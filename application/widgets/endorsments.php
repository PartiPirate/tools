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

include_once("engine/bo/GaletteBo.php");
include_once("engine/bo/SkillBo.php");
include_once("engine/bo/SkillUserBo.php");
include_once("engine/bo/SkillEndorsmentBo.php");

if ($isConnected) {
	$skillEndorsmentBo = SkillEndorsmentBo::newInstance($connection, $config);
	
	$randomUserSkill = $skillEndorsmentBo->getRandomSkillUser($sessionUserId);

?>
<div id="endorsments">
	<?php 	if ($randomUserSkill) { ?>

	<div id="panel-endorsments" class="panel panel-default pull-right">
		<div class="panel-heading">
			<h3 class="panel-title">Une approbation ?</h3>
		</div>
		<div class="panel-body">
			<span 
				class="data"
				data-id="<?php echo $randomUserSkill["sus_id"]?>" 
				data-skill-label="<?php echo $randomUserSkill["ski_label"]?>" 
				data-identity="<?php echo GaletteBo::showIdentity($randomUserSkill); ?>">
			<?php 
				$message = lang("skill_endorsment_need_approval");
				
				$message = str_replace("{id}", $randomUserSkill["id_adh"], $message);
				$message = str_replace("{identity}", GaletteBo::showIdentity($randomUserSkill), $message);
				$message = str_replace("{level}", lang("skill_endorsment_level_" . $randomUserSkill["sus_level"]), $message);
				$message = str_replace("{skill}", $randomUserSkill["ski_label"], $message);
				
				echo $message;
			?>
			</span>
		</div>
		<div class="panel-footer text-right">
			<button class="btn btn-default btn-xs btn-endorse-skill"><span class="glyphicon glyphicon-thumbs-up"></span> Approuver</button>
			<button class="btn btn-default btn-xs btn-refresh-skill"
				title="Rafraîchir" data-toggle="tooltip" data-placement="bottom"
			><span class="glyphicon glyphicon-refresh"></span></button>
		</div>
	</div>
	
<?php 		}?>

	<div id="dialog-endorse-skill" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Approuver la compétence de <span class="skill-user-identity"></span></h4>
				</div>
				<div class="modal-body">
					Approuver la compétence de <span class="skill-user-identity"></span> : <span class="skill-label"></span>
					<form>
						<input type="hidden" name="sus_id">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
					<button type="button" class="btn btn-ok btn-success">Approuver</button>
				</div>
			</div>
		</div>
	</div>

</div>

<?php 	}?>
