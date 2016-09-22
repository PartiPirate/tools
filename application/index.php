<?php /*
	Copyright 2016 Cédric Levieux, Parti Pirate

	This file is part of Fabrilia.

    Fabrilia is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Fabrilia is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Fabrilia.  If not, see <http://www.gnu.org/licenses/>.
*/
include_once("header.php");

include_once("engine/bo/GaletteBo.php");
include_once("engine/bo/RedmineBo.php");
include_once("engine/bo/SkillBo.php");
include_once("engine/bo/SkillUserBo.php");
include_once("engine/bo/SkillEndorsmentBo.php");

$redmineBo = RedmineBo::newInstance($connection, $config["redmine"]["db"]);

if ($isConnected) {
	$galetteBo = GaletteBo::newInstance($connection, $config["galette"]["db"]);

	$skillBo = SkillBo::newInstance($connection, $config);
	$skillUserBo = SkillUserBo::newInstance($connection, $config);
	$skillEndorsmentBo = SkillEndorsmentBo::newInstance($connection, $config);

	$skills = $skillBo->getByFilters(array());
	$userSkills = $skillUserBo->getByFilters(array("sus_user_id" => $sessionUserId, "with_label" => true));
	
	$member = $galetteBo->getMemberById($sessionUserId);
	
	$expirationDate = new DateTime($member["date_echeance"]);
	$now = new DateTime();
	
	$diff = $expirationDate->diff($now);

	$expirationClass = "text-success";
	
	if ($diff->days < 8) {
		$expirationClass = "text-danger";
	}
	else if ($diff->days < 15) {
		$expirationClass = "text-warning";
	}
	
	if (isset($_SESSION["redmineUser"])) {
		$redmineUser = json_decode($_SESSION["redmineUser"], true);
		
		$userTasks = $redmineBo->getTasks(array("no_closed" => true, "assigned_to_id" => $redmineUser["redmine_user_id"], "status" => 1));
		$notAssignedTasks = $redmineBo->getTasks(array("no_closed" => true, "not_assigned" => true, "status" => 1, "member_user_id" => $redmineUser["redmine_user_id"]));
	}
}

if (! isset($notAssignedTasks)) {
	$notAssignedTasks = $redmineBo->getTasks(array("no_closed" => true, "not_assigned" => true, "status" => 1));
}

?>

