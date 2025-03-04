-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 04, 2025 lúc 04:03 AM
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
(1, 7, 7),
(2, 8, 3),
(3, 11, 7),
(4, 9, 7),
(5, 10, 3);

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
  `Address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_detail_tour`
--

INSERT INTO `booking_detail_tour` (`Sr_no`, `Booking_id`, `Tour_name`, `Price`, `Total_pay`, `User_name`, `Phone_num`, `Address`) VALUES
(1, 106, 'Hà Nội ', '1900000', '4541000', 'Phuc Hung', '0987389890', 'sssss'),
(2, 107, 'Đà Nẵng', '1400000', '1960000', 'Phuc Hung', '0987389890', 'sssss'),
(22, 127, 'Hà Nội ', '1900000', '2641000', 'Phuc Hung', '0987389890', 'sssss');

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
  `User_id` int(11) NOT NULL,
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
(106, 1, 15, 12, 'Xe khách', '2', '2', 0, '2025-01-17', 3, '2025-03-04 07:48:00'),
(107, 1, 16, 13, 'Máy bay', '1', '1', 1, '2025-01-17', 2, '2025-03-03 13:30:20'),
(127, 1, 15, 12, 'Máy bay', '2', '1', 0, '2025-03-15', 2, '2025-03-04 09:23:21');

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
(5, 33, '2025-02-15', 1),
(6, 33, '2025-02-16', 1),
(14, 15, '2025-03-01', 1),
(15, 15, '2025-03-08', 1),
(16, 15, '2025-03-15', 1),
(17, 16, '2025-02-28', 1),
(18, 16, '2025-03-02', 1),
(19, 16, '2025-03-06', 1),
(20, 17, '2025-03-01', 1),
(21, 17, '2025-03-08', 1),
(22, 17, '2025-03-15', 1),
(23, 15, '2025-02-24', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departure_time`
--

CREATE TABLE `departure_time` (
  `id` int(11) NOT NULL,
  `id_tour` int(11) DEFAULT NULL,
  `Day_depart` varchar(255) DEFAULT NULL,
  `Orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departure_time`
--

INSERT INTO `departure_time` (`id`, `id_tour`, `Day_depart`, `Orders`) VALUES
(12, 15, '2 ngày 1 đêm', 16),
(13, 16, '2 ngày 1 đêm', 1),
(14, 17, '2 ngày 1 đêm', 0),
(15, 18, '2 ngày 1 đêm', 6),
(16, 19, '5 ngày 4 đêm', 5),
(18, 21, '2 ngày 1 đêm', 0),
(19, 22, '3 ngày 2 đêm', 3),
(20, 23, '2 ngày 1 đêm', 0),
(21, 24, '2 ngày 1 đêm', 0),
(22, 25, '3 ngày 2 đêm', 0),
(23, 26, '1 ngày', 0),
(24, 27, '1 ngày', 0),
(25, 28, '2 ngày 1 đêm', 0),
(26, 29, '3 ngày 2 đêm', 0),
(27, 30, '2 ngày 1 đêm', 0),
(28, 31, '5 ngày 4 đêm', 0),
(29, 32, '6 ngày 5 đêm', 0),
(30, 33, '7 ngày 6 đêm', 3);

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
(1, 'NV1', 'NV1', 'NV1', '8c2e36e3cdf14ba19ba69db346b4fd4f', 'NV1@gmail.com', '0976889999', 'NV1', 'QL', '2025-01-11'),
(2, 'NV2', 'NV2', 'NV2', 'f3b5124e0a3c80acff2e15ad64d4860b', 'NV2@gmail.com', '0738939003', 'sjfnjkasn', 'CSKH', '2025-01-03'),
(3, 'NV3', 'NV3', 'NV3', 'fd23bdb93d20ed16f1f7293e2b6ad6ad', 'NV3@gmail.com', '0978478389', 'NV3', 'HDV', '2025-01-11'),
(7, 'NV4', 'NV4', 'NV4', 'fc36a43b3c227816a575a54c451a87a7', 'NV4@gmail.com', '0783993893', 'NV4', 'HDV', '2025-01-13');

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
  `UserId` int(11) DEFAULT NULL,
  `employid` int(11) DEFAULT NULL,
  `UserName` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `UserId`, `employid`, `UserName`, `message`, `Timestamp`) VALUES
(13, 1, NULL, 'Phucssssth', 'xx', '2025-01-10 01:04:02'),
(14, 10, NULL, 'sss', 'xxx', '2025-01-10 01:06:46'),
(15, 1, NULL, 'Phuc Hung', 'cc', '2025-01-14 06:06:51'),
(16, 2, NULL, 'NV2', 'đ', '2025-01-14 06:23:53');

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
  `Published_at` date DEFAULT NULL,
  `employeesId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `Title`, `dereption`, `Image`, `Content`, `Published_at`, `employeesId`) VALUES
