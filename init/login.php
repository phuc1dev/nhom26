<?php
	include 'config.php';

	header('Content-Type: application/json');
	
	function getClientIP() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		} else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
			$ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		} else if (isset($_SERVER['HTTP_FORWARDED'])) {
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		} else if (isset($_SERVER['REMOTE_ADDR'])) {
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		} else {
			$ipaddress = 'UNKNOWN';
		}
		return $ipaddress;
	}
	
	$ipv4 = getClientIP();
	
	$obj = json_decode(file_get_contents("php://input"), true);
	
	if ($obj === null && json_last_error() !== JSON_ERROR_NONE) {
		http_response_code(400);
		echo jsonEncode([
			'success' => false,
			'type' => 'NONE_PARAMETER_FOUND',
			'ip' => $ipv4,
			'desc' => 'Vui lòng điền đầy đủ thông tin.'
		]);
		exit;
	}
	
	if (!isset($obj["d"]) || $obj["d"] == "") {
		http_response_code(400);
		echo jsonEncode([
			'success' => false,
			'type' => 'NONE_PARAMETER_FOUND',
			'ip' => $ipv4,
			'desc' => 'Vui lòng điền đầy đủ thông tin.'
		]);
		exit;
	}
	
	if (!isset($obj["k"]) || $obj["k"] == "") {
		http_response_code(400);
		echo jsonEncode([
			'success' => false,
			'type' => 'NONE_PARAMETER_FOUND',
			'ip' => $ipv4,
			'desc' => 'Vui lòng điền đầy đủ thông tin.'
		]);
		exit;
	}
	
	$encrypted = $obj["d"];
	$k = $obj["k"];
	
	$decrypted = decryptData($encrypted, $k);
	
	if (isJson($decrypted)) {
		$dataObj = json_decode($decrypted, true);
		
		if (!isset($dataObj["email"]) || $dataObj["email"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'ip' => $ipv4,
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		if (!isset($dataObj["password"]) || $dataObj["password"] == "") {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'NONE_PARAMETER_FOUND',
				'ip' => $ipv4,
				'desc' => 'Vui lòng điền đầy đủ thông tin.'
			]);
			exit;
		}
		
		$email = $dataObj["email"];
		$pwd = hash('sha256', $dataObj["password"]);
		
		$searchAccount = $ketnoi->query("SELECT * FROM `accounts` WHERE `EMAIL` = '{$email}' AND `PASSWORD` = '{$pwd}'");
		
		if ($searchAccount->num_rows > 0) {
			$userData = $searchAccount->fetch_array();
			$selectByGV = $ketnoi->query("SELECT * FROM `giangvien` WHERE `EMAIL` = '{$email}'")->fetch_array();
			$secretKey = customText(64);
				
			$jwt = generateJwt([
				'id' => $selectByGV['ID'],
				'administrator' => $userData['ADMINISTRATOR'] == 1
			], $secretKey);
				
			echo jsonEncode([
				'success' => true,
				'type' => 'LOGIN_SUCCESS',
				'desc' => 'Đăng nhập thành công.',
				'access' => encryptData(json_encode([
					'd' => $jwt,
					'k' => $secretKey,
					'e' => time() + 3600
				]), $k),
				'k' => $k,
				'e' => 3600
			]);
		} else {
			http_response_code(400);
			echo jsonEncode([
				'success' => false,
				'type' => 'LOGIN_FAIL',
				'ip' => $ipv4,
				'desc' => 'Email hoặc mật khẩu không đúng.'
			]);
			exit;
		}
	} else {
		http_response_code(400);
		echo jsonEncode([
			'success' => false,
			'type' => ' INVALID_PARAMETERS',
			'ip' => $ipv4,
			'desc' => 'Vui lòng điền đầy đủ thông tin.'
		]);
		exit;
	}
?>