-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2012 at 03:34 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_article`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

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
(31, 'vi', 'nha-san-xuat', 'Nhà sản xuất', 27, NULL, NULL, 4, '', '{"controller":"product","action":"manufacturer","description":"","params":""}', 1, 1337152496),
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
(50, 'vi', 'lien-he', 'Liên hệ', 1, NULL, NULL, 5, '', '{"controller":"contact","action":"index","description":"","params":"","modified":"{\\"1337153449\\":\\"1\\",\\"1337153459\\":\\"1\\",\\"1337153484\\":\\"1\\",\\"1337153531\\":\\"1\\",\\"1337153559\\":\\"1\\"}"}', 1, 1337153287);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_image`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`id`, `lang`, `origin`, `translation`, `module`, `controller`, `action`) VALUES
(1, '1', 'Tên tham số', '', 'admin', 'setting', 'index'),
(2, '1', 'Giá trị', '', 'admin', 'setting', 'index');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `name`, `value`, `module`, `controller`, `action`) VALUES
(1, 'ADMIN_LANGUAGE', '1', 'admin', 'category', '');

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
