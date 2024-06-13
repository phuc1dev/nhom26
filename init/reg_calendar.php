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
		
		if (!isset($dataObj["date"]) || $dataObj["date"] == "") {
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
		
		if (!isset($dataObj["gvcode"]) || $dataObj["gvcode"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["subject"]) || $dataObj["subject"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["start"]) || $dataObj["start"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["end"]) || $dataObj["end"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		$date = $dataObj["date"];
		$room = $dataObj["room"];
		$gvcode = $dataObj["gvcode"];
		$subject = $dataObj["subject"];
		$start = $dataObj["start"];
		$end = $dataObj["end"];
		
		$ketnoi->query("INSERT INTO `lichday` (`GVCODE`, `MONHOC`, `PHONG`, `THOIGIAN`, `TIET_BATDAU`, `TIET_KETTHUC`) VALUES ('{$gvcode}', '{$subject}', '{$room}', '{$date}', {$start}, {$end})");
		
		echo jsonEncode([
			'success' => true,
			'type' => 'REGISTER_SUCCESS',
			'desc' => 'Đăng ký lịch thành công.'
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