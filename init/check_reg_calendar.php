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
		
		$date = $dataObj["date"];
		$room = $dataObj["room"];
		
		$searchLich = $ketnoi->query("SELECT * FROM `lichday` WHERE `PHONG` = '{$room}' AND `THOIGIAN` = '{$date}' ORDER BY `TIET_BATDAU`");
		
		if ($searchLich->num_rows > 0) {
			$empty_periods = array();
			$last_end = 0;
			
			while ($row = $searchLich->fetch_array()) {
				if ($row['TIET_BATDAU'] - $last_end >= 3) {
					if (!in_array($last_end + 1, [5, 6, 8, 11, 12, 14])) {
						array_push($empty_periods, [ $last_end + 1, $row['TIET_BATDAU'] - 1 ]);
					}
				}
				
				$last_end = $row['TIET_KETTHUC'];
			}
			
			if (15 - $last_end >= 3) {
				if (!in_array($last_end + 1, [5, 6, 8, 11, 12, 14])) {
					array_push($empty_periods, [$last_end + 1, 15]);
				}
			}
			
			echo jsonEncode([
				'success' => true,
				'type' => 'GET_SUCCESS',
				'desc' => 'Lấy lịch trống thành công.',
				'access' => encryptData(json_encode([
					'data' => $empty_periods
				]), $k),
				'k' => $k
			]);
		} else {
			echo jsonEncode([
				'success' => true,
				'type' => 'GET_SUCCESS',
				'desc' => 'Lấy lịch trống thành công.',
				'access' => encryptData(json_encode([
					'data' => [
						[1, 15]
					]
				]), $k),
				'k' => $k
			]);
		}
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