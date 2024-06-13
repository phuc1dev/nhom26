<?php
	include 'config.php';

	header('Content-Type: application/json');

	if(isset($_GET['start'])) {
		$monday = $_GET['start'];
		// Lấy dữ liệu lịch dạy từ cơ sở dữ liệu cho tuần hiện tại
		$sql = "SELECT giangvien.name, lichday.monhoc, lichday.thoigian, lichday.tiet_batdau, lichday.tiet_ketthuc , lichday.phong
				FROM lichday 
				INNER JOIN giangvien ON lichday.gvcode = giangvien.code
				WHERE ". (isAdmin() ? "" : "lichday.gvcode = '".getGVCode()."' AND") ." lichday.thoigian BETWEEN '$monday' AND DATE_ADD('$monday', INTERVAL 6 DAY)";
		$result = $ketnoi->query($sql);

		$events = [];
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$date = date('Y-m-d', strtotime($row["thoigian"]));
				$session = '';
				if ($row["tiet_batdau"] >= 1 && $row["tiet_batdau"] <= 6) {
					$session = 'sang';
				} elseif ($row["tiet_batdau"] >= 7 && $row["tiet_batdau"] <= 12) {
					$session = 'trua';
				} elseif ($row["tiet_batdau"] >= 13 && $row["tiet_batdau"] <= 15) {
					$session = 'toi';
				}
				$events[$date][$session][] = $row;
			}
		}

		// Hiển thị lịch
		echo '<table class="table table-bordered calendar mt-3">';
		echo '<thead>';
		echo '<tr>';
		echo '<th></th>';
		echo '<th>T2<br>'.date('d/m/Y', strtotime("+0 day", strtotime($monday))).'</th>';
		echo '<th>T3<br>'.date('d/m/Y', strtotime("+1 day", strtotime($monday))).'</th>';
		echo '<th>T4<br>'.date('d/m/Y', strtotime("+2 day", strtotime($monday))).'</th>';
		echo '<th>T5<br>'.date('d/m/Y', strtotime("+3 day", strtotime($monday))).'</th>';
		echo '<th>T6<br>'.date('d/m/Y', strtotime("+4 day", strtotime($monday))).'</th>';
		echo '<th>T7<br>'.date('d/m/Y', strtotime("+5 day", strtotime($monday))).'</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';

		// Hiển thị các buổi sáng
		echo '<tr>';
		echo '<th class="session-title">Sáng</th>';
		for ($i = 0; $i < 6; $i++) {
			$date = date('Y-m-d', strtotime("+$i day", strtotime($monday)));
			echo '<td>';
			if (isset($events[$date]['sang'])) {
				foreach ($events[$date]['sang'] as $event) {
					echo '<div class="event">';
					echo (isset($event["monhoc"]) ? "<strong>".$event["monhoc"]."</strong>" : 'N/A') . '<br>';
					echo 'Tiết: ' . (isset($event["tiet_batdau"]) ? $event["tiet_batdau"] : 'N/A') . ' - ' . (isset($event["tiet_ketthuc"]) ? $event["tiet_ketthuc"] : 'N/A') . '<br>';
					echo 'Phòng: ' . $event["phong"].'<br>';
					echo 'GV: ' . $event["name"];
					echo '</div>';
				}
			}
			echo '</td>';
		}
		echo '</tr>';

		// Hiển thị các buổi trưa
		echo '<tr>';
		echo '<th class="session-title">Trưa</th>';
		for ($i = 0; $i < 6; $i++) {
			$date = date('Y-m-d', strtotime("+$i day", strtotime($monday)));
			echo '<td>';
			if (isset($events[$date]['trua'])) {
				foreach ($events[$date]['trua'] as $event) {
					echo '<div class="event">';
					echo (isset($event["monhoc"]) ? "<strong>".$event["monhoc"]."</strong>" : 'N/A') . '<br>';
					echo 'Tiết: ' . (isset($event["tiet_batdau"]) ? $event["tiet_batdau"] : 'N/A') . ' - ' . (isset($event["tiet_ketthuc"]) ? $event["tiet_ketthuc"] : 'N/A') . '<br>';
					echo 'Phòng: ' . $event["phong"].'<br>';
					echo 'GV: ' . $event["name"];
					echo '</div>';
				}
			}
			echo '</td>';
		}
		echo '</tr>';

		// Hiển thị các buổi tối
		echo '<tr>';
		echo '<th class="session-title">Tối</th>';
		for ($i = 0; $i < 6; $i++) {
			$date = date('Y-m-d', strtotime("+$i day", strtotime($monday)));
			echo '<td>';
			if (isset($events[$date]['toi'])) {
				foreach ($events[$date]['toi'] as $event) {
					echo '<div class="event">';
					echo (isset($event["monhoc"]) ? "<strong>".$event["monhoc"]."</strong>" : 'N/A') . '<br>';
					echo 'Tiết: ' . (isset($event["tiet_batdau"]) ? $event["tiet_batdau"] : 'N/A') . ' - ' . (isset($event["tiet_ketthuc"]) ? $event["tiet_ketthuc"] : 'N/A') . '<br>';
					echo 'Phòng: ' . $event["phong"].'<br>';
					echo 'GV: ' . $event["name"];
					echo '</div>';
				}
			}
			echo '</td>';
		}
		echo '</tr>';

		echo '</tbody>';
		echo '</table>';
	} else {
		$monday = date('Y-m-d', strtotime('monday this week'));
		$saturday = date('Y-m-d', strtotime('saturday this week'));
		// Lấy dữ liệu lịch dạy từ cơ sở dữ liệu cho tuần hiện tại
		$sql = "SELECT giangvien.name, lichday.monhoc, lichday.thoigian, lichday.tiet_batdau, lichday.tiet_ketthuc , lichday.phong
				FROM lichday 
				INNER JOIN giangvien ON lichday.gvcode = giangvien.code
				WHERE ". (isAdmin() ? "" : "lichday.gvcode = '".getGVCode()."' AND") ." lichday.thoigian BETWEEN '$monday' AND '$saturday'";
		$result = $ketnoi->query($sql);

		$events = [];
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$date = date('Y-m-d', strtotime($row["thoigian"]));
				$session = '';
				if ($row["tiet_batdau"] >= 1 && $row["tiet_batdau"] <= 6) {
					$session = 'sang';
				} elseif ($row["tiet_batdau"] >= 7 && $row["tiet_batdau"] <= 12) {
					$session = 'trua';
				} elseif ($row["tiet_batdau"] >= 13 && $row["tiet_batdau"] <= 15) {
					$session = 'toi';
				}
				$events[$date][$session][] = $row;
			}
		}

		// Hiển thị lịch
		echo '<table class="table table-bordered calendar mt-3">';
		echo '<thead>';
		echo '<tr>';
		echo '<th></th>';
		echo '<th>T2<br>'.date('d/m/Y', strtotime("+0 day", strtotime($monday))).'</th>';
		echo '<th>T3<br>'.date('d/m/Y', strtotime("+1 day", strtotime($monday))).'</th>';
		echo '<th>T4<br>'.date('d/m/Y', strtotime("+2 day", strtotime($monday))).'</th>';
		echo '<th>T5<br>'.date('d/m/Y', strtotime("+3 day", strtotime($monday))).'</th>';
		echo '<th>T6<br>'.date('d/m/Y', strtotime("+4 day", strtotime($monday))).'</th>';
		echo '<th>T7<br>'.date('d/m/Y', strtotime("+5 day", strtotime($monday))).'</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';

		// Hiển thị các buổi sáng
		echo '<tr>';
		echo '<th class="session-title">Sáng</th>';
		for ($i = 0; $i < 6; $i++) {
			$date = date('Y-m-d', strtotime("+$i day", strtotime($monday)));
			echo '<td>';
			if (isset($events[$date]['sang'])) {
				foreach ($events[$date]['sang'] as $event) {
					echo '<div class="event">';
					echo (isset($event["monhoc"]) ? "<strong>".$event["monhoc"]."</strong>" : 'N/A') . '<br>';
					echo 'Tiết: ' . (isset($event["tiet_batdau"]) ? $event["tiet_batdau"] : 'N/A') . ' - ' . (isset($event["tiet_ketthuc"]) ? $event["tiet_ketthuc"] : 'N/A') . '<br>';
					echo 'Phòng: ' . $event["phong"].'<br>';
					echo 'GV: ' . $event["name"];
					echo '</div>';
				}
			}
			echo '</td>';
		}
		echo '</tr>';

		// Hiển thị các buổi trưa
		echo '<tr>';
		echo '<th class="session-title">Trưa</th>';
		for ($i = 0; $i < 6; $i++) {
			$date = date('Y-m-d', strtotime("+$i day", strtotime($monday)));
			echo '<td>';
			if (isset($events[$date]['trua'])) {
				foreach ($events[$date]['trua'] as $event) {
					echo '<div class="event">';
					echo (isset($event["monhoc"]) ? "<strong>".$event["monhoc"]."</strong>" : 'N/A') . '<br>';
					echo 'Tiết: ' . (isset($event["tiet_batdau"]) ? $event["tiet_batdau"] : 'N/A') . ' - ' . (isset($event["tiet_ketthuc"]) ? $event["tiet_ketthuc"] : 'N/A') . '<br>';
					echo 'Phòng: ' . $event["phong"].'<br>';
					echo 'GV: ' . $event["name"];
					echo '</div>';
				}
			}
			echo '</td>';
		}
		echo '</tr>';

		// Hiển thị các buổi tối
		echo '<tr>';
		echo '<th class="session-title">Tối</th>';
		for ($i = 0; $i < 6; $i++) {
			$date = date('Y-m-d', strtotime("+$i day", strtotime($monday)));
			echo '<td>';
			if (isset($events[$date]['toi'])) {
				foreach ($events[$date]['toi'] as $event) {
					echo '<div class="event">';
					echo (isset($event["monhoc"]) ? "<strong>".$event["monhoc"]."</strong>" : 'N/A') . '<br>';
					echo 'Tiết: ' . (isset($event["tiet_batdau"]) ? $event["tiet_batdau"] : 'N/A') . ' - ' . (isset($event["tiet_ketthuc"]) ? $event["tiet_ketthuc"] : 'N/A') . '<br>';
					echo 'Phòng: ' . $event["phong"].'<br>';
					echo 'GV: ' . $event["name"];
					echo '</div>';
				}
			}
			echo '</td>';
		}
		echo '</tr>';

		echo '</tbody>';
		echo '</table>';
	}
?>