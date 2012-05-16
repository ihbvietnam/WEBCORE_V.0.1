-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2012 at 05:42 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `authassignment`
--

CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(64) NOT NULL,
  `bizrule` text COLLATE utf8_unicode_ci,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authassignment`
--

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', 1, NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitem`
--

CREATE TABLE IF NOT EXISTS `authitem` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `bizrule` text COLLATE utf8_unicode_ci,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authitem`
--

INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('admin', 2, '', NULL, 'N;'),
('author', 2, '', NULL, 'N;'),
('create', 0, 'create', NULL, 'N;'),
('delete', 0, 'delete', NULL, 'N;'),
('editor', 2, '', NULL, 'N;'),
('manager_account', 2, NULL, NULL, NULL),
('managerAccount', 0, 'manager user', NULL, NULL),
('update', 0, 'update a post', NULL, 'N;'),
('updateOwn', 1, 'update a post by author himself', 'return Yii::app()->user->id==$params["post"]->created_by;', 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitemchild`
--

CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authitemchild`
--

INSERT INTO `authitemchild` (`parent`, `child`) VALUES
('admin', 'author'),
('author', 'create'),
('update', 'create'),
('admin', 'delete'),
('admin', 'editor'),
('admin', 'manager_account'),
('manager_account', 'managerAccount'),
('editor', 'update'),
('updateOwn', 'update'),
('author', 'updateOwn');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_article`
--

CREATE TABLE IF NOT EXISTS `tbl_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'vi',
  `catid` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `special` tinyint(4) NOT NULL DEFAULT '0',
  `order_view` int(11) NOT NULL DEFAULT '0',
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `other` text COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_article`
--

