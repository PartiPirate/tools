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
require_once("engine/utils/DateTimeUtils.php");
require_once("engine/utils/FormUtils.php");

// We sanitize the request fields
xssCleanArray($_REQUEST);

$connection = openConnection();

$application = $_POST["application"];
$secret = $_POST["secret"];
$userId = $_POST["userId"];

$query = "	SELECT *
			FROM sso.tokens
			WHERE
				tok_user_id = :tok_user_id
			AND tok_secret = :tok_secret
			AND tok_application = :tok_application
			AND tok_validity_date > NOW()
			AND tok_used_date IS NULL \n";


$userId = $_REQUEST["userId"];

$args = array(	"tok_user_id" => $userId,
				"tok_application" => $application,
				"tok_secret" => $secret);

$statement = $connection->prepare($query);
$statement->execute($args);
$results = $statement->fetchAll();

if (!count($results)) {
	echo json_encode(array("ko" => "ko"));
	exit();
}

$updateSsoQuery = "	UPDATE sso.tokens SET tok_used_date = NOW() WHERE tok_id = :tok_id";
$updateSsoArgs = array("tok_id" => $results[0]["tok_id"]);

$statement = $connection->prepare($updateSsoQuery);
$statement->execute($updateSsoArgs);

echo json_encode(array("ok" => "ok"));
exit();

?>