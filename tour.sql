-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 09, 2025 lúc 05:01 AM
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
-- Cơ sở dữ liệu: `tour`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `user_type` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action_type`, `description`, `user_type`, `created_at`) VALUES
(8, 27, 'login', 'Đăng nhập vào hệ thống', 'user', '2025-04-09 09:17:21'),
(9, 27, 'logout', 'Đăng xuất khỏi hệ thống', 'user', '2025-04-09 09:17:28'),
(11, 27, 'login', 'Đăng nhập vào hệ thống', 'user', '2025-04-09 09:20:54'),
(12, 27, 'login', 'Đăng nhập vào hệ thống', 'user', '2025-04-09 09:21:39'),
(13, 27, 'logout', 'Khách hàng đăng xuất khỏi hệ thống', 'user', '2025-04-09 09:21:41'),
(14, 1, 'login', 'Đăng nhập vào hệ thống', 'employees', '2025-04-09 09:21:53'),
(15, 1, 'logout', 'Nhân viên đăng xuất khỏi hệ thống', 'employees', '2025-04-09 09:21:59'),
(16, 1, 'login', 'Đăng nhập vào hệ thống', 'employees', '2025-04-09 09:38:56'),
(18, 1, 'update', 'Cập nhật tin tức', 'employees', '2025-04-09 09:43:21'),
(19, 1, 'Insert', 'Thêm tin tức', 'employees', '2025-04-09 09:45:17'),
(20, 1, 'Delete', 'Xóa tin tức', 'employees', '2025-04-09 09:46:29'),
(21, 1, 'logout', 'Nhân viên đăng xuất khỏi hệ thống', 'employees', '2025-04-09 09:46:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `Sr_no` int(11) NOT NULL,
  `Admin_name` varchar(255) NOT NULL,
  `Admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`Sr_no`, `Admin_name`, `Admin_password`) VALUES
(1, 'Phuc', '865a9bce9df0ab7b66cf52bafd19ee1a');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `assignment_tour`
--

