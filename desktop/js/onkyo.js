
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

$(function() {
    $("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});
});

function addCmdToTable(_cmd) {
}
/*
function printOnkyo(_OnkyoEq_id) {
    $.ajax({// fonction permettant de faire de l'ajax
        type: "POST", // methode de transmission des données au fichier php
        url: "plugins/onkyo/core/ajax/onkyo.ajax.php", // url du fichier php
        data: {
            action: "getInfos",
            id: _OnkyoEq_id
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, error);
        },
        success: function(data) { // si l'appel a bien fonctionné
        	if (data.state != 'ok') {
                $('#div_alert').showAlert({message:  data.result,level: 'danger'});
                return;
            }
            $('#table_onkyo tbody').empty();
            $('#div_onkyo').empty();
            $('#div_onkyo').append(data.result.print);
            for (var i in data.result.cmd) {
            	if (data.result.cmd[i].value != null) {
                	var tr = '<tr>';
                	tr += '<td>' + data.result.cmd[i].name + '</td>';
                	tr += '<td>' + data.result.cmd[i].value;
                	if (data.result.cmd[i].unite != null) {
                    	tr += ' ' + data.result.cmd[i].unite;
                	}
                	tr += '</td>';
                	tr += '</tr>';
                	$('#table_onkyo tbody').append(tr);
               }
            }
        }
    });
}*/