<?php 	if ($isConnected) {?>
<div id="skills">
	<div id="panel-skills" class="panel panel-default pull-left">
		<div class="panel-heading">
			<h3 class="panel-title">Vos compétences</h3>
		</div>
		<div class="panel-body">
	<?php 	if (!count($userSkills)) {
				echo "Pas de compétence, peut-être voudriez vous en ajouter ?";
			}
			else {
				foreach($userSkills as $userSkill) {
	?>
	<div class="row">
		<div class="col-md-6"><?php echo $userSkill["ski_label"]; ?></div>
		<div class="col-md-3"><?php echo lang("skill_level_" . $userSkill["sus_level"]); ?></div>
		<div class="col-md-3 text-right">
			<button class="btn btn-primary btn-xxs btn-modify-skill" 
				data-id="<?php echo $userSkill["sus_id"]; ?>" 
				data-skill-level="<?php echo $userSkill["sus_level"]; ?>"
				data-skill-label="<?php echo $userSkill["ski_label"]; ?>"
				data-skill-id="<?php echo $userSkill["sus_skill_id"]; ?>"><span class="glyphicon glyphicon-cog"></span></button>
			<button class="btn btn-danger btn-xxs btn-delete-skill" 
				data-id="<?php echo $userSkill["sus_id"]; ?>" 
				data-skill-label="<?php echo $userSkill["ski_label"]; ?>"><span class="glyphicon glyphicon-minus"></span></button>
		</div>
	</div>
	<?php 				
				}
			}?>
		</div>
		<div class="panel-footer text-right">
			<button class="btn btn-default btn-xs btn-add-skill"><span class="glyphicon glyphicon-plus"></span> Ajouter</button>
		</div>
	</div>
	
	<div id="dialog-delete-skill" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Supprimer la compétence "<span class="skill-label"></span>"</h4>
				</div>
				<div class="modal-body">
					Supprimer cette compétence de votre liste ?
					<form>
						<input type="hidden" name="sus_id">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					<button type="button" class="btn btn-ok btn-danger">Supprimer</button>
				</div>
			</div>
		</div>
	</div>
	
	<div id="dialog-add-skill" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Ajouter une compétence</h4>
				</div>
				<div class="modal-body">
	
					<form class="form-horizontal">
						<fieldset>
	
							<legend>Votre compétence</legend>
	
							<div class="form-group">
								<label class="col-md-4 control-label" for="add_sus_skill_id">Votre compétence</label>
								<div class="col-md-8">
									<select id="add_sus_skill_id" name="sus_skill_id" class="form-control">
										<option value="0">Je ne trouve pas dans la liste</option>
										<?php 	foreach($skills as $skill) {?>
										<option value="<?php echo $skill["ski_id"]; ?>"><?php echo $skill["ski_label"]; ?></option>
										<?php 	}?>
									</select>
								</div>
							</div>
	
							<div class="form-group new-skill">
								<label class="col-md-4 control-label" for="add_sus_label">Nouvelle compétence</label>
								<div class="col-md-8">
									<input id="add_sus_label" name="sus_label" type="text"
										placeholder="Le nom de la nouvelle compétence" class="form-control input-md">
								</div>
							</div>
	
							<div class="form-group">
								<label class="col-md-4 control-label" for="add_sus_level">Votre niveau</label>
								<div class="col-md-4">
									<select id="add_sus_level" name=sus_level class="form-control">
										<option value="concepts">Notions</option>
										<option value="average">Niveau moyen</option>
										<option value="good">Bon niveau</option>
										<option value="advanced">Avancé</option>
										<option value="expert">Expert</option>
									</select>
								</div>
							</div>
	
						</fieldset>
					</form>
	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					<button type="button" class="btn btn-ok btn-success">Ajouter</button>
				</div>
			</div>
		</div>
	</div>
	
	<div id="dialog-mod-skill" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Modifier votre compétence "<span class="skill-label"></span>"</h4>
				</div>
				<div class="modal-body">
	
					<form class="form-horizontal">
						<input type="hidden" name="sus_id">
						<fieldset>
	
							<legend>Votre compétence</legend>
	
							<div class="form-group">
								<label class="col-md-4 control-label" for="mod_sus_skill_id">Votre compétence</label>
								<div class="col-md-8">
									<select id="mod_sus_skill_id" name="sus_skill_id" class="form-control">
										<option value="0">Je ne trouve pas dans la liste</option>
										<?php 	foreach($skills as $skill) {?>
										<option value="<?php echo $skill["ski_id"]; ?>"><?php echo $skill["ski_label"]; ?></option>
										<?php 	}?>
									</select>
								</div>
							</div>
	
							<div class="form-group new-skill">
								<label class="col-md-4 control-label" for="mod_sus_label">Nouvelle compétence</label>
								<div class="col-md-8">
									<input id="mod_sus_label" name="sus_label" type="text"
										placeholder="Le nom de la nouvelle compétence" class="form-control input-md">
								</div>
							</div>
	
							<div class="form-group">
								<label class="col-md-4 control-label" for="mod_sus_level">Votre niveau</label>
								<div class="col-md-4">
									<select id="mod_sus_level" name=sus_level class="form-control">
										<option value="concepts">Notions</option>
										<option value="average">Niveau moyen</option>
										<option value="good">Bon niveau</option>
										<option value="advanced">Avancé</option>
										<option value="expert">Expert</option>
									</select>
								</div>
							</div>
	
						</fieldset>
					</form>
	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					<button type="button" class="btn btn-ok btn-primary">Modifier</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 	}?>

