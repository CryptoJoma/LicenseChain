-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `ID` int(10) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `title_web` varchar(50) NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `analytics` text DEFAULT NULL,
  `email_web` varchar(255) NOT NULL,
  `email_admin` varchar(255) NOT NULL,
  `timezone` char(35) NOT NULL DEFAULT 'America/Los_Angeles',
  `status` enum('0','1') NOT NULL,
  `mod_rewrite` enum('0','1') NOT NULL,
  `smtp_server` varchar(255) NOT NULL,
  `smtp_port` int(4) NOT NULL,
  `smtp_user` varchar(50) NOT NULL,
  `smtp_password` varchar(50) NOT NULL,
  `session_time` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `license_type` enum('1','69') NOT NULL DEFAULT '1',
  `license_key` varchar(255) NOT NULL,
  `expiration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `used_ips` mediumtext DEFAULT NULL,
  `ips_limit` int(11) NOT NULL DEFAULT 4,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `used_macs` mediumtext DEFAULT '',
  `macs_limit` int(11) NOT NULL DEFAULT 4
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `license_usage`
--

CREATE TABLE `license_usage` (
  `id` int(11) NOT NULL,
  `license_key` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `mac_address` varchar(255) NOT NULL,
  `license_type` int(11) NOT NULL DEFAULT 1,
  `processor` varchar(255) NOT NULL,
  `ram_amount` int(11) NOT NULL,
  `disk_amount` int(11) NOT NULL,
  `hdd_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `minutes`
--

CREATE TABLE `minutes` (
  `Id` int(11) NOT NULL,
  `Amount` int(11) NOT NULL,
  `Minutes_Billed` datetime NOT NULL DEFAULT current_timestamp(),
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `minutes_used_time`
--

CREATE TABLE `minutes_used_time` (
  `mid` int(11) NOT NULL,
  `used_time` int(11) DEFAULT 0,
  `used_license` varchar(255) NOT NULL,
  `used_trunk` varchar(255) NOT NULL,
  `used_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_pages`
--

CREATE TABLE `page_pages` (
  `IdPage` int(11) NOT NULL,
  `page_title` varchar(200) NOT NULL,
  `page_id` varchar(255) NOT NULL,
  `page_url` varchar(400) NOT NULL,
  `page_content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime NOT NULL DEFAULT current_timestamp(),
  `template` varchar(100) NOT NULL DEFAULT 'default'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` enum('USD','EUR','GBP') NOT NULL DEFAULT 'USD',
  `pay_address` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `status` enum('created','pending','completed','failed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `example_links` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `videos` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Id` int(11) NOT NULL,
  `Title` varchar(125) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sip_trunk`
--

CREATE TABLE `sip_trunk` (
  `id` int(11) NOT NULL,
  `trunk_name` varchar(256) NOT NULL,
  `trunk_username` varchar(256) NOT NULL,
  `trunk_password` varchar(256) NOT NULL,
  `trunk_server` varchar(256) NOT NULL,
  `trunk_price` float DEFAULT NULL,
  `trunk_role` enum('0','1') NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `trunk_status` enum('0','1') NOT NULL DEFAULT '0',
  `used` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_login`
--

CREATE TABLE `users_login` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `user` varchar(25) NOT NULL,
  `tg_id` varchar(255) NOT NULL,
  `role` enum('69','2','3','4','5') NOT NULL DEFAULT '4',
  `wallet` mediumtext DEFAULT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `registration_date` date NOT NULL DEFAULT current_timestamp(),
  `last_login` varchar(55) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `contact` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verification_codes`
--

CREATE TABLE `verification_codes` (
  `cid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `oid` int(11) NOT NULL DEFAULT 1,
  `code` varchar(50) NOT NULL,
  `creation_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `license_usage`
--
ALTER TABLE `license_usage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minutes`
--
ALTER TABLE `minutes`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `minutes_used_time`
--
ALTER TABLE `minutes_used_time`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `page_pages`
--
ALTER TABLE `page_pages`
  ADD PRIMARY KEY (`IdPage`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `sip_trunk`
--
ALTER TABLE `sip_trunk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_login`
--
ALTER TABLE `users_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verification_codes`
--
ALTER TABLE `verification_codes`
  ADD PRIMARY KEY (`cid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `license_usage`
--
ALTER TABLE `license_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `minutes`
--
ALTER TABLE `minutes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `minutes_used_time`
--
ALTER TABLE `minutes_used_time`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_pages`
--
ALTER TABLE `page_pages`
  MODIFY `IdPage` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sip_trunk`
--
ALTER TABLE `sip_trunk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_login`
--
ALTER TABLE `users_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
