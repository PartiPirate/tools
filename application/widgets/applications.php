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

<div id="applications" class="text-center" style="margin:0;">
	<div>	
		<a href="do_start_sso.php?application=galette" 
			title="<?php echo lang("sso_galette"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-success col-md-2" style="height: 70px; padding: 25px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Galette</a>
		<a href="do_start_sso.php?application=congressus" 
			title="<?php echo lang("sso_congressus"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-success col-md-2" style="height: 70px; padding: 25px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Congressus</a>
		<a href="do_start_sso.php?application=personae" 
			title="<?php echo lang("sso_personae"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-success col-md-2" style="height: 70px; padding: 25px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Personae</a>
	</div>
<br>
	<div>	
		<a href="https://redmine.partipirate.org/" data-href="do_start_sso.php?application=redmine" 
			title="<?php echo lang("sso_redmine"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height: 70px; padding: 25px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Redmine</a>
		<a href="https://wiki.partipirate.org/" data-href="do_start_sso.php?application=wiki" 
			title="<?php echo lang("sso_wiki"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height: 70px; padding: 25px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Wiki</a>
		<a href="https://discourse.partipirate.org/" data-href="do_start_sso.php?application=discourse" 
			title="<?php echo lang("sso_discourse"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-warning col-md-2" style="height: 70px; padding: 25px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Discourse (Forum + ML)</a>
	</div>
<br>
	<div>	
		<a href="mumble://<?php echo $sessionUser["pseudo_adh"]; ?>@mumble.partipirate.org/?version=1.2.0" title="<?php echo lang("sso_mumble"); ?>" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-success col-md-2" style="height: 70px; padding: 25px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Mumble</a>
		<a href="https://framapad.org/" title="Framapad" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-external col-md-2" style="height: 70px; padding: 25px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">Framapad</a>
		<a href="https://www.opentweetbar.net/" title="OpenTweetBar" data-toggle="tooltip" data-placement="bottom"
			target="_blank" class="btn btn-external col-md-2" style="height: 70px; padding: 25px 0 0 0; margin-left: 10px; margin-right: 10px; float: none;">OpenTweetBar</a>
	</div>
<br>
	<div>	
		<button class="btn btn-success btn-xs" style="margin: 5px">Applications accessibles directement sans réidentification</button>
		<button class="btn btn-warning btn-xs" style="margin: 5px;">Application où vous devez vous réidentifier</button><br />
		<button class="btn btn-external btn-xs" style="margin: 5px;">Application externes utilisées par les Pirates</button>
	</div>
<br>
</div>

<?php
}
?>
