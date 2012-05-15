-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 10, 2012 at 08:38 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dogo`
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
-- Table structure for table `tbl_article`
--

CREATE TABLE IF NOT EXISTS `tbl_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `lang` smallint(6) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `special` tinyint(4) NOT NULL DEFAULT '0',
  `order_view` int(11) NOT NULL DEFAULT '0',
  `title` varchar(256) NOT NULL,
  `alias` varchar(256) NOT NULL,
  `keywords` varchar(512) NOT NULL,
  `other` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_article`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
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
  `created_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=58 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `alias`, `lang`, `name`, `parent_id`, `child_id`, `special`, `order_view`, `keywords`, `other`, `created_by`, `created_date`) VALUES
(1, 'quan-ly-menu-trang-quan-tri', 0, 'Quản lý menu trang quản trị', 0, NULL, NULL, 1, '', '{"max_rank":"3","description":"Qu\\u1ea3n l\\u00fd menu trang qu\\u1ea3n tr\\u1ecb ","created_date":1332903011}', 1, 1336612722),
(2, 'quan-ly-menu-trang-hien-thi', 0, 'Quản lý menu trang hiển thị', 0, NULL, NULL, 2, '', '{"max_rank":"3","description":"Qu\\u1ea3n l\\u00fd menu trang hi\\u1ec3n th\\u1ecb","created_date":1332903057,"modified":"{\\"1332903474\\":\\"12\\"}"}', 1, 1336612722),
(3, 'quan-ly-danh-muc-tin-tuc', 0, 'Quản lý danh mục tin tức', 0, NULL, NULL, 3, '', '{"max_rank":"3","description":"Qu\\u1ea3n l\\u00fd danh m\\u1ee5c tin t\\u1ee9c","created_date":1332903214}', 1, 1336612722),
(31, 'he-thong', 0, 'Hệ thống', 1, NULL, NULL, 1, '', '{"controller":"config","action":"menu","params":"{\\"group\\":1}","description":"Qu\\u1ea3n tr\\u1ecb h\\u1ec7 th\\u1ed1ng","created_date":1332903517,"modified":"{\\"1336216659\\":\\"1\\",\\"1336613220\\":\\"1\\"}"}', 1, 1336612722),
(32, 'menu', 0, 'Menu', 31, NULL, NULL, 4, '', '{"controller":"config","action":"menu","params":"{\\"group\\":1}","description":"","created_date":1332903631,"modified":"{\\"1332903824\\":\\"12\\",\\"1333737009\\":\\"12\\",\\"1333737015\\":\\"12\\",\\"1336612491\\":\\"1\\",\\"1336612617\\":\\"1\\",\\"1336612804\\":\\"1\\"}"}', 1, 1336612722),
(6, 'don-dep', 0, 'Dọn dẹp', 31, NULL, NULL, 3, '', '{"controller":"config","action":"clear_image","description":"","params":"","created_date":1332903671,"modified":"{\\"1332903824\\":\\"12\\",\\"1336612491\\":\\"1\\",\\"1336612617\\":\\"1\\",\\"1336612797\\":\\"1\\"}"}', 1, 1336612722),
(7, 'anh-rac', 0, 'Ảnh rác', 6, NULL, NULL, 1, '', '{"controller":"config","action":"clear_image","description":"","params":"","created_date":1332903695,"modified":"{\\"1336612767\\":\\"1\\"}"}', 1, 1336612722),
(8, 'trang-quan-tri', 0, 'Trang quản trị', 32, NULL, NULL, 1, '', '{"controller":"config","action":"menu","params":"{\\"group\\":1}","description":"","created_date":1332903781,"modified":"{\\"1332903853\\":\\"12\\",\\"1333091541\\":\\"12\\",\\"1333091588\\":\\"12\\",\\"1336126815\\":\\"1\\",\\"1336126843\\":\\"1\\",\\"1336612776\\":\\"1\\"}"}', 1, 1336612722),
(9, 'trang-frontend', 0, 'Trang frontend', 32, NULL, NULL, 2, '', '{"controller":"config","action":"menu","params":"{\\"group\\":2}","description":"","created_date":1332903802,"modified":"{\\"1332903853\\":\\"12\\",\\"1333091551\\":\\"12\\",\\"1336126805\\":\\"1\\",\\"1336126815\\":\\"1\\",\\"1336126902\\":\\"1\\",\\"1336126931\\":\\"1\\",\\"1336612782\\":\\"1\\"}"}', 1, 1336612722),
(10, 'user', 0, 'User', 31, NULL, NULL, 5, '', '{"controller":"user","action":"index","description":"","params":"","created_date":1332903891,"modified":"{\\"1332904074\\":\\"12\\",\\"1336214993\\":\\"1\\",\\"1336215008\\":\\"1\\",\\"1336612491\\":\\"1\\",\\"1336612617\\":\\"1\\",\\"1336612827\\":\\"1\\"}"}', 1, 1336612722),
(11, 'danh-sach-22', 0, 'Danh sách', 10, NULL, NULL, 1, '', '{"controller":"user","action":"index","description":"","params":"","created_date":1332904104,"modified":"{\\"1336612833\\":\\"1\\"}"}', 1, 1336612722),
(12, 'tao-moi-20', 0, 'Tạo mới', 10, NULL, NULL, 2, '', '{"controller":"user","action":"create","description":"","params":"","created_date":1332904116,"modified":"{\\"1336612839\\":\\"1\\",\\"1336612868\\":\\"1\\"}"}', 1, 1336612722),
(13, 'bai-viet', 0, 'Bài viết', 1, NULL, NULL, 2, '', '{"controller":"news","action":"index","description":"","params":"","created_date":1332904144,"modified":"{\\"1336214993\\":\\"1\\",\\"1336216648\\":\\"1\\",\\"1336216659\\":\\"1\\",\\"1336613271\\":\\"1\\"}"}', 1, 1336612722),
(14, 'danh-sach-25', 0, 'Danh sách', 13, NULL, NULL, 1, '', '{"controller":"news","action":"index","description":"","params":"","created_date":1332904163,"modified":"{\\"1336612848\\":\\"1\\"}"}', 1, 1336612722),
(15, 'tao-moi-79', 0, 'Tạo mới', 13, NULL, NULL, 2, '', '{"controller":"news","action":"create","description":"","params":"","created_date":1332904178,"modified":"{\\"1336612858\\":\\"1\\"}"}', 1, 1336612722),
(16, 'danh-muc-tieng-viet', 0, 'Danh mục tiếng việt', 106, NULL, NULL, 1, '', '{"controller":"news","action":"manager_category_vi","description":"","params":"","created_date":1332904205,"modified":"{\\"1333704719\\":\\"12\\",\\"1333704803\\":\\"12\\",\\"1333704808\\":\\"12\\",\\"1333704871\\":\\"12\\"}"}', 1, 1336612722),
(17, 'lien-he--hoi-dap-', 0, 'Liên hệ & hỏi đáp ', 1, NULL, NULL, 5, '', '{"controller":"qa","action":"index","description":"","params":"","created_date":1332904285,"modified":"{\\"1336214993\\":\\"1\\",\\"1336216648\\":\\"1\\",\\"1336216672\\":\\"1\\",\\"1336613323\\":\\"1\\"}"}', 1, 1336612722),
(18, 'hoi-dap', 0, 'Hỏi đáp', 17, NULL, NULL, 1, '', '{"controller":"qa","action":"index","description":"","params":"","created_date":1332904297,"modified":"{\\"1336612919\\":\\"1\\"}"}', 1, 1336612722),
(19, 'lien-he', 0, 'Liên hệ', 17, NULL, NULL, 2, '', '{"controller":"contact","action":"index","description":"","params":"","created_date":1332904320,"modified":"{\\"1332904326\\":\\"12\\",\\"1332904388\\":\\"12\\",\\"1332904402\\":\\"12\\",\\"1336612927\\":\\"1\\"}"}', 1, 1336612722),
(20, 'xuat-du-lieu-ra-file-excel', 0, 'Xuất dữ liệu ra file excel', 46, NULL, NULL, 5, '', '{"controller":"language","action":"export","description":"","params":""}', 1, 1336612722),
(21, 'bo-suu-tap', 0, 'Bộ sưu tập', 1, NULL, NULL, 6, '', '{"controller":"album","action":"index","description":"","params":"","created_date":1332904460,"modified":"{\\"1336214993\\":\\"1\\",\\"1336216648\\":\\"1\\",\\"1336216672\\":\\"1\\",\\"1336613333\\":\\"1\\"}"}', 1, 1336612722),
(22, 'album', 0, 'Album', 21, NULL, NULL, 1, '', '{"controller":"album","action":"index","description":"","params":"","created_date":1332904475,"modified":"{\\"1336613340\\":\\"1\\"}"}', 1, 1336612722),
(23, 'danh-sach-59', 0, 'Danh sách', 22, NULL, NULL, 1, '', '{"controller":"album","action":"index","description":"","params":"","created_date":1332904513,"modified":"{\\"1336613347\\":\\"1\\"}"}', 1, 1336612722),
(24, 'tao-moi-27', 0, 'Tạo mới', 22, NULL, NULL, 2, '', '{"controller":"album","action":"create","description":"","params":"","created_date":1332904530,"modified":"{\\"1336613354\\":\\"1\\",\\"1336613385\\":\\"1\\"}"}', 1, 1336612722),
(25, 'video', 0, 'Video', 21, NULL, NULL, 2, '', '{"controller":"galleryVideo","action":"index","description":"","params":"","created_date":1332904546,"modified":"{\\"1336613363\\":\\"1\\"}"}', 1, 1336612722),
(26, 'danh-sach-22-28', 0, 'Danh sách', 25, NULL, NULL, 1, '', '{"controller":"galleryVideo","action":"index","description":"","params":"","created_date":1332904563,"modified":"{\\"1336613369\\":\\"1\\"}"}', 1, 1336612722),
(27, 'tao-moi-17', 0, 'Tạo mới', 25, NULL, NULL, 2, '', '{"controller":"galleryVideo","action":"create","description":"","params":"","created_date":1332904579,"modified":"{\\"1336613377\\":\\"1\\"}"}', 1, 1336612722),
(28, 'banner-quang-cao', 0, 'Banner quảng cáo', 31, NULL, NULL, 4, '', '{"controller":"banner","action":"index","description":"","params":"","created_date":1332904617,"modified":"{\\"1332904651\\":\\"12\\",\\"1332904653\\":\\"12\\",\\"1336214593\\":\\"1\\",\\"1336214964\\":\\"1\\",\\"1336215008\\":\\"1\\",\\"1336612491\\":\\"1\\",\\"1336612617\\":\\"1\\",\\"1336612813\\":\\"1\\"}"}', 1, 1336612722),
(29, 'danh-sach-8', 0, 'Danh sách', 28, NULL, NULL, 1, '', '{"controller":"banner","action":"index","description":"","params":"","created_date":1332904703,"modified":"{\\"1332904711\\":\\"12\\",\\"1336612820\\":\\"1\\"}"}', 1, 1336612722),
(30, 'gioi-thieu', 0, 'Giới thiệu', 3, NULL, 1, 6, '', '{"description":"","created_date":1332904975,"modified":"{\\"1332905230\\":\\"12\\",\\"1333536138\\":\\"12\\",\\"1333702687\\":\\"12\\",\\"1333702700\\":\\"12\\",\\"1333703294\\":\\"12\\",\\"1333954957\\":\\"12\\",\\"1333954961\\":\\"12\\",\\"1333956924\\":\\"12\\",\\"1334141359\\":\\"12\\",\\"1334141396\\":\\"12\\",\\"1334141416\\":\\"12\\",\\"1334141430\\":\\"12\\",\\"1334141448\\":\\"12\\"}"}', 1, 1336612722),
(4, 'quan-ly-danh-muc-san-pham', 0, 'Quản lý danh mục sản phẩm', 0, NULL, NULL, 4, '', '{"max_rank":"3","description":"","created_date":1332998910}', 1, 1336612722),
(5, 'quan-ly-danh-muc-nha-san-xuat', 0, 'Quản lý danh mục nhà sản xuất', 0, NULL, NULL, 5, '', '{"max_rank":"2","description":"","created_date":1332998922}', 1, 1336612722),
(34, 'menu-trang-quan-tri-9', 0, 'Menu trang quản trị', 33, NULL, NULL, 1, '', '{"controller":"config","action":"menu","params":"{\\"group\\":1}","description":"","created_date":1336214722}', 1, 1336612722),
(35, 'menu-trang-frontend-21', 0, 'Menu trang frontend', 33, NULL, NULL, 2, '', '{"controller":"config","action":"menu","params":"{\\"group\\":2}","description":"","created_date":1336214747}', 1, 1336612722),
(37, 'san-pham', 0, 'Sản phẩm', 1, NULL, NULL, 3, '', '{"controller":"product","action":"index","description":"","params":"","created_date":1336216438,"modified":"{\\"1336216648\\":\\"1\\",\\"1336216659\\":\\"1\\",\\"1336613278\\":\\"1\\"}"}', 1, 1336612722),
(38, 'danh-sach-84', 0, 'Danh sách', 37, NULL, NULL, 1, '', '{"controller":"product","action":"index","description":"","params":"","created_date":1336216465,"modified":"{\\"1336612876\\":\\"1\\"}"}', 1, 1336612722),
(39, 'tao-moi-26', 0, 'Tạo mới', 37, NULL, NULL, 2, '', '{"controller":"product","action":"create","description":"","params":"","created_date":1336216497,"modified":"{\\"1336612891\\":\\"1\\"}"}', 1, 1336612722),
(40, 'danh-muc', 0, 'Danh mục', 37, NULL, NULL, 3, '', '{"controller":"product","action":"manager_category","description":"","params":"","created_date":1336216544,"modified":"{\\"1336612898\\":\\"1\\"}"}', 1, 1336612722),
(41, 'nha-san-xuat', 0, 'Nhà sản xuất', 37, NULL, NULL, 4, '', '{"controller":"manufacturer","action":"manager_category","description":"","params":"","created_date":1336216598,"modified":"{\\"1336612905\\":\\"1\\"}"}', 1, 1336612722),
(42, 'don-hang', 0, 'Đơn hàng', 1, NULL, NULL, 4, '', '{"controller":"order","action":"index","description":"","params":"","created_date":1336216631,"modified":"{\\"1336216648\\":\\"1\\",\\"1336216672\\":\\"1\\",\\"1336216675\\":\\"1\\",\\"1336613288\\":\\"1\\",\\"1336613304\\":\\"1\\"}"}', 1, 1336612722),
(43, 'tham-so-cau-hinh', 0, 'Tham số cấu hình', 31, NULL, NULL, 1, '', '{"controller":"setting","action":"index","description":"","params":"","modified":"{\\"1336612491\\":\\"1\\",\\"1336613260\\":\\"1\\",\\"1336617172\\":\\"1\\"}"}', 1, 1336612722),
(44, 'danh-sach', 0, 'Danh sách', 43, NULL, NULL, 1, '', '{"controller":"setting","action":"index","description":"","params":"","modified":"{\\"1336612734\\":\\"1\\"}"}', 1, 1336612722),
(45, 'them-moi', 0, 'Thêm mới', 43, NULL, NULL, 2, '', '{"controller":"setting","action":"create","description":"","params":"","modified":"{\\"1336612742\\":\\"1\\"}"}', 1, 1336612722),
(46, 'ngon-ngu', 0, 'Ngôn ngữ', 31, NULL, NULL, 2, '', '{"controller":"language","action":"edit","description":"","params":"","modified":"{\\"1336612617\\":\\"1\\"}"}', 1, 1336612722),
(47, 'chinh-sua', 0, 'Chỉnh sửa', 46, NULL, NULL, 1, '', '{"controller":"language","action":"edit","description":"","params":"","modified":"{\\"1336612748\\":\\"1\\"}"}', 1, 1336612722),
(48, 'tao-moi', 0, 'Tạo mới', 46, NULL, NULL, 2, '', '{"controller":"language","action":"create","description":"","params":""}', 1, 1336612722),
(49, 'xoa', 0, 'Xóa', 46, NULL, NULL, 3, '', '{"controller":"language","action":"delete","description":"","params":""}', 1, 1336612722),
(50, 'nhap-du-lieu-tu-file-excel', 0, 'Nhập dữ liệu từ file excel', 46, NULL, NULL, 4, '', '{"controller":"language","action":"import","description":"","params":""}', 1, 1336612722),
(52, 'trang-chu', 0, 'Trang chủ', 2, NULL, NULL, 1, '', '{"controller":"product","action":"present","description":"","params":""}', 1, 1336650918),
(53, 'gioi-thieu-23', 0, 'Giới thiệu', 2, NULL, NULL, 2, '', '{"controller":"news","action":"present","description":"","params":""}', 1, 1336651409),
(54, 'tin-tuc', 0, 'Tin tức', 2, NULL, NULL, 3, '', '{"controller":"news","action":"view_category","params":"{\\"cat_alias\\":\\"gioi-thieu\\"}","description":""}', 1, 1336651433),
(55, 'san-pham-99', 0, 'Sản phẩm', 2, NULL, NULL, 4, '', '{"controller":"product","action":"present","description":"","params":""}', 1, 1336651458),
(56, 'lien-he-23', 0, 'Liên hệ', 2, NULL, NULL, 5, '', '{"controller":"contact","action":"view_contact","description":"","params":""}', 1, 1336651489),
(57, 'hoi-dap-61', 0, 'Hỏi đáp', 2, NULL, NULL, 6, '', '{"controller":"qa","action":"view_qa","description":"","params":""}', 1, 1336651499);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE IF NOT EXISTS `tbl_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) CHARACTER SET utf8 NOT NULL,
  `origin` varchar(1024) CHARACTER SET utf8 NOT NULL,
  `translation` varchar(1024) CHARACTER SET utf8 NOT NULL,
  `module` varchar(32) CHARACTER SET utf8 NOT NULL,
  `controller` varchar(32) CHARACTER SET utf8 NOT NULL,
  `action` varchar(32) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`id`, `lang`, `origin`, `translation`, `module`, `controller`, `action`) VALUES
(1, 'vi', 'Tên tham số', '', 'admin', 'setting', 'create'),
(2, 'vi', 'Giá trị', '', 'admin', 'setting', 'create'),
(3, 'vi', 'quản trị các tham số cấu hình', '', 'admin', 'setting', 'update'),
(4, 'vi', 'Chỉnh sửa các tham số cấu hình', '', 'admin', 'setting', 'update'),
(5, 'vi', 'Thêm tham số cấu hình', '', 'admin', 'setting', 'update'),
(6, 'vi', 'Danh sách tham số cấu hình', '', 'admin', 'setting', 'update'),
(7, 'vi', 'Tên tham số', '', 'admin', 'setting', 'update'),
(8, 'vi', 'Giá trị', '', 'admin', 'setting', 'update'),
(9, 'vi', 'Hủy thao tác', '', 'admin', 'setting', 'update'),
(10, 'vi', 'Tạo', '', 'admin', 'setting', 'update'),
(11, 'vi', 'Đồ gỗ nội thất', '', '', 'site', 'home'),
(12, 'vi', 'Liên hệ qua Email', '', '', 'site', 'home'),
(13, 'vi', 'Ngôn ngữ', '', '', 'site', 'home'),
(14, 'vi', 'Hotline', '', '', 'site', 'home'),
(15, 'vi', 'Giỏ hàng', '', '', 'site', 'home'),
(16, 'vi', 'quản trị các tham số cấu hình', '', 'admin', 'setting', 'create'),
(17, 'vi', 'Thêm tham số cấu hình', '', 'admin', 'setting', 'create'),
(18, 'vi', 'Danh sách tham số cấu hình', '', 'admin', 'setting', 'create'),
(19, 'vi', 'Hủy thao tác', '', 'admin', 'setting', 'create'),
(20, 'vi', 'Tạo', '', 'admin', 'setting', 'create'),
(21, 'vi', 'thanhlx0204@gmail.com', '', '', 'site', 'home'),
(22, 'vi', 'quản trị các tham số cấu hình', '', 'admin', 'setting', 'index'),
(23, 'vi', 'Danh sách các tham số cấu hình', '', 'admin', 'setting', 'index'),
(24, 'vi', 'Tạo tham số', '', 'admin', 'setting', 'index'),
(25, 'vi', 'Tìm kiếm', '', 'admin', 'setting', 'index'),
(26, 'vi', 'Tên tham số', '', 'admin', 'setting', 'index'),
(27, 'vi', 'Giá trị', '', 'admin', 'setting', 'index'),
(28, 'vi', 'Lọc kết quả', '', 'admin', 'setting', 'index'),
(29, 'vi', 'Công cụ', '', 'admin', 'setting', 'index'),
(30, 'vi', 'Bạn muốn xóa bài viết này?', '', 'admin', 'setting', 'index'),
(31, 'vi', 'Bạn đã xóa thành công', '', 'admin', 'setting', 'index'),
(32, 'vi', 'Chỉnh sửa bài viết', '', 'admin', 'setting', 'index'),
(33, 'vi', 'Xóa bài viết', '', 'admin', 'setting', 'index'),
(34, 'vi', 'Copy bài viết', '', 'admin', 'setting', 'index'),
(35, 'vi', 'Có tổng cộng', '', 'admin', 'setting', 'index'),
(36, 'vi', 'tin', '', 'admin', 'setting', 'index'),
(37, 'vi', 'Trước', '', 'admin', 'setting', 'index'),
(38, 'vi', 'Sau', '', 'admin', 'setting', 'index'),
(39, 'vi', 'Xóa', '', 'admin', 'setting', 'index'),
(40, 'vi', 'CÔNG TY CỔ PHẦN THƯƠNG MẠI VÀ XÂY DỰNG ĐỒ NỘI THẤT GỖ', '', '', 'site', 'home'),
(41, 'vi', 'Showroom', '', '', 'site', 'home'),
(42, 'vi', '43 - Ngõ Văn Chương - Khâm Thiên - Hà Nội', '', '', 'site', 'home'),
(43, 'vi', 'Tel/Fax', '', '', 'site', 'home'),
(44, 'vi', '04.35565 863', '', '', 'site', 'home'),
(45, 'vi', 'Mobile', '', '', 'site', 'home'),
(46, 'vi', '0943 903 069', '', '', 'site', 'home'),
(47, 'vi', 'Email', '', '', 'site', 'home'),
(48, 'vi', 'contact@donoithatgo.vn', '', '', 'site', 'home'),
(49, 'vi', 'Design by IHB Việt Nam', '', '', 'site', 'home'),
(50, 'vi', 'IHB Việt Nam', '', '', 'site', 'home'),
(51, 'vi', 'Đồ gỗ, IHB Việt Nam', '', '', 'site', 'home'),
(52, 'vi', 'quản trị tin tức', '', 'admin', 'news', 'index'),
(53, 'vi', 'Danh sách tin tức', '', 'admin', 'news', 'index'),
(54, 'vi', 'Thêm tin', '', 'admin', 'news', 'index'),
(55, 'vi', 'Tìm kiếm', '', 'admin', 'news', 'index'),
(56, 'vi', 'Lọc kết quả', '', 'admin', 'news', 'index'),
(57, 'vi', 'Tất cả các thư mục', '', 'admin', 'news', 'index'),
(58, 'vi', 'Không lọc', '', 'admin', 'news', 'index'),
(59, 'vi', 'Trạng thái', '', 'admin', 'news', 'index'),
(60, 'vi', 'Đổi trạng thái bài viết', '', 'admin', 'news', 'index'),
(61, 'vi', 'Công cụ', '', 'admin', 'news', 'index'),
(62, 'vi', 'Bạn muốn xóa bài viết này?', '', 'admin', 'news', 'index'),
(63, 'vi', 'Bạn đã xóa thành công', '', 'admin', 'news', 'index'),
(64, 'vi', 'Chỉnh sửa bài viết', '', 'admin', 'news', 'index'),
(65, 'vi', 'Xóa bài viết', '', 'admin', 'news', 'index'),
(66, 'vi', 'Copy bài viết', '', 'admin', 'news', 'index'),
(67, 'vi', 'Có', '', 'admin', 'news', 'index'),
(68, 'vi', 'tin', '', 'admin', 'news', 'index'),
(69, 'vi', 'Trước', '', 'admin', 'news', 'index'),
(70, 'vi', 'Sau', '', 'admin', 'news', 'index'),
(71, 'vi', 'Xóa', '', 'admin', 'news', 'index'),
(72, 'vi', 'Copy', '', 'admin', 'news', 'index'),
(73, 'vi', 'Trang chủ', '', '', 'site', 'home'),
(74, 'vi', 'Giới thiệu', '', '', 'site', 'home'),
(75, 'vi', 'Tin tức', '', '', 'site', 'home'),
(76, 'vi', 'Sản phẩm', '', '', 'site', 'home'),
(77, 'vi', 'Liên hệ', '', '', 'site', 'home'),
(78, 'vi', 'Hỏi đáp', '', '', 'site', 'home'),
(79, 'vi', 'Video', '', '', 'site', 'home'),
(80, 'vi', 'Hướng dẫn', '', '', 'site', 'home'),
(81, 'vi', 'Hướng dẫn mua hàng', '', '', 'site', 'home'),
(82, 'vi', 'Cách giao dịch thanh toán', '', '', 'site', 'home');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE IF NOT EXISTS `tbl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `process_status` tinyint(1) NOT NULL,
  `special` tinyint(4) DEFAULT NULL,
  `other` varchar(1024) DEFAULT NULL,
  `created_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_order`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE IF NOT EXISTS `tbl_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `catid` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `lang` smallint(6) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `amount_status` tinyint(1) NOT NULL DEFAULT '1',
  `special` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(256) NOT NULL,
  `alias` varchar(256) NOT NULL,
  `keywords` varchar(512) NOT NULL,
  `other` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE IF NOT EXISTS `tbl_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL,
  `value` varchar(512) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `name`, `value`) VALUES
