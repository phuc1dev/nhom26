var currentWeekOffset = 0;

function changeTimetable(offset) {
    currentWeekOffset += offset;
	
	var currentDate = moment.tz("Asia/Ho_Chi_Minh");
	var currentDay = currentDate.day(); // Lấy số thứ tự của ngày trong tuần (0 = Chủ Nhật, 1 = Thứ Hai, ..., 6 = Thứ Bảy)
	var mondayOffset = currentDay - 1; // Tính offset để điều chỉnh về ngày thứ Hai trong tuần hiện tại
	
	if (currentDay == 0) {
		mondayOffset = 6;
	}
	
	var currentMonday = currentDate.clone().subtract(mondayOffset, 'days');
	
	var newMonday = currentMonday.clone().add(currentWeekOffset, 'weeks');
	
    var formattedNewMonday = newMonday.format('YYYY-MM-DD');

    fetch(`${url}/api/timetable/load?start=` + formattedNewMonday)
		.then(response => response.text())
		.then(data => {
			$("#timetableLoader").html(data);
		})
		.catch(error => {
			console.error('Error:', error);
		});
}

changeTimetable(currentWeekOffset);