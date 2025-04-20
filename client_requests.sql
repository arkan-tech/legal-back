-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 29, 2024 at 02:26 PM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ymtaz_db_old`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_requests`
--

DROP TABLE IF EXISTS `client_requests`;
CREATE TABLE IF NOT EXISTS `client_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `description` text,
  `priority` tinyint(2) DEFAULT NULL COMMENT '1 3agel , 2 date, 3 other',
  `file` varchar(255) DEFAULT NULL,
  `payment_status` int(11) NOT NULL DEFAULT '0',
  `price` int(11) DEFAULT NULL,
  `replay` longtext,
  `replay_file` text,
  `replay_from_admin` int(11) DEFAULT NULL,
  `replay_from_lawyer_id` int(11) DEFAULT NULL,
  `replay_status` int(11) NOT NULL DEFAULT '0',
  `replay_date` varchar(100) DEFAULT NULL,
  `replay_time` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `for_admin` int(11) NOT NULL DEFAULT '1',
  `advisory_id` int(11) DEFAULT NULL,
  `lawyer_id` int(11) DEFAULT NULL,
  `request_status` int(11) DEFAULT '0' COMMENT '0=>''قيد الدراسة'',\r\n1=>''قيد الانتظار''\r\n2=>''مكتملة''',
  `accept_rules` int(11) DEFAULT '1',
  `referral_status` int(11) DEFAULT '0',
  `transaction_complete` int(11) DEFAULT '0',
  `transaction_id` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client_requests`
--

INSERT INTO `client_requests` (`id`, `client_id`, `type_id`, `description`, `priority`, `file`, `payment_status`, `price`, `replay`, `replay_file`, `replay_from_admin`, `replay_from_lawyer_id`, `replay_status`, `replay_date`, `replay_time`, `status`, `for_admin`, `advisory_id`, `lawyer_id`, `request_status`, `accept_rules`, `referral_status`, `transaction_complete`, `transaction_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1661, 26, 'شصيشصشسي', 1, NULL, 1, 735, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 2, NULL, 1, NULL, 1, 1, 'EDCF4FEDBBF98571C704EE80925C0C960C53B88D864FD9AF7C60440931326CD4', '2024-02-29 11:54:27', '2024-02-29 12:15:24', NULL),
(2, 1661, 27, 'شصيشصشسي', 1, NULL, 1, 423, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, 1, 0, '54230AF095C7D53D0134AC92B18CBDD71C83E0BE362A04CA0B32134796C63A2C', '2024-02-29 11:59:00', '2024-02-29 11:59:02', NULL),
(3, 1661, 27, 'شصيشصشسي', 2, NULL, 1, 735, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, 1, 0, 'F28E86F1D4C0443706A53A0737F756472929870C32B83A547D48AE830D97808F', '2024-02-29 11:59:32', '2024-02-29 11:59:33', NULL),
(4, 1661, 27, 'شصيشصشسي', 4, NULL, 1, 6521, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, 1, 0, 'DBF7432D068534D21E88F0329768FD4D0A9EC565154BC5CDEFADB6C591A75467', '2024-02-29 11:59:49', '2024-02-29 11:59:52', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
