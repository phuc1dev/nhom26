$(function() {
	$( "#datepicker" ).datepicker({
		dateFormat: 'yy-mm-dd',
		showOtherMonths: true,
		selectOtherMonths: true
	});
});

const regCalendar = async (gvcode) => {
	const subject = $('#subjectName').val();
	const selectedDate = $('#datepicker').val();
	const selectedRoom = $('#room').val();
	const startPeriod = $('#startPeriod').val();
	const endPeriod = $('#endPeriod').val();
	
	const customKey = customText(32);
	
	const encrypted = await encryptData(JSON.stringify({
		'date': selectedDate,
		'room': selectedRoom,
		'gvcode': gvcode,
		'subject': subject,
		'start': startPeriod,
		'end': endPeriod
	}), customKey);
	
	$.LoadingOverlay("show");
	
	$.post({
		url: `${url}/api/timetable/reg`,
		data: JSON.stringify({
			'd': encrypted,
			'k': customKey
		}),
		success: async (data) => {
			console.log(data);
			
			
			toastr.success(data.desc, {timeOut: 3000});
			$.LoadingOverlay("hide");
			
			
			const periodTemplate = '<option value="" selected disabled></option>';
			
			$('#subjectName').val("");
			$('#datepicker').val("");
			$('#room').val("");
			$('#startPeriod').html(periodTemplate);
			$('#endPeriod').html(periodTemplate);
		},
		error: function (data, status, error) {
			const dataJson = data.responseJSON;
			$.LoadingOverlay("hide");
			toastr.error(dataJson.desc, {timeOut: 3000});
		}
    });
}

$(document).ready(function(){
	let periods = [];
	
	$('#startPeriod').change(() => {
		$.LoadingOverlay("show");
		var endArr = [1, 2, 4, 7, 8, 10, 11, 13, 14];
		
		const startChoosen = parseInt($('#startPeriod').val(), 10);
		
		endArr.push(startChoosen, startChoosen + 1);
		
		const tietSang = [1, 2, 3, 4, 5, 6];
		const tietTrua = [7, 8, 9, 10, 11, 12];
		const tietToi = [13, 14, 15];
		
		if (tietSang.includes(startChoosen)) {
			tietTrua.forEach(item => {
				endArr.push(item);
			});
			
			tietToi.forEach(item => {
				endArr.push(item);
			});
		} else if (tietTrua.includes(startChoosen)) {
			tietSang.forEach(item => {
				endArr.push(item);
			});
			
			tietToi.forEach(item => {
				endArr.push(item);
			});
		} else {
			tietSang.forEach(item => {
				endArr.push(item);
			});
			
			tietTrua.forEach(item => {
				endArr.push(item);
			});
		}
		
		var template2 = '<option value="" selected disabled></option>';
		
		for (const row of periods) {
			for (let i = row[0]; i <= row[1]; i++) {
				if (!endArr.includes(i) && i - row[0] >= 2) {
					template2 += `<option value="${i}">${i}</option>`;
				}
			}
		}
		
		$('#endPeriod').html(template2);
		$.LoadingOverlay("hide");
	});
	
    $('#datepicker, #room').change(async () => {
        if($('#datepicker').val() && $('#room').val()) {
            const selectedDate = $('#datepicker').val();
            const selectedRoom = $('#room').val();
			
			const customKey = customText(32);
			
			console.log(selectedDate + ":" + selectedRoom);
			
			const encrypted = await encryptData(JSON.stringify({
				'date': selectedDate,
				'room': selectedRoom
			}), customKey);
			
			$.LoadingOverlay("show");
			
			$.post({
				url: `${url}/api/timetable/check`,
				data: JSON.stringify({
					'd': encrypted,
					'k': customKey
				}),
				success: async (data) => {
					console.log(data);
					
					
					toastr.success(data.desc, {timeOut: 3000});
					$.LoadingOverlay("hide");
					
					
					const dataEncrypted = await decryptData(data.access, data.k);
					const dataObj = JSON.parse(dataEncrypted);
					
					console.log(dataObj);
					
					var template = '<option value="" selected disabled></option>';
					var template2 = '<option value="" selected disabled></option>';
					
					periods = dataObj.data;
					
					for (const row of periods) {
						for (let i = row[0]; i <= row[1]; i++) {
							const startArr = [3, 5, 6, 8, 9, 11, 12, 14, 15];
							if (!startArr.includes(i) && row[1] - i >= 2) {
								template += `<option value="${i}">${i}</option>`;
							}
						}
					}
					
					$('#startPeriod').html(template);
					$('#endPeriod').html(template2);
				},
				error: function (data, status, error) {
					const dataJson = data.responseJSON;
					$.LoadingOverlay("hide");
					toastr.error(dataJson.desc, {timeOut: 3000});
				}
			});
        }
    });
})