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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class onkyo extends eqLogic {
	public static $_onkyoCommands = array (
		"PWR" => array(
			"configuration" => array("System Power", "info", "binary"),
			"00" => array("System Standby", "action", "other"),
			"01" => array("System On", "action", "other")
		),
		"AMT" => array(
			"configuration" => array("Audio Muting", "info", "binary"),
			"00" => array("Audio Muting Off", "action", "other"),
			"01" => array("Audio Muting On", "action", "other")
		),
		"MVL" => array(
			"configuration" => array("Master Volume", "info", "numeric"),
			"UP" => array("Volume Level Up", "action", "other"),
			"DOWN" => array("Volume Level Down", "action", "other")
		),
		"DIM" => array(
			"configuration" => array("Dimmer Level", "info", "string"),
			"00" => array("Dimmer Level Bright", "action", "other"),
			"01" => array("Dimmer Level Dim", "action", "other"),
			"02" => array("Dimmer Level Dark", "action", "other"),
			"03" => array("Dimmer Level Shut-Off", "action", "other"),
			"08" => array("Dimmer Level Bright & LED OFF", "action", "other")
		),
		"SLI" => array(
			"configuration" => array("Input Selector", "info", "string"),
			"00" => array("VCR/DVR", "action", "other"),
			"01" => array("CBL/SAT", "action", "other"),
			"02" => array("GAME", "action", "other"),
			"03" => array("AUX1(AUX)", "action", "other"),
			"04" => array("AUX2", "action", "other"),
			"05" => array("PC", "action", "other"),
			"06" => array("VIDEO7", "action", "other"),
			"07" => array("EXTRA1", "action", "other"),
			"08" => array("EXTRA2", "action", "other"),
			"09" => array("EXTRA3", "action", "other"),
			"10" => array("BD/DVD", "action", "other"),
			"11" => array("STRM BOX", "action", "other"),
			"12" => array("TV", "action", "other"),
			"20" => array("TV/TAPE", "action", "other"),
			"21" => array("TAPE2", "action", "other"),
			"22" => array("PHONO", "action", "other"),
			"23" => array("TV/CD", "action", "other"),
			"24" => array("FM", "action", "other"),
			"25" => array("AM", "action", "other"),
			"26" => array("TUNER", "action", "other"),
			"27" => array("MUSIC SERVER", "action", "other"),
			"28" => array("INTERNET RADIO", "action", "other"),
			"29" => array("USB/USB(Front)", "action", "other"),
			"2A" => array("USB(Rear)", "action", "other"),
			"2B" => array("NETWORK / NET", "action", "other"),
			"2C" => array("USB(toggle)", "action", "other"),
			"2D" => array("Aiplay", "action", "other"),
			"2E" => array("Bluetooth", "action", "other"),
			"40" => array("Universal PORT", "action", "other"),
			"30" => array("MULTI CH", "action", "other"),
			"31" => array("XM*1", "action", "other"),
			"32" => array("SIRIUS*1", "action", "other"),
			"33" => array("DAB *5", "action", "other"),
			"UP" => array("Selector Position Wrap-Around Up", "action", "other"),
			"DOWN" => array("Selector Position Wrap-Around Down", "action", "other")
		),
		"SLZ" => array(
			"configuration" => array("Zone2 Selector", "info", "string"),
			"00" => array("Zone2 VCR/DVR", "action", "other"),
			"01" => array("Zone2 CBL/SAT", "action", "other"),
			"02" => array("Zone2 GAME", "action", "other"),
			"03" => array("Zone2 AUX1(AUX)", "action", "other"),
			"04" => array("Zone2 AUX2", "action", "other"),
			"05" => array("Zone2 PC", "action", "other"),
			"06" => array("Zone2 VIDEO7", "action", "other"),
			"07" => array("Zone2 EXTRA1", "action", "other"),
			"08" => array("Zone2 EXTRA2", "action", "other"),
			"09" => array("Zone2 EXTRA3", "action", "other"),
			"10" => array("Zone2 BD/DVD", "action", "other"),
			"11" => array("Zone2 STRM BOX", "action", "other"),
			"12" => array("Zone2 TV", "action", "other"),
			"20" => array("Zone2 TV/TAPE", "action", "other"),
			"21" => array("Zone2 TAPE2", "action", "other"),
			"22" => array("Zone2 PHONO", "action", "other"),
			"23" => array("Zone2 TV/CD", "action", "other"),
			"24" => array("Zone2 FM", "action", "other"),
			"25" => array("Zone2 AM", "action", "other"),
			"26" => array("Zone2 TUNER", "action", "other"),
			"27" => array("Zone2 MUSIC SERVER", "action", "other"),
			"28" => array("Zone2 INTERNET RADIO", "action", "other"),
			"29" => array("Zone2 USB/USB(Front)", "action", "other"),
			"2A" => array("Zone2 USB(Rear)", "action", "other"),
			"2B" => array("Zone2 NETWORK / NET", "action", "other"),
			"2C" => array("Zone2 USB(toggle)", "action", "other"),
			"2D" => array("Zone2 Aiplay", "action", "other"),
			"2E" => array("Zone2 Bluetooth", "action", "other"),
			"40" => array("Zone2 Universal PORT", "action", "other"),
			"30" => array("Zone2 MULTI CH", "action", "other"),
			"31" => array("Zone2 XM*1", "action", "other"),
			"32" => array("Zone2 SIRIUS*1", "action", "other"),
			"33" => array("Zone2 DAB *5", "action", "other"),
			"UP" => array("Zone2 Selector Position Wrap-Around Up", "action", "other"),
			"DOWN" => array("Zone2 Selector Position Wrap-Around Down", "action", "other")
		),
		"LMD" => array(
			"configuration" => array("Listening Mode", "info", "string"),
			"00" => array("STEREO", "action", "other"),
			"01" => array("DIRECT", "action", "other"),
			"02" => array("SURROUND", "action", "other"),
			"03" => array("FILM / Game-RPG", "action", "other"),
			"04" => array("THX", "action", "other"),
			"05" => array("ACTION / Game-Action", "action", "other"),
			"06" => array("MUSICAL / Game-Rock", "action", "other"),
			"07" => array("MONO MOVIE", "action", "other"),
			"08" => array("ORCHESTRA", "action", "other"),
			"09" => array("UNPLUGGED", "action", "other"),
			"0A" => array("STUDIO-MIX", "action", "other"),
			"0B" => array("TV LOGIC", "action", "other"),
			"0C" => array("ALL CH STEREO", "action", "other"),
			"0D" => array("THEATER-DIMENSIONAL", "action", "other"),
			"0E" => array("ENHANCED 7/ENHANCE / Game-Sports", "action", "other"),
			"0F" => array("MONO", "action", "other"),
			"11" => array("PURE AUDIO", "action", "other"),
			"12" => array("MULTIPLEX", "action", "other"),
			"13" => array("FULL MONO", "action", "other"),
			"14" => array("DOLBY VIRTUAL", "action", "other"),
			"15" => array("DTS Surround Sensation", "action", "other"),
			"16" => array("Audyssey DSX", "action", "other"),
			"1F" => array("Whole House Mode", "action", "other"),
			"23" => array("Stage", "action", "other"),
			"25" => array("Action", "action", "other"),
			"26" => array("Music", "action", "other"),
			"2E" => array("Sports", "action", "other"),
			"40" => array("5.1ch Surround", "action", "other"),
			"40" => array("Straight Decode*1", "action", "other"),
			"41" => array("Dolby EX/DTS ES", "action", "other"),
			"41" => array("Dolby EX*2", "action", "other"),
			"42" => array("THX Cinema", "action", "other"),
			"43" => array("THX Surround EX", "action", "other"),
			"44" => array("THX Music", "action", "other"),
			"45" => array("THX Games", "action", "other"),
			"50" => array("THX U2/S2/I/S Cinema/Cinema2", "action", "other"),
			"51" => array("THX MusicMode,THX U2/S2/I/S Music", "action", "other"),
			"52" => array("THX Games Mode,THX U2/S2/I/S Games", "action", "other"),
			"80" => array("PLII/PLIIx Movie / Dolby Atmos/Dolby Surround", "action", "other"),
			"81" => array("PLII/PLIIx Music", "action", "other"),
			"82" => array("Neo:6 Cinema/Neo:X Cinema", "action", "other"),
			"83" => array("Neo:6 Music/Neo:X Music", "action", "other"),
			"84" => array("PLII/PLIIx THX Cinema", "action", "other"),
			"85" => array("Neo:6/Neo:X THX Cinema", "action", "other"),
			"86" => array("PLII/PLIIx Game", "action", "other"),
			"87" => array("Neural Surr*3", "action", "other"),
			"88" => array("Neural THX/Neural Surround", "action", "other"),
			"89" => array("PLII/PLIIx THX Games", "action", "other"),
			"8A" => array("Neo:6/Neo:X THX Games", "action", "other"),
			"8B" => array("PLII/PLIIx THX Music", "action", "other"),
			"8C" => array("Neo:6/Neo:X THX Music", "action", "other"),
			"8D" => array("Neural THX Cinema", "action", "other"),
			"8E" => array("Neural THX Music", "action", "other"),
			"8F" => array("Neural THX Games", "action", "other"),
			"90" => array("PLIIz Height", "action", "other"),
			"91" => array("Neo:6 Cinema DTS Surround Sensation", "action", "other"),
			"92" => array("Neo:6 Music DTS Surround Sensation", "action", "other"),
			"93" => array("Neural Digital Music", "action", "other"),
			"94" => array("PLIIz Height + THX Cinema", "action", "other"),
			"95" => array("PLIIz Height + THX Music", "action", "other"),
			"96" => array("PLIIz Height + THX Games", "action", "other"),
			"97" => array("PLIIz Height + THX U2/S2 Cinema", "action", "other"),
			"98" => array("PLIIz Height + THX U2/S2 Music", "action", "other"),
			"99" => array("PLIIz Height + THX U2/S2 Games", "action", "other"),
			"9A" => array("Neo:X Game", "action", "other"),
			"A0" => array("PLIIx/PLII Movie + Audyssey DSX", "action", "other"),
			"A1" => array("PLIIx/PLII Music + Audyssey DSX", "action", "other"),
			"A2" => array("PLIIx/PLII Game + Audyssey DSX", "action", "other"),
			"A3" => array("Neo:6 Cinema + Audyssey DSX", "action", "other"),
			"A4" => array("Neo:6 Music + Audyssey DSX", "action", "other"),
			"A5" => array("Neural Surround + Audyssey DSX", "action", "other"),
			"A6" => array("Neural Digital Music + Audyssey DSX", "action", "other"),
			"A7" => array("Dolby EX + Audyssey DSX", "action", "other"),
			"UP" => array("Listening Mode Wrap-Around Up", "action", "other"),
			"DOWN" => array("Listening Mode Wrap-Around Down", "action", "other"),
			"MOVIE" => array("Listening Mode Wrap-Around Movie", "action", "other"),
			"MUSIC" => array("Listening Mode Wrap-Around Music", "action", "other"),
			"GAME" => array("Listening Mode Wrap-Around Game", "action", "other")
		),
		"PRS" => array(
			"configuration" => array("Preset", "info", "string"),
			"UP" => array("Preset No. Wrap-Around Up", "action", "other"),
			"DOWN" => array("Preset No. Wrap-Around Down", "action", "other")
		),
		"LTN" => array(
			"configuration" => array("Late Night", "info", "string"),
			"00" => array("Late Night Off", "action", "other"),
			"01" => array("Late Night Low@DolbyDigital", "action", "other"),
			"02" => array("Late Night High@DolbyDigital", "action", "other"),
			"03" => array("Late Night Auto@Dolby TrueHD", "action", "other"),
			"UP" => array("Late Night State Wrap-Around Up", "action", "other")
		),
		"HDO" => array(
			"configuration" => array("HDMI Output Selector", "info", "string"),
			"00" => array("Analog", "action", "other"),
			"01" => array("HDMI Main", "action", "other"),
			"02" => array("HDMI Sub", "action", "other"),
			"03" => array("Both Main+Sub", "action", "other"),
			"04" => array("Both(Main)", "action", "other"),
			"05" => array("Both(Sub)", "action", "other"),
			"UP" => array("HDMI Out Selector Wrap-Around Up", "action", "other")
		),
		"RES" => array(
			"configuration" => array("Monitor Out Resolution", "info", "string"),			
			"00" => array("Through", "action", "other"),
			"01" => array("Auto(HDMI Output Only)", "action", "other"),
			"02" => array("480p", "action", "other"),
			"03" => array("720p", "action", "other"),
			"13" => array("1680x720p", "action", "other"),
			"04" => array("1080i", "action", "other"),
			"05" => array("1080p(HDMI Output Only)", "action", "other"),
			"07" => array("1080p/24fs(HDMI Output Only)", "action", "other"),
			"15" => array("2560x1080p", "action", "other"),
			"08" => array("4K Upcaling(HDMI Output Only) 4K", "action", "other"),
			"06" => array("Source", "action", "other"),
			"UP" => array("Monitor Out Resolution Wrap-Around Up", "action", "other")
		),
		"CEC" => array(
			"configuration" => array("HDMI CEC", "info", "string"),			
			"00" => array("CEC Off", "action", "other"),
			"01" => array("CEC On", "action", "other"),
			"UP" => array("HDMI CEC Wrap-Around Up", "action", "other")
		),
		"SLP" => array(
			"configuration" => array("Sleep", "info", "numeric"),			
			"OFF" => array("Sleep Off", "action", "other"),
			"UP" => array("Sleep Time Wrap-Around UP", "action", "other")
		),
		
		// Zone 2
		"ZPW" => array(
			"configuration" => array("Zone2 Power", "info", "binary"),
			"00" => array("Zone2 Standby", "action", "other"),
			"01" => array("Zone2 On", "action", "other")
		),
		"ZMT" => array(
			"configuration" => array("Zone2 Muting", "info", "binary"),
			"00" => array("Zone2 Muting Off", "action", "other"),
			"01" => array("Zone2 Muting On", "action", "other")
		),
		"ZVL" => array(
			"configuration" => array("Zone2 Volume", "info", "numeric"),
			"UP" => array("Zone2 Level Up", "action", "other"),
			"DOWN" => array("Zone2 Level Down", "action", "other")
		),
		
		// NET
		/*"NTC" => array(
			"configuration" => array("Network/USB Operation", "info", "string"),
			"PLAY" => array("PLAY KEY", "action", "other"),
			"STOP" => array("STOP KEY", "action", "other"),
			"PAUSE" => array("PAUSE KEY", "action", "other"),
			"TRUP" => array("TRACK UP KEY", "action", "other"),
			"TRDN" => array("TRACK DOWN KEY", "action", "other"),
			"FF" => array("FF KEY (CONTINUOUS*)", "action", "other"),
			"REW" => array("REW KEY (CONTINUOUS*)", "action", "other"),
			"REPEAT" => array("REPEAT KEY", "action", "other"),
			"RANDOM" => array("RANDOM KEY", "action", "other"),
			"DISPLAY" => array("DISPLAY KEY", "action", "other"),
			"ALBUM" => array("ALBUM KEY", "action", "other"),
			"ARTIST" => array("ARTIST KEY", "action", "other"),
			"GENRE" => array("GENRE KEY", "action", "other"),
			"PLAYLIST" => array("PLAYLIST KEY", "action", "other"),
			"RIGHT" => array("RIGHT KEY", "action", "other"),
			"LEFT" => array("LEFT KEY", "action", "other"),
			"UP" => array("UP KEY", "action", "other"),
			"DOWN" => array("DOWN KEY", "action", "other"),
			"SELECT" => array("SELECT KEY", "action", "other"),
			"0" => array("0 KEY", "action", "other"),
			"1" => array("1 KEY", "action", "other"),
			"2" => array("2 KEY", "action", "other"),
			"3" => array("3 KEY", "action", "other"),
			"4" => array("4 KEY", "action", "other"),
			"5" => array("5 KEY", "action", "other"),
			"6" => array("6 KEY", "action", "other"),
			"7" => array("7 KEY", "action", "other"),
			"8" => array("8 KEY", "action", "other"),
			"9" => array("9 KEY", "action", "other"),
			"DELETE" => array("DELETE KEY", "action", "other"),
			"CAPS" => array("CAPS KEY", "action", "other"),
			"LOCATION" => array("LOCATION KEY", "action", "other"),
			"LANGUAGE" => array("LANGUAGE KEY", "action", "other"),
			"SETUP" => array("SETUP KEY", "action", "other"),
			"RETURN" => array("RETURN KEY", "action", "other"),
			"CHUP" => array("CH UP(for iRadio)", "action", "other"),
			"CHDN" => array("CH DOWN(for iRadio)", "action", "other"),
			"MENU" => array("MENU", "action", "other"),
			"TOP" => array("TOP MENU", "action", "other"),
			"MODE" => array("MODE(for iPod) STD<->EXTMODE", "action", "other"),
			"LIST" => array("LIST <-> PLAYBACK", "action", "other"),
			"F1" => array("Positive Feed or Mark/Unmark *1", "action", "other"),
			"F2" => array("Negative Feed *1", "action", "other")
		),*/
		"NAT" => array(
			"configuration" => array("NET/USB Artist Name Info", "info", "string")
		),
		"NAL" => array(
			"configuration" => array("NET/USB Album Name Info", "info", "string")
		),
		"NTI" => array(
			"configuration" => array("NET/USB Title Name", "info", "string")
		),
		"NTM" => array(
			"configuration" => array("NET/USB Time Info", "info", "string")
		),
		"NTR" => array(
			"configuration" => array("NET/USB Track Info", "info", "string")
		),
		"NST" => array(
			"configuration" => array("NET/USB Play Status", "info", "string")
		),
		"NPR" => array(
			"configuration" => array("Internet Radio Preset", "info", "string")
		),
		/*"NLS" => array(
			"configuration" => array("NET/USB List Info", "info", "string")
		),*/
		/*"NJA" => array(
			"configuration" => array("NET/USB Jacket Art", "info", "string"),
			"DIS" => array("Jacket Art disable", "action", "other"),
			"ENA" => array("Jacket Art enable", "action", "other"),
			"BMP" => array("Jacket Art enable and Image type BMP", "action", "other"),
			"LINK" => array("Jacket Art enable and Image type LINK", "action", "other"),
			"UP" => array("Jacket Art Wrap-Around Up", "action", "other"),
			"REQ" => array("Jacket Art data", "action", "other")
		),*/
		/*"NSV" => array(
			"configuration" => array("NET Service", "action", "message")
		),*/
		/*"NPU" => array(
			"configuration" => array("NET Popup Message", "info", "string")
		),*/
		"IFA" => array( "configuration" => array("Audio Information", "info", "string") ),
		"IFV" => array( "configuration" => array("Video Information", "info", "string") ),
		"OSD" => array(
			"configuration" => array("Setup Operation Command", "info", "string"),
			"MENU" => array("Menu", "action", "other"),
			"UP" => array("Up", "action", "other"),
			"DOWN" => array("Down", "action", "other"),
			"RIGHT" => array("Right", "action", "other"),
			"LEFT" => array("Left", "action", "other"),
			"ENTER" => array("Enter", "action", "other"),
			"EXIT" => array("Exit", "action", "other"),
			"AUDIO" => array("Audio Adjust", "action", "other"),
			"VIDEO" => array("Video Adjust", "action", "other"),
			"HOME" => array("Home", "action", "other"),
			"QUICK" => array("Quick Setup", "action", "other"),
			"IPV" => array("Instaprevue", "action", "other"),
		),
	);
	
	public static function deamon_info() {
		$return = array();
		$return['log'] = 'onkyo_node';
		$return['state'] = 'nok';
		$pid = trim( shell_exec ('ps ax | grep "onkyo/resources/onkyo.js" | grep -v "grep" | wc -l') );
		if ($pid != '' && $pid != '0') {
			$return['state'] = 'ok';
		}
		$return['launchable'] = 'ok';
		return $return;
	}
	
	public static function deamon_start() {
		self::deamon_stop();
		$deamon_info = self::deamon_info();
		if ($deamon_info['launchable'] != 'ok') {
			throw new Exception(__('Veuillez vérifier la configuration', __FILE__));
		}
		
		$url = network::getNetworkAccess('internal') . '/plugins/onkyo/core/api/jeeOnkyo.php?apikey=' . jeedom::getApiKey('onkyo');
		
		//launching serial service
		$onkyoLaunched = onkyo::launch_node($url, config::byKey('nodePort', 'onkyo', 8021));
		
		// Attente du lancement du démon
		$tries = 0;
		while (true) {
			if (null != onkyo::callbackCmd('{"action":"getNodes"}', true)) break;
			$tries++;
			if ($tries > 4) { $onkyoLaunched = false; break; }
			sleep(1);
		}
		
		if ($onkyoLaunched) {
			$onkyos = self::byType('onkyo', true);
			
			foreach ($onkyos as $onkyo) {
				self::createNode($onkyo);
			}
		}
		else {
			log::add('onkyo', 'error', 'Erreur lors de la création du node');
		}
	}
	
	public static function launch_node($url, $port) {
		$log = log::convertLogLevel(log::getLogLevel('onkyo'));
		$sensor_path = realpath(dirname(__FILE__) . '/../../resources');
		
		$cmd = 'nice -n 19 nodejs ' . $sensor_path . '/onkyo.js ' . $url . ' ' . $port . ' ' . $log;
		
		log::add('onkyo', 'debug', 'Lancement démon onkyo : ' . $cmd);
		
		$result = exec('nohup ' . $cmd . ' >> ' . log::getPathToLog('onkyo_node') . ' 2>&1 &');
		if (strpos(strtolower($result), 'error') !== false || strpos(strtolower($result), 'traceback') !== false) {
			log::add('onkyo', 'error', $result);
			return false;
		}
		
		$i = 0;
		while ($i < 30) {
			$deamon_info = self::deamon_info();
			if ($deamon_info['state'] == 'ok') {
				break;
			}
			sleep(1);
			$i++;
		}
		if ($i >= 30) {
			log::add('onkyo', 'error', 'Impossible de lancer le démon onkyo, vérifiez le port', 'unableStartDeamon');
			return false;
		}
		message::removeAll('onkyo', 'unableStartDeamon');
		log::add('onkyo', 'info', 'Démon onkyo lancé');
		return true;
	}

	public static function deamon_stop() {
		exec('kill $(ps aux | grep "onkyo/resources/onkyo.js" | awk \'{print $2}\')');
		log::add('onkyo', 'info', 'Arrêt du service onkyo');
		$deamon_info = self::deamon_info();
		if ($deamon_info['state'] == 'ok') {
			sleep(1);
			exec('kill -9 $(ps aux | grep "onkyo/resources/onkyo.js" | awk \'{print $2}\')');
		}
		$deamon_info = self::deamon_info();
		if ($deamon_info['state'] == 'ok') {
			sleep(1);
			exec('sudo kill -9 $(ps aux | grep "onkyo/resources/onkyo.js" | awk \'{print $2}\')');
		}
	}
	
	public static function dependancy_info() {
		$return = array();
		$return['log'] = 'onkyo_dep';
		$net = realpath(dirname(__FILE__) . '/../../resources/node_modules/net');
		$async = realpath(dirname(__FILE__) . '/../../resources/node_modules/async');
		$events = realpath(dirname(__FILE__) . '/../../resources/node_modules/events');
		$request = realpath(dirname(__FILE__) . '/../../resources/node_modules/request');
		$return['progress_file'] = '/tmp/onkyo_dep';
		if (is_dir($net) && is_dir($async) && is_dir($events) && is_dir($request)) {
			$return['state'] = 'ok';
		}
		else {
			$return['state'] = 'nok';
		}
		return $return;
	}
	
	public static function dependancy_install() {
		log::add('onkyo','info','Installation des dépéndances nodejs');
		$resource_path = realpath(dirname(__FILE__) . '/../../resources');
		passthru('/bin/bash ' . $resource_path . '/nodejs.sh ' . $resource_path . ' onkyo > ' . log::getPathToLog('onkyo_dep') . ' 2>&1 &');
	}
	
	public function preSave() {
		log::add('onkyo', 'debug', 'preSave()');
		$this->setLogicalId($this->getConfiguration('onkyo_ip'));

		if (null != $this->getId() && '' != $this->getId()) {
			log::add('onkyo', 'debug', 'on cherche à killer le node existant');
			$node = json_decode(onkyo::callbackCmd('{"action":"getNode","id":'.$this->getId().'}', false));
			if (count($node) > 0) {
				// Suppression du noeud
				if (onkyo::callbackCmd('{"action":"removeNode","id":'.$this->getId().'}', false)) {
					log::add('onkyo', 'info', 'noeud déconnecté');
				}
				else {
					log::add('onkyo', 'error', 'erreur lors de la déconnexion du noeud');
				}
			}
			else {
				log::add('onkyo', 'debug', 'noeud non connecté');
			}
		}
	}

	public function preInsert() {
		log::add('onkyo', 'debug', 'preInsert()');
	}
	
	public function postInsert() {
		log::add('onkyo', 'debug', 'postInsert()');
	}
	
	public function postSave() {
		log::add('onkyo', 'debug', 'postSave()');

		if ($this->getIsEnable()) {
			self::createNode($this);
		}
		else {
			log::add('onkyo', 'info', 'l\'équipement n\'est pas activé');
		}
		
		onkyo::checkOnkyo($this);
	}
	
	public function postAjax() {
		log::add('onkyo', 'debug', 'postAjax()');
		
		onkyo::cleanOnkyo($this);
	}
	
	public function cleanOnkyo($onkyo) {
		// Nettoyage des commandes
		$cmds = onkyoCmd::byEqLogicId($onkyo->getId());
		
		foreach ($cmds as $cmd) {
			log::add('onkyo', 'debug', 'Vérification de la commande '.$cmd->getLogicalId());
			if (strlen($cmd->getLogicalId()) == 3) {
				$code = $cmd->getLogicalId();
				if (!isset(onkyo::$_onkyoCommands[$code])) {
					log::add('onkyo', 'debug', '-> La commande '.$code.' n\'existe pas : suppression');
					$cmd->remove();
					
					// Si type numeric il faut aussi supprimer le slider
					if ('numeric' == $cmd->getSubType()) {
						$sliderCmd = onkyoCmd::byEqLogicIdAndLogicalId($onkyo->getId(), $code.'SLIDER');
						if (is_object($sliderCmd)) {
							log::add('onkyo', 'debug', '-> Suppression du slider lié à la commande '.$code);
							$sliderCmd->remove();
						}
					}
				}
			}
			elseif (strlen($cmd->getLogicalId()) > 3) {
				$code = substr($cmd->getLogicalId(), 0, 3);
				$command = substr($cmd->getLogicalId(), 3, strlen($cmd->getLogicalId())-3);
				if (!isset(onkyo::$_onkyoCommands[$code][$command]) && 'SLIDER' != $command) {
					log::add('onkyo', 'debug', '-> La commande '.$code.$command.' n\'existe pas : suppression');
					$cmd->remove();
				}
			}
		}
	}
	
	public function checkOnkyo($onkyo) {
		// Création des commandes
		foreach (onkyo::$_onkyoCommands as $code => $value) {
			log::add('onkyo', 'debug', 'Vérification des commandes '.$code.' pour l\'amplificateur '.$onkyo->getName());
			log::add('onkyo', 'debug', 'configuration = '.$value['configuration'][0].' - '.$value['configuration'][1].' - '.$value['configuration'][2]);
			
			$onkyoCmd = onkyoCmd::byEqLogicIdAndLogicalId($onkyo->getId(), $code);
			if (!is_object($onkyoCmd)) {
				log::add('onkyo', 'debug', 'La commande '.$code.' n\'existe pas pour l\'amplificateur '.$onkyo->getId().' -> création');
				
				$onkyoCmd = new onkyoCmd();
				$onkyoCmd->setEqLogic_id($onkyo->getId());
				$onkyoCmd->setEqType('onkyo');
				$onkyoCmd->setLogicalId($code);
				if ($value['configuration'][2] == 'numeric') {
					$onkyoCmd->setName('Info '.$code);
					$onkyoCmd->setIsVisible(0);
				}
				else {
					$onkyoCmd->setName($value['configuration'][0]);
				}
				$onkyoCmd->setType($value['configuration'][1]);
				$onkyoCmd->setSubType($value['configuration'][2]);
				$onkyoCmd->save();
			}
			
			$cmdId = $onkyoCmd->getId();
			
			if ($value['configuration'][2] == 'numeric') {
				$onkyoCmd = onkyoCmd::byEqLogicIdAndLogicalId($onkyo->getId(), $code.'SLIDER');
				if (!is_object($onkyoCmd)) {
					log::add('onkyo', 'debug', 'La commande '.$code.'SLIDER'.' n\'existe pas pour l\'amplificateur '.$onkyo->getId().' -> création');
					$onkyoCmd = new onkyoCmd();
					$onkyoCmd->setEqLogic_id($onkyo->getId());
					$onkyoCmd->setEqType('onkyo');
					$onkyoCmd->setLogicalId($code.'SLIDER');
					$onkyoCmd->setName($value['configuration'][0]);
					$onkyoCmd->setConfiguration('minValue', 0);
					$onkyoCmd->setConfiguration('maxValue', 80);
					$onkyoCmd->setType('action');
					$onkyoCmd->setSubType('slider');
					$onkyoCmd->setValue($cmdId);
					$onkyoCmd->save();
				}
			}

			foreach ($value as $command => $configuration) {
				if ($command != 'configuration') {
					log::add('onkyo', 'debug', 'Vérification de la commande '.$code.$command.' pour l\'amplificateur '.$onkyo->getName());
					$onkyoCmd = onkyoCmd::byEqLogicIdAndLogicalId($onkyo->getId(), $code.$command);
					if (!is_object($onkyoCmd)) {
						log::add('onkyo', 'debug', 'La commande '.$code.$command.' n\'existe pas pour l\'amplificateur '.$onkyo->getId());
						$onkyoCmd = onkyoCmd::byEqLogicIdAndLogicalId($onkyo->getId(), $code.$command);
						if (!is_object($onkyoCmd)) {
							log::add('onkyo', 'debug', 'La commande '.$code.$command.' n\'existe pas pour l\'amplificateur '.$onkyo->getId().' -> création');
							$onkyoCmd = new onkyoCmd();
							$onkyoCmd->setEqLogic_id($onkyo->getId());
							$onkyoCmd->setEqType('onkyo');
							$onkyoCmd->setLogicalId($code.$command);
							$onkyoCmd->setName($configuration[0]);
							$onkyoCmd->setConfiguration('command', $code.$command);
							$onkyoCmd->setType($configuration[1]);
							$onkyoCmd->setSubType($configuration[2]);
							$onkyoCmd->setIsVisible(0);
							$onkyoCmd->setValue($cmdId);
							$onkyoCmd->save();
						}
					}
				}
			}
		}
		log::add('onkyo', 'debug', 'Création des commandes terminée');
	}
	
	public static function createNode($onkyo) {
		$onkyoIp = filter_var($onkyo->getConfiguration('onkyo_ip'), FILTER_VALIDATE_IP);
		$onkyoPort = (is_numeric($onkyo->getConfiguration('onkyo_port', 60128)) && $onkyo->getConfiguration('onkyo_port', 60128) > 0 && $onkyo->getConfiguration('onkyo_port', 60128) < 65537 ? true : false);
		
		if (null != $onkyo->getId() && '' != $onkyo->getId() && $onkyoIp && $onkyoPort) {
			log::add('onkyo', 'debug', 'connexion du noeud');
			if (onkyo::callbackCmd('{"action":"createNode","id":'.$onkyo->getId().',"name":"'.$onkyo->getName().'","host":"'.$onkyo->getConfiguration('onkyo_ip').'","port":'.$onkyo->getConfiguration('callback_port', 60128).'}', false)) {
				log::add('onkyo', 'info', 'noeud connecté');
				
				// Actualisation des états
				log::add('onkyo', 'debug', 'Actualisation des états');
				
				$cmds = onkyoCmd::byEqLogicId($onkyo->getId(), 'info');
				
				foreach ($cmds as $cmd) {
					log::add('onkyo', 'debug', '-> actualisation état '.$cmd->getLogicalId());
					onkyoCmd::sendToController('{"action":"sendCmd","id":'.$onkyo->getId().',"command":"'.$cmd->getLogicalId().'QSTN"}');
				}

				return true;
			}
			else {
				log::add('onkyo', 'error', 'erreur lors de la connexion du noeud');
				return false;
			}
		}
		else {
			log::add('onkyo', 'error', 'paramètres de connexion insuffisants');
			return false;
		}
	}
	
	// Vérifie que les paramètre de l'amplificateur suffisent au lancement du node
	public function isLaunchable() {
		$onkyoIp = filter_var($this->getConfiguration('onkyo_ip'), FILTER_VALIDATE_IP);
		$onkyoPort = (is_numeric($this->getConfiguration('onkyo_port'), 60128) && $this->getConfiguration('onkyo_port', 60128) > 0 && $this->getConfiguration('onkyo_port', 60128) < 65537 ? true : false);
		return ($onkyoIp && $onkyoPort);
	}
	
	public function preUpdate() {
		log::add('onkyo', 'debug', 'preUpdate()');
	}
	
	public function postUpdate() {
		log::add('onkyo', 'debug', 'postUpdate()');
	}
	
	public function preRemove() {
		log::add('onkyo', 'debug', 'preRemove()');
		
		$connectedOnkyos = json_decode(onkyo::callbackCmd('{"action":"getNode","id":'.$this->getId().'}', true));
		
		if (count($connectedOnkyos) > 0) {
			if (onkyo::callbackCmd('{"action":"removeNode","id":'.$this->getId().'}', false)) {
				log::add('onkyo', 'info', 'noeud déconnecté');
			}
			else {
				log::add('onkyo', 'error', 'erreur lors de la déconnexion du noeud');
			}
		}
		else {
			log::add('onkyo', 'info', 'le noeud n\'était pas connecté');
		}
	}
	
	public function postRemove() {
		log::add('onkyo', 'debug', 'postRemove()');
	}
	
	public static function onkyoCmd($onkyoId, $cmd, $value) {
		log::add('onkyo', 'debug', 'Réception d\'un état : id='.$onkyoId.' cmd='.$cmd.', value='.$value);
		$onkyoCmd = onkyoCmd::byEqLogicIdAndLogicalId($onkyoId, $cmd);
		if (is_object($onkyoCmd)) {
			log::add('onkyo', 'debug', 'commande trouvée -> '.$onkyoCmd->getName().' - type -> '.$onkyoCmd->getType().' - subType -> '.$onkyoCmd->getSubType());
			if ('numeric' == $onkyoCmd->getSubType()) {
				$onkyoCmd->event(hexdec($value));
			}
			else {
				$onkyoCmd->event($value);
			}
		}
	}
	
	public static function callbackCmd($cmd, $noFail) {
		$fp = fsockopen('127.0.0.1', config::byKey('nodePort', 'onkyo', 8021), $errno, $errstr, 5);
		if (!$fp) {
			if (!$noFail) log::add('onkyo', 'error', 'Connexion du node impossible, vérifier que le démon est lancé');
		}
		else {
			fwrite($fp, $cmd);
			while (!feof($fp)) {
				return fgets($fp, 128);
			}
		}
		return null;
	}
}

