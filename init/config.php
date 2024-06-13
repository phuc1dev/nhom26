<?php
	$ketnoi = new mysqli("localhost", "root", "", "nhom26");
	
	function customText($length) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$text = '';
		for ($i = 0; $i < $length; $i++) {
			$text .= $chars[rand(0, strlen($chars) - 1)];
		}
		return $text;
	}
	
	function hexToBin($hexStr) {
		$binStr = '';
		for ($i = 0; $i < strlen($hexStr); $i += 2) {
			$binStr .= chr(hexdec(substr($hexStr, $i, 2)));
		}
		return $binStr;
	}

	function binToHex($binStr) {
		$hexStr = '';
		for ($i = 0; $i < strlen($binStr); $i++) {
			$hexStr .= str_pad(dechex(ord($binStr[$i])), 2, '0', STR_PAD_LEFT);
		}
		return $hexStr;
	}

	function encryptData($data, $key) {
		$iv = random_bytes(16);
		$encryptedData = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
		return base64_encode(binToHex($iv) . binToHex($encryptedData));
	}

	function decryptData($encryptedData, $key) {
		$decodeBase64 = base64_decode($encryptedData);
		
		$iv = hexToBin(substr($decodeBase64, 0, 32));
		$encryptedDataBuffer = hexToBin(substr($decodeBase64, 32));
		$decryptedData = openssl_decrypt($encryptedDataBuffer, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
		return $decryptedData;
	}
	
	function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}
	
	function jsonEncode($param) {
		return json_encode($param, JSON_UNESCAPED_UNICODE);
	}
	
	function base64UrlEncode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	function base64UrlDecode($data) {
		return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
	}
	
	function generateJwt($payload, $secret) {
		$header = ['alg' => 'HS512', 'typ' => 'JWT'];
		$encodedHeader = base64UrlEncode(json_encode($header));
		$encodedPayload = base64UrlEncode(json_encode($payload));
		$signature = base64UrlEncode(hash_hmac('sha512', "$encodedHeader.$encodedPayload", $secret, true));
		$jwt = "$encodedHeader.$encodedPayload.$signature";
		return $jwt;
	}

	function decodeJwt($jwt, $secret) {
		list($encodedHeader, $encodedPayload, $signature) = explode('.', $jwt);
		$calculatedSignature = base64UrlEncode(hash_hmac('sha512', "$encodedHeader.$encodedPayload", $secret, true));

		if ($calculatedSignature !== $signature) {
			return 'INVALID_SIGNATURE';
		}

		$header = json_decode(base64UrlDecode($encodedHeader), true);
		$payload = json_decode(base64UrlDecode($encodedPayload), true);

		return $payload;
	}
	
	function isLogin() {
		if (isset($_COOKIE['d']) && isset($_COOKIE['k'])) {
			$obj = json_decode(decryptData($_COOKIE['d'], $_COOKIE['k']));
			$jwt = decodeJwt($obj->d, $obj->k);
			if ($obj->e > time()) {
				return true;
			}
		}
		return false;
	}
	
	function GetID() {
		if (isLogin()) {
			$obj = json_decode(decryptData($_COOKIE['d'], $_COOKIE['k']));
			$jwt = decodeJwt($obj->d, $obj->k);
			if ($obj->e > time()) {
				return $jwt['id'];
			}
		}
		return null;
	}
	
	function GetEmail() {
		global $ketnoi;
		$id = GetID();
		
		if ($id == null || $id == "") {
			return false;
		}
		
		$DataInfo = $ketnoi->query("SELECT * FROM `giangvien` WHERE `ID` = '{$id}'")->fetch_array();
		return $DataInfo['EMAIL'];
	}
	
	function isAdmin() {
		global $ketnoi;
		$id = GetID();
		
		if ($id == null || $id == "") {
			return false;
		}
		
		$DataInfo = $ketnoi->query("SELECT * FROM `accounts` WHERE `ID` = '{$id}'")->fetch_array();
		return $DataInfo['ADMINISTRATOR'] == 1;
	}
	
	function getGVFullName() {
		global $ketnoi;
		$email = GetEmail();
		
		if ($email == null || $email == "") {
			return false;
		}
		
		$DataInfo = $ketnoi->query("SELECT * FROM `giangvien` WHERE `EMAIL` = '{$email}'")->fetch_array();
		return $DataInfo['NAME'];
	}
	
	function getGVCode() {
		global $ketnoi;
		$email = GetEmail();
		
		if ($email == null || $email == "") {
			return false;
		}
		
		$DataInfo = $ketnoi->query("SELECT * FROM `giangvien` WHERE `EMAIL` = '{$email}'")->fetch_array();
		return $DataInfo['CODE'];
	}
	
	function getGVSpecs() {
		global $ketnoi;
		$email = GetEmail();
		
		if ($email == null || $email == "") {
			return false;
		}
		
		$DataInfo = $ketnoi->query("SELECT * FROM `giangvien` WHERE `EMAIL` = '{$email}'")->fetch_array();
		return $DataInfo['NGANH'];
	}
	
	function getGVGender() {
		global $ketnoi;
		$email = GetEmail();
		
		if ($email == null || $email == "") {
			return false;
		}
		
		$DataInfo = $ketnoi->query("SELECT * FROM `giangvien` WHERE `EMAIL` = '{$email}'")->fetch_array();
		return $DataInfo['GIOITINH'];
	}
	
	function getGVBirthday() {
		global $ketnoi;
		$email = GetEmail();
		
		if ($email == null || $email == "") {
			return false;
		}
		
		$DataInfo = $ketnoi->query("SELECT * FROM `giangvien` WHERE `EMAIL` = '{$email}'")->fetch_array();
		return $DataInfo['NGAYSINH'];
	}
?>