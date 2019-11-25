<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('onkyo');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>
<div class="row row-overflow">
	<div class="col-lg-2 col-md-3 col-sm-4">
		<div class="bs-sidebar">
			<ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
				<a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un équipement}}</a>
				<li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
				<?php
				foreach ($eqLogics as $eqLogic) {
					$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
					echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
				}
				?>
			</ul>
		</div>
	</div>
	
	<div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
		<legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
				<center>
					<i class="fa fa-plus-circle" style="font-size : 7em;color:#3F23A4;"></i>
				</center>
				<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>Ajouter</center></span>
			</div>
			<div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
				<center>
					<i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i>
				</center>
				<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Configuration}}</center></span>
			</div>
		</div>

		<legend><i class="icon nature-planet5"></i> {{Mes amplificateurs Onkyo}}</legend>
		<div class="eqLogicThumbnailContainer">
			<?php
			foreach ($eqLogics as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
				echo '			<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
				echo "				<center>";
				echo '					<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
				echo "				</center>";
				echo '				<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
				echo '			</div>';
			}
			?>
		</div>
	</div>
	<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
		<a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
		<a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
		</ul>
		<?php
		if (count($eqLogics) > 0) {
		?>
		<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">
				<form class="form-horizontal">
					<fieldset>
						<legend>
							<i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}
							<i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i>
						</legend>
						<div class="form-group">
							<label class="col-sm-2 control-label">{{Nom de l'amplificateur Onkyo}}</label>
							<div class="col-sm-3">
								<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
								<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'amplificateur Onkyo}}"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >{{Objet parent}}</label>
							<div class="col-sm-3">
								<select class="form-control eqLogicAttr" data-l1key="object_id">
									<option value="">{{Aucun}}</option>
									<?php
									foreach (jeeObject::all() as $object) {
										echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group expertModeVisible">
							<label class="col-sm-2 control-label">{{Adresse IP de l'amplificateur}}</label>
							<div class="col-sm-2">
								<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="onkyo_ip" placeholder="{{Adresse IP de l'amplificateur}}"/>
							</div>
						</div>
						<div class="form-group expertModeVisible">
							<label class="col-sm-2 control-label">{{Port d'écoute de l'amplificateur}}</label>
							<div class="col-sm-2">
								<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="onkyo_port" placeholder="60128"/>
							</div>
							<span>{{valeur par défaut "60128", à ne modifier qu'en cas de nécessité}}</span>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
								<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
							</div>
						</div>
						<!--<div class="form-group">
							<label class="col-sm-2 control-label">{{Démon}}</label>
							<div class="col-sm-3">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>{{Statut}}</th>
											<th>{{Configuration}}</th>
											<th>{{(Re)Démarrer}}</th>
											<th>{{Arrêter}}</th>
											<th>{{Dernier lancement}}</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="deamonState" data-slave_id="0">
												<?php
												$node = json_decode(onkyo::callbackCmd('{"action":"getNode","id":'.$eqLogic->getId().'}', false));
												if (count($node) > 0) {
													echo '<span class="label label-success" style="font-size:1em;">{{OK}}</span>';
												}
												else {
													echo '<span class="label label-danger" style="font-size:1em;">{{NOK}}</span>';
												}
												?>
											</td>
											<td class="deamonLaunchable" data-slave_id="0">
												<?php
												if ($eqLogic->getIsEnable()) {
													$onkyoIp = filter_var($eqLogic->getConfiguration('onkyo_ip'), FILTER_VALIDATE_IP);
													$onkyoPort = (is_numeric($eqLogic->getConfiguration('onkyo_port', 60128)) && $eqLogic->getConfiguration('onkyo_port', 60128) > 0 && $eqLogic->getConfiguration('onkyo_port', 60128) < 65537 ? true : false);
													if (null != $eqLogic->getId() && '' != $eqLogic->getId() && $onkyoIp && $onkyoPort) {
														echo '<span class="label label-success" style="font-size:1em;">{{OK}}</span>';
													}
													else {
														echo '<span class="label label-danger" style="font-size:1em;">{{NOK}}</span> paramètres de connexion insuffisants';
													}
												}
												else {
													echo '<span class="label label-danger" style="font-size:1em;">{{NOK}}</span> l\'amplificateur n\'est pas activé';
												}
												?>
											</td>
											<td>
												<a class="btn btn-success btn-sm bt_startDeamon" data-slave_id="0" style="position:relative;top:-5px;"><i class="fa fa-play"></i></a>
											</td>
											<td>
												<a class="btn btn-danger btn-sm bt_stopDeamon" data-slave_id="0" style="position:relative;top:-5px;"><i class="fa fa-stop"></i></a>
											</td>
											<td class="td_lastLaunchDeamon" data-slave_id="0">
												<?php echo $eqLogic->getConfiguration('last_launch'); ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>-->
					</fieldset>
				</form>





			</div>
			<div role="tabpanel" class="tab-pane" id="commandtab">
				<table id="table_cmd" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th style="width: 100px;">#</th>
							<th>{{Nom}}</th>
							<th>{{Commande native}}</th>
							<th style="width: 200px;">{{Paramètres}}</th>
							<th style="width: 100px;"></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<?php
		}
		?>
	</div>
</div>

<?php include_file('desktop', 'onkyo', 'js', 'onkyo');?>
<?php include_file('core', 'plugin.template', 'js');?>

<script>
	$('.bt_startDeamon').on('click',function(){
		alert("NiY");
	});
	
	$('.bt_stopDeamon').on('click',function(){
		alert("NiY");
	});
</script>