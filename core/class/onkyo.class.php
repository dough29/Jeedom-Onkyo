<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class onkyo extends eqLogic {

	public function getCommandsFromJSon () {
		$json = file_get_contents(__DIR__.'/../template/ressources/commands.json');
		$cmds = json_decode($json, true);
		
		return $cmds;
	}

	public function getTypeParams ($type) {
		$typ = trim($type);
		if ($typ == "action") {
				$return['configuration'] = "button";
				$return['subtype'] = "other";
				$return['unite'] = null;
		} elseif ($typ == "info") {
				$return['configuration'] = "data";
				$return['subtype'] = "numeric";
				$return['unite'] = '';
		} else {
			var_dump($typ); die;
		}
		return $return;
	}

	public function preUpdate() {
		if ($this->getConfiguration('ip_address') == '') {
			throw new Exception(__('L\'adresse IP ne peut être vide', __FILE__));
		}
	}

	public function postUpdate() {
	}

	public function postInsert() {
		
		$commands = $this->getCommandsFromJSon();

		foreach ($commands as $category=>$catCommands) {
			foreach ($catCommands as $commandName=>$conf) {
				foreach ($conf as $command=>$type) {
					$type_params = $this->getTypeParams($type);
					$onkyoCmd = new onkyoCmd();
					$onkyoCmd->setName($commandName);
					$onkyoCmd->setEqLogic_id($this->id);
					$onkyoCmd->setConfiguration($type_params['configuration'], $command);
					if (!is_null($type_params['unite'])) {
						$onkyoCmd->setUnite($type_params['unite']);
					}
					$onkyoCmd->setType($type);
					$onkyoCmd->setSubType($type_params['subtype']);
					$onkyoCmd->setIsVisible(0);
					$onkyoCmd->setLogicalId(ereg_replace("[^a-z0-9]", "", strtolower($commandName))); 
					$onkyoCmd->save();
				}
			}
		}
	}

	public function toHtml($_version = 'dashboard') {
		if ($this->getIsEnable() != 1) {
			return '';
		}
		
		// Récupération des informations de l'ampli
		$onkyo = $this->getOnkyoInfos();
		
		// Tableau des valeurs à remplacer dans le template 'onkyo.html'
		$replace = array();
		
		$replace['#id#'] = $this->getId();
		$replace['#background_color#'] = $this->getBackgroundColor(jeedom::versionAlias($_version));
		$replace['#eqLink#'] = $this->getLinkToConfiguration();
		$replace['#name#'] = $this->getName();
		
		$replace['#currentVolume#'] = $onkyo['currentVolume'];
		
		$onkyoCommands = $this->getCommandsFromJSon();

		$commandReplace = array();
		$replace['#js_commandes#'] = '';
		
		foreach ($this->getCmd('action') as $cmd) {
			if ($cmd->getIsVisible()) {
				foreach ($onkyoCommands as $category=>$catCommands) {
					if (array_key_exists($cmd->getName(), $onkyoCommands[$category])) {
						// Initialisation de la catégorie
						if (!array_key_exists($category, $commandReplace)) $commandReplace[$category] = '';
						
						// Création du bouton
						$commandReplace[$category] .= '<span class="cursor cmd tooltips cmd-widget" data-type="action" data-subtype="other" data-cmd_id="'.$cmd->getId().'"><span class="action"><img src="plugins/onkyo/core/template/ressources/'.$cmd->getLogicalId().'.png" style="width:50px; height:50px;"></span></span>';
						// Création du JS associé
						$replace['#js_commandes#'] .= "$('.cmd[data-cmd_id=".$cmd->getId()."] .action').on('click', function() {jeedom.cmd.execute({id: '".$cmd->getId()."'});});";
					}
				}
			}
		}
		
		$replace['#commandes#'] = '';
		
		foreach($commandReplace as $category=>$value) {
			$replace['#commandes#'] .= '<tr><td>'.$category.'</td><td>'.$value.'</td></tr>';
		}
		
		return template_replace($replace, getTemplate('core', jeedom::versionAlias($_version), 'onkyo', 'onkyo'));
	}

	public function getShowOnChild() {
		return true;
	}

	public function getOnkyoInfos() {
		$onkyo= array();
		
		$out = $this->sendISCP('MVLQSTN');
		$onkyo['currentVolume'] = hexdec(substr($out, 3, 2));
		
		//$out = $this->sendISCP('PWRQSTN');
		//$onkyo['powerState'] = substr($out, 3, 2);
		
		//log::add('onkyo', 'info', json_encode($onkyo), 'config');
		return $onkyo;
	}

	public function sendISCP($command) {
		$service_port = 60128;
		$address = $this->getConfiguration('ip_address');
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) {
			log::add('onkyo', 'error', "socket_create() a échoué : raison : " . socket_strerror(socket_last_error()) . "\n", 'config');
		}
		$result = socket_connect($socket, $address, $service_port);
		if ($socket === false) {
			log::add('onkyo', 'error', "socket_connect() a échoué : raison : ($result) " . socket_strerror(socket_last_error($socket)) . "\n", 'config');
		}
		$in = "ISCP\x00\x00\x00\x10\x00\x00\x00\x08\x01\x00\x00\x00\x211".$command."\x0D\x0A";
		socket_write($socket, $in, strlen($in));
		
		$out = socket_read($socket, 2048);
		
		socket_close($socket);
		
		$out = explode('!1', $out);

		return $out[1];
	}
}

class onkyoCmd extends cmd {
    public function dontRemoveCmd() {
        return true;
    }
	
	public function execute($_options = array()) {
		$eqLogic_onkyo = $this->getEqLogic();
		$onkyo = $eqLogic_onkyo->getonkyoInfos();
		if (!is_array($onkyo)) {
			sleep(1);
			$onkyo = $eqLogic_onkyo->getonkyoInfos();
			if (!is_array($onkyo)) {
				return false;
			}
		}
		
		if ($this->getConfiguration('data') == 'MVLQSTN') {
			return $onkyo['currentVolume'];
		}
		if ($this->getConfiguration('data') == 'PWRQSTN') {
			return $onkyo['powerState'];
		}
		
		if ($this->getType() == 'action') {
			log::add('onkyo', 'info', 'execute 2', 'config');
			$eqLogic_onkyo->sendISCP($this->getConfiguration('button'));
			return true;
		}

		return false;
	}
}
?>
