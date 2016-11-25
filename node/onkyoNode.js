/*jslint node:true nomen:true*/
'use strict';
var onkyo, send_queue,
	nodes = [],
	net = require('net'),
	async = require('async'),
	events = require('events'),
	request = require('request');

var urlJeedom = '';
var callbackPort = '';
var log = '';

process.argv.forEach(function(val, index, array) {
	switch ( index ) {
		case 2 : urlJeedom = val; break;
		case 3 : callbackPort = val; break;
		case 4 : log = val; break;
	}
});

onkyo = new events.EventEmitter();

onkyo.on('error', (err) => {
	logger('ERROR', 'ERROR - keeping process alive:'+err);
});

onkyo.on('uncaughtException', function (err) {
	logger('ERROR', 'UNCAUGHT EXCEPTION - keeping process alive:'+err);
});



/*
	Ce service est l'interface de communication avec Jeedom
*/
var callbackServer = net.createServer((c) => {
	c.on('data', (data) => {
		if (/^[\],:{}\s]*$/.test(data.toString().replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
			var cmd = JSON.parse(data.toString());
			
			switch(cmd.action) {
				case 'createNode':
					logger('DEBUG', '->createNode: id='+cmd.id+'; name='+cmd.name);
					onkyo.connect(cmd.id, cmd.name, cmd.host, cmd.port);
					c.write('{"result":"success", "nodeCreated":'+cmd.id+'}\n');
					break;
				case 'removeNode':
					logger('DEBUG', '->removeNode : id.'+cmd.id);
					for (var i = 0, len = nodes.length; i < len; i++) {
						if (nodes[i].id == cmd.id) {
							nodes[i].destroy();
							nodes.splice(i, 1);
							c.write('{"result":"success", "nodeRemoved":'+cmd.id+'}\n');
							break;
						}
					}
					break;
				case 'getNode':
					logger('DEBUG', '->getNode id.'+cmd.id);
					var result = '[';
					for (var i = 0, len = nodes.length; i < len; i++) {
						if (nodes[i].id == cmd.id) {
							result += '{"id":'+nodes[i].id+',"name":"'+nodes[i].name+'", "connected":'+nodes[i].is_connected+'}';
							break;
						}
					}
					result += ']';
					c.write(result+'\n');
					break;
				case 'getNodes':
					logger('DEBUG', '->getNodes');
					var result = '[';
					for (var i = 0, len = nodes.length; i < len; i++) {
						result += '{"id":'+nodes[i].id+',"name":"'+nodes[i].name+'", "connected":'+nodes[i].is_connected+'},';
					}
					if (result.length > 1) {
						result = result.substring(0, result.length - 1);
					}
					result += ']';
					c.write(result+'\n');
					break;
				case 'sendCmd':
					logger('DEBUG', '->sendCmd: id='+cmd.id+'; command='+cmd.command);
					onkyo.raw({id:cmd.id, message:cmd.command}, function (err) {
						if (err) {
							logger('ERROR', 'ERROR - sending command:'+err);
						}
					});
					c.write('{"result":"success", "messageSent":"'+cmd.command+'"}\n');
					break;
				default:
					logger('DEBUG', 'Action '+cmd.action+' not implemented');
					break;
			}
		}
		else {
			logger('ERROR', 'Erreur lors de l\'appel du service -> '+data.toString());
			c.write('HTTP/1.1 403 Forbidden\nContent-Length: 9\n\nForbidden');
		}
	});
});

callbackServer.on('error', (err) => {
	throw err;
});

callbackServer.listen(callbackPort, () => {
	logger('INFO', 'Service de callback plugin Onkyo : Ok');
});



