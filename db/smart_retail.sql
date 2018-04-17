-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 10, 2018 at 12:40 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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



CREATE TABLE `categories` (
  `id` int(100) NOT NULL,
  `category` varchar(400) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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

-- --------------------------------------------------------



CREATE TABLE `first_run` (
  `id` int(10) NOT NULL,
  `first_run` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `first_run` (`id`, `first_run`) VALUES
(1, 0);



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



CREATE TABLE `movement` (
  `id` int(100) NOT NULL,
  `month` varchar(10) NOT NULL,
  `year` year(4) NOT NULL,
  `date` varchar(50) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `initial` int(11) NOT NULL,
  `final` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `comment` varchar(400) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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



CREATE TABLE `product_keys` (
  `id` int(100) NOT NULL,
  `hash` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `product_keys` (`id`, `hash`) VALUES
(1, '187c86ef5098f4cce97f76ddfef97855'),
(2, 'ddb37c5f88bde8d865763451547a3c76'),
(3, 'd1e04b5eb4ad58aba5690aebbf64d035'),
(4, 'c5698f1607ba23503ea86b371bafaf05'),
(5, '58659897d3748212163a9b50559cc54c'),
(6, '5e14cb47cd40a1490d5f4df53e3c1fed'),
(7, 'f9b9b82ff98e5887d3ba3791baa79e12'),
(8, '5c753b16ea39c92993fcc9a45151d83a'),
(9, 'c0f49572d741b0274471482241005952'),
(10, 'bbd20725d44f2646fcae27c2eb7101b9'),
(11, '236b7246dd01bec9ddb2bf4babfb2bda'),
(12, 'ad6eae94867026a33546139a5f559f92'),
(13, '6b4bd99e14f52959ecdfbf2c5f1959d0'),
(14, 'dd7bc224818df3beeec674f5ba610e7d');



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

-- --------------------------------------------------------

--
-- Table structure for table `stock_update`
--

CREATE TABLE `stock_update` (
  `id` int(110) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `date` varchar(100) NOT NULL,
  `product_code` varchar(300) NOT NULL,
  `product_name` varchar(300) NOT NULL,
  `old_quantity` int(10) NOT NULL,
  `added_quantity` int(10) NOT NULL,
  `new_quantity` int(10) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` year(4) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_update_ref`
--

CREATE TABLE `stock_update_ref` (
  `id` int(100) NOT NULL,
  `ref` varchar(300) NOT NULL,
  `date` varchar(20) NOT NULL,
  `items_number` int(20) NOT NULL,
  `agent_name` varchar(100) NOT NULL,
  `day` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(2) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(100) NOT NULL,
  `unit` varchar(400) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, '1217-02185', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin', 'Administrator', '673159865', 'images/files/user_photos/20180207030256_IMG-20160423-WA0003.jpg', '2018-02-07 01:01:56', 'NONE');

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


ALTER TABLE `activation`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);


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
-- Indexes for table `movement`
--
ALTER TABLE `movement`
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
-- Indexes for table `stock_update`
--
ALTER TABLE `stock_update`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_update_ref`
--
ALTER TABLE `stock_update_ref`
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
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `first_run`
--
ALTER TABLE `first_run`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `issue_inventory`
--
ALTER TABLE `issue_inventory`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `issue_ref`
--
ALTER TABLE `issue_ref`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movement`
--
ALTER TABLE `movement`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_keys`
--
ALTER TABLE `product_keys`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `return_clients`
--
ALTER TABLE `return_clients`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `return_inventory`
--
ALTER TABLE `return_inventory`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `return_products`
--
ALTER TABLE `return_products`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `return_ref`
--
ALTER TABLE `return_ref`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_ref`
--
ALTER TABLE `sales_ref`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_count`
--
ALTER TABLE `stock_count`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_count_ref`
--
ALTER TABLE `stock_count_ref`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_update`
--
ALTER TABLE `stock_update`
  MODIFY `id` int(110) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_update_ref`
--
ALTER TABLE `stock_update_ref`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trial`
--
ALTER TABLE `trial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_prefs`
--
ALTER TABLE `user_prefs`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `withdrawal`
--
ALTER TABLE `withdrawal`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `withdrawal_ref`
--
ALTER TABLE `withdrawal_ref`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT;
