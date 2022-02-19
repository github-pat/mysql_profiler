<?php 
	include 'connect.php';

	try {
		$sql = "SELECT event_time, CAST(argument AS CHAR(2000)) query
				FROM  mysql.general_log 
				WHERE command_type = 'Query'
				AND event_time >= NOW()
				AND CAST(argument AS CHAR(2000)) <> 'set names utf8'
				AND SUBSTRING(CAST(argument AS CHAR(2000)), 1, 17) <> 'SELECT event_time'
				ORDER BY event_time DESC; TRUNCATE general_log;";
				
		$db = new db($_POST['host'], $_POST['port'], $_POST['user'], $_POST['pass']);
		$db = $db->connect();
		$stmt = $db->query($sql);
		$data = $stmt->fetchAll(PDO::FETCH_OBJ);

		if ($data) {
			echo json_encode(['Code'=> 200, "Data"=> $data]);
		}
		else{
			echo json_encode(['Code'=> 404, "Message"=> "No se encontraron datos"]);
		}
		$db = null;

		
	} catch (PDOException $e) {
		echo json_encode(['Code'=> $e->getCode(), 'Message'=> $e->getMessage().' in line '.$e->getLine()]);
	}

 ?>