/*
	Implémentation de la communication avec les amplificateurs
*/
onkyo.connect = function (id, name, host, port) {
	logger('DEBUG', 'Tentative de connexion à id.'+id+' -> '+name);
	var node = net.connect({host:host, port:port});
	node.id = id;
	node.name = name;
	node.
	on('connect', function () {
		logger('INFO', 'Connexion id.'+node.id+' : Ok');
		node.is_connected = true;
	}).
	on('close', function () {
		logger('INFO', 'Connexion id.'+node.id+' : closed');
		node.is_connected = false;
		node.destroy();
	}).
	on('error', function (err) {
		logger('ERROR', 'Connexion id.'+node.id+' : une erreur est survenue, vérifier la configuration');
	}).
	on('data', function (data) {
		logger('DEBUG', '#################### packet ####################');
		logger('DEBUG', data.toString());
		logger('DEBUG', '################################################');
		
		// On ne conserve que les caractères nécessaires
		var messages = data.toString().replace(/[^\x20-\x7E\xC0-\xFF]/gi, '');
		messages = messages.replace('ISCP\'!1', 'ISCP!1');
		
		messages = messages.split('ISCP!1');

		for (var i = 0, len = messages.length; i < len; i++) {
			if (messages[i].length > 0) {
				logger('DEBUG', '##################-> '+messages[i].length+' - '+messages[i]);
				logger('DEBUG', 'Etat "'+messages[i]+'" reçu pour id.'+node.id);
				
				sendToJeedom(node.id, messages[i]);
			}
		}

		logger('DEBUG', '################################################');
		logger('DEBUG', '################################################');
	});
	nodes.push(node);
}

onkyo.raw = function (data, callback) {
    if (typeof data !== 'undefined' && data !== '') {
        send_queue.push(data, function (err) {
            if (typeof callback === 'function') {
                callback(err, null);
            }
        });
    }
	else if (typeof callback === 'function') {
        callback(true, 'No data provided.');
    }
};

send_queue = async.queue(function (data, callback) {
	var nodeIt = -1;
	
	for (var i = 0, len = nodes.length; i < len; i++) {
		if (nodes[i].id == data.id) {
			nodeIt = i;
			break;
		}
	}
	
    if (nodeIt >=0 && nodes[nodeIt].is_connected) {
		nodes[nodeIt].write(iscp_packet(data.message));
        setTimeout(callback, 500, false);
        return;
    }

    logger('INFO', 'l\'id '+data.id+' n\'est pas connecté');
    callback('Send command, while not connected', null);

}, 1);

function iscp_packet(data) {
    var iscp_msg, header;

    // Add ISCP header if not already present
    if (data.charAt(0) !== '!') { data = '!1' + data; }
    // ISCP message
    iscp_msg = new Buffer(data + '\x0D\x0a');

    // eISCP header
    header = new Buffer([
        73, 83, 67, 80, // magic
        0, 0, 0, 16,    // header size
        0, 0, 0, 0,     // data size
        1,              // version
        0, 0, 0         // reserved
    ]);
    // write data size to eISCP header
    header.writeUInt32BE(iscp_msg.length, 8);

    return Buffer.concat([header, iscp_msg]);
}

function iscp_packet_extract(packet) {
    return packet.toString('ascii', 18, packet.length - 3);
}


/*
	Fonctions utiles
*/
function sendToJeedom(id, message) {
	var command = message.substring(0, 3),
		value = message.substring(3, message.length);
	var jeeOnkyo = urlJeedom + '&onkyoId='+id+'&cmd='+command+'&value='+value;
	request(jeeOnkyo, function (error, response, body) {
		if (!error && response.statusCode == 200) {
			logger('DEBUG', 'Mise à jour de l\'état dans Jeedom : '+jeeOnkyo);
		}
		else{
			logger('ERROR', 'Envoi de l\état à Jeedom impossible');
		}
	});
}

function logger(level, message) {
	if (
		(log == 'error' && level == 'ERROR') ||
		(log == 'warning' && (level == 'ERROR' || level == 'WARNING')) ||
		(log == 'info' && (level == 'ERROR' || level == 'WARNING' || level == 'INFO')) ||
		(log == 'debug' && (level == 'ERROR' || level == 'WARNING' || level == 'INFO' || level == 'DEBUG'))
	)
	{
		console.log(level+':'+(new Date()) + " > " + message);
	}
}
