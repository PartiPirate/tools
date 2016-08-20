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
include_once("config/database.php");
require_once("engine/utils/FormUtils.php");
require_once("engine/utils/LogUtils.php");
require_once("engine/bo/RedmineBo.php");

session_start();

// We sanitize the request fields
xssCleanArray($_REQUEST);

$connection = openConnection();

$redmineBo = RedmineBo::newInstance($connection, $config["redmine"]["db"]);

if (isset($_SESSION["redminePassword"])) {
	$redminePassword = $_SESSION["redminePassword"];
	$redmineUser = json_decode($_SESSION["redmineUser"], true);
	
	$redmineBo->updatePassword($redmineUser["redmine_user_id"], $redminePassword);
}

$data = array();

$data["ok"] = "ok";
echo json_encode($data);

?>