(2, 'Khám phá kỳ quan thế giới tại Việt Nam\r\nViệt Nam tự hào với nhiều kỳ quan thiên nhiên được công nhận trên toàn thế giới.', '1. Lên kế hoạch và đặt trước\r\nLên kế hoạch sớm giúp bạn có thời gian so sánh giá và đặt vé máy bay, khách sạn, hoặc tour du lịch với mức giá ưu đãi nhất. Các ưu đãi và giảm giá thường xuất hiện khi bạn đặt trước từ vài tháng, đặc biệt vào những dịp thấp điểm du lịch.\r\n\r\n2. Chọn phương tiện di chuyển tiết kiệm\r\nNgoài việc sử dụng máy bay giá rẻ, bạn cũng có thể cân nhắc các phương tiện như tàu, xe buýt hoặc xe khách. Những phương tiện này không chỉ tiết kiệm chi phí mà còn mang đến trải nghiệm thú vị về văn hóa địa phương.\r\n\r\n3. Ăn uống địa phương thay vì nhà hàng du lịch\r\nThay vì ăn tại các nhà hàng dành cho khách du lịch, bạn có thể thử các quán ăn bình dân của người dân địa phương. Giá cả tại các quán này thường rẻ hơn nhiều và bạn còn có thể thưởng thức những món ăn độc đáo, truyền thống.\r\n\r\n4. Tận dụng các chương trình giảm giá và ưu đãi\r\nNhiều địa điểm du lịch, bảo tàng, hoặc công viên giải trí cung cấp các chương trình giảm giá vào những ngày nhất định trong tuần hoặc cho khách du lịch theo nhóm. Hãy tìm hiểu trước và lên kế hoạch tham quan vào những thời điểm này để tiết kiệm chi phí.\r\n\r\n5. Chọn những điểm đến ít đông đúc\r\nThay vì đến những điểm du lịch nổi tiếng, bạn có thể lựa chọn các địa điểm ít người biết đến. Những nơi này không chỉ rẻ hơn mà còn giúp bạn tránh khỏi cảnh đông đúc, quá tải, mang đến trải nghiệm yên bình và thú vị hơn.\r\n\r\nHy vọng với những mẹo này, bạn sẽ có một chuyến du lịch đáng nhớ mà không phải lo lắng về chi phí!', 'gallery-3.jpg', 'Việt Nam là điểm đến lý tưởng với phong cảnh thiên nhiên tuyệt đẹp, từ Vịnh Hạ Long đến động Phong Nha. Đây là nơi bạn có thể trải nghiệm vẻ đẹp hùng vĩ và văn hóa độc đáo của đất nước hình chữ S.', '2025-01-05', 1),
(3, '5 mẹo du lịch tiết kiệm chi ph.,Học cách tiết kiệm khi đi du lịch mà vẫn tận hưởng trọn vẹn hành trình.', '1. Lên kế hoạch và đặt trước\r\nViệc lên kế hoạch du lịch sớm giúp bạn tiết kiệm chi phí cho các dịch vụ như vé máy bay, khách sạn và các hoạt động tham quan. Đặt vé máy bay và phòng khách sạn trước ít nhất 1-2 tháng sẽ giúp bạn tìm được các ưu đãi hấp dẫn và tránh tình trạng giá tăng vào giờ chót.\r\n\r\n2. Chọn phương tiện di chuyển giá rẻ\r\nThay vì lựa chọn các hãng hàng không đắt đỏ, bạn có thể tham khảo các chuyến bay giá rẻ hoặc các phương tiện như tàu hỏa, xe buýt, hoặc xe thuê. Những phương tiện này thường có chi phí thấp hơn, đặc biệt khi bạn di chuyển trong các khu vực gần nhau.\r\n\r\n3. Ở trong các hostel hoặc nhà nghỉ\r\nKhách sạn 5 sao có thể mang đến trải nghiệm sang trọng, nhưng giá cả lại rất cao. Thay vào đó, bạn có thể chọn ở trong các hostel hoặc nhà nghỉ bình dân. Đây không chỉ là giải pháp tiết kiệm chi phí mà còn giúp bạn kết nối với những du khách khác, tạo ra những trải nghiệm thú vị.\r\n\r\n4. Ăn uống tại các quán địa phương\r\nĂn tại các nhà hàng cao cấp hoặc khu vực du lịch nổi tiếng sẽ khiến chi phí ăn uống của bạn tăng lên đáng kể. Hãy thử ăn tại các quán ăn địa phương, nơi bạn có thể thưởng thức những món ăn đặc sản với giá cả hợp lý hơn rất nhiều.\r\n\r\n5. Tận dụng các ưu đãi và khuyến mãi\r\nTrước chuyến đi, hãy tìm hiểu và sử dụng các ưu đãi du lịch như thẻ giảm giá, combo vé tham quan hoặc các chương trình khuyến mãi từ các công ty du lịch. Nhiều bảo tàng, công viên, hay điểm tham quan cũng có giảm giá vào những ngày đặc biệt hoặc cho nhóm đông người.\r\n\r\nVới những mẹo trên, bạn có thể có một chuyến du lịch thú vị mà không lo bị vượt quá ngân sách!', 'gallery-2.jpg', 'Du lịch không nhất thiết phải tốn kém. Chúng tôi chia sẻ những mẹo hữu ích giúp bạn tiết kiệm từ việc chọn thời điểm đặt vé, tìm khách sạn giá rẻ, đến các phương án ăn uống và mua sắm hợp lý.', '2025-01-04', 1),
(4, 'Top 10 điểm đến không thể bỏ qua năm 2025', 'Toulouse, Pháp\r\nThành phố này nổi tiếng với cảnh quan sông Garonne thơ mộng và nền văn hóa nghệ thuật phong phú. Toulouse được đánh giá là điểm đến lý tưởng cho kỳ nghỉ cuối tuần hoàn hảo. \r\nNYPOST\r\n\r\nCameroon\r\nVới bãi biển đẹp, công viên quốc gia ít người biết đến và cuộc sống về đêm sôi động, Cameroon là điểm đến hấp dẫn cho những ai tìm kiếm trải nghiệm mới mẻ. \r\nNYPOST\r\n\r\nLow Country và Coastal Georgia, Hoa Kỳ\r\nKhu vực này nổi tiếng với lịch sử phong phú và nền ẩm thực đa dạng, đặc biệt là các món ăn hải sản tươi ngon. \r\nNYPOST\r\n\r\nBoise, Idaho\r\nThành phố này kết hợp giữa di sản công nghiệp và văn hóa thủ công, mang đến trải nghiệm độc đáo cho du khách. \r\nNYPOST\r\n\r\nMount Hood và Columbia River Gorge, Oregon, Hoa Kỳ\r\nVới cảnh quan thiên nhiên hùng vĩ, khu vực này là thiên đường cho những ai yêu thích hoạt động ngoài trời như leo núi và đi bộ đường dài. \r\nNYPOST\r\n\r\nReykjavik, Iceland\r\nThủ đô của Iceland nổi tiếng với cảnh quan thiên nhiên độc đáo và các hoạt động như ngắm cực quang và tắm suối nước nóng. \r\nCRYSTAL BAY\r\n\r\nSiwa Oasis, Ai Cập\r\nNằm ở sa mạc phía tây Ai Cập, Siwa Oasis là điểm đến ít người biết đến với cảnh quan sa mạc hùng vĩ và nền văn hóa độc đáo. \r\nCRYSTAL BAY\r\n\r\nTasmania, Úc\r\nVới vẻ đẹp hoang sơ và nền văn hóa phong phú, Tasmania là điểm đến lý tưởng cho những ai yêu thích thiên nhiên và khám phá. \r\nVOGUE\r\n\r\nKyoto, Nhật Bản\r\nThành phố này nổi tiếng với các đền chùa cổ kính và mùa hoa anh đào nở rộ, mang đến trải nghiệm văn hóa độc đáo. \r\nVOGUE\r\n\r\nInner Hebrides, Scotland\r\nQuần đảo này ít người biết đến với cảnh quan thiên nhiên hoang sơ và nền văn hóa Scotland đặc trưng. \r\nVOGUE\r\n\r\nPatmos, Hy Lạp\r\nHòn đảo này nổi tiếng với lịch sử lâu dài và cảnh quan biển đẹp, là điểm đến lý tưởng cho những ai tìm kiếm sự yên bình. \r\nVOGUE\r\n\r\nHy vọng danh sách trên sẽ giúp bạn lựa chọn được điểm đến phù hợp cho chuyến du lịch trong năm 2025.', 'gallery-4.jpg', 'Từ các thành phố sôi động đến những vùng đất yên bình, năm 2025 mang đến cơ hội khám phá những địa điểm tuyệt vời. Danh sách này bao gồm các địa danh nổi bật trên toàn cầu, hứa hẹn tạo nên những kỷ niệm đáng nhớ.', '2025-01-03', 1),
(5, 'Làm thế nào để có một chuyến đi an toàn?Những lưu ý quan trọng để đảm bảo an toàn trong mỗi chuyến hành trình.', '1. Lên kế hoạch chi tiết\r\nTìm hiểu về điểm đến: Trước khi đi, nghiên cứu về địa điểm bạn sẽ đến, bao gồm các vấn đề an ninh, khí hậu, văn hóa, và các quy định địa phương.\r\nThực hiện đăng ký thông tin chuyến đi: Nếu đi nước ngoài, bạn có thể đăng ký thông tin chuyến đi tại đại sứ quán hoặc lãnh sự quán để nhận hỗ trợ nếu cần.\r\n2. Mua bảo hiểm du lịch\r\nBảo hiểm y tế và tai nạn: Mua bảo hiểm du lịch bao gồm bảo hiểm y tế, bảo hiểm tai nạn và mất hành lý. Điều này giúp bạn tránh những chi phí phát sinh bất ngờ trong trường hợp xảy ra sự cố.\r\n3. Giữ an toàn tài sản\r\nMang ít tiền mặt: Chỉ mang một ít tiền mặt và sử dụng thẻ tín dụng hoặc thẻ ghi nợ để thanh toán khi cần.\r\nGiữ tài sản an toàn: Sử dụng túi xách hoặc ba lô chống trộm và luôn giữ đồ đạc quan trọng (hộ chiếu, tiền bạc, thẻ tín dụng) bên mình hoặc trong két sắt tại khách sạn.\r\n4. Tuân thủ các quy định an ninh\r\nKiểm tra tình hình an ninh địa phương: Trước khi đi, tìm hiểu xem có bất kỳ cảnh báo an ninh hoặc tình hình khẩn cấp nào ở địa phương không.\r\nTuân thủ các quy định về an ninh tại sân bay: Đảm bảo bạn tuân thủ các quy định về hành lý xách tay và không mang theo các vật phẩm bị cấm.\r\n5. Sức khỏe trong chuyến đi\r\nMang theo thuốc cần thiết: Nếu bạn có bệnh lý hoặc cần thuốc đặc biệt, hãy mang theo đủ thuốc và các giấy tờ liên quan.\r\nCập nhật tiêm phòng: Đảm bảo bạn đã tiêm phòng đầy đủ theo yêu cầu của quốc gia bạn đến, đặc biệt là khi đi du lịch tới các khu vực có nguy cơ cao (ví dụ: sốt xuất huyết, sốt rét).\r\n6. Giữ liên lạc thường xuyên\r\nChia sẻ kế hoạch chuyến đi: Chia sẻ với người thân, bạn bè về lịch trình chuyến đi, nơi bạn ở và các số điện thoại khẩn cấp.\r\nMạng di động và kết nối: Đảm bảo bạn có phương thức liên lạc với gia đình và bạn bè trong trường hợp cần thiết.\r\n7. Chú ý khi di chuyển\r\nSử dụng phương tiện công cộng an toàn: Khi di chuyển trong thành phố, hãy chọn phương tiện công cộng hoặc taxi uy tín. Tránh di chuyển một mình vào ban đêm ở những khu vực vắng vẻ.\r\nCảnh giác với lừa đảo: Cảnh giác với các hình thức lừa đảo, đặc biệt là khi đi du lịch một mình hoặc tới những nơi đông đúc.\r\n8. Giữ sức khỏe thể chất và tinh thần\r\nUống đủ nước và ăn uống hợp lý: Tránh ăn thực phẩm không rõ nguồn gốc, và luôn uống đủ nước để duy trì sức khỏe.\r\nNghỉ ngơi đầy đủ: Chuyến đi sẽ thú vị hơn nếu bạn nghỉ ngơi đầy đủ, đặc biệt là khi tham gia các hoạt động ngoài trời hoặc du lịch mạo hiểm.\r\nBằng cách chuẩn bị tốt và tuân thủ các lời khuyên trên, bạn sẽ có một chuyến đi an toàn và tận hưởng trọn vẹn hành trình của mình.', 'gallery-5.jpg', 'An toàn là yếu tố hàng đầu khi đi du lịch. Bài viết cung cấp các lời khuyên thiết thực để bạn luôn an tâm trên mọi hành trình, từ việc chuẩn bị hành lý đến cách ứng phó khi gặp sự cố bất ngờ.g', '2025-01-12', 1),
(7, 'dss', 'ss', 'from.jpg', 'sss', '2025-01-12', 1);

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
(7, 127, 'Huyd', '1989-09-13', 'Nam', 'Người lớn'),
(8, 127, 'Thảo', '2023-09-02', 'Nữ', 'Trẻ em (từ 2 -> 11 tuổi)');

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
  `phuongtien` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `request_tour`
