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
include_once("engine/bo/RedmineBo.php");

$redmineBo = RedmineBo::newInstance($connection, $config["redmine"]["db"]);

if ($isConnected) {
	if (isset($_SESSION["redmineUser"])) {
		$redmineUser = json_decode($_SESSION["redmineUser"], true);

		$userTasks = $redmineBo->getTasks(array("no_closed" => true, "assigned_to_id" => $redmineUser["redmine_user_id"], "status" => 1));
		$notAssignedTasks = $redmineBo->getTasks(array("no_closed" => true, "not_assigned" => true, "status" => 1, "member_user_id" => $redmineUser["redmine_user_id"]));
	}
}

if (! isset($notAssignedTasks)) {
	$notAssignedTasks = $redmineBo->getTasks(array("no_closed" => true, "not_assigned" => true, "status" => 1));
}

if ($isConnected) {?>

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

<?php 	
} 
else {
?>

	<div class="well well-sm text-info">
		<?php echo lang("task_if_you_please"); ?>	
	</div>

<?php 

	$tileClass= "col-md-12";
	$tileTasks = $notAssignedTasks; 
	$tileTitle = lang("task_not_assigned_list");
	
	include("tasks_tile.php");
?>

<?php 	
}?>