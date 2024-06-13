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
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["pcname"]) || $dataObj["pcname"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["reason"]) || $dataObj["reason"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		$room = $dataObj["room"];
		$pcname = $dataObj["pcname"];
		$reason = $dataObj["reason"];
		
		$ketnoi->query("INSERT INTO `maybaotri` (`ROOMCODE`, `PCNAME`, `NOTE`) VALUES ('{$room}', '{$pcname}', '{$reason}')");
		
		echo jsonEncode([
			'success' => true,
			'type' => 'REPORT_SUCCESS',
			'desc' => 'Báo cáo máy hỏng thành công.'
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