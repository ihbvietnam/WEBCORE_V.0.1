-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 04, 2012 at 06:25 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phoenix`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `lang` smallint(6) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL,
  `special` tinyint(4) NOT NULL DEFAULT '0',
  `order_view` int(11) NOT NULL DEFAULT '0',
  `title` varchar(256) NOT NULL,
  `alias` varchar(256) NOT NULL,
  `keywords` varchar(512) NOT NULL,
  `other` text NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
('updateOwn', 1, 'update a post by author himself', 'return Yii::app()->user->id==$params["post"]->created_by;', 'N;'),
('update', 0, 'update a post', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `authitemchild`
--

CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authitemchild`
--

INSERT INTO `authitemchild` (`parent`, `child`) VALUES
('admin', 'author'),
('admin', 'delete'),
('admin', 'editor'),
('admin', 'manager_account'),
('author', 'create'),
('author', 'updateOwn'),
('editor', 'update'),
('manager_account', 'managerAccount'),
('update', 'create'),
('updateOwn', 'update');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `lang` smallint(6) NOT NULL DEFAULT '0',
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) DEFAULT NULL,
  `special` tinyint(4) DEFAULT NULL,
  `order_view` smallint(6) NOT NULL DEFAULT '1',
  `keywords` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `other` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `alias`, `lang`, `name`, `parent_id`, `child_id`, `special`, `order_view`, `keywords`, `other`, `created_by`) VALUES
