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

if ($isConnected) {
?>

	<div class="text-center" style="margin:0;">
	
		<a href="do_start_sso.php?application=galette" 
			title="<?php echo lang("sso_galette"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-success col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Galette</a>
		<a href="do_start_sso.php?application=congressus" 
			title="<?php echo lang("sso_congressus"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-success col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Congressus</a>
		<a href="do_start_sso.php?application=personae" 
			title="<?php echo lang("sso_personae"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-success col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Personae</a>
		<a href="https://redmine.partipirate.org/" data-href="do_start_sso.php?application=redmine" 
			title="<?php echo lang("sso_redmine"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Redmine</a>
	
	</div>
<br>
	<div class="text-center" style="margin:0;">
	
		<a href="https://wiki.partipirate.org/" data-href="do_start_sso.php?application=wiki" 
			title="<?php echo lang("sso_wiki"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Wiki</a>
		<a href="https://forum.partipirate.org/" data-href="do_start_sso.php?application=forum" 
			title="<?php echo lang("sso_forum"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Forum</a>
		<a href="https://lists.partipirate.org/" data-href="do_start_sso.php?application=ml" 
			title="<?php echo lang("sso_ml"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height:110px; padding: 45px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">ML</a>
	
	</div>
<br>
	<div class="text-center" style="margin:0;">
		<button class="btn btn-success btn-xs">Applications accessibles directement sans réidentification</button>
		<button class="btn btn-warning  btn-xs">Application où vous devez vous réidentifier</button>
	</div>
<br>


<?php
}
?>