--

INSERT INTO `request_tour` (`id_request`, `user_id`, `customer_name`, `tour_name`, `departure_date`, `tour_price`, `itinerary`, `tour_duration`, `phuongtien`) VALUES
(4, 1, 'Phuc Hung', 'Hà Nội - Quảng Ninh - Ninh Bình', '2025-03-28', 6500000, 'Đặt chân đến Quảng Ninh - tỉnh đầu tiên có 4 thành phố: Hạ Long, Móng Cái, Uông Bí và Cẩm Phả tạo nên thành phố du lịch không chỉ nổi tiếng về biển như Vịnh Hạ Long với hàng nghìn đảo đá nhấp nhô trên sóng nước lung linh huyền ảo, những hang động tuyệt đẹp, những bãi tắm hoang sơ, làn nước mát lạnh trong veo đặc trưng của vùng đảo Cô Tô, Soi Sim, ... Không những thế, Quảng Ninh còn hấp dẫn du khách về không khí mát mẻ của vùng núi thiêng Yên Tử nơi hội tụ tâm linh, văn hóa và không gian nghỉ dưỡng đỉnh cao. Nếu bạn yêu sự hoang sơ của thiên nhiên, không gian thoáng mát thì hãy thử một lần ghé thăm cao nguyên Bình Liêu, được ví von như “Sapa vùng đất than”, với các cột mốc biên giới và dãy “cờ cỏ lau” hay con đường “Sống lưng khủng long” chạy dọc đường tuần biên luôn là điểm dừng yêu thích của du khách trong và ngoài tỉnh.\r\nNinh Bình - vùng đất “Nơi mơ đến, chốn mong về” ghi dấu ấn với Quần thể danh thắng Tràng An -Di sản văn hóa thiên nhiên thế giới, đi thuyền chèo tham quan hệ thống thạch nhũ trong hang động và di tích Đền Trần; uy nghiêm trầm mặc với quần thể chùa Bái Đính, ẩn mình thanh tịnh sau hang động với Tuyệt tịnh cốc, …', '4 Ngày 3 Đêm', 'Xe khách'),
(7, 1, 'Phuc Hung', 'Hà Nội - Quảng Ninh - Ninh Bình', '2025-03-14', 10000, 'àd', '4 ngày3 đêm', 'Xe khách');

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
(9, 'Deluxe room', 'Phú Quốc', '2025-02-21', '2025-02-23', '20m²', 2400000, '2', '1', 'Hoạt động', 'no', 1),
(10, 'Double Room', 'Hà Nội', '2025-02-22', '2025-02-26', '30m²', 3000000, '4', '2', 'Hoạt động', 'no', 1),
(11, 'Famaly room', 'Đà Nẵng', '2025-02-22', '2025-02-25', '40m²', 5000000, '4', '0', 'Hoạt động', 'no', 1),
(12, 'Luxury room', 'Sapa', '2025-02-12', '2025-02-14', '50m²', 5500000, '4', '2', 'Hoạt động', 'no', 1),
(13, 'Single room', 'Huế', '2025-02-25', '2025-02-28', '60m²', 6000000, '5', '2', 'ko Hoạt động', 'no', 1);

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
  `work_date` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `employid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `schedule`
--

INSERT INTO `schedule` (`id`, `work_date`, `location`, `employid`) VALUES
(5, '2025-01-17 14:44:00', '', 1),
(6, '2025-01-25 14:45:00', '', 2),
(7, '2025-02-05 12:39:00', '', 1),
(21, '2025-02-06 13:23:00', '', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour`
--