(1, 'FRONT_SITE_TITLE', 'Đồ gỗ nội thất'),
(2, 'EMAIL_CONTACT', 'thanhlx0204@gmail.com'),
(3, 'HOTLINE', '0906244804'),
(4, 'COMPANY', 'CÔNG TY CỔ PHẦN THƯƠNG MẠI VÀ XÂY DỰNG ĐỒ NỘI THẤT GỖ'),
(5, 'SHOWROOM', '43 - Ngõ Văn Chương - Khâm Thiên - Hà Nội'),
(6, 'TEL/FAX', '04.35565 863'),
(7, 'MOBILE', '0943 903 069'),
(8, 'EMAIL', 'contact@donoithatgo.vn'),
(9, 'DESIGN_BY', 'Design by IHB Việt Nam'),
(10, 'META_DESCRIPTION', 'Đồ gỗ nội thất'),
(11, 'META_KEYWORD', 'Đồ gỗ, IHB Việt Nam'),
(12, 'META_AUTHOR', 'IHB Việt Nam'),
(13, 'META_COPYRIGHT', 'IHB Việt Nam');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `salt`, `status`, `email`, `other`) VALUES
(1, 'admin', '068bf8c42edece5daa08c9ec0dc0b317', '4f570d19da3d07.31748483', 1, 'kythuat@ihbvietnam.com', '{"phone":"0906244804","address":"Truong Son, An Lao, Hai Phong","firstname":"YHCT","lastname":"YHCT","register_date":1331006642,"last_visit_date":1331006642}');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
