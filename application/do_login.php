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
require_once("engine/bo/GaletteBo.php");
require_once("engine/bo/RedmineBo.php");
require_once("engine/authenticators/GaletteAuthenticator.php");
require_once("engine/discourse/DiscourseAPI.php");

session_start();

// We sanitize the request fields
xssCleanArray($_REQUEST);

$connection = openConnection();
$galetteAuthenticator = GaletteAuthenticator::newInstance($connection, $config["galette"]["db"]);

$redmineBo = RedmineBo::newInstance($connection, $config["redmine"]["db"]);

$discourseApi = new richp10\discourseAPI\DiscourseAPI("127.0.0.1:480", $config["discourse"]["api_key"], "http");

$login = $_REQUEST["login"];
$password = $_REQUEST["password"];
//$ajax = isset("")

$data = array();

if ($login == $config["administrator"]["login"] && $password == $config["administrator"]["password"]) {
	$_SESSION["administrator"] = true;
	$data["ok"] = "ok";

	addLog($_SERVER, $_SESSION, null, array("result" => "administrator"));
	
	header('Location: administration.php');
	exit();
}

$member = $galetteAuthenticator->authenticate($login, $password);
if ($member) {
	$data["ok"] = "ok";
	$connectedMember = array();
	$connectedMember["pseudo_adh"] = GaletteBo::showIdentity($member);
	$connectedMember["id_adh"] = $member["id_adh"];

	$_SESSION["member"] = json_encode($connectedMember);
	$_SESSION["memberId"] = $member["id_adh"];
	addLog($_SERVER, $_SESSION, null, array("result" => "ok"));
	
	$redmineUser = $redmineBo->getUser($member);
	if ($redmineUser) {
		$_SESSION["redminePassword"] = $redmineBo->computePassword($password, $redmineUser);
		
		$redmineUser["firstname"] = utf8_encode($redmineUser["firstname"]);
		$redmineUser["lastname"] = utf8_encode($redmineUser["lastname"]);

//		print_r($redmineUser);
		
		$_SESSION["redmineUser"] = json_encode($redmineUser);
	}

	$result = $discourseApi->getUserByEmail($member["email_adh"]);
	if (!$result) {
		$result = $discourseApi->createUser($member["nom_adh"] . " " . $member["prenom_adh"], $member["pseudo_adh"], $member["email_adh"], $password, true);
	}
	
//		exit();
}
else {
	$data["ko"] = "ko";
	$data["message"] = "error_login_bad";
	addLog($_SERVER, $_SESSION, null, array("result" => "ko"));
}

session_write_close();

/*
$referer = $_SERVER["HTTP_REFERER"];

if ($referer) {
	header("Location: $referer");
}
else {
	header("Location: index.php");
}
*/

if (isset($data["ok"]) && $_POST["referer"]) {
	header('Location: ' . $_POST["referer"]);
}
else if (!isset($data["ok"]) && $_POST["referer"]) {
	header('Location: connect.php?error=' . $data["message"] . "&referer=" . urlencode($_POST["referer"]));
}
else {
	echo json_encode($data);
}
?>