<div class="container theme-showcase" role="main" id="main" tabindex="-1">
	<ol class="breadcrumb">
		<li class="active"><?php echo lang("breadcrumb_index"); ?></li>
	</ol>

	<div class="well well-sm">
		<?php echo lang("index_guide"); ?>
	</div>

	<br />

<?php 	if ($isConnected) {?>

	<div class="well well-sm <?php echo $expirationClass; ?>">
		<?php 
			$message = lang("index_membership");
			$message = str_replace("{days}", $diff->days, $message);
			$message = str_replace("{date}", $expirationDate->format(lang("date_format")), $message);

			echo $message;
		?>
	</div>

	<div class="row text-center" style="margin:0;">
	
		<a href="do_start_sso.php?application=galette" 
			title="<?php echo lang("sso_galette"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-success col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Galette</a>
		<a href="do_start_sso.php?application=congressus" 
			title="<?php echo lang("sso_congressus"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-success col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Congressus</a>
		<a href="do_start_sso.php?application=personae" 
			title="<?php echo lang("sso_personae"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-success col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Personae</a>
		<a href="https://redmine.partipirate.org/" data-href="do_start_sso.php?application=redmine" 
			title="<?php echo lang("sso_redmine"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Redmine</a>
	
	</div>
<br>
	<div class="row text-center" style="margin:0;">
	
		<a href="https://wiki.partipirate.org/" data-href="do_start_sso.php?application=wiki" 
			title="<?php echo lang("sso_wiki"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Wiki</a>
		<a href="https://forum.partipirate.org/" data-href="do_start_sso.php?application=forum" 
			title="<?php echo lang("sso_forum"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Forum</a>
		<a href="https://lists.partipirate.org/" data-href="do_start_sso.php?application=ml" 
			title="<?php echo lang("sso_ml"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">ML</a>
	
	</div>
<br>
	<div class="row text-center" style="margin:0;">
		<button class="btn btn-success btn-xs">SSO OK</button>
		<button class="btn btn-warning  btn-xs">SSO KO</button>
	</div>
<br>

<?php 

	$tileClass= "col-md-12";
	if (isset($userTasks) && count($userTasks) && count($notAssignedTasks)) {
		$tileClass= "col-md-6";
	}

	if (isset($userTasks)) {
		$tileTasks = $userTasks; 
		$tileTitle = lang("task_assigned_list");
		include("tasks_tile.php");
	}
	
	$tileTasks = $notAssignedTasks; 
	$tileTitle = lang("task_not_assigned_list");
	
	include("tasks_tile.php");
?>

<?php 	
	if (isset($_SESSION["redmineUser"])) {
		$redmineUser = json_decode($_SESSION["redmineUser"], true);
		$redmineUserPassword = $redmineUser["hashed_password"];
		
		$computePassword = $_SESSION["redminePassword"];
		
		if ($computePassword != $redmineUserPassword) {?>
	<br>
	<div class="row text-info div-upgrade-redmine-password" style="margin:0;">
		<?php echo lang("index_redmine_not_same_password"); ?>
		<a href="do_upgrade_redmine_password.php" class="btn btn-success btn-xs btn-upgrade-redmine-password"><?php echo lang("common_yes"); ?></a>
	</div>		
<?php 		
		}
	}
	else {?>
	<br>
	<div class="row text-warning" style="margin:0;">
		<?php echo lang("index_redmine_no_account"); ?>
	</div>		
<?php 		
	}
?>

<?php 	} else {?>

	<div class="well well-sm text-info">
		<?php echo lang("task_if_you_please"); ?>	
	</div>

<?php 

	$tileClass= "col-md-12";
	$tileTasks = $notAssignedTasks; 
	$tileTitle = lang("task_not_assigned_list");
	
	include("tasks_tile.php");
?>

<?php 	}?>

<?php include("connect_button.php"); ?>

</div>

<div class="lastDiv"></div>

<?php include("footer.php");?>

</body>
</html>