INSERT INTO `tbl_article` (`id`, `lang`, `catid`, `type`, `status`, `special`, `order_view`, `title`, `alias`, `keywords`, `other`, `created_by`, `created_date`) VALUES
(1, 'vi', 51, 1, 1, 0, 0, 'Tầm nhìn sứ mệnh', 'tam-nhin-su-menh', '', '{"introimage":"1","list_suggest":"","fulltext":"<p><span style=\\"font-size: 10pt; font-family: verdana,geneva; color: #092e5a;\\"><strong><span style=\\"font-size: 12pt;\\">S\\u1ee9 m\\u1ec7nh:<\\/span><\\/strong><span style=\\"font-size: 12pt;\\"> Mang \\u0111\\u1ebfn cho t\\u1eebng kh&aacute;ch h&agrave;ng nh\\u1eefng s\\u1ea3n ph\\u1ea9m, nh\\u1eefng d\\u1ecbch v\\u1ee5 c&ocirc;ng ngh\\u1ec7  th&ocirc;ng tin t\\u1ed1t nh\\u1ea5t gi&uacute;p ho&agrave;n thi\\u1ec7n h\\u01a1n ch\\u1ea5t l\\u01b0\\u1ee3ng s\\u1ed1ng c\\u1ee7a kh&aacute;ch h&agrave;ng:  t\\u1eeb vi\\u1ec7c \\u0103n u\\u1ed1ng, gi\\u1ea3i tr&iacute; th\\u01b0\\u1eddng ng&agrave;y cho \\u0111\\u1ebfn nh\\u1eefng v\\u1ea5n \\u0111\\u1ec1 v\\u1ec1 s\\u1ee9c kh\\u1ecfe,  ch\\u0103m s&oacute;c, gi&aacute;o d\\u1ee5c con c&aacute;i.<\\/span><\\/span><\\/p>\\r\\n<p><span style=\\"font-size: 12pt; font-family: verdana,geneva; color: #092e5a;\\"><strong>T\\u1ea7m nh&igrave;n:<\\/strong> IHB Vi\\u1ec7t Nam mong mu\\u1ed1n tr\\u1edf th&agrave;nh th\\u01b0\\u01a1ng hi\\u1ec7u s\\u1ed1 m\\u1ed9t Vi\\u1ec7t Nam v\\u1ec1 c&aacute;c s\\u1ea3n  ph\\u1ea9m, d\\u1ecbch v\\u1ee5 c&ocirc;ng ngh\\u1ec7 th&ocirc;ng tin h\\u1eefu &iacute;ch ph\\u1ee5c v\\u1ee5 c\\u1ed9ng \\u0111\\u1ed3ng. IHB Vi\\u1ec7t  Nam c\\u0169ng \\u0111\\u1eb7t m\\u1ee5c ti&ecirc;u xu\\u1ea5t kh\\u1ea9u s\\u1ea3n ph\\u1ea9m v&agrave; d\\u1ecbch v\\u1ee5 c&ocirc;ng ngh\\u1ec7 th&ocirc;ng tin  ra th\\u1ecb tr\\u01b0\\u1eddng qu\\u1ed1c t\\u1ebf.<\\/span><\\/p>","introtext":"S\\u1ee9 m\\u1ec7nh: Mang \\u0111\\u1ebfn cho t\\u1eebng kh&aacute;ch h&agrave;ng nh\\u1eefng s\\u1ea3n ph\\u1ea9m, nh\\u1eefng d\\u1ecbch v\\u1ee5 c&ocirc;ng ngh\\u1ec7  th&ocirc;ng tin t\\u1ed1t nh\\u1ea5t gi&uacute;p ho&agrave;n thi\\u1ec7n h\\u01a1n ch\\u1ea5t l\\u01b0\\u1ee3ng s\\u1ed1ng c\\u1ee7a kh&aacute;ch h&agrave;ng:  t\\u1eeb vi\\u1ec7c \\u0103n u\\u1ed1ng, gi\\u1ea3i tr&iacute; th\\u01b0\\u1eddng ng&agrave;y cho \\u0111\\u1ebfn nh\\u1eefng v\\u1ea5n \\u0111\\u1ec1 v\\u1ec1 s\\u1ee9c kh\\u1ecfe,  ch\\u0103m s&oacute;c, gi&aacute;o d\\u1ee5c con c&aacute;i.\\r\\nT\\u1ea7m nh&igrave;n: IHB Vi\\u1ec7t Nam mong mu\\u1ed1n tr\\u1edf th&agrave;nh th\\u01b0\\u01a1ng hi\\u1ec7u s\\u1ed1 m\\u1ed9t Vi\\u1ec7t Nam v\\u1ec1 c&aacute;c s\\u1ea3n  ph\\u1ea9m, d\\u1ecbch v\\u1ee5 c&ocirc;ng ngh\\u1ec7 th&ocirc;ng tin h\\u1eefu &iacute;ch ph\\u1ee5c v\\u1ee5 c\\u1ed9ng \\u0111\\u1ed3ng. IHB Vi\\u1ec7t  Nam c\\u0169ng \\u0111\\u1eb7t m\\u1ee5c ti&ecirc;u xu\\u1ea5t kh\\u1ea9u s\\u1ea3n ph\\u1ea9m v&agrave; d\\u1ecbch ...","modified":"{\\"1337157173\\":\\"1\\"}"}', 1, 1337156987),
(2, 'vi', 51, 1, 1, 0, 0, 'Triết lý kinh doanh', 'triet-ly-kinh-doanh', '', '{"introimage":"2","list_suggest":"","fulltext":"<div><span style=\\"font-family: verdana,geneva; font-size: 12pt; color: #092e5a;\\">\\"V\\u1edbi  slogan IHB &ndash; \\u0110\\u1ed2NG H&Agrave;NH C&Ugrave;NG CU\\u1ed8C S\\u1ed0NG, ch&uacute;ng t&ocirc;i lu&ocirc;n cam k\\u1ebft n\\u1ed7 l\\u1ef1c  h\\u1ebft m&igrave;nh \\u0111\\u1ec3 \\u0111em \\u0111\\u1ebfn cho kh&aacute;ch h&agrave;ng nh\\u1eefng s\\u1ea3n ph\\u1ea9m, d\\u1ecbch v\\u1ee5 t\\u1ed1t nh\\u1ea5t c&ugrave;ng  s\\u1ef1 ch\\u0103m s&oacute;c nhi\\u1ec7t t&igrave;nh chu \\u0111&aacute;o.<\\/span><\\/div>\\r\\n<div><span style=\\"font-family: verdana,geneva; font-size: 12pt; color: #092e5a;\\"><br \\/><\\/span><\\/div>\\r\\n<div><span style=\\"font-family: verdana,geneva; font-size: 12pt; color: #092e5a;\\">Ch&uacute;ng  t&ocirc;i hi\\u1ec3u r\\u1eb1ng, s\\u1ef1 ph&aacute;t tri\\u1ec3n b\\u1ec1n v\\u1eefng c\\u1ee7a IHB ch\\u1ec9 c&oacute; \\u0111\\u01b0\\u1ee3c khi ch&uacute;ng t&ocirc;i  kh&ocirc;ng ng\\u1eebng n&acirc;ng cao ch\\u1ea5t l\\u01b0\\u1ee3ng d\\u1ecbch v\\u1ee5, g&oacute;p ph\\u1ea7n v&agrave;o s\\u1ef1 ph&aacute;t tri\\u1ec3n v&agrave;  n&acirc;ng cao \\u0111\\u1eddi s\\u1ed1ng x&atilde; h\\u1ed9i. Quan tr\\u1ecdng h\\u01a1n n\\u1eefa, ch&uacute;ng t&ocirc;i lu&ocirc;n mong mu\\u1ed1n  IHB s\\u1ebd lu&ocirc;n \\u0111\\u1ed3ng h&agrave;nh tr&ecirc;n con \\u0111\\u01b0\\u1eddng \\u0111i t\\u1edbi th&agrave;nh c&ocirc;ng c\\u1ee7a qu&yacute; kh&aacute;ch.\\"<\\/span><\\/div>\\r\\n<p style=\\"line-height: normal; text-align: right;\\"><em><span style=\\"font-size: 12pt; font-family: verdana,geneva; color: #092e5a;\\">Tr&acirc;n tr\\u1ecdng, IHB!<\\/span><\\/em><\\/p>","introtext":"\\"V\\u1edbi  slogan IHB &ndash; \\u0110\\u1ed2NG H&Agrave;NH C&Ugrave;NG CU\\u1ed8C S\\u1ed0NG, ch&uacute;ng t&ocirc;i lu&ocirc;n cam k\\u1ebft n\\u1ed7 l\\u1ef1c  h\\u1ebft m&igrave;nh \\u0111\\u1ec3 \\u0111em \\u0111\\u1ebfn cho kh&aacute;ch h&agrave;ng nh\\u1eefng s\\u1ea3n ph\\u1ea9m, d\\u1ecbch v\\u1ee5 t\\u1ed1t nh\\u1ea5t c&ugrave;ng  s\\u1ef1 ch\\u0103m s&oacute;c nhi\\u1ec7t t&igrave;nh chu \\u0111&aacute;o.\\r\\n\\r\\nCh&uacute;ng  t&ocirc;i hi\\u1ec3u r\\u1eb1ng, s\\u1ef1 ph&aacute;t tri\\u1ec3n b\\u1ec1n v\\u1eefng c\\u1ee7a IHB ch\\u1ec9 c&oacute; \\u0111\\u01b0\\u1ee3c khi ch&uacute;ng t&ocirc;i  kh&ocirc;ng ng\\u1eebng n&acirc;ng cao ch\\u1ea5t l\\u01b0\\u1ee3ng d\\u1ecbch v\\u1ee5, g&oacute;p ph\\u1ea7n v&agrave;o s\\u1ef1 ph&aacute;t tri\\u1ec3n v&agrave;  n&acirc;ng cao \\u0111\\u1eddi s\\u1ed1ng x&atilde; h\\u1ed9i. Quan tr\\u1ecdng h\\u01a1n n\\u1eefa, ch&uacute;ng t&ocirc;i lu&ocirc;n mong mu\\u1ed1n  IHB s\\u1ebd lu&ocirc;n \\u0111\\u1ed3ng h&agrave;nh tr&ecirc;n con \\u0111\\u01b0\\u1eddng ...","modified":"{\\"1337158145\\":\\"1\\"}"}', 1, 1337157237),
(3, 'vi', 51, 1, 1, 0, 0, 'Dự án đầu tư', 'du-an-dau-tu', '', '{"introimage":"3","list_suggest":"","fulltext":"<p style=\\"margin-left: 54pt; text-indent: -18pt; text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #092e5a;\\"><strong>1.1.<\\/strong><strong>C\\u1ed5ng th&ocirc;ng tin t&iacute;ch h\\u1ee3p<\\/strong> <strong><span style=\\"text-decoration: underline;\\"><span style=\\"text-decoration: underline;\\"><a href=\\"http:\\/\\/www.khoemoingay.com\\/\\"><span style=\\"color: #092e5a; text-decoration: underline;\\">www.khoemoingay.com<\\/span><\\/a><\\/span><\\/span><\\/strong><\\/span><\\/p>\\r\\n<p style=\\"margin-left: 54pt; text-indent: -18pt; text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #092e5a;\\">-<span style=\\"font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; font-size-adjust: none; font-stretch: normal;\\">&nbsp;&nbsp;&nbsp; <\\/span>C\\u1ed5ng  th&ocirc;ng tin v\\u1ec1 y d\\u01b0\\u1ee3c, s\\u1ee9c kh\\u1ecfe \\u0111a t\\u01b0\\u01a1ng t&aacute;c: L&agrave; 1 c\\u1ed5ng th&ocirc;ng tin \\u0111\\u01b0\\u1ee3c  ph&aacute;t tri\\u1ec3n theo &yacute; t\\u01b0\\u1edfng c\\u1ee7a th\\u1ebf h\\u1ec7 web 2.0 h\\u01b0\\u1edbng t\\u1edbi ng\\u01b0\\u1eddi d&ugrave;ng nhi\\u1ec1u  h\\u01a1n: chia s\\u1ebb th&ocirc;ng tin, l\\u1ef1a ch\\u1ecdn v&agrave; theo d&otilde;i c&aacute;c th&ocirc;ng tin m&agrave; m&igrave;nh quan  t&acirc;m, b&igrave;nh lu\\u1eadn, th\\u1ea3o lu\\u1eadn v\\u1ec1 c&aacute;c th&ocirc;ng tin &hellip;<\\/span><\\/p>\\r\\n<p style=\\"margin-left: 54pt; text-indent: -18pt; text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #092e5a;\\">-<span style=\\"font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; font-size-adjust: none; font-stretch: normal;\\">&nbsp;&nbsp;&nbsp; <\\/span>D\\u1ecbch  v\\u1ee5 t\\u01b0 v\\u1ea5n s\\u1ee9c kh\\u1ecfe tr\\u1ef1c tuy\\u1ebfn: \\u0110\\u1ed9i ng\\u0169 t\\u01b0 v\\u1ea5n s\\u1ee9c kh\\u1ecfe chuy&ecirc;n nghi\\u1ec7p,  c&aacute;c h&igrave;nh th\\u1ee9c t\\u01b0 v\\u1ea5n tr\\u1ef1c tuy\\u1ebfn phong ph&uacute; (chat text, chat voice, chat  video), \\u0111\\u1eb7t l\\u1ecbch t\\u01b0 v\\u1ea5n &hellip;<\\/span><\\/p>\\r\\n<p style=\\"margin-left: 54pt; text-indent: -18pt; text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #092e5a;\\">-<span style=\\"font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; font-size-adjust: none; font-stretch: normal;\\">&nbsp;&nbsp;&nbsp; <\\/span>Th\\u01b0 vi\\u1ec7n y khoa online: Tra c\\u1ee9u c&aacute;c th&ocirc;ng tin v\\u1ec1 y d\\u01b0\\u1ee3c \\u0111\\u1ea7y \\u0111\\u1ee7, nhanh ch&oacute;ng v&agrave; ti\\u1ec7n l\\u1ee3i nh\\u1ea5t.<\\/span><\\/p>\\r\\n<p style=\\"margin-left: 54pt; text-indent: -18pt; text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #092e5a;\\">-<span style=\\"font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; font-size-adjust: none; font-stretch: normal;\\">&nbsp;&nbsp;&nbsp; <\\/span>Danh  b\\u1ea1 y khoa online: Cho ph&eacute;p tra c\\u1ee9u danh s&aacute;ch c&aacute;c c\\u1eeda h&agrave;ng thu\\u1ed1c, ph&ograve;ng  kh&aacute;m, b\\u1ec7nh vi\\u1ec7n, trung t&acirc;m dinh d\\u01b0\\u1ee1ng, l&agrave;m \\u0111\\u1eb9p &hellip; ; \\u0111\\u1eb7t l\\u1ecbch, \\u0111\\u0103ng k&iacute; s\\u1eed  d\\u1ee5ng d\\u1ecbch v\\u1ee5 tr\\u1ef1c tuy\\u1ebfn.<\\/span><\\/p>\\r\\n<p style=\\"margin-left: 54pt; text-indent: -18pt; text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #092e5a;\\">-<span style=\\"font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; font-size-adjust: none; font-stretch: normal;\\">&nbsp;&nbsp;&nbsp; <\\/span>Nh&agrave; thu\\u1ed1c \\u0111i\\u1ec7n t\\u1eed: Ni&ecirc;m y\\u1ebft gi&aacute; thu\\u1ed1c tr\\u1ef1c tuy\\u1ebfn, \\u0111\\u1eb7t \\u0111\\u01a1n tr\\u1ef1c tuy\\u1ebfn.<\\/span><\\/p>\\r\\n<p style=\\"margin-left: 54pt; text-indent: -18pt; text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #092e5a;\\"><img src=\\"http:\\/\\/framework.vn\\/upload\\/2012\\/05\\/16\\/origin_editor\\/kmn.png\\" alt=\\"\\" width=\\"958\\" height=\\"693\\" \\/><br \\/><\\/span><\\/p>","introtext":"1.1.C\\u1ed5ng th&ocirc;ng tin t&iacute;ch h\\u1ee3p www.khoemoingay.com\\r\\n-&nbsp;&nbsp;&nbsp; C\\u1ed5ng  th&ocirc;ng tin v\\u1ec1 y d\\u01b0\\u1ee3c, s\\u1ee9c kh\\u1ecfe \\u0111a t\\u01b0\\u01a1ng t&aacute;c: L&agrave; 1 c\\u1ed5ng th&ocirc;ng tin \\u0111\\u01b0\\u1ee3c  ph&aacute;t tri\\u1ec3n theo &yacute; t\\u01b0\\u1edfng c\\u1ee7a th\\u1ebf h\\u1ec7 web 2.0 h\\u01b0\\u1edbng t\\u1edbi ng\\u01b0\\u1eddi d&ugrave;ng nhi\\u1ec1u  h\\u01a1n: chia s\\u1ebb th&ocirc;ng tin, l\\u1ef1a ch\\u1ecdn v&agrave; theo d&otilde;i c&aacute;c th&ocirc;ng tin m&agrave; m&igrave;nh quan  t&acirc;m, b&igrave;nh lu\\u1eadn, th\\u1ea3o lu\\u1eadn v\\u1ec1 c&aacute;c th&ocirc;ng tin &hellip;\\r\\n-&nbsp;&nbsp;&nbsp; D\\u1ecbch  v\\u1ee5 t\\u01b0 v\\u1ea5n s\\u1ee9c kh\\u1ecfe tr\\u1ef1c tuy\\u1ebfn: \\u0110\\u1ed9i ng\\u0169 t\\u01b0 v\\u1ea5n s\\u1ee9c kh\\u1ecfe chuy&ecirc;n nghi\\u1ec7p,  c&aacute;c h&igrave;nh th\\u1ee9c t\\u01b0 v\\u1ea5n tr\\u1ef1c tuy\\u1ebfn phong ph&uacute; (chat text, chat voice, chat ...","modified":"{\\"1337157363\\":\\"1\\"}"}', 1, 1337157341),
(4, 'vi', 52, 1, 1, 0, 0, 'Thủ tục và trình tự hợp tác', 'thu-tuc-va-trinh-tu-hop-tac', '', '{"introimage":"4","list_suggest":"","fulltext":"<p><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\"><strong>- B\\u01b0\\u1edbc 1:<\\/strong> \\u0110\\u1ed1i t&aacute;c trao \\u0111\\u1ed5i v\\u1edbi nh&acirc;n vi&ecirc;n kinh doanh v&agrave; ch\\u0103m s&oacute;c kh&aacute;ch h&agrave;ng c\\u1ee7a IHB Vi\\u1ec7t Nam.<\\/span><\\/p>\\r\\n<p style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">&nbsp;&nbsp;&nbsp;&nbsp; H\\u1ed7 tr\\u1ee3 1: <a href=\\"mailto:ihbvietnam@yahoo.com\\">ihbvietnam@yahoo.com<\\/a> (0977 379 326)<br \\/><\\/span><\\/p>\\r\\n<p style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">&nbsp;&nbsp;&nbsp;&nbsp; H\\u1ed7 tr\\u1ee3 2: <a href=\\"mailto:ihb_epay@yahoo.com\\">ihb_epay@yahoo.com<\\/a><br \\/><\\/span><\\/p>\\r\\n<p style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">&nbsp;&nbsp; <strong>- B\\u01b0\\u1edbc 2: K&yacute; k\\u1ebft h\\u1ee3p \\u0111\\u1ed3ng:<\\/strong> <\\/span><\\/p>\\r\\n<p style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">&nbsp;&nbsp;&nbsp;&nbsp;  \\u0110\\u1ed1i t&aacute;c g\\u1eedi l\\u1ea1i h\\u1ee3p \\u0111\\u1ed3ng sau khi \\u0111&atilde; k&yacute; v&agrave; \\u0111&oacute;ng d\\u1ea5u (v\\u1edbi kh&aacute;ch h&agrave;ng c&aacute;  nh&acirc;n, c&oacute; th\\u1ec3 ch\\u1ec9 ph\\u1ea3i g\\u1eedi b\\u1ea3n m\\u1ec1m v&agrave; b\\u1ea3n scan CMND) cho IHB Vi\\u1ec7t Nam. C&oacute;  2 ph\\u01b0\\u01a1ng th\\u1ee9c g\\u1eedi:<br \\/><\\/span><\\/p>\\r\\n<p style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; o B\\u1ea3n gi\\u1ea5y g\\u1eedi v\\u1ec1 \\u0111\\u1ecba ch\\u1ec9: <\\/span><\\/p>\\r\\n<p style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; T\\u1ea7ng 4, nh&agrave; 6, ng&otilde; 850, \\u0111\\u01b0\\u1eddng L&aacute;ng, qu\\u1eadn \\u0110\\u1ed1ng \\u0110a, H&agrave; N\\u1ed9i.<\\/span><\\/p>\\r\\n<p style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \\u0110T: 04 6680 7626&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hotline: 0977 379 326<br \\/><\\/span><\\/p>\\r\\n<p style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; o B\\u1ea3n m\\u1ec1m g\\u1eedi v&agrave;o \\u0111\\u1ecba ch\\u1ec9 mail: <a href=\\"mailto:kinhdoanh@ihbvietnam.com\\">kinhdoanh@ihbvietnam.com<\\/a>.<\\/span><\\/p>\\r\\n<p style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">&nbsp;&nbsp; <strong>- B\\u01b0\\u1edbc 3:<\\/strong> IHB ti\\u1ebfn h&agrave;nh h\\u1ed7 tr\\u1ee3 v&agrave; tri\\u1ec3n khai d\\u1ecbch v\\u1ee5 (D\\u1ecbch v\\u1ee5 c&oacute; th\\u1ec3 \\u0111\\u01b0\\u1ee3c tri\\u1ec3n khai ngay trong ng&agrave;y).<\\/span><\\/p>\\r\\n<div style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">H&atilde;y  g\\u1ecdi cho IHB Vi\\u1ec7t Nam \\u0111\\u1ec3 IHB \\u0111\\u01b0\\u1ee3c h\\u1ed7 tr\\u1ee3 Qu&yacute; kh&aacute;ch. IHB Vi\\u1ec7t Nam lu&ocirc;n  mong mu\\u1ed1n \\u0111\\u01b0\\u1ee3c h\\u1ed7 tr\\u1ee3 Qu&yacute; kh&aacute;ch h&agrave;ng v\\u1ec1 d\\u1ecbch v\\u1ee5 thanh to&aacute;n qua th\\u1ebb c&agrave;o.  S\\u1ef1 ph&aacute;t tri\\u1ec3n c\\u1ee7a Qu&yacute; kh&aacute;ch l&agrave; ni\\u1ec1m t\\u1ef1 h&agrave;o c\\u1ee7a ch&uacute;ng t&ocirc;i!<\\/span><\\/div>\\r\\n<div style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\"><br \\/><\\/span><\\/div>\\r\\n<div style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\"><em>(*): Doanh thu nh&agrave; m\\u1ea1ng tr\\u1ea3 v\\u1ec1 cho IHB Vi\\u1ec7t Nam l&agrave; 85% gi&aacute; tr\\u1ecb th\\u1ebb n\\u1ea1p.<\\/em><br \\/><\\/span><\\/div>\\r\\n<p style=\\"text-align: left;\\"><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\"><br \\/><\\/span><\\/p>\\r\\n<p style=\\"text-align: left;\\"><strong><span style=\\"font-family: verdana,geneva; font-size: 10pt; color: #284d73;\\">Tr&acirc;n tr\\u1ecdng,<\\/span><\\/strong><\\/p>","introtext":"- B\\u01b0\\u1edbc 1: \\u0110\\u1ed1i t&aacute;c trao \\u0111\\u1ed5i v\\u1edbi nh&acirc;n vi&ecirc;n kinh doanh v&agrave; ch\\u0103m s&oacute;c kh&aacute;ch h&agrave;ng c\\u1ee7a IHB Vi\\u1ec7t Nam.\\r\\n&nbsp;&nbsp;&nbsp;&nbsp; H\\u1ed7 tr\\u1ee3 1: ihbvietnam@yahoo.com (0977 379 326)\\r\\n&nbsp;&nbsp;&nbsp;&nbsp; H\\u1ed7 tr\\u1ee3 2: ihb_epay@yahoo.com\\r\\n&nbsp;&nbsp; - B\\u01b0\\u1edbc 2: K&yacute; k\\u1ebft h\\u1ee3p \\u0111\\u1ed3ng: \\r\\n&nbsp;&nbsp;&nbsp;&nbsp;  \\u0110\\u1ed1i t&aacute;c g\\u1eedi l\\u1ea1i h\\u1ee3p \\u0111\\u1ed3ng sau khi \\u0111&atilde; k&yacute; v&agrave; \\u0111&oacute;ng d\\u1ea5u (v\\u1edbi kh&aacute;ch h&agrave;ng c&aacute;  nh&acirc;n, c&oacute; th\\u1ec3 ch\\u1ec9 ph\\u1ea3i g\\u1eedi b\\u1ea3n m\\u1ec1m v&agrave; b\\u1ea3n scan CMND) cho IHB Vi\\u1ec7t Nam. C&oacute;  2 ph\\u01b0\\u01a1ng th\\u1ee9c g\\u1eedi:\\r\\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; o B\\u1ea3n gi\\u1ea5y g\\u1eedi v\\u1ec1 \\u0111\\u1ecba ch\\u1ec9: \\r\\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; T\\u1ea7ng 4, nh&agrave; 6, ng&otilde; 850, \\u0111\\u01b0\\u1eddng L&aacute;ng, qu\\u1eadn \\u0110\\u1ed1ng \\u0110a, ...","modified":"{\\"1337158113\\":\\"1\\",\\"1337158121\\":\\"1\\"}"}', 1, 1337158082),
(5, 'vi', 0, 6, 1, 0, 0, 'Banner trái', 'banner-trai-16052012', '', '{"description":"","images":"5"}', 1, 1337158895),
(6, 'vi', 0, 6, 1, 0, 0, 'Banner phải', 'banner-phai-16052012', '', '{"description":"","images":"6"}', 1, 1337158990),
(7, 'vi', 0, 6, 1, 0, 0, 'Banner headline', 'banner-headline-16052012', '', '{"description":"","images":"7,8,9,10,11,12"}', 1, 1337159136);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'vi',
  `alias` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) DEFAULT NULL,
  `special` tinyint(4) DEFAULT NULL,
  `order_view` smallint(6) NOT NULL DEFAULT '1',
  `keywords` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `other` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=70 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `lang`, `alias`, `name`, `parent_id`, `child_id`, `special`, `order_view`, `keywords`, `other`, `created_by`, `created_date`) VALUES
