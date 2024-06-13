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
		
		if (!isset($dataObj["room"]) || $dataObj["room"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin. 6'
			]);
			exit;
		}
		
		if (!isset($dataObj["code"]) || $dataObj["code"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin. 5'
			]);
			exit;
		}
		
		if (!isset($dataObj["amount"]) || $dataObj["amount"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.4'
			]);
			exit;
		}
		
		$room = $dataObj["room"];
		$code = $dataObj["code"];
		$amount = $dataObj["amount"];
		
		
		$searchByCode = $ketnoi->query("SELECT * FROM `phongmay` WHERE `CODE` = '{$code}'");
		
		if ($searchByCode->num_rows > 0) {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'CODE_EXIST',
				'desc' => 'Mã phòng máy đã tồn tại, vui lòng dùng mã khác.'
			]);
			exit;
		}
		
		$ketnoi->query("INSERT INTO `phongmay` (`ROOM`, `CODE`, `AMOUNT`) VALUES ('{$room}', '{$code}', '{$amount}')");
		
		echo jsonEncode([
			'success' => true,
			'type' => 'ADD_ROOM_SUCCESS',
			'desc' => 'Thêm phòng máy thành công.'
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