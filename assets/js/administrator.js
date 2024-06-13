OpenInfoModal = (data) => {
	data = JSON.parse(data);
	
	$('input[realm-tag="InfoNameGV"]').val(data.name);
	$('input[realm-tag="InfoCodeGV"]').val(data.code);
	$('input[realm-tag="InfoEmailGV"]').val(data.email);
	$('input[realm-tag="InfoNganhGV"]').val(data.nganh);
	$('select[realm-tag="InfoGenderGV"]').val(data.gender);
	
	$('button[realm-tag="InfoDeleteBtn"]').attr('onclick', 'DeleteGV(' + data.id + ')');
	$('button[realm-tag="InfoSaveBtn"]').attr('onclick', 'SaveGV({"id": ' + data.id + '})');
	$('#modalInfoLoader').modal('show');
}

var needReload = false;

const SaveGV = async (data) => {
    $.LoadingOverlay("show");
	
	const customKey = customText(32);
	
	const encrypted = await encryptData(JSON.stringify({
		"id": data.id,
		"name": $('input[realm-tag="InfoNameGV"]').val(),
		"gvcode": $('input[realm-tag="InfoCodeGV"]').val(),
		"email": $('input[realm-tag="InfoEmailGV"]').val(),
		"pwd": $('input[realm-tag="InfoPassGV"]').val(),
		"gioitinh": $('select[realm-tag="InfoGenderGV"]').val(),
		"nganh": $('input[realm-tag="InfoNganhGV"]').val()
	}), customKey);

	$.post({
		url: `${url}/api/admin/saveGV`,
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
				window.location.href = `${url}/quan-ly-giang-vien.html`;
			}, 2000);
		},
		error: function (obj, status, error) {
			var resp = obj.responseJSON;
			
			toastr.error(resp.desc, {timeOut: 5000})
		}
	});
	
	$.LoadingOverlay("hide");
}

const DeleteGV = async (id) => {
    $.LoadingOverlay("show");
	const customKey = customText(32);
	
	const encrypted = await encryptData(JSON.stringify({
		"id": id
	}), customKey);

	$.post({
		url: `${url}/api/admin/deleteGV`,
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
				window.location.href = `${url}/quan-ly-giang-vien.html`;
			}, 2000);
		},
		error: function (obj, status, error) {
			var resp = obj.responseJSON;
			
			toastr.error(resp.desc, {timeOut: 5000})
		}
	});
	
	$.LoadingOverlay("hide");
}

document.addEventListener("DOMContentLoaded", function() {
    var findByCode = document.getElementById("findByCode");
    var timerId;

    findByCode.addEventListener("input", function(event) {
        clearTimeout(timerId);

        timerId = setTimeout(function() {
            findCustomerByCode(event.target.value);
        }, 200);
    });
});

const findCustomerByCode = async (code) => {
	const customKey = customText(32);
	$.LoadingOverlay("show");
	const encrypted = await encryptData(JSON.stringify({
		"typing": code
	}), customKey);
	
	$.post({
		url: `${url}/api/admin/findByName`,
		headers: {
            "Content-Type": "application/json"
        },
		data: JSON.stringify({
			'd': encrypted,
			'k': customKey
		}),
		success: async (data) => {
			const dataEncrypted = await decryptData(data.access, data.k);
			const dataObj = JSON.parse(dataEncrypted);
					
			$('#ShowCustomers').html(dataObj.data);
		}
	});
	
	$.LoadingOverlay("hide");
}

$(function() {
	$( "#datepicker" ).datepicker({
		dateFormat: 'yy-mm-dd',
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true
	});
});

function AddModal() {
	$('#modalAddLoader').modal('show');
}

const AddGV = async () => {
	$.LoadingOverlay("show");
    const customKey = customText(32);
	
	const encrypted = await encryptData(JSON.stringify({
		"name": $('input[realm-tag="AddGVName"]').val(),
		"email": $('input[realm-tag="AddGVEmail"]').val(),
		"pwd": $('input[realm-tag="AddGVPwd"]').val(),
		"nganh": $('input[realm-tag="AddGVNganh"]').val(),
		"gioitinh": $('select[realm-tag="AddGVGender"]').val(),
		"ngaysinh": $('input[realm-tag="AddGVBirthday"]').val()
	}), customKey);
	
	console.log(JSON.stringify({
		"name": $('input[realm-tag="AddGVName"]').val(),
		"email": $('input[realm-tag="AddGVEmail"]').val(),
		"pwd": $('input[realm-tag="AddGVPwd"]').val(),
		"nganh": $('input[realm-tag="AddGVNganh"]').val(),
		"gioitinh": $('select[realm-tag="AddGVGender"]').val(),
		"ngaysinh": $('input[realm-tag="AddGVBirthday"]').val()
	}))
	
	$.post({
		url: `${url}/api/admin/addGV`,
		headers: {
            "Content-Type": "application/json"
        },
		data: JSON.stringify({
			'd': encrypted,
			'k': customKey
		}),
		success: async (data) => {
			
			$('input[realm-tag="AddGVName"]').val("");
			$('input[realm-tag="AddGVEmail"]').val("");
			$('input[realm-tag="AddGVPwd"]').val("");
			$('input[realm-tag="AddGVNganh"]').val("");
			$('select[realm-tag="AddGVGender"]').val("Nam");
			$('input[realm-tag="AddGVBirthday"]').val("");
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
			window.location.href = `${url}/quan-ly-giang-vien.html`;
		}
	});
});