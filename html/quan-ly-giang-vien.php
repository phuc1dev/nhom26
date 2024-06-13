<?php
	include '../init/config.php';
	
	if (!isLogin()) {
		header('Location: ./dang-nhap.html');
		exit();
	}
	
	if (!isAdmin()) {
		header('Location: /');
		exit();
	}
?>

<!DOCTYPE html>

<html
  lang="vi"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Nhóm 26 - Quản lý phòng máy tính</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
	<link rel="stylesheet" href="../assets/vendor/fonts/fontawesome.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
	
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
	<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
	
	<style>
		.calendar {
			table-layout: fixed;
			width: 100%;
		}
		.calendar th, .calendar td {
			vertical-align: top;
			padding: 10px;
			border: 1px solid #dee2e6;
			word-wrap: break-word; /* Giúp từ ngữ không tràn ra ngoài ô */
			width: 140px; /* Chiều rộng mặc định của mỗi ô */
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.calendar th {
			background-color: #f8f9fa;
			text-align: center;
		}
		.calendar .event {
			background-color: #d1ecf1;
			border: 1px solid #bee5eb;
			border-radius: 4px;
			padding: 5px;
			margin-bottom: 5px;
			font-size: 0.9em;
		}
		.session-title {
			width: 100px;
			background-color: #f8f9fa;
			vertical-align: middle;
			text-align: center;
			font-weight: bold;
		}

		@media (max-width: 768px) {
			.calendar thead {
				display: none;
			}
			.calendar, .calendar tbody, .calendar tr, .calendar td, .calendar th {
				display: block;
				width: 100%;
				box-sizing: border-box;
			}
			.calendar tr {
				margin-bottom: 10px;
				display: flex;
				flex-wrap: wrap;
			}
			.calendar th.session-title {
				width: 100%;
				text-align: left;
				background-color: #f8f9fa;
				font-weight: bold;
				border-bottom: 2px solid #dee2e6;
			}
			.calendar td {
				width: 100%;
				border: 1px solid #dee2e6;
			}
			.calendar td[data-label]:before {
				content: attr(data-label);
				display: block;
				font-weight: bold;
				margin-bottom: 5px;
			}
			.calendar td {
				padding-left: 20px;
				padding-right: 20px;
			}
			.calendar .event {
				padding: 5px;
				font-size: 0.85em;
			}
		}
    </style>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="/" class="app-brand-link">
              <span class="app-brand-logo demo">
                <svg
                  width="25"
                  viewBox="0 0 25 42"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink">
                  <defs>
                    <path
                      d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                      id="path-1"></path>
                    <path
                      d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                      id="path-3"></path>
                    <path
                      d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                      id="path-4"></path>
                    <path
                      d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                      id="path-5"></path>
                  </defs>
                  <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                      <g id="Icon" transform="translate(27.000000, 15.000000)">
                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                          <mask id="mask-2" fill="white">
                            <use xlink:href="#path-1"></use>
                          </mask>
                          <use fill="#696cff" xlink:href="#path-1"></use>
                          <g id="Path-3" mask="url(#mask-2)">
                            <use fill="#696cff" xlink:href="#path-3"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                          </g>
                          <g id="Path-4" mask="url(#mask-2)">
                            <use fill="#696cff" xlink:href="#path-4"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                          </g>
                        </g>
                        <g
                          id="Triangle"
                          transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                          <use fill="#696cff" xlink:href="#path-5"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </span>
              <span class="app-brand-text demo menu-text fw-bold ms-2" style="font-family: monospace; letter-spacing: 6px">phuc1dev</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">Tổng quan</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/" class="menu-link">
                    <div data-i18n="Analytics">Thống kê</div>
                  </a>
                </li>
              </ul>
            </li>

            <!-- Layouts -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Giảng viên</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="/dang-ky-phong-may.html" class="menu-link">
                    <div data-i18n="Without menu">Đăng ký phòng máy</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="/bao-cao-may-hong.html" class="menu-link">
                    <div data-i18n="Without navbar">Báo cáo máy hỏng</div>
                  </a>
                </li>
              </ul>
            </li>
			
			<?php
				if (isAdmin()) {
			?>
			<li class="menu-item active open">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div data-i18n="Layouts">Quản trị viên</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item active">
                  <a href="/quan-ly-giang-vien.html" class="menu-link">
                    <div data-i18n="Without menu">Quản lý giảng viên</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="/quan-ly-phong-may.html" class="menu-link">
                    <div data-i18n="Without navbar">Quản lý phòng máy</div>
                  </a>
                </li>
              </ul>
            </li>
			<?php
				}
			?>
			<li class="menu-item">
			  <a href="/html/ThuHai-Nhom26.pdf" target="_blank" class="menu-link">
				<i class="menu-icon tf-icons bx bx-file"></i>
				<div data-i18n="Documentation">Documentation</div>
			  </a>
			</li>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../assets/img/avatars/avt.jpg" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="../assets/img/avatars/avt.jpg" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-medium d-block"><?=getGVFullName()?></span>
                            <small class="text-muted"><?=isAdmin() ? "Administrator" : "Giảng viên";?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Thông tin cá nhân</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item cursor-pointer" onclick="DangXuat()">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Đăng xuất</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-sm-9 col-md-9 col-lg-9 mb-4 order-0">
				  <div class="col-12 mb-4">
					  <div class="card">
						<div class="d-flex align-items-end row">
						  <div class="col-sm-8">
							<div class="card-body">
							  <h5 class="card-title text-primary">Chào mừng <b><?=getGVFullName()?></b>! 🎉</h5>
							  <div class="container">
								<div class="row justify-content-center">
									<div class="col-md-2 col-lg-2 col-sm-12">
										<div class="d-flex justify-content-center align-items-sm-center gap-4 mb-2">
										  <img
											src="../assets/img/avatars/avt.jpg"
											alt="user-avatar"
											class="d-block rounded-circle"
											height="64"
											width="64"
											id="uploadedAvatar" />
										</div>
									</div>
									
									<div class="col-md-10 col-lg-10 col-sm-12">
										<div class="row">
											<label class="col-sm-7">Mã giảng viên: <b><?=getGVCode()?></b></label>
											<label class="col-sm-5">Giới tính: <b><?=getGVGender()?></b></label>
											
											<label class="col-sm-7">Họ tên: <b><?=getGVFullName()?></b></label>
											<label class="col-sm-5">Ngày sinh: <b><?=date("d/m/Y", strtotime(getGVBirthday()))?></b></label>
											
											<label class="col-sm-12">Ngành: <b><?=getGVSpecs()?></b></label>
										</div>
									</div>
								</div>
							  </div>
							</div>
						  </div>
						  <div class="col-sm-4 text-center text-sm-left">
							<div class="card-body pb-0 px-0 px-md-4">
							  <img
								src="../assets/img/illustrations/man-with-laptop-light.png"
								height="140"
								alt="View Badge User"
								data-app-dark-img="illustrations/man-with-laptop-dark.png"
								data-app-light-img="illustrations/man-with-laptop-light.png" />
							</div>
						  </div>
						  
						</div>
					</div>
                  </div>
				  
				  <div class="col-12">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title text-primary">
								<div class="pb-2 text-center">
									<b>QUẢN LÝ GIẢNG VIÊN</b>
									<hr>
								</div>
							</h5>
							<!-- Danh sách tài khoản liên kết -->
							<div class="mt-5">
								<div class="container">
									<div class="row justify-content-end pt-3">
										<div class="col-sm-4 col-md-4 col-lg-4">
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
													<input type="text" id="findByCode" class="form-control" placeholder="Tìm kiếm theo tên giảng viên" aria-describedby="basic-addon1">
												</div>
											</div>
										</div>
										
										<div class="col-sm-4 col-md-4 col-lg-4">
											<b style="font-size: 18px" onclick="AddModal()" class="badge bg-primary cursor-pointer text-white">
												<i class="fa-solid fa-user-plus"></i> Thêm giảng viên
											</b>
										</div>
									</div>
								</div>
								<div class="table-responsive pt-1">
									<table class="table table-hover align-items-center mb-0">
										<thead>
											<tr>
												<th class="align-middle text-center text-uppercase text-dark"></th>
												<th class="align-middle text-center text-uppercase text-dark"><b>Giảng viên</b></th>
												<th class="align-middle text-center text-center text-uppercase text-dark"><b>Mã GV</b></th>
												<th class="align-middle text-center text-center text-uppercase text-dark"><b>E-mail</b></th>
												<th class="align-middle text-center text-center text-uppercase text-dark"><b>Ngành</b></th>
											</tr>
										</thead>
										<tbody id="ShowCustomers">
										<?php
											$allCustomers = $ketnoi->query("SELECT * FROM `giangvien`");
											$customerCount = 0;
											while ($row = $allCustomers->fetch_array()) {
												$customerCount++;
												$gvCode = $row['CODE'];
												
												
												echo '
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
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				  </div>
                </div>
				
				<div class="col-sm-3 col-md-3 col-lg-3">
					<!-- Transactions -->
					<div class="col-md-12 col-lg-12 order-2 mb-4">
					  <div class="card h-100">
						<div class="card-header d-flex align-items-center justify-content-between">
						  <h5 class="card-title text-primary"><i class="fa-solid fa-toolbox"></i> Danh sách máy bảo trì</h5>
						</div>
						<div class="card-body">
						  <ul class="p-0 m-0">
							<?php
								$getAllMayBaoTri = $ketnoi->query("SELECT * FROM `maybaotri`");
								
								while ($row = $getAllMayBaoTri->fetch_array()) {
									echo '
									<li class="d-flex mb-4 pb-1">
									  <div class="avatar flex-shrink-0 me-3">
										<img src="../assets/img/icons/unicons/paypal.png" class="rounded" />
									  </div>
									  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
										<div class="me-2">
										  <h6 class="mb-0 mt-1">'.$row['ROOMCODE'].'-'.$row['PCNAME'].'</h6>
										  <small class="text-muted d-block mb-1">'.$row['NOTE'].'</small>
										</div>
									  </div>
									</li>
									';
								}
							?>
						  </ul>
						</div>
					  </div>
					</div>
                </div>
                <!-- Total Revenue -->
                
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-center py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  Copyright ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  <a class="footer-link fw-medium cursor-pointer">phuc1dev.top</a>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
			<div class="modal fade" id="modalAddLoader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Thêm thông tin giảng viên mới</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="alert alert-danger text-white mb-3" style="text-align: justify" role="alert" hidden id="AddAlertForm">
								<span id="AddAlertMessage"></span>
							</div>
							
							<div class="alert alert-success text-white mb-3" style="text-align: justify" role="alert" hidden id="AddAlert2Form">
								<span id="AddAlert2Message"></span>
							</div>

							<form role="form" autocomplete="off">
								<div class="container">
									<div class="row pt-3">
										<div class="col-sm-5 col-md-5 col-lg-5">
											<label class="form-control-label">Họ tên GV:</label>
										</div>
										<div class="col-sm-7 col-md-7 col-lg-7">
											<input realm-tag="AddGVName" class="form-control form-control-sm" placeholder="Điền họ tên giảng viên"/>
										</div>
									</div>

									<div class="row pt-3">
										<div class="col-sm-5 col-md-5 col-lg-5">
											<label class="form-control-label">Địa chỉ E-mail:</label>
										</div>
										<div class="col-sm-7 col-md-7 col-lg-7">
											<input realm-tag="AddGVEmail" class="form-control form-control-sm" placeholder="Điền địa chỉ email"/>
										</div>
									</div>
									
									<div class="row pt-3">
										<div class="col-sm-5 col-md-5 col-lg-5">
											<label class="form-control-label">Mật khẩu:</label>
										</div>
										<div class="col-sm-7 col-md-7 col-lg-7">
											<input realm-tag="AddGVPwd" class="form-control form-control-sm" placeholder="Điền mật khẩu đăng nhập"/>
										</div>
									</div>

									<div class="row pt-3">
										<div class="col-sm-5 col-md-5 col-lg-5">
											<label class="form-control-label">Ngành:</label>
										</div>
										<div class="col-sm-7 col-md-7 col-lg-7">
											<input realm-tag="AddGVNganh" class="form-control form-control-sm" placeholder="Điền ngành giảng dạy"/>
										</div>
									</div>
									
									<div class="row pt-3">
										<div class="col-sm-5 col-md-5 col-lg-5">
											<label class="form-control-label">Giới tính:</label>
										</div>
										<div class="col-sm-7 col-md-7 col-lg-7">
											<select realm-tag="AddGVGender" class="form-control form-control-sm">
												<option value="Nam">Nam</option>
												<option value="Nu">Nữ</option>
											</select>
										</div>
									</div>
									
									<div class="row pt-3">
										<div class="col-sm-5 col-md-5 col-lg-5">
											<label class="form-control-label">Ngày sinh:</label>
										</div>
										<div class="col-sm-7 col-md-7 col-lg-7">
											<input realm-tag="AddGVBirthday" type="text" class="form-control form-control-sm" id="datepicker" placeholder="Chọn ngày sinh">
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button onclick="AddGV()" type="button" class="btn btn-success">Thêm ngay</button>
						</div>
					</div>
				</div>
			</div>
		  
			<div class="modal fade" id="modalInfoLoader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="modalInfoTitle">Thông tin giảng viên:</h5>
							<button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="container">
								<div class="row justify-content-center">
									<div class="col-sm-8 col-md-8 col-lg-8">
										<div class="alert alert-danger text-white mb-3" style="text-align: justify" role="alert" hidden id="InfoAlertForm">
											<span id="InfoAlertMessage"></span>
										</div>
										
										<div class="alert alert-success text-white mb-3" style="text-align: justify" role="alert" hidden id="InfoAlert2Form">
											<span id="InfoAlert2Message"></span>
										</div>

										<form role="form" autocomplete="off">
											<div class="container">
												<div class="row pt-3">
												<div class="col-sm-5 col-md-5 col-lg-5">
														<label class="form-control-label">Tên giảng viên:</label>
													</div>
													<div class="col-sm-7 col-md-7 col-lg-7">
														<input realm-tag="InfoNameGV" class="form-control form-control-sm" placeholder="Điền tên giảng viên"/>
													</div>
												</div>
												
												<div class="row pt-3">
													<div class="col-sm-5 col-md-5 col-lg-5">
														<label class="form-control-label">Mã giảng viên:</label>
													</div>
													<div class="col-sm-7 col-md-7 col-lg-7">
														<input realm-tag="InfoCodeGV" class="form-control form-control-sm" placeholder="Điền mã giảng viên"/>
													</div>
												</div>

												<div class="row pt-3">
													<div class="col-sm-5 col-md-5 col-lg-5">
														<label class="form-control-label">E-mail:</label>
													</div>
													<div class="col-sm-7 col-md-7 col-lg-7">
														<input realm-tag="InfoEmailGV" class="form-control form-control-sm" placeholder="Điền địa chỉ email"/>
													</div>
												</div>
												
												<div class="row pt-3">
													<div class="col-sm-5 col-md-5 col-lg-5">
														<label class="form-control-label">Mật khẩu:</label>
													</div>
													<div class="col-sm-7 col-md-7 col-lg-7">
														<input realm-tag="InfoPassGV" class="form-control form-control-sm" placeholder="Điền mật khẩu mới"/>
													</div>
												</div>
												
												<div class="row pt-3">
													<div class="col-sm-5 col-md-5 col-lg-5">
														<label class="form-control-label">Ngành:</label>
													</div>
													<div class="col-sm-7 col-md-7 col-lg-7">
														<input realm-tag="InfoNganhGV" class="form-control form-control-sm" placeholder="Điền ngành dạy"/>
													</div>
												</div>
												
												<div class="row pt-3">
													<div class="col-sm-5 col-md-5 col-lg-5">
														<label class="form-control-label">Giới tính:</label>
													</div>
													<div class="col-sm-7 col-md-7 col-lg-7">
														<select realm-tag="InfoGenderGV" class="form-control form-control-sm">
															<option value="Nam">Nam</option>
															<option value="Nu">Nữ</option>
														</select>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="container">
								<div class="row">
									<div class="col-4">
										<button realm-tag="InfoDeleteBtn" type="button" class="btn btn-danger">Xoá</button>
									</div>
									<div class="col-4"></div>
									<div class="col-4 d-flex justify-content-end">
										<button realm-tag="InfoSaveBtn" type="button" class="btn btn-info">Lưu</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		  
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
	<script src="../assets/js/cryptjs.js?k=<?=time()?>"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
	<script src="../assets/js/administrator.js?k=<?=time()?>"></script>
	<script src="../assets/js/logout.js?k=<?=time()?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  </body>
</html>
