const upReport = async () => {
	const PCroom = $('#room').val();
	const namePC = $('#PCName').val();
	const PCreason = $('#PCcontent').val();
	
	const customKey = customText(32);
	
	const encrypted = await encryptData(JSON.stringify({
		room: PCroom,
		pcname: namePC,
		reason: PCreason
	}), customKey);
	
	$.LoadingOverlay("show");
	
	$.post({
		url: `${url}/api/pc/report`,
		data: JSON.stringify({
			'd': encrypted,
			'k': customKey
		}),
		success: async (data) => {
			console.log(data);
			
			
			toastr.success(data.desc, {timeOut: 3000});
			$.LoadingOverlay("hide");
			
			$('#room').val("");
			$('#PCName').val("");
			$('#PCcontent').val("");
		},
		error: function (data, status, error) {
			const dataJson = data.responseJSON;
			$.LoadingOverlay("hide");
			toastr.error(dataJson.desc, {timeOut: 3000});
		}
    });
}