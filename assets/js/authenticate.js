function setCookie(name, value, time) {
  const expires = new Date();
  expires.setTime(expires.getTime() + time * 1000);
  const cookieString = `${name}=${encodeURIComponent(value)};expires=${expires.toUTCString()};path=/`;
  document.cookie = cookieString;
}

function deleteAllCookies() {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;";
    }
}

async function DangNhap() {
	const email = $("#email").val();
	const pwd = $("#password").val();
	
	const customKey = customText(32);
	
	if (email == undefined || email == "" || pwd == undefined || pwd == "") {
		toastr.error("Vui lòng điền đầy đủ thông tin", {timeOut: 3000});
		return;
	}
	
	const encrypted = await encryptData(JSON.stringify({
		'email': email,
		'password': pwd
	}), customKey);
	
	$.LoadingOverlay("show");
	
	$.post({
		url: `${url}/api/authenticate/login`,
		data: JSON.stringify({
			'd': encrypted,
			'k': customKey
		}),
		success: function (data) {
			console.log(data);
			
			
			toastr.success(data.desc, {timeOut: 3000});
			$.LoadingOverlay("hide");
			setCookie("d", data.access, data.e);
			setCookie("k", data.k, data.e);
			
			setTimeout(function() {
				window.location.href = `${url}`;
			}, 1000);
		},
		error: function (data, status, error) {
			const dataJson = data.responseJSON;
			$.LoadingOverlay("hide");
			toastr.error(dataJson.desc, {timeOut: 3000});
		}
	});
}

function DangXuat() {
	deleteAllCookies();
	
	setTimeout(function() {
		window.location.href = `${url}`;
	}, 2000);
}