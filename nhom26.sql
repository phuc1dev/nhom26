-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 02, 2024 lúc 07:24 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `nhom26`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `accounts`
--

CREATE TABLE `accounts` (
  `ID` int(11) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `ADMINISTRATOR` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `accounts`
--

INSERT INTO `accounts` (`ID`, `EMAIL`, `PASSWORD`, `ADMINISTRATOR`) VALUES
(1, 'xyz.junomc@gmail.com', '5da178b111acbe02acb437fb28381b625c25e505bec7b2b20218e09027136e57', 0),
(2, 'hungmatlon2k3@gmail.com', 'd712de7409ac86bf83e8d373f28462f96ccce6ae4e3dd9961c875565aa4650eb', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giangvien`
--

CREATE TABLE `giangvien` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL COMMENT 'Tên giảng viên',
  `EMAIL` varchar(255) NOT NULL COMMENT 'Địa chỉ email',
  `CODE` varchar(255) NOT NULL COMMENT 'Mã giảng viên',
  `NGANH` varchar(255) NOT NULL COMMENT 'Ngành',
  `GIOITINH` varchar(255) NOT NULL COMMENT 'Giới tính',
  `NGAYSINH` date DEFAULT NULL COMMENT 'Ngày sinh'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giangvien`
--

INSERT INTO `giangvien` (`ID`, `NAME`, `EMAIL`, `CODE`, `NGANH`, `GIOITINH`, `NGAYSINH`) VALUES
(1, 'Nguyen Hoang Phuc', 'xyz.junomc@gmail.com', 'GV0001', 'An toàn thông tin', 'Nam', '2003-10-20'),
(2, 'Pham Tan Hung', 'hungmatlon2k3@gmail.com', 'GV0002', 'Quảng trị kinh doanh', 'Nam', '2003-11-09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichday`
--

CREATE TABLE `lichday` (
  `ID` int(11) NOT NULL,
  `GVCODE` varchar(255) NOT NULL COMMENT 'Mã giảng viên',
  `MONHOC` varchar(255) NOT NULL COMMENT 'Môn học',
  `PHONG` varchar(255) NOT NULL COMMENT 'Phòng học',
  `THOIGIAN` date NOT NULL COMMENT 'Thời gian',
  `TIET_BATDAU` int(11) NOT NULL COMMENT 'Tiết bắt đầu',
  `TIET_KETTHUC` int(11) NOT NULL COMMENT 'Tiết kết thúc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lichday`
--

INSERT INTO `lichday` (`ID`, `GVCODE`, `MONHOC`, `PHONG`, `THOIGIAN`, `TIET_BATDAU`, `TIET_KETTHUC`) VALUES
(1, 'GV0001', 'Lập trình mã nguồn mở', 'A101', '2024-05-28', 2, 6),
(2, 'GV0001', 'TH - Lập trình mã nguồn mở', 'A101', '2024-05-26', 7, 9),
(3, 'GV0002', 'Lập trình mạng', 'A203', '2024-05-29', 1, 3),
(4, 'GV0001', 'Thiết kế web', 'A104', '2024-05-31', 10, 12),
(5, 'GV0001', 'Anh văn 3', 'A204', '2024-06-03', 13, 15),
(6, 'GV0001', 'Nhập môn lập trình', 'A102', '2024-06-02', 7, 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `maybaotri`
--

CREATE TABLE `maybaotri` (
  `ID` int(11) NOT NULL,
  `ROOMCODE` varchar(255) NOT NULL COMMENT 'Mã phòng',
  `PCNAME` varchar(255) NOT NULL COMMENT 'Tên máy',
  `NOTE` varchar(255) NOT NULL COMMENT 'Ghi chú'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `maybaotri`
--

INSERT INTO `maybaotri` (`ID`, `ROOMCODE`, `PCNAME`, `NOTE`) VALUES
(1, 'A101', 'PC05', 'Không bật lên được'),
(2, 'A101', 'PC08', 'Hỏng bàn phím và chuột'),
(3, 'A101', 'PC27', 'Không thể kết nối với máy trạm'),
(4, 'A101', 'PC28', 'Không thể kết nối với máy trạm'),
(5, 'A101', 'PC33', 'Treo màn hình');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phongmay`
--

CREATE TABLE `phongmay` (
  `ID` int(11) NOT NULL,
  `ROOM` varchar(255) NOT NULL COMMENT 'Tên phòng',
  `CODE` varchar(255) NOT NULL COMMENT 'Mã phòng',
  `AMOUNT` int(11) NOT NULL COMMENT 'Số lượng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phongmay`
--

INSERT INTO `phongmay` (`ID`, `ROOM`, `CODE`, `AMOUNT`) VALUES
(1, 'Phòng máy 1', 'A101', 40),
(2, 'Phòng máy 2', 'A102', 45),
(3, 'Phòng máy 3', 'A103', 50);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `giangvien`
--
ALTER TABLE `giangvien`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `lichday`
--
ALTER TABLE `lichday`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `maybaotri`
--
ALTER TABLE `maybaotri`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `phongmay`
--
ALTER TABLE `phongmay`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `accounts`
--
ALTER TABLE `accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `giangvien`
--
ALTER TABLE `giangvien`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `lichday`
--
ALTER TABLE `lichday`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `maybaotri`
--
ALTER TABLE `maybaotri`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `phongmay`
--
ALTER TABLE `phongmay`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
