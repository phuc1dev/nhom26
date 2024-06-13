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
		
		if (!isset($dataObj["typing"]) || $dataObj["typing"] == "") {
            $typing = "";
        } else {
			$typing = $dataObj["typing"];
		}
		
		$allCustomers = $ketnoi->query("SELECT * FROM `giangvien` WHERE `NAME` LIKE '%{$typing}%'");
		$customerCount = 0;
		
		$templ = '';
		
		while ($row = $allCustomers->fetch_array()) {
			$customerCount++;
			$gvCode = $row['CODE'];
			
			
			$templ .= '
				<tr class="cursor-pointer" onclick=\'OpenInfoModal(`{"id": '.$row['ID'].', "code": "'.$row['CODE'].'", "name": "'.$row['NAME'].'", "email": "'.$row['EMAIL'].'", "nganh": "'.$row['NGANH'].'", "gender": "'.$row['GIOITINH'].'"}`)\'>
					<td class="align-middle text-center">
						<span class="text-secondary text-xs font-weight-bold">'.$customerCount.'</span>
					</td>
					
					<td class="align-middle text-center">
						<span class="text-secondary text-xs font-weight-bold">'.$row['NAME'].'</span>
					</td>
					
					<td class="align-middle text-center">
						<span class="text-secondary text-xs font-weight-bold">'.$row['CODE'].'</span>
					</td>
					
					<td class="align-middle text-center">
						<span class="text-secondary text-xs font-weight-bold">'.$row['EMAIL'].'</span>
					</td>
					
					<td class="align-middle text-center">
						<span class="text-secondary text-xs font-weight-bold">'.$row['NGANH'].'</span>
					</td>
				</tr>
			';
		}
		
		echo jsonEncode([
			'success' => true,
			'type' => 'FIND_SUCCESS',
			'desc' => 'Search thành công.',
			'access' => encryptData(json_encode([
				'data' => $templ
			]), $k),
			'k' => $k
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