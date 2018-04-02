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

if ($isConnected) {
	$galetteBo = GaletteBo::newInstance($connection, $config["galette"]["db"]);

	$member = $galetteBo->getMemberById($sessionUserId);

	$expirationDate = new DateTime($member["date_echeance"]);
	$now = new DateTime();

//	$diff = $expirationDate->diff($now);
	$diff = $now->diff($expirationDate);


	$expirationClass = "text-success";
		$message = lang("index_membership");

	if ($diff->format("%R") == "-") {
		$expirationClass = "text-danger";
		$message = lang("index_membership_nomore");
	}
	else if ($diff->days < 8) {
		$expirationClass = "text-danger";
	}
	else if ($diff->days < 15) {
		$expirationClass = "text-warning";
	}

?>

	<div class="well well-sm <?php echo $expirationClass; ?>">
		<?php 
			$message = str_replace("{days}", $diff->days, $message);
			$message = str_replace("{date}", $expirationDate->format(lang("date_format")), $message);

			echo $message;
		?>
	</div>

<?php	
}
?>