<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>MySql Profiler</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body style="font-family: 'Arial';font-size: 14px;">
	<h1 style="text-align: center;">MySql Profiler</h1>
	<form style="width: 400px; margin: 50px auto; border: 1px solid #666;border-radius: 3px;padding: 30px;">
		<label style="padding: 5px">Host
			<input type="text" name="host" style="width:calc(100% - 10px); margin-bottom: 10px;" required />
		</label>
		<label style="padding: 5px">User
			<input type="text" name="user" style="width:calc(100% - 10px); margin-bottom: 10px;" required />
		</label>
		<label style="padding: 5px">Pass
			<input type="text" name="pass" style="width:calc(100% - 10px); margin-bottom: 10px;" required />
		</label>
		<label style="padding: 5px">Port
			<input type="number" name="port" min="0" style="width:80px; margin-bottom: 10px;" value="3306" required />
		</label><br>
		<button type="button" id="clear" style="float: right">Limpiar</button>
		<button type="button" id="pausar" style="float: right">Pausar</button>
		<input type="submit" style="float: right" value="Arrancar" />

		<br>
	</form>
	<table border="1" style="text-align: left;width: calc(100% - 20px); margin: auto">
		<thead>
			<tr>
				<th>event_time</th>
				<th>query</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>



<script type="text/javascript">
	var conn;
	$(document).ready(function() {
		$('form').on('submit', function(event) {
			event.preventDefault();
			conn = setInterval(Consultar, 500)
		});
		$('#pausar').on('click', function() {
			clearInterval(conn);
		});
		$('#clear').on('click', function() {
			$('tbody').html('');
		});
	});
	function Consultar() {
		var obj = {};
		obj.host = $('[name="host"]').val();
		obj.user = $('[name="user"]').val();
		obj.pass = $('[name="pass"]').val();
		obj.port = $('[name="port"]').val();
		$.ajax({
			url: 'controller.php',
			type: 'POST',
			dataType: 'JSON',
			data: obj,
		})
		.done(function(Json) {
			if (Json.Code == 200) {
				var tr = '';
				$.each(Json.Data, function(index, val) {
					 tr += '<tr>'+
					 			'<td>'+val.event_time+'</td>'+
					 			'<td>'+val.query+'</td>'+
					 		 '</tr>';
				});
				var Tbody = $('tbody')
				if (Tbody[0].children.length == 0) {
					Tbody.html(tr);
				}
				else{
					$(tr).insertBefore(Tbody.find('tr:first-child'))
				}
			}
			else if (Json.Code == 404) {}
			else{
				clearInterval(conn);
				alert(Json.Message);
			}
		})
		.fail(function(e) {
			clearInterval(conn);
			console.log(e);
		})

	}
</script>
</body>
</html>