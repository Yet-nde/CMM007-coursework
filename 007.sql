-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2025 at 12:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `007`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1 CHECK (`quantity` >= 0),
  `available_quantity` int(11) NOT NULL DEFAULT 1 CHECK (`available_quantity` >= 0 and `available_quantity` <= `quantity`),
  `image_path` varchar(255) DEFAULT 'default_book.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','deleted') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `isbn`, `genre`, `quantity`, `available_quantity`, `image_path`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(26, 'Beyond The Story edited', 'Myeongseok Kang edited', '9781035031548', 'Autobiography', 9, 6, '/uploads/6800d33d743c8_gold dainty four leaf clover bracelets.jpg', '2025-04-02 11:25:31', '2025-04-17 10:11:27', NULL, 'active'),
(38, 'Half of a Yellow Sun', 'Chimamanda Ngozi Adichie', '9781400044160', 'Fiction', 2, 0, 'uploads/68008816d86af_halfofayellowsun.jpeg', '2025-04-17 04:48:22', '2025-04-17 09:30:15', NULL, 'active'),
(39, 'The Da Vinci Code', 'Dan Brown', '978141372563', 'mystery thriller', 8, 8, 'uploads/680088526c635_thedavincicode.jpeg', '2025-04-17 04:49:22', '2025-04-17 10:09:27', '2025-04-17 10:09:27', 'deleted'),
(40, 'The Elements of Style', 'William Stunk Jr.', '9780486113708', 'non-fiction', 30, 30, 'uploads/6800889a67a1b_TheElementsofStyle.jpeg', '2025-04-17 04:50:34', '2025-04-17 10:11:43', NULL, 'active'),
(41, 'Web Coding & Development for Dummies', 'Paul McFedries', '1394197020', 'academic', 35, 34, 'uploads/680088f2ad1c2_WebCodingDevelopmentforDummies.jpeg', '2025-04-17 04:52:02', '2025-04-17 08:51:30', NULL, 'active'),
(42, 'We Used to Live Here edit', 'Marcus Kliewer', '9781919600567', 'Horror', 11, 11, 'uploads/680089466ae04_WeUsedtoLiveHere.jpeg', '2025-04-17 04:53:26', '2025-04-17 08:26:40', NULL, 'active'),
(43, 'Things Fall Apart', 'Chinua Achebe edit', '9780385474542', 'Africa', 8, 8, '/uploads/6800cd0ab1c1c_butterfly pendant necklace.jpg', '2025-04-17 07:29:40', '2025-04-17 09:43:11', '2025-04-17 09:43:11', 'deleted'),
(44, 'Extra da vinci code', 'Extra edit', '67665558999', 'mystery thriller', 9, 9, '/uploads/6800b5b182a6e_half of a yellow sun.jpeg', '2025-04-17 08:02:24', '2025-04-17 08:03:12', NULL, 'active'),
(45, 'The Last Days of Forcados High edit', 'A.H Mohammed', '9789789060917', 'young adult fiction', 8, 8, '/uploads/6800bfca8d948_Cream off shoulder lace trim top.jpg', '2025-04-17 08:45:24', '2025-04-17 09:29:52', NULL, 'active'),
(46, 'Blue edit', 'Cropped', '7668879987889', 'fantasy', 8, 7, 'uploads/6800c90f355d3_bluecroppedsweatshirt.jpg', '2025-04-17 09:25:35', '2025-04-17 10:11:50', NULL, 'active'),
(47, 'Butterfly', 'rhine', '6777877777', 'fantasy', 8, 8, 'uploads/6800cce498cb9_rhinestonebutterflyrimlesssunglasses.jpg', '2025-04-17 09:41:56', '2025-04-17 09:41:56', NULL, 'active'),
(48, 'sil', 'black', '8777887887', 'fiction', 20, 20, 'uploads/6800d2f1c7cba_blacksilhouette.jpeg', '2025-04-17 10:07:45', '2025-04-17 10:07:45', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `loan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `return_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`loan_id`, `user_id`, `book_id`, `borrow_date`, `due_date`, `return_date`) VALUES
(54, 51, 26, '2025-04-17 09:09:14', '2025-05-01 09:09:14', '2025-04-17 09:09:24'),
(55, 51, 38, '2025-04-17 09:50:13', '2025-05-01 09:50:13', '2025-04-17 09:50:37'),
(56, 51, 26, '2025-04-17 09:50:55', '2025-05-01 09:50:55', '2025-04-17 10:47:46'),
(57, 51, 39, '2025-04-17 09:50:59', '2025-05-01 09:50:59', '2025-04-17 10:47:49'),
(58, 51, 40, '2025-04-17 09:51:04', '2025-05-01 09:51:04', '2025-04-17 11:11:43'),
(59, 51, 45, '2025-04-17 09:51:08', '2025-05-01 09:51:08', '2025-04-17 10:29:52'),
(60, 51, 41, '2025-04-17 09:51:14', '2025-05-01 09:51:14', '2025-04-17 09:51:30'),
(61, 51, 26, '2025-04-17 10:29:09', '2025-05-01 10:29:09', '2025-04-17 10:29:19'),
(62, 51, 26, '2025-04-17 10:29:30', '2025-05-01 10:29:30', '2025-04-17 10:29:49'),
(63, 51, 38, '2025-04-17 10:30:01', '2025-05-01 10:30:01', NULL),
(64, 51, 38, '2025-04-17 10:30:15', '2025-05-01 10:30:15', NULL),
(65, 51, 26, '2025-04-17 10:47:55', '2025-05-01 10:47:55', NULL),
(66, 51, 26, '2025-04-17 11:11:27', '2025-05-01 11:11:27', NULL),
(67, 51, 46, '2025-04-17 11:11:50', '2025-05-01 11:11:50', NULL);

--
-- Triggers `loans`
--
DELIMITER $$
CREATE TRIGGER `check_max_books_before_insert` BEFORE INSERT ON `loans` FOR EACH ROW BEGIN
    DECLARE current_loan_count INT;
    DECLARE user_status ENUM('active', 'suspended', 'deleted');

    SELECT status INTO user_status 
    FROM Users 
    WHERE user_id = NEW.user_id;
    
    IF user_status != 'active' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'User account is not active.';
    END IF;
  
    SELECT COUNT(*) INTO current_loan_count 
    FROM Loans 
    WHERE user_id = NEW.user_id 
    AND return_date IS NULL;  
  
    IF current_loan_count >= 5 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Maximum of 5 books already borrowed.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set_default_due_date` BEFORE INSERT ON `loans` FOR EACH ROW BEGIN
        IF NEW.due_date IS NULL THEN
        SET NEW.due_date = DATE_ADD(NEW.borrow_date, INTERVAL 14 DAY);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `attempt_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempt_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_role` enum('Admin','User') NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `action_type` enum('create','update','delete','suspend','restore','login','logout') NOT NULL,
  `target_type` enum('user','book','session') DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `session_id` varchar(128) DEFAULT NULL,
  `action_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('success','failed') DEFAULT 'success'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`log_id`, `user_id`, `user_role`, `ip_address`, `user_agent`, `action_type`, `target_type`, `target_id`, `session_id`, `action_time`, `status`) VALUES
