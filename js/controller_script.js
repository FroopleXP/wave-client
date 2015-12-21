$(document).ready(function() {

	var socket = io.connect("http://127.0.0.1:8080", {secure: true});
	var list = $("#control_list");

	list.delegate('button', 'click', function(sel) {

		var socket_num = $(this).attr('socket_num');
		var channel = $(this).attr('channel_id');
		var pos = $(this).attr('pos');
		var user_id = $.cookie("user_id");

		socket.emit('control', {
			user_id: user_id,
			channel_id: channel,
			socket_id: socket_num,
			pos: pos
		});

	});

});
