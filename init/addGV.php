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
		
		if (!isset($dataObj["name"]) || $dataObj["name"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin. 6'
			]);
			exit;
		}
		
		if (!isset($dataObj["email"]) || $dataObj["email"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin. 5'
			]);
			exit;
		}
		
		if (!isset($dataObj["pwd"]) || $dataObj["pwd"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.4'
			]);
			exit;
		}
		
		if (!isset($dataObj["nganh"]) || $dataObj["nganh"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin. 3'
			]);
			exit;
		}
		
		if (!isset($dataObj["gioitinh"]) || $dataObj["gioitinh"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin. 2'
			]);
			exit;
		}
		
		if (!isset($dataObj["ngaysinh"]) || $dataObj["ngaysinh"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin. 1'
			]);
			exit;
		}
		
		$name = $dataObj["name"];
		$email = $dataObj["email"];
		$nganh = $dataObj["nganh"];
		$gioitinh = $dataObj["gioitinh"];
		$ngaysinh = $dataObj["ngaysinh"];
		$pwd = $dataObj["pwd"];
		
		
		$searchByEmail = $ketnoi->query("SELECT * FROM `giangvien` WHERE `EMAIL` = '{$email}'");
		
		if ($searchByEmail->num_rows > 0) {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => ' EMAIL_EXIST',
				'desc' => 'Email đã được sử dụng bởi giảng viên khác, vui lòng dùng email khác.'
			]);
			exit;
		}
		
		$getLastGV = $ketnoi->query("SELECT * FROM `giangvien` ORDER BY `ID` DESC LIMIT 1")->fetch_array();
		$gvcode = "GV".(str_pad($getLastGV['ID'] + 1, 4, "0", STR_PAD_LEFT));
		
		$hashedPwd = hash('sha256', $pwd);
		
		$ketnoi->query("INSERT INTO `giangvien` (`NAME`, `EMAIL`, `CODE`, `NGANH`, `GIOITINH`, `NGAYSINH`) VALUES ('{$name}', '{$email}', '{$gvcode}', '{$nganh}', '{$gioitinh}', '{$ngaysinh}')");
		$ketnoi->query("INSERT INTO `accounts` (`EMAIL`, `PASSWORD`) VALUES ('{$email}', '{$hashedPwd}')");
		
		echo jsonEncode([
			'success' => true,
			'type' => 'ADD_SUCCESS',
			'desc' => 'Thêm giảng viên thành công.'
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