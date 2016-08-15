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
	
	$expirationDate = new DateTime($member["date_echeance"]);
	$now = new DateTime();
	
	$diff = $expirationDate->diff($now);

	$expirationClass = "text-success";
	
	if ($diff->days < 8) {
		$expirationClass = "text-danger";
	}
	else if ($diff->days < 15) {
		$expirationClass = "text-warning";
	}
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

	<div class="well well-sm <?php echo $expirationClass; ?>">
		<?php 
			$message = lang("index_membership");
			$message = str_replace("{days}", $diff->days, $message);
			$message = str_replace("{date}", $expirationDate->format(lang("date_format")), $message);

			echo $message;
		?>
	</div>

	<div class="row">
	
		<a href="do_start_sso.php?application=galette" 
			title="<?php echo lang("sso_galette"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-3" style="height:150px; padding: 65px 0 0 0;">Galette</a>
		<a href="do_start_sso.php?application=congressus" 
			title="<?php echo lang("sso_congressus"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-3" style="height:150px; padding: 65px 0 0 0;">Congressus</a>
		<a href="do_start_sso.php?application=personae" 
			title="<?php echo lang("sso_personae"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-3" style="height:150px; padding: 65px 0 0 0;">Personae</a>
		<a href="do_start_sso.php?application=redmine" 
			title="<?php echo lang("sso_redmine"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-3" style="height:150px; padding: 65px 0 0 0;">Redmine</a>
	
	</div>

	<div class="row">
	
		<a href="do_start_sso.php?application=wiki" 
			title="<?php echo lang("sso_wiki"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-3" style="height:150px; padding: 65px 0 0 0;">Wiki</a>
		<a href="do_start_sso.php?application=forum" 
			title="<?php echo lang("sso_forum"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-3" style="height:150px; padding: 65px 0 0 0;">Forum</a>
		<a href="do_start_sso.php?application=ml" 
			title="<?php echo lang("sso_ml"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-default col-md-3" style="height:150px; padding: 65px 0 0 0;">ML</a>
	
	</div>



<?php 	} else {?>


<?php 	}?>

<?php include("connect_button.php"); ?>

</div>

<div class="lastDiv"></div>

<?php include("footer.php");?>

</body>
</html>