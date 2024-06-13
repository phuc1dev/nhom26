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
		
		if (!isset($dataObj["gvcode"]) || $dataObj["gvcode"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["email"]) || $dataObj["email"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["name"]) || $dataObj["name"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["nganh"]) || $dataObj["nganh"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["gioitinh"]) || $dataObj["gioitinh"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["pwd"]) || $dataObj["pwd"] == "") {
			$pwd = "";
		} else {
			$pwd = $dataObj["pwd"];
		}
		
		$id = $dataObj["id"];
		$name = $dataObj["name"];
		$gvcode = $dataObj["gvcode"];
		$email = $dataObj["email"];
		$nganh = $dataObj["nganh"];
		$gioitinh = $dataObj["gioitinh"];
		
		$selOldEmail = $ketnoi->query("SELECT * FROM `giangvien` WHERE `ID` = {$id}")->fetch_array();
		
		if ($pwd != "") {
			$newpwd = hash('sha256', $pwd);
			$ketnoi->query("UPDATE `accounts` SET `PASSWORD` = '{$newpwd}' WHERE `EMAIL` = '".$selOldEmail['EMAIL']."'");
		}
		
		$ketnoi->query("UPDATE `accounts` SET `EMAIL` = '{$email}' WHERE `EMAIL` = '".$selOldEmail['EMAIL']."'");
		$ketnoi->query("UPDATE `giangvien` SET `NAME` = '{$name}', `NGANH` = '{$nganh}', `GIOITINH` = '{$gioitinh}', `EMAIL` = '".$email."', `CODE` = '{$gvcode}' WHERE `ID` = {$id}");
		
		$ketnoi->query("UPDATE `lichday` SET `GVCODE` = '{$gvcode}' WHERE `GVCODE` = '".$selOldEmail['CODE']."'");
		
		echo jsonEncode([
			'success' => true,
			'type' => 'UPDATE_SUCCESS',
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