(1, 'vi', 'danh-muc-menu-trang-quan-tri', 'Danh mục menu trang quản trị', 0, NULL, NULL, 1, '', '{"max_rank":"3","description":"Qu\\u1ea3n l\\u00fd menu trang qu\\u1ea3n tr\\u1ecb ","created_date":1332903011,"modified":"{\\"1337142769\\":\\"1\\",\\"1337142840\\":\\"1\\",\\"1337142900\\":\\"1\\",\\"1337142915\\":\\"1\\"}"}', 1, 1336612722),
(2, 'vi', 'danh-muc-menu-trang-front-end', 'Danh mục menu trang front end', 0, NULL, NULL, 2, '', '{"max_rank":"2","description":"Qu\\u1ea3n l\\u00fd menu trang hi\\u1ec3n th\\u1ecb","created_date":1332903057,"modified":"{\\"1332903474\\":\\"12\\",\\"1337142622\\":\\"1\\",\\"1337142776\\":\\"1\\",\\"1337142847\\":\\"1\\",\\"1337142906\\":\\"1\\"}"}', 1, 1336612722),
(3, 'vi', 'danh-muc-trang-tinh', 'Danh mục trang tĩnh', 0, NULL, NULL, 3, '', '{"max_rank":"1","description":"Qu\\u1ea3n l\\u00fd danh m\\u1ee5c tin t\\u1ee9c","created_date":1332903214,"modified":"{\\"1337142800\\":\\"1\\",\\"1337142923\\":\\"1\\"}"}', 1, 1336612722),
(4, 'vi', 'danh-muc-tin-tuc', 'Danh mục tin tức', 0, NULL, NULL, 4, '', '{"max_rank":"2","description":"Qu\\u1ea3n l\\u00fd danh m\\u1ee5c tin t\\u1ee9c","created_date":1332903214,"modified":"{\\"1337142806\\":\\"1\\",\\"1337142929\\":\\"1\\"}"}', 1, 1336612722),
(5, 'vi', 'danh-muc-san-pham', 'Danh mục sản phẩm', 0, NULL, NULL, 5, '', '{"max_rank":"2","description":"","created_date":1332998910,"modified":"{\\"1337142811\\":\\"1\\",\\"1337142933\\":\\"1\\"}"}', 1, 1336612722),
(6, 'vi', 'danh-muc-nha-san-xuat', 'Danh mục nhà sản xuất', 0, NULL, NULL, 6, '', '{"max_rank":"1","description":"","created_date":1332998922,"modified":"{\\"1337142815\\":\\"1\\",\\"1337142938\\":\\"1\\"}"}', 1, 1336612722),
(7, 'vi', 'danh-muc-album-anh', 'Danh mục album ảnh', 0, NULL, NULL, 7, '', '{"max_rank":"1","description":""}', 1, 1337150676),
(8, 'vi', 'danh-muc-video', 'Danh mục video', 0, NULL, NULL, 8, '', '{"max_rank":"1","description":""}', 1, 1337150686),
(9, 'vi', 'he-thong', 'Hệ thống', 1, NULL, NULL, 1, '', '{"controller":"setting","action":"index","description":"","params":""}', 1, 1337150952),
(10, 'vi', 'cau-hinh', 'Cấu hình', 9, NULL, NULL, 1, '', '{"controller":"setting","action":"index","description":"","params":""}', 1, 1337150970),
(11, 'vi', 'ngon-ngu', 'Ngôn ngữ', 9, NULL, NULL, 2, '', '{"controller":"language","action":"edit","description":"","params":""}', 1, 1337151072),
(12, 'vi', 'chinh-sua', 'Chỉnh sửa', 11, NULL, NULL, 1, '', '{"controller":"language","action":"edit","description":"","params":""}', 1, 1337151511),
(13, 'vi', 'tao-moi', 'Tạo mới', 11, NULL, NULL, 2, '', '{"controller":"language","action":"create","description":"","params":""}', 1, 1337151624),
(14, 'vi', 'xoa', 'Xóa', 11, NULL, NULL, 3, '', '{"controller":"language","action":"delete","description":"","params":""}', 1, 1337151641),
(15, 'vi', 'nhap-du-lieu-tu-file-excel', 'Nhập dữ liệu từ file excel', 11, NULL, NULL, 4, '', '{"controller":"language","action":"import","description":"","params":""}', 1, 1337151665),
(16, 'vi', 'xuat-du-lieu-ra-file-excel', 'Xuất dữ liệu ra file excel', 11, NULL, NULL, 5, '', '{"controller":"language","action":"export","description":"","params":""}', 1, 1337151689),
(17, 'vi', 'don-dep', 'Dọn dẹp', 9, NULL, NULL, 3, '', '{"controller":"config","action":"clear_image","description":"","params":"","modified":"{\\"1337151768\\":\\"1\\"}"}', 1, 1337151757),
(18, 'vi', 'menu', 'Menu', 9, NULL, NULL, 4, '', '{"controller":"config","action":"menu","params":"{\\"group\\":1}","description":""}', 1, 1337151816),
(19, 'vi', 'trang-quan-tri', 'Trang quản trị', 18, NULL, NULL, 1, '', '{"controller":"config","action":"menu","params":"{\\"group\\":1}","description":""}', 1, 1337151831),
(20, 'vi', 'trang-frontend', 'Trang frontend', 18, NULL, NULL, 2, '', '{"controller":"config","action":"menu","params":"{\\"group\\":2}","description":""}', 1, 1337151851),
(21, 'vi', 'banner-quang-cao', 'Banner quảng cáo', 9, NULL, NULL, 5, '', '{"controller":"banner","action":"index","description":"","params":""}', 1, 1337151879),
(22, 'vi', 'banner-quang-cao-tao-moi', 'Tạo mới', 21, NULL, NULL, 1, '', '{"controller":"banner","action":"create","description":"","params":""}', 1, 1337151911),
(23, 'vi', 'quan-ly', 'Quản lý', 21, NULL, NULL, 2, '', '{"controller":"banner","action":"index","description":"","params":""}', 1, 1337152045),
(24, 'vi', 'user', 'User', 9, NULL, NULL, 6, '', '{"controller":"user","action":"index","description":"","params":""}', 1, 1337152112),
(25, 'vi', 'them-moi', 'Thêm mới', 24, NULL, NULL, 1, '', '{"controller":"user","action":"create","description":"","params":""}', 1, 1337152127),
(26, 'vi', 'quan-ly-user', 'Quản lý', 24, NULL, NULL, 2, '', '{"controller":"user","action":"index","description":"","params":""}', 1, 1337152150),
(27, 'vi', 'san-pham', 'Sản phẩm', 1, NULL, NULL, 2, '', '{"controller":"product","action":"index","description":"","params":""}', 1, 1337152268),
(28, 'vi', 'quan-ly-san-pham', 'Quản lý', 27, NULL, NULL, 1, '', '{"controller":"product","action":"index","description":"","params":""}', 1, 1337152305),
(29, 'vi', 'tao-moi-san-pham', 'Tạo mới', 27, NULL, NULL, 2, '', '{"controller":"product","action":"create","description":"","params":""}', 1, 1337152317),
(30, 'vi', 'danh-muc', 'Danh mục', 27, NULL, NULL, 3, '', '{"controller":"product","action":"manager_category","description":"","params":""}', 1, 1337152340),
(31, 'vi', 'nha-san-xuat', 'Nhà sản xuất', 27, NULL, NULL, 4, '', '{"controller":"product","action":"manufacturer","description":"","params":"","modified":"{\\"1337155377\\":\\"1\\"}"}', 1, 1337152496),
(32, 'vi', 'tin-tuc', 'Tin tức', 1, NULL, NULL, 3, '', '{"controller":"news","action":"index","description":"","params":"","modified":"{\\"1337153484\\":\\"1\\",\\"1337153531\\":\\"1\\"}"}', 1, 1337152547),
(33, 'vi', 'quan-ly-tin-tuc', 'Quản lý', 32, NULL, NULL, 1, '', '{"controller":"news","action":"index","description":"","params":""}', 1, 1337152562),
(34, 'vi', 'tao-moi-tin-tuc', 'Tạo mới', 32, NULL, NULL, 2, '', '{"controller":"news","action":"create","description":"","params":""}', 1, 1337152589),
(35, 'vi', 'danh-muc-tin-tuc-7', 'Danh mục', 32, NULL, NULL, 3, '', '{"controller":"news","action":"manager_category","description":"","params":""}', 1, 1337152878),
(36, 'vi', 'cac-trang-tinh', 'Các trang tĩnh', 9, NULL, NULL, 7, '', '{"controller":"staticPage","action":"index","description":"","params":"","modified":"{\\"1337153484\\":\\"1\\",\\"1337153531\\":\\"1\\",\\"1337153559\\":\\"1\\"}"}', 1, 1337152997),
(37, 'vi', 'quan-ly-cac-trang-tinh', 'Quản lý', 36, NULL, NULL, 1, '', '{"controller":"staticPage","action":"index","description":"","params":""}', 1, 1337153015),
(38, 'vi', 'tao-moi-cac-trang-tinh', 'Tạo mới', 36, NULL, NULL, 2, '', '{"controller":"staticPage","action":"create","description":"","params":""}', 1, 1337153028),
(39, 'vi', 'danh-muc-cac-trang-tinh', 'Danh mục', 36, NULL, NULL, 3, '', '{"controller":"staticPage","action":"manager_category","description":"","params":""}', 1, 1337153040),
(40, 'vi', 'don-hang', 'Đơn hàng', 27, NULL, NULL, 5, '', '{"controller":"order","action":"index","description":"","params":"","modified":"{\\"1337153449\\":\\"1\\",\\"1337153459\\":\\"1\\",\\"1337153484\\":\\"1\\",\\"1337153531\\":\\"1\\"}"}', 1, 1337153087),
(41, 'vi', 'album-anh', 'Album ảnh', 1, NULL, NULL, 6, '', '{"controller":"album","action":"index","description":"","params":"","modified":"{\\"1337153449\\":\\"1\\",\\"1337153459\\":\\"1\\",\\"1337153484\\":\\"1\\",\\"1337153531\\":\\"1\\",\\"1337153559\\":\\"1\\"}"}', 1, 1337153115),
(42, 'vi', 'quan-ly-album-anh', 'Quản lý', 41, NULL, NULL, 1, '', '{"controller":"album","action":"index","description":"","params":""}', 1, 1337153132),
(43, 'vi', 'tao-moi-album-anh', 'Tạo mới', 41, NULL, NULL, 2, '', '{"controller":"album","action":"create","description":"","params":""}', 1, 1337153144),
(44, 'vi', 'danh-muc-album-anh-3', 'Danh mục', 41, NULL, NULL, 3, '', '{"controller":"album","action":"manager_category","description":"","params":""}', 1, 1337153163),
(45, 'vi', 'video', 'Video', 1, NULL, NULL, 7, '', '{"controller":"galleryVideo","action":"index","description":"","params":"","modified":"{\\"1337153449\\":\\"1\\",\\"1337153459\\":\\"1\\",\\"1337153484\\":\\"1\\",\\"1337153531\\":\\"1\\",\\"1337153559\\":\\"1\\"}"}', 1, 1337153177),
(46, 'vi', 'quan-ly-video', 'Quản lý', 45, NULL, NULL, 1, '', '{"controller":"galleryVideo","action":"index","description":"","params":""}', 1, 1337153191),
(47, 'vi', 'tao-moi-video', 'Tạo mới', 45, NULL, NULL, 2, '', '{"controller":"galleryVideo","action":"create","description":"","params":""}', 1, 1337153206),
(48, 'vi', 'danh-muc-video-1', 'Danh mục', 45, NULL, NULL, 3, '', '{"controller":"galleryVideo","action":"manager_category","description":"","params":""}', 1, 1337153234),
(49, 'vi', 'hoi-dap', 'Hỏi đáp', 1, NULL, NULL, 4, '', '{"controller":"qa","action":"index","description":"","params":"","modified":"{\\"1337153449\\":\\"1\\",\\"1337153484\\":\\"1\\",\\"1337153531\\":\\"1\\",\\"1337153559\\":\\"1\\"}"}', 1, 1337153267),
(50, 'vi', 'lien-he', 'Liên hệ', 1, NULL, NULL, 5, '', '{"controller":"contact","action":"index","description":"","params":"","modified":"{\\"1337153449\\":\\"1\\",\\"1337153459\\":\\"1\\",\\"1337153484\\":\\"1\\",\\"1337153531\\":\\"1\\",\\"1337153559\\":\\"1\\"}"}', 1, 1337153287),
(51, 'vi', 'gioi-thieu', 'Giới thiệu', 3, NULL, 1, 1, '', '{"description":"Nh\\u00f3m c\\u00e1c b\\u00e0i vi\\u1ebft gi\\u1edbi thi\\u1ec7u website"}', 1, 1337156067),
(52, 'vi', 'huong-dan', 'Hướng dẫn', 3, NULL, 1, 2, '', '{"description":"Nh\\u00f3m c\\u00e1c b\\u00e0i vi\\u1ebft h\\u01b0\\u1edbng d\\u1eabn s\\u1eed d\\u1ee5ng website"}', 1, 1337156112),
(53, 'vi', 'danh-muc-goc', 'Danh mục gốc', 9, NULL, NULL, 8, '', '{"controller":"config","action":"root","description":"","params":""}', 1, 1337160203),
(54, 'vi', 'danh-muc-1', 'Danh mục 1', 4, NULL, 1, 1, '', '{"description":"Danh m\\u1ee5c 1\\r\\n"}', 1, 1337161176),
(55, 'vi', 'danh-muc-11', 'Danh mục 1.1', 54, NULL, 0, 1, '', '{"description":""}', 1, 1337161185),
(56, 'vi', 'danh-muc-12', 'Danh mục 1.2', 54, NULL, 0, 2, '', '{"description":""}', 1, 1337161192),
(57, 'vi', 'danh-muc-13', 'Danh mục 1.3', 54, NULL, 1, 3, '', '{"description":"","modified":"{\\"1337161205\\":\\"1\\"}"}', 1, 1337161200),
(58, 'vi', 'danh-muc-14', 'Danh mục 1.4', 54, NULL, 0, 4, '', '{"description":""}', 1, 1337161214),
(59, 'vi', 'danh-muc-15', 'Danh mục 1.5', 54, NULL, 0, 5, '', '{"description":""}', 1, 1337161240),
(60, 'vi', 'danh-muc-16', 'Danh mục 1.6', 54, NULL, 0, 6, '', '{"description":""}', 1, 1337161249),
(61, 'vi', 'danh-muc-2', 'Danh mục 2', 4, NULL, 1, 2, '', '{"description":""}', 1, 1337161255),
(62, 'vi', 'danh-muc-21', 'Danh mục 2.1', 61, NULL, 0, 1, '', '{"description":""}', 1, 1337161264),
(63, 'vi', 'danh-muc-22', 'Danh mục 2.2', 61, NULL, 0, 2, '', '{"description":""}', 1, 1337161271),
(64, 'vi', 'danh-muc-23', 'Danh mục 2.3', 61, NULL, 0, 3, '', '{"description":""}', 1, 1337161277),
(65, 'vi', 'danh-muc-3', 'Danh mục 3', 4, NULL, 1, 3, '', '{"description":""}', 1, 1337161284),
(66, 'vi', 'danh-muc-31', 'Danh mục 3.1', 65, NULL, 0, 1, '', '{"description":""}', 1, 1337161291),
(67, 'vi', 'danh-muc-32', 'Danh mục 3.2', 65, NULL, 0, 2, '', '{"description":""}', 1, 1337161301),
(68, 'vi', 'danh-muc-4', 'Danh mục 4', 4, NULL, 1, 4, '', '{"description":""}', 1, 1337161313),
(69, 'vi', 'danh-muc-41', 'Danh mục 4.1', 68, NULL, 0, 1, '', '{"description":""}', 1, 1337161326);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_image`
--

CREATE TABLE IF NOT EXISTS `tbl_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `title` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `parent_attribute` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(4) NOT NULL DEFAULT '0',
  `src` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `other` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_image`
--

INSERT INTO `tbl_image` (`id`, `status`, `title`, `url`, `category`, `parent_attribute`, `parent_id`, `src`, `filename`, `extension`, `other`, `created_by`, `created_date`) VALUES
(1, 1, NULL, NULL, 'StaticPage', 'introimage', 1, 'upload/2012/05/16', 'Chrysanthemum', 'jpg', '[]', 1, 1337156945),
(2, 1, NULL, NULL, 'StaticPage', 'introimage', 2, 'upload/2012/05/16', 'Penguins', 'jpg', '[]', 1, 1337157220),
(3, 1, NULL, NULL, 'StaticPage', 'introimage', 3, 'upload/2012/05/16', 'Penguins-18', 'jpg', 'null', 1, 1337157357),
(4, 1, NULL, NULL, 'StaticPage', 'introimage', 4, 'upload/2012/05/16', 'Lighthouse', 'jpg', '[]', 1, 1337158079),
(5, 1, NULL, NULL, 'Banner', 'images', 5, 'upload/2012/05/16', 'Chrysanthemum-23', 'jpg', '[]', 1, 1337158810),
(6, 1, NULL, NULL, 'Banner', 'images', 6, 'upload/2012/05/16', 'Tulips', 'jpg', '[]', 1, 1337158988),
(7, 1, NULL, NULL, 'Banner', 'images', 7, 'upload/2012/05/16', 'Chrysanthemum-16', 'jpg', '[]', 1, 1337159125),
(8, 1, NULL, NULL, 'Banner', 'images', 7, 'upload/2012/05/16', 'Desert', 'jpg', '[]', 1, 1337159126),
(9, 1, NULL, NULL, 'Banner', 'images', 7, 'upload/2012/05/16', 'Hydrangeas', 'jpg', '[]', 1, 1337159126),
(10, 1, NULL, NULL, 'Banner', 'images', 7, 'upload/2012/05/16', 'Koala', 'jpg', '[]', 1, 1337159126),
(11, 1, NULL, NULL, 'Banner', 'images', 7, 'upload/2012/05/16', 'Lighthouse-78', 'jpg', '[]', 1, 1337159126),
(12, 1, NULL, NULL, 'Banner', 'images', 7, 'upload/2012/05/16', 'Penguins-95', 'jpg', '[]', 1, 1337159127);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE IF NOT EXISTS `tbl_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `origin` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `translation` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=52 ;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`id`, `lang`, `origin`, `translation`, `module`, `controller`, `action`) VALUES
(1, 'vi', 'Trang chủ', '', '', 'site', 'home'),
(2, 'vi', 'Sản phẩm mới', '', '', 'site', 'home'),
(3, 'vi', 'Tin tức mới', '', '', 'site', 'home'),
(4, 'vi', '1', '', '', 'site', 'home'),
(5, 'vi', 'Liên hệ qua Email', '', '', 'site', 'home'),
(6, 'vi', 'Ngôn ngữ', '', '', 'site', 'home'),
(7, 'vi', 'Hotline', '', '', 'site', 'home'),
(8, 'vi', 'Giỏ hàng', '', '', 'site', 'home'),
(9, 'vi', 'Danh mục menu trang quản trị', '', '', 'site', 'home'),
(10, 'vi', 'Hệ thống', '', '', 'site', 'home'),
(11, 'vi', 'Cấu hình', '', '', 'site', 'home'),
(12, 'vi', 'Chỉnh sửa', '', '', 'site', 'home'),
(13, 'vi', 'Trang quản trị', '', '', 'site', 'home'),
(14, 'vi', 'Tạo mới', '', '', 'site', 'home'),
(15, 'vi', 'Thêm mới', '', '', 'site', 'home'),
(16, 'vi', 'Quản lý', '', '', 'site', 'home'),
(17, 'vi', 'Giới thiệu', '', '', 'site', 'home'),
(18, 'vi', 'Danh mục menu trang front end', '', '', 'site', 'home'),
(19, 'vi', 'Trang frontend', '', '', 'site', 'home'),
(20, 'vi', 'Sản phẩm', '', '', 'site', 'home'),
(21, 'vi', 'Hướng dẫn', '', '', 'site', 'home'),
(22, 'vi', 'Danh mục trang tĩnh', '', '', 'site', 'home'),
(23, 'vi', 'Xóa', '', '', 'site', 'home'),
(24, 'vi', 'Dọn dẹp', '', '', 'site', 'home'),
(25, 'vi', 'Danh mục', '', '', 'site', 'home'),
(26, 'vi', 'Tin tức', '', '', 'site', 'home'),
(27, 'vi', 'Danh mục tin tức', '', '', 'site', 'home'),
(28, 'vi', 'Nhập dữ liệu từ file excel', '', '', 'site', 'home'),
(29, 'vi', 'Menu', '', '', 'site', 'home'),
(30, 'vi', 'Nhà sản xuất', '', '', 'site', 'home'),
(31, 'vi', 'Hỏi đáp', '', '', 'site', 'home'),
(32, 'vi', 'Danh mục sản phẩm', '', '', 'site', 'home'),
(33, 'vi', 'Xuất dữ liệu ra file excel', '', '', 'site', 'home'),
(34, 'vi', 'Banner quảng cáo', '', '', 'site', 'home'),
(35, 'vi', 'Đơn hàng', '', '', 'site', 'home'),
(36, 'vi', 'Liên hệ', '', '', 'site', 'home'),
(37, 'vi', 'Danh mục nhà sản xuất', '', '', 'site', 'home'),
(38, 'vi', 'User', '', '', 'site', 'home'),
(39, 'vi', 'Album ảnh', '', '', 'site', 'home'),
(40, 'vi', 'Danh mục album ảnh', '', '', 'site', 'home'),
(41, 'vi', 'Các trang tĩnh', '', '', 'site', 'home'),
(42, 'vi', 'Video', '', '', 'site', 'home'),
(43, 'vi', 'Danh mục video', '', '', 'site', 'home'),
(44, 'vi', 'Hướng dẫn mua hàng', '', '', 'site', 'home'),
(45, 'vi', 'Phương thức thanh toán', '', '', 'site', 'home'),
(46, 'vi', 'Sản phẩm nổi bật', '', '', 'site', 'home'),
(47, 'vi', 'Đang online', '', '', 'site', 'home'),
(48, 'vi', 'Showroom', '', '', 'site', 'home'),
(49, 'vi', 'Tel/Fax', '', '', 'site', 'home'),
(50, 'vi', 'Mobile', '', '', 'site', 'home'),
(51, 'vi', 'Email', '', '', 'site', 'home');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE IF NOT EXISTS `tbl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'vi',
  `status` tinyint(1) NOT NULL,
  `process_status` tinyint(1) NOT NULL,
  `special` tinyint(4) DEFAULT NULL,
  `other` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_order`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE IF NOT EXISTS `tbl_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'vi',
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `catid` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `amount_status` tinyint(1) NOT NULL DEFAULT '1',
  `special` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `num_price` int(11) NOT NULL,
  `alias` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `other` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE IF NOT EXISTS `tbl_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `name`, `value`, `module`, `controller`, `action`) VALUES
(1, 'ADMIN_LANGUAGE', 'vi', 'admin', 'category', ''),
(2, 'SIZE_REMARK_PRODUCT', '1', '', 'site', 'home'),
(3, 'SIZE_HOME_NEWS', '1', '', 'site', 'home'),
(4, 'META_AUTHOR', '1', '', 'site', 'home'),
(5, 'META_COPYRIGHT', '1', '', 'site', 'home'),
(6, 'META_KEYWORD', '1', '', 'site', 'home'),
(7, 'META_DESCRIPTION', '1', '', 'site', 'home'),
(8, 'FRONT_SITE_TITLE', '1', '', 'site', 'home'),
(9, 'EMAIL_CONTACT', '1', '', 'site', 'home'),
(10, 'HOTLINE', '1', '', 'site', 'home'),
(11, 'COMPANY', '1', '', 'site', 'home'),
(12, 'ADDRESS_SHOWROOM', '1', '', 'site', 'home'),
(13, 'TEL/FAX', '1', '', 'site', 'home'),
(14, 'MOBILE', '1', '', 'site', 'home'),
(15, 'EMAIL', '1', '', 'site', 'home'),
(16, 'DESIGN_BY', '1', '', 'site', 'home');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `other` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `salt`, `status`, `email`, `other`) VALUES
(1, 'admin', '068bf8c42edece5daa08c9ec0dc0b317', '4f570d19da3d07.31748483', 1, 'kythuat@ihbvietnam.com', '{"phone":"0906244804","address":"Truong Son, An Lao, Hai Phong","firstname":"YHCT","lastname":"YHCT","register_date":1331006642,"last_visit_date":1331006642}');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
