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
require_once("engine/utils/SessionUtils.php");
require_once("engine/utils/DateTimeUtils.php");
require_once("engine/utils/FormUtils.php");

session_start();

$user = SessionUtils::getUser($_SESSION);
if (!$user) exit();

// We sanitize the request fields
xssCleanArray($_REQUEST);

$connection = openConnection();

$application = $_REQUEST["application"];

$query = "	INSERT INTO sso.tokens
				(tok_user_id, tok_creation_date, tok_validity_date, tok_used_date, tok_secret, tok_application)
			VALUES
				(:tok_user_id, :tok_creation_date, :tok_validity_date, NULL, :tok_secret, :tok_application)";

// Compute secret
$secret = uniqid('', true);

$now = getNow();
// print_r($now);
// print_r($now);
// print_r($validity);

$args = array();
$args["tok_user_id"] = $user["id_adh"];
$args["tok_secret"] = $secret;
$args["tok_application"] = $application;
$args["tok_creation_date"] = $now->format("Y-m-d H:i:s");

$validity = $now->add(new DateInterval('PT10S'));
$args["tok_validity_date"] = $validity->format("Y-m-d H:i:s");

// echo showQuery($query, $args);
// exit();

$statement = $connection->prepare($query);
$statement->execute($args);

$ssoUrl = "index.php";

$urls = array();
$urls["personae"] = "https://personae.partipirate.org/do_sso.php?secret={secret}&userId={userId}";
$urls["congressus"] = "https://congressus.partipirate.org/do_sso.php?secret={secret}&userId={userId}";
$urls["galette"] = "https://gestion.partipirate.org/index.php?sso=1&secret={secret}&userId={userId}";

if (isset($urls[$application])) {
	$ssoUrl = $urls[$application];
	$ssoUrl = str_replace("{secret}", $secret, $ssoUrl);
	$ssoUrl = str_replace("{userId}", $user["id_adh"], $ssoUrl);
}

header("Location: $ssoUrl");
?>