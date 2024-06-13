OpenInfoModal = (data) => {
	data = JSON.parse(data);
	
	$('input[realm-tag="InfoRoomName"]').val(data.room);
	$('input[realm-tag="InfoRoomCode"]').val(data.code);
	$('input[realm-tag="InfoRoomAmount"]').val(data.amount);
	
	$('button[realm-tag="InfoDeleteBtn"]').attr('onclick', 'DeleteRoom(' + data.id + ')');
	$('button[realm-tag="InfoSaveBtn"]').attr('onclick', 'SaveRoom({"id": ' + data.id + '})');
	$('#modalInfoLoader').modal('show');
}

var needReload = false;

const SaveRoom = async (data) => {
    $.LoadingOverlay("show");
	
	const customKey = customText(32);
	
	const encrypted = await encryptData(JSON.stringify({
		"id": data.id,
		"room": $('input[realm-tag="InfoRoomName"]').val(),
		"code": $('input[realm-tag="InfoRoomCode"]').val(),
		"amount": $('input[realm-tag="InfoRoomAmount"]').val()
	}), customKey);

	$.post({
		url: `${url}/api/admin/saveRoom`,
		headers: {
            "Content-Type": "application/json"
        },
		dataType: "json",
		data: JSON.stringify({
			'd': encrypted,
			'k': customKey
		}),
		success: function (obj) {
			toastr.success(obj.desc, {timeOut: 5000})
			
			setTimeout(function() {
				window.location.href = `${url}/quan-ly-phong-may.html`;
			}, 2000);
		},
		error: function (obj, status, error) {
			var resp = obj.responseJSON;
			
			toastr.error(resp.desc, {timeOut: 5000})
		}
	});
	
	$.LoadingOverlay("hide");
}

const DeleteRoom = async (id) => {
    $.LoadingOverlay("show");
	const customKey = customText(32);
	
	const encrypted = await encryptData(JSON.stringify({
		"id": id
	}), customKey);

	$.post({
		url: `${url}/api/admin/deleteRoom`,
		headers: {
            "Content-Type": "application/json"
        },
		dataType: "json",
		data: JSON.stringify({
			'd': encrypted,
			'k': customKey
		}),
		success: function (obj) {
			toastr.success(obj.desc, {timeOut: 5000})
			
			setTimeout(function() {
				window.location.href = `${url}/quan-ly-phong-may.html`;
			}, 2000);
		},
		error: function (obj, status, error) {
			var resp = obj.responseJSON;
			
			toastr.error(resp.desc, {timeOut: 5000})
		}
	});
	
	$.LoadingOverlay("hide");
}

function AddModal() {
	$('#modalAddLoader').modal('show');
}

const AddRoom = async () => {
	$.LoadingOverlay("show");
    const customKey = customText(32);
	
	const encrypted = await encryptData(JSON.stringify({
		"room": $('input[realm-tag="AddRoomName"]').val(),
		"code": $('input[realm-tag="AddRoomCode"]').val(),
		"amount": $('input[realm-tag="AddRoomAmount"]').val()
	}), customKey);
	
	$.post({
		url: `${url}/api/admin/addRoom`,
		headers: {
            "Content-Type": "application/json"
        },
		data: JSON.stringify({
			'd': encrypted,
			'k': customKey
		}),
		success: async (data) => {
			
			$('input[realm-tag="AddRoomName"]').val("");
			$('input[realm-tag="AddRoomCode"]').val("");
			$('input[realm-tag="AddRoomAmount"]').val("");
			needReload = true;
			
			toastr.success(data.desc, {timeOut: 5000});
		},
		error: function (obj, status, error) {
			var resp = obj.responseJSON;
			
			toastr.error(resp.desc, {timeOut: 5000})
		}
	});
	
	$.LoadingOverlay("hide");
}

$(document).ready(function () {
    $('#modalAddLoader').on('hidden.bs.modal', function (e) {
		if (needReload) {
			window.location.href = `${url}/quan-ly-phong-may.html`;
		}
	});
});