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
 
	if (isset($tileTasks) && count($tileTasks)) {
?>
<div class="<?php echo $tileClass; ?>">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo $tileTitle?></div>
		<ul class="list-group" style="max-height: 202px; overflow-y: scroll;">
<?php 	foreach($tileTasks as $task) {?>
			<li class="list-group-item">
			
<?php 
			switch($task["tracker_id"]) {
				case "1": // issue
					echo "<i class='fa fa-exclamation-circle' aria-hidden='true' title='".lang("task_issue")."' data-toggle='tooltip' data-placement='right'></i>";
					break;
				case "2": // upgrade
					echo "<i class='fa fa-arrow-circle-o-up' aria-hidden='true' title='".lang("task_upgrade")."' data-toggle='tooltip' data-placement='right'></i>";
					break;
				case "4": // document
					echo "<i class='fa fa-file-text-o' aria-hidden='true' title='".lang("task_documentation")."' data-toggle='tooltip' data-placement='right'></i>";
					break;
				case "3": // task
				default:
					echo "<i class='fa fa-gear' aria-hidden='true' title='".lang("task_task")."' data-toggle='tooltip' data-placement='right'></i>";
					break;
			}
?>			
				<a href="https://redmine.partipirate.org/issues/<?php echo $task["issue_id"]; ?>"><?php echo utf8_encode($task["subject"]); ?></a>
				pour
				<a href="https://redmine.partipirate.org/projects/<?php echo $task["identifier"]; ?>"><?php echo utf8_encode($task["name"]); ?></a>
				<?php //print_r($task); ?>
			</li>
<?php 	}?>
		</ul>
	</div>
</div>

<?php 		
	}
?>