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

include_once("engine/bo/SkillBo.php");
include_once("engine/bo/SkillUserBo.php");
include_once("engine/bo/SkillEndorsmentBo.php");

if ($isConnected) {
	$skillBo = SkillBo::newInstance($connection, $config);
	$skillUserBo = SkillUserBo::newInstance($connection, $config);
	
	$skills = $skillBo->getByFilters(array());
	$userSkills = $skillUserBo->getByFilters(array("sus_user_id" => $sessionUserId, "with_label" => true, "with_endorsments" => true));

?>
<div id="skills">
	<div id="panel-skills" class="panel panel-default pull-left" style="z-index: 1000;">
		<div class="panel-heading">
			<h3 class="panel-title">Vos compétences</h3>
		</div>
		<div class="panel-body row-striped row-hover" style="padding: 0 15px;">
	<?php 	if (!count($userSkills)) {
				echo "Pas de compétence, peut-être voudriez vous en ajouter ?";
			}
			else {
				foreach($userSkills as $userSkill) {
	?>
	<div class="row">
		<div class="col-md-6"><?php echo $userSkill["ski_label"]; ?> <?php
			if ($userSkill["sus_total_endorsments"]) {
				echo "(";
				echo $userSkill["sus_total_endorsments"]; 
				echo ")";
			}
		?></div>
		<div class="col-md-3"><?php echo lang("skill_level_" . $userSkill["sus_level"]); ?></div>
		<div class="col-md-3 text-right">
			<button class="btn btn-primary btn-xxs btn-modify-skill" 
				title="Modifier cette compétence" data-toggle="tooltip" data-placement="bottom"
				data-id="<?php echo $userSkill["sus_id"]; ?>" 
				data-skill-level="<?php echo $userSkill["sus_level"]; ?>"
				data-skill-label="<?php echo $userSkill["ski_label"]; ?>"
				data-skill-id="<?php echo $userSkill["sus_skill_id"]; ?>"><span class="glyphicon glyphicon-cog"></span></button>
			<button class="btn btn-danger btn-xxs btn-delete-skill"
				title="Supprimer cette compétence" data-toggle="tooltip" data-placement="bottom" 
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
					<h4 class="modal-title">Supprimer la compétence &laquo;<span class="skill-label"></span>&raquo;</h4>
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
					<h4 class="modal-title">Modifier votre compétence &laquo;<span class="skill-label"></span>&raquo;</h4>
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