(1, 'quan-ly-menu-trang-quan-tri', 0, 'Quản lý menu trang quản trị', 0, NULL, NULL, 1, '', '{"max_rank":"3","description":"Qu\\u1ea3n l\\u00fd menu trang qu\\u1ea3n tr\\u1ecb ","created_date":1332903011}', 12),
(2, 'quan-ly-menu-trang-hien-thi', 0, 'Quản lý menu trang hiển thị', 0, NULL, NULL, 2, '', '{"max_rank":"3","description":"Qu\\u1ea3n l\\u00fd menu trang hi\\u1ec3n th\\u1ecb","created_date":1332903057,"modified":"{\\"1332903474\\":\\"12\\"}"}', 12),
(3, 'quan-ly-danh-muc-tin-tuc', 0, 'Quản lý danh mục tin tức', 0, NULL, NULL, 3, '', '{"max_rank":"3","description":"Qu\\u1ea3n l\\u00fd danh m\\u1ee5c tin t\\u1ee9c","created_date":1332903214}', 12),
(4, 'quan-tri-he-thong', 0, 'Quản trị hệ thống', 1, NULL, NULL, 1, '', '{"controller":"config","action":"menu","params":"{\\"group\\":1}","description":"Qu\\u1ea3n tr\\u1ecb h\\u1ec7 th\\u1ed1ng","created_date":1332903517}', 12),
(5, 'quan-tri-menu', 0, 'Quản trị menu', 4, NULL, NULL, 2, '', '{"controller":"config","action":"menu","params":"{\\"group\\":1}","description":"","created_date":1332903631,"modified":"{\\"1332903824\\":\\"12\\",\\"1333737009\\":\\"12\\",\\"1333737015\\":\\"12\\"}"}', 12),
(6, 'don-dep-he-thong', 0, 'Dọn dẹp hệ thống', 4, NULL, NULL, 1, '', '{"controller":"config","action":"clear_image","description":"","params":"","created_date":1332903671,"modified":"{\\"1332903824\\":\\"12\\"}"}', 12),
(7, 'don-dep-anh-rac', 0, 'Dọn dẹp ảnh rác', 6, NULL, NULL, 1, '', '{"controller":"config","action":"clear_image","description":"","params":"","created_date":1332903695}', 12),
(8, 'menu-trang-quan-tri', 0, 'Menu trang quản trị', 5, NULL, NULL, 1, '', '{"controller":"config","action":"menu","params":"{\\"group\\":1}","description":"","created_date":1332903781,"modified":"{\\"1332903853\\":\\"12\\",\\"1333091541\\":\\"12\\",\\"1333091588\\":\\"12\\",\\"1336126815\\":\\"1\\",\\"1336126843\\":\\"1\\"}"}', 12),
(9, 'menu-trang-frontend', 0, 'Menu trang frontend', 5, NULL, NULL, 2, '', '{"controller":"config","action":"menu","params":"{\\"group\\":2}","description":"","created_date":1332903802,"modified":"{\\"1332903853\\":\\"12\\",\\"1333091551\\":\\"12\\",\\"1336126805\\":\\"1\\",\\"1336126815\\":\\"1\\",\\"1336126902\\":\\"1\\",\\"1336126931\\":\\"1\\"}"}', 12),
(10, 'quan-tri-user', 0, 'Quản trị user', 1, NULL, NULL, 2, '', '{"controller":"user","action":"index","description":"","params":"","created_date":1332903891,"modified":"{\\"1332904074\\":\\"12\\"}"}', 12),
(11, 'danh-sach-user', 0, 'Danh sách user', 10, NULL, NULL, 1, '', '{"controller":"user","action":"index","description":"","params":"","created_date":1332904104}', 12),
(12, 'them-user', 0, 'Thêm user', 10, NULL, NULL, 2, '', '{"controller":"user","action":"create","description":"","params":"","created_date":1332904116}', 12),
(13, 'quan-tri-bai-viet', 0, 'Quản trị bài viết', 1, NULL, NULL, 3, '', '{"controller":"news","action":"index","description":"","params":"","created_date":1332904144}', 12),
(14, 'danh-sach-bai-viet', 0, 'Danh sách bài viết', 13, NULL, NULL, 1, '', '{"controller":"news","action":"index","description":"","params":"","created_date":1332904163}', 12),
(15, 'tao-bai-viet-moi', 0, 'Tạo bài viết mới', 13, NULL, NULL, 2, '', '{"controller":"news","action":"create","description":"","params":"","created_date":1332904178}', 12),
(16, 'danh-muc-tieng-viet', 0, 'Danh mục tiếng việt', 106, NULL, NULL, 1, '', '{"controller":"news","action":"manager_category_vi","description":"","params":"","created_date":1332904205,"modified":"{\\"1333704719\\":\\"12\\",\\"1333704803\\":\\"12\\",\\"1333704808\\":\\"12\\",\\"1333704871\\":\\"12\\"}"}', 12),
(17, 'quan-tri-lien-he--hoi-dap-', 0, 'Quản trị liên hệ & hỏi đáp ', 1, NULL, NULL, 4, '', '{"controller":"qa","action":"index","description":"","params":"","created_date":1332904285}', 12),
(18, 'quan-tri-hoi-dap', 0, 'Quản trị hỏi đáp', 17, NULL, NULL, 1, '', '{"controller":"qa","action":"index","description":"","params":"","created_date":1332904297}', 12),
(19, 'quan-tri-thu-lien-he', 0, 'Quản trị thư liên hệ', 17, NULL, NULL, 2, '', '{"controller":"contact","action":"index","description":"","params":"","created_date":1332904320,"modified":"{\\"1332904326\\":\\"12\\",\\"1332904388\\":\\"12\\",\\"1332904402\\":\\"12\\"}"}', 12),
(20, 'quan-tri-don-dang-ki-hoc', 0, 'Quản trị đơn đăng kí học', 17, NULL, NULL, 3, '', '{"controller":"register","action":"index","description":"","params":"","created_date":1332904434}', 12),
(21, 'quan-tri-bo-suu-tap', 0, 'Quản trị bộ sưu tập', 1, NULL, NULL, 5, '', '{"controller":"album","action":"index","description":"","params":"","created_date":1332904460}', 12),
(22, 'quan-tri-album', 0, 'Quản trị album', 21, NULL, NULL, 1, '', '{"controller":"album","action":"index","description":"","params":"","created_date":1332904475}', 12),
(23, 'danh-sach-album', 0, 'Danh sách album', 22, NULL, NULL, 1, '', '{"controller":"album","action":"index","description":"","params":"","created_date":1332904513}', 12),
(24, 'them-album-moi', 0, 'Thêm album mới', 22, NULL, NULL, 2, '', '{"controller":"album","action":"create","description":"","params":"","created_date":1332904530}', 12),
(25, 'quan-tri-video', 0, 'Quản trị video', 21, NULL, NULL, 2, '', '{"controller":"galleryVideo","action":"index","description":"","params":"","created_date":1332904546}', 12),
(26, 'danh-sach-video', 0, 'Danh sách video', 25, NULL, NULL, 1, '', '{"controller":"galleryVideo","action":"index","description":"","params":"","created_date":1332904563}', 12),
(27, 'them-video', 0, 'Thêm video', 25, NULL, NULL, 2, '', '{"controller":"galleryVideo","action":"create","description":"","params":"","created_date":1332904579}', 12),
(28, 'quan-tri-banner-quang-cao', 0, 'Quản trị banner quảng cáo', 21, NULL, NULL, 3, '', '{"controller":"banner","action":"index","description":"","params":"","created_date":1332904617,"modified":"{\\"1332904651\\":\\"12\\",\\"1332904653\\":\\"12\\"}"}', 12),
(29, 'danh-sach-banner-quang-cao', 0, 'Danh sách banner quảng cáo', 28, NULL, NULL, 1, '', '{"controller":"banner","action":"index","description":"","params":"","created_date":1332904703,"modified":"{\\"1332904711\\":\\"12\\"}"}', 12),
(31, 'gioi-thieu', 0, 'Giới thiệu', 3, NULL, 1, 6, '', '{"description":"","created_date":1332904975,"modified":"{\\"1332905230\\":\\"12\\",\\"1333536138\\":\\"12\\",\\"1333702687\\":\\"12\\",\\"1333702700\\":\\"12\\",\\"1333703294\\":\\"12\\",\\"1333954957\\":\\"12\\",\\"1333954961\\":\\"12\\",\\"1333956924\\":\\"12\\",\\"1334141359\\":\\"12\\",\\"1334141396\\":\\"12\\",\\"1334141416\\":\\"12\\",\\"1334141430\\":\\"12\\",\\"1334141448\\":\\"12\\"}"}', 12);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `image`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `status`, `email`, `other`) VALUES
(1, 'admin', '068bf8c42edece5daa08c9ec0dc0b317', '4f570d19da3d07.31748483', 1, 'kythuat@ihbvietnam.com', '{"phone":"0906244804","address":"Truong Son, An Lao, Hai Phong","firstname":"YHCT","lastname":"YHCT","register_date":1331006642,"last_visit_date":1331006642}');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