CREATE TABLE `tour` (
  `id` int(11) NOT NULL,
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
  `Itinerary` varchar(255) NOT NULL,
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

INSERT INTO `tour` (`id`, `Name`, `Style`, `Price`, `Child_price_percen`, `Max_participant`, `Min_participant`, `Description`, `Status`, `Depart`, `DepartureLocation`, `Itinerary`, `employeesId`, `type`, `timetour`, `discount`, `vehicle`, `vung`) VALUES
(15, 'Hà Nội ', 'Hiện đại', 2000000, '39', 25, 10, 'Hà Nội, thủ đô của Việt Nam, nổi bật với sự kết hợp hài hòa giữa vẻ đẹp cổ kính và sự phát triển hiện đại. Nếu bạn có dịp đến thăm Hà Nội, một tour tham quan sẽ là cách tuyệt vời để khám phá những điểm đến nổi bật và tìm hiểu về lịch sử, văn hóa, cũng như ẩm thực đặc sắc của thành phố này.\r\n\r\nCác điểm tham quan nổi bật trong Tour Hà Nội:\r\nHoàn Kiếm và Hồ Gươm:\r\n\r\nĐây là biểu tượng của Hà Nội, gắn liền với câu chuyện lịch sử và truyền thuyết về thanh gươm. Du khách có thể tham quan đền Ngọc Sơn, tháp Rùa, và đi dạo quanh hồ để tận hưởng không gian yên bình giữa lòng thành phố.\r\nKhu phố cổ Hà Nội:\r\n\r\nKhu phố cổ là nơi lưu giữ nét đẹp truyền thống của Hà Nội với những ngôi nhà cổ, các con phố nhỏ hẹp và các cửa hàng bán đồ thủ công, đặc sản. Đây cũng là nơi bạn có thể thưởng thức nhiều món ăn đặc sản như phở, bún chả, nem rán.\r\nLăng Chủ tịch Hồ Chí Minh:\r\n\r\nLăng Hồ Chí Minh là nơi an nghỉ của Chủ tịch Hồ Chí Minh, vị lãnh tụ vĩ đại của dân tộc Việt Nam. Đây là một trong những điểm đến không thể thiếu trong hành trình khám phá Hà Nội.\r\nChùa Một Cột:\r\n\r\nĐây là ngôi chùa nổi tiếng với kiến trúc độc đáo, được xây dựng trên một cột đá duy nhất, mang đậm dấu ấn văn hóa Phật giáo của Hà Nội.\r\nBảo tàng Dân tộc học Việt Nam:\r\n\r\nMột trong những bảo tàng nổi bật tại Hà Nội, nơi lưu giữ và trưng bày các hiện vật, hình ảnh về các dân tộc và nền văn hóa đa dạng của Việt Nam.\r\nVăn Miếu – Quốc Tử Giám:\r\n\r\nLà trường đại học đầu tiên của Việt Nam, Văn Miếu không chỉ có giá trị lịch sử mà còn là biểu tượng của nền giáo dục Việt Nam xưa.\r\nHồ Tây:\r\n\r\nHồ Tây là hồ lớn nhất và đẹp nhất Hà Nội, thích hợp cho những ai muốn thư giãn, dạo bộ quanh hồ hoặc thưởng thức cà phê tại các quán ven hồ.\r\nHoạt động trong Tour Hà Nội:\r\nThưởng thức ẩm thực Hà Nội: Không thể thiếu khi tham gia tour Hà Nội là việc thưởng thức các món ăn đặc trưng như phở, bún thang, bún chả, cốm làng Vòng, và các loại chè truyền thống.\r\nTham quan các chợ truyền thống: Chợ Đồng Xuân, chợ Hàng Da, và chợ đêm Hà Nội là những nơi bạn có thể mua sắm đồ lưu niệm hoặc các sản phẩm thủ công độc đáo.\r\nDạo thuyền trên Hồ Tây hoặc Hồ Hoàn Kiếm: Trải nghiệm dạo thuyền giúp bạn cảm nhận không gian yên bình và lãng mạn của Hà Nội.\r\nThời gian lý tưởng cho Tour Hà Nội:\r\nHà Nội có bốn mùa rõ rệt, và mỗi mùa đều mang một vẻ đẹp đặc trưng:\r\n\r\nMùa xuân (tháng 1 – tháng 3): Thời tiết mát mẻ, cây cối đâm chồi nảy lộc, thích hợp cho việc tham quan.\r\nMùa hè (tháng 5 – tháng 8): Thời tiết ấm áp, phù hợp để tham quan các hồ, công viên và thưởng thức món ăn đường phố.\r\nMùa thu (tháng 9 – tháng 11): Mùa thu Hà Nội nổi tiếng với không khí mát mẻ, là thời điểm lý tưởng để dạo chơi và tận hưởng vẻ đẹp của các con phố cổ.\r\nMùa đông (tháng 12 – tháng 2): Mùa đông Hà Nội có khí lạnh, thích hợp cho những ai yêu thích sự yên tĩnh và lãng mạn.', 'Active', '2025-01-17', 'TP.Hồ Chí Minh', 'Day 1:Hà Nội Day2:Hồ', 1, 'Gia đình', '2 ngày 1 đêm', 1900000, 'Máy bay', 'Bắc'),
(16, 'Đà Nẵng', 'Cổ đại', 1600000, '40', 30, 10, 'Đà Nẵng, thành phố ven biển xinh đẹp của miền Trung Việt Nam, nổi bật với những bãi biển dài, cảnh quan thiên nhiên tuyệt đẹp, các di tích lịch sử, và ẩm thực đặc sắc. Tour Đà Nẵng là cơ hội tuyệt vời để khám phá một trong những thành phố năng động và phát triển bậc nhất của Việt Nam, nơi kết hợp giữa vẻ đẹp hiện đại và truyền thống.\r\n\r\nCác điểm tham quan nổi bật trong Tour Đà Nẵng:\r\nBà Nà Hills:\r\n\r\nBà Nà Hills là một trong những điểm du lịch nổi tiếng nhất tại Đà Nẵng, đặc biệt với cáp treo đạt kỷ lục thế giới về chiều dài. Bạn sẽ được thưởng ngoạn vẻ đẹp hùng vĩ của núi rừng và tham quan Cầu Vàng - cây cầu với đôi bàn tay khổng lồ nâng đỡ, tạo nên một khung cảnh độc đáo và ấn tượng.\r\nCầu Rồng:\r\n\r\nCầu Rồng là một trong những biểu tượng nổi bật của Đà Nẵng. Đặc biệt, vào mỗi cuối tuần, cầu Rồng có thể phun lửa và phun nước, tạo nên một cảnh tượng tuyệt vời thu hút nhiều du khách.\r\nBãi biển Mỹ Khê:\r\n\r\nVới bờ cát trắng mịn và làn nước trong xanh, Mỹ Khê là một trong những bãi biển đẹp nhất của Đà Nẵng, nơi du khách có thể thư giãn, tắm biển, tham gia các hoạt động thể thao dưới nước, hoặc thưởng thức các món hải sản tươi ngon.\r\nNgũ Hành Sơn:\r\n\r\nNgũ Hành Sơn là một nhóm năm ngọn núi đá vôi nổi bật, được đặt theo tên của các yếu tố trong ngũ hành (Kim, Mộc, Thủy, Hỏa, Thổ). Du khách có thể tham quan các chùa, động, và thưởng ngoạn toàn cảnh Đà Nẵng từ trên cao.\r\nChùa Linh Ứng:\r\n\r\nChùa Linh Ứng nằm trên bán đảo Sơn Trà, là một trong những ngôi chùa nổi tiếng với tượng Phật Bà Quan Âm cao nhất Việt Nam. Không gian yên tĩnh và cảnh quan tuyệt đẹp tại đây sẽ khiến bạn cảm thấy thư giãn và tĩnh tâm.\r\nCông viên Châu Á - Asia Park:\r\n\r\nLà khu vui chơi giải trí lớn với các trò chơi hấp dẫn, Asia Park đặc biệt nổi bật với Vòng quay mặt trời (Sun Wheel) cao nhất Việt Nam, từ đây du khách có thể nhìn ngắm toàn cảnh thành phố Đà Nẵng.\r\nCổ Viện Chàm:\r\n\r\nCổ Viện Chàm là nơi trưng bày các hiện vật văn hóa Chămpa cổ xưa, giúp du khách hiểu thêm về nền văn minh Chămpa từng phát triển mạnh mẽ tại miền Trung Việt Nam.\r\nHoạt động trong Tour Đà Nẵng:\r\nTham quan các điểm di tích lịch sử: Khám phá các ngôi chùa, di tích và bảo tàng như Chùa Linh Ứng, Cổ Viện Chàm, để tìm hiểu về lịch sử và văn hóa đặc sắc của Đà Nẵng và miền Trung.\r\nThưởng thức ẩm thực Đà Nẵng: Đà Nẵng nổi tiếng với các món ăn đặc sản như mì Quảng, bún chả cá, bánh tráng cuốn thịt heo, hải sản tươi sống. Đừng quên ghé qua các quán ăn ven biển để thưởng thức những món ngon.\r\nTrải nghiệm các hoạt động thể thao: Đà Nẵng có rất nhiều hoạt động thú vị như lướt sóng, chèo thuyền kayak, và các trò chơi thể thao dưới nước tại các bãi biển.\r\nThời gian lý tưởng cho Tour Đà Nẵng:\r\nMùa xuân (tháng 1 – tháng 3): Thời tiết mát mẻ và dễ chịu, rất thích hợp cho việc tham quan.\r\nMùa hè (tháng 5 – tháng 8): Thời gian lý tưởng để tắm biển và tham gia các hoạt động thể thao ngoài trời.\r\nMùa thu (tháng 9 – tháng 11): Thời tiết dễ chịu, không quá nóng và ít mưa, phù hợp để tham quan các điểm du lịch.\r\nMùa đông (tháng 12 – tháng 2): Mùa lạnh, thích hợp cho những ai muốn tránh cái nóng của mùa hè và tận hưởng không khí trong lành.', 'Active', '2025-01-25', 'TP.Hồ Chí Minh', 'Day 1:Đà nẵng', 1, 'Theo đoàn', '2 ngày 1 đêm', 0, 'Máy bay', 'Nam'),
(17, 'Huế', 'Hiện đại', 1000000, '30', 12, 3, 'Huế, thành phố cổ kính nằm bên dòng sông Hương, là một trong những điểm du lịch hấp dẫn nhất ở miền Trung Việt Nam. Nổi bật với di sản văn hóa phong phú, những công trình lịch sử, và cảnh sắc thiên nhiên đẹp như tranh vẽ, Huế luôn thu hút du khách với vẻ đẹp trầm mặc, huyền bí và lãng mạn. Tour Huế là cơ hội tuyệt vời để bạn khám phá những nét đặc sắc của vùng đất cố đô này.\r\n\r\nCác điểm tham quan nổi bật trong Tour Huế:\r\nKinh Thành Huế (Hoàng Cung):\r\n\r\nKinh Thành Huế là di sản văn hóa thế giới được UNESCO công nhận, là nơi vua Gia Long xây dựng trong thế kỷ 19, là trung tâm chính trị và văn hóa của triều đại Nguyễn. Bạn sẽ được tham quan Ngọ Môn, Cửu Đỉnh, Đại Nội, Điện Thái Hòa và nhiều công trình kiến trúc khác trong khu vực hoàng cung này.\r\nLăng Tẩm các vua Nguyễn:\r\n\r\nHuế nổi tiếng với các lăng tẩm của các vua triều Nguyễn, mỗi lăng có một kiến trúc riêng biệt và ẩn chứa câu chuyện lịch sử thú vị. Các lăng nổi tiếng như Lăng Khải Định, Lăng Minh Mạng, Lăng Gia Long, hay Lăng Tự Đức đều mang đậm dấu ấn kiến trúc cổ kính và sự trang nghiêm của triều đại Nguyễn.\r\nChùa Thiên Mụ:\r\n\r\nChùa Thiên Mụ là ngôi chùa cổ nhất và nổi tiếng nhất ở Huế, nằm trên đồi Hà Khê bên bờ sông Hương. Đây là một trong những biểu tượng của Huế, với kiến trúc độc đáo và tầm nhìn tuyệt đẹp ra sông Hương.\r\nSông Hương:\r\n\r\nSông Hương là một phần không thể thiếu trong Tour Huế, du khách có thể đi thuyền trên sông, tận hưởng cảnh đẹp hai bên bờ sông, chiêm ngưỡng các làng nghề truyền thống và thưởng thức những làn điệu ca Huế đặc sắc.\r\nChợ Đông Ba:\r\n\r\nChợ Đông Ba là chợ truyền thống lâu đời của Huế, nơi du khách có thể tìm mua những sản phẩm thủ công mỹ nghệ, đồ lưu niệm, quà tặng và các món ăn đặc sản nổi tiếng của Huế như bánh bèo, bánh nậm, cơm hến.\r\nCầu Trường Tiền:\r\n\r\nCầu Trường Tiền là biểu tượng của thành phố Huế, một cây cầu lịch sử nối liền hai bờ sông Hương. Cầu được xây dựng từ thời Pháp thuộc, mang một vẻ đẹp cổ kính, đặc biệt khi về đêm, ánh đèn lấp lánh phản chiếu trên mặt nước tạo nên cảnh tượng tuyệt đẹp.\r\nLàng nghề truyền thống Huế:\r\n\r\nHuế nổi tiếng với nhiều làng nghề truyền thống như làng nón lá Phú Cam, làng gốm Thanh Tiên, hay làng tranh dân gian. Bạn có thể tham quan các làng nghề này để tìm hiểu về quá trình sản xuất các sản phẩm thủ công mỹ nghệ độc đáo của Huế.\r\nHoạt động trong Tour Huế:\r\nTham quan các di tích lịch sử: Khám phá Kinh Thành Huế, các lăng tẩm của các vua Nguyễn, và các ngôi chùa, di tích văn hóa đặc sắc.\r\nThưởng thức ẩm thực Huế: Huế là thiên đường ẩm thực với các món ăn đặc trưng như bánh bèo, bánh nậm, bánh canh, cơm hến, bánh huế. Du khách có thể thưởng thức các món ăn truyền thống ngay tại các quán ăn, nhà hàng trong thành phố.\r\nTrải nghiệm văn hóa ca Huế: Ca Huế, loại hình âm nhạc truyền thống của Huế, là một phần không thể thiếu trong các tour tham quan. Bạn có thể nghe ca Huế trên sông Hương hoặc tại các nhà hát.\r\nThời gian lý tưởng cho Tour Huế:\r\nMùa xuân (tháng 1 – tháng 3): Thời tiết mát mẻ, dễ chịu, là thời điểm lý tưởng để tham quan các di tích và thưởng thức ẩm thực Huế.\r\nMùa hè (tháng 4 – tháng 6): Thời tiết nóng, thích hợp cho những ai muốn khám phá các bãi biển gần Huế như Lăng Cô.\r\nMùa thu (tháng 9 – tháng 11): Mùa mưa ở Huế, nhưng cũng là thời điểm Huế có khí hậu mát mẻ và ít khách du lịch, thích hợp cho những ai muốn tránh đám đông.\r\nMùa đông (tháng 12 – tháng 2): Huế trở nên lạnh và sương mù, tạo ra một không gian lãng mạn và huyền bí, phù hợp cho những chuyến du lịch nghỉ dưỡng.', 'Active', '2025-01-22', 'TP.Hồ Chí Minh', 'Day 1:Huế', 1, 'Theo nhóm nhỏ', '2 ngày 1 đêm', 900000, 'Xe khách', 'Trung'),
(18, 'Sapa', 'Hiện đại', 3000000, '30', 5, 2, 'Sapa, một thị trấn nhỏ nằm ở phía Tây Bắc Việt Nam, nổi tiếng với những cảnh quan thiên nhiên hùng vĩ, văn hóa độc đáo của các dân tộc thiểu số, và khí hậu mát mẻ quanh năm. Đây là một điểm đến lý tưởng cho những ai yêu thích khám phá thiên nhiên, tận hưởng không khí trong lành và tìm hiểu về các phong tục tập quán đặc sắc của các cộng đồng dân tộc như H\'mông, Dao, Tày, Giáy. Tour Sapa mang đến cho du khách những trải nghiệm tuyệt vời về một vùng đất đầy bí ẩn và vẻ đẹp thiên nhiên.\r\n\r\nCác điểm tham quan nổi bật trong Tour Sapa:\r\nFansipan – Nóc nhà của Đông Dương:\r\n\r\nFansipan là đỉnh núi cao nhất Đông Dương, với độ cao 3.143m. Du khách có thể tham gia các tour leo núi, hoặc nếu không muốn leo, có thể đi cáp treo để chiêm ngưỡng toàn cảnh thiên nhiên hùng vĩ của Sapa từ trên cao.\r\nThị trấn Sapa:\r\n\r\nThị trấn Sapa nổi bật với những ngôi nhà có kiến trúc Pháp cổ, các khu chợ địa phương và không gian yên bình. Du khách có thể tản bộ dọc các con phố để cảm nhận vẻ đẹp thơ mộng của thị trấn này, thưởng thức các món ăn đặc sản và mua sắm các sản phẩm thủ công.\r\nBản Cát Cát:\r\n\r\nBản Cát Cát là một trong những bản làng của người H\'mông, nơi bạn có thể tìm hiểu về đời sống và văn hóa của người dân tộc thiểu số. Tại đây, bạn có thể tham quan các ngôi nhà truyền thống, xem các hoạt động sản xuất thổ cẩm, dệt vải và thưởng thức các món ăn đặc trưng.\r\nThung lũng Mường Hoa:\r\n\r\nThung lũng Mường Hoa nổi tiếng với những cánh đồng lúa bậc thang xanh mướt, những con suối trong vắt và những bãi đá cổ với những hình vẽ kỳ lạ. Đây là nơi lý tưởng để chụp ảnh và thưởng thức cảnh đẹp thiên nhiên hoang sơ.\r\nBản Tả Phìn:\r\n\r\nBản Tả Phìn là nơi sinh sống của người Dao Đỏ, nổi tiếng với nghề thêu tay và các sản phẩm thủ công mỹ nghệ. Du khách có thể tham gia các hoạt động tìm hiểu về văn hóa địa phương, ngắm cảnh và mua sắm các sản phẩm thủ công độc đáo.\r\nHồ Sapa:\r\n\r\nHồ Sapa là một trong những điểm du lịch nổi tiếng của thị trấn. Bạn có thể đi dạo quanh hồ, thư giãn và tận hưởng không khí trong lành của vùng núi cao.\r\nChợ Sapa:\r\n\r\nChợ Sapa là nơi tụ tập của các dân tộc thiểu số, đặc biệt là vào cuối tuần. Du khách có thể tìm mua các sản phẩm thủ công truyền thống như thổ cẩm, vòng tay, trang sức, và thưởng thức các món ăn đặc sản địa phương như thịt trâu gác bếp, xôi ngũ sắc.\r\nHoạt động trong Tour Sapa:\r\nTrekking và leo núi: Khám phá các bản làng xa xôi, leo núi Fansipan, hoặc trekking qua những con đường mòn, các thửa ruộng bậc thang.\r\nTham quan các bản làng: Ghé thăm các bản làng của người H\'mông, Dao, Tày, Giáy để tìm hiểu về đời sống và văn hóa đặc sắc của các dân tộc thiểu số.\r\nTrải nghiệm ẩm thực Sapa: Sapa nổi tiếng với các món ăn đặc sản như thịt trâu gác bếp, cá hồi Sapa, xôi ngũ sắc, măng rừng, và rượu cần.\r\nThăm các khu chợ: Chợ Sapa, chợ Tả Phìn, chợ Cát Cát… là những nơi bạn có thể mua sắm các sản phẩm thổ cẩm, đồ lưu niệm độc đáo.\r\nThời gian lý tưởng cho Tour Sapa:\r\nMùa xuân (tháng 1 – tháng 3): Đây là mùa hoa mận, hoa đào nở rộ, khung cảnh đẹp như tranh vẽ, thích hợp cho những ai muốn tận hưởng không khí mát mẻ và cảnh sắc tươi mới.\r\nMùa hè (tháng 4 – tháng 6): Thời gian lý tưởng để tham gia trekking, leo núi và khám phá thiên nhiên. Sapa vào mùa hè có khí hậu mát mẻ và dễ chịu, rất thích hợp cho các hoạt động ngoài trời.\r\nMùa thu (tháng 9 – tháng 11): Đây là mùa lúa chín, các cánh đồng lúa bậc thang ở Sapa khoác lên mình màu vàng óng ả. Đây là thời điểm tuyệt vời để thưởng thức cảnh sắc thiên nhiên tuyệt đẹp.\r\nMùa đông (tháng 12 – tháng 2): Sapa vào mùa đông có thể rất lạnh, thậm chí có tuyết rơi, tạo nên một không gian huyền bí và lãng mạn, rất thích hợp cho những ai yêu thích sự yên tĩnh và muốn trải nghiệm khí hậu lạnh.', 'Active', '2025-01-18', 'TP.Hồ Chí Minh', 'Day 1:Sapa', 1, 'Gia đình', '2 ngày 1 đêm', 2500000, 'Du thuyền', 'Bắc'),
(19, 'Phú Quốc', 'Hiện đại', 5000000, '40', 50, 10, 'Phú Quốc, hòn đảo ngọc xinh đẹp của Việt Nam, nằm ở vịnh Thái Lan, được biết đến với bãi biển trong xanh, cát trắng mịn, thiên nhiên hoang sơ và hệ sinh thái phong phú. Đây là một trong những điểm du lịch hấp dẫn bậc nhất tại Việt Nam, thu hút du khách bởi cảnh quan thiên nhiên tuyệt vời, ẩm thực đặc sản độc đáo và những hoạt động giải trí thú vị. Tour Phú Quốc sẽ đưa bạn đến khám phá vẻ đẹp của thiên đường du lịch biển đảo này.\r\n\r\nCác điểm tham quan nổi bật trong Tour Phú Quốc:\r\nBãi Sao:\r\n\r\nBãi Sao là một trong những bãi biển đẹp nhất Phú Quốc, với cát trắng mịn và làn nước trong xanh. Nơi đây còn được biết đến với vẻ đẹp hoang sơ, là địa điểm lý tưởng để tắm biển, thư giãn và tham gia các hoạt động thể thao dưới nước như lướt ván, chèo thuyền kayak.\r\nVinpearl Safari Phú Quốc:\r\n\r\nVinpearl Safari là khu bảo tồn động vật bán hoang dã lớn nhất Việt Nam, nơi bạn có thể tham quan các loài động vật quý hiếm như hươu cao cổ, vượn, sư tử và các loài động vật hoang dã khác trong môi trường tự nhiên.\r\nCông viên giải trí VinWonders Phú Quốc:\r\n\r\nVinWonders Phú Quốc là công viên giải trí lớn, nơi du khách có thể trải nghiệm các trò chơi cảm giác mạnh, khám phá các khu vực chủ đề như Khu vui chơi nước, Thế giới phiêu lưu, và thưởng thức các chương trình biểu diễn đặc sắc.\r\nDinh Cậu:\r\n\r\nDinh Cậu là một ngôi đền nhỏ nằm trên một mỏm đá, với cảnh quan tuyệt đẹp hướng ra biển. Đây là nơi cầu bình an, may mắn và cũng là một điểm du lịch tâm linh quan trọng tại Phú Quốc.\r\nHòn Móng Tay:\r\n\r\nHòn Móng Tay là một hòn đảo nhỏ hoang sơ, với nước biển trong vắt và những bãi cát trắng mịn. Đây là một địa điểm lý tưởng để lặn ngắm san hô, tắm biển và tham gia các hoạt động ngoài trời.\r\nChùa Hộ Quốc (Thiền viện Trúc Lâm Phú Quốc):\r\n\r\nChùa Hộ Quốc là một trong những ngôi chùa lớn và đẹp tại Phú Quốc, được xây dựng theo kiến trúc cổ điển của Phật giáo. Tọa lạc trên đỉnh núi, chùa mang đến một không gian thanh tịnh, yên bình và có tầm nhìn rộng ra biển.\r\nChợ Dương Đông:\r\n\r\nChợ Dương Đông là một trong những khu chợ lớn và nhộn nhịp tại Phú Quốc. Du khách có thể đến đây để thưởng thức các món ăn đặc sản địa phương như hải sản tươi sống, bánh tét mật cật, nước mắm Phú Quốc và mua sắm các món quà lưu niệm.\r\nHoạt động trong Tour Phú Quốc:\r\nTắm biển và tham gia các hoạt động thể thao dưới nước: Phú Quốc nổi tiếng với các bãi biển đẹp như Bãi Sao, Bãi Dài, và Bãi Kem, là nơi lý tưởng để tắm biển, tham gia lướt sóng, chèo thuyền kayak và lặn ngắm san hô.\r\nKhám phá các đảo nhỏ: Du khách có thể tham gia các tour khám phá các đảo nhỏ quanh Phú Quốc như Hòn Móng Tay, Hòn Gầm Ghì, Hòn Đồi Mồi, để tận hưởng vẻ đẹp thiên nhiên hoang sơ và tham gia các hoạt động lặn ngắm san hô.\r\nThưởng thức ẩm thực Phú Quốc: Phú Quốc là thiên đường ẩm thực với các món hải sản tươi ngon như tôm hùm, cua huỳnh đế, nghêu, sò, ốc, đặc biệt là nước mắm Phú Quốc nổi tiếng. Du khách cũng có thể thưởng thức các món ăn đặc sản như bánh tét mật cật, bánh canh ghẹ.\r\nTham quan các di tích lịch sử và văn hóa: Ngoài các hoạt động giải trí, du khách cũng có thể tham quan các di tích lịch sử và văn hóa tại Phú Quốc, như Dinh Cậu, Chùa Hộ Quốc và các làng nghề truyền thống.\r\nThời gian lý tưởng cho Tour Phú Quốc:\r\nMùa khô (tháng 11 – tháng 4): Đây là thời gian lý tưởng để du lịch Phú Quốc, với thời tiết mát mẻ, ít mưa, rất thích hợp cho các hoạt động ngoài trời và tắm biển.\r\nMùa mưa (tháng 5 – tháng 10): Phú Quốc vẫn có vẻ đẹp riêng trong mùa mưa, nhưng thời tiết có thể không thuận lợi cho các hoạt động ngoài trời. Tuy nhiên, nếu bạn muốn tìm kiếm sự yên tĩnh và tránh đám đông, mùa mưa cũng là một lựa chọn.', 'Active', '2025-01-24', 'TP.Hồ Chí Minh', 'Day 1:Phú quốc', 1, 'Theo đoàn', '5 ngày 4 đêm', 4900000, 'Xe khách', 'Nam'),
(21, 'Tour Miền Tây Sông Nước', 'Sinh thái', 1500000, '50', 30, 5, 'Khám phá chợ nổi Cái Răng, miệt vườn trái cây', 'Active', '2025-02-26', 'TP.Hồ Chí Minh', 'Cần Thơ - Tiền Giang - Bến Tre', 1, 'Gia đình', '2 ngày 1 đêm', 1000000, 'Xe khách', 'Nam'),
(22, 'Tour Côn Đảo Huyền Bí', 'Văn hóa', 3200000, '40', 20, 4, 'Viếng mộ chị Võ Thị Sáu, bãi Đầm Trầu', 'Active', '2025-02-28', 'TP.Hồ Chí Minh', '	Côn Đảo', 1, 'Theo nhóm nhỏ', '3 ngày 2 đêm', 0, 'Máy bay', 'Nam'),
(23, 'Tour Vũng Tàu - Long Hải', 'Giải trí', 1200000, '30', 40, 6, 'Tắm biển, ăn hải sản, khám phá núi Minh Đạm', 'Active', '2025-03-08', 'TP.Hồ Chí Minh', 'Vũng Tàu - Long Hải', 1, 'Theo đoàn', '2 ngày 1 đêm', 1000000, 'Xe khách', 'Nam'),
(24, 'Tour Mộc Châu - Sơn La', 'Sinh thái', 2500000, '40', 20, 4, 'Đồi chè xanh mướt, thác Dải Yếm, bản làng dân tộc', 'Active', '2025-03-01', 'Hà Nội', 'Mộc Châu - Sơn La', 1, 'Gia đình', '2 ngày 1 đêm', 2400000, 'Xe khách', 'Bắc'),
(25, 'Tour Hà Giang - Cao Nguyên Đá', 'Phiêu lưu', 3900000, '50', 15, 4, 'Chinh phục đèo Mã Pí Lèng, khám phá cao nguyên đá', 'Active', '2025-03-08', 'Hà Nội', 'Hà Giang - Đồng Văn', 1, 'Theo nhóm nhỏ', '3 ngày 2 đêm', 3000000, 'Xe khách', 'Bắc'),
(26, 'Tour Tràng An - Bái Đính', 'Tâm linh', 1200000, '30', 40, 6, 'Tham quan chùa Bái Đính, du thuyền Tràng An', 'Active', '2025-03-14', 'Hà Nội', 'Ninh Bình - Tràng An', 1, 'Gia đình', '1 ngày', 0, 'Xe khách', 'Bắc'),
(27, 'Tour Mỹ Tho - Bến Tre', 'Sinh thái', 1200000, '50', 25, 4, 'Du ngoạn sông nước, thưởng thức đờn ca tài tử', 'Active', '2025-04-12', 'TP.Hồ Chí Minh', 'Mỹ Tho - Bến Tre', 1, 'Theo đoàn', '1 ngày', 0, 'Xe khách', 'Tây'),
(28, 'Tour An Giang - Châu Đốc', 'Tâm linh', 1800000, '40', 20, 4, 'Viếng miếu Bà Chúa Xứ, khám phá rừng Tràm Trà Sư', 'Active', '2025-02-28', 'TP.Hồ Chí Minh', 'Châu Đốc - Trà Sư', 1, 'Theo nhóm nhỏ', '2 ngày 1 đêm', 1600000, 'Xe khách', 'Tây'),
(29, 'Tour Quy Nhơn - Kỳ Co - Eo Gió', 'Phiêu lưu', 3200000, '50', 20, 4, 'Tắm biển Kỳ Co, check-in Eo Gió, khám phá hải sản', 'Active', '2025-07-10', 'TP.Hồ Chí Minh', 'Quy Nhơn - Kỳ Co - Eo Gió', 1, 'Theo nhóm nhỏ', '3 ngày 2 đêm', 3100000, 'Máy bay', 'Trung'),
(30, 'Tour Phong Nha - Kẻ Bàng', 'Sinh thái', 2500000, '50', 15, 4, 'Khám phá động Phong Nha, chèo thuyền trên sông Son', 'Active', '2025-03-08', 'Đà Nẵng', 'Quảng Bình - Phong Nha', 1, 'Gia đình', '2 ngày 1 đêm', 0, 'Xe khách', 'Trung'),
(31, 'Tour Thái Lan - Bangkok - Pattaya', 'Giải trí', 12000000, '50', 30, 5, 'Tham quan chùa Vàng, chợ nổi, đảo San Hô, phố đi bộ Pattaya', 'Active', '2025-03-01', 'TP.Hồ Chí Minh', 'Bangkok - Pattaya', 1, 'Theo đoàn', '5 ngày 4 đêm', 0, 'Máy bay', 'Ngoài nước'),
(32, 'Tour Hàn Quốc - Seoul - Nami', 'Văn hóa', 25000000, '40', 25, 4, 'Khám phá cung điện Gyeongbok, đảo Nami, tháp Namsan', 'Active', '2025-07-11', 'Hà Nội', 'Seoul - Nami - Everland', 1, 'Gia đình', '6 ngày 5 đêm', 20000000, 'Máy bay', 'Ngoài nước'),
(33, 'Tour Nhật Bản - Tokyo - Núi Phú Sĩ', 'Nghỉ dưỡng', 32000000, '50', 20, 4, 'Trải nghiệm Tokyo, Hakone, núi Phú Sĩ, suối nước nóng', 'Active', '2025-03-07', 'TP.Hồ Chí Minh', 'Tokyo - Hakone - Phú Sĩ', 1, 'Theo nhóm nhỏ', '7 ngày 6 đêm', 20000000, 'Máy bay', 'Ngoài nước');

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
(16, 15, 'hanoi.jpg', 'Thủ đô nghìn năm văn hiến của Việt Nam với phố cổ đặc trưng, hồ Gươm thơ mộng và nét ẩm thực tinh tế. Hà Nội là sự kết hợp hài hòa giữa truyền thống và hiện đại.'),
(17, 16, 'danang.jpg', 'Thành phố biển đáng sống với bãi biển Mỹ Khê xinh đẹp, cầu Rồng độc đáo và bán đảo Sơn Trà xanh mát. Đà Nẵng còn là cửa ngõ đến Hội An và Bà Nà Hills.'),
(18, 17, 'hue.jpg', 'Cố đô yên bình với quần thể di tích lịch sử và lăng tẩm hoàng gia. Huế nổi tiếng với dòng sông Hương thơ mộng và nền ẩm thực cung đình đặc trưng.'),
(19, 18, 'sapa1.jpg', 'Vùng cao nguyên thơ mộng với những thửa ruộng bậc thang trải dài và nét văn hóa đặc sắc của các dân tộc thiểu số. Sapa thu hút du khách bởi khí hậu mát mẻ và đỉnh Fansipan hùng vĩ.\r\n\r\n'),
(20, 19, 'phuq.jpg', 'Đảo ngọc của Việt Nam nổi tiếng với bãi biển trong xanh, cát trắng mịn và hệ sinh thái đa dạng. Phú Quốc còn hấp dẫn bởi đặc sản hải sản tươi ngon và nước mắm truyền thống.'),
(22, 21, 'namk.jpg', ''),
(23, 22, 'cond.jfif', ''),
(24, 23, 'vt.jfif', ''),
(25, 24, 'mc.jfif', ''),
(26, 25, 'tr.jfif', ''),
(27, 26, 'gh.jfif', ''),
(28, 27, 'mt.jfif', ''),
(29, 28, 'an.jpg', ''),
(30, 29, 'ky-co-1.jpg', ''),
(31, 30, 'pn.jfif', ''),
(32, 31, 'muang-boran-4-8565.jpg', ''),
(33, 32, 'hq.jfif', ''),
(34, 33, 'Nhb.jpg', '');

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
(7, 15, 'Hà Nội ', '2025-01-17 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(8, 16, 'Đà Nẵng', '2025-01-25 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(9, 17, 'Huế', '2025-01-22 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(10, 18, 'Sapa', '2025-01-18 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(11, 19, 'Phú Quốc', '2025-01-24 00:00:00', '5 ngày 4 đêm', 'TP.Hồ Chí Minh'),
(13, 21, 'Tour Miền Tây Sông Nước', '2025-02-26 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(14, 22, 'Tour Côn Đảo Huyền Bí', '2025-02-28 00:00:00', '3 ngày 2 đêm', 'TP.Hồ Chí Minh'),
(15, 23, 'Tour Vũng Tàu - Long Hải', '2025-03-08 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(16, 24, 'Tour Mộc Châu - Sơn La', '2025-03-01 00:00:00', '2 ngày 1 đêm', 'Hà Nội'),
(17, 25, 'Tour Hà Giang - Cao Nguyên Đá', '2025-03-08 00:00:00', '3 ngày 2 đêm', 'Hà Nội'),
(18, 26, 'Tour Tràng An - Bái Đính', '2025-03-14 00:00:00', '1 ngày', 'Hà Nội'),
(19, 27, 'Tour Mỹ Tho - Bến Tre', '2025-04-12 00:00:00', '1 ngày', 'TP.Hồ Chí Minh'),
(20, 28, 'Tour An Giang - Châu Đốc', '2025-02-28 00:00:00', '2 ngày 1 đêm', 'TP.Hồ Chí Minh'),
(21, 29, 'Tour Quy Nhơn - Kỳ Co - Eo Gió', '2025-07-10 00:00:00', '3 ngày 2 đêm', 'TP.Hồ Chí Minh'),
(22, 30, 'Tour Phong Nha - Kẻ Bàng', '2025-03-08 00:00:00', '2 ngày 1 đêm', 'Đà Nẵng'),
(23, 31, 'Tour Thái Lan - Bangkok - Pattaya', '2025-03-01 00:00:00', '5 ngày 4 đêm', 'TP.Hồ Chí Minh'),
(24, 32, 'Tour Hàn Quốc - Seoul - Nami', '2025-07-11 00:00:00', '6 ngày 5 đêm', 'Hà Nội'),
(25, 33, 'Tour Nhật Bản - Tokyo - Núi Phú Sĩ', '2025-03-07 00:00:00', '7 ngày 6 đêm', 'TP.Hồ Chí Minh');

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
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_credit`
--

INSERT INTO `user_credit` (`id`, `Name`, `Address`, `Email`, `sdt`, `profile`, `Password`, `Datetime`, `reset_token`, `token_expiry`) VALUES
(1, 'Phuc Hung', 'sssss', 'phuc@gmail.com', '0987389890', 'pt.png', 'cb0343fa02f5e80de7ed84427f227af1', '2015-01-24', NULL, NULL),
(10, 'sss', 'TP BÌNH THUẬN', 'comonhay@gmail.com', '0988888888', 'anh3.jpg', '619ce14ca2272f0a86e86c3df935928f', '2025-01-09', 'd7d23643d9c42da6a128209b3232d49116a3b2a672457c0bfd6d20dcfd693584', '2025-02-13 14:23:03');

--
-- Chỉ mục cho các bảng đã đổ
--

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
-- Chỉ mục cho bảng `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`Sr_no`),
  ADD KEY `adminSr_no` (`adminSr_no`);

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
  ADD KEY `fk_employid` (`employid`);

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
-- Chỉ mục cho bảng `request_tour`
--
ALTER TABLE `request_tour`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `fk_employid5` (`employid`);

--
-- Chỉ mục cho bảng `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeesId` (`employeesId`);

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
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `assignment_tour`
--
ALTER TABLE `assignment_tour`
  MODIFY `idass` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `booking_details_ks`
--
ALTER TABLE `booking_details_ks`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `booking_detail_tour`
--
ALTER TABLE `booking_detail_tour`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `booking_orderks`
--
ALTER TABLE `booking_orderks`
  MODIFY `Booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `booking_ordertour`
--
ALTER TABLE `booking_ordertour`
  MODIFY `Booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT cho bảng `carousel`
--
ALTER TABLE `carousel`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `departure_dates`
--
ALTER TABLE `departure_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `departure_time`
--
ALTER TABLE `departure_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `deposit_hotel`
--
ALTER TABLE `deposit_hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `participant`
--
ALTER TABLE `participant`
  MODIFY `idpar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `rating_reviews_ks`
--
ALTER TABLE `rating_reviews_ks`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `rating_reviewtour`
--
ALTER TABLE `rating_reviewtour`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `request_tour`
--
ALTER TABLE `request_tour`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `tour`
--
ALTER TABLE `tour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  MODIFY `Sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `tour_schedule`
--
ALTER TABLE `tour_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `user_credit`
--
ALTER TABLE `user_credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  ADD CONSTRAINT `booking_details_ks_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_orderks` (`Booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
-- Các ràng buộc cho bảng `contact_details`
--
ALTER TABLE `contact_details`
  ADD CONSTRAINT `contact_details_ibfk_1` FOREIGN KEY (`adminSr_no`) REFERENCES `admin` (`Sr_no`);

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
  ADD CONSTRAINT `fk_employid` FOREIGN KEY (`employid`) REFERENCES `employees` (`id`);

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
-- Các ràng buộc cho bảng `request_tour`
--
ALTER TABLE `request_tour`
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
  ADD CONSTRAINT `fk_employid5` FOREIGN KEY (`employid`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour`
--
ALTER TABLE `tour`
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
