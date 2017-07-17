


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



--
-- Table structure for table `api_keys`
--

DROP TABLE IF EXISTS `<DB_PREFIX>api_keys`;
CREATE TABLE `<DB_PREFIX>api_keys` (
  `id` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL,
  `is_private_key` tinyint(4) NOT NULL,
  `ip_addresses` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `<DB_PREFIX>api_keys` (`id`, `api_key`, `level`, `ignore_limits`, `date_created`, `is_private_key`, `ip_addresses`) VALUES
(1, 'dc471dc465b2d7d5c673bdb083166bfc', 10, 1, 1473694000, 1, '::1'),
(3, '48sgoc0kog80wwco8wcsoc404scssks0oc44o0gk', 10, 1, 1476430780, 0, NULL);

-- --------------------------------------------------------



DROP TABLE IF EXISTS `<DB_PREFIX>emaillogs`;
CREATE TABLE `<DB_PREFIX>emaillogs` (
  `id` int(11) NOT NULL,
  `emailaddress` varchar(200) NOT NULL,
  `emailtext` text NOT NULL,
  `emailtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `slug` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



--
-- Table structure for table `grid`
--

DROP TABLE IF EXISTS `<DB_PREFIX>grid`;
CREATE TABLE `<DB_PREFIX>grid` (
  `id` int(11) NOT NULL,
  `slug` varchar(10) NOT NULL,
  `sizegrid` double NOT NULL,
  `gridname` varchar(200) NOT NULL,
  `selectadmin` varchar(200) NOT NULL,
  `commissioningdate` date DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `manufacturer` varchar(200) DEFAULT NULL,
  `modeltype` varchar(200) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `day_db` varchar(200) DEFAULT NULL,
  `intervalsdata` int(11) DEFAULT NULL,
  `api_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `<DB_PREFIX>grid_api`;
CREATE TABLE `<DB_PREFIX>grid_api` (
  `id` int(11) NOT NULL,
  `apikey_id` int(11) NOT NULL,
  `grid_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grid_user`
--

DROP TABLE IF EXISTS `<DB_PREFIX>grid_user`;
CREATE TABLE `<DB_PREFIX>grid_user` (
  `id` int(11) NOT NULL,
  `ref_num` varchar(180) DEFAULT NULL,
  `power` float NOT NULL,
  `date_connected` date NOT NULL,
  `consumption` float NOT NULL,
  `slug` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `<DB_PREFIX>groups`;
CREATE TABLE `<DB_PREFIX>groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `<DB_PREFIX>groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------
--
-- Indexes for table `api_keys`
--
ALTER TABLE `<DB_PREFIX>api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emaillogs`
--
ALTER TABLE `<DB_PREFIX>emaillogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `grid`
--
ALTER TABLE `<DB_PREFIX>grid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grid_api`
--
ALTER TABLE `<DB_PREFIX>grid_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grid_user`
--
ALTER TABLE `<DB_PREFIX>grid_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `<DB_PREFIX>groups`
  ADD PRIMARY KEY (`id`);
  


--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `<DB_PREFIX>api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `emaillogs`
--
ALTER TABLE `<DB_PREFIX>emaillogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `grid`
--
ALTER TABLE `<DB_PREFIX>grid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `grid_api`
--
ALTER TABLE `<DB_PREFIX>grid_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grid_user`
--
ALTER TABLE `<DB_PREFIX>grid_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `<DB_PREFIX>groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `input`
--


--
-- Table structure for table `input`
--

DROP TABLE IF EXISTS `<DB_PREFIX>input`;
CREATE TABLE `<DB_PREFIX>input` (
  `id` int(11) NOT NULL,
  `slug` varchar(20) NOT NULL,
  `input_node` int(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `key_num` int(20) NOT NULL,
  `datatype` int(2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL  ON UPDATE CURRENT_TIMESTAMP,
  `inputvalue` double NOT NULL,
  `process_list` varchar(255) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `feed_input` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `interruptions`
--

DROP TABLE IF EXISTS `<DB_PREFIX>interruptions`;
CREATE TABLE `<DB_PREFIX>interruptions` (
  `id` int(9) NOT NULL,
  `slug` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `limits`
--

DROP TABLE IF EXISTS `<DB_PREFIX>limits`;
CREATE TABLE `<DB_PREFIX>limits` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `<DB_PREFIX>login_attempts`;
CREATE TABLE `<DB_PREFIX>login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `<DB_PREFIX>logs`;
CREATE TABLE `<DB_PREFIX>logs` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `<DB_PREFIX>message`;
CREATE TABLE `<DB_PREFIX>message` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_group` varchar(200) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

DROP TABLE IF EXISTS `<DB_PREFIX>reply`;
CREATE TABLE `<DB_PREFIX>reply` (
  `id` int(11) NOT NULL,
  `reply` text NOT NULL,
  `message_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `smslogs`
--

DROP TABLE IF EXISTS `<DB_PREFIX>smslogs`;
CREATE TABLE `<DB_PREFIX>smslogs` (
  `id` int(11) NOT NULL,
  `slug` varchar(10) NOT NULL,
  `smsnumber` int(20) NOT NULL,
  `smstext` text NOT NULL,
  `smstime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `<DB_PREFIX>users`;
CREATE TABLE `<DB_PREFIX>users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `<DB_PREFIX>users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1499943347, 1, 'ADMIN', 'MINIGRIDEMS', 'ADMIN', '2547012345678');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `<DB_PREFIX>users_groups`;
CREATE TABLE `<DB_PREFIX>users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `<DB_PREFIX>users_groups` (`id`, `user_id`, `group_id`) VALUES
(31, 1, 1),
(32, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `<DB_PREFIX>user_profile`;
CREATE TABLE `<DB_PREFIX>user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `url` varchar(210) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `<DB_PREFIX>user_profile` (`id`, `user_id`, `url`) VALUES
(1, 1, 'Lighthouse.jpg');

--
-- Indexes for dumped tables
--


--
-- Indexes for table `input`
--
ALTER TABLE `<DB_PREFIX>input`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `limits`
--
ALTER TABLE `<DB_PREFIX>limits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `<DB_PREFIX>login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `<DB_PREFIX>logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `<DB_PREFIX>message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `<DB_PREFIX>reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smslogs`
--
ALTER TABLE `<DB_PREFIX>smslogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `<DB_PREFIX>users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `<DB_PREFIX>users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `<DB_PREFIX>user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
ALTER TABLE `<DB_PREFIX>input`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `limits`
--
ALTER TABLE `<DB_PREFIX>limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `<DB_PREFIX>login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `<DB_PREFIX>logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `<DB_PREFIX>message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `<DB_PREFIX>reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `smslogs`
--
ALTER TABLE `<DB_PREFIX>smslogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `<DB_PREFIX>users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `<DB_PREFIX>users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `<DB_PREFIX>user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `<DB_PREFIX>users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `<DB_PREFIX>groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `<DB_PREFIX>users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
