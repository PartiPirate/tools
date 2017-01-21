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

if ($isConnected) {
	$galetteBo = GaletteBo::newInstance($connection, $config["galette"]["db"]);
	$member = $galetteBo->getMemberById($sessionUserId);
	
	$member["pseudo_adh"] = utf8_encode($member["pseudo_adh"]);
	$member["nom_adh"] = utf8_encode($member["nom_adh"]);
	$member["prenom_adh"] = utf8_encode($member["prenom_adh"]);
	$member["adresse_adh"] = utf8_encode($member["adresse_adh"]);
	$member["adresse2_adh"] = utf8_encode($member["adresse2_adh"]);
	$member["cp_adh"] = utf8_encode($member["cp_adh"]);
	$member["ville_adh"] = utf8_encode($member["ville_adh"]);
	$member["pays_adh"] = utf8_encode($member["pays_adh"]);
	
	unset($member["id_adh"]);
	unset($member["id_statut"]);
	unset($member["societe_adh"]);
	unset($member["titre_adh"]);
	unset($member["sexe_adh"]);
	unset($member["ddn_adh"]);
	unset($member["url_adh"]);
	unset($member["icq_adh"]);
	unset($member["msn_adh"]);
	unset($member["jabber_adh"]);
	unset($member["info_adh"]);
	unset($member["info_public_adh"]);
	unset($member["prof_adh"]);
	unset($member["login_adh"]);
	unset($member["mdp_adh"]);
	unset($member["date_crea_adh"]);
	unset($member["date_modif_adh"]);
	unset($member["activite_adh"]);
	unset($member["bool_admin_adh"]);
	unset($member["bool_exempt_adh"]);
	unset($member["bool_display_info"]);
	unset($member["date_echeance"]);
	unset($member["pref_lang"]);
	unset($member["lieu_naissance"]);
	unset($member["gpgid"]);
	unset($member["fingerprint"]);
	unset($member["parent_id"]);
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

	<form action="https://adhesion.partipirate.org/index.php" method="post">
		<input type="hidden" value="" id="join-member-input" name="join-member-input"/>
		<button id="join-submit-button" class="btn btn-default btn-lg btn-block" type="submit">Réadhérer</button>
	</form>

<?php 	} else {?>


<?php 	}?>

<?php include("connect_button.php"); ?>

</div>

<div class="lastDiv"></div>

<script type="text/javascript">

$(function() {
	var member = <?php echo json_encode($member); ?>;
	$("#join-member-input").val(JSON.stringify(member));
	$("#join-submit-button").click();
});

</script>

<?php include("footer.php");?>

</body>
</html>