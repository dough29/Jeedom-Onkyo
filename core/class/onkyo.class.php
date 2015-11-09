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

	public function getCommandsFromFile () {
		// Moulinette pour contourner l'adressage biaisé de l'include
		$path = "";
		$temp = preg_split("/\//",__FILE__);
		for ($i=0;$i< sizeof($temp)- 2;$i++) {
			if (!preg_match("/[A-z]\.php/",$temp[$i])) {
				$path .= $temp[$i]."/";	
			}
		}
		$commands = array();
		//echo "$path"."template/ressources/commands.txt"
		foreach (file($path."template/ressources/commands.txt") as $ligne) {
			if (trim($ligne) !== "" && !preg_match("/\;/",$ligne)) {
				$cases = preg_split("/\t/",$ligne);
				$label = trim($cases[0]);
				$code = trim($cases[1]);
				$type = trim($cases[2]);
				if (!isset($commands[$type])) {
					$commands[$type] = array();
				}
				$commands[$type][$label] = $code;
			}
		}
		return $commands;
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
		
		$commands = $this->getCommandsFromFile();
		// Boucle de création des objets commandes
		foreach ($commands as $type=>$command) {
			foreach ($command as $label=>$code) {
				//var_dump($commands); die;
				if (trim($type) !== "") {
					$type_params = $this->getTypeParams($type);
					$onkyoCmd = new onkyoCmd();
					$onkyoCmd->setName(__($label, __FILE__));
					$onkyoCmd->setEqLogic_id($this->id);
					$onkyoCmd->setConfiguration($type_params['configuration'], $code);
					if (!is_null($type_params['unite'])) {
						$onkyoCmd->setUnite($type_params['unite']);
					}
					$onkyoCmd->setType($type);
					$onkyoCmd->setSubType($type_params['subtype']);
					$onkyoCmd->setIsVisible(0);
					$onkyoCmd->setLogicalId(ereg_replace("[^a-z]", "", strtolower(__($label, __FILE__)))); 
					$onkyoCmd->save();
				}
			}
		}

	}

	public function toHtml($_version = 'dashboard') {
		if ($this->getIsEnable() != 1) {
			return '';
		}

		$commands = $this->getCommandsFromFile();
		
		$html_commandes = '';
		$js_commandes = '';
		$commandes_template = getTemplate('core', $_version, 'commandes', 'onkyo');
	
		// Boucle de création des variables
		$idz =array();
		foreach ($this->getCmd('action') as $cmd) {
			$id = "id_".$cmd->getLogicalId();
			$idz[$id] = $cmd->getId();
			
			if ($cmd->getIsVisible()) {
				$replace['#commandeId#'] = $cmd->getId();
				$replace['#commandeLogicialId#'] = $cmd->getLogicalId();
				$html_commandes .= template_replace($replace, $commandes_template);
				$js_commandes .= "$('.cmd[data-cmd_id=".$cmd->getId()."] .action').on('click', function() {jeedom.cmd.execute({id: '".$cmd->getId()."'});});";
			}
		}
		
		// Récupération des infos
		$onkyo = $this->getonkyoInfos();
		
		// Cas d'échec
		if (!is_array($onkyo)) {
			$replace = array();
			$replace['#ip_address#'] = '';
			foreach ($commands as $type=>$command) {
				foreach ($command as $label=>$code) {
					if ($type =="action") {
						$id = "id_".ereg_replace("[^a-z]", "", strtolower($label));
						$replace['#' . $id . '#'] = '';
					}
				}
			}
			$replace['#id#'] = $this->getId();
			$replace['#background_color#'] = $this->getBackgroundColor(jeedom::versionAlias($_version));
			$replace['#eqLink#'] = $this->getLinkToConfiguration();
			$replace['#commandes#'] = $html_commandes;
			$replace['#js_commandes#'] = $js_commandes;
			return template_replace($replace, getTemplate('core', jeedom::versionAlias($_version), 'onkyo', 'onkyo'));
		}
		
		// Cas de succès
		$replace = array();
		$replace['#name#'] = $this->getName();
		$replace['#ip_address#'] = $this->getConfiguration('ip_address');
		
		foreach ($commands as $type=>$command) {
			foreach ($command as $label=>$code) {
				if ($type =="action") {
					$id = "id_".ereg_replace("[^a-z]", "", strtolower($label));
					$replace['#' . $id . '#'] = $idz[$id];
				}
			}			
		}
		//var_dump($idz); die;
		$replace['#id#'] = $this->getId();
		$replace['#background_color#'] = $this->getBackgroundColor(jeedom::versionAlias($_version));
		$replace['#eqLink#'] = $this->getLinkToConfiguration();
		$replace['#commandes#'] = $html_commandes;
		$replace['#js_commandes#'] = $js_commandes;
		return template_replace($replace, getTemplate('core', jeedom::versionAlias($_version), 'onkyo', 'onkyo'));
	}

	public function getShowOnChild() {
		return true;
	}

	public function getonkyoInfos() {
		$onkyo= array();
		
		//$out = $this->sendISCP('MVLQSTN');
		//$onkyo['currentVolume'] = hexdec(substr($out, 3, 2));
		
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
