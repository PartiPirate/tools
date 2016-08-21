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

$redmineBo = RedmineBo::newInstance($connection, $config["redmine"]["db"]);

if ($isConnected) {
	$galetteBo = GaletteBo::newInstance($connection, $config["galette"]["db"]);
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
			target="_blank" class="btn btn-default col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Galette</a>
		<a href="do_start_sso.php?application=congressus" 
			title="<?php echo lang("sso_congressus"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Congressus</a>
		<a href="do_start_sso.php?application=personae" 
			title="<?php echo lang("sso_personae"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Personae</a>
		<a href="do_start_sso.php?application=redmine" 
			title="<?php echo lang("sso_redmine"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-2 disabled" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Redmine</a>
	
	</div>
<br>
	<div class="row text-center" style="margin:0;">
	
		<a href="do_start_sso.php?application=wiki" 
			title="<?php echo lang("sso_wiki"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-2 disabled" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Wiki</a>
		<a href="do_start_sso.php?application=forum" 
			title="<?php echo lang("sso_forum"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-2 disabled" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Forum</a>
		<a href="do_start_sso.php?application=ml" 
			title="<?php echo lang("sso_ml"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-2 disabled" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">ML</a>
	
	</div>

	<br>
<?php 

	$tileClass= "col-md-12";
	if (isset($userTasks) && count($userTasks) && count($notAssignedTasks)) {
		$tileClass= "col-md-6";
	}

	$tileTasks = $userTasks; 
	$tileTitle = lang("task_assigned_list");
	
	include("tasks_tile.php");
	
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