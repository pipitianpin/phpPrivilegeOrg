-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-05-22 01:13:41
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phpprivilegeorg`
--

-- --------------------------------------------------------

--
-- 表的结构 `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('85f74d7a99829765b91f228e7e4c44d0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:36.0) Gecko/20100101 Firefox/36.0', 1432088720, 'a:8:{s:9:"user_data";s:0:"";s:7:"user_id";s:2:"56";s:8:"username";s:3:"lee";s:5:"email";s:16:"lee@e-cast.co.nz";s:8:"is_admin";b:1;s:4:"role";s:10:"superadmin";s:7:"role_id";s:1:"5";s:6:"status";s:1:"1";}'),
('88d86ea41f4658b32fdba89b6f8457ce', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:36.0) Gecko/20100101 Firefox/36.0', 1432159647, 'a:9:{s:9:"user_data";s:0:"";s:7:"user_id";s:2:"56";s:8:"username";s:3:"lee";s:5:"email";s:16:"lee@e-cast.co.nz";s:8:"is_admin";b:1;s:4:"role";s:10:"superadmin";s:7:"role_id";s:1:"5";s:6:"status";s:1:"1";s:10:"library_id";s:3:"166";}'),
('c7f6fdaf12e67073adb44c880cd22716', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 1432158754, 'a:8:{s:9:"user_data";s:0:"";s:7:"user_id";s:2:"58";s:8:"username";s:6:"preeti";s:5:"email";s:19:"preeti@e-cast.co.nz";s:8:"is_admin";b:1;s:4:"role";s:10:"superadmin";s:7:"role_id";s:1:"5";s:6:"status";s:1:"1";}'),
('de4ff42e0a4d38c12843dabb6e5d764e', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:38.0) Gecko/20100101 Firefox/38.0', 1432158057, 'a:8:{s:9:"user_data";s:0:"";s:7:"user_id";s:2:"79";s:8:"username";s:5:"test2";s:5:"email";s:18:"test2@e-cast.co.nz";s:8:"is_admin";b:0;s:4:"role";s:8:"employee";s:7:"role_id";s:1:"3";s:6:"status";s:1:"1";}'),
('e174446ae81c662e7052272861b80444', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.78.2 (KHTML, like Gecko) Version/7.0.6 Safari/537.78.2', 1432097117, ''),
('ee782c6b827d1fdc549f4804f7923e5e', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:38.0) Gecko/20100101 Firefox/38.0', 1432091903, 'a:9:{s:9:"user_data";s:0:"";s:7:"user_id";s:2:"79";s:8:"username";s:5:"test2";s:5:"email";s:18:"test2@e-cast.co.nz";s:8:"is_admin";b:0;s:4:"role";s:8:"employee";s:7:"role_id";s:1:"3";s:6:"status";s:1:"1";s:10:"library_id";s:3:"166";}');

-- --------------------------------------------------------

--
-- 表的结构 `company_info`
--

CREATE TABLE IF NOT EXISTS `company_info` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `company_desc` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `company_file_address` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_file_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `company_info`
--

INSERT INTO `company_info` (`company_id`, `company_name`, `company_desc`, `company_phone`, `company_file_address`, `company_email`, `company_file_name`) VALUES
(1, 'php', 'Sample Company', '000-000-000', 'assets/img/logo/logo.png', 'gangliuleon@gmail.com', 'logo.png');

-- --------------------------------------------------------

--
-- 表的结构 `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `login` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `org`
--

CREATE TABLE IF NOT EXISTS `org` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `org_name` varchar(128) DEFAULT NULL,
  `parent_id` int(6) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `parent_id_2` (`parent_id`),
  KEY `parent_id_3` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=161 ;

--
-- 转存表中的数据 `org`
--

INSERT INTO `org` (`id`, `org_name`, `parent_id`, `isActive`) VALUES
(141, 'LGNZ', NULL, 1),
(142, 'RTU Group', 141, 1),
(146, 'lawyer2', 141, 1),
(147, 'Test Org', NULL, 1),
(148, 'Test1', 147, 1),
(149, 'Test2', 147, 1),
(150, 'Test3', 147, 1),
(151, 'Test1-1', 148, 1),
(152, 'Test1-2', 148, 1),
(153, 'Test1-3', 148, 1),
(154, 'Test2-1', 149, 1),
(155, 'Test2-2', 149, 1),
(156, 'Test2-3', 149, 1),
(157, 'Test3-1', 150, 1),
(158, 'Test3-2', 150, 1),
(160, 'dd', 141, 1);

-- --------------------------------------------------------

--
-- 表的结构 `org_admin`
--

CREATE TABLE IF NOT EXISTS `org_admin` (
  `id` smallint(8) NOT NULL AUTO_INCREMENT,
  `org_id` smallint(5) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `org_id` (`org_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `org_admin`
--

INSERT INTO `org_admin` (`id`, `org_id`, `user_id`) VALUES
(3, 141, 59);

-- --------------------------------------------------------

--
-- 表的结构 `org_privilege`
--

CREATE TABLE IF NOT EXISTS `org_privilege` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `org_id` smallint(4) DEFAULT NULL,
  `privilege_id` smallint(4) DEFAULT NULL,
  `privilege_value` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `un_orgid_privilegeid` (`org_id`,`privilege_id`) USING HASH,
  KEY `org_id` (`org_id`),
  KEY `privilege_id` (`privilege_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=177 ;

--
-- 转存表中的数据 `org_privilege`
--

INSERT INTO `org_privilege` (`id`, `org_id`, `privilege_id`, `privilege_value`) VALUES
(120, 141, 2000, 1),
(121, 141, 2001, 1),
(122, 141, 2002, 1),
(123, 141, 2003, 1),
(124, 141, 2004, 1),
(125, 141, 2005, 1),
(126, 141, 2006, 1),
(127, 141, 2009, 1),
(128, 141, 2010, 1),
(129, 141, 2015, 1),
(152, 141, 4000, 1),
(153, 147, 2000, 0),
(154, 147, 2001, 0),
(155, 147, 2002, 0),
(156, 147, 2003, 0),
(157, 147, 2004, 1),
(158, 147, 2005, 0),
(159, 147, 2006, 0),
(160, 147, 2009, 0),
(161, 147, 2010, 0),
(162, 147, 2015, 0),
(163, 147, 4000, 1),
(174, 141, 2016, 1),
(176, 141, 4001, 0);

-- --------------------------------------------------------

--
-- 表的结构 `org_role`
--

CREATE TABLE IF NOT EXISTS `org_role` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `org_id` smallint(4) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `un_orgid_rolename` (`org_id`,`role_name`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- 转存表中的数据 `org_role`
--

INSERT INTO `org_role` (`id`, `org_id`, `role_name`) VALUES
(46, 141, 'dd'),
(45, 141, 'temp role'),
(44, 141, 'Trainee');

-- --------------------------------------------------------

--
-- 表的结构 `org_user`
--

CREATE TABLE IF NOT EXISTS `org_user` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `org_id` smallint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `un_orguser_orgid_userid` (`org_id`,`user_id`) USING HASH,
  KEY `fk_orguser_org_userid` (`user_id`),
  KEY `in_orguser_orgid` (`org_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=598 ;

--
-- 转存表中的数据 `org_user`
--

INSERT INTO `org_user` (`id`, `org_id`, `user_id`) VALUES
(594, 141, 59),
(584, 141, 60),
(593, 141, 79),
(565, 141, 128),
(567, 141, 129),
(569, 141, 130),
(566, 142, 128),
(570, 146, 130),
(592, 147, 59);

-- --------------------------------------------------------

--
-- 表的结构 `privilege`
--

CREATE TABLE IF NOT EXISTS `privilege` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `privilege_name` varchar(40) NOT NULL,
  `privilege_desc` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `privilegedesc` (`privilege_name`) USING HASH
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='2000 : Keyword\n2001 : Related Material\n2002 : Comment\n2003 : Download\n2004 : Get Embedded Code\n2005 : Favourite\n2006 : Quiz\n2009 : View Video\n2010 : Request Recording\n2015 : Library Setting\n2016 : Project\n2017 : Public Library' AUTO_INCREMENT=4002 ;

--
-- 转存表中的数据 `privilege`
--

INSERT INTO `privilege` (`id`, `privilege_name`, `privilege_desc`) VALUES
(2000, 'Keyword', NULL),
(2001, 'Related Material', NULL),
(2002, 'Comment', NULL),
(2003, 'Download', NULL),
(2004, 'Get Embedded Code', NULL),
(2005, 'Favourite', NULL),
(2006, 'QUIZ', NULL),
(2009, 'View Video', NULL),
(2010, 'Request Recording', NULL),
(2015, 'Library Setting', NULL),
(2016, 'Edit Project', NULL),
(4000, 'Edit Embed', NULL),
(4001, 'Create Course', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) DEFAULT NULL,
  `role_description` varchar(128) DEFAULT NULL,
  `active` tinyint(128) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `roles`
--

INSERT INTO `roles` (`id`, `role`, `role_description`, `active`) VALUES
(1, 'admin', 'admin user', 1),
(2, 'comms', 'Employee role', 1),
(4, 'guest', 'Time restricted guest user', 1),
(5, 'superadmin', 'E-Cast superadmin user ', 1),
(3, 'employee', 'Time limited guest login', 1);

-- --------------------------------------------------------

--
-- 表的结构 `role_privilege`
--

CREATE TABLE IF NOT EXISTS `role_privilege` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `role_id` int(7) DEFAULT NULL,
  `privilege_id` smallint(4) DEFAULT NULL,
  `privilege_value` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `un_roleprivilege_roleid_privilegeid` (`role_id`,`privilege_id`) USING HASH,
  KEY `role_id` (`role_id`),
  KEY `privilege_id` (`privilege_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=165 ;

--
-- 转存表中的数据 `role_privilege`
--

INSERT INTO `role_privilege` (`id`, `role_id`, `privilege_id`, `privilege_value`) VALUES
(68, 44, 2000, 1),
(69, 44, 2001, 1),
(70, 44, 2003, 1),
(71, 44, 2004, 1),
(72, 44, 2005, 0),
(73, 44, 2006, 0),
(74, 44, 2009, 1),
(75, 44, 2010, 0),
(76, 44, 2015, 1),
(86, 45, 2000, 0),
(87, 45, 2001, 0),
(88, 45, 2003, 1),
(89, 45, 2004, 0),
(90, 45, 2005, 0),
(91, 45, 2006, 0),
(92, 45, 2009, 1),
(93, 45, 2010, 0),
(94, 45, 2015, 0),
(95, 44, 2002, 0),
(97, 44, 4000, 0),
(161, 45, 2002, 0),
(163, 45, 4000, 0),
(164, 45, 2016, 1);

-- --------------------------------------------------------

--
-- 表的结构 `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` bigint(18) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- 转存表中的数据 `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`) VALUES
(93, 44, 128),
(94, 45, 129),
(95, 45, 130),
(98, 44, 60);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expiry_basetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'this is the time that start counting expiration, not the final expiry time, the final depend on user role',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `guest_time_out` datetime DEFAULT NULL,
  `role_id` int(128) DEFAULT '0',
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `un_users_email` (`email`) USING HASH
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `expiry_basetime`, `modified`, `guest_time_out`, `role_id`, `first_name`, `last_name`) VALUES
(59, 'test', '$P$Bs3sSiq2zWjH1aFZdKJ/aasZNdAdyz.', 'org_admin@com.co.nz', 1, 0, NULL, NULL, NULL, NULL, 'e580d5f16ac735b965040fdf91022882', '::1', '2015-05-22 01:00:28', '2015-03-17 15:31:42', '2015-03-17 15:49:34', '2015-05-21 23:01:39', NULL, 1, 'test1', 'auckland'),
(60, 'sample', '$P$BhYH9OFVEoYZm0tvrM5b1hV5bvc/zx/', 'org_user@com.co.nz', 1, 0, NULL, NULL, NULL, NULL, '1dccd07fad36e0fbc96cdeaca71caf8e', '121.98.113.66', '2015-05-20 16:35:19', '2015-03-31 09:04:07', '2015-05-20 16:35:19', '2015-05-21 04:35:39', NULL, 3, NULL, NULL),
(79, 'test2', '$P$BpjL8kBiDG1bKNLUmuZhfMLK8pQZit/', 'test2@com.co.nz', 1, 0, NULL, NULL, NULL, NULL, '466e7e1896833003bd68549d0270d61f', '127.0.0.1', '2015-05-21 09:41:13', '2015-04-28 14:38:23', '2015-05-21 09:41:13', '2015-05-21 23:01:47', NULL, 3, 'test2', 'pipi'),
(128, '', '$P$Bg6eJ7s1iqVdhTmQWufAcfB0XaQs9o0', 'uploaduser772@ddd.com', 1, 0, NULL, NULL, NULL, NULL, '7d619ac4fb113c629ac7116605e4ac65', '127.0.0.1', '0000-00-00 00:00:00', '2015-05-06 14:22:24', '2015-05-06 14:22:24', '2015-05-06 02:21:22', NULL, 3, 'upload', 'user'),
(129, '', '$P$B3uh0iHYzCPPKn1qMzf3kc8xwL41Yy.', 'uploaduser773@ddd.com', 1, 0, NULL, NULL, NULL, NULL, '673d31a527d284e1fa16b01e5903e451', '127.0.0.1', '0000-00-00 00:00:00', '2015-05-06 14:22:25', '2015-05-06 14:22:25', '2015-05-06 02:21:22', NULL, 3, 'upload', 'user'),
(130, '', '$P$B31iydFuEfHeQc8VVQWJ/RCZgFBtPB0', 'uploaduser774@ddd.com', 1, 0, NULL, NULL, NULL, NULL, '33a250449f0417ee42c4690d6fb50c25', '127.0.0.1', '0000-00-00 00:00:00', '2015-05-06 14:22:25', '2015-05-06 14:22:25', '2015-05-06 02:21:22', NULL, 3, 'upload', 'user'),
(131, '', '$P$Bq/ry9mRwKPSyp31IhLrhYMZ//Av6u0', 'test_user@com.co.nz', 1, 0, NULL, NULL, NULL, NULL, '2e916ac8ff6541dbd156362b88f42d9d', '127.0.0.1', '2015-05-07 14:22:22', '2015-05-07 14:18:43', '2015-05-07 14:22:22', '2015-05-21 04:34:43', NULL, 3, 'test_user', 'test ');

-- --------------------------------------------------------

--
-- 表的结构 `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `user_autologin`
--

INSERT INTO `user_autologin` (`key_id`, `user_id`, `user_agent`, `last_ip`, `last_login`) VALUES
('0b394280b8916fd7d4453fe5f2078a8b', 59, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.78.2 (KHTML, like Gecko) Version/7.0.6 Safari/537.78.2', '127.0.0.1', '2015-05-11 21:58:39'),
('1ad77f68805f1ea7c3a9238dd13de352', 58, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.78.2 (KHTML, like Gecko) Version/7.0.6 Safari/537.78.2', '127.0.0.1', '2015-05-06 22:25:11'),
('21f14ca61c536dd9329ee9b810cc50ce', 58, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', '127.0.0.1', '2015-05-14 23:46:59'),
('33a528c61039fe4bd77ef81b619d5f0f', 58, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36', '127.0.0.1', '2015-04-29 01:01:49'),
('4377c109bd172a430b8825a0f9c8a326', 58, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', '121.98.113.66', '2015-05-11 22:43:12'),
('53ae5ecaae20cde7c11039d7eb30dad7', 58, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36', '122.60.23.189', '2015-04-28 09:51:48'),
('62f9b3f89d01e2af1069e6c741301bed', 58, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36', '121.98.113.66', '2015-04-30 21:21:52'),
('8f3fe955ff9103479242318f1efc93f9', 58, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', '121.98.113.66', '2015-05-20 02:22:04'),
('970f90b28c4078bf76daddd3cfa1bbcb', 58, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36', '127.0.0.1', '2015-04-15 00:02:07'),
('a360139f71601f50b5b86e704b1f1d9e', 79, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:38.0) Gecko/20100101 Firefox/38.0', '127.0.0.1', '2015-05-20 21:41:13'),
('b55718aff459ff24cdf906177e782cd3', 58, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', '127.0.0.1', '2015-05-20 21:52:39'),
('c31a483712740427b53d65cd7d75b6f7', 58, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.78.2 (KHTML, like Gecko) Version/7.0.6 Safari/537.78.2', '121.98.113.66', '2015-04-24 01:28:18'),
('ce3439ffd23c0785a8e0a67cf0d62447', 79, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:37.0) Gecko/20100101 Firefox/37.0', '127.0.0.1', '2015-05-14 23:08:04');

-- --------------------------------------------------------

--
-- 表的结构 `user_privilege`
--

CREATE TABLE IF NOT EXISTS `user_privilege` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `privilege_id` smallint(4) DEFAULT NULL,
  `privilege_value` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `un1` (`user_id`,`privilege_id`),
  KEY `user_id` (`user_id`),
  KEY `privilege_id` (`privilege_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1382 ;

--
-- 转存表中的数据 `user_privilege`
--

INSERT INTO `user_privilege` (`id`, `user_id`, `privilege_id`, `privilege_value`) VALUES
(672, 60, 2000, 1),
(673, 60, 2001, 1),
(674, 60, 2003, 1),
(675, 60, 2009, 1),
(676, 60, 2002, 0),
(678, 60, 2005, 0),
(679, 60, 2004, 1),
(681, 60, 2015, 1),
(682, 60, 2006, 1),
(684, 60, 2010, 0),
(827, 79, 2002, 1),
(828, 79, 2003, 1),
(829, 79, 2005, 0),
(830, 79, 2004, 0),
(831, 79, 2000, 0),
(832, 79, 2015, 0),
(833, 79, 2006, 0),
(834, 79, 2001, 0),
(835, 79, 2010, 0),
(836, 79, 2009, 1),
(867, 59, 2002, 1),
(868, 59, 2003, 1),
(869, 59, 2005, 1),
(870, 59, 2004, 1),
(871, 59, 2000, 1),
(872, 59, 2015, 1),
(873, 59, 2006, 1),
(874, 59, 2001, 1),
(875, 59, 2010, 1),
(876, 59, 2009, 1),
(937, 128, 2000, 1),
(938, 128, 2001, 1),
(939, 128, 2003, 1),
(940, 128, 2004, 1),
(941, 128, 2009, 1),
(942, 129, 2003, 1),
(943, 129, 2009, 1),
(944, 130, 2003, 1),
(945, 130, 2009, 1),
(1091, 59, 4000, 1),
(1170, 60, 4000, 0),
(1238, 59, 2016, 0),
(1309, 79, 4000, 1),
(1310, 79, 2016, 0),
(1368, 79, 4001, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `country`, `website`) VALUES
(1, 63, NULL, NULL),
(2, 66, NULL, NULL),
(3, 67, NULL, NULL),
(4, 69, NULL, NULL),
(5, 70, NULL, NULL),
(6, 80, NULL, NULL);

--
-- 限制导出的表
--

--
-- 限制表 `org_admin`
--
ALTER TABLE `org_admin`
  ADD CONSTRAINT `fk_orgadmin_orgid_org_id` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orgadmin_userid_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `org_privilege`
--
ALTER TABLE `org_privilege`
  ADD CONSTRAINT `fk_org_id` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_privilege_id` FOREIGN KEY (`privilege_id`) REFERENCES `privilege` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `org_role`
--
ALTER TABLE `org_role`
  ADD CONSTRAINT `fk_orgid` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `org_user`
--
ALTER TABLE `org_user`
  ADD CONSTRAINT `fk_orguser_org_orgid` FOREIGN KEY (`org_id`) REFERENCES `org` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orguser_org_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `role_privilege`
--
ALTER TABLE `role_privilege`
  ADD CONSTRAINT `fk_roleprivilege_role_id` FOREIGN KEY (`role_id`) REFERENCES `org_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_role_privilege_privilege_id` FOREIGN KEY (`privilege_id`) REFERENCES `privilege` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `fk_roleid_to_org_role_to_id` FOREIGN KEY (`role_id`) REFERENCES `org_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userid_to_users_to_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `user_privilege`
--
ALTER TABLE `user_privilege`
  ADD CONSTRAINT `user_privilege_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_privilege_ibfk_2` FOREIGN KEY (`privilege_id`) REFERENCES `privilege` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
