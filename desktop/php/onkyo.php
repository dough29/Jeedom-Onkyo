<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'onkyo');
?>
<div class="row row-overflow">
	<div class="col-md-2">
		<div class="bs-sidebar">
			<ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
				<a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un ampli}}</a>
				<li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
				<?php
				foreach (eqLogic::byType('onkyo') as $eqLogic) {
					echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName() . '</a></li>';
				}
				?>
			</ul>
		</div>
	</div>
	<div class="col-md-10 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
		<form class="form-horizontal">
			<fieldset>
				<legend>{{Général}}</legend>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Nom de l'ampli}}</label>
					<div class="col-md-3">
						<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
						<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'ampli}}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" >{{Objet parent}}</label>
					<div class="col-md-3">
						<select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
							<option value="">{{Aucun}}</option>
							<?php
							foreach (object::all() as $object) {
								echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" >{{Activer}}</label>
					<div class="col-md-1">
						<input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" size="16" checked/>
					</div>
					<label class="col-md-2 control-label" >{{Visible}}</label>
					<div class="col-md-1">
						<input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">{{Adresse IP}}</label>
					<div class="col-md-3">
						<input type="text" id="ip_address" class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="ip_address" placeholder="Adresse IP"/>
					</div>
				</div>
			
			</fieldset> 
		</form>
		<form class="form-horizontal">
			<fieldset>
				<div class="form-actions">
					<a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
					<a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
				</div>
			</fieldset>
		</form>

	</div>
</div>
<?php include_file('desktop', 'onkyo', 'js', 'onkyo'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