class onkyoCmd extends cmd {
	public function preRemove() {
		log::add('onkyo', 'debug', 'onkyoCmd::preRemove()');
	}

	public function postRemove() {
		log::add('onkyo', 'debug', 'onkyoCmd::postRemove()');
	}

	public function execute($_options = null) {
		log::add('onkyo', 'debug', 'execute()');
		
		$result = '';
		
		switch ($this->getType()) {
			case 'info':
				return $this->execCmd();
				break;
			case 'action':
				$value = '';
				switch ($this->getSubType()) {
					case 'slider':
						$infoCmd = cmd::byId($this->getValue());
						$value = $_options['slider'];
						//if ($infoCmd->getLogicalId() == 'MVL' || $infoCmd->getLogicalId() == 'ZVL') {
						$value = strtoupper(dechex($value));
						if (strlen($value) == 1) $value = '0'.$value;
						//}
						$result = onkyoCmd::sendToController('{"action":"sendCmd","id":'.$this->getEqLogic_id().',"command":"'.$infoCmd->getLogicalId().$value.'"}');
						break;
					case 'other':
						$result = onkyoCmd::sendToController('{"action":"sendCmd","id":'.$this->getEqLogic_id().',"command":"'.$this->getConfiguration('command').'"}');
				}
				
				break;
		}
		
		return $result;
	}
	
	public static function sendToController($msg) {
		log::add('onkyo', 'debug', 'Envoi au contrôleur: '.$msg);
		$fp = fsockopen('127.0.0.1', config::byKey('nodePort', 'onkyo', 8021), $errstr);
		if (!$fp) {
			echo "ERROR: $errstr<br />\n";
		} else {
			fwrite($fp, $msg);
			fclose($fp);
		}
		return $msg;
	}
}
?>
