-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 02, 2018 at 06:22 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_retail`
--

-- --------------------------------------------------------

--
-- Table structure for table `activation`
--

CREATE TABLE `activation` (
  `id` int(200) NOT NULL,
  `licence_key` varchar(400) NOT NULL,
  `start_date` varchar(400) NOT NULL,
  `start_time` varchar(400) NOT NULL,
  `end_date` varchar(400) NOT NULL,
  `end_time` varchar(400) NOT NULL,
  `end_date_time` varchar(400) NOT NULL,
  `time_activated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `previous_key_expiry` varchar(400) NOT NULL,
  `key_expired` tinyint(1) NOT NULL,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(200) NOT NULL,
  `agent_id` varchar(400) NOT NULL,
  `agent_name` varchar(400) NOT NULL,
  `contact` varchar(400) NOT NULL,
  `position` varchar(400) NOT NULL,
  `photo` varchar(400) NOT NULL,
  `sale_area` text NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `agent_id`, `agent_name`, `contact`, `position`, `photo`, `sale_area`, `time_added`, `time_modified`, `user_id`) VALUES
(1, 'AG-001-01184', '', '66352452', 'Assasin', 'images/files/agent_photos/20180116040124_tÃ©lÃ©chargement (3).jpg', '', '2018-01-16 03:50:24', '2018-01-16 03:50:24', 'NONE'),
(2, 'AG-002-01188', '', 'contc', 'Ndi', 'images/files/agent_photos/20180116040101_tÃ©lÃ©chargement (3).jpg', 'around maling', '2018-01-16 03:58:01', '2018-01-16 03:58:01', 'NONE'),
(3, 'AG-003-01184', 'Hitman', '7899565', 'Assasin', '', 'Russia Against US.', '2018-01-16 04:00:00', '2018-01-16 04:00:00', 'NONE'),
(4, 'AG-004-01187', 'Hitman Agent 47', '7899655', 'Assasin', 'images/files/agent_photos/20180118030153_download.jpg', 'Killing in Malingo', '2018-01-18 14:45:53', '2018-01-18 14:45:53', 'NONE'),
(5, 'AG-005-01186', 'Jevis', '546223112', 'Writer', 'images/files/agent_photos/20180118030133_download.jpg', 'Molyko', '2018-01-18 14:46:33', '2018-01-18 14:46:33', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(100) NOT NULL,
  `category` varchar(400) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `status`) VALUES
(2, 'Clothes', 1),
(4, 'Shoes 2', 0),
(6, 'New Cat', 0),
(7, 'Cars Category', 1),
(8, 'Books', 1),
(9, 'Kitchen Food', 1);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(100) NOT NULL,
  `company_name` varchar(400) NOT NULL,
  `location` varchar(400) NOT NULL,
  `email` varchar(400) NOT NULL,
  `contact` varchar(400) NOT NULL,
  `pobox` varchar(400) NOT NULL,
  `photo` varchar(400) NOT NULL,
  `activity` text NOT NULL,
  `manager` varchar(400) NOT NULL,
  `manager_email` varchar(400) NOT NULL,
  `manager_contact` varchar(400) NOT NULL,
  `tax_regime` varchar(400) NOT NULL,
  `tax_number` varchar(400) NOT NULL,
  `financial_year` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `location`, `email`, `contact`, `pobox`, `photo`, `activity`, `manager`, `manager_email`, `manager_contact`, `tax_regime`, `tax_number`, `financial_year`) VALUES
(1, 'Distinguished Fashions', 'Bomaka', 'bm@maio.com', '69855', '65233', 'images/files/company/20180212060235_173472218.jpg', 'Activities\r\nNew line\r\nAnother one\r\nREal Iron', 'Mr Ndi Tifuh', 'mymail@gmail.com', '68985512', '89998', '+698/*865', '2018');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(200) NOT NULL,
  `customer_id` varchar(400) NOT NULL,
  `customer_name` varchar(400) NOT NULL,
  `business_name` varchar(400) NOT NULL,
  `location` varchar(400) NOT NULL,
  `email` varchar(400) NOT NULL,
  `contact` varchar(400) NOT NULL,
  `pobox` varchar(400) NOT NULL,
  `fax` varchar(400) NOT NULL,
  `photo` varchar(400) NOT NULL,
  `credit_limit` varchar(400) NOT NULL,
  `discount_rate` varchar(400) NOT NULL,
  `settlement_days` varchar(200) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `user_id` varchar(400) NOT NULL,
  `time_added` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_id`, `customer_name`, `business_name`, `location`, `email`, `contact`, `pobox`, `fax`, `photo`, `credit_limit`, `discount_rate`, `settlement_days`, `day`, `month`, `year`, `user_id`, `time_added`) VALUES
(1, 'iiooiei', 'cedric', 'jecivs and co', 'buea', 'emd@mai.com', 'djfkj', 'dkfj', 'djfjkd@jkdfjkd.com', 'images/files/agent_photos/20180118030132_download.jpg', '1000', '30000', '20', 18, 1, 2018, 'NONE', '2018-01-18 15:40:32');

-- --------------------------------------------------------

--
-- Table structure for table `first_run`
--

CREATE TABLE `first_run` (
  `id` int(10) NOT NULL,
  `first_run` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `first_run`
--

INSERT INTO `first_run` (`id`, `first_run`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `issue_inventory`
--

CREATE TABLE `issue_inventory` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `product_code` varchar(400) NOT NULL,
  `product_name` varchar(400) NOT NULL,
  `quantity` int(200) NOT NULL,
  `unit_price` int(200) NOT NULL,
  `total` int(200) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issue_inventory`
--

INSERT INTO `issue_inventory` (`id`, `ref`, `date`, `product_code`, `product_name`, `quantity`, `unit_price`, `total`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, 'ISS180003', '16/01/2018', 'RI45', 'Rice', 10, 8000, 80000, 16, 1, 2018, '2018-01-16 11:39:40', 'NONE'),
(2, 'ISS180003', '16/01/2018', 'COO454', 'Coori coori', 6, 4000, 24000, 16, 1, 2018, '2018-01-16 11:39:41', 'NONE'),
(3, '12255', '18/01/2018', 'RI45', 'Rice', 5, 8000, 40000, 18, 1, 2018, '2018-01-18 15:04:16', 'NONE'),
(4, '12255', '18/01/2018', 'RI45', 'Rice', 5, 8000, 40000, 18, 1, 2018, '2018-01-18 15:05:12', 'NONE'),
(5, '125', '18/01/2018', '0er564-566', 'Milk', 5, 1000, 5000, 18, 1, 2018, '2018-01-18 15:10:48', 'NONE'),
(6, '566', '18/01/2018', 'RI45', 'Rice', 3, 8000, 24000, 18, 1, 2018, '2018-01-18 17:40:30', 'NONE'),
(7, '566', '18/01/2018', 'COO454', 'Coori coori', 4, 4000, 16000, 18, 1, 2018, '2018-01-18 17:40:31', 'NONE'),
(8, 'ISS-00006', '05/02/2018', 'RI45', 'Rice', 5, 8000, 40000, 5, 2, 2018, '2018-02-05 20:16:22', 'NONE'),
(9, 'ISS-00006', '05/02/2018', 'COO454', 'Coori coori', 4, 4000, 16000, 5, 2, 2018, '2018-02-05 20:16:22', 'NONE'),
(10, 'ISS-00006', '05/02/2018', '9900', '899', 2, 0, 0, 5, 2, 2018, '2018-02-05 20:16:22', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `issue_ref`
--

CREATE TABLE `issue_ref` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `sales_agent` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `tax` varchar(400) NOT NULL,
  `discount` varchar(400) NOT NULL,
  `total_price` int(200) NOT NULL,
  `items_sold` int(200) NOT NULL,
  `final_total` int(200) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issue_ref`
--

INSERT INTO `issue_ref` (`id`, `ref`, `sales_agent`, `date`, `tax`, `discount`, `total_price`, `items_sold`, `final_total`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, 'ISS180003', 'JNH', '16/01/2018', '', '', 104000, 2, 0, 16, 1, 2018, '2018-01-16 11:39:41', 'NONE'),
(2, '12255', 'Jevis', '18/01/2018', '', '', 40000, 1, 0, 18, 1, 2018, '2018-01-18 15:04:16', 'NONE'),
(3, '12255', 'Jevis', '18/01/2018', '', '', 40000, 1, 0, 18, 1, 2018, '2018-01-18 15:05:13', 'NONE'),
(4, '125', 'Hitman Agent 47', '18/01/2018', '', '', 5000, 1, 0, 18, 1, 2018, '2018-01-18 15:10:48', 'NONE'),
(5, '566', 'Jevis', '18/01/2018', '', '', 40000, 2, 0, 18, 1, 2018, '2018-01-18 17:40:31', 'NONE'),
(6, 'ISS-00006', 'Jevis', '05/02/2018', '', '', 56000, 3, 0, 5, 2, 2018, '2018-02-05 20:16:22', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(150) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `barcode` varchar(400) NOT NULL,
  `product_code` varchar(400) NOT NULL,
  `product_name` varchar(400) NOT NULL,
  `quantity` int(200) NOT NULL,
  `measure_unit` varchar(400) NOT NULL,
  `category` varchar(400) NOT NULL,
  `cost` int(200) NOT NULL,
  `unit_price` int(200) NOT NULL,
  `reorder_level` varchar(400) NOT NULL,
  `suplier` varchar(400) NOT NULL,
  `location` varchar(400) NOT NULL,
  `contact` varchar(400) NOT NULL,
  `product_status` tinyint(1) NOT NULL,
  `show_stock_available` tinyint(1) NOT NULL,
  `expiry_date` varchar(400) NOT NULL,
  `valuation_method` varchar(100) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `ref`, `date`, `barcode`, `product_code`, `product_name`, `quantity`, `measure_unit`, `category`, `cost`, `unit_price`, `reorder_level`, `suplier`, `location`, `contact`, `product_status`, `show_stock_available`, `expiry_date`, `valuation_method`, `day`, `month`, `year`, `time_added`, `time_updated`, `user_id`) VALUES
(1, '364', '02/01/2018', '125654fgf', 'COO454', 'Coori coori', 35, 'bottel', 'Food', 3000, 4000, '15', 'Fru Ndi', 'Muea', '67920', 1, 1, '04/01/2018', 'FIFO', 13, 1, 2018, '2018-01-13 06:32:16', '2018-03-02 04:15:42', 'NONE'),
(2, '2015', '02/01/2018', '26599', '0er564-566', 'Milk', 10, 'bottles', 'Food', 600, 1000, '12', 'Cedric', 'Muea', '6589566', 1, 1, '26/01/2018', 'FIFO', 14, 1, 2018, '2018-01-14 04:13:09', '2018-03-02 04:15:42', 'NONE'),
(3, '788', '', '', '9900', 'Cocoa', 34, 'Bags', 'Clothes', 2000, 3000, '25', '', '', '', 1, 1, '30/04/2025', 'FIFO', 15, 1, 2018, '2018-01-15 16:35:31', '2018-03-02 04:15:42', 'NONE'),
(4, '242535', '18/01/2018', '345', 'RI45', 'Rice', 17, 'Bags', 'Cars Category', 6000, 8000, '50', 'Jevis', 'Muea', '68000', 1, 1, '10/01/2018', 'FIFO', 16, 1, 2018, '2018-01-16 11:14:25', '2018-03-02 04:17:33', 'NONE'),
(5, 'REF00005', '14/02/2018', '8799665', 'ITM00005', 'Tin tomatoes', 115, 'Cans', 'Kitchen Food', 300, 350, '25', 'JOhn', 'Buea', '6589', 0, 1, '25/03/2021', 'FIFO', 14, 2, 2018, '2018-02-14 13:02:32', '2018-02-26 13:48:05', 'NONE'),
(6, 'REF00006', '22/02/2018', '8999665', 'ITM00006', 'Salt', 100, 'Bags', 'Kitchen Food', 200, 3000, '10', 'Ndive and Co', 'Muea', '659887455', 1, 1, '25/02/2027', 'WAP', 22, 2, 2018, '2018-02-22 07:31:09', '2018-02-22 07:31:09', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `product_keys`
--

CREATE TABLE `product_keys` (
  `id` int(100) NOT NULL,
  `hash` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_keys`
--

INSERT INTO `product_keys` (`id`, `hash`) VALUES
(1, '187c86ef5098f4cce97f76ddfef97855'),
(2, 'ddb37c5f88bde8d865763451547a3c76'),
(3, 'd1e04b5eb4ad58aba5690aebbf64d035'),
(4, 'c5698f1607ba23503ea86b371bafaf05');

-- --------------------------------------------------------

--
-- Table structure for table `return_clients`
--

CREATE TABLE `return_clients` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `client_name` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `item_number` int(100) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `return_clients`
--

INSERT INTO `return_clients` (`id`, `ref`, `client_name`, `date`, `item_number`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, 'ref', 'cedri', '14/01/2018', 2, 14, 1, 2018, '0000-00-00 00:00:00', '0'),
(2, 'ref', 'cedri', '14/01/2018', 2, 14, 1, 2018, '0000-00-00 00:00:00', '0'),
(3, 'ref', 'cedri', '14/01/2018', 2, 14, 1, 2018, '0000-00-00 00:00:00', '0'),
(4, 'ref', 'cedri', '14/01/2018', 2, 14, 1, 2018, '0000-00-00 00:00:00', '0'),
(5, 'RET00005', 'ddd', '21/01/2018', 2, 21, 1, 2018, '2018-01-21 15:46:51', 'NONE'),
(6, 'RETC00006', 'Cedric', '10/02/2018', 2, 10, 2, 2018, '2018-02-10 06:17:58', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `return_inventory`
--

CREATE TABLE `return_inventory` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `product_code` varchar(400) NOT NULL,
  `product_name` varchar(400) NOT NULL,
  `quantity` int(200) NOT NULL,
  `unit_price` int(200) NOT NULL,
  `total` int(200) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `return_inventory`
--

INSERT INTO `return_inventory` (`id`, `ref`, `date`, `product_code`, `product_name`, `quantity`, `unit_price`, `total`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, 'RET00001', '22/01/2018', 'COO454', 'Coori coori', 5, 4000, 20000, 22, 1, 2018, '2018-01-22 05:12:52', 'NONE'),
(2, 'RET00001', '22/01/2018', 'RI45', 'Rice', 6, 8000, 48000, 22, 1, 2018, '2018-01-22 05:12:52', 'NONE'),
(3, 'RET00001', '22/01/2018', 'COO454', 'Coori coori', 5, 4000, 20000, 22, 1, 2018, '2018-01-22 05:13:28', 'NONE'),
(4, 'RET00001', '22/01/2018', 'RI45', 'Rice', 6, 8000, 48000, 22, 1, 2018, '2018-01-22 05:13:28', 'NONE'),
(5, 'RET00002', '23/01/2018', 'COO454', 'Coori coori', 4, 4000, 16000, 23, 1, 2018, '2018-01-23 03:23:53', 'NONE'),
(6, 'RET00002', '23/01/2018', '0er564-566', 'Milk', 3, 1000, 3000, 23, 1, 2018, '2018-01-23 03:23:54', 'NONE'),
(7, 'RET00003', '23/01/2018', '9900', '899', 50, 0, 0, 23, 1, 2018, '2018-01-23 03:29:16', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `return_products`
--

CREATE TABLE `return_products` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `product_code` varchar(400) NOT NULL,
  `product_name` varchar(400) NOT NULL,
  `quantity` varchar(400) NOT NULL,
  `purpose` varchar(400) NOT NULL,
  `status` varchar(400) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `return_products`
--

INSERT INTO `return_products` (`id`, `ref`, `date`, `product_code`, `product_name`, `quantity`, `purpose`, `status`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, 'ref', '', '0er564-566', 'Milk', '12', 'my name', '', 14, 1, 2018, '2018-01-14 11:22:42', 'NONE'),
(2, 'ref', '', 'COO454', 'Coori coori', '52', '', '', 14, 1, 2018, '2018-01-14 11:22:42', 'NONE'),
(3, 'ref', '', '0er564-566', 'Milk', '12', 'my name', '', 14, 1, 2018, '2018-01-14 11:22:45', 'NONE'),
(4, 'ref', '', 'COO454', 'Coori coori', '52', '', '', 14, 1, 2018, '2018-01-14 11:22:45', 'NONE'),
(5, 'ref', '', '0er564-566', 'Milk', '12', 'my name', '', 14, 1, 2018, '2018-01-14 11:31:29', 'NONE'),
(6, 'ref', '', 'COO454', 'Coori coori', '52', '', '', 14, 1, 2018, '2018-01-14 11:31:29', 'NONE'),
(7, 'ref', '', '0er564-566', 'Milk', '12', 'my name', '', 14, 1, 2018, '2018-01-14 11:32:12', 'NONE'),
(8, 'ref', '', 'COO454', 'Coori coori', '52', '', '', 14, 1, 2018, '2018-01-14 11:32:12', 'NONE'),
(9, 'ref', '', '0er564-566', 'Milk', '12', 'my name', '', 14, 1, 2018, '2018-01-14 11:32:17', 'NONE'),
(10, 'ref', '', 'COO454', 'Coori coori', '52', '', '', 14, 1, 2018, '2018-01-14 11:32:17', 'NONE'),
(11, 'ref', '', '0er564-566', 'Milk', '12', 'my name', '', 14, 1, 2018, '2018-01-14 11:32:53', 'NONE'),
(12, 'ref', '', 'COO454', 'Coori coori', '52', '', '', 14, 1, 2018, '2018-01-14 11:32:53', 'NONE'),
(13, 'ref', '', '0er564-566', 'Milk', '12', 'my name', '', 14, 1, 2018, '2018-01-14 11:33:13', 'NONE'),
(14, 'ref', '', 'COO454', 'Coori coori', '52', '', '', 14, 1, 2018, '2018-01-14 11:33:13', 'NONE'),
(15, 'RET00005', '', 'COO454', 'Coori coori', '5', 'Not working', 'defect', 21, 1, 2018, '2018-01-21 15:46:51', 'NONE'),
(16, 'RET00005', '', 'RI45', 'Rice', '6', 'workin', 'normal', 21, 1, 2018, '2018-01-21 15:46:51', 'NONE'),
(17, 'RETC00006', '', 'COO454', 'Coori coori', '4', 'Just to swap', 'Normal', 10, 2, 2018, '2018-02-10 06:17:58', 'NONE'),
(18, 'RETC00006', '', '9900', '899', '2', 'Vert bad', 'Defect', 10, 2, 2018, '2018-02-10 06:17:58', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `return_ref`
--

CREATE TABLE `return_ref` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `sales_agent` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `total_price` int(200) NOT NULL,
  `items_returned` int(200) NOT NULL,
  `final_total` int(200) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `return_ref`
--

INSERT INTO `return_ref` (`id`, `ref`, `sales_agent`, `date`, `total_price`, `items_returned`, `final_total`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, 'RET00001', 'Hitman Agent 47', '22/01/2018', 68000, 2, 0, 22, 1, 2018, '2018-01-22 05:16:27', 'NONE'),
(2, 'RET00002', 'Hitman Agent 47', '23/01/2018', 19000, 2, 0, 23, 1, 2018, '2018-01-23 03:23:54', 'NONE'),
(3, 'RET00003', 'Cedric Tifuh', '23/01/2018', 0, 1, 0, 23, 1, 2018, '2018-01-23 03:29:16', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `product_code` varchar(400) NOT NULL,
  `product_name` varchar(400) NOT NULL,
  `quantity` int(200) NOT NULL,
  `unit_price` int(200) NOT NULL,
  `total` int(200) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `ref`, `date`, `product_code`, `product_name`, `quantity`, `unit_price`, `total`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, '12345', '', '0er564-566', 'Milk', 5, 1000, 5000, 14, 1, 2018, '2018-01-14 07:03:48', 'NONE'),
(2, '12345', '', 'COO454', 'Coori coori', 5, 4000, 20000, 14, 1, 2018, '2018-01-14 07:03:48', 'NONE'),
(3, '76890', '16/01/2018', 'RI45', 'Rice', 3, 8000, 24000, 16, 1, 2018, '2018-01-16 11:18:27', 'NONE'),
(4, '76890', '16/01/2018', 'COO454', 'Coori coori', 5, 4000, 20000, 16, 1, 2018, '2018-01-16 11:18:27', 'NONE'),
(5, '1800003', '16/01/2018', 'RI45', 'Rice', 10, 8000, 80000, 16, 1, 2018, '2018-01-16 11:32:17', 'NONE'),
(6, '1800003', '16/01/2018', 'COO454', 'Coori coori', 3, 4000, 12000, 16, 1, 2018, '2018-01-16 11:32:18', 'NONE'),
(7, 'ref', '18/01/2018', 'RI45', 'Rice', 10, 8000, 80000, 18, 1, 2018, '2018-01-18 15:19:20', 'NONE'),
(8, '112', '21/01/2018', 'RI45', 'Rice', 5, 8000, 40000, 21, 1, 2018, '2018-01-21 03:33:46', 'NONE'),
(9, '00006', '21/01/2018', 'COO454', 'Coori coori', 10, 4000, 40000, 21, 1, 2018, '2018-01-21 03:47:57', 'NONE'),
(10, '00007', '22/01/2018', '0er564-566', 'Milk', 1, 1000, 1000, 22, 1, 2018, '2018-01-22 05:45:22', 'NONE'),
(11, '00008', '22/01/2018', 'COO454', 'Coori coori', 1, 4000, 4000, 22, 1, 2018, '2018-01-22 13:22:12', 'NONE'),
(12, '00009', '24/01/2018', 'COO454', 'Coori coori', 8, 4000, 32000, 24, 1, 2018, '2018-01-24 13:24:48', 'NONE'),
(13, '00010', '25/01/2018', 'RI45', 'Rice', 41, 8000, 328000, 25, 1, 2018, '2018-01-25 14:48:54', 'NONE'),
(14, '00011', '26/01/2018', '0er564-566', 'Milk', 10, 1000, 10000, 26, 1, 2018, '2018-01-26 05:11:32', 'NONE'),
(15, '00011', '26/01/2018', 'RI45', 'Rice', 5, 8000, 40000, 26, 1, 2018, '2018-01-26 05:11:32', 'NONE'),
(16, '00011', '26/01/2018', 'COO454', 'Coori coori', 10, 4000, 40000, 26, 1, 2018, '2018-01-26 05:11:32', 'NONE'),
(17, '00012', '26/01/2018', '0er564-566', 'Milk', 10, 1000, 10000, 26, 1, 2018, '2018-01-26 05:17:25', 'NONE'),
(18, '00013', '05/02/2018', 'COO454', 'Coori coori', 5, 4000, 20000, 5, 2, 2018, '2018-02-05 17:37:32', 'NONE'),
(19, '00014', '12/02/2018', 'RI45', 'Rice', 10, 8000, 80000, 12, 2, 2018, '2018-02-12 17:40:14', 'NONE'),
(20, '00015', '12/02/2018', '0er564-566', 'Milk', 20, 1000, 0, 12, 2, 2018, '2018-02-12 18:10:01', 'NONE'),
(21, '00016', '12/02/2018', '0er564-566', 'Milk', 12, 1000, 12000, 12, 2, 2018, '2018-02-12 18:11:12', 'NONE'),
(22, '00017', '20/02/2018', 'COO454', 'Coori coori', 5, 4000, 20000, 20, 2, 2018, '2018-02-20 09:39:46', 'NONE'),
(23, '00018', '22/02/2018', '9900', 'Cocoa', 5, 3000, 15000, 22, 2, 2018, '2018-02-22 22:02:21', 'NONE'),
(24, '00018', '22/02/2018', 'RI45', 'Rice', 1, 8000, 8000, 22, 2, 2018, '2018-02-22 22:02:22', 'NONE'),
(25, '00019', '26/02/2018', 'ITM00005', 'Tin tomatoes', 5, 350, 1750, 26, 2, 2018, '2018-02-26 13:48:05', 'NONE'),
(26, '00020', '27/02/2018', '0er564-566', 'Milk', 1, 1000, 1000, 27, 2, 2018, '2018-02-27 10:26:20', '1217-02185'),
(27, '00021', '02/03/2018', 'COO454', 'Coori coori', 5, 4000, 20000, 2, 3, 2018, '2018-03-02 04:15:42', '1217-02185'),
(28, '00021', '02/03/2018', '9900', 'Cocoa', 9, 3000, 27000, 2, 3, 2018, '2018-03-02 04:15:42', '1217-02185'),
(29, '00021', '02/03/2018', '0er564-566', 'Milk', 4, 1000, 4000, 2, 3, 2018, '2018-03-02 04:15:42', '1217-02185');

-- --------------------------------------------------------

--
-- Table structure for table `sales_ref`
--

CREATE TABLE `sales_ref` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `sales_agent` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `tax` varchar(400) NOT NULL,
  `discount` varchar(400) NOT NULL,
  `total_price` int(200) NOT NULL,
  `items_sold` int(200) NOT NULL,
  `final_total` int(200) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_ref`
--

INSERT INTO `sales_ref` (`id`, `ref`, `sales_agent`, `date`, `tax`, `discount`, `total_price`, `items_sold`, `final_total`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, '12345', 'Cedric Tifuh', '14/01/2018', '', '', 25000, 2, 0, 14, 1, 2018, '2018-01-14 07:03:48', 'NONE'),
(2, '76890', 'Cedric Tifuh', '16/01/2018', '', '', 44000, 2, 0, 16, 1, 2018, '2018-01-16 11:18:27', 'NONE'),
(3, '1800003', 'Jevis Himself', '16/01/2018', '', '', 92000, 2, 0, 16, 1, 2018, '2018-01-16 11:32:18', 'NONE'),
(4, 'ref', 'Jevis', '18/01/2018', '', '', 80000, 1, 0, 18, 1, 2018, '2018-01-18 15:19:20', 'NONE'),
(5, '112', 'joe', '21/01/2018', '', '', 40000, 1, 0, 21, 1, 2018, '2018-01-21 03:33:46', 'NONE'),
(6, '00006', 'ced', '21/01/2018', '', '', 40000, 1, 0, 21, 1, 2018, '2018-01-21 03:47:57', 'NONE'),
(7, '00007', 'Cedric Tifuh', '22/01/2018', '', '', 1000, 1, 0, 22, 1, 2018, '2018-01-22 05:45:22', 'NONE'),
(8, '00008', 'Jevis', '22/01/2018', '', '', 4000, 1, 0, 22, 1, 2018, '2018-01-22 13:22:13', 'NONE'),
(9, '00009', 'cedric', '24/01/2018', '', '', 32000, 1, 0, 24, 1, 2018, '2018-01-24 13:24:49', 'NONE'),
(10, '00010', 'v', '25/01/2018', '', '', 328000, 1, 0, 25, 1, 2018, '2018-01-25 14:48:54', 'NONE'),
(11, '00011', 'Cedric', '26/01/2018', '', '', 90000, 3, 0, 26, 1, 2018, '2018-01-26 05:11:32', 'NONE'),
(12, '00012', 'Cedric', '26/01/2018', '', '', 10000, 1, 0, 26, 1, 2018, '2018-01-26 05:17:26', 'NONE'),
(13, '00013', 'Joe', '05/02/2018', '', '', 20000, 1, 0, 5, 2, 2018, '2018-02-05 17:37:32', 'NONE'),
(14, '00014', 'cynthia', '12/02/2018', '', '', 80000, 1, 0, 12, 2, 2018, '2018-02-12 17:40:14', 'NONE'),
(15, '00015', 'mike', '12/02/2018', '', '', 0, 1, 0, 12, 2, 2018, '2018-02-12 18:10:01', 'NONE'),
(16, '00016', 'ced', '12/02/2018', '', '', 12000, 1, 0, 12, 2, 2018, '2018-02-12 18:11:12', 'NONE'),
(17, '00017', 'Cedric', '20/02/2018', '', '', 20000, 1, 0, 20, 2, 2018, '2018-02-20 09:39:46', 'NONE'),
(18, '00018', 'joe', '22/02/2018', '', '', 23000, 2, 0, 22, 2, 2018, '2018-02-22 22:02:22', 'NONE'),
(19, '00019', 'cedric', '26/02/2018', '', '', 1750, 1, 0, 26, 2, 2018, '2018-02-26 13:48:05', 'NONE'),
(20, '00020', 'ndive', '27/02/2018', '', '', 1000, 1, 0, 27, 2, 2018, '2018-02-27 10:26:21', '1217-02185'),
(21, '00021', 'joe', '02/03/2018', '', '', 51000, 3, 0, 2, 3, 2018, '2018-03-02 04:15:42', '1217-02185');

-- --------------------------------------------------------

--
-- Table structure for table `stock_count`
--

CREATE TABLE `stock_count` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `product_code` varchar(400) NOT NULL,
  `product_name` varchar(400) NOT NULL,
  `s_quantity` int(100) NOT NULL,
  `m_quantity` int(100) NOT NULL,
  `difference` int(100) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_count`
--

INSERT INTO `stock_count` (`id`, `ref`, `date`, `product_code`, `product_name`, `s_quantity`, `m_quantity`, `difference`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, 'STKCT00001', '20/01/2018', 'RI45', 'Rice', 10, 14, 4, 20, 1, 2018, '2018-01-20 15:05:46', 'NONE'),
(2, 'STKCT00001', '20/01/2018', 'COO454', 'Coori coori', 60, 43, 17, 20, 1, 2018, '2018-01-20 15:05:46', 'NONE'),
(3, 'STKCT00001', '20/01/2018', 'COO454', 'Coori coori', 60, 43, 17, 20, 1, 2018, '2018-01-20 15:06:08', 'NONE'),
(4, 'STKCT00001', '20/01/2018', 'RI45', 'Rice', 10, 14, 4, 20, 1, 2018, '2018-01-20 15:06:54', 'NONE'),
(5, 'STKCT00001', '20/01/2018', 'COO454', 'Coori coori', 60, 43, 17, 20, 1, 2018, '2018-01-20 15:06:54', 'NONE'),
(6, 'STKCT00001', '20/01/2018', 'RI45', 'Rice', 10, 14, 4, 20, 1, 2018, '2018-01-20 15:07:41', 'NONE'),
(7, 'STKCT00001', '20/01/2018', 'COO454', 'Coori coori', 60, 43, 17, 20, 1, 2018, '2018-01-20 15:07:41', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `stock_count_ref`
--

CREATE TABLE `stock_count_ref` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `agent_name` varchar(400) NOT NULL,
  `item_number` int(100) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_count_ref`
--

INSERT INTO `stock_count_ref` (`id`, `ref`, `date`, `agent_name`, `item_number`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, 'STKCT00001', '20/01/2018', 'c', 2, 20, 1, 2018, '2018-01-20 15:07:41', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `trail`
--

CREATE TABLE `trail` (
  `id` int(11) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `start_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` varchar(100) NOT NULL,
  `end_date_time` varchar(100) NOT NULL,
  `in_trial` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trial`
--

CREATE TABLE `trial` (
  `id` int(11) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `start_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` varchar(100) NOT NULL,
  `end_date_time` varchar(100) NOT NULL,
  `sys_end_date` varchar(100) NOT NULL,
  `in_trial` tinyint(1) NOT NULL,
  `product_activated` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trial`
--

INSERT INTO `trial` (`id`, `start_date`, `start_date_time`, `end_date`, `end_date_time`, `sys_end_date`, `in_trial`, `product_activated`, `expired`) VALUES
(2, '02/03/2018', '2018-03-02 04:07:47', '01/04/2018', '04/01/2018 06:07:47', '', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(100) NOT NULL,
  `unit` varchar(400) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit`, `status`) VALUES
(1, 'Cartons', 1),
(2, 'Bags', 1),
(4, 'Cans', 1),
(5, 'Buckets', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(200) NOT NULL,
  `user_id` varchar(400) NOT NULL,
  `username` varchar(400) NOT NULL,
  `password` varchar(400) NOT NULL,
  `name` varchar(400) NOT NULL,
  `position` varchar(400) NOT NULL,
  `contact` varchar(400) NOT NULL,
  `photo` varchar(400) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id_d` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `username`, `password`, `name`, `position`, `contact`, `photo`, `time_added`, `user_id_d`) VALUES
(1, '1214-01183', 'tnced', 'ced', 'Cedric Tifuh', 'Manager', '67956412', 'images/files/user_photos/20180115020153_12404235323.jpg', '2018-01-15 13:06:53', 'NONE'),
(4, '1217-02185', 'admin', '8cd6c7848c5e7e4e9c0aa36cdaf8d591718342e8', 'Admin', 'Administrator', '673159865', 'images/files/user_photos/20180207030256_IMG-20160423-WA0003.jpg', '2018-02-07 02:01:56', 'NONE'),
(5, '1218-02184', 'jevis', 'c815b82d42702e6f638fda9ea19a5027ad564de9', 'Jevis Worker', 'Sales', '665899', 'images/files/user_photos/20180212060213_wallpaper-sky-blue-background-20.jpg', '2018-02-12 17:45:13', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `user_prefs`
--

CREATE TABLE `user_prefs` (
  `id` int(200) NOT NULL,
  `user_id` varchar(400) NOT NULL,
  `sales` tinyint(1) NOT NULL,
  `inventory` tinyint(1) NOT NULL,
  `cash_management` tinyint(1) NOT NULL,
  `customer` tinyint(1) NOT NULL,
  `purchases` tinyint(1) NOT NULL,
  `setting` tinyint(1) NOT NULL,
  `reports` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_prefs`
--

INSERT INTO `user_prefs` (`id`, `user_id`, `sales`, `inventory`, `cash_management`, `customer`, `purchases`, `setting`, `reports`) VALUES
(1, '1216-01184', 1, 1, 1, 1, 1, 1, 1),
(2, '1217-02185', 1, 1, 1, 1, 1, 1, 1),
(3, '1218-02184', 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal`
--

CREATE TABLE `withdrawal` (
  `id` int(200) NOT NULL,
  `ref` varchar(400) NOT NULL,
  `date` varchar(400) NOT NULL,
  `withdrawal` varchar(400) NOT NULL,
  `purpose` varchar(400) NOT NULL,
  `quantity` int(100) NOT NULL,
  `source` varchar(400) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdrawal`
--

INSERT INTO `withdrawal` (`id`, `ref`, `date`, `withdrawal`, `purpose`, `quantity`, `source`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, '12344', '15/01/2018', 'John', 'For transport', 25, 'from accounts', 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(2, '12344', '15/01/2018', 'John', 'tifuh', 33, 'cedric', 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(3, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(4, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(5, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(6, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(7, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(8, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(9, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(10, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(11, '12344', '15/01/2018', 'John', 'For transport', 25, 'from accounts', 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(12, '12344', '15/01/2018', 'John', 'tifuh', 33, 'cedric', 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(13, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(14, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(15, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(16, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(17, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(18, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(19, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(20, '12344', '15/01/2018', 'John', '', 0, '', 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(21, '9866', '15/01/2018', '65899', 'dkfj', 0, '`dkffjk', 15, 1, 2018, '2018-01-15 03:42:31', 'NONE'),
(22, '9866', '15/01/2018', '65899', 'dkfjk', 0, 'dkjfjk', 15, 1, 2018, '2018-01-15 03:42:31', 'NONE'),
(23, '9866', '15/01/2018', '65899', 'dkjffjdjk', 0, 'dkfjj', 15, 1, 2018, '2018-01-15 03:42:31', 'NONE'),
(24, '9866', '15/01/2018', '65899', 'dkjfkjdj', 0, 'djkfjkdkj', 15, 1, 2018, '2018-01-15 03:42:31', 'NONE'),
(25, '9866', '15/01/2018', '65899', 'dkjfdkjf', 0, 'dkjfkjd', 15, 1, 2018, '2018-01-15 03:42:31', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_ref`
--

CREATE TABLE `withdrawal_ref` (
  `id` int(200) NOT NULL,
  `ref` varchar(200) NOT NULL,
  `date` varchar(400) NOT NULL,
  `withdrawal` varchar(200) NOT NULL,
  `item_total` int(20) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdrawal_ref`
--

INSERT INTO `withdrawal_ref` (`id`, `ref`, `date`, `withdrawal`, `item_total`, `day`, `month`, `year`, `time_added`, `user_id`) VALUES
(1, '12344', '15/01/2018', 'John', 10, 15, 1, 2018, '2018-01-15 03:33:21', 'NONE'),
(2, '12344', '15/01/2018', 'John', 10, 15, 1, 2018, '2018-01-15 03:33:49', 'NONE'),
(3, '9866', '15/01/2018', '65899', 5, 15, 1, 2018, '2018-01-15 03:42:31', 'NONE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activation`
--
ALTER TABLE `activation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `first_run`
--
ALTER TABLE `first_run`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_inventory`
--
ALTER TABLE `issue_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_ref`
--
ALTER TABLE `issue_ref`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_keys`
--
ALTER TABLE `product_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_clients`
--
ALTER TABLE `return_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_inventory`
--
ALTER TABLE `return_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_products`
--
ALTER TABLE `return_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_ref`
--
ALTER TABLE `return_ref`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_ref`
--
ALTER TABLE `sales_ref`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_count`
--
ALTER TABLE `stock_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_count_ref`
--
ALTER TABLE `stock_count_ref`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trial`
--
ALTER TABLE `trial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_prefs`
--
ALTER TABLE `user_prefs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal`
--
ALTER TABLE `withdrawal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal_ref`
--
ALTER TABLE `withdrawal_ref`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activation`
--
ALTER TABLE `activation`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `first_run`
--
ALTER TABLE `first_run`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `issue_inventory`
--
ALTER TABLE `issue_inventory`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `issue_ref`
--
ALTER TABLE `issue_ref`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `product_keys`
--
ALTER TABLE `product_keys`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `return_clients`
--
ALTER TABLE `return_clients`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `return_inventory`
--
ALTER TABLE `return_inventory`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `return_products`
--
ALTER TABLE `return_products`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `return_ref`
--
ALTER TABLE `return_ref`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `sales_ref`
--
ALTER TABLE `sales_ref`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `stock_count`
--
ALTER TABLE `stock_count`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `stock_count_ref`
--
ALTER TABLE `stock_count_ref`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `trial`
--
ALTER TABLE `trial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_prefs`
--
ALTER TABLE `user_prefs`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `withdrawal`
--
ALTER TABLE `withdrawal`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `withdrawal_ref`
--
ALTER TABLE `withdrawal_ref`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
