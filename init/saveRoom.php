<?php
	include 'config.php';

	header('Content-Type: application/json');

	
	$obj = json_decode(file_get_contents("php://input"), true);
	
	if ($obj === null && json_last_error() !== JSON_ERROR_NONE) {
		http_response_code(400);
		echo jsonEncode([
			'success' => false,
			'type' => 'NONE_PARAMETER_FOUND',
			'desc' => 'Vui lòng điền đầy đủ thông tin 1.'
		]);
		exit;
	}
	
	if (!isset($obj["d"]) || $obj["d"] == "") {
		http_response_code(400);
		echo jsonEncode([
			'success' => false,
			'type' => 'NONE_PARAMETER_FOUND',
			'desc' => 'Vui lòng điền đầy đủ thông tin 2.'
		]);
		exit;
	}
	
	if (!isset($obj["k"]) || $obj["k"] == "") {
		http_response_code(400);
		echo jsonEncode([
			'success' => false,
			'type' => 'NONE_PARAMETER_FOUND',
			'desc' => 'Vui lòng điền đầy đủ thông tin 4.'
		]);
		exit;
	}
	
	$encrypted = $obj["d"];
	$k = $obj["k"];
	
	$decrypted = decryptData($encrypted, $k);
	
	if (isJson($decrypted)) {
		$dataObj = json_decode($decrypted, true);
		
		if (!isset($dataObj["id"]) || $dataObj["id"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["code"]) || $dataObj["code"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["room"]) || $dataObj["room"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["amount"]) || $dataObj["amount"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		$id = $dataObj["id"];
		$room = $dataObj["room"];
		$code = $dataObj["code"];
		$amount = $dataObj["amount"];
		
		$selOldRoom = $ketnoi->query("SELECT * FROM `phongmay` WHERE `ID` = {$id}")->fetch_array();
		
		
		$ketnoi->query("UPDATE `maybaotri` SET `ROOMCODE` = '{$code}' WHERE `ROOMCODE` = '".$selOldRoom['CODE']."'");
		$ketnoi->query("UPDATE `lichday` SET `PHONG` = '{$code}' WHERE `PHONG` = '".$selOldRoom['CODE']."'");
		
		$ketnoi->query("UPDATE `phongmay` SET `CODE` = '{$code}', `ROOM` = '{$room}', `AMOUNT` = {$amount} WHERE `CODE` = '".$selOldRoom['CODE']."'");
		
		echo jsonEncode([
			'success' => true,
			'type' => 'UPDATE_ROOM_SUCCESS',
			'desc' => 'Cập nhật thông tin thành công.'
		]);
	} else {
		http_response_code(400);
		echo jsonEncode([
			'success' => false,
			'type' => ' INVALID_PARAMETERS',
			'desc' => 'Vui lòng điền đầy đủ thông tin 3.'
		]);
		exit;
	}
?>