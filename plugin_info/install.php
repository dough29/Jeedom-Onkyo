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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

function onkyo_install() {
	log::add('onkyo', 'debug', 'onkyo_install()');
}

function onkyo_update() {
	log::add('onkyo', 'debug', 'onkyo_update()');
	
	$onkyos = onkyo::byType('onkyo', true);
	foreach ($onkyos as $onkyo) {
		onkyo::checkOnkyo($onkyo);
	}
}

function onkyo_remove() {
	log::add('onkyo', 'debug', 'onkyo_remove()');
}
?>