CREATE TABLE `assignment_tour` (
  `idass` int(11) NOT NULL,
  `id_toursche` int(11) DEFAULT NULL,
  `employid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `assignment_tour`
--

INSERT INTO `assignment_tour` (`idass`, `id_toursche`, `employid`) VALUES
(36, 197, 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_details_ks`
--

CREATE TABLE `booking_details_ks` (
  `sr_no` int(11) NOT NULL,
  `Booking_id` int(11) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `total_pay` varchar(255) NOT NULL,
  `room_no` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `phonenum` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_details_ks`
--

INSERT INTO `booking_details_ks` (`sr_no`, `Booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phonenum`, `address`) VALUES
(1, 23, 'Deluxe room', '2400000', '5760000', '270', 'Phuc Hung', '0987389890', 'sssss'),
(2, 24, 'Deluxe room', '2400000', '5760000', '313', 'Phuc Hung', '0987389890', 'sssss');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_detail_tour`
--

CREATE TABLE `booking_detail_tour` (
  `Sr_no` int(11) NOT NULL,
  `Booking_id` int(11) NOT NULL,
  `Tour_name` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Total_pay` varchar(255) NOT NULL,
  `User_name` text NOT NULL,
  `Phone_num` text NOT NULL,
  `Address` text NOT NULL,
  `tenks` varchar(255) NOT NULL,
  `tienks` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_detail_tour`
--

INSERT INTO `booking_detail_tour` (`Sr_no`, `Booking_id`, `Tour_name`, `Price`, `Total_pay`, `User_name`, `Phone_num`, `Address`, `tenks`, `tienks`) VALUES
(116, 232, 'Phú Quốc', '4900000', '5895000', 'Phuc Hung', '0987389890', 'sssss', 'Aquasun Hotel', '1000000'),
(117, 233, 'Đà Nẵng', '2400000', '3105300', 'Phuc Hung', '0987389890', 'sssss', 'Aquasun Hotel', '1000000'),
(119, 235, 'Tour Mộc Châu - Sơn La', '2400000', '3400000', 'Phuc Hung', '0987389890', 'sssss', 'Aquasun Hotel', '1000000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_orderks`
--

CREATE TABLE `booking_orderks` (
  `Booking_id` int(11) NOT NULL,
  `Room_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Check_in` date NOT NULL,
  `Check_out` date NOT NULL,
  `Refund` int(11) NOT NULL,
  `Booking_status` varchar(255) NOT NULL,
  `Payment_status` varchar(255) NOT NULL,
  `Datetime` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_orderks`
--

INSERT INTO `booking_orderks` (`Booking_id`, `Room_id`, `User_id`, `Check_in`, `Check_out`, `Refund`, `Booking_status`, `Payment_status`, `Datetime`, `created_at`) VALUES
(23, 9, 1, '2025-01-16', '2025-01-20', 0, '2', '2', '2025-01-17', '2025-03-03 13:30:37'),
(24, 9, 1, '2025-01-19', '2025-01-20', 1, '1', '1', '2025-01-17', '2025-03-03 13:30:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_ordertour`
--

CREATE TABLE `booking_ordertour` (
  `Booking_id` int(11) NOT NULL,
  `User_id` int(11) DEFAULT NULL,
  `Tour_id` int(11) NOT NULL,
  `Departure_id` int(11) NOT NULL,
  `Arrival` varchar(255) NOT NULL,
  `Booking_status` varchar(255) NOT NULL,
  `Payment_status` varchar(255) NOT NULL,
  `refund` int(11) NOT NULL,
  `Datetime` date NOT NULL,
  `participants` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_ordertour`
--

INSERT INTO `booking_ordertour` (`Booking_id`, `User_id`, `Tour_id`, `Departure_id`, `Arrival`, `Booking_status`, `Payment_status`, `refund`, `Datetime`, `participants`, `created_at`) VALUES
(232, 1, 50, 69, 'Xe khách', '2', '2', 0, '2025-04-13', 1, '2025-04-07 09:29:19'),
(233, 1, 47, 54, 'Máy bay', '2', '2', 0, '2025-05-14', 1, '2025-04-07 09:32:43'),
(235, 1, 54, 182, 'Xe khách', '2', '1', 0, '2025-05-04', 1, '2025-04-08 13:03:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carousel`
--

CREATE TABLE `carousel` (
  `Sr_no` int(11) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `adminSr_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` int(11) NOT NULL,
  `room_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `Action` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chat_rooms`
--

INSERT INTO `chat_rooms` (`id`, `room_id`, `user_id`, `employee_id`, `Action`, `created_at`) VALUES
(9, 'room_67e214b03a6d1', 1, 2, 0, '2025-03-25 02:28:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_details`
--

CREATE TABLE `contact_details` (
  `Sr_no` int(11) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` int(11) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Iname` varchar(255) DEFAULT NULL,
  `adminSr_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_assignment`
--

CREATE TABLE `customer_assignment` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer_assignment`
--

INSERT INTO `customer_assignment` (`id`, `customer_id`, `employee_id`, `assigned_at`) VALUES
(18, 1, 2, '2025-03-14 09:53:21'),
(21, 12, 9, '2025-03-14 10:27:48'),
(22, 13, 9, '2025-03-15 03:08:38'),
(24, 17, 9, '2025-04-01 01:08:09'),
(25, 20, 11, '2025-04-02 10:04:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departure_dates`
--

CREATE TABLE `departure_dates` (
  `id` int(11) NOT NULL,
  `tour_id` int(11) DEFAULT NULL,
  `departure_date` date NOT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departure_dates`
--

INSERT INTO `departure_dates` (`id`, `tour_id`, `departure_date`, `is_available`) VALUES
(58, 47, '2025-04-08', 1),
(70, 50, '2025-04-13', 1),
(92, 57, '2025-04-16', 1),
(96, 59, '2025-07-10', 1),
(98, 59, '2025-04-18', 1),
(115, 64, '2025-04-07', 1),
(117, 46, '2025-05-09', 1),
(121, 46, '2025-04-20', 1),
(122, 46, '2025-04-18', 1),
(123, 48, '2025-05-01', 1),
(124, 48, '2025-04-27', 1),
(125, 49, '2025-05-03', 1),
(126, 52, '2025-04-18', 1),
(127, 52, '2025-04-30', 1),
(128, 52, '2025-05-01', 1),
(129, 47, '2025-05-14', 1),
(130, 47, '2025-06-11', 1),
(131, 47, '2025-12-19', 1),
(132, 46, '2025-12-19', 1),
(133, 48, '2025-12-26', 1),
(134, 49, '2025-12-25', 1),
(135, 49, '2025-07-11', 1),
(136, 50, '2025-12-12', 1),
(137, 50, '2025-07-17', 1),
(138, 51, '2025-07-10', 1),
(139, 51, '2025-06-05', 1),
(140, 51, '2025-12-26', 1),
(141, 52, '2025-12-31', 1),
(142, 52, '2025-09-17', 1),
(143, 64, '2025-06-12', 1),
(144, 64, '2025-07-11', 1),
(145, 64, '2025-12-24', 1),
(146, 63, '2025-04-30', 1),
(147, 63, '2025-07-18', 1),
(148, 63, '2025-12-10', 1),
(149, 62, '2025-04-30', 1),
(150, 62, '2025-05-02', 1),
(151, 62, '2025-11-01', 1),
(152, 62, '2025-12-20', 1),
(153, 61, '2025-04-30', 1),
(154, 61, '2025-05-11', 1),
(155, 61, '2025-12-20', 1),
(156, 60, '2025-04-24', 1),
(157, 60, '2025-05-04', 1),
(158, 60, '2025-05-11', 1),
(159, 60, '2025-12-20', 1),
(160, 60, '2025-10-16', 1),
(161, 58, '2025-04-29', 1),
(162, 58, '2025-05-07', 1),
(163, 58, '2025-07-17', 1),
(164, 58, '2025-12-20', 1),
(165, 57, '2025-09-12', 1),
(166, 57, '2025-12-09', 1),
(167, 53, '2025-04-25', 1),
(168, 53, '2025-06-20', 1),
(169, 53, '2025-12-27', 1),
(170, 54, '2025-04-16', 1),
(171, 54, '2025-07-18', 1),
(172, 54, '2025-05-04', 1),
(173, 54, '2025-12-20', 1),
(174, 55, '2025-04-23', 1),
(175, 55, '2025-06-13', 1),
(176, 55, '2025-07-11', 1),
(177, 55, '2025-11-21', 1),
(178, 56, '2025-04-17', 1),
(179, 56, '2025-04-30', 1),
(180, 56, '2025-05-09', 1),
(181, 56, '2025-06-20', 1),
(182, 56, '2025-10-22', 1),
(183, 59, '2025-04-25', 1),
(184, 59, '2025-05-02', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departure_time`
--

CREATE TABLE `departure_time` (
  `id` int(11) NOT NULL,
  `id_tour` int(11) DEFAULT NULL,
  `Day_depart` varchar(255) DEFAULT NULL,
  `ngaykhoihanh` date DEFAULT NULL,
  `Orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departure_time`
--

INSERT INTO `departure_time` (`id`, `id_tour`, `Day_depart`, `ngaykhoihanh`, `Orders`) VALUES
(54, 47, '2 ngày 1 đêm', '2025-04-08', 2),
(69, 50, '5 ngày 4 đêm', '2025-04-13', 2),
(98, 57, '1 ngày', '2025-04-16', 0),
(104, 59, '3 ngày 2 đêm', '2025-07-10', 0),
(106, 59, '3 ngày 2 đêm', '2025-04-18', 0),
(128, 64, '4 ngày 3 đêm', '2025-04-07', 0),
(133, 46, '2 ngày 1 đêm', '2025-04-20', 0),
(134, 46, '2 ngày 1 đêm', '2025-04-18', 0),
(135, 48, '2 ngày 1 đêm', '2025-05-01', 0),
(136, 48, '2 ngày 1 đêm', '2025-04-27', 0),
(137, 49, '3 ngày 2 đêm', '2025-05-03', 0),
(138, 52, '3 ngày 2 đêm', '2025-04-18', 0),
(139, 52, '3 ngày 2 đêm', '2025-04-30', 0),
(140, 52, '3 ngày 2 đêm', '2025-05-01', 2),
(141, 47, '2 ngày 1 đêm', '2025-05-14', 1),
(142, 47, '2 ngày 1 đêm', '2025-06-11', 0),
(143, 47, '2 ngày 1 đêm', '2025-12-19', 0),
(144, 46, '2 ngày 1 đêm', '2025-12-19', 0),
(145, 48, '2 ngày 1 đêm', '2025-12-26', 0),
(146, 49, '3 ngày 2 đêm', '2025-12-25', 0),
(147, 49, '3 ngày 2 đêm', '2025-07-11', 0),
(148, 50, '5 ngày 4 đêm', '2025-12-12', 0),
(149, 50, '5 ngày 4 đêm', '2025-07-17', 0),
(150, 51, '4 ngày 3 đêm', '2025-07-10', 0),
(151, 51, '4 ngày 3 đêm', '2025-06-05', 0),
(152, 51, '4 ngày 3 đêm', '2025-12-26', 0),
(153, 52, '3 ngày 2 đêm', '2025-12-31', 0),
(154, 52, '3 ngày 2 đêm', '2025-09-17', 0),
(155, 64, '4 ngày 3 đêm', '2025-06-12', 0),
(156, 64, '4 ngày 3 đêm', '2025-07-11', 0),
(157, 64, '4 ngày 3 đêm', '2025-12-24', 0),
(158, 63, '7 ngày 6 đêm', '2025-04-30', 0),
(159, 63, '7 ngày 6 đêm', '2025-07-18', 0),
(160, 63, '7 ngày 6 đêm', '2025-12-10', 0),
(161, 62, '6 ngày 5 đêm', '2025-04-30', 0),
(162, 62, '6 ngày 5 đêm', '2025-05-02', 0),
(163, 62, '6 ngày 5 đêm', '2025-11-01', 0),
(164, 62, '6 ngày 5 đêm', '2025-12-20', 0),
(165, 61, '5 ngày 4 đêm', '2025-04-30', 0),
(166, 61, '5 ngày 4 đêm', '2025-05-11', 0),
(167, 61, '5 ngày 4 đêm', '2025-12-20', 0),
(168, 60, '2 ngày 1 đêm', '2025-04-24', 0),
(169, 60, '2 ngày 1 đêm', '2025-05-04', 0),
(170, 60, '2 ngày 1 đêm', '2025-05-11', 0),
(171, 60, '2 ngày 1 đêm', '2025-12-20', 0),
(172, 60, '2 ngày 1 đêm', '2025-10-16', 0),
(173, 58, '2 ngày 1 đêm', '2025-04-29', 0),
(174, 58, '2 ngày 1 đêm', '2025-05-07', 0),
(175, 58, '2 ngày 1 đêm', '2025-07-17', 0),
(176, 58, '2 ngày 1 đêm', '2025-12-20', 0),
(177, 57, '1 ngày', '2025-09-12', 0),
(178, 57, '1 ngày', '2025-12-09', 0),
(179, 53, '2 ngày 1 đêm', '2025-04-25', 0),
(180, 53, '2 ngày 1 đêm', '2025-06-20', 0),
(181, 53, '2 ngày 1 đêm', '2025-12-27', 0),
(182, 54, '2 ngày 1 đêm', '2025-04-16', -1),
(183, 54, '2 ngày 1 đêm', '2025-07-18', -1),
(184, 54, '2 ngày 1 đêm', '2025-05-04', 1),
(185, 54, '2 ngày 1 đêm', '2025-12-20', -1),
(186, 55, '3 ngày 2 đêm', '2025-04-23', 0),
(187, 55, '3 ngày 2 đêm', '2025-06-13', 0),
(188, 55, '3 ngày 2 đêm', '2025-07-11', 0),
(189, 55, '3 ngày 2 đêm', '2025-11-21', 0),
(190, 56, '1 ngày', '2025-04-17', 0),
(191, 56, '1 ngày', '2025-04-30', 0),
(192, 56, '1 ngày', '2025-05-09', 0),
(193, 56, '1 ngày', '2025-06-20', 0),
(194, 56, '1 ngày', '2025-10-22', 0),
(195, 59, '3 ngày 2 đêm', '2025-04-25', 0),
(196, 59, '3 ngày 2 đêm', '2025-05-02', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `deposit_hotel`
--

CREATE TABLE `deposit_hotel` (
  `id` int(11) NOT NULL,
  `id_depart` int(11) DEFAULT NULL,
  `Name_hotel` text DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `Quantity` float DEFAULT NULL,
  `Check_in` date DEFAULT NULL,
  `Check_out` date DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `vehicle_plate` varchar(20) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `drivers`
--

INSERT INTO `drivers` (`driver_id`, `name`, `phone`, `email`, `vehicle_type`, `vehicle_plate`, `status`, `created_at`) VALUES
(1, 'Nguyễn Văn A', '0987654321', 'nguyenvana@gmail.com', 'Xe khách', '51G-12345', 'Active', '2025-03-19 00:48:36'),
(2, 'Trần Thị B', '0912345678', 'tranthib@example.com', 'Xe khách', '52H-67890', 'Active', '2025-03-19 00:48:36'),
(3, 'Lê Văn C', '0909123456', 'levanc@example.com', 'Xe khách', '53K-11223', 'Inactive', '2025-03-19 00:48:36'),
(4, 'Phạm Văn D', '0934567890', 'phamvand@example.com', 'Máy bay', '54M-44556', 'Active', '2025-03-19 00:48:36'),
(5, 'Hoàng Thị E', '0971234567', 'hoangthie@example.com', 'Du thuyền', '55N-77889', 'Active', '2025-03-19 00:48:36'),
(48, 'Đinh Văn F', '0939998888', 'dinhvanf@gmail.com', 'Xe khách', '50D-99001', 'Active', '2025-03-19 04:20:30'),
(49, 'Bùi Văn G', '0921112222', 'buivang@gmail.com', 'Xe khách', '50E-33445', 'Active', '2025-03-19 05:00:00'),
(50, 'Ngô Văn H', '0916667777', 'ngovanh@gmail.com', 'Xe khách', '51F-55667', 'Inactive', '2025-03-19 05:45:18'),
(51, 'Vũ Văn I', '0903334444', 'vuvani@gmail.com', 'Xe khách', '50G-77889', 'Active', '2025-03-19 06:25:40'),
(52, 'Dương Văn K', '0898889999', 'duongvank@gmail.com', 'Xe khách', '51H-99012', 'Active', '2025-03-19 07:10:05'),
(53, 'Nguyễn Văn L', '0887776666', 'nguyenvanl@gmail.com', 'Xe khách', '51I-11234', 'Inactive', '2025-03-19 08:30:20'),
(54, 'Trần Văn M', '0876665555', 'tranvanm@gmail.com', 'Xe khách', '50J-55678', 'Active', '2025-03-19 09:00:50'),
(55, 'Lê Văn N', '0865554444', 'levann@gmail.com', 'Xe khách', '50K-77890', 'Active', '2025-03-19 09:45:12'),
(56, 'Phạm Văn O', '0854443333', 'phamvano@gmail.com', 'Xe khách', '51L-99023', 'Active', '2025-03-19 10:30:40'),
(57, 'Hoàng Văn P', '0843332222', 'hoangvanp@gmail.com', 'Xe khách', '50M-11245', 'Inactive', '2025-03-19 11:15:05'),
(58, 'Đinh Văn Q', '0832221111', 'dinhvanq@gmail.com', 'Xe khách', '51N-33456', 'Active', '2025-03-19 12:00:30'),
(59, 'Bùi Văn R', '0821110000', 'buivanr@gmail.com', 'Xe khách', '50O-55678', 'Active', '2025-03-19 12:45:10'),
(60, 'Ngô Văn S', '0810009999', 'ngovans@gmail.com', 'Xe khách', '51P-77890', 'Active', '2025-03-19 13:30:50'),
(61, 'Vũ Văn T', '0809998888', 'vuvant@gmail.com', 'Xe khách', '50Q-99034', 'Inactive', '2025-03-19 14:15:25'),
(62, 'Dương Văn U', '0798887777', 'duongvanu@gmail.com', 'Xe khách', '51R-11256', 'Active', '2025-03-19 15:00:00'),
(63, 'Nguyễn Văn V', '0787776666', 'nguyenvanv@gmail.com', 'Xe khách', '50S-33467', 'Active', '2025-03-19 15:45:12'),
(64, 'Trần Văn W', '0776665555', 'tranvanw@gmail.com', 'Xe khách', '51T-55678', 'Active', '2025-03-19 16:30:40'),
(65, 'Lê Văn X', '0765554444', 'levanx@gmail.com', 'Xe khách', '50U-77890', 'Inactive', '2025-03-19 17:15:05'),
(66, 'Phạm Văn Y', '0754443333', 'phamvany@gmail.com', 'Xe khách', '51V-99045', 'Active', '2025-03-19 18:00:30'),
(67, 'Hoàng Văn Z', '0743332222', 'hoangvanz@gmail.com', 'Xe khách', '50W-11278', 'Active', '2025-03-19 18:45:10'),
(68, 'Đinh Văn AA', '0732221111', 'dinhvanaa@gmail.com', 'Xe khách', '51X-33489', 'Active', '2025-03-19 19:30:50'),
(69, 'Bùi Văn BB', '0721110000', 'buivanbb@gmail.com', 'Xe khách', '50Y-55690', 'Inactive', '2025-03-19 20:15:25'),
(70, 'Ngô Văn CC', '0710009999', 'ngovancc@gmail.com', 'Xe khách', '51Z-77891', 'Active', '2025-03-19 21:00:00'),
(71, 'Vũ Văn DD', '0709998888', 'vuvandd@gmail.com', 'Xe khách', '50AA-99056', 'Active', '2025-03-19 21:45:12'),
(72, 'Dương Văn EE', '0698887777', 'duongvanee@gmail.com', 'Xe khách', '51BB-11290', 'Active', '2025-03-19 22:30:40'),
(73, 'Nguyễn Văn FF', '0687776666', 'nguyenvanff@gmail.com', 'Xe khách', '50CC-33412', 'Inactive', '2025-03-19 23:15:05'),
(74, 'Trần Văn GG', '0676665555', 'tranvangg@gmail.com', 'Xe khách', '51DD-55634', 'Active', '2025-03-20 00:00:30'),
(75, 'Lê Văn HH', '0665554444', 'levanhh@gmail.com', 'Xe khách', '50EE-77856', 'Active', '2025-03-20 00:45:10'),
(76, 'Phạm Văn II', '0654443333', 'phamvanii@gmail.com', 'Xe khách', '51FF-99078', 'Active', '2025-03-20 01:30:50'),
(77, 'Hoàng Văn JJ', '0643332222', 'hoangvanjj@gmail.com', 'Xe khách', '50GG-11290', 'Active', '2025-03-20 02:15:25'),
(78, 'Đinh Văn KK', '0632221111', 'dinhvankk@gmail.com', 'Xe khách', '51HH-33412', 'Inactive', '2025-03-20 03:00:00'),
(79, 'Bùi Văn LL', '0621110000', 'buivanll@gmail.com', 'Xe khách', '50II-55634', 'Active', '2025-03-20 03:45:12'),
(80, 'Ngô Văn MM', '0610009999', 'ngovanmm@gmail.com', 'Xe khách', '51JJ-77856', 'Active', '2025-03-20 04:30:40'),
(81, 'Vũ Văn NN', '0609998888', 'vuvannn@gmail.com', 'Xe khách', '50KK-99078', 'Inactive', '2025-03-20 05:15:05'),
(82, 'Dương Văn OO', '0598887777', 'duongvanoo@gmail.com', 'Xe khách', '51LL-11234', 'Active', '2025-03-20 06:00:30'),
(83, 'Nguyễn Văn PP', '0587776666', 'nguyenvanpp@gmail.com', 'Xe khách', '50MM-33445', 'Active', '2025-03-20 06:45:10'),
(84, 'Trần Văn QQ', '0576665555', 'tranvanqq@gmail.com', 'Xe khách', '51NN-55678', 'Active', '2025-03-20 07:30:50'),
(85, 'Lê Văn RR', '0565554444', 'levanrr@gmail.com', 'Xe khách', '50OO-77890', 'Inactive', '2025-03-20 08:15:25'),
(86, 'Phạm Văn SS', '0554443333', 'phamvanss@gmail.com', 'Xe khách', '51PP-99012', 'Active', '2025-03-20 09:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `Employee_code` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone_number` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Permissions` enum('QL','CSKH','HDV') NOT NULL,
  `Created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employees`
--

INSERT INTO `employees` (`id`, `Employee_code`, `Name`, `Username`, `Password`, `Email`, `Phone_number`, `Address`, `Permissions`, `Created_at`) VALUES
(1, 'NV1', 'NV1', 'NV1', '8c2e36e3cdf14ba19ba69db346b4fd4f', 'NV1@gmail.com', '0976889999', 'NV1', 'QL', '2025-03-11'),
(2, 'NV2', 'NV2', 'NV2', 'f3b5124e0a3c80acff2e15ad64d4860b', 'NV2@gmail.com', '0738939003', 'sjfnjkasn', 'CSKH', '2025-01-03'),
(3, 'NV3', 'NV3', 'NV3', 'fd23bdb93d20ed16f1f7293e2b6ad6ad', 'NV3@gmail.com', '0978478389', 'NV3', 'HDV', '2025-01-11'),
(7, 'NV4', 'NV4', 'NV4', 'fc36a43b3c227816a575a54c451a87a7', 'NV4@gmail.com', '0783993893', 'NV4', 'HDV', '2025-01-13'),
(8, 'Phú', 'Phú', 'Phú', 'e6354b14257db8ac7760967c51d04a96', 'sv@gmail.com', '0757564567', 'ádknasdnkjasndđs', 'HDV', '2025-03-10'),
(9, 'NV6', 'NV6', 'NV6', '22bc78e39a11ee3834f1fcaa09c59dee', 'NV6@gmail.com', '0757564567', 'ádknasdnkjasndđs', 'CSKH', '2024-03-08'),
(10, 'QLNV9', 'NV9', 'NV9', '64730b8e3578cc2d327d6e59b451aa9b', 'NV9@gmail.com', '0736282900', 'SAFAS', 'QL', '2025-03-20'),
(11, 'CSNV5', 'NV5', 'NV5', '5a7ed5b2b0b57c3ac01da4e0853bf778', 'NV5@gmail.com', '0704678654', 'TP Hồ Chí Minh', 'CSKH', '2025-03-20'),
(12, 'HDNV8', 'NV8', 'NV8', 'd8a2c8ccdd578f416808e866664b6dea', 'NV8@gmail.com', '0763728782', 'Gò Vấp', 'HDV', '2025-03-20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `facilities`
--

INSERT INTO `facilities` (`id`, `Name`, `Description`) VALUES
(1, 'Bể bơi', 'Bể bơi ngoài trời rộng rãi, có thể sử dụng quanh năm.'),
(2, 'Phòng gym', 'Phòng gym với đầy đủ thiết bị tập luyện cho mọi nhu cầu.'),
(3, 'Khu vực BBQ', 'Khu vực ngoài trời dành cho các buổi tiệc BBQ, có bàn ghế và bếp nướng.'),
(4, 'Dịch vụ phòng', 'Dịch vụ phòng 24/7, phục vụ các nhu cầu ăn uống và vệ sinh.'),
(5, 'Khu vực vui chơi trẻ em', 'Khu vực an toàn và vui nhộn cho trẻ em, bao gồm cầu trượt và xích đu.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `features`
--

INSERT INTO `features` (`id`, `Name`) VALUES
(1, 'Có cửa sổ'),
(2, 'Máy lạnh'),
(3, 'Nội thất đầy đủ'),
(4, 'Khu vực làm việc'),
(5, 'Wifi miễn phí');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `subject`, `message`, `admin_id`, `created_at`) VALUES
(1, 'ss', 'dvtc@gmail.com', 'ss', 'ss', NULL, '2025-01-09 08:46:19'),
(2, 'ss', 'sss@gmail.com', 'ss', 'ss', NULL, '2025-01-09 08:46:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `room_id` varchar(50) NOT NULL,
  `sender_type` enum('user','guide') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `room_id`, `sender_type`, `message`, `created_at`, `is_read`) VALUES
(75, 1, 2, 'room_67e214b03a6d1', 'user', 'd', '2025-03-25 02:28:08', 0),
(76, 1, 2, 'room_67e214b03a6d1', 'user', 'sss', '2025-03-25 02:28:20', 0),
(77, 1, 2, 'room_67e214b03a6d1', 'guide', 'XXX', '2025-03-25 02:28:41', 0),
(78, 1, 2, 'room_67e214b03a6d1', 'user', 'x', '2025-04-01 10:17:34', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `dereption` text NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `video` varchar(255) NOT NULL,
  `Published_at` date DEFAULT NULL,
  `employeesId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `Title`, `dereption`, `Image`, `Content`, `video`, `Published_at`, `employeesId`) VALUES
(2, 'Khám phá kỳ quan thế giới tại Việt Nam\r\nViệt Nam tự hào với nhiều kỳ quan thiên nhiên được công nhận trên toàn thế giới.', '1. Lên kế hoạch và đặt trước\r\nLên kế hoạch sớm giúp bạn có thời gian so sánh giá và đặt vé máy bay, khách sạn, hoặc tour du lịch với mức giá ưu đãi nhất. Các ưu đãi và giảm giá thường xuất hiện khi bạn đặt trước từ vài tháng, đặc biệt vào những dịp thấp điểm du lịch.\r\n\r\n2. Chọn phương tiện di chuyển tiết kiệm\r\nNgoài việc sử dụng máy bay giá rẻ, bạn cũng có thể cân nhắc các phương tiện như tàu, xe buýt hoặc xe khách. Những phương tiện này không chỉ tiết kiệm chi phí mà còn mang đến trải nghiệm thú vị về văn hóa địa phương.\r\n\r\n3. Ăn uống địa phương thay vì nhà hàng du lịch\r\nThay vì ăn tại các nhà hàng dành cho khách du lịch, bạn có thể thử các quán ăn bình dân của người dân địa phương. Giá cả tại các quán này thường rẻ hơn nhiều và bạn còn có thể thưởng thức những món ăn độc đáo, truyền thống.\r\n\r\n4. Tận dụng các chương trình giảm giá và ưu đãi\r\nNhiều địa điểm du lịch, bảo tàng, hoặc công viên giải trí cung cấp các chương trình giảm giá vào những ngày nhất định trong tuần hoặc cho khách du lịch theo nhóm. Hãy tìm hiểu trước và lên kế hoạch tham quan vào những thời điểm này để tiết kiệm chi phí.\r\n\r\n5. Chọn những điểm đến ít đông đúc\r\nThay vì đến những điểm du lịch nổi tiếng, bạn có thể lựa chọn các địa điểm ít người biết đến. Những nơi này không chỉ rẻ hơn mà còn giúp bạn tránh khỏi cảnh đông đúc, quá tải, mang đến trải nghiệm yên bình và thú vị hơn.\r\n\r\nHy vọng với những mẹo này, bạn sẽ có một chuyến du lịch đáng nhớ mà không phải lo lắng về chi phí!', 'gallery-3.jpg', 'Việt Nam là điểm đến lý tưởng với phong cảnh thiên nhiên tuyệt đẹp, từ Vịnh Hạ Long đến động Phong Nha. Đây là nơi bạn có thể trải nghiệm vẻ đẹp hùng vĩ và văn hóa độc đáo của đất nước hình chữ S.', 'MZarE7xP6rk', '2025-04-06', 1),
(3, '5 mẹo du lịch tiết kiệm chi ph.,Học cách tiết kiệm khi đi du lịch mà vẫn tận hưởng trọn vẹn hành trình.', '1. Lên kế hoạch và đặt trước\r\nViệc lên kế hoạch du lịch sớm giúp bạn tiết kiệm chi phí cho các dịch vụ như vé máy bay, khách sạn và các hoạt động tham quan. Đặt vé máy bay và phòng khách sạn trước ít nhất 1-2 tháng sẽ giúp bạn tìm được các ưu đãi hấp dẫn và tránh tình trạng giá tăng vào giờ chót.\r\n\r\n2. Chọn phương tiện di chuyển giá rẻ\r\nThay vì lựa chọn các hãng hàng không đắt đỏ, bạn có thể tham khảo các chuyến bay giá rẻ hoặc các phương tiện như tàu hỏa, xe buýt, hoặc xe thuê. Những phương tiện này thường có chi phí thấp hơn, đặc biệt khi bạn di chuyển trong các khu vực gần nhau.\r\n\r\n3. Ở trong các hostel hoặc nhà nghỉ\r\nKhách sạn 5 sao có thể mang đến trải nghiệm sang trọng, nhưng giá cả lại rất cao. Thay vào đó, bạn có thể chọn ở trong các hostel hoặc nhà nghỉ bình dân. Đây không chỉ là giải pháp tiết kiệm chi phí mà còn giúp bạn kết nối với những du khách khác, tạo ra những trải nghiệm thú vị.\r\n\r\n4. Ăn uống tại các quán địa phương\r\nĂn tại các nhà hàng cao cấp hoặc khu vực du lịch nổi tiếng sẽ khiến chi phí ăn uống của bạn tăng lên đáng kể. Hãy thử ăn tại các quán ăn địa phương, nơi bạn có thể thưởng thức những món ăn đặc sản với giá cả hợp lý hơn rất nhiều.\r\n\r\n5. Tận dụng các ưu đãi và khuyến mãi\r\nTrước chuyến đi, hãy tìm hiểu và sử dụng các ưu đãi du lịch như thẻ giảm giá, combo vé tham quan hoặc các chương trình khuyến mãi từ các công ty du lịch. Nhiều bảo tàng, công viên, hay điểm tham quan cũng có giảm giá vào những ngày đặc biệt hoặc cho nhóm đông người.\r\n\r\nVới những mẹo trên, bạn có thể có một chuyến du lịch thú vị mà không lo bị vượt quá ngân sách!', 'gallery-2.jpg', 'Du lịch không nhất thiết phải tốn kém. Chúng tôi chia sẻ những mẹo hữu ích giúp bạn tiết kiệm từ việc chọn thời điểm đặt vé, tìm khách sạn giá rẻ, đến các phương án ăn uống và mua sắm hợp lý.', 'MVrwPSTW5Vo', '2025-04-06', 1),
(4, 'Top 10 điểm đến không thể bỏ qua năm 2025', 'Toulouse, Pháp\r\nThành phố này nổi tiếng với cảnh quan sông Garonne thơ mộng và nền văn hóa nghệ thuật phong phú. Toulouse được đánh giá là điểm đến lý tưởng cho kỳ nghỉ cuối tuần hoàn hảo. \r\nNYPOST\r\n\r\nCameroon\r\nVới bãi biển đẹp, công viên quốc gia ít người biết đến và cuộc sống về đêm sôi động, Cameroon là điểm đến hấp dẫn cho những ai tìm kiếm trải nghiệm mới mẻ. \r\nNYPOST\r\n\r\nLow Country và Coastal Georgia, Hoa Kỳ\r\nKhu vực này nổi tiếng với lịch sử phong phú và nền ẩm thực đa dạng, đặc biệt là các món ăn hải sản tươi ngon. \r\nNYPOST\r\n\r\nBoise, Idaho\r\nThành phố này kết hợp giữa di sản công nghiệp và văn hóa thủ công, mang đến trải nghiệm độc đáo cho du khách. \r\nNYPOST\r\n\r\nMount Hood và Columbia River Gorge, Oregon, Hoa Kỳ\r\nVới cảnh quan thiên nhiên hùng vĩ, khu vực này là thiên đường cho những ai yêu thích hoạt động ngoài trời như leo núi và đi bộ đường dài. \r\nNYPOST\r\n\r\nReykjavik, Iceland\r\nThủ đô của Iceland nổi tiếng với cảnh quan thiên nhiên độc đáo và các hoạt động như ngắm cực quang và tắm suối nước nóng. \r\nCRYSTAL BAY\r\n\r\nSiwa Oasis, Ai Cập\r\nNằm ở sa mạc phía tây Ai Cập, Siwa Oasis là điểm đến ít người biết đến với cảnh quan sa mạc hùng vĩ và nền văn hóa độc đáo. \r\nCRYSTAL BAY\r\n\r\nTasmania, Úc\r\nVới vẻ đẹp hoang sơ và nền văn hóa phong phú, Tasmania là điểm đến lý tưởng cho những ai yêu thích thiên nhiên và khám phá. \r\nVOGUE\r\n\r\nKyoto, Nhật Bản\r\nThành phố này nổi tiếng với các đền chùa cổ kính và mùa hoa anh đào nở rộ, mang đến trải nghiệm văn hóa độc đáo. \r\nVOGUE\r\n\r\nInner Hebrides, Scotland\r\nQuần đảo này ít người biết đến với cảnh quan thiên nhiên hoang sơ và nền văn hóa Scotland đặc trưng. \r\nVOGUE\r\n\r\nPatmos, Hy Lạp\r\nHòn đảo này nổi tiếng với lịch sử lâu dài và cảnh quan biển đẹp, là điểm đến lý tưởng cho những ai tìm kiếm sự yên bình. \r\nVOGUE\r\n\r\nHy vọng danh sách trên sẽ giúp bạn lựa chọn được điểm đến phù hợp cho chuyến du lịch trong năm 2025.', 'gallery-4.jpg', 'Từ các thành phố sôi động đến những vùng đất yên bình, năm 2025 mang đến cơ hội khám phá những địa điểm tuyệt vời. Danh sách này bao gồm các địa danh nổi bật trên toàn cầu, hứa hẹn tạo nên những kỷ niệm đáng nhớ.', 'oguOqdI8Fhs', '2025-04-06', 1),
(5, 'Làm thế nào để có một chuyến đi an toàn?Những lưu ý quan trọng để đảm bảo an toàn trong mỗi chuyến hành trình.', '1. Lên kế hoạch chi tiết\r\nTìm hiểu về điểm đến: Trước khi đi, nghiên cứu về địa điểm bạn sẽ đến, bao gồm các vấn đề an ninh, khí hậu, văn hóa, và các quy định địa phương.\r\nThực hiện đăng ký thông tin chuyến đi: Nếu đi nước ngoài, bạn có thể đăng ký thông tin chuyến đi tại đại sứ quán hoặc lãnh sự quán để nhận hỗ trợ nếu cần.\r\n2. Mua bảo hiểm du lịch\r\nBảo hiểm y tế và tai nạn: Mua bảo hiểm du lịch bao gồm bảo hiểm y tế, bảo hiểm tai nạn và mất hành lý. Điều này giúp bạn tránh những chi phí phát sinh bất ngờ trong trường hợp xảy ra sự cố.\r\n3. Giữ an toàn tài sản\r\nMang ít tiền mặt: Chỉ mang một ít tiền mặt và sử dụng thẻ tín dụng hoặc thẻ ghi nợ để thanh toán khi cần.\r\nGiữ tài sản an toàn: Sử dụng túi xách hoặc ba lô chống trộm và luôn giữ đồ đạc quan trọng (hộ chiếu, tiền bạc, thẻ tín dụng) bên mình hoặc trong két sắt tại khách sạn.\r\n4. Tuân thủ các quy định an ninh\r\nKiểm tra tình hình an ninh địa phương: Trước khi đi, tìm hiểu xem có bất kỳ cảnh báo an ninh hoặc tình hình khẩn cấp nào ở địa phương không.\r\nTuân thủ các quy định về an ninh tại sân bay: Đảm bảo bạn tuân thủ các quy định về hành lý xách tay và không mang theo các vật phẩm bị cấm.\r\n5. Sức khỏe trong chuyến đi\r\nMang theo thuốc cần thiết: Nếu bạn có bệnh lý hoặc cần thuốc đặc biệt, hãy mang theo đủ thuốc và các giấy tờ liên quan.\r\nCập nhật tiêm phòng: Đảm bảo bạn đã tiêm phòng đầy đủ theo yêu cầu của quốc gia bạn đến, đặc biệt là khi đi du lịch tới các khu vực có nguy cơ cao (ví dụ: sốt xuất huyết, sốt rét).\r\n6. Giữ liên lạc thường xuyên\r\nChia sẻ kế hoạch chuyến đi: Chia sẻ với người thân, bạn bè về lịch trình chuyến đi, nơi bạn ở và các số điện thoại khẩn cấp.\r\nMạng di động và kết nối: Đảm bảo bạn có phương thức liên lạc với gia đình và bạn bè trong trường hợp cần thiết.\r\n7. Chú ý khi di chuyển\r\nSử dụng phương tiện công cộng an toàn: Khi di chuyển trong thành phố, hãy chọn phương tiện công cộng hoặc taxi uy tín. Tránh di chuyển một mình vào ban đêm ở những khu vực vắng vẻ.\r\nCảnh giác với lừa đảo: Cảnh giác với các hình thức lừa đảo, đặc biệt là khi đi du lịch một mình hoặc tới những nơi đông đúc.\r\n8. Giữ sức khỏe thể chất và tinh thần\r\nUống đủ nước và ăn uống hợp lý: Tránh ăn thực phẩm không rõ nguồn gốc, và luôn uống đủ nước để duy trì sức khỏe.\r\nNghỉ ngơi đầy đủ: Chuyến đi sẽ thú vị hơn nếu bạn nghỉ ngơi đầy đủ, đặc biệt là khi tham gia các hoạt động ngoài trời hoặc du lịch mạo hiểm.\r\nBằng cách chuẩn bị tốt và tuân thủ các lời khuyên trên, bạn sẽ có một chuyến đi an toàn và tận hưởng trọn vẹn hành trình của mình.', 'gallery-5.jpg', 'An toàn là yếu tố hàng đầu khi đi du lịch. Bài viết cung cấp các lời khuyên thiết thực để bạn luôn an tâm trên mọi hành trình, từ việc chuẩn bị hành lý đến cách ứng phó khi gặp sự cố bất ngờ.g', 'NSnkb1IAjbE', '2025-04-06', 1),
(8, 'Xu Hướng Du Lịch 2025: Những Tour Hot Nhất Trong Năm', 'Du lịch năm 2025 đang chứng kiến sự thay đổi mạnh mẽ với các xu hướng mới, từ những điểm đến độc đáo đến những trải nghiệm du lịch bền vững. Hãy cùng khám phá những tour hot nhất trong năm mà bạn không nên bỏ lỡ!\r\n\r\n1. Du Lịch Trải Nghiệm Sinh Thái - Côn Đảo\r\n\r\n\r\nCôn Đảo ngày càng trở thành điểm đến thu hút với vẻ đẹp hoang sơ, biển xanh trong và hệ sinh thái phong phú. Du khách có thể tham gia các hoạt động như lặn biển ngắm san hô, thăm rừng nguyên sinh và tìm hiểu lịch sử tại nhà tù Côn Đảo.\r\n\r\n2. Tour Cao Nguyên Mộc Châu - Khám Phá Vùng Đất Hoa\r\n\r\n\r\nMộc Châu không chỉ nổi tiếng với những đồi chè xanh bát ngát mà còn là thiên đường của các loài hoa nở quanh năm. Tháng 1-3 là mùa hoa mận, hoa đào khoe sắc rực rỡ, tạo nên bức tranh thiên nhiên tuyệt đẹp.\r\n\r\n3. Du Lịch Cao Cấp Tại Maldives\r\n\r\n\r\nMaldives vẫn giữ vững vị trí là điểm đến du lịch nghỉ dưỡng sang trọng hàng đầu thế giới. Những biệt thự trên mặt nước, bãi biển cát trắng và dịch vụ 5 sao là lựa chọn lý tưởng cho kỳ nghỉ xa hoa.\r\n\r\n4. Hành Trình Khám Phá Nhật Bản Mùa Hoa Anh Đào\r\n\r\n\r\nDu lịch Nhật Bản vào mùa xuân luôn thu hút đông đảo du khách bởi vẻ đẹp của hoa anh đào. Các thành phố như Tokyo, Kyoto, Osaka đều tổ chức lễ hội hoa anh đào với không gian lãng mạn, đậm chất văn hóa.\r\n\r\n5. Hành Trình Du Lịch Hàn Quốc - Trải Nghiệm Văn Hóa Kpop\r\n\r\n\r\nHàn Quốc không chỉ nổi tiếng với ẩm thực phong phú mà còn là thiên đường dành cho fan Kpop. Du khách có thể tham quan các địa điểm quay MV, ghé thăm các quán cà phê của thần tượng và tận hưởng không khí sôi động tại Seoul.\r\n\r\nXu hướng du lịch năm nay tập trung vào trải nghiệm thiên nhiên, văn hóa và nghỉ dưỡng đẳng cấp. Hãy lên kế hoạch ngay hôm nay để không bỏ lỡ những chuyến đi đáng nhớ!\r\n\r\n', 'tt.jpg', 'Xu Hướng Du Lịch 2025', 'Au6LqK1UH8g', '2025-04-06', 1),
(9, '🎒 Du lịch trải nghiệm Tây Bắc – xu hướng mới của giới trẻ', 'Trong những năm gần đây, du lịch Tây Bắc đang trở thành một trào lưu mạnh mẽ trong cộng đồng giới trẻ yêu thích khám phá. Không còn chuộng những điểm đến quen thuộc và tiện nghi, nhiều bạn trẻ lựa chọn những chuyến đi “phượt” đầy thử thách đến các vùng núi như Mộc Châu, Tà Xùa, Y Tý, Hà Giang – nơi thiên nhiên còn giữ được nét hoang sơ, kỳ vĩ và văn hóa bản địa độc đáo.\r\n\r\nĐặc biệt, Hà Giang với những cung đường đèo quanh co như Mã Pí Lèng, Dốc Thẩm Mã, hay Đèo Ô Quy Hồ luôn là điểm đến \"must-try\" cho các tín đồ xê dịch. Không chỉ là hành trình chinh phục thử thách, du lịch đến đây còn là cơ hội để đắm chìm trong vẻ đẹp của những cánh đồng hoa tam giác mạch nở rộ vào cuối năm, hay ruộng bậc thang vàng óng mỗi mùa lúa chín.\r\n\r\nỞ Tà Xùa (Sơn La), săn mây vào buổi sớm đã trở thành trải nghiệm \"gây nghiện\" với những ai yêu thiên nhiên. Nơi đây còn được mệnh danh là \"thiên đường trên mây\" khi từng lớp sương giăng kín lối đi, tạo nên khung cảnh huyền ảo, mơ màng.\r\n\r\nY Tý (Lào Cai) cũng không kém phần hấp dẫn với những bản làng của người Hà Nhì, H\'Mông nằm lặng lẽ giữa mây trời. Những mái nhà trình tường, những nụ cười mộc mạc của người dân bản địa khiến hành trình trở nên đáng nhớ hơn bao giờ hết.\r\n\r\nNgoài cảnh sắc thiên nhiên, một phần không thể thiếu của trải nghiệm Tây Bắc là ẩm thực bản địa. Những món ăn đậm đà hương vị núi rừng như thắng cố, lạp xưởng, cá suối nướng, cơm lam… khiến bao người mê mẩn.\r\n\r\nVới sự hỗ trợ của các tour trải nghiệm hoặc những bạn dẫn đoàn có kinh nghiệm, việc du lịch Tây Bắc giờ đây vừa dễ tiếp cận hơn, vừa đảm bảo an toàn. Đây cũng là dịp để các bạn trẻ rời xa phố thị ồn ào, tìm về nơi bình yên, kết nối với thiên nhiên và chính mình.\r\n\r\nTây Bắc không chỉ là một vùng đất, mà còn là một hành trình đầy cảm hứng – nơi trái tim của những người trẻ được thắp sáng bởi đam mê khám phá, vượt qua giới hạn bản thân và yêu thêm đất nước mình qua từng chuyến đi.', 'du-lich-trai-nghiem.jpg', 'Các tour phượt Mộc Châu, Tà Xùa, Y Tý, Hà Giang đang thu hút đông đảo các bạn trẻ nhờ vào vẻ đẹp hoang sơ, những cung đường đèo kỳ vĩ và văn hóa bản địa độc đáo.', 'ks0mOYXeMJk', '2025-04-06', 1),
(10, '🛫 Visa du lịch Hàn Quốc sẽ dễ dàng hơn từ tháng 5/2025', 'Tin vui cho những tín đồ yêu thích xứ sở kim chi: Bắt đầu từ tháng 5/2025, chính phủ Hàn Quốc sẽ chính thức nới lỏng các thủ tục cấp visa du lịch cho công dân Việt Nam. Đây là một phần trong chiến lược mới nhằm thu hút khách du lịch quốc tế và tăng cường quan hệ hợp tác du lịch – văn hóa giữa Hàn Quốc và Việt Nam.\r\n\r\nTheo thông tin từ Đại sứ quán Hàn Quốc tại Hà Nội, những thay đổi đáng chú ý bao gồm:\r\n\r\nRút ngắn thời gian xét duyệt visa từ 10 ngày xuống còn 5 ngày làm việc.\r\n\r\nMiễn nộp chứng minh tài chính đối với du khách có lịch sử du lịch tốt (từng đi Hàn Quốc, Nhật Bản, châu Âu… trong 5 năm gần nhất).\r\n\r\nƯu tiên xét duyệt nhanh cho những người đăng ký tour trọn gói từ các công ty du lịch được ủy quyền hoặc có thư mời từ phía Hàn Quốc.\r\n\r\nTăng số lượng visa 5 năm và 10 năm đối với một số nhóm đối tượng như giáo viên, công chức, người có thu nhập cao...\r\n\r\nĐặc biệt, với các tour du lịch Hàn Quốc từ Việt Nam đang rất được ưa chuộng – như Seoul – Nami – Everland, hay Busan – Jeju – thì chính sách này sẽ giúp khách hàng tiết kiệm đáng kể thời gian và công sức trong việc xin visa.\r\n\r\nCác công ty lữ hành lớn tại Việt Nam như Saigontourist, Vietravel, Fiditour cũng đã bắt đầu cập nhật các chương trình tour Hàn Quốc ưu đãi nhân dịp chính sách mới có hiệu lực. Nhiều combo trọn gói từ 12 – 15 triệu đồng đang được săn đón mạnh, đặc biệt trong dịp mùa hè và mùa lá đỏ 2025.\r\n\r\nChính phủ Hàn Quốc kỳ vọng lượng khách Việt Nam sẽ tăng ít nhất 30% trong năm 2025, đóng góp tích cực vào sự phục hồi ngành du lịch sau đại dịch và thúc đẩy giao lưu văn hóa hai nước.\r\n\r\nVới những thay đổi tích cực này, hành trình khám phá Seoul hiện đại, Gyeongju cổ kính hay ngắm hoa anh đào lãng mạn tại Hàn Quốc sẽ trở nên dễ dàng hơn bao giờ hết cho du khách Việt.', 'hqq.jpeg', 'Chính phủ Hàn Quốc vừa thông báo nới lỏng thủ tục xin visa cho công dân Việt Nam, áp dụng cho du khách có lịch sử du lịch tốt hoặc có vé tour từ các công ty uy tín.', 'RZzN-yH00Yg', '2025-04-06', 1),
(11, '🌸 Lễ hội hoa anh đào Nhật Bản 2025 chính thức khởi động ', 'Mùa xuân tại Nhật Bản luôn mang đến một màu sắc đặc biệt với lễ hội hoa anh đào, hay còn gọi là Sakura Matsuri. Mỗi năm, vào cuối tháng 3 và đầu tháng 4, cả Nhật Bản như khoác lên mình một tấm áo mới với sắc hồng và trắng của hoa anh đào nở rộ, tạo nên một cảnh tượng thiên nhiên tuyệt đẹp và là niềm tự hào của người dân xứ sở Phù Tang.\r\n\r\nNăm 2025, mùa lễ hội hoa anh đào sẽ chính thức khởi động từ cuối tháng 3 và kéo dài đến giữa tháng 4, khi hoa anh đào tại các thành phố lớn như Tokyo và Kyoto đạt độ nở đẹp nhất. Đây là thời điểm lý tưởng để du khách khám phá vẻ đẹp tuyệt vời của hoa anh đào trong không khí tươi mới, mát mẻ của mùa xuân.\r\n\r\n🎉 Tour Nhật Bản dịp lễ hội hoa anh đào 2025: \"Cháy vé\" nhanh chóng\r\nVới sức hút mạnh mẽ của lễ hội hoa anh đào, các tour du lịch Nhật Bản dịp này đang trở thành món quà hấp dẫn cho các gia đình, nhóm bạn và các cặp đôi. Những chương trình tour trọn gói bao gồm chuyến bay, khách sạn, vé tham quan và hướng dẫn viên luôn được các công ty du lịch trong và ngoài nước đưa ra với mức giá ưu đãi đặc biệt.\r\n\r\nNhiều công ty du lịch đang khai thác các tour đến Tokyo, Kyoto, Osaka, nơi có những công viên nổi tiếng như Ueno Park, Shinjuku Gyoen, và Maruyama Park. Đặc biệt, bạn sẽ được trải nghiệm hanami (ngắm hoa) – một truyền thống lâu đời của người Nhật, khi họ tụ tập cùng gia đình, bạn bè dưới những tán cây anh đào để thưởng thức ẩm thực, uống rượu sake và tận hưởng không khí trong lành.\r\n\r\n🌍 Những điểm ngắm hoa anh đào không thể bỏ qua\r\nTokyo: Công viên Ueno và công viên Shinjuku Gyoen là hai địa điểm nổi tiếng nhất. Tại Ueno, du khách có thể tham gia lễ hội hoa anh đào lớn nhất Tokyo, ngắm nhìn hàng nghìn cây hoa anh đào rực rỡ trong khi thưởng thức các món ăn đặc trưng của Nhật Bản.\r\n\r\nKyoto: Kyoto là nơi lưu giữ nhiều ngôi đền và chùa cổ kính, tạo nên sự kết hợp tuyệt vời giữa thiên nhiên và văn hóa. Công viên Maruyama và con đường Philosopher’s Path (Con đường triết học) là những địa điểm lý tưởng để ngắm hoa anh đào.\r\n\r\nHokkaido: Nếu bạn muốn tránh đám đông ở các thành phố lớn, Hokkaido với mùa hoa anh đào muộn hơn là lựa chọn tuyệt vời để tận hưởng không gian yên tĩnh và bình yên.\r\n\r\n💰 Ưu đãi hấp dẫn cho các tour hoa anh đào 2025\r\nCác tour du lịch Nhật Bản dịp hoa anh đào năm nay đặc biệt thu hút với các ưu đãi giảm giá lên đến 15-20%. Những tour trọn gói dành cho nhóm khách gia đình hoặc cặp đôi thường có các dịch vụ như:\r\n\r\nKhách sạn 4-5 sao gần các khu vực ngắm hoa.\r\n\r\nVé vào cửa các điểm tham quan nổi tiếng như đền Kinkaku-ji (Kyoto), tháp Tokyo Skytree (Tokyo), hay cung điện Hoàng gia.\r\n\r\nChương trình đặc biệt vào ngày lễ hội Sakura, với bữa tiệc hanami ngoài trời và hoạt động văn hóa truyền thống Nhật Bản.\r\n\r\nNhờ những chương trình khuyến mãi hấp dẫn này, các tour du lịch Nhật Bản dịp hoa anh đào đã nhanh chóng cháy vé và thu hút rất đông khách du lịch từ Việt Nam. Nếu bạn đang có kế hoạch du lịch Nhật Bản vào dịp lễ hội hoa anh đào 2025, hãy nhanh chóng đặt vé để có cơ hội trải nghiệm mùa xuân tuyệt vời tại xứ sở Phù Tang.\r\n\r\nMẹo: Đừng quên chuẩn bị cho mình một chiếc máy ảnh chất lượng để lưu lại những khoảnh khắc đẹp nhất bên những cây anh đào nở rộ và khung cảnh tuyệt vời tại Nhật Bản.', 'had.jpg', 'Mùa lễ hội hoa anh đào tại Tokyo và Kyoto sẽ bắt đầu từ cuối tháng 3 và kéo dài đến giữa tháng 4. Tour Nhật Bản dịp này đang “cháy vé” với hàng loạt ưu đãi hấp dẫn cho nhóm khách gia đình và cặp đôi.', 'Plp98VugaZo', '2025-04-09', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `participant`
--

CREATE TABLE `participant` (
  `idpar` int(11) NOT NULL,
  `idbook` int(11) DEFAULT NULL,
  `hoten` varchar(255) NOT NULL,
  `ngaysinh` date NOT NULL,
  `gioitinh` varchar(255) NOT NULL,
  `phanloai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `participant`
--

INSERT INTO `participant` (`idpar`, `idbook`, `hoten`, `ngaysinh`, `gioitinh`, `phanloai`) VALUES
(141, 232, 'Anh hùng', '2001-07-07', 'Nam', 'Người lớn'),
(142, 233, 'ád', '1998-10-07', 'Nam', 'Người lớn'),
(144, 235, 'sf', '1994-06-08', 'Nam', 'Người lớn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `idbook` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `idbook`, `method`, `created_at`) VALUES
(70, 1, 232, 'vnpay', '2025-04-07 02:29:19'),
(71, 1, 233, 'vnpay', '2025-04-07 02:32:43'),
(73, 1, 235, 'vietqr', '2025-04-08 06:03:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating_reviews_ks`
--

CREATE TABLE `rating_reviews_ks` (
  `Sr_no` int(11) NOT NULL,
  `Booking_id` int(11) DEFAULT NULL,
  `Room_id` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Review` text DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Datetime` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rating_reviews_ks`
--

INSERT INTO `rating_reviews_ks` (`Sr_no`, `Booking_id`, `Room_id`, `Rating`, `Review`, `Username`, `Datetime`) VALUES
(2, 23, 9, 5, 'tuyệt', 'Phuc Hung', '2025-01-17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating_reviewtour`
--

CREATE TABLE `rating_reviewtour` (
  `Sr_no` int(11) NOT NULL,
  `Booking_id` int(11) DEFAULT NULL,
  `Tour_id` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Review` text DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Datetime` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rating_reviewtour`
--

INSERT INTO `rating_reviewtour` (`Sr_no`, `Booking_id`, `Tour_id`, `Rating`, `Review`, `Username`, `Datetime`) VALUES
(18, 232, 50, 5, 'sss', 'Phuc Hung', '2025-04-07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rentals`
--

CREATE TABLE `rentals` (
  `rental_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `pickup_time` datetime NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `dropoff_location` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `gia` varchar(255) NOT NULL,
  `Trangthai` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rentals`
--

INSERT INTO `rentals` (`rental_id`, `customer_name`, `customer_phone`, `customer_email`, `vehicle_type`, `driver_id`, `pickup_time`, `pickup_location`, `dropoff_location`, `notes`, `gia`, `Trangthai`, `created_at`, `user_id`) VALUES
(3, 'Phuc Hung', '0987389890', 'phuc@gmail.com', '4 chỗ', 50, '2025-04-06 08:11:00', 'Tp hồ', 'Hà ', 'sss', '', 1, '2025-03-27 01:12:07', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `guide_id` int(11) DEFAULT NULL,
  `report_type` enum('tour','work') DEFAULT NULL,
  `report_content` text DEFAULT NULL,
  `report_file` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reports`
--

INSERT INTO `reports` (`id`, `guide_id`, `report_type`, `report_content`, `report_file`, `status`, `created_at`, `approved_by`, `approved_at`) VALUES
(11, 3, 'tour', 'xcc🔥 Điểm nổi bật\r\n✔ Giao diện đẹp: Bảng có bo góc, đổ bóng, hover màu xám.\r\n✔ Nút \"Xem chi tiết\": Nếu nội dung > 100 ký tự, bấm để mở rộng.\r\n✔ Màu sắc nút hành động:\r\n\r\nDuyệt (✔) → Xanh lá\r\n\r\nTừ chối (✖) → Đỏ\r\n✔ Bảo mật: htmlspecialchars() chống XSS.\r\n\r\n💡 Giờ bạn có một bảng báo cáo đẹp, dễ dùng và không bị quá dài! 🚀', NULL, 'approved', '2025-03-25 03:29:15', 1, '2025-03-25 03:45:27'),
(12, 3, 'tour', 'sss', NULL, 'approved', '2025-03-25 03:34:10', 1, '2025-03-25 03:46:11'),
(13, 3, 'tour', 'emasd', '1742874470_6N5Đ_CAO BẰNG- TĨNH TÂY- BẮC CẠN 08JUN2025. Revised 20.3.pdf', 'approved', '2025-03-25 03:47:50', 1, '2025-03-25 04:03:38'),
(14, 3, 'work', '📅 Ngày báo cáo: 25/03/2025\r\n👤 Hướng dẫn viên: Nguyễn Văn A\r\n\r\n1. Thông tin chung\r\nTour phụ trách: Đà Nẵng – Hội An (3 ngày 2 đêm)\r\n\r\nThời gian khởi hành: 22/03/2025\r\n\r\nSố lượng khách: 25 người\r\n\r\nPhương tiện di chuyển: Xe du lịch 45 chỗ\r\n\r\n2. Công việc đã thực hiện\r\n✅ Hướng dẫn khách tham quan các điểm du lịch:\r\n\r\nNgày 1: Bán đảo Sơn Trà, Ngũ Hành Sơn, phố cổ Hội An.\r\n\r\nNgày 2: Bà Nà Hills, cầu Vàng, công viên châu Á.\r\n\r\nNgày 3: Chợ Hàn, bãi biển Mỹ Khê, tiễn khách ra sân bay.\r\n✅ Phối hợp với tài xế và nhà hàng để đảm bảo dịch vụ tốt nhất.\r\n✅ Hỗ trợ khách hàng giải đáp thắc mắc và xử lý các tình huống phát sinh.\r\n\r\n3. Khó khăn gặp phải\r\n⚠ Một số khách bị say xe, cần hỗ trợ y tế nhẹ.\r\n⚠ Giao thông ùn tắc tại Hội An vào buổi tối, cần điều chỉnh lịch trình linh hoạt.\r\n⚠ Thời tiết thay đổi thất thường, có mưa nhỏ trong ngày thứ hai.\r\n\r\n4. Đề xuất và cải tiến\r\n💡 Cần trang bị thêm túi sơ cứu trên xe để hỗ trợ khách say xe.\r\n💡 Cần có phương án dự phòng khi gặp thời tiết xấu (danh sách điểm tham quan thay thế).\r\n💡 Đề xuất bổ sung thời gian tham quan phố cổ Hội An để khách có nhiều trải nghiệm hơn.', '1742875507_Mau bao cao KLTN.docx', 'approved', '2025-03-25 04:05:07', 1, '2025-03-25 04:05:36'),
(15, 7, 'work', 'sds', '1744073524_booking_details_233 (1).pdf', 'pending', '2025-04-08 00:52:04', 1, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `request_tour`
--

CREATE TABLE `request_tour` (
  `id_request` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `tour_name` varchar(255) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `tour_price` int(10) DEFAULT NULL,
  `itinerary` text DEFAULT NULL,
  `tour_duration` varchar(50) DEFAULT NULL,
  `phuongtien` varchar(255) NOT NULL,
  `idks` int(11) NOT NULL,
  `idtx` int(11) NOT NULL,
  `Trangthai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `request_tour`
--

INSERT INTO `request_tour` (`id_request`, `user_id`, `customer_name`, `tour_name`, `departure_date`, `tour_price`, `itinerary`, `tour_duration`, `phuongtien`, `idks`, `idtx`, `Trangthai`) VALUES
(9, 1, 'Phuc Hung', 'Hà Nội', '2025-03-20', 300000, '{\"Ngày 1\":\"Lịch trình ngày 1: Hà Nội\",\"Ngày 2\":\"Lịch trình ngày 2: Hồ\"}', '2 ngày 1 đêm', 'Xe khách', 9, 1, 1),
(16, 1, 'Phuc Hung', 'emaui', '2025-03-07', 1000000, '{\"Ngày 1\":\"z\",\"Ngày 2\":\"x\"}', '2 ngày 1 đêm', 'Xe khách', 9, 2, 0),
(17, 1, 'Phuc Hung', 'Hà nội', '2025-03-29', 2000000, '{\"Ngày 1\":\"xx\",\"Ngày 2\":\"xxx\"}', '2 ngày 1 đêm', 'Xe khách', 10, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Diadiem` text NOT NULL,
  `Ngaynhan` date NOT NULL,
  `Ngaytra` date NOT NULL,
  `Area` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `Adult` varchar(255) NOT NULL,
  `Children` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Removed` varchar(255) NOT NULL,
  `employeesId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `Name`, `Diadiem`, `Ngaynhan`, `Ngaytra`, `Area`, `Price`, `Adult`, `Children`, `Status`, `Removed`, `employeesId`) VALUES
(9, 'Aquasun Hotel', 'Phú Quốc', '2025-04-01', '2025-05-11', '20m²', 2400000, '2', '1', 'Hoạt động', 'no', 1),
(10, 'Salute Premium Hotel & Spa', 'Hà Nội', '2025-02-22', '2025-02-26', '30m²', 3000000, '4', '2', 'Hoạt động', 'no', 1),
(11, 'Madelise Central Grand Hotel', 'Đà Nẵng', '2025-02-22', '2025-02-25', '40m²', 5000000, '4', '0', 'Hoạt động', 'no', 1),
(12, 'Sapa Horizon Hotel', 'Sapa', '2025-02-12', '2025-02-14', '50m²', 5500000, '4', '2', 'Hoạt động', 'no', 1),
(13, 'Grand Paradise Hotel', 'Huế', '2025-02-25', '2025-02-28', '60m²', 6000000, '5', '2', 'ko Hoạt động', 'no', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms_facilities`
--

CREATE TABLE `rooms_facilities` (
  `Sr_no` int(11) NOT NULL,
  `Room_id` int(11) DEFAULT NULL,
  `Facilities_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms_facilities`
--

INSERT INTO `rooms_facilities` (`Sr_no`, `Room_id`, `Facilities_id`) VALUES
(7, 9, 5),
(8, 10, 4),
(9, 11, 3),
(10, 12, 2),
(11, 13, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms_features`
--

CREATE TABLE `rooms_features` (
  `Sr_no` int(11) NOT NULL,
  `Room_id` int(11) DEFAULT NULL,
  `Features_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms_features`
--

INSERT INTO `rooms_features` (`Sr_no`, `Room_id`, `Features_id`) VALUES
(7, 9, 5),
(8, 10, 4),
(9, 11, 3),
(10, 12, 2),
(11, 13, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms_images`
--

CREATE TABLE `rooms_images` (
  `Sr_no` int(11) NOT NULL,
  `Room_id` int(11) DEFAULT NULL,
  `Image` varchar(255) NOT NULL,
  `Thumb` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms_images`
--

INSERT INTO `rooms_images` (`Sr_no`, `Room_id`, `Image`, `Thumb`) VALUES
(7, 9, 'Deluxex.jpg', 'Phòng được trang bị tiện nghi hiện đại, không gian sang trọng và thoải mái, phù hợp cho những ai yêu thích sự tinh tế.'),
(8, 10, 'doublee.jpg', 'Thiết kế dành cho hai người, với không gian ấm cúng cùng giường đôi hoặc hai giường đơn tiện lợi.'),
(9, 11, 'famaly.jpg', 'Phòng rộng rãi, lý tưởng cho gia đình, được trang bị nhiều giường và các tiện ích phù hợp cho trẻ em.'),
(10, 12, 'luxury.jpg', 'Không gian cao cấp với nội thất sang trọng, tiện nghi đỉnh cao và trải nghiệm đẳng cấp.'),
(11, 13, 'singlee.jpg', 'Phòng nhỏ gọn, ấm áp, dành riêng cho khách đi một mình, đầy đủ tiện nghi cho một kỳ nghỉ thoải mái.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `shift_type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `shift_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `schedule`
--

INSERT INTO `schedule` (`id`, `employee_id`, `shift_type`, `status`, `shift_date`, `created_at`) VALUES
(759, 1, 'X', 'P', '2025-03-01', '2025-03-25 02:41:00'),
(760, 1, 'Ca 2', 'V', '2025-03-02', '2025-03-25 02:41:00'),
(761, 1, 'Ca 2', 'V', '2025-03-03', '2025-03-25 02:41:01'),
(762, 1, 'Ca 2', 'V', '2025-03-04', '2025-03-25 02:41:01'),
(763, 1, 'Ca 3', 'V', '2025-03-05', '2025-03-25 02:41:01'),
(764, 1, 'Ca 2', 'V', '2025-03-06', '2025-03-25 02:41:01'),
(765, 1, 'X', 'P', '2025-03-07', '2025-03-25 02:41:01'),
(766, 1, 'Ca 3', 'V', '2025-03-08', '2025-03-25 02:41:01'),
(767, 1, 'Ca 2', 'V', '2025-03-09', '2025-03-25 02:41:01'),
(768, 1, 'Ca 2', 'V', '2025-03-10', '2025-03-25 02:41:01'),
(769, 1, 'X', 'P', '2025-03-11', '2025-03-25 02:41:01'),
(770, 1, 'X', 'P', '2025-03-12', '2025-03-25 02:41:01'),
(771, 1, 'Ca 3', 'V', '2025-03-13', '2025-03-25 02:41:01'),
(772, 1, 'Ca 1', 'V', '2025-03-14', '2025-03-25 02:41:01'),
(773, 1, 'X', 'P', '2025-03-15', '2025-03-25 02:41:01'),
(774, 1, 'Ca 2', 'V', '2025-03-16', '2025-03-25 02:41:01'),
(775, 1, 'X', 'P', '2025-03-17', '2025-03-25 02:41:01'),
(776, 1, 'X', 'P', '2025-03-18', '2025-03-25 02:41:01'),
(777, 1, 'Ca 1', 'V', '2025-03-19', '2025-03-25 02:41:01'),
(778, 1, 'Ca 1', 'V', '2025-03-20', '2025-03-25 02:41:01'),
(779, 1, 'Ca 2', 'V', '2025-03-21', '2025-03-25 02:41:01'),
(780, 1, 'Ca 1', 'V', '2025-03-22', '2025-03-25 02:41:01'),
(781, 1, 'Ca 2', 'V', '2025-03-23', '2025-03-25 02:41:01'),
(782, 1, 'X', 'P', '2025-03-24', '2025-03-25 02:41:01'),
(783, 1, 'Ca 2', 'V', '2025-03-25', '2025-03-25 02:41:01'),
(784, 1, 'Ca 1', 'V', '2025-03-26', '2025-03-25 02:41:01'),
(785, 1, 'Ca 3', 'V', '2025-03-27', '2025-03-25 02:41:01'),
(786, 1, 'Ca 3', 'V', '2025-03-28', '2025-03-25 02:41:01'),
(787, 1, 'Ca 3', 'V', '2025-03-29', '2025-03-25 02:41:01'),
(788, 1, 'Ca 2', 'V', '2025-03-30', '2025-03-25 02:41:01'),
(789, 1, 'Ca 2', 'V', '2025-03-31', '2025-03-25 02:41:01'),
(790, 2, 'Ca 3', 'V', '2025-03-01', '2025-03-25 02:41:01'),
(791, 2, 'Ca 1', 'V', '2025-03-02', '2025-03-25 02:41:01'),
(792, 2, 'Ca 3', 'V', '2025-03-03', '2025-03-25 02:41:01'),
(793, 2, 'Ca 2', 'V', '2025-03-04', '2025-03-25 02:41:01'),
(794, 2, 'Ca 1', 'V', '2025-03-05', '2025-03-25 02:41:01'),
(795, 2, 'Ca 1', 'V', '2025-03-06', '2025-03-25 02:41:01'),
(796, 2, 'Ca 2', 'V', '2025-03-07', '2025-03-25 02:41:01'),
(797, 2, 'Ca 2', 'V', '2025-03-08', '2025-03-25 02:41:01'),
(798, 2, 'Ca 1', 'V', '2025-03-09', '2025-03-25 02:41:01'),
(799, 2, 'Ca 1', 'V', '2025-03-10', '2025-03-25 02:41:01'),
(800, 2, 'Ca 2', 'V', '2025-03-11', '2025-03-25 02:41:01'),
(801, 2, 'X', 'P', '2025-03-12', '2025-03-25 02:41:01'),
(802, 2, 'Ca 1', 'V', '2025-03-13', '2025-03-25 02:41:01'),
(803, 2, 'Ca 2', 'V', '2025-03-14', '2025-03-25 02:41:01'),
(804, 2, 'Ca 3', 'V', '2025-03-15', '2025-03-25 02:41:01'),
(805, 2, 'Ca 3', 'V', '2025-03-16', '2025-03-25 02:41:01'),
(806, 2, 'Ca 3', 'V', '2025-03-17', '2025-03-25 02:41:01'),
(807, 2, 'X', 'P', '2025-03-18', '2025-03-25 02:41:01'),
(808, 2, 'Ca 2', 'V', '2025-03-19', '2025-03-25 02:41:01'),
(809, 2, 'X', 'P', '2025-03-20', '2025-03-25 02:41:01'),
(810, 2, 'X', 'P', '2025-03-21', '2025-03-25 02:41:01'),
(811, 2, 'X', 'P', '2025-03-22', '2025-03-25 02:41:01'),
(812, 2, 'Ca 1', 'V', '2025-03-23', '2025-03-25 02:41:01'),
(813, 2, 'Ca 2', 'V', '2025-03-24', '2025-03-25 02:41:01'),
(814, 2, 'Ca 1', 'V', '2025-03-25', '2025-03-25 02:41:01'),
(815, 2, 'X', 'P', '2025-03-26', '2025-03-25 02:41:01'),
(816, 2, 'Ca 2', 'V', '2025-03-27', '2025-03-25 02:41:01'),
(817, 2, 'Ca 2', 'V', '2025-03-28', '2025-03-25 02:41:01'),
(818, 2, 'Ca 2', 'V', '2025-03-29', '2025-03-25 02:41:01'),
(819, 2, 'Ca 3', 'V', '2025-03-30', '2025-03-25 02:41:01'),
(820, 2, 'Ca 2', 'V', '2025-03-31', '2025-03-25 02:41:01'),
(821, 3, 'Ca 3', 'V', '2025-03-01', '2025-03-25 02:41:01'),
(822, 3, 'X', 'P', '2025-03-02', '2025-03-25 02:41:01'),
(823, 3, 'Ca 1', 'V', '2025-03-03', '2025-03-25 02:41:01'),
(824, 3, 'Ca 2', 'V', '2025-03-04', '2025-03-25 02:41:01'),
(825, 3, 'X', 'P', '2025-03-05', '2025-03-25 02:41:01'),
(826, 3, 'Ca 1', 'V', '2025-03-06', '2025-03-25 02:41:01'),
(827, 3, 'Ca 1', 'V', '2025-03-07', '2025-03-25 02:41:01'),
(828, 3, 'Ca 1', 'V', '2025-03-08', '2025-03-25 02:41:01'),
(829, 3, 'Ca 3', 'V', '2025-03-09', '2025-03-25 02:41:01'),
(830, 3, 'Ca 3', 'V', '2025-03-10', '2025-03-25 02:41:01'),
(831, 3, 'Ca 2', 'V', '2025-03-11', '2025-03-25 02:41:01'),
(832, 3, 'Ca 2', 'V', '2025-03-12', '2025-03-25 02:41:01'),
(833, 3, 'Ca 1', 'V', '2025-03-13', '2025-03-25 02:41:01'),
(834, 3, 'X', 'P', '2025-03-14', '2025-03-25 02:41:01'),
(835, 3, 'X', 'P', '2025-03-15', '2025-03-25 02:41:01'),
(836, 3, 'Ca 3', 'V', '2025-03-16', '2025-03-25 02:41:01'),
(837, 3, 'X', 'P', '2025-03-17', '2025-03-25 02:41:01'),
(838, 3, 'Ca 3', 'V', '2025-03-18', '2025-03-25 02:41:01'),
(839, 3, 'Ca 1', 'V', '2025-03-19', '2025-03-25 02:41:01'),
(840, 3, 'X', 'P', '2025-03-20', '2025-03-25 02:41:01'),
(841, 3, 'Ca 3', 'V', '2025-03-21', '2025-03-25 02:41:01'),
(842, 3, 'Ca 3', 'V', '2025-03-22', '2025-03-25 02:41:01'),
(843, 3, 'Ca 1', 'V', '2025-03-23', '2025-03-25 02:41:01'),
(844, 3, 'Ca 1', 'V', '2025-03-24', '2025-03-25 02:41:01'),
(845, 3, 'Ca 2', 'V', '2025-03-25', '2025-03-25 02:41:01'),
(846, 3, 'Ca 1', 'V', '2025-03-26', '2025-03-25 02:41:01'),
(847, 3, 'X', 'P', '2025-03-27', '2025-03-25 02:41:01'),
(848, 3, 'Ca 3', 'V', '2025-03-28', '2025-03-25 02:41:01'),
(849, 3, 'X', 'P', '2025-03-29', '2025-03-25 02:41:01'),
(850, 3, 'Ca 3', 'V', '2025-03-30', '2025-03-25 02:41:01'),
(851, 3, 'X', 'P', '2025-03-31', '2025-03-25 02:41:01'),
(852, 7, 'Ca 2', 'V', '2025-03-01', '2025-03-25 02:41:01'),
(853, 7, 'Ca 2', 'V', '2025-03-02', '2025-03-25 02:41:01'),
(854, 7, 'X', 'P', '2025-03-03', '2025-03-25 02:41:01'),
(855, 7, 'X', 'P', '2025-03-04', '2025-03-25 02:41:01'),
(856, 7, 'Ca 3', 'V', '2025-03-05', '2025-03-25 02:41:01'),
(857, 7, 'Ca 1', 'V', '2025-03-06', '2025-03-25 02:41:01'),
(858, 7, 'Ca 2', 'V', '2025-03-07', '2025-03-25 02:41:01'),
(859, 7, 'Ca 3', 'V', '2025-03-08', '2025-03-25 02:41:01'),
(860, 7, 'X', 'P', '2025-03-09', '2025-03-25 02:41:01'),
(861, 7, 'Ca 2', 'V', '2025-03-10', '2025-03-25 02:41:01'),
(862, 7, 'X', 'P', '2025-03-11', '2025-03-25 02:41:01'),
(863, 7, 'X', 'P', '2025-03-12', '2025-03-25 02:41:01'),
(864, 7, 'Ca 3', 'V', '2025-03-13', '2025-03-25 02:41:01'),
(865, 7, 'Ca 1', 'V', '2025-03-14', '2025-03-25 02:41:01'),
(866, 7, 'Ca 2', 'V', '2025-03-15', '2025-03-25 02:41:01'),
(867, 7, 'Ca 1', 'V', '2025-03-16', '2025-03-25 02:41:01'),
(868, 7, 'Ca 3', 'V', '2025-03-17', '2025-03-25 02:41:01'),
(869, 7, 'Ca 3', 'V', '2025-03-18', '2025-03-25 02:41:01'),
(870, 7, 'Ca 1', 'V', '2025-03-19', '2025-03-25 02:41:01'),
(871, 7, 'Ca 2', 'V', '2025-03-20', '2025-03-25 02:41:01'),
(872, 7, 'Ca 2', 'V', '2025-03-21', '2025-03-25 02:41:01'),
(873, 7, 'Ca 2', 'V', '2025-03-22', '2025-03-25 02:41:01'),
(874, 7, 'Ca 2', 'V', '2025-03-23', '2025-03-25 02:41:01'),
(875, 7, 'X', 'P', '2025-03-24', '2025-03-25 02:41:01'),
(876, 7, 'Ca 2', 'V', '2025-03-25', '2025-03-25 02:41:01'),
(877, 7, 'Ca 2', 'V', '2025-03-26', '2025-03-25 02:41:01'),
(878, 7, 'Ca 1', 'V', '2025-03-27', '2025-03-25 02:41:01'),
(879, 7, 'Ca 2', 'V', '2025-03-28', '2025-03-25 02:41:01'),
(880, 7, 'Ca 3', 'V', '2025-03-29', '2025-03-25 02:41:01'),
(881, 7, 'Ca 3', 'V', '2025-03-30', '2025-03-25 02:41:01'),
(882, 7, 'Ca 1', 'V', '2025-03-31', '2025-03-25 02:41:01'),
(883, 8, 'Ca 3', 'V', '2025-03-01', '2025-03-25 02:41:01'),
(884, 8, 'Ca 3', 'V', '2025-03-02', '2025-03-25 02:41:01'),
(885, 8, 'Ca 3', 'V', '2025-03-03', '2025-03-25 02:41:01'),
(886, 8, 'Ca 1', 'V', '2025-03-04', '2025-03-25 02:41:01'),
(887, 8, 'Ca 1', 'V', '2025-03-05', '2025-03-25 02:41:01'),
(888, 8, 'X', 'P', '2025-03-06', '2025-03-25 02:41:01'),
(889, 8, 'X', 'P', '2025-03-07', '2025-03-25 02:41:01'),
(890, 8, 'Ca 2', 'V', '2025-03-08', '2025-03-25 02:41:01'),
(891, 8, 'Ca 2', 'V', '2025-03-09', '2025-03-25 02:41:01'),
(892, 8, 'X', 'P', '2025-03-10', '2025-03-25 02:41:01'),
(893, 8, 'Ca 2', 'V', '2025-03-11', '2025-03-25 02:41:01'),
(894, 8, 'Ca 1', 'V', '2025-03-12', '2025-03-25 02:41:01'),
(895, 8, 'Ca 3', 'V', '2025-03-13', '2025-03-25 02:41:01'),
(896, 8, 'Ca 2', 'V', '2025-03-14', '2025-03-25 02:41:01'),
(897, 8, 'X', 'P', '2025-03-15', '2025-03-25 02:41:01'),
(898, 8, 'X', 'P', '2025-03-16', '2025-03-25 02:41:01'),
(899, 8, 'Ca 3', 'V', '2025-03-17', '2025-03-25 02:41:01'),
(900, 8, 'Ca 3', 'V', '2025-03-18', '2025-03-25 02:41:01'),
(901, 8, 'Ca 3', 'V', '2025-03-19', '2025-03-25 02:41:01'),
(902, 8, 'Ca 1', 'V', '2025-03-20', '2025-03-25 02:41:01'),
(903, 8, 'Ca 2', 'V', '2025-03-21', '2025-03-25 02:41:01'),
(904, 8, 'X', 'P', '2025-03-22', '2025-03-25 02:41:01'),
(905, 8, 'Ca 3', 'V', '2025-03-23', '2025-03-25 02:41:01'),
(906, 8, 'Ca 1', 'V', '2025-03-24', '2025-03-25 02:41:01'),
(907, 8, 'Ca 2', 'V', '2025-03-25', '2025-03-25 02:41:01'),
(908, 8, 'X', 'P', '2025-03-26', '2025-03-25 02:41:01'),
(909, 8, 'Ca 3', 'V', '2025-03-27', '2025-03-25 02:41:01'),
(910, 8, 'Ca 2', 'V', '2025-03-28', '2025-03-25 02:41:01'),
(911, 8, 'Ca 1', 'V', '2025-03-29', '2025-03-25 02:41:01'),
(912, 8, 'Ca 1', 'V', '2025-03-30', '2025-03-25 02:41:01'),
(913, 8, 'Ca 2', 'V', '2025-03-31', '2025-03-25 02:41:01'),
(914, 9, 'Ca 2', 'V', '2025-03-01', '2025-03-25 02:41:01'),
(915, 9, 'Ca 2', 'V', '2025-03-02', '2025-03-25 02:41:01'),
(916, 9, 'Ca 3', 'V', '2025-03-03', '2025-03-25 02:41:01'),
(917, 9, 'Ca 3', 'V', '2025-03-04', '2025-03-25 02:41:01'),
(918, 9, 'X', 'P', '2025-03-05', '2025-03-25 02:41:01'),
(919, 9, 'Ca 3', 'V', '2025-03-06', '2025-03-25 02:41:01'),
(920, 9, 'Ca 2', 'V', '2025-03-07', '2025-03-25 02:41:01'),
(921, 9, 'Ca 2', 'V', '2025-03-08', '2025-03-25 02:41:01'),
(922, 9, 'Ca 2', 'V', '2025-03-09', '2025-03-25 02:41:01'),
(923, 9, 'Ca 3', 'V', '2025-03-10', '2025-03-25 02:41:01'),
(924, 9, 'Ca 1', 'V', '2025-03-11', '2025-03-25 02:41:01'),
(925, 9, 'Ca 2', 'V', '2025-03-12', '2025-03-25 02:41:01'),
(926, 9, 'Ca 1', 'V', '2025-03-13', '2025-03-25 02:41:01'),
(927, 9, 'Ca 3', 'V', '2025-03-14', '2025-03-25 02:41:01'),
(928, 9, 'Ca 2', 'V', '2025-03-15', '2025-03-25 02:41:01'),
(929, 9, 'Ca 2', 'V', '2025-03-16', '2025-03-25 02:41:01'),
(930, 9, 'Ca 3', 'V', '2025-03-17', '2025-03-25 02:41:01'),
(931, 9, 'Ca 3', 'V', '2025-03-18', '2025-03-25 02:41:01'),
(932, 9, 'Ca 2', 'V', '2025-03-19', '2025-03-25 02:41:01'),
(933, 9, 'Ca 2', 'V', '2025-03-20', '2025-03-25 02:41:01'),
(934, 9, 'Ca 1', 'V', '2025-03-21', '2025-03-25 02:41:01'),
(935, 9, 'Ca 3', 'V', '2025-03-22', '2025-03-25 02:41:01'),
(936, 9, 'X', 'P', '2025-03-23', '2025-03-25 02:41:01'),
(937, 9, 'X', 'P', '2025-03-24', '2025-03-25 02:41:01'),
(938, 9, 'Ca 3', 'V', '2025-03-25', '2025-03-25 02:41:01'),
(939, 9, 'Ca 2', 'V', '2025-03-26', '2025-03-25 02:41:01'),
(940, 9, 'Ca 3', 'V', '2025-03-27', '2025-03-25 02:41:01'),
(941, 9, 'Ca 3', 'V', '2025-03-28', '2025-03-25 02:41:01'),
(942, 9, 'X', 'P', '2025-03-29', '2025-03-25 02:41:01'),
(943, 9, 'Ca 2', 'V', '2025-03-30', '2025-03-25 02:41:01'),
(944, 9, 'Ca 3', 'V', '2025-03-31', '2025-03-25 02:41:01'),
(945, 10, 'Ca 3', 'V', '2025-03-01', '2025-03-25 02:41:01'),
(946, 10, 'Ca 3', 'V', '2025-03-02', '2025-03-25 02:41:01'),
(947, 10, 'Ca 2', 'V', '2025-03-03', '2025-03-25 02:41:01'),
(948, 10, 'X', 'P', '2025-03-04', '2025-03-25 02:41:01'),
(949, 10, 'Ca 3', 'V', '2025-03-05', '2025-03-25 02:41:01'),
(950, 10, 'Ca 2', 'V', '2025-03-06', '2025-03-25 02:41:01'),
(951, 10, 'Ca 2', 'V', '2025-03-07', '2025-03-25 02:41:01'),
(952, 10, 'Ca 2', 'V', '2025-03-08', '2025-03-25 02:41:01'),
(953, 10, 'Ca 3', 'V', '2025-03-09', '2025-03-25 02:41:01'),
(954, 10, 'Ca 3', 'V', '2025-03-10', '2025-03-25 02:41:01'),
(955, 10, 'X', 'P', '2025-03-11', '2025-03-25 02:41:01'),
(956, 10, 'Ca 2', 'V', '2025-03-12', '2025-03-25 02:41:01'),
(957, 10, 'Ca 2', 'V', '2025-03-13', '2025-03-25 02:41:01'),
(958, 10, 'X', 'P', '2025-03-14', '2025-03-25 02:41:01'),
(959, 10, 'Ca 3', 'V', '2025-03-15', '2025-03-25 02:41:01'),
(960, 10, 'X', 'P', '2025-03-16', '2025-03-25 02:41:01'),
(961, 10, 'Ca 1', 'V', '2025-03-17', '2025-03-25 02:41:01'),
(962, 10, 'Ca 3', 'V', '2025-03-18', '2025-03-25 02:41:01'),
(963, 10, 'Ca 2', 'V', '2025-03-19', '2025-03-25 02:41:01'),
(964, 10, 'X', 'P', '2025-03-20', '2025-03-25 02:41:01'),
(965, 10, 'Ca 1', 'V', '2025-03-21', '2025-03-25 02:41:01'),
(966, 10, 'Ca 3', 'V', '2025-03-22', '2025-03-25 02:41:01'),
(967, 10, 'Ca 1', 'V', '2025-03-23', '2025-03-25 02:41:01'),
(968, 10, 'Ca 2', 'V', '2025-03-24', '2025-03-25 02:41:01'),
(969, 10, 'Ca 2', 'V', '2025-03-25', '2025-03-25 02:41:01'),
(970, 10, 'Ca 1', 'V', '2025-03-26', '2025-03-25 02:41:01'),
(971, 10, 'Ca 3', 'V', '2025-03-27', '2025-03-25 02:41:01'),
(972, 10, 'Ca 2', 'V', '2025-03-28', '2025-03-25 02:41:01'),
(973, 10, 'Ca 3', 'V', '2025-03-29', '2025-03-25 02:41:01'),
(974, 10, 'Ca 3', 'V', '2025-03-30', '2025-03-25 02:41:01'),
(975, 10, 'Ca 2', 'V', '2025-03-31', '2025-03-25 02:41:01'),
(976, 11, 'Ca 1', 'V', '2025-03-01', '2025-03-25 02:41:01'),
(977, 11, 'Ca 1', 'V', '2025-03-02', '2025-03-25 02:41:01'),
(978, 11, 'Ca 2', 'V', '2025-03-03', '2025-03-25 02:41:01'),
(979, 11, 'X', 'P', '2025-03-04', '2025-03-25 02:41:01'),
(980, 11, 'Ca 1', 'V', '2025-03-05', '2025-03-25 02:41:01'),
(981, 11, 'Ca 3', 'V', '2025-03-06', '2025-03-25 02:41:01'),
(982, 11, 'Ca 2', 'V', '2025-03-07', '2025-03-25 02:41:01'),
(983, 11, 'Ca 1', 'V', '2025-03-08', '2025-03-25 02:41:01'),
(984, 11, 'Ca 3', 'V', '2025-03-09', '2025-03-25 02:41:01'),
(985, 11, 'Ca 1', 'V', '2025-03-10', '2025-03-25 02:41:01'),
(986, 11, 'X', 'P', '2025-03-11', '2025-03-25 02:41:01'),
(987, 11, 'Ca 2', 'V', '2025-03-12', '2025-03-25 02:41:01'),
(988, 11, 'Ca 3', 'V', '2025-03-13', '2025-03-25 02:41:01'),
(989, 11, 'Ca 2', 'V', '2025-03-14', '2025-03-25 02:41:01'),
(990, 11, 'Ca 2', 'V', '2025-03-15', '2025-03-25 02:41:01'),
(991, 11, 'X', 'P', '2025-03-16', '2025-03-25 02:41:01'),
(992, 11, 'Ca 3', 'V', '2025-03-17', '2025-03-25 02:41:01'),
(993, 11, 'Ca 3', 'V', '2025-03-18', '2025-03-25 02:41:01'),
(994, 11, 'X', 'P', '2025-03-19', '2025-03-25 02:41:01'),
(995, 11, 'Ca 3', 'V', '2025-03-20', '2025-03-25 02:41:01'),
(996, 11, 'X', 'P', '2025-03-21', '2025-03-25 02:41:01'),
(997, 11, 'Ca 1', 'V', '2025-03-22', '2025-03-25 02:41:01'),
(998, 11, 'Ca 2', 'V', '2025-03-23', '2025-03-25 02:41:01'),
(999, 11, 'X', 'P', '2025-03-24', '2025-03-25 02:41:01'),
(1000, 11, 'Ca 1', 'V', '2025-03-25', '2025-03-25 02:41:01'),
(1001, 11, 'X', 'P', '2025-03-26', '2025-03-25 02:41:01'),
(1002, 11, 'Ca 1', 'V', '2025-03-27', '2025-03-25 02:41:01'),
(1003, 11, 'Ca 3', 'V', '2025-03-28', '2025-03-25 02:41:01'),
(1004, 11, 'Ca 1', 'V', '2025-03-29', '2025-03-25 02:41:01'),
(1005, 11, 'X', 'P', '2025-03-30', '2025-03-25 02:41:01'),
(1006, 11, 'Ca 3', 'V', '2025-03-31', '2025-03-25 02:41:01'),
(1007, 12, 'Ca 3', 'V', '2025-03-01', '2025-03-25 02:41:01'),
(1008, 12, 'Ca 3', 'V', '2025-03-02', '2025-03-25 02:41:01'),
(1009, 12, 'Ca 1', 'V', '2025-03-03', '2025-03-25 02:41:01'),
(1010, 12, 'Ca 1', 'V', '2025-03-04', '2025-03-25 02:41:01'),
(1011, 12, 'Ca 1', 'V', '2025-03-05', '2025-03-25 02:41:01'),
(1012, 12, 'Ca 3', 'V', '2025-03-06', '2025-03-25 02:41:01'),
(1013, 12, 'X', 'P', '2025-03-07', '2025-03-25 02:41:01'),
(1014, 12, 'Ca 3', 'V', '2025-03-08', '2025-03-25 02:41:01'),
(1015, 12, 'X', 'P', '2025-03-09', '2025-03-25 02:41:01'),
(1016, 12, 'Ca 2', 'V', '2025-03-10', '2025-03-25 02:41:01'),
(1017, 12, 'Ca 1', 'V', '2025-03-11', '2025-03-25 02:41:01'),
(1018, 12, 'X', 'P', '2025-03-12', '2025-03-25 02:41:01'),
(1019, 12, 'Ca 1', 'V', '2025-03-13', '2025-03-25 02:41:01'),
(1020, 12, 'Ca 1', 'V', '2025-03-14', '2025-03-25 02:41:01'),
(1021, 12, 'Ca 3', 'V', '2025-03-15', '2025-03-25 02:41:01'),
(1022, 12, 'X', 'P', '2025-03-16', '2025-03-25 02:41:01'),
(1023, 12, 'X', 'P', '2025-03-17', '2025-03-25 02:41:01'),
(1024, 12, 'Ca 2', 'V', '2025-03-18', '2025-03-25 02:41:01'),
(1025, 12, 'Ca 1', 'V', '2025-03-19', '2025-03-25 02:41:01'),
(1026, 12, 'Ca 3', 'V', '2025-03-20', '2025-03-25 02:41:01'),
(1027, 12, 'Ca 2', 'V', '2025-03-21', '2025-03-25 02:41:01'),
(1028, 12, 'X', 'P', '2025-03-22', '2025-03-25 02:41:01'),
(1029, 12, 'Ca 3', 'V', '2025-03-23', '2025-03-25 02:41:01'),
(1030, 12, 'Ca 2', 'V', '2025-03-24', '2025-03-25 02:41:01'),
(1031, 12, 'Ca 2', 'V', '2025-03-25', '2025-03-25 02:41:01'),
(1032, 12, 'Ca 3', 'V', '2025-03-26', '2025-03-25 02:41:01'),
(1033, 12, 'Ca 2', 'V', '2025-03-27', '2025-03-25 02:41:01'),
(1034, 12, 'Ca 2', 'V', '2025-03-28', '2025-03-25 02:41:01'),
(1035, 12, 'Ca 1', 'V', '2025-03-29', '2025-03-25 02:41:01'),
(1036, 12, 'Ca 1', 'V', '2025-03-30', '2025-03-25 02:41:01'),
(1037, 12, 'Ca 3', 'V', '2025-03-31', '2025-03-25 02:41:01'),
(1038, 1, 'Ca 2', 'X', '2025-03-07', '2025-03-25 02:41:13'),
(1039, 1, 'Ca 1', 'V', '2025-04-01', '2025-04-05 06:42:38'),
(1040, 1, 'Ca 2', 'V', '2025-04-02', '2025-04-05 06:42:38'),
(1041, 1, 'Ca 1', 'V', '2025-04-03', '2025-04-05 06:42:38'),
(1042, 1, 'Ca 1', 'V', '2025-04-04', '2025-04-05 06:42:38'),
(1043, 1, 'X', 'P', '2025-04-05', '2025-04-05 06:42:38'),
(1044, 1, 'Ca 1', 'V', '2025-04-06', '2025-04-05 06:42:38'),
(1045, 1, 'X', 'P', '2025-04-07', '2025-04-05 06:42:38'),
(1046, 1, 'X', 'P', '2025-04-08', '2025-04-05 06:42:38'),
(1047, 1, 'Ca 2', 'V', '2025-04-09', '2025-04-05 06:42:38'),
(1048, 1, 'X', 'P', '2025-04-10', '2025-04-05 06:42:38'),
(1049, 1, 'Ca 3', 'V', '2025-04-11', '2025-04-05 06:42:38'),
(1050, 1, 'Ca 2', 'V', '2025-04-12', '2025-04-05 06:42:38'),
(1051, 1, 'X', 'P', '2025-04-13', '2025-04-05 06:42:38'),
(1052, 1, 'Ca 2', 'V', '2025-04-14', '2025-04-05 06:42:38'),
(1053, 1, 'Ca 1', 'V', '2025-04-15', '2025-04-05 06:42:38'),
(1054, 1, 'Ca 2', 'V', '2025-04-16', '2025-04-05 06:42:38'),
(1055, 1, 'Ca 3', 'V', '2025-04-17', '2025-04-05 06:42:38'),
(1056, 1, 'Ca 3', 'V', '2025-04-18', '2025-04-05 06:42:38'),
(1057, 1, 'Ca 2', 'V', '2025-04-19', '2025-04-05 06:42:38'),
(1058, 1, 'Ca 1', 'V', '2025-04-20', '2025-04-05 06:42:38'),
(1059, 1, 'Ca 2', 'V', '2025-04-21', '2025-04-05 06:42:38'),
(1060, 1, 'Ca 2', 'V', '2025-04-22', '2025-04-05 06:42:38'),
(1061, 1, 'Ca 2', 'V', '2025-04-23', '2025-04-05 06:42:38'),
(1062, 1, 'Ca 1', 'V', '2025-04-24', '2025-04-05 06:42:38'),
(1063, 1, 'Ca 3', 'V', '2025-04-25', '2025-04-05 06:42:38'),
(1064, 1, 'X', 'P', '2025-04-26', '2025-04-05 06:42:38'),
(1065, 1, 'X', 'P', '2025-04-27', '2025-04-05 06:42:38'),
(1066, 1, 'Ca 2', 'V', '2025-04-28', '2025-04-05 06:42:38'),
(1067, 1, 'Ca 2', 'V', '2025-04-29', '2025-04-05 06:42:38'),
(1068, 1, 'Ca 2', 'V', '2025-04-30', '2025-04-05 06:42:38'),
(1069, 2, 'Ca 3', 'V', '2025-04-01', '2025-04-05 06:42:38'),
(1070, 2, 'Ca 3', 'V', '2025-04-02', '2025-04-05 06:42:38'),
(1071, 2, 'Ca 2', 'V', '2025-04-03', '2025-04-05 06:42:38'),
(1072, 2, 'Ca 2', 'V', '2025-04-04', '2025-04-05 06:42:38'),
(1073, 2, 'X', 'P', '2025-04-05', '2025-04-05 06:42:38'),
(1074, 2, 'Ca 1', 'V', '2025-04-06', '2025-04-05 06:42:38'),
(1075, 2, 'X', 'P', '2025-04-07', '2025-04-05 06:42:38'),
(1076, 2, 'Ca 2', 'V', '2025-04-08', '2025-04-05 06:42:38'),
(1077, 2, 'X', 'P', '2025-04-09', '2025-04-05 06:42:38'),
(1078, 2, 'X', 'P', '2025-04-10', '2025-04-05 06:42:38'),
(1079, 2, 'Ca 2', 'V', '2025-04-11', '2025-04-05 06:42:38'),
(1080, 2, 'Ca 3', 'V', '2025-04-12', '2025-04-05 06:42:38'),
(1081, 2, 'Ca 3', 'V', '2025-04-13', '2025-04-05 06:42:38'),
(1082, 2, 'Ca 2', 'V', '2025-04-14', '2025-04-05 06:42:38'),
(1083, 2, 'Ca 2', 'V', '2025-04-15', '2025-04-05 06:42:38'),
(1084, 2, 'Ca 1', 'V', '2025-04-16', '2025-04-05 06:42:38'),
(1085, 2, 'X', 'P', '2025-04-17', '2025-04-05 06:42:38'),
(1086, 2, 'Ca 1', 'V', '2025-04-18', '2025-04-05 06:42:38'),
(1087, 2, 'Ca 2', 'V', '2025-04-19', '2025-04-05 06:42:38'),
(1088, 2, 'X', 'P', '2025-04-20', '2025-04-05 06:42:38'),
(1089, 2, 'Ca 2', 'V', '2025-04-21', '2025-04-05 06:42:38'),
(1090, 2, 'Ca 2', 'V', '2025-04-22', '2025-04-05 06:42:38'),
(1091, 2, 'Ca 3', 'V', '2025-04-23', '2025-04-05 06:42:38'),
(1092, 2, 'Ca 2', 'V', '2025-04-24', '2025-04-05 06:42:38'),
(1093, 2, 'Ca 2', 'V', '2025-04-25', '2025-04-05 06:42:38'),
(1094, 2, 'Ca 1', 'V', '2025-04-26', '2025-04-05 06:42:38'),
(1095, 2, 'X', 'P', '2025-04-27', '2025-04-05 06:42:38'),
(1096, 2, 'Ca 1', 'V', '2025-04-28', '2025-04-05 06:42:38'),
(1097, 2, 'Ca 3', 'V', '2025-04-29', '2025-04-05 06:42:38'),
(1098, 2, 'Ca 3', 'V', '2025-04-30', '2025-04-05 06:42:38'),
(1099, 3, 'Ca 2', 'V', '2025-04-01', '2025-04-05 06:42:38'),
(1100, 3, 'Ca 1', 'V', '2025-04-02', '2025-04-05 06:42:38'),
(1101, 3, 'Ca 1', 'V', '2025-04-03', '2025-04-05 06:42:38'),
(1102, 3, 'Ca 2', 'V', '2025-04-04', '2025-04-05 06:42:38'),
(1103, 3, 'X', 'P', '2025-04-05', '2025-04-05 06:42:38'),
(1104, 3, 'Ca 2', 'V', '2025-04-06', '2025-04-05 06:42:38'),
(1105, 3, 'Ca 1', 'V', '2025-04-07', '2025-04-05 06:42:38'),
(1106, 3, 'Ca 3', 'V', '2025-04-08', '2025-04-05 06:42:38'),
(1107, 3, 'Ca 3', 'V', '2025-04-09', '2025-04-05 06:42:38'),
(1108, 3, 'Ca 3', 'V', '2025-04-10', '2025-04-05 06:42:38'),
(1109, 3, 'Ca 3', 'V', '2025-04-11', '2025-04-05 06:42:38'),
(1110, 3, 'X', 'P', '2025-04-12', '2025-04-05 06:42:38'),
(1111, 3, 'X', 'P', '2025-04-13', '2025-04-05 06:42:38'),
(1112, 3, 'Ca 2', 'V', '2025-04-14', '2025-04-05 06:42:38'),
(1113, 3, 'Ca 1', 'V', '2025-04-15', '2025-04-05 06:42:38'),
(1114, 3, 'Ca 2', 'V', '2025-04-16', '2025-04-05 06:42:38'),
(1115, 3, 'X', 'P', '2025-04-17', '2025-04-05 06:42:38'),
(1116, 3, 'Ca 2', 'V', '2025-04-18', '2025-04-05 06:42:38'),
(1117, 3, 'X', 'P', '2025-04-19', '2025-04-05 06:42:38'),
(1118, 3, 'Ca 2', 'V', '2025-04-20', '2025-04-05 06:42:38'),
(1119, 3, 'Ca 1', 'V', '2025-04-21', '2025-04-05 06:42:38'),
(1120, 3, 'Ca 1', 'V', '2025-04-22', '2025-04-05 06:42:38'),
(1121, 3, 'Ca 1', 'V', '2025-04-23', '2025-04-05 06:42:38'),
(1122, 3, 'Ca 2', 'V', '2025-04-24', '2025-04-05 06:42:38'),
(1123, 3, 'X', 'P', '2025-04-25', '2025-04-05 06:42:38'),
(1124, 3, 'Ca 1', 'V', '2025-04-26', '2025-04-05 06:42:38'),
(1125, 3, 'Ca 2', 'V', '2025-04-27', '2025-04-05 06:42:38'),
(1126, 3, 'Ca 3', 'V', '2025-04-28', '2025-04-05 06:42:38'),
(1127, 3, 'Ca 3', 'V', '2025-04-29', '2025-04-05 06:42:38'),
(1128, 3, 'X', 'P', '2025-04-30', '2025-04-05 06:42:38'),
(1129, 7, 'Ca 1', 'V', '2025-04-01', '2025-04-05 06:42:38'),
(1130, 7, 'Ca 1', 'V', '2025-04-02', '2025-04-05 06:42:38'),
(1131, 7, 'Ca 2', 'V', '2025-04-03', '2025-04-05 06:42:38'),
(1132, 7, 'X', 'P', '2025-04-04', '2025-04-05 06:42:38'),
(1133, 7, 'Ca 2', 'V', '2025-04-05', '2025-04-05 06:42:38'),
(1134, 7, 'Ca 1', 'V', '2025-04-06', '2025-04-05 06:42:38'),
(1135, 7, 'Ca 3', 'V', '2025-04-07', '2025-04-05 06:42:38'),
(1136, 7, 'Ca 3', 'V', '2025-04-08', '2025-04-05 06:42:38'),
(1137, 7, 'Ca 2', 'V', '2025-04-09', '2025-04-05 06:42:38'),
(1138, 7, 'Ca 1', 'V', '2025-04-10', '2025-04-05 06:42:38'),
(1139, 7, 'Ca 3', 'V', '2025-04-11', '2025-04-05 06:42:38'),
(1140, 7, 'Ca 1', 'V', '2025-04-12', '2025-04-05 06:42:38'),
(1141, 7, 'Ca 2', 'V', '2025-04-13', '2025-04-05 06:42:38'),
(1142, 7, 'Ca 2', 'V', '2025-04-14', '2025-04-05 06:42:38'),
(1143, 7, 'Ca 2', 'V', '2025-04-15', '2025-04-05 06:42:38'),
(1144, 7, 'Ca 1', 'V', '2025-04-16', '2025-04-05 06:42:38'),
(1145, 7, 'Ca 1', 'V', '2025-04-17', '2025-04-05 06:42:38'),
(1146, 7, 'X', 'P', '2025-04-18', '2025-04-05 06:42:38'),
(1147, 7, 'Ca 2', 'V', '2025-04-19', '2025-04-05 06:42:38'),
(1148, 7, 'Ca 3', 'V', '2025-04-20', '2025-04-05 06:42:38'),
(1149, 7, 'Ca 3', 'V', '2025-04-21', '2025-04-05 06:42:38'),
(1150, 7, 'Ca 3', 'V', '2025-04-22', '2025-04-05 06:42:38'),
(1151, 7, 'Ca 2', 'V', '2025-04-23', '2025-04-05 06:42:38'),
(1152, 7, 'Ca 2', 'V', '2025-04-24', '2025-04-05 06:42:38'),
(1153, 7, 'Ca 2', 'V', '2025-04-25', '2025-04-05 06:42:38'),
(1154, 7, 'X', 'P', '2025-04-26', '2025-04-05 06:42:38'),
(1155, 7, 'X', 'P', '2025-04-27', '2025-04-05 06:42:38'),
(1156, 7, 'Ca 3', 'V', '2025-04-28', '2025-04-05 06:42:38'),
(1157, 7, 'Ca 1', 'V', '2025-04-29', '2025-04-05 06:42:38'),
(1158, 7, 'Ca 2', 'V', '2025-04-30', '2025-04-05 06:42:38'),
(1159, 8, 'Ca 1', 'V', '2025-04-01', '2025-04-05 06:42:38'),
(1160, 8, 'Ca 2', 'V', '2025-04-02', '2025-04-05 06:42:38'),
(1161, 8, 'Ca 3', 'V', '2025-04-03', '2025-04-05 06:42:38'),
(1162, 8, 'Ca 3', 'V', '2025-04-04', '2025-04-05 06:42:38'),
(1163, 8, 'Ca 2', 'V', '2025-04-05', '2025-04-05 06:42:38'),
(1164, 8, 'Ca 3', 'V', '2025-04-06', '2025-04-05 06:42:38'),
(1165, 8, 'Ca 1', 'V', '2025-04-07', '2025-04-05 06:42:38'),
(1166, 8, 'X', 'P', '2025-04-08', '2025-04-05 06:42:38'),
(1167, 8, 'X', 'P', '2025-04-09', '2025-04-05 06:42:38'),
(1168, 8, 'Ca 2', 'V', '2025-04-10', '2025-04-05 06:42:38'),
(1169, 8, 'Ca 3', 'V', '2025-04-11', '2025-04-05 06:42:38'),
(1170, 8, 'Ca 1', 'V', '2025-04-12', '2025-04-05 06:42:38'),
(1171, 8, 'Ca 1', 'V', '2025-04-13', '2025-04-05 06:42:38'),
(1172, 8, 'Ca 1', 'V', '2025-04-14', '2025-04-05 06:42:38'),
(1173, 8, 'Ca 1', 'V', '2025-04-15', '2025-04-05 06:42:38'),
(1174, 8, 'Ca 1', 'V', '2025-04-16', '2025-04-05 06:42:38'),
(1175, 8, 'Ca 3', 'V', '2025-04-17', '2025-04-05 06:42:38'),
(1176, 8, 'Ca 2', 'V', '2025-04-18', '2025-04-05 06:42:38'),
(1177, 8, 'X', 'P', '2025-04-19', '2025-04-05 06:42:38'),
(1178, 8, 'Ca 3', 'V', '2025-04-20', '2025-04-05 06:42:38'),
(1179, 8, 'Ca 1', 'V', '2025-04-21', '2025-04-05 06:42:38'),
(1180, 8, 'X', 'P', '2025-04-22', '2025-04-05 06:42:38'),
(1181, 8, 'Ca 2', 'V', '2025-04-23', '2025-04-05 06:42:38'),
(1182, 8, 'X', 'P', '2025-04-24', '2025-04-05 06:42:38'),
(1183, 8, 'Ca 1', 'V', '2025-04-25', '2025-04-05 06:42:38'),
(1184, 8, 'Ca 3', 'V', '2025-04-26', '2025-04-05 06:42:38'),
(1185, 8, 'Ca 1', 'V', '2025-04-27', '2025-04-05 06:42:38'),
(1186, 8, 'X', 'P', '2025-04-28', '2025-04-05 06:42:38'),
(1187, 8, 'Ca 1', 'V', '2025-04-29', '2025-04-05 06:42:38'),
(1188, 8, 'Ca 1', 'V', '2025-04-30', '2025-04-05 06:42:38'),
(1189, 9, 'Ca 2', 'V', '2025-04-01', '2025-04-05 06:42:38'),
(1190, 9, 'X', 'P', '2025-04-02', '2025-04-05 06:42:38'),
(1191, 9, 'Ca 1', 'V', '2025-04-03', '2025-04-05 06:42:38'),
(1192, 9, 'X', 'P', '2025-04-04', '2025-04-05 06:42:39'),
(1193, 9, 'Ca 1', 'V', '2025-04-05', '2025-04-05 06:42:39'),
(1194, 9, 'Ca 2', 'V', '2025-04-06', '2025-04-05 06:42:39'),
(1195, 9, 'Ca 1', 'V', '2025-04-07', '2025-04-05 06:42:39'),
(1196, 9, 'Ca 1', 'V', '2025-04-08', '2025-04-05 06:42:39'),
(1197, 9, 'Ca 1', 'V', '2025-04-09', '2025-04-05 06:42:39'),
(1198, 9, 'Ca 2', 'V', '2025-04-10', '2025-04-05 06:42:39'),
(1199, 9, 'Ca 1', 'V', '2025-04-11', '2025-04-05 06:42:39'),
(1200, 9, 'Ca 3', 'V', '2025-04-12', '2025-04-05 06:42:39'),
(1201, 9, 'Ca 3', 'V', '2025-04-13', '2025-04-05 06:42:39'),
(1202, 9, 'X', 'P', '2025-04-14', '2025-04-05 06:42:39'),
(1203, 9, 'Ca 1', 'V', '2025-04-15', '2025-04-05 06:42:39'),
(1204, 9, 'Ca 2', 'V', '2025-04-16', '2025-04-05 06:42:39'),
(1205, 9, 'Ca 2', 'V', '2025-04-17', '2025-04-05 06:42:39'),
(1206, 9, 'Ca 1', 'V', '2025-04-18', '2025-04-05 06:42:39'),
(1207, 9, 'X', 'P', '2025-04-19', '2025-04-05 06:42:39'),
(1208, 9, 'Ca 2', 'V', '2025-04-20', '2025-04-05 06:42:39'),
(1209, 9, 'Ca 3', 'V', '2025-04-21', '2025-04-05 06:42:39'),
(1210, 9, 'X', 'P', '2025-04-22', '2025-04-05 06:42:39'),
(1211, 9, 'Ca 2', 'V', '2025-04-23', '2025-04-05 06:42:39'),
(1212, 9, 'X', 'P', '2025-04-24', '2025-04-05 06:42:39'),
(1213, 9, 'Ca 1', 'V', '2025-04-25', '2025-04-05 06:42:39'),
(1214, 9, 'X', 'P', '2025-04-26', '2025-04-05 06:42:39'),
(1215, 9, 'Ca 2', 'V', '2025-04-27', '2025-04-05 06:42:39'),
(1216, 9, 'Ca 3', 'V', '2025-04-28', '2025-04-05 06:42:39'),
(1217, 9, 'Ca 2', 'V', '2025-04-29', '2025-04-05 06:42:39'),
(1218, 9, 'Ca 1', 'V', '2025-04-30', '2025-04-05 06:42:39'),
(1219, 10, 'Ca 3', 'V', '2025-04-01', '2025-04-05 06:42:39'),
(1220, 10, 'Ca 1', 'V', '2025-04-02', '2025-04-05 06:42:39'),
(1221, 10, 'Ca 1', 'V', '2025-04-03', '2025-04-05 06:42:39'),
(1222, 10, 'Ca 3', 'V', '2025-04-04', '2025-04-05 06:42:39'),
(1223, 10, 'Ca 3', 'V', '2025-04-05', '2025-04-05 06:42:39'),
(1224, 10, 'Ca 3', 'V', '2025-04-06', '2025-04-05 06:42:39'),
(1225, 10, 'Ca 3', 'V', '2025-04-07', '2025-04-05 06:42:39'),
(1226, 10, 'Ca 3', 'V', '2025-04-08', '2025-04-05 06:42:39'),
(1227, 10, 'X', 'P', '2025-04-09', '2025-04-05 06:42:39'),
(1228, 10, 'Ca 3', 'V', '2025-04-10', '2025-04-05 06:42:39'),
(1229, 10, 'Ca 3', 'V', '2025-04-11', '2025-04-05 06:42:39'),
(1230, 10, 'X', 'P', '2025-04-12', '2025-04-05 06:42:39'),
(1231, 10, 'X', 'P', '2025-04-13', '2025-04-05 06:42:39'),
(1232, 10, 'X', 'P', '2025-04-14', '2025-04-05 06:42:39'),
(1233, 10, 'Ca 1', 'V', '2025-04-15', '2025-04-05 06:42:39'),
(1234, 10, 'Ca 3', 'V', '2025-04-16', '2025-04-05 06:42:39'),
(1235, 10, 'Ca 1', 'V', '2025-04-17', '2025-04-05 06:42:39'),
(1236, 10, 'Ca 2', 'V', '2025-04-18', '2025-04-05 06:42:39'),
(1237, 10, 'Ca 2', 'V', '2025-04-19', '2025-04-05 06:42:39'),
(1238, 10, 'Ca 1', 'V', '2025-04-20', '2025-04-05 06:42:39'),
(1239, 10, 'X', 'P', '2025-04-21', '2025-04-05 06:42:39'),
(1240, 10, 'Ca 3', 'V', '2025-04-22', '2025-04-05 06:42:39'),
(1241, 10, 'X', 'P', '2025-04-23', '2025-04-05 06:42:39'),
(1242, 10, 'X', 'P', '2025-04-24', '2025-04-05 06:42:39'),
(1243, 10, 'Ca 1', 'V', '2025-04-25', '2025-04-05 06:42:39'),
(1244, 10, 'Ca 2', 'V', '2025-04-26', '2025-04-05 06:42:39'),
(1245, 10, 'Ca 1', 'V', '2025-04-27', '2025-04-05 06:42:39'),
(1246, 10, 'Ca 2', 'V', '2025-04-28', '2025-04-05 06:42:39'),
(1247, 10, 'Ca 2', 'V', '2025-04-29', '2025-04-05 06:42:39'),
(1248, 10, 'X', 'P', '2025-04-30', '2025-04-05 06:42:39'),
(1249, 11, 'Ca 3', 'V', '2025-04-01', '2025-04-05 06:42:39'),
(1250, 11, 'X', 'P', '2025-04-02', '2025-04-05 06:42:39'),
(1251, 11, 'X', 'P', '2025-04-03', '2025-04-05 06:42:39'),
(1252, 11, 'Ca 2', 'V', '2025-04-04', '2025-04-05 06:42:39'),
(1253, 11, 'Ca 3', 'V', '2025-04-05', '2025-04-05 06:42:39'),
(1254, 11, 'X', 'P', '2025-04-06', '2025-04-05 06:42:39'),
(1255, 11, 'Ca 3', 'V', '2025-04-07', '2025-04-05 06:42:39'),
(1256, 11, 'Ca 2', 'V', '2025-04-08', '2025-04-05 06:42:39'),
(1257, 11, 'X', 'P', '2025-04-09', '2025-04-05 06:42:39'),
(1258, 11, 'X', 'P', '2025-04-10', '2025-04-05 06:42:39'),
(1259, 11, 'Ca 2', 'V', '2025-04-11', '2025-04-05 06:42:39'),
(1260, 11, 'X', 'P', '2025-04-12', '2025-04-05 06:42:39'),
(1261, 11, 'Ca 3', 'V', '2025-04-13', '2025-04-05 06:42:39'),
(1262, 11, 'Ca 1', 'V', '2025-04-14', '2025-04-05 06:42:39'),
(1263, 11, 'Ca 3', 'V', '2025-04-15', '2025-04-05 06:42:39'),
(1264, 11, 'Ca 2', 'V', '2025-04-16', '2025-04-05 06:42:39'),
(1265, 11, 'Ca 2', 'V', '2025-04-17', '2025-04-05 06:42:39'),
(1266, 11, 'Ca 1', 'V', '2025-04-18', '2025-04-05 06:42:39'),
(1267, 11, 'X', 'P', '2025-04-19', '2025-04-05 06:42:39'),
(1268, 11, 'Ca 3', 'V', '2025-04-20', '2025-04-05 06:42:39'),
(1269, 11, 'Ca 2', 'V', '2025-04-21', '2025-04-05 06:42:39'),
(1270, 11, 'Ca 3', 'V', '2025-04-22', '2025-04-05 06:42:39'),
(1271, 11, 'X', 'P', '2025-04-23', '2025-04-05 06:42:39'),
(1272, 11, 'Ca 2', 'V', '2025-04-24', '2025-04-05 06:42:39'),
(1273, 11, 'X', 'P', '2025-04-25', '2025-04-05 06:42:39'),
(1274, 11, 'Ca 1', 'V', '2025-04-26', '2025-04-05 06:42:39'),
(1275, 11, 'Ca 1', 'V', '2025-04-27', '2025-04-05 06:42:39'),
(1276, 11, 'X', 'P', '2025-04-28', '2025-04-05 06:42:39'),
(1277, 11, 'X', 'P', '2025-04-29', '2025-04-05 06:42:39'),
(1278, 11, 'Ca 2', 'V', '2025-04-30', '2025-04-05 06:42:39'),
(1279, 12, 'Ca 3', 'V', '2025-04-01', '2025-04-05 06:42:39'),
(1280, 12, 'X', 'P', '2025-04-02', '2025-04-05 06:42:39'),
(1281, 12, 'X', 'P', '2025-04-03', '2025-04-05 06:42:39'),
(1282, 12, 'Ca 3', 'V', '2025-04-04', '2025-04-05 06:42:39'),
(1283, 12, 'Ca 3', 'V', '2025-04-05', '2025-04-05 06:42:39'),
(1284, 12, 'Ca 2', 'V', '2025-04-06', '2025-04-05 06:42:39'),
(1285, 12, 'X', 'P', '2025-04-07', '2025-04-05 06:42:39'),
(1286, 12, 'Ca 2', 'V', '2025-04-08', '2025-04-05 06:42:39'),
(1287, 12, 'X', 'P', '2025-04-09', '2025-04-05 06:42:39'),
(1288, 12, 'Ca 2', 'V', '2025-04-10', '2025-04-05 06:42:39'),
(1289, 12, 'X', 'P', '2025-04-11', '2025-04-05 06:42:39'),
(1290, 12, 'Ca 3', 'V', '2025-04-12', '2025-04-05 06:42:39'),
(1291, 12, 'Ca 3', 'V', '2025-04-13', '2025-04-05 06:42:39'),
(1292, 12, 'Ca 2', 'V', '2025-04-14', '2025-04-05 06:42:39'),
(1293, 12, 'Ca 1', 'V', '2025-04-15', '2025-04-05 06:42:39'),
(1294, 12, 'Ca 2', 'V', '2025-04-16', '2025-04-05 06:42:39'),
(1295, 12, 'X', 'P', '2025-04-17', '2025-04-05 06:42:39'),
(1296, 12, 'Ca 3', 'V', '2025-04-18', '2025-04-05 06:42:39'),
(1297, 12, 'Ca 2', 'V', '2025-04-19', '2025-04-05 06:42:39'),
(1298, 12, 'Ca 1', 'V', '2025-04-20', '2025-04-05 06:42:39'),
(1299, 12, 'Ca 3', 'V', '2025-04-21', '2025-04-05 06:42:39'),
(1300, 12, 'X', 'P', '2025-04-22', '2025-04-05 06:42:39'),
(1301, 12, 'Ca 3', 'V', '2025-04-23', '2025-04-05 06:42:39'),
(1302, 12, 'Ca 2', 'V', '2025-04-24', '2025-04-05 06:42:39'),
(1303, 12, 'Ca 1', 'V', '2025-04-25', '2025-04-05 06:42:39'),
(1304, 12, 'Ca 3', 'V', '2025-04-26', '2025-04-05 06:42:39'),
(1305, 12, 'Ca 2', 'V', '2025-04-27', '2025-04-05 06:42:39'),
(1306, 12, 'Ca 2', 'V', '2025-04-28', '2025-04-05 06:42:39'),
(1307, 12, 'Ca 1', 'V', '2025-04-29', '2025-04-05 06:42:39'),
(1308, 12, 'X', 'P', '2025-04-30', '2025-04-05 06:42:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tichdiem`
--

CREATE TABLE `tichdiem` (
  `idtd` int(11) NOT NULL,
  `idkh` int(11) NOT NULL,
  `hangTV` varchar(50) DEFAULT NULL,
  `diem` int(11) DEFAULT 0,
  `sotour` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tichdiem`
--

INSERT INTO `tichdiem` (`idtd`, `idkh`, `hangTV`, `diem`, `sotour`) VALUES
(3, 17, 'New', 100, 0),
(22, 20, 'New', 100, 0),
(23, 1, 'New', 552, 0),
(30, 27, 'New', 100, 0),
(32, 29, 'New', 100, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour`
--

CREATE TABLE `tour` (
  `id` int(11) NOT NULL,
  `idks` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Style` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `Child_price_percen` varchar(255) NOT NULL,
  `Max_participant` int(11) NOT NULL,
  `Min_participant` int(11) NOT NULL,
  `Description` text NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Depart` varchar(255) NOT NULL,
  `DepartureLocation` varchar(255) NOT NULL,
  `Itinerary` text NOT NULL,
  `employeesId` int(11) NOT NULL,
  `type` enum('Gia đình','Theo đoàn','Theo nhóm nhỏ') NOT NULL,
  `timetour` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL,
  `vehicle` enum('Xe khách','Máy bay','Du thuyền') NOT NULL,
  `vung` enum('Nam','Trung','Bắc','Ngoài nước','Tây') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tour`
--

INSERT INTO `tour` (`id`, `idks`, `Name`, `Style`, `Price`, `Child_price_percen`, `Max_participant`, `Min_participant`, `Description`, `Status`, `Depart`, `DepartureLocation`, `Itinerary`, `employeesId`, `type`, `timetour`, `discount`, `vehicle`, `vung`) VALUES
(46, 9, 'Hà Nội', 'Hiện đại', 2400000, '45', 30, 10, 'Hà Nội, thủ đô của Việt Nam, nổi bật với sự kết hợp hài hòa giữa vẻ đẹp cổ kính và sự phát triển hiện đại. Nếu bạn có dịp đến thăm Hà Nội, một tour tham quan sẽ là cách tuyệt vời để khám phá những điểm đến nổi bật và tìm hiểu về lịch sử, văn hóa, cũng như ẩm thực đặc sắc của thành phố này.\\r\\n\\r\\nCác điểm tham quan nổi bật trong Tour Hà Nội:\\r\\nHoàn Kiếm và Hồ Gươm:\\r\\n\\r\\nĐây là biểu tượng của Hà Nội, gắn liền với câu chuyện lịch sử và truyền thuyết về thanh gươm. Du khách có thể tham quan đền Ngọc Sơn, tháp Rùa, và đi dạo quanh hồ để tận hưởng không gian yên bình giữa lòng thành phố.\\r\\nKhu phố cổ Hà Nội:\\r\\n\\r\\nKhu phố cổ là nơi lưu giữ nét đẹp truyền thống của Hà Nội với những ngôi nhà cổ, các con phố nhỏ hẹp và các cửa hàng bán đồ thủ công, đặc sản. Đây cũng là nơi bạn có thể thưởng thức nhiều món ăn đặc sản như phở, bún chả, nem rán.\\r\\nLăng Chủ tịch Hồ Chí Minh:\\r\\n\\r\\nLăng Hồ Chí Minh là nơi an nghỉ của Chủ tịch Hồ Chí Minh, vị lãnh tụ vĩ đại của dân tộc Việt Nam. Đây là một trong những điểm đến không thể thiếu trong hành trình khám phá Hà Nội.\\r\\nChùa Một Cột:\\r\\n\\r\\nĐây là ngôi chùa nổi tiếng với kiến trúc độc đáo, được xây dựng trên một cột đá duy nhất, mang đậm dấu ấn văn hóa Phật giáo của Hà Nội.\\r\\nBảo tàng Dân tộc học Việt Nam:\\r\\n\\r\\nMột trong những bảo tàng nổi bật tại Hà Nội, nơi lưu giữ và trưng bày các hiện vật, hình ảnh về các dân tộc và nền văn hóa đa dạng của Việt Nam.\\r\\nVăn Miếu – Quốc Tử Giám:\\r\\n\\r\\nLà trường đại học đầu tiên của Việt Nam, Văn Miếu không chỉ có giá trị lịch sử mà còn là biểu tượng của nền giáo dục Việt Nam xưa.\\r\\nHồ Tây:\\r\\n\\r\\nHồ Tây là hồ lớn nhất và đẹp nhất Hà Nội, thích hợp cho những ai muốn thư giãn, dạo bộ quanh hồ hoặc thưởng thức cà phê tại các quán ven hồ.\\r\\nHoạt động trong Tour Hà Nội:\\r\\nThưởng thức ẩm thực Hà Nội: Không thể thiếu khi tham gia tour Hà Nội là việc thưởng thức các món ăn đặc trưng như phở, bún thang, bún chả, cốm làng Vòng, và các loại chè truyền thống.\\r\\nTham quan các chợ truyền thống: Chợ Đồng Xuân, chợ Hàng Da, và chợ đêm Hà Nội là những nơi bạn có thể mua sắm đồ lưu niệm hoặc các sản phẩm thủ công độc đáo.\\r\\nDạo thuyền trên Hồ Tây hoặc Hồ Hoàn Kiếm: Trải nghiệm dạo thuyền giúp bạn cảm nhận không gian yên bình và lãng mạn của Hà Nội.\\r\\nThời gian lý tưởng cho Tour Hà Nội:\\r\\nHà Nội có bốn mùa rõ rệt, và mỗi mùa đều mang một vẻ đẹp đặc trưng:\\r\\n\\r\\nMùa xuân (tháng 1 – tháng 3): Thời tiết mát mẻ, cây cối đâm chồi nảy lộc, thích hợp cho việc tham quan.\\r\\nMùa hè (tháng 5 – tháng 8): Thời tiết ấm áp, phù hợp để tham quan các hồ, công viên và thưởng thức món ăn đường phố.\\r\\nMùa thu (tháng 9 – tháng 11): Mùa thu Hà Nội nổi tiếng với không khí mát mẻ, là thời điểm lý tưởng để dạo chơi và tận hưởng vẻ đẹp của các con phố cổ.\\r\\nMùa đông (tháng 12 – tháng 2): Mùa đông Hà Nội có khí lạnh, thích hợp cho những ai yêu thích sự yên tĩnh và lãng mạn.\', \'Active\', \'2025-01-17\', \'TP.Hồ Chí Minh\', \'Day 1:Hà Nội Day2:Hồ\', 1, \'Gia đình\', \'2 ngày 1 đêm\', 1900000, \'Máy bay\', \'Bắc\'),\r\n\r\n', 'Hoạt động', '2025-03-17', 'TP.Hồ Chí Minh', 'Day 1:Hà Nội \r\nDay2:Hồ', 1, 'Gia đình', '2 ngày 1 đêm', 1900000, 'Máy bay', 'Bắc'),
(47, 9, 'Đà Nẵng', 'Cổ đại', 1900000, '40', 30, 10, 'Đà Nẵng, thành phố ven biển xinh đẹp của miền Trung Việt Nam, nổi bật với những bãi biển dài, cảnh quan thiên nhiên tuyệt đẹp, các di tích lịch sử, và ẩm thực đặc sắc. Tour Đà Nẵng là cơ hội tuyệt vời để khám phá một trong những thành phố năng động và phát triển bậc nhất của Việt Nam, nơi kết hợp giữa vẻ đẹp hiện đại và truyền thống.\\r\\n\\r\\nCác điểm tham quan nổi bật trong Tour Đà Nẵng:\\r\\nBà Nà Hills:\\r\\n\\r\\nBà Nà Hills là một trong những điểm du lịch nổi tiếng nhất tại Đà Nẵng, đặc biệt với cáp treo đạt kỷ lục thế giới về chiều dài. Bạn sẽ được thưởng ngoạn vẻ đẹp hùng vĩ của núi rừng và tham quan Cầu Vàng - cây cầu với đôi bàn tay khổng lồ nâng đỡ, tạo nên một khung cảnh độc đáo và ấn tượng.\\r\\nCầu Rồng:\\r\\n\\r\\nCầu Rồng là một trong những biểu tượng nổi bật của Đà Nẵng. Đặc biệt, vào mỗi cuối tuần, cầu Rồng có thể phun lửa và phun nước, tạo nên một cảnh tượng tuyệt vời thu hút nhiều du khách.\\r\\nBãi biển Mỹ Khê:\\r\\n\\r\\nVới bờ cát trắng mịn và làn nước trong xanh, Mỹ Khê là một trong những bãi biển đẹp nhất của Đà Nẵng, nơi du khách có thể thư giãn, tắm biển, tham gia các hoạt động thể thao dưới nước, hoặc thưởng thức các món hải sản tươi ngon.\\r\\nNgũ Hành Sơn:\\r\\n\\r\\nNgũ Hành Sơn là một nhóm năm ngọn núi đá vôi nổi bật, được đặt theo tên của các yếu tố trong ngũ hành (Kim, Mộc, Thủy, Hỏa, Thổ). Du khách có thể tham quan các chùa, động, và thưởng ngoạn toàn cảnh Đà Nẵng từ trên cao.\\r\\nChùa Linh Ứng:\\r\\n\\r\\nChùa Linh Ứng nằm trên bán đảo Sơn Trà, là một trong những ngôi chùa nổi tiếng với tượng Phật Bà Quan Âm cao nhất Việt Nam. Không gian yên tĩnh và cảnh quan tuyệt đẹp tại đây sẽ khiến bạn cảm thấy thư giãn và tĩnh tâm.\\r\\nCông viên Châu Á - Asia Park:\\r\\n\\r\\nLà khu vui chơi giải trí lớn với các trò chơi hấp dẫn, Asia Park đặc biệt nổi bật với Vòng quay mặt trời (Sun Wheel) cao nhất Việt Nam, từ đây du khách có thể nhìn ngắm toàn cảnh thành phố Đà Nẵng.\\r\\nCổ Viện Chàm:\\r\\n\\r\\nCổ Viện Chàm là nơi trưng bày các hiện vật văn hóa Chămpa cổ xưa, giúp du khách hiểu thêm về nền văn minh Chămpa từng phát triển mạnh mẽ tại miền Trung Việt Nam.\\r\\nHoạt động trong Tour Đà Nẵng:\\r\\nTham quan các điểm di tích lịch sử: Khám phá các ngôi chùa, di tích và bảo tàng như Chùa Linh Ứng, Cổ Viện Chàm, để tìm hiểu về lịch sử và văn hóa đặc sắc của Đà Nẵng và miền Trung.\\r\\nThưởng thức ẩm thực Đà Nẵng: Đà Nẵng nổi tiếng với các món ăn đặc sản như mì Quảng, bún chả cá, bánh tráng cuốn thịt heo, hải sản tươi sống. Đừng quên ghé qua các quán ăn ven biển để thưởng thức những món ngon.\\r\\nTrải nghiệm các hoạt động thể thao: Đà Nẵng có rất nhiều hoạt động thú vị như lướt sóng, chèo thuyền kayak, và các trò chơi thể thao dưới nước tại các bãi biển.\\r\\nThời gian lý tưởng cho Tour Đà Nẵng:\\r\\nMùa xuân (tháng 1 – tháng 3): Thời tiết mát mẻ và dễ chịu, rất thích hợp cho việc tham quan.\\r\\nMùa hè (tháng 5 – tháng 8): Thời gian lý tưởng để tắm biển và tham gia các hoạt động thể thao ngoài trời.\\r\\nMùa thu (tháng 9 – tháng 11): Thời tiết dễ chịu, không quá nóng và ít mưa, phù hợp để tham quan các điểm du lịch.\\r\\nMùa đông (tháng 12 – tháng 2): Mùa lạnh, thích hợp cho những ai muốn tránh cái cái nóng của mùa hè và tận hưởng không khí trong lành.', 'Hoạt động', '2025-03-25', 'TP.Hồ Chí Minh', 'Day 1:Đà nẵng', 1, 'Theo đoàn', '2 ngày 1 đêm', 0, 'Máy bay', 'Nam'),
(48, 9, 'Huế', 'Hiện đại', 1000000, '30', 12, 1, 'thành phố cổ kính nằm bên dòng sông Hương, là một trong những điểm du lịch hấp dẫn nhất ở miền Trung Việt Nam. Nổi bật với di sản văn hóa phong phú, những công trình lịch sử, và cảnh sắc thiên nhiên đẹp như tranh vẽ, Huế luôn thu hút du khách với vẻ đẹp trầm mặc, huyền bí và lãng mạn. Tour Huế là cơ hội tuyệt vời để bạn khám phá những nét đặc sắc của vùng đất cố đô này.\\r\\n\\r\\nCác điểm tham quan nổi bật trong Tour Huế:\\r\\nKinh Thành Huế (Hoàng Cung):\\r\\n\\r\\nKinh Thành Huế là di sản văn hóa thế giới được UNESCO công nhận, là nơi vua Gia Long xây dựng trong thế kỷ 19, là trung tâm chính trị và văn hóa của triều đại Nguyễn. Bạn sẽ được tham quan Ngọ Môn, Cửu Đỉnh, Đại Nội, Điện Thái Hòa và nhiều công trình kiến trúc khác trong khu vực hoàng cung này.\\r\\nLăng Tẩm các vua Nguyễn:\\r\\n\\r\\nHuế nổi tiếng với các lăng tẩm của các vua triều Nguyễn, mỗi lăng có một kiến trúc riêng biệt và ẩn chứa câu chuyện lịch sử thú vị. Các lăng nổi tiếng như Lăng Khải Định, Lăng Minh Mạng, Lăng Gia Long, hay Lăng Tự Đức đều mang đậm dấu ấn kiến trúc cổ kính và sự trang nghiêm của triều đại Nguyễn.\\r\\nChùa Thiên Mụ:\\r\\n\\r\\nChùa Thiên Mụ là ngôi chùa cổ nhất và nổi tiếng nhất ở Huế, nằm trên đồi Hà Khê bên bờ sông Hương. Đây là một trong những biểu tượng của Huế, với kiến trúc độc đáo và tầm nhìn tuyệt đẹp ra sông Hương.\\r\\nSông Hương:\\r\\n\\r\\nSông Hương là một phần không thể thiếu trong Tour Huế, du khách có thể đi thuyền trên sông, tận hưởng cảnh đẹp hai bên bờ sông, chiêm ngưỡng các làng nghề truyền thống và thưởng thức những làn điệu ca Huế đặc sắc.\\r\\nChợ Đông Ba:\\r\\n\\r\\nChợ Đông Ba là chợ truyền thống lâu đời của Huế, nơi du khách có thể tìm mua những sản phẩm thủ công mỹ nghệ, đồ lưu niệm, quà tặng và các món ăn đặc sản nổi tiếng của Huế như bánh bèo, bánh nậm, cơm hến.\\r\\nCầu Trường Tiền:\\r\\n\\r\\nCầu Trường Tiền là biểu tượng của thành phố Huế, một cây cầu lịch sử nối liền hai bờ sông Hương. Cầu được xây dựng từ thời Pháp thuộc, mang một vẻ đẹp cổ kính, đặc biệt khi về đêm, ánh đèn lấp lánh phản chiếu trên mặt nước tạo nên cảnh tượng tuyệt đẹp.\\r\\nLàng nghề truyền thống Huế:\\r\\n\\r\\nHuế nổi tiếng với nhiều làng nghề truyền thống như làng nón lá Phú Cam, làng gốm Thanh Tiên, hay làng tranh dân gian. Bạn có thể tham quan các làng nghề này để tìm hiểu về quá trình sản xuất các sản phẩm thủ công mỹ nghệ độc đáo của Huế.\\r\\nHoạt động trong Tour Huế:\\r\\nTham quan các di tích lịch sử: Khám phá Kinh Thành Huế, các lăng tẩm của các vua Nguyễn, và các ngôi chùa, di tích văn hóa đặc sắc.\\r\\nThưởng thức ẩm thực Huế: Huế là thiên đường ẩm thực với các món ăn đặc trưng như bánh bèo, bánh nậm, bánh canh, cơm hến, bánh huế. Du khách có thể thưởng thức các món ăn truyền thống ngay tại các quán ăn, nhà hàng trong thành phố.\\r\\nTrải nghiệm văn hóa ca Huế: Ca Huế, loại hình âm nhạc truyền thống của Huế, là một phần không thể thiếu trong các tour tham quan. Bạn có thể nghe ca Huế trên sông Hương hoặc tại các nhà hát.\\r\\nThời gian lý tưởng cho Tour Huế:\\r\\nMùa xuân (tháng 1 – tháng 3): Thời tiết mát mẻ, dễ chịu, là thời điểm lý tưởng để tham quan các di tích và thưởng thức ẩm thực Huế.\\r\\nMùa hè (tháng 4 – tháng 6): Thời tiết nóng, thích hợp cho những ai muốn khám phá các bãi biển gần Huế như Lăng Cô.\\r\\nMùa thu (tháng 9 – tháng 11): Mùa mưa ở Huế, nhưng cũng là thời điểm Huế có khí hậu mát mẻ và ít khách du lịch, thích hợp cho những ai muốn tránh đám đông.\\r\\nMùa đông (tháng 12 – tháng 2): Huế trở nên lạnh và sương mù, tạo ra một không gian lãng mạn và huyền bí, phù hợp cho những chuyến du lịch nghỉ dưỡng.', 'Hoạt động', '2025-03-21', 'TP.Hồ Chí Minh', 'Lịch trình ngày 1:\r\nLịch trình ngày 2:', 1, 'Theo nhóm nhỏ', '2 ngày 1 đêm', 900000, 'Xe khách', 'Trung'),
(49, 9, 'Sapa', 'Hiện đại', 3100000, '40', 40, 10, 'Sapa, một thị trấn nhỏ nằm ở phía Tây Bắc Việt Nam, nổi tiếng với những cảnh quan thiên nhiên hùng vĩ, văn hóa độc đáo của các dân tộc thiểu số, và khí hậu mát mẻ quanh năm. Đây là một điểm đến lý tưởng cho những ai yêu thích khám phá thiên nhiên, tận hưởng không khí trong lành và tìm hiểu về các phong tục tập quán đặc sắc của các cộng đồng dân tộc như H\\\'mông, Dao, Tày, Giáy. Tour Sapa mang đến cho du khách những trải nghiệm tuyệt vời về một vùng đất đầy bí ẩn và vẻ đẹp thiên nhiên.\\r\\n\\r\\nCác điểm tham quan nổi bật trong Tour Sapa:\\r\\nFansipan – Nóc nhà của Đông Dương:\\r\\n\\r\\nFansipan là đỉnh núi cao nhất Đông Dương, với độ cao 3.143m. Du khách có thể tham gia các tour leo núi, hoặc nếu không muốn leo, có thể đi cáp treo để chiêm ngưỡng toàn cảnh thiên nhiên hùng vĩ của Sapa từ trên cao.\\r\\nThị trấn Sapa:\\r\\n\\r\\nThị trấn Sapa nổi bật với những ngôi nhà có kiến trúc Pháp cổ, các khu chợ địa phương và không gian yên bình. Du khách có thể tản bộ dọc các con phố để cảm nhận vẻ đẹp thơ mộng của thị trấn này, thưởng thức các món ăn đặc sản và mua sắm các sản phẩm thủ công.\\r\\nBản Cát Cát:\\r\\n\\r\\nBản Cát Cát là một trong những bản làng của người H\\\'mông, nơi bạn có thể tìm hiểu về đời sống và văn hóa của người dân tộc thiểu số. Tại đây, bạn có thể tham quan các ngôi nhà truyền thống, xem các hoạt động sản xuất thổ cẩm, dệt vải và thưởng thức các món ăn đặc trưng.\\r\\nThung lũng Mường Hoa:\\r\\n\\r\\nThung lũng Mường Hoa nổi tiếng với những cánh đồng lúa bậc thang xanh mướt, những con suối trong vắt và những bãi đá cổ với những hình vẽ kỳ lạ. Đây là nơi lý tưởng để chụp ảnh và thưởng thức cảnh đẹp thiên nhiên hoang sơ.\\r\\nBản Tả Phìn:\\r\\n\\r\\nBản Tả Phìn là nơi sinh sống của người Dao Đỏ, nổi tiếng với nghề thêu tay và các sản phẩm thủ công mỹ nghệ. Du khách có thể tham gia các hoạt động tìm hiểu về văn hóa địa phương, ngắm cảnh và mua sắm các sản phẩm thủ công độc đáo.\\r\\nHồ Sapa:\\r\\n\\r\\nHồ Sapa là một trong những điểm du lịch nổi tiếng của thị trấn. Bạn có thể đi dạo quanh hồ, thư giãn và tận hưởng không khí trong lành của vùng núi cao.\\r\\nChợ Sapa:\\r\\n\\r\\nChợ Sapa là nơi tụ tập của các dân tộc thiểu số, đặc biệt là vào cuối tuần. Du khách có thể tìm mua các sản phẩm thủ công truyền thống như thổ cẩm, vòng tay, trang sức, và thưởng thức các món ăn đặc sản địa phương như thịt trâu gác bếp, xôi ngũ sắc.\\r\\nHoạt động trong Tour Sapa:\\r\\nTrekking và leo núi: Khám phá các bản làng xa xôi, leo núi Fansipan, hoặc trekking qua những con đường mòn, các thửa ruộng bậc thang.\\r\\nTham quan các bản làng: Ghé thăm các bản làng của người H\\\'mông, Dao, Tày, Giáy để tìm hiểu về đời sống và văn hóa đặc sắc của các dân tộc thiểu số.\\r\\nTrải nghiệm ẩm thực Sapa: Sapa nổi tiếng với các món ăn đặc sản như thịt trâu gác bếp, cá hồi Sapa, xôi ngũ sắc, măng rừng, và rượu cần.\\r\\nThăm các khu chợ: Chợ Sapa, chợ Tả Phìn, chợ Cát Cát… là những nơi bạn có thể mua sắm các sản phẩm thổ cẩm, đồ lưu niệm độc đáo.\\r\\nThời gian lý tưởng cho Tour Sapa:\\r\\nMùa xuân (tháng 1 – tháng 3): Đây là mùa hoa mận, hoa đào nở rộ, khung cảnh đẹp như tranh vẽ, thích hợp cho những ai muốn tận hưởng không khí mát mẻ và cảnh sắc tươi mới.\\r\\nMùa hè (tháng 4 – tháng 6): Thời gian lý tưởng để tham gia trekking, leo núi và khám phá thiên nhiên. Sapa vào mùa hè có khí hậu mát mẻ và dễ chịu, rất thích hợp cho các hoạt động ngoài trời.\\r\\nMùa thu (tháng 9 – tháng 11): Đây là mùa lúa chín, các cánh đồng lúa bậc thang ở Sapa khoác lên mình màu vàng óng ả. Đây là thời điểm tuyệt vời để thưởng thức cảnh sắc thiên nhiên tuyệt đẹp.\\r\\nMùa đông (tháng 12 – tháng 2): Sapa vào mùa đông có thể rất lạnh, thậm chí có tuyết rơi, tạo nên một không gian huyền bí và lãng mạn, rất thích hợp cho những ai yêu thích sự yên tĩnh và muốn trải nghiệm khí hậu lạnh.', 'Hoạt động', '2025-03-18', 'TP.Hồ Chí Minh', 'Lịch trình ngày 1:\r\nLịch trình ngày 2:\r\nLịch trình ngày 3:', 1, 'Theo đoàn', '3 ngày 2 đêm', 2900000, 'Du thuyền', 'Bắc'),
(50, 9, 'Phú Quốc', 'Hiện đại', 5500000, '35', 50, 10, 'Phú Quốc, hòn đảo ngọc xinh đẹp của Việt Nam, nằm ở vịnh Thái Lan, được biết đến với bãi biển trong xanh, cát trắng mịn, thiên nhiên hoang sơ và hệ sinh thái phong phú. Đây là một trong những điểm du lịch hấp dẫn bậc nhất tại Việt Nam, thu hút du khách bởi cảnh quan thiên nhiên tuyệt vời, ẩm thực đặc sản độc đáo và những hoạt động giải trí thú vị. Tour Phú Quốc sẽ đưa bạn đến khám phá vẻ đẹp của thiên đường du lịch biển đảo này.\\r\\n\\r\\nCác điểm tham quan nổi bật trong Tour Phú Quốc:\\r\\nBãi Sao:\\r\\n\\r\\nBãi Sao là một trong những bãi biển đẹp nhất Phú Quốc, với cát trắng mịn và làn nước trong xanh. Nơi đây còn được biết đến với vẻ đẹp hoang sơ, là địa điểm lý tưởng để tắm biển, thư giãn và tham gia các hoạt động thể thao dưới nước như lướt ván, chèo thuyền kayak.\\r\\nVinpearl Safari Phú Quốc:\\r\\n\\r\\nVinpearl Safari là khu bảo tồn động vật bán hoang dã lớn nhất Việt Nam, nơi bạn có thể tham quan các loài động vật quý hiếm như hươu cao cổ, vượn, sư tử và các loài động vật hoang dã khác trong môi trường tự nhiên.\\r\\nCông viên giải trí VinWonders Phú Quốc:\\r\\n\\r\\nVinWonders Phú Quốc là công viên giải trí lớn, nơi du khách có thể trải nghiệm các trò chơi cảm giác mạnh, khám phá các khu vực chủ đề như Khu vui chơi nước, Thế giới phiêu lưu, và thưởng thức các chương trình biểu diễn đặc sắc.\\r\\nDinh Cậu:\\r\\n\\r\\nDinh Cậu là một ngôi đền nhỏ nằm trên một mỏm đá, với cảnh quan tuyệt đẹp hướng ra biển. Đây là nơi cầu bình an, may mắn và cũng là một điểm du lịch tâm linh quan trọng tại Phú Quốc.\\r\\nHòn Móng Tay:\\r\\n\\r\\nHòn Móng Tay là một hòn đảo nhỏ hoang sơ, với nước biển trong vắt và những bãi cát trắng mịn. Đây là một địa điểm lý tưởng để lặn ngắm san hô, tắm biển và tham gia các hoạt động ngoài trời.\\r\\nChùa Hộ Quốc (Thiền viện Trúc Lâm Phú Quốc):\\r\\n\\r\\nChùa Hộ Quốc là một trong những ngôi chùa lớn và đẹp tại Phú Quốc, được xây dựng theo kiến trúc cổ điển của Phật giáo. Tọa lạc trên đỉnh núi, chùa mang đến một không gian thanh tịnh, yên bình và có tầm nhìn rộng ra biển.\\r\\nChợ Dương Đông:\\r\\n\\r\\nChợ Dương Đông là một trong những khu chợ lớn và nhộn nhịp tại Phú Quốc. Du khách có thể đến đây để thưởng thức các món ăn đặc sản địa phương như hải sản tươi sống, bánh tét mật cật, nước mắm Phú Quốc và mua sắm các món quà lưu niệm.\\r\\nHoạt động trong Tour Phú Quốc:\\r\\nTắm biển và tham gia các hoạt động thể thao dưới nước: Phú Quốc nổi tiếng với các bãi biển đẹp như Bãi Sao, Bãi Dài, và Bãi Kem, là nơi lý tưởng để tắm biển, tham gia lướt sóng, chèo thuyền kayak và lặn ngắm san hô.\\r\\nKhám phá các đảo nhỏ: Du khách có thể tham gia các tour khám phá các đảo nhỏ quanh Phú Quốc như Hòn Móng Tay, Hòn Gầm Ghì, Hòn Đồi Mồi, để tận hưởng vẻ đẹp thiên nhiên hoang sơ và tham gia các hoạt động lặn ngắm san hô.\\r\\nThưởng thức ẩm thực Phú Quốc: Phú Quốc là thiên đường ẩm thực với các món hải sản tươi ngon như tôm hùm, cua huỳnh đế, nghêu, sò, ốc, đặc biệt là nước mắm Phú Quốc nổi tiếng. Du khách cũng có thể thưởng thức các món ăn đặc sản như bánh tét mật cật, bánh canh ghẹ.\\r\\nTham quan các di tích lịch sử và văn hóa: Ngoài các hoạt động giải trí, du khách cũng có thể tham quan các di tích lịch sử và văn hóa tại Phú Quốc, như Dinh Cậu, Chùa Hộ Quốc và các làng nghề truyền thống.\\r\\nThời gian lý tưởng cho Tour Phú Quốc:\\r\\nMùa khô (tháng 11 – tháng 4): Đây là thời gian lý tưởng để du lịch Phú Quốc, với thời tiết mát mẻ, ít mưa, rất thích hợp cho các hoạt động ngoài trời và tắm biển.\\r\\nMùa mưa (tháng 5 – tháng 10): Phú Quốc vẫn có vẻ đẹp riêng trong mùa mưa, nhưng thời tiết có thể không thuận lợi cho các hoạt động ngoài trời. Tuy nhiên, nếu bạn muốn tìm kiếm sự yên tĩnh và tránh đám đông, mùa mưa cũng là một lựa chọn.', 'Hoạt động', '2025-03-30', 'TP.Hồ Chí Minh', 'Lịch trình ngày 1:\r\nLịch trình ngày 2:', 1, 'Theo đoàn', '5 ngày 4 đêm', 4900000, 'Xe khách', 'Nam'),
(51, 9, 'Tour Miền Tây Sông Nước', 'Sinh thái', 2400000, '50', 30, 5, 'Khám phá chợ nổi Cái Răng, miệt vườn trái cây', 'Hoạt động', '2025-03-30', 'TP.Hồ Chí Minh', 'NGÀY 1: TP.HCM – MỸ THO – BẾN TRE – CẦN THƠ\r\n-Buổi sáng:\r\nKhởi hành từ TP.HCM, dừng chân tại Chùa Vĩnh Tràng (Tiền Giang) – ngôi chùa cổ với kiến trúc độc đáo.\r\nTham quan Cồn Thới Sơn, chèo xuồng ba lá trên rạch dừa nước.\r\nThưởng thức trái cây miền Tây và nghe đờn ca tài tử Nam Bộ.\r\n-Buổi trưa:\r\nĂn trưa tại Bến Tre với món cá tai tượng chiên xù, lẩu cá linh bông điên điển.\r\n-Buổi chiều:\r\nTham quan làng nghề làm kẹo dừa, cơ sở làm bánh tráng.\r\nDi chuyển về Cần Thơ, nhận phòng khách sạn.\r\n-Buổi tối:\r\nTự do khám phá chợ đêm Ninh Kiều, thưởng thức hải sản miền Tây.\r\n\r\nNGÀY 2: CẦN THƠ – CHỢ NỔI CÁI RĂNG – RỪNG TRÀM TRÀ SƯ (AN GIANG)\r\n-Buổi sáng:\r\nDậy sớm đi Chợ nổi Cái Răng, tìm hiểu nét văn hóa sông nước độc đáo.\r\nThưởng thức hủ tiếu ghe, bún riêu, cà phê kho ngay trên thuyền.\r\n-Buổi trưa:\r\nDi chuyển đến An Giang, ăn trưa tại nhà hàng địa phương.\r\n-Buổi chiều:\r\nKhám phá Rừng Tràm Trà Sư, đi thuyền xuyên rừng tràm, ngắm chim trời, hệ sinh thái độc đáo.\r\n- Buổi tối:\r\nVề thành phố Châu Đốc, tự do khám phá Miếu Bà Chúa Xứ, Lăng Thoại Ngọc Hầu.\r\n\r\nNGÀY 3: CHÂU ĐỐC – NÚI SAM – LÀNG CHĂM – VĨNH LONG\r\n-Buổi sáng:\r\nTham quan Núi Sam, ngắm toàn cảnh Châu Đốc từ trên cao.\r\nTìm hiểu văn hóa Chăm tại Làng Chăm Châu Giang.\r\n-Buổi trưa:\r\nĂn trưa với đặc sản bún cá Châu Đốc, gỏi sầu đâu khô cá lóc.\r\n- Buổi chiều:\r\nKhởi hành về Vĩnh Long, ghé Làng Gốm đỏ Mang Thít.\r\n-Buổi tối:\r\nNhận phòng khách sạn, nghỉ ngơi tại Vĩnh Long.\r\n\r\nNGÀY 4: VĨNH LONG – TP.HCM\r\n-Buổi sáng:\r\nTham quan Cù Lao An Bình, trải nghiệm bắt cá, tát mương, hái trái cây.\r\n- Buổi trưa:\r\nThưởng thức bữa ăn dân dã tại nhà vườn.\r\n-Buổi chiều:\r\nLên xe về TP.HCM, kết thúc chuyến đi.', 1, 'Gia đình', '4 ngày 3 đêm', 1000000, 'Xe khách', 'Nam'),
(52, 9, 'Tour Côn Đảo Huyền Bí', 'Văn hóa', 3000000, '40', 20, 4, 'Viếng mộ chị Võ Thị Sáu, bãi Đầm Trầu', 'Hoạt động', '2025-02-28', 'TP.Hồ Chí Minh', 'Côn đảo', 1, 'Theo nhóm nhỏ', '3 ngày 2 đêm', 0, 'Máy bay', 'Nam'),
(53, 9, 'Tour Vũng Tàu - Long Hải', 'Giải trí', 2400000, '30', 40, 6, 'Tắm biển, ăn hải sản, khám phá núi Minh Đạm', 'Hoạt động', '2025-03-08', 'TP.Hồ Chí Minh', 'Vũng Tàu - Long Hải', 1, 'Theo đoàn', '2 ngày 1 đêm', 1000000, 'Xe khách', 'Nam'),
(54, 9, 'Tour Mộc Châu - Sơn La', 'Sinh thái', 3000000, '40', 20, 4, 'Đồi chè xanh mướt, thác Dải Yếm, bản làng dân tộc', 'Hoạt động', '2025-03-01', 'Hà Nội', 'Mộc Châu - Sơn La', 1, 'Gia đình', '2 ngày 1 đêm', 2400000, 'Xe khách', 'Bắc'),
(55, 9, 'Tour Hà Giang - Cao Nguyên Đá', 'Phiêu lưu', 2400000, '50', 15, 4, 'Chinh phục đèo Mã Pí Lèng, khám phá cao nguyên đá', 'Hoạt động', '2025-03-08', 'Hà Nội', 'Hà Giang - Đồng Văn', 1, 'Theo nhóm nhỏ', '3 ngày 2 đêm', 0, 'Xe khách', 'Bắc'),
(56, 9, 'Tour Tràng An - Bái Đính', 'Tâm linh', 2500000, '30', 40, 6, 'Tham quan chùa Bái Đính, du thuyền Tràng An', 'Hoạt động', '2025-03-14', 'Hà Nội', 'Ninh Bình - Tràng An', 1, 'Gia đình', '1 ngày', 0, 'Xe khách', 'Bắc'),
(57, 9, 'Tour Mỹ Tho - Bến Tre', 'Sinh thái', 2400000, '50', 25, 4, 'Du ngoạn sông nước, thưởng thức đờn ca tài tử', 'Hoạt động', '2025-03-12', 'TP.Hồ Chí Minh', 'Mỹ Tho - Bến Tre', 1, 'Theo đoàn', '1 ngày', 0, 'Xe khách', 'Tây'),
(58, 9, 'Tour An Giang - Châu Đốc', 'Tâm linh', 2400000, '40', 20, 4, 'Viếng miếu Bà Chúa Xứ, khám phá rừng Tràm Trà Sư', 'Hoạt động', '2025-02-28', 'TP.Hồ Chí Minh', 'Châu Đốc - Trà Sư', 1, 'Theo nhóm nhỏ', '2 ngày 1 đêm', 1600000, 'Xe khách', 'Tây'),
(59, 9, 'Tour Quy Nhơn - Kỳ Co - Eo Gió', 'Phiêu lưu', 4000000, '50', 20, 4, 'Tắm biển Kỳ Co, check-in Eo Gió, khám phá hải sản', 'Hoạt động', '2025-07-10', 'TP.Hồ Chí Minh', 'Quy Nhơn - Kỳ Co - Eo Gió', 1, 'Theo nhóm nhỏ', '3 ngày 2 đêm', 3100000, 'Máy bay', 'Trung'),
(60, 9, 'Tour Phong Nha - Kẻ Bàng', 'Sinh thái', 2400000, '50', 15, 4, 'Khám phá động Phong Nha, chèo thuyền trên sông Son', 'Hoạt động', '2025-03-08', 'Đà Nẵng', 'Quảng Bình - Phong Nha', 1, 'Gia đình', '2 ngày 1 đêm', 0, 'Xe khách', 'Trung'),
(61, 9, 'Tour Thái Lan - Bangkok - Pattaya', 'Giải trí', 11000000, '50', 30, 5, 'Tham quan chùa Vàng, chợ nổi, đảo San Hô, phố đi bộ Pattaya', 'Hoạt động', '2025-03-01', 'TP.Hồ Chí Minh', 'Bangkok - Pattaya', 1, 'Theo đoàn', '5 ngày 4 đêm', 0, 'Máy bay', 'Ngoài nước'),
(62, 9, 'Tour Hàn Quốc - Seoul - Nami', 'Văn hóa', 25000000, '40', 25, 4, 'Khám phá cung điện Gyeongbok, đảo Nami, tháp Namsan', 'Hoạt động', '2025-03-14', 'Hà Nội', 'Seoul - Nami - Everland', 1, 'Gia đình', '6 ngày 5 đêm', 20000000, 'Máy bay', 'Ngoài nước'),
(63, 9, 'Tour Nhật Bản - Tokyo - Núi Phú Sĩ', 'Nghỉ dưỡng', 31000000, '50', 20, 4, 'Trải nghiệm Tokyo, Hakone, núi Phú Sĩ, suối nước nóng', 'Hoạt động', '2025-03-07', 'TP.Hồ Chí Minh', 'Tokyo - Hakone - Phú Sĩ', 1, 'Theo nhóm nhỏ', '7 ngày 6 đêm', 29000000, 'Máy bay', 'Ngoài nước'),
(64, 9, 'Đông Bắc: Hà Nội - Hà Giang - Lũng Cú - Đồng Văn - Mã Pì Lèng', 'Sinh thái', 9000000, '40', 20, 5, 'Đông Bắc: Hà Nội - Hà Giang - Lũng Cú - Đồng Văn - Mã Pì Lèng', 'Hoạt động', '2025-03-10', 'Hà Nội', 'Ngày 1: Đà Nẵng - Hà Nội - Tuyên Quang - Hà Giang\r\nNgày 2: Hà Giang - Lũng Cú - Đồng Văn 3 bữa (sáng, trưa, chiều) \r\nNgày 3: Đồng Văn - Mã Pí Lèng - Mèo Vạc  3 bữa ăn (sáng, trưa, chiều)\r\nNgày 4: Hà Giang - Hà Nội - Đà ', 1, 'Gia đình', '4 ngày 3 đêm', 7990000, 'Máy bay', 'Bắc');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_images`
--

CREATE TABLE `tour_images` (
  `Sr_no` int(11) NOT NULL,
  `id_tour` int(11) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Thumb` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_images`
--

INSERT INTO `tour_images` (`Sr_no`, `id_tour`, `Image`, `Thumb`) VALUES
(1, 46, 'hanoi.jpg', ''),
(2, 47, 'danang.jpg', ''),
(3, 48, 'hue.jpg', ''),
(4, 49, 'sapa1.jpg', ''),
(5, 50, 'phuq.jpg', ''),
(6, 51, 'mt.jfif', ''),
(7, 52, 'cond.jfif', ''),
(8, 53, 'vt.jfif', ''),
(9, 54, 'mc.jfif', ''),
(10, 55, 'gh.jfif', ''),
(11, 56, 'tr.jfif', ''),
(12, 57, 'an.jpg', ''),
(13, 58, 'namk.jpg', ''),
(14, 59, 'ky-co-1.jpg', ''),
(15, 60, 'pn.jfif', ''),
(16, 61, 'muang-boran-4-8565.jpg', ''),
(17, 62, 'hq.jfif', ''),
(18, 63, 'Nhb.jpg', ''),
(19, 64, 'hn.jpg', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_schedule`
--

CREATE TABLE `tour_schedule` (
  `id` int(11) NOT NULL,
  `id_tour` int(11) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Schedule` varchar(255) DEFAULT NULL,
  `Locations` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_schedule`
--

INSERT INTO `tour_schedule` (`id`, `id_tour`, `Name`, `Date`, `Schedule`, `Locations`) VALUES
(54, 59, 'Tour Quy Nhơn - Kỳ Co - Eo Gió', '2025-07-10 00:00:00', '3 ngày 2 đêm', 'TP.Hồ Chí Minh'),
(55, 59, 'Tour Quy Nhơn - Kỳ Co - Eo Gió', '2025-07-10 00:00:00', '3 ngày 2 đêm', 'TP.Hồ Chí Minh'),
(56, 59, 'Tour Quy Nhơn - Kỳ Co - Eo Gió', '2025-07-10 00:00:00', '3 ngày 2 đêm', 'TP.Hồ Chí Minh'),
(57, 59, 'Tour Quy Nhơn - Kỳ Co - Eo Gió', '2025-07-10 00:00:00', '3 ngày 2 đêm', 'TP.Hồ Chí Minh'),
(148, 51, 'Tour Miền Tây Sông Nước', '2025-07-10 00:00:00', '4 ngày 3 đêm', 'TP.Hồ Chí Minh'),
(149, 51, 'Tour Miền Tây Sông Nước', '2025-06-05 00:00:00', '4 ngày 3 đêm', 'TP.Hồ Chí Minh'),
(150, 51, 'Tour Miền Tây Sông Nước', '2025-12-26 00:00:00', '4 ngày 3 đêm', 'TP.Hồ Chí Minh'),
(166, 60, 'Tour Phong Nha - Kẻ Bàng', '2025-04-24 00:00:00', '2 ngày 1 đêm', 'Đà Nẵng'),
(167, 60, 'Tour Phong Nha - Kẻ Bàng', '2025-05-04 00:00:00', '2 ngày 1 đêm', 'Đà Nẵng'),
(168, 60, 'Tour Phong Nha - Kẻ Bàng', '2025-05-11 00:00:00', '2 ngày 1 đêm', 'Đà Nẵng'),
(169, 60, 'Tour Phong Nha - Kẻ Bàng', '2025-12-20 00:00:00', '2 ngày 1 đêm', 'Đà Nẵng'),
(170, 60, 'Tour Phong Nha - Kẻ Bàng', '2025-10-16 00:00:00', '2 ngày 1 đêm', 'Đà Nẵng'),
(171, 58, 'Tour An Giang - Châu Đốc', '2025-04-29 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(172, 58, 'Tour An Giang - Châu Đốc', '2025-05-07 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(173, 58, 'Tour An Giang - Châu Đốc', '2025-07-17 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(174, 58, 'Tour An Giang - Châu Đốc', '2025-12-20 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(175, 57, 'Tour Mỹ Tho - Bến Tre', '2025-09-12 00:00:00', '1 ngày', 'TP.Hồ Chí Minh'),
(176, 57, 'Tour Mỹ Tho - Bến Tre', '2025-12-09 00:00:00', '1 ngày', 'TP.Hồ Chí Minh'),
(177, 53, 'Tour Vũng Tàu - Long Hải', '2025-04-25 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(178, 53, 'Tour Vũng Tàu - Long Hải', '2025-06-20 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(179, 53, 'Tour Vũng Tàu - Long Hải', '2025-12-27 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(184, 55, 'Tour Hà Giang - Cao Nguyên Đá', '2025-04-23 00:00:00', '3 ngày 2 đêm', 'Hà Nội'),
(185, 55, 'Tour Hà Giang - Cao Nguyên Đá', '2025-06-13 00:00:00', '3 ngày 2 đêm', 'Hà Nội'),
(186, 55, 'Tour Hà Giang - Cao Nguyên Đá', '2025-07-11 00:00:00', '3 ngày 2 đêm', 'Hà Nội'),
(187, 55, 'Tour Hà Giang - Cao Nguyên Đá', '2025-11-21 00:00:00', '3 ngày 2 đêm', 'Hà Nội'),
(193, 59, 'Tour Quy Nhơn - Kỳ Co - Eo Gió', '2025-07-10 00:00:00', '3 ngày 2 đêm', 'TP.Hồ Chí Minh'),
(194, 59, 'Tour Quy Nhơn - Kỳ Co - Eo Gió', '2025-07-10 00:00:00', '3 ngày 2 đêm', 'TP.Hồ Chí Minh'),
(197, 47, 'Đà Nẵng', '2025-04-08 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(198, 50, 'Phú Quốc', '2025-04-13 00:00:00', '5 ngày 4 đêm', 'TP.Hồ Chí Minh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_credit`
--

CREATE TABLE `user_credit` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` text NOT NULL,
  `Email` varchar(255) NOT NULL,
  `sdt` varchar(255) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Datetime` date NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `is_locked` tinyint(1) DEFAULT 0,
  `unlock_token` varchar(255) DEFAULT NULL,
  `login_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_credit`
--

INSERT INTO `user_credit` (`id`, `Name`, `Address`, `Email`, `sdt`, `profile`, `Password`, `Datetime`, `reset_token`, `token_expiry`, `failed_attempts`, `is_locked`, `unlock_token`, `login_type`) VALUES
(1, 'Phuc Hung', 'sssss', 'phuc@gmail.com', '0987389890', 'pt.png', 'cb0343fa02f5e80de7ed84427f227af1', '2001-10-11', NULL, NULL, 0, 0, NULL, ''),
(12, 'Skappa', 'TP BÌNH THUẬN', 'Skappa@gmail.com', '0738393890', 'tt.jpg', 'b9f85712cd4de962ab308c6e2b550bea', '2001-06-15', NULL, NULL, 0, 0, NULL, ''),
(13, 'ma', 'TP BÌNH THUẬN', 'ma@gmail.com', '0756383989', 'qrh.PNG', '619ce14ca2272f0a86e86c3df935928f', '2004-10-22', NULL, NULL, 0, 0, NULL, ''),
(17, 'ssss', 'ss', 'phucss@gmail.com', '0983928928', 'Đặt tour.jpg', '619ce14ca2272f0a86e86c3df935928f', '2022-07-01', NULL, NULL, 0, 0, NULL, ''),
(20, 'sss', 'TP BÌNH THUẬN', 'sssss@gmail.com', '0838290920', 'qrh.PNG', '619ce14ca2272f0a86e86c3df935928f', '1999-06-25', NULL, NULL, 0, 0, NULL, ''),
(27, 'Phan Hung', 'sssss', 'comonhay@gmail.com', '0736278299', 'gallery-6.jpg', '', '1996-07-07', NULL, NULL, 0, 0, NULL, 'google'),
(29, 'Phuc Dang', 'zf', 'phucdang756@gmail.com', '0973873893', 'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=3857178607907583&height=50&width=50&ext=1746581799&hash=AbYKqbCWzxb4NVGUlyeFfy5e', '', '2004-03-07', NULL, NULL, 0, 0, NULL, 'facebook');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `type` enum('tour','hotel') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `item_id`, `type`, `created_at`) VALUES
(6, 1, 56, 'tour', '2025-04-09 08:32:15');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Sr_no`);

--
-- Chỉ mục cho bảng `assignment_tour`
--
ALTER TABLE `assignment_tour`
  ADD PRIMARY KEY (`idass`),
  ADD KEY `fk_id_toursche` (`id_toursche`),
  ADD KEY `fk_employid1` (`employid`);

--
-- Chỉ mục cho bảng `booking_details_ks`
--
ALTER TABLE `booking_details_ks`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `fk_booking_ids` (`Booking_id`);

--
-- Chỉ mục cho bảng `booking_detail_tour`
--
ALTER TABLE `booking_detail_tour`
  ADD PRIMARY KEY (`Sr_no`),
  ADD KEY `fk_booking_id` (`Booking_id`);

--
-- Chỉ mục cho bảng `booking_orderks`
--
ALTER TABLE `booking_orderks`
  ADD PRIMARY KEY (`Booking_id`),
  ADD KEY `fk_room_id` (`Room_id`),
  ADD KEY `fk_user_id` (`User_id`);

--
-- Chỉ mục cho bảng `booking_ordertour`
--
ALTER TABLE `booking_ordertour`
  ADD PRIMARY KEY (`Booking_id`),
  ADD KEY `User_id` (`User_id`),
  ADD KEY `Tour_id` (`Tour_id`),
  ADD KEY `Departure_id` (`Departure_id`);

--
-- Chỉ mục cho bảng `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`Sr_no`),
  ADD KEY `adminSr_no` (`adminSr_no`);

--
-- Chỉ mục cho bảng `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_id` (`room_id`),
  ADD KEY `fk_chatrooms_employee` (`employee_id`);

--
-- Chỉ mục cho bảng `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`Sr_no`),
  ADD KEY `adminSr_no` (`adminSr_no`);

--
-- Chỉ mục cho bảng `customer_assignment`
--
ALTER TABLE `customer_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Chỉ mục cho bảng `departure_dates`
--
ALTER TABLE `departure_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tour_departure` (`tour_id`);

--
-- Chỉ mục cho bảng `departure_time`
--
ALTER TABLE `departure_time`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departure_time_ibfk_1` (`id_tour`);

--
-- Chỉ mục cho bảng `deposit_hotel`
--
ALTER TABLE `deposit_hotel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_depart` (`id_depart`);

--
-- Chỉ mục cho bảng `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `vehicle_plate` (`vehicle_plate`);

--
-- Chỉ mục cho bảng `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeesId` (`employeesId`);

--
-- Chỉ mục cho bảng `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`idpar`),
  ADD KEY `idbook` (`idbook`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_book` (`idbook`);

--
-- Chỉ mục cho bảng `rating_reviews_ks`
--
ALTER TABLE `rating_reviews_ks`
  ADD PRIMARY KEY (`Sr_no`),
  ADD KEY `Booking_id` (`Booking_id`),
  ADD KEY `Room_id` (`Room_id`);

--
-- Chỉ mục cho bảng `rating_reviewtour`
--
ALTER TABLE `rating_reviewtour`
  ADD PRIMARY KEY (`Sr_no`),
  ADD KEY `Booking_id` (`Booking_id`),
  ADD KEY `Tour_id` (`Tour_id`);

--
-- Chỉ mục cho bảng `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `fk_rentals_user` (`user_id`);

--
-- Chỉ mục cho bảng `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guide_id` (`guide_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Chỉ mục cho bảng `request_tour`
--
ALTER TABLE `request_tour`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_request_tour_rooms` (`idks`),
  ADD KEY `fk_request_tour_drivers` (`idtx`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeesId` (`employeesId`);

--
-- Chỉ mục cho bảng `rooms_facilities`
--
ALTER TABLE `rooms_facilities`
  ADD PRIMARY KEY (`Sr_no`),
  ADD KEY `fk_rooms_facilities1` (`Room_id`);

--
-- Chỉ mục cho bảng `rooms_features`
--
ALTER TABLE `rooms_features`
  ADD PRIMARY KEY (`Sr_no`),
  ADD KEY `Features_id` (`Features_id`),
  ADD KEY `fk_rooms_features` (`Room_id`);

--
-- Chỉ mục cho bảng `rooms_images`
--
ALTER TABLE `rooms_images`
  ADD PRIMARY KEY (`Sr_no`),
  ADD KEY `fk_rooms_images` (`Room_id`);

--
-- Chỉ mục cho bảng `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Chỉ mục cho bảng `tichdiem`
--
ALTER TABLE `tichdiem`
  ADD PRIMARY KEY (`idtd`),
  ADD KEY `idkh` (`idkh`);

--
-- Chỉ mục cho bảng `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeesId` (`employeesId`),
  ADD KEY `fk_tour_rooms` (`idks`);

--
-- Chỉ mục cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  ADD PRIMARY KEY (`Sr_no`),
  ADD KEY `fk_tour_id` (`id_tour`);

--
-- Chỉ mục cho bảng `tour_schedule`
--
ALTER TABLE `tour_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tour_schedule_id` (`id_tour`);

--
-- Chỉ mục cho bảng `user_credit`
--
ALTER TABLE `user_credit`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`item_id`,`type`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `assignment_tour`
--
ALTER TABLE `assignment_tour`
  MODIFY `idass` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `booking_details_ks`
--
ALTER TABLE `booking_details_ks`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `booking_detail_tour`
--
ALTER TABLE `booking_detail_tour`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT cho bảng `booking_orderks`
--
ALTER TABLE `booking_orderks`
  MODIFY `Booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `booking_ordertour`
--
ALTER TABLE `booking_ordertour`
  MODIFY `Booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT cho bảng `carousel`
--
ALTER TABLE `carousel`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `customer_assignment`
--
ALTER TABLE `customer_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `departure_dates`
--
ALTER TABLE `departure_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT cho bảng `departure_time`
--
ALTER TABLE `departure_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT cho bảng `deposit_hotel`
--
ALTER TABLE `deposit_hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `participant`
--
ALTER TABLE `participant`
  MODIFY `idpar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT cho bảng `rating_reviews_ks`
--
ALTER TABLE `rating_reviews_ks`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `rating_reviewtour`
--
ALTER TABLE `rating_reviewtour`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `rentals`
--
ALTER TABLE `rentals`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `request_tour`
--
ALTER TABLE `request_tour`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `rooms_facilities`
--
ALTER TABLE `rooms_facilities`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `rooms_features`
--
ALTER TABLE `rooms_features`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `rooms_images`
--
ALTER TABLE `rooms_images`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1309;

--
-- AUTO_INCREMENT cho bảng `tichdiem`
--
ALTER TABLE `tichdiem`
  MODIFY `idtd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `tour`
--
ALTER TABLE `tour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `tour_schedule`
--
ALTER TABLE `tour_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT cho bảng `user_credit`
--
ALTER TABLE `user_credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `assignment_tour`
--
ALTER TABLE `assignment_tour`
  ADD CONSTRAINT `fk_employid1` FOREIGN KEY (`employid`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_toursche` FOREIGN KEY (`id_toursche`) REFERENCES `tour_schedule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `booking_details_ks`
--
ALTER TABLE `booking_details_ks`
  ADD CONSTRAINT `booking_details_ks_ibfk_1` FOREIGN KEY (`Booking_id`) REFERENCES `booking_orderks` (`Booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_ids` FOREIGN KEY (`Booking_id`) REFERENCES `booking_orderks` (`Booking_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `booking_detail_tour`
--
ALTER TABLE `booking_detail_tour`
  ADD CONSTRAINT `fk_booking_id` FOREIGN KEY (`Booking_id`) REFERENCES `booking_ordertour` (`Booking_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `booking_orderks`
--
ALTER TABLE `booking_orderks`
  ADD CONSTRAINT `fk_room_id` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`User_id`) REFERENCES `user_credit` (`id`);

--
-- Các ràng buộc cho bảng `booking_ordertour`
--
ALTER TABLE `booking_ordertour`
  ADD CONSTRAINT `booking_ordertour_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `user_credit` (`id`),
  ADD CONSTRAINT `booking_ordertour_ibfk_2` FOREIGN KEY (`Tour_id`) REFERENCES `tour` (`id`),
  ADD CONSTRAINT `booking_ordertour_ibfk_3` FOREIGN KEY (`Departure_id`) REFERENCES `departure_time` (`id`);

--
-- Các ràng buộc cho bảng `carousel`
--
ALTER TABLE `carousel`
  ADD CONSTRAINT `carousel_ibfk_1` FOREIGN KEY (`adminSr_no`) REFERENCES `admin` (`Sr_no`);

--
-- Các ràng buộc cho bảng `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD CONSTRAINT `fk_chatrooms_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `contact_details`
--
ALTER TABLE `contact_details`
  ADD CONSTRAINT `contact_details_ibfk_1` FOREIGN KEY (`adminSr_no`) REFERENCES `admin` (`Sr_no`);

--
-- Các ràng buộc cho bảng `customer_assignment`
--
ALTER TABLE `customer_assignment`
  ADD CONSTRAINT `customer_assignment_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `user_credit` (`id`),
  ADD CONSTRAINT `customer_assignment_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Các ràng buộc cho bảng `departure_dates`
--
ALTER TABLE `departure_dates`
  ADD CONSTRAINT `fk_tour_departure` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `departure_time`
--
ALTER TABLE `departure_time`
  ADD CONSTRAINT `departure_time_ibfk_1` FOREIGN KEY (`id_tour`) REFERENCES `tour` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `deposit_hotel`
--
ALTER TABLE `deposit_hotel`
  ADD CONSTRAINT `deposit_hotel_ibfk_1` FOREIGN KEY (`id_depart`) REFERENCES `departure_time` (`id`);

--
-- Các ràng buộc cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`Sr_no`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `user_credit` (`id`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`receiver_id`) REFERENCES `employees` (`id`);

--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`employeesId`) REFERENCES `employees` (`id`);

--
-- Các ràng buộc cho bảng `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `participant_ibfk_1` FOREIGN KEY (`idbook`) REFERENCES `booking_ordertour` (`Booking_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_book` FOREIGN KEY (`idbook`) REFERENCES `booking_ordertour` (`Booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user_credit` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rating_reviews_ks`
--
ALTER TABLE `rating_reviews_ks`
  ADD CONSTRAINT `rating_reviews_ks_ibfk_1` FOREIGN KEY (`Booking_id`) REFERENCES `booking_orderks` (`Booking_id`),
  ADD CONSTRAINT `rating_reviews_ks_ibfk_2` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`id`);

--
-- Các ràng buộc cho bảng `rating_reviewtour`
--
ALTER TABLE `rating_reviewtour`
  ADD CONSTRAINT `rating_reviewtour_ibfk_1` FOREIGN KEY (`Booking_id`) REFERENCES `booking_ordertour` (`Booking_id`),
  ADD CONSTRAINT `rating_reviewtour_ibfk_2` FOREIGN KEY (`Tour_id`) REFERENCES `tour` (`id`);

--
-- Các ràng buộc cho bảng `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `fk_rentals_user` FOREIGN KEY (`user_id`) REFERENCES `user_credit` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`guide_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `admin` (`Sr_no`);

--
-- Các ràng buộc cho bảng `request_tour`
--
ALTER TABLE `request_tour`
  ADD CONSTRAINT `fk_request_tour_drivers` FOREIGN KEY (`idtx`) REFERENCES `drivers` (`driver_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_request_tour_rooms` FOREIGN KEY (`idks`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_tour_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_credit` (`id`);

--
-- Các ràng buộc cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`employeesId`) REFERENCES `employees` (`id`);

--
-- Các ràng buộc cho bảng `rooms_facilities`
--
ALTER TABLE `rooms_facilities`
  ADD CONSTRAINT `fk_rooms_facilities` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rooms_facilities1` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rooms_i` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rooms_facilities_ibfk_1` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`id`);

--
-- Các ràng buộc cho bảng `rooms_features`
--
ALTER TABLE `rooms_features`
  ADD CONSTRAINT `fk_rooms_features` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rooms_features_ibfk_1` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `rooms_features_ibfk_2` FOREIGN KEY (`Features_id`) REFERENCES `features` (`id`);

--
-- Các ràng buộc cho bảng `rooms_images`
--
ALTER TABLE `rooms_images`
  ADD CONSTRAINT `fk_rooms_images` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rooms_images_ibfk_1` FOREIGN KEY (`Room_id`) REFERENCES `rooms` (`id`);

--
-- Các ràng buộc cho bảng `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tichdiem`
--
ALTER TABLE `tichdiem`
  ADD CONSTRAINT `tichdiem_ibfk_1` FOREIGN KEY (`idkh`) REFERENCES `user_credit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `fk_tour_rooms` FOREIGN KEY (`idks`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tour_ibfk_1` FOREIGN KEY (`employeesId`) REFERENCES `employees` (`id`);

--
-- Các ràng buộc cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  ADD CONSTRAINT `fk_tour_id` FOREIGN KEY (`id_tour`) REFERENCES `tour` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_images_ibfk_1` FOREIGN KEY (`id_tour`) REFERENCES `tour` (`id`);

--
-- Các ràng buộc cho bảng `tour_schedule`
--
ALTER TABLE `tour_schedule`
  ADD CONSTRAINT `fk_tour_schedule_id` FOREIGN KEY (`id_tour`) REFERENCES `tour` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_schedule_ibfk_1` FOREIGN KEY (`id_tour`) REFERENCES `tour` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