(3, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'nq97r6kts9u09pfdnsfj9goafm', '2025-04-01 20:46:20', 'success'),
(4, NULL, 'Admin', NULL, NULL, 'create', 'book', 19, NULL, '2025-04-01 20:49:56', 'success'),
(5, NULL, 'Admin', NULL, NULL, 'create', 'book', 19, NULL, '2025-04-01 21:42:36', 'success'),
(6, NULL, 'Admin', NULL, NULL, 'update', 'book', 19, NULL, '2025-04-01 21:47:09', 'success'),
(7, NULL, 'Admin', NULL, NULL, 'delete', 'book', 19, NULL, '2025-04-01 21:47:14', 'success'),
(8, NULL, 'Admin', NULL, NULL, 'delete', 'book', 19, NULL, '2025-04-01 21:55:11', 'success'),
(9, NULL, 'Admin', NULL, NULL, 'update', 'book', 19, NULL, '2025-04-01 21:55:30', 'success'),
(10, NULL, 'Admin', NULL, NULL, 'delete', 'book', 19, NULL, '2025-04-01 21:55:40', 'success'),
(11, NULL, 'Admin', NULL, NULL, 'create', 'book', 20, NULL, '2025-04-01 22:00:49', 'success'),
(12, NULL, 'Admin', NULL, NULL, 'create', 'book', 21, NULL, '2025-04-01 22:13:48', 'success'),
(13, NULL, 'Admin', NULL, NULL, 'create', 'book', 22, NULL, '2025-04-01 22:31:01', 'success'),
(14, NULL, 'Admin', NULL, NULL, 'delete', 'book', 21, NULL, '2025-04-01 22:44:45', 'success'),
(15, NULL, 'Admin', NULL, NULL, 'delete', 'book', 22, NULL, '2025-04-01 22:44:48', 'success'),
(16, NULL, 'Admin', NULL, NULL, 'create', 'book', 23, NULL, '2025-04-01 22:45:16', 'success'),
(17, NULL, 'Admin', NULL, NULL, 'update', 'user', 1, NULL, '2025-04-01 22:50:40', 'success'),
(18, NULL, 'Admin', NULL, NULL, 'delete', 'user', 1, NULL, '2025-04-01 22:51:01', 'success'),
(19, NULL, 'Admin', NULL, NULL, 'create', 'book', 24, NULL, '2025-04-01 22:59:14', 'success'),
(20, NULL, 'Admin', NULL, NULL, 'create', 'book', 25, NULL, '2025-04-01 23:05:59', 'success'),
(21, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'rthaouvs1ujbsd79dp5v6is2hr', '2025-04-02 11:13:50', 'success'),
(22, NULL, 'Admin', NULL, NULL, 'create', 'book', 26, NULL, '2025-04-02 11:25:31', 'success'),
(23, NULL, 'Admin', NULL, NULL, 'create', 'book', 27, NULL, '2025-04-02 11:29:21', 'success'),
(24, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'p4366a0um8hj962197e8nq1j12', '2025-04-03 16:52:47', 'success'),
(25, NULL, 'Admin', NULL, NULL, 'update', 'book', 25, NULL, '2025-04-03 17:47:07', 'success'),
(26, NULL, 'Admin', NULL, NULL, 'delete', 'book', 25, NULL, '2025-04-03 17:55:20', 'success'),
(27, NULL, 'Admin', NULL, NULL, 'create', 'book', 28, NULL, '2025-04-03 17:58:40', 'success'),
(28, NULL, 'Admin', NULL, NULL, 'update', 'user', 10, NULL, '2025-04-03 17:58:58', 'success'),
(29, NULL, 'Admin', NULL, NULL, 'delete', 'user', 10, NULL, '2025-04-03 17:59:05', 'success'),
(30, NULL, 'Admin', NULL, NULL, 'create', 'user', 13, NULL, '2025-04-03 18:00:10', 'success'),
(31, NULL, 'Admin', NULL, NULL, 'update', 'book', 25, NULL, '2025-04-03 18:02:44', 'success'),
(32, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'ehbijorppm5jkbsfnkb6v8fice', '2025-04-03 18:03:02', 'success'),
(33, NULL, 'Admin', NULL, NULL, 'create', 'book', 29, NULL, '2025-04-03 18:13:46', 'success'),
(34, NULL, 'Admin', NULL, NULL, 'create', 'book', 30, NULL, '2025-04-03 18:16:01', 'success'),
(35, NULL, 'Admin', NULL, NULL, 'create', 'book', 31, NULL, '2025-04-03 18:20:05', 'success'),
(36, NULL, 'Admin', NULL, NULL, 'create', 'book', 32, NULL, '2025-04-03 18:21:02', 'success'),
(37, NULL, 'Admin', NULL, NULL, 'delete', 'user', 1, NULL, '2025-04-03 19:48:05', 'success'),
(38, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '7rtuvmv872vje6fqfnbphaatfq', '2025-04-03 19:56:17', 'success'),
(39, NULL, 'Admin', NULL, NULL, 'delete', 'user', 1, NULL, '2025-04-03 20:04:17', 'success'),
(40, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '3jo16i60r0760ci84on7ngpmdh', '2025-04-03 20:04:59', 'success'),
(41, NULL, 'Admin', NULL, NULL, 'update', 'user', 1, NULL, '2025-04-03 21:00:07', 'success'),
(42, NULL, 'Admin', NULL, NULL, 'update', 'user', 10, NULL, '2025-04-03 21:00:28', 'success'),
(43, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '38p8g1qc0jjflh8gdeurfbu73g', '2025-04-03 21:00:33', 'success'),
(45, NULL, 'Admin', NULL, NULL, 'delete', 'user', 13, NULL, '2025-04-13 08:12:36', 'success'),
(46, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'u25a1m4eeh6fcmbvu76f3ncphn', '2025-04-13 08:13:58', 'success'),
(47, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'bi5qhoat21d0crb7fpe376g55m', '2025-04-13 08:55:50', 'success'),
(48, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '544f3timtmvsnevncd293hkfr9', '2025-04-13 09:08:01', 'success'),
(49, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'snueae6rov3r9shtm8rd4ae6gi', '2025-04-13 09:14:10', 'success'),
(50, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, '6k4bdaqgo7iop84gmut3h4aolp', '2025-04-13 09:17:24', 'success'),
(51, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'tkg2bp5a58c7s3vlvo05fm81pi', '2025-04-13 10:02:10', 'success'),
(52, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'bf77s2i74mjsftso0dmpqu0eu1', '2025-04-13 12:51:26', 'success'),
(53, NULL, 'Admin', NULL, NULL, 'update', 'book', 25, NULL, '2025-04-13 12:52:09', 'success'),
(54, NULL, 'Admin', NULL, NULL, 'delete', 'book', 25, NULL, '2025-04-13 12:52:20', 'success'),
(55, NULL, 'Admin', NULL, NULL, 'update', 'user', 1, NULL, '2025-04-13 12:52:59', 'success'),
(56, NULL, 'Admin', NULL, NULL, 'delete', 'user', 1, NULL, '2025-04-13 13:06:27', 'success'),
(57, NULL, 'Admin', NULL, NULL, 'create', 'user', 15, NULL, '2025-04-13 14:06:02', 'success'),
(58, NULL, 'Admin', NULL, NULL, 'create', 'user', 16, NULL, '2025-04-13 14:35:29', 'success'),
(59, NULL, 'Admin', NULL, NULL, 'create', 'user', 17, NULL, '2025-04-13 15:00:28', 'success'),
(60, NULL, 'Admin', NULL, NULL, 'create', 'user', 18, NULL, '2025-04-13 15:34:18', 'success'),
(61, NULL, 'Admin', NULL, NULL, 'create', 'user', 19, NULL, '2025-04-13 15:39:53', 'success'),
(62, NULL, 'Admin', NULL, NULL, 'delete', 'user', 19, NULL, '2025-04-13 15:50:08', 'success'),
(63, NULL, 'Admin', NULL, NULL, 'delete', 'user', 11, NULL, '2025-04-13 15:51:42', 'success'),
(64, NULL, 'Admin', NULL, NULL, 'delete', 'user', 1, NULL, '2025-04-13 15:51:48', 'success'),
(66, NULL, 'Admin', NULL, NULL, 'create', 'user', 21, NULL, '2025-04-13 16:07:47', 'success'),
(67, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '700edmmd544j0r1q710li2e9qr', '2025-04-13 16:07:55', 'success'),
(68, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, '26f3tmjb7g8nvsmhit2i7deb0p', '2025-04-13 16:08:57', 'success'),
(69, NULL, 'Admin', NULL, NULL, 'delete', 'user', 21, NULL, '2025-04-13 16:09:17', 'success'),
(70, NULL, 'Admin', NULL, NULL, 'delete', 'user', 21, NULL, '2025-04-13 16:37:33', 'success'),
(71, NULL, 'Admin', NULL, NULL, 'delete', 'book', 25, NULL, '2025-04-13 16:38:52', 'success'),
(72, NULL, 'Admin', NULL, NULL, 'delete', 'book', 25, NULL, '2025-04-13 16:39:05', 'success'),
(73, NULL, 'Admin', NULL, NULL, 'delete', 'book', 27, NULL, '2025-04-13 16:39:10', 'success'),
(74, NULL, 'Admin', NULL, NULL, 'delete', 'user', 20, NULL, '2025-04-13 17:04:52', 'success'),
(75, NULL, 'Admin', NULL, NULL, 'delete', 'user', 21, NULL, '2025-04-13 17:14:46', 'success'),
(76, NULL, 'Admin', NULL, NULL, 'restore', 'book', 25, NULL, '2025-04-13 17:44:28', 'success'),
(77, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, '668bhbe79djacdcb4810tf51nr', '2025-04-14 10:08:34', 'success'),
(78, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'lnue9mrvhvuje6aqoepukv36ai', '2025-04-14 12:20:50', 'success'),
(79, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'bf524k9aa0t5e73klmjo66d6f3', '2025-04-14 12:24:58', 'success'),
(80, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'j64buqud2tmh78a8reg537lk27', '2025-04-14 14:07:56', 'success'),
(81, NULL, 'Admin', NULL, NULL, 'create', 'book', 33, NULL, '2025-04-15 12:43:06', 'success'),
(82, NULL, 'Admin', NULL, NULL, 'delete', 'book', 33, NULL, '2025-04-15 12:43:29', 'success'),
(83, NULL, 'Admin', NULL, NULL, 'restore', 'book', 33, NULL, '2025-04-15 12:43:52', 'success'),
(84, NULL, 'Admin', NULL, NULL, 'delete', 'book', 32, NULL, '2025-04-15 12:44:01', 'success'),
(85, NULL, 'Admin', NULL, NULL, 'restore', 'book', 32, NULL, '2025-04-15 12:44:08', 'success'),
(86, NULL, 'Admin', NULL, NULL, 'delete', 'book', 33, NULL, '2025-04-15 12:51:02', 'success'),
(87, NULL, 'Admin', NULL, NULL, 'restore', 'book', 33, NULL, '2025-04-15 12:51:06', 'success'),
(88, NULL, 'Admin', NULL, NULL, 'update', 'book', 25, NULL, '2025-04-15 13:08:12', 'success'),
(89, NULL, 'Admin', NULL, NULL, 'update', 'book', 25, NULL, '2025-04-15 13:09:00', 'success'),
(90, NULL, 'Admin', NULL, NULL, 'update', 'book', 25, NULL, '2025-04-15 13:13:49', 'success'),
(91, NULL, 'Admin', NULL, NULL, 'delete', 'book', 25, NULL, '2025-04-15 13:13:57', 'success'),
(92, NULL, 'Admin', NULL, NULL, 'restore', 'book', 25, NULL, '2025-04-15 13:14:01', 'success'),
(93, NULL, 'Admin', NULL, NULL, 'restore', 'book', 27, NULL, '2025-04-15 13:14:16', 'success'),
(94, NULL, 'Admin', NULL, NULL, 'delete', 'book', 25, NULL, '2025-04-15 13:32:23', 'success'),
(95, NULL, 'Admin', NULL, NULL, 'restore', 'book', 25, NULL, '2025-04-15 13:32:27', 'success'),
(96, NULL, 'Admin', NULL, NULL, 'update', 'book', 25, NULL, '2025-04-15 13:32:39', 'success'),
(97, NULL, 'Admin', NULL, NULL, 'update', 'user', 22, NULL, '2025-04-15 13:33:01', 'success'),
(98, NULL, 'Admin', NULL, NULL, 'create', 'user', 24, NULL, '2025-04-15 13:33:46', 'success'),
(99, NULL, 'Admin', NULL, NULL, 'delete', 'user', 24, NULL, '2025-04-15 13:34:07', 'success'),
(100, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '3r24iksv7e06h6jksoqfbpa8q1', '2025-04-15 13:34:54', 'success'),
(101, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, '8bpo7gmg2rb0cb0qhsvqf84bob', '2025-04-15 22:45:56', 'success'),
(102, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, '0kf036ft0a5e48mv6ek2tr15pn', '2025-04-15 23:19:30', 'success'),
(103, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '0i2bjj9c4h22meklgob6l6vd2v', '2025-04-15 23:20:13', 'success'),
(104, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'lsfm2pfrcpo8grc13akle0oc70', '2025-04-16 01:57:06', 'success'),
(105, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, '2id8h9h50dv4a8rklanr15t46d', '2025-04-16 03:55:22', 'success'),
(106, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '9a90ipnnk7njkuollb0kavcrmu', '2025-04-16 03:58:30', 'success'),
(107, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'qf6fgb5nq6k3qnom4pam41dehm', '2025-04-16 03:59:36', 'success'),
(108, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'n3o3q6kemid1d3kslcjr7m0q1a', '2025-04-16 06:38:56', 'success'),
(109, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'ss1v0l7gcs2uat0noio747j47l', '2025-04-16 06:41:45', 'success'),
(110, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'vjlf6n7b0bd8v25p3e3h0vdu6l', '2025-04-16 06:45:10', 'success'),
(111, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'hp0h0j0tsudle1imt4kb6ki5sg', '2025-04-16 06:46:55', 'success'),
(112, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'kpd4o0vc2k3uimm5nehl1v3m07', '2025-04-16 06:54:22', 'success'),
(113, NULL, 'Admin', NULL, NULL, 'update', 'user', 22, NULL, '2025-04-16 06:54:50', 'success'),
(114, NULL, 'Admin', NULL, NULL, 'delete', 'user', 24, NULL, '2025-04-16 06:54:57', 'success'),
(115, NULL, 'Admin', NULL, NULL, 'update', 'book', 26, NULL, '2025-04-16 07:03:36', 'success'),
(116, NULL, 'Admin', NULL, NULL, 'update', 'book', 33, NULL, '2025-04-16 07:03:59', 'success'),
(117, NULL, 'Admin', NULL, NULL, 'update', 'book', 25, NULL, '2025-04-16 07:12:06', 'success'),
(118, NULL, 'Admin', NULL, NULL, 'delete', 'book', 25, NULL, '2025-04-16 07:12:10', 'success'),
(119, NULL, 'Admin', NULL, NULL, 'restore', 'book', 25, NULL, '2025-04-16 07:12:17', 'success'),
(120, NULL, 'Admin', NULL, NULL, 'create', 'user', 27, NULL, '2025-04-16 07:12:39', 'success'),
(121, NULL, 'Admin', NULL, NULL, 'update', 'user', 27, NULL, '2025-04-16 07:12:52', 'success'),
(122, NULL, 'Admin', NULL, NULL, 'delete', 'user', 27, NULL, '2025-04-16 07:12:59', 'success'),
(123, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'idbfn35ous1dtdokj9ur4sdn5r', '2025-04-16 07:25:58', 'success'),
(124, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'ugv2mat94ejnbb5v473d1kpeg3', '2025-04-16 07:26:11', 'success'),
(125, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'e222l39uj4tolsjf089b7v67b2', '2025-04-16 10:02:29', 'success'),
(126, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, 'lnq15tmh3dd0lfc935aovcp1tq', '2025-04-16 10:04:44', 'success'),
(127, NULL, 'Admin', NULL, NULL, 'update', 'book', 25, NULL, '2025-04-16 10:05:08', 'success'),
(128, NULL, 'Admin', NULL, NULL, 'delete', 'user', 27, NULL, '2025-04-16 10:05:25', 'success'),
(129, NULL, 'Admin', NULL, NULL, 'create', 'book', 34, NULL, '2025-04-16 12:52:04', 'success'),
(130, NULL, 'Admin', NULL, NULL, 'create', 'book', 35, NULL, '2025-04-16 13:00:48', 'success'),
(131, NULL, 'Admin', NULL, NULL, 'delete', 'book', 35, NULL, '2025-04-16 13:10:32', 'success'),
(132, NULL, 'Admin', NULL, NULL, 'restore', 'book', 35, NULL, '2025-04-16 13:10:40', 'success'),
(133, NULL, 'Admin', NULL, NULL, 'update', 'user', 27, NULL, '2025-04-16 13:10:54', 'success'),
(134, NULL, 'Admin', NULL, NULL, 'delete', 'user', 27, NULL, '2025-04-16 13:11:03', 'success'),
(135, NULL, 'Admin', NULL, NULL, 'update', 'book', 25, NULL, '2025-04-16 16:12:44', 'success'),
(136, NULL, 'Admin', NULL, NULL, 'delete', 'book', 25, NULL, '2025-04-16 16:12:48', 'success'),
(137, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'ki6ip9m7nl3l8q2o0v9nbofo7f', '2025-04-16 16:16:24', 'success'),
(138, NULL, 'Admin', NULL, NULL, 'restore', 'book', 25, NULL, '2025-04-16 16:24:00', 'success'),
(139, NULL, 'Admin', NULL, NULL, 'delete', 'book', 25, NULL, '2025-04-16 16:24:11', 'success'),
(140, NULL, 'Admin', NULL, NULL, 'update', 'book', 26, NULL, '2025-04-16 17:01:45', 'success'),
(141, NULL, 'Admin', NULL, NULL, 'restore', 'book', 25, NULL, '2025-04-16 17:01:50', 'success'),
(142, NULL, 'Admin', NULL, NULL, 'delete', 'book', 25, NULL, '2025-04-16 17:01:54', 'success'),
(143, NULL, 'Admin', NULL, NULL, 'update', 'user', 27, NULL, '2025-04-16 17:02:12', 'success'),
(144, NULL, 'Admin', NULL, NULL, 'delete', 'user', 27, NULL, '2025-04-16 17:02:18', 'success'),
(145, NULL, 'Admin', NULL, NULL, 'create', 'book', 36, NULL, '2025-04-16 17:03:36', 'success'),
(146, NULL, 'Admin', NULL, NULL, 'create', 'user', 29, NULL, '2025-04-16 17:47:57', 'success'),
(147, NULL, 'Admin', NULL, NULL, 'delete', 'user', 22, NULL, '2025-04-16 17:49:27', 'success'),
(148, NULL, 'Admin', NULL, NULL, 'delete', 'user', 29, NULL, '2025-04-16 17:51:57', 'success'),
(149, NULL, 'Admin', NULL, NULL, 'update', 'book', 26, NULL, '2025-04-16 17:52:09', 'success'),
(150, NULL, 'Admin', NULL, NULL, 'delete', 'book', 27, NULL, '2025-04-16 17:52:16', 'success'),
(151, NULL, 'Admin', NULL, NULL, 'create', 'user', 33, NULL, '2025-04-16 17:53:33', 'success'),
(152, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'oc2rb1t5bjn6kjlcciha8ovs24', '2025-04-16 18:09:02', 'success'),
(153, NULL, 'Admin', NULL, NULL, 'create', 'user', 37, NULL, '2025-04-16 18:25:31', 'success'),
(154, NULL, 'Admin', NULL, NULL, 'create', 'user', 38, NULL, '2025-04-16 18:25:54', 'success'),
(155, NULL, 'Admin', NULL, NULL, 'create', 'book', 37, NULL, '2025-04-16 18:35:15', 'success'),
(156, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '16rm8q06gef4ungul0a6r44if8', '2025-04-16 20:59:21', 'success'),
(157, NULL, 'Admin', NULL, NULL, 'delete', 'user', 38, NULL, '2025-04-16 21:06:31', 'success'),
(158, NULL, 'Admin', NULL, NULL, 'delete', 'book', 28, NULL, '2025-04-16 21:06:56', 'success'),
(159, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'cpqfmrj7kam9d64trpeif7stn4', '2025-04-17 03:56:16', 'success'),
(160, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, 'i6hb9j930ncbvokr5c2rn8gieo', '2025-04-17 03:58:49', 'success'),
(161, NULL, 'Admin', NULL, NULL, 'restore', 'book', 25, NULL, '2025-04-17 04:07:22', 'success'),
(162, NULL, 'Admin', NULL, NULL, 'update', 'user', 39, NULL, '2025-04-17 04:07:41', 'success'),
(163, NULL, 'Admin', NULL, NULL, 'delete', 'user', 37, NULL, '2025-04-17 04:08:03', 'success'),
(164, NULL, 'Admin', NULL, NULL, 'create', 'user', 42, NULL, '2025-04-17 04:08:50', 'success'),
(165, NULL, 'Admin', NULL, NULL, 'create', 'book', 38, NULL, '2025-04-17 04:48:22', 'success'),
(166, NULL, 'Admin', NULL, NULL, 'create', 'book', 39, NULL, '2025-04-17 04:49:22', 'success'),
(167, NULL, 'Admin', NULL, NULL, 'create', 'book', 40, NULL, '2025-04-17 04:50:34', 'success'),
(168, NULL, 'Admin', NULL, NULL, 'create', 'book', 41, NULL, '2025-04-17 04:52:02', 'success'),
(169, NULL, 'Admin', NULL, NULL, 'create', 'book', 42, NULL, '2025-04-17 04:53:26', 'success'),
(170, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 06:38:12', 'success'),
(171, NULL, 'Admin', NULL, NULL, 'create', 'user', 44, NULL, '2025-04-17 06:52:54', 'success'),
(172, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 06:53:54', 'success'),
(173, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 07:13:59', 'success'),
(174, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 07:20:12', 'success'),
(175, NULL, 'Admin', NULL, NULL, 'create', 'book', 43, NULL, '2025-04-17 07:29:40', 'success'),
(176, NULL, 'Admin', NULL, NULL, 'update', 'book', 26, NULL, '2025-04-17 07:29:55', 'success'),
(177, NULL, 'Admin', NULL, NULL, 'update', 'book', 26, NULL, '2025-04-17 07:30:16', 'success'),
(178, NULL, 'Admin', NULL, NULL, 'delete', 'book', 26, NULL, '2025-04-17 07:30:23', 'success'),
(179, NULL, 'Admin', NULL, NULL, 'restore', 'book', 26, NULL, '2025-04-17 07:30:29', 'success'),
(180, NULL, 'Admin', NULL, NULL, 'create', 'user', 46, NULL, '2025-04-17 07:30:55', 'success'),
(181, NULL, 'Admin', NULL, NULL, 'delete', 'user', 46, NULL, '2025-04-17 07:31:35', 'success'),
(182, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 07:32:01', 'success'),
(183, NULL, 'User', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 07:44:37', 'success'),
(184, NULL, 'Admin', NULL, NULL, 'create', 'book', 44, NULL, '2025-04-17 08:02:24', 'success'),
(185, NULL, 'Admin', NULL, NULL, 'update', 'book', 44, NULL, '2025-04-17 08:02:42', 'success'),
(186, NULL, 'Admin', NULL, NULL, 'update', 'book', 44, NULL, '2025-04-17 08:02:57', 'success'),
(187, NULL, 'Admin', NULL, NULL, 'delete', 'book', 44, NULL, '2025-04-17 08:03:02', 'success'),
(188, NULL, 'Admin', NULL, NULL, 'restore', 'book', 44, NULL, '2025-04-17 08:03:12', 'success'),
(189, NULL, 'Admin', NULL, NULL, 'create', 'user', 50, NULL, '2025-04-17 08:03:39', 'success'),
(190, NULL, 'Admin', NULL, NULL, 'update', 'user', 40, NULL, '2025-04-17 08:03:50', 'success'),
(191, NULL, 'Admin', NULL, NULL, 'update', 'user', 40, NULL, '2025-04-17 08:03:59', 'success'),
(192, NULL, 'Admin', NULL, NULL, 'delete', 'user', 44, NULL, '2025-04-17 08:04:04', 'success'),
(193, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 08:04:30', 'success'),
(194, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 08:05:58', 'success'),
(195, 51, 'User', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 08:10:14', 'success'),
(196, NULL, 'Admin', NULL, NULL, 'update', 'book', 42, NULL, '2025-04-17 08:26:32', 'success'),
(197, NULL, 'Admin', NULL, NULL, 'delete', 'book', 42, NULL, '2025-04-17 08:26:36', 'success'),
(198, NULL, 'Admin', NULL, NULL, 'restore', 'book', 42, NULL, '2025-04-17 08:26:40', 'success'),
(199, NULL, 'Admin', NULL, NULL, 'create', 'user', 54, NULL, '2025-04-17 08:27:33', 'success'),
(200, NULL, 'Admin', NULL, NULL, 'update', 'user', 46, NULL, '2025-04-17 08:27:53', 'success'),
(201, NULL, 'Admin', NULL, NULL, 'delete', 'user', 46, NULL, '2025-04-17 08:28:06', 'success'),
(202, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 08:28:21', 'success'),
(203, NULL, 'Admin', NULL, NULL, 'create', 'book', 45, NULL, '2025-04-17 08:45:24', 'success'),
(204, NULL, 'Admin', NULL, NULL, 'update', 'book', 45, NULL, '2025-04-17 08:45:42', 'success'),
(205, NULL, 'Admin', NULL, NULL, 'update', 'book', 45, NULL, '2025-04-17 08:46:02', 'success'),
(206, NULL, 'Admin', NULL, NULL, 'delete', 'book', 45, NULL, '2025-04-17 08:46:16', 'success'),
(207, NULL, 'Admin', NULL, NULL, 'restore', 'book', 45, NULL, '2025-04-17 08:46:24', 'success'),
(208, NULL, 'Admin', NULL, NULL, 'create', 'user', 57, NULL, '2025-04-17 08:47:02', 'success'),
(209, NULL, 'Admin', NULL, NULL, 'update', 'user', 51, NULL, '2025-04-17 08:47:22', 'success'),
(210, NULL, 'Admin', NULL, NULL, 'update', 'user', 51, NULL, '2025-04-17 08:47:30', 'success'),
(211, NULL, 'Admin', NULL, NULL, 'update', 'user', 51, NULL, '2025-04-17 08:47:42', 'success'),
(212, NULL, 'Admin', NULL, NULL, 'delete', 'user', 46, NULL, '2025-04-17 08:47:52', 'success'),
(213, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 08:48:05', 'success'),
(214, 51, 'User', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 08:51:41', 'success'),
(215, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 09:08:24', 'success'),
(216, NULL, 'Admin', NULL, NULL, 'create', 'book', 46, NULL, '2025-04-17 09:25:35', 'success'),
(217, NULL, 'Admin', NULL, NULL, 'update', 'book', 46, NULL, '2025-04-17 09:25:55', 'success'),
(218, NULL, 'Admin', NULL, NULL, 'delete', 'book', 46, NULL, '2025-04-17 09:26:05', 'success'),
(219, NULL, 'Admin', NULL, NULL, 'restore', 'book', 46, NULL, '2025-04-17 09:26:13', 'success'),
(220, NULL, 'Admin', NULL, NULL, 'create', 'user', 60, NULL, '2025-04-17 09:26:55', 'success'),
(221, NULL, 'Admin', NULL, NULL, 'update', 'user', 46, NULL, '2025-04-17 09:27:17', 'success'),
(222, NULL, 'Admin', NULL, NULL, 'delete', 'user', 46, NULL, '2025-04-17 09:27:22', 'success'),
(223, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 09:27:49', 'success'),
(224, 51, 'User', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 09:30:42', 'success'),
(225, NULL, 'Admin', NULL, NULL, 'create', 'book', 47, NULL, '2025-04-17 09:41:56', 'success'),
(226, NULL, 'Admin', NULL, NULL, 'update', 'book', 43, NULL, '2025-04-17 09:42:15', 'success'),
(227, NULL, 'Admin', NULL, NULL, 'update', 'book', 43, NULL, '2025-04-17 09:42:34', 'success'),
(228, NULL, 'Admin', NULL, NULL, 'delete', 'book', 43, NULL, '2025-04-17 09:42:47', 'success'),
(229, NULL, 'Admin', NULL, NULL, 'restore', 'book', 43, NULL, '2025-04-17 09:43:00', 'success'),
(230, NULL, 'Admin', NULL, NULL, 'delete', 'book', 43, NULL, '2025-04-17 09:43:11', 'success'),
(231, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 09:43:16', 'success'),
(232, 51, 'User', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 09:43:52', 'success'),
(233, NULL, 'Admin', NULL, NULL, 'create', 'user', 63, NULL, '2025-04-17 09:44:35', 'success'),
(234, NULL, 'Admin', NULL, NULL, 'update', 'user', 46, NULL, '2025-04-17 09:44:54', 'success'),
(235, NULL, 'Admin', NULL, NULL, 'delete', 'user', 46, NULL, '2025-04-17 09:44:59', 'success'),
(236, NULL, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 09:45:18', 'success'),
(237, 51, 'User', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 09:48:20', 'success'),
(238, 64, 'Admin', NULL, NULL, 'create', 'book', 48, NULL, '2025-04-17 10:07:45', 'success'),
(239, 64, 'Admin', NULL, NULL, 'update', 'book', 26, NULL, '2025-04-17 10:09:01', 'success'),
(240, 64, 'Admin', NULL, NULL, 'delete', 'book', 26, NULL, '2025-04-17 10:09:08', 'success'),
(241, 64, 'Admin', NULL, NULL, 'restore', 'book', 26, NULL, '2025-04-17 10:09:14', 'success'),
(242, 64, 'Admin', NULL, NULL, 'delete', 'book', 39, NULL, '2025-04-17 10:09:27', 'success'),
(243, 64, 'Admin', NULL, NULL, 'create', 'user', 66, NULL, '2025-04-17 10:10:02', 'success'),
(244, 64, 'Admin', NULL, NULL, 'update', 'user', 46, NULL, '2025-04-17 10:10:24', 'success'),
(245, 64, 'Admin', NULL, NULL, 'delete', 'user', 46, NULL, '2025-04-17 10:10:30', 'success'),
(246, 64, 'Admin', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 10:10:50', 'success'),
(247, 51, 'User', '::1', NULL, 'logout', NULL, NULL, '', '2025-04-17 10:12:55', 'success');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('Admin','User') NOT NULL DEFAULT 'User',
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `verification_token` varchar(64) DEFAULT NULL,
  `verify_token_expiry` datetime DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `status` enum('active','pending','suspended','deleted') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `role`, `reset_token`, `reset_token_expiry`, `verification_token`, `verify_token_expiry`, `verified`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(44, 'user1', '$2y$10$P7zr3knaHzzPWylDcVfbeeLFPfI37PuwPKHxDj0OgHEZ5GL2MqRBy', 'user1@gmail.com', 'User', NULL, NULL, '6f3b05a9bbae70c314ba18cf836e66a7220f9846bca8ac502f35f9a625295163', '2025-04-17 09:52:52', 0, 'active', '2025-04-17 06:52:52', '2025-04-17 08:04:08', NULL),
(46, 'user6 edit', '$2y$10$t4ByuST/qSCih/tNIspvweLgVhRjP5kgj4nsBNEWkbXnrnY1HyANW', 'user28@gmail.com', 'User', NULL, NULL, '96922de80523a9f41de19c2a3060344914fa2e10ac10d01917f738ce632ecf46', '2025-04-17 10:30:53', 0, 'active', '2025-04-17 07:30:53', '2025-04-17 10:10:34', NULL),
(50, 'user3', '$2y$10$TvdzKrJtgMJez4RyQXy49.c9MNPNxbB2dfsBIVxJy8cb4m.CAH/vO', 'user3@gmail.com', 'User', NULL, NULL, '639a7b0bc7d0ff4c4078e5a0c64a925e700c8fbacbb943f3d83dd5163c111a4f', '2025-04-17 11:03:38', 0, 'pending', '2025-04-17 08:03:38', '2025-04-17 08:03:38', NULL),
(51, 'yetunde', '$2y$10$HDe3qUbKCgdX85lJuHhLYeZ408Cs13mZJk6dyq3WLPXOEiiki71vm', 'yetundesaka1@gmail.com', 'User', NULL, NULL, NULL, NULL, 1, 'active', '2025-04-17 08:08:13', '2025-04-17 08:47:42', NULL),
(54, 'user4', '$2y$10$7AjPn0LsWohUdYbCqbKzjeQlUbGZ3SR2U6MopJh35eXRqflSdcEvG', 'user4@gmail.com', 'Admin', NULL, NULL, '265a2b366ff223fe2291d9934bc83b63c7f7a62ef818a4d2eaf590fab9ff1abf', '2025-04-17 11:27:31', 0, 'pending', '2025-04-17 08:27:31', '2025-04-17 08:27:31', NULL),
(57, 'user8', '$2y$10$HXZTUi9Y1JSO0woJtPY4oOZjNXUMOgQbZ6pSTvXpgKeXn1dtl26SO', 'user8@gmail.com', 'Admin', NULL, NULL, 'ddca3043abcc0fad4f3a63cfe18c9fc7ac4f56a0e9838eb4077ffb0030764294', '2025-04-17 11:47:00', 0, 'pending', '2025-04-17 08:47:00', '2025-04-17 08:47:00', NULL),
(60, 'sakabo', '$2y$10$PcBDoL6hn8ewe84YUkiAl.Vhxe85cuPVokJQtYnSk7KMTyImFwlSu', 'user9@gmail.com', 'Admin', NULL, NULL, '77a2ed2354b9cb74e017983b446500acbf016e8b3ac86d06c8cb69fa93192aa0', '2025-04-17 12:26:53', 0, 'pending', '2025-04-17 09:26:53', '2025-04-17 09:26:53', NULL),
(63, 'pdud', '$2y$10$3XinLSFq3T12A/DfRp11rOwVZImgCJ7AgZjpbpO8zVwwoC6futZv2', 'user10@gmail.com', 'Admin', NULL, NULL, '20f4a3efb75909dc9043d390457630fbf4d80004958294858cffe7c8795063d7', '2025-04-17 12:44:33', 0, 'pending', '2025-04-17 09:44:33', '2025-04-17 09:44:33', NULL),
(64, 'bodunrin', '$2y$10$vMBaZXPNOO8xanOesuV3EeuTcl0j.cn4bXfUE6eSKH0Zxme4yTaEe', 'sakabodunrin.az@gmail.com', 'Admin', NULL, NULL, NULL, NULL, 1, 'active', '2025-04-17 10:05:28', '2025-04-17 10:06:08', NULL),
(66, 'user', '$2y$10$xnnPdVt9OzN1.wVMfqVff.xkP9SgjDP3vYsPnX70PuZXGpZSrYmli', 'user54@gmail.com', 'Admin', NULL, NULL, '301c9600edb4985dd2fdf97b974caa9612e182cb782a0a06c51a8a8688383b51', '2025-04-17 13:10:00', 0, 'pending', '2025-04-17 10:10:00', '2025-04-17 10:10:00', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_active_loans`
-- (See below for the actual view)
--
CREATE TABLE `user_active_loans` (
`user_id` int(11)
,`active_count` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `user_active_loans`
--
DROP TABLE IF EXISTS `user_active_loans`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_active_loans`  AS SELECT `loans`.`user_id` AS `user_id`, count(0) AS `active_count` FROM `loans` WHERE `loans`.`return_date` is null GROUP BY `loans`.`user_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loan_id`),
  ADD UNIQUE KEY `unique_loan` (`user_id`,`book_id`,`return_date`),
  ADD KEY `fk_book` (`book_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`attempt_id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_log_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `fk_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
