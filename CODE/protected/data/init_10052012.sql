-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 10, 2012 at 10:10 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phoenix`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=52 ;

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
(50, 'nhap-du-lieu-tu-file-excel', 0, 'Nhập dữ liệu từ file excel', 46, NULL, NULL, 4, '', '{"controller":"language","action":"import","description":"","params":""}', 1, 1336612722);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=219 ;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`id`, `lang`, `origin`, `translation`, `module`, `controller`, `action`) VALUES
(1, 'vi', 'quản trị ngôn ngữ', '', 'admin', 'language', 'create'),
(2, 'vi', 'Thêm ngôn ngữ', '', 'admin', 'language', 'create'),
(3, 'vi', 'Ngôn ngữ', '', 'admin', 'language', 'create'),
(4, 'vi', 'Ngôn ngữ nguồn', '', 'admin', 'language', 'create'),
(5, 'vi', 'Module', '', 'admin', 'language', 'create'),
(6, 'vi', 'Controller', '', 'admin', 'language', 'create'),
(7, 'vi', 'Action', '', 'admin', 'language', 'create'),
(8, 'vi', 'Hủy thao tác', '', 'admin', 'language', 'create'),
(9, 'vi', 'Tạo', '', 'admin', 'language', 'create'),
(10, 'af', 'quản trị ngôn ngữ', '', 'admin', 'language', 'create'),
(11, 'af', 'Thêm ngôn ngữ', '', 'admin', 'language', 'create'),
(12, 'af', 'Ngôn ngữ', '', 'admin', 'language', 'create'),
(13, 'af', 'Ngôn ngữ nguồn', '', 'admin', 'language', 'create'),
(14, 'af', 'Module', '', 'admin', 'language', 'create'),
(15, 'af', 'Controller', '', 'admin', 'language', 'create'),
(16, 'af', 'Action', '', 'admin', 'language', 'create'),
(17, 'af', 'Hủy thao tác', '', 'admin', 'language', 'create'),
(18, 'af', 'Tạo', '', 'admin', 'language', 'create'),
(19, 'af', 'quản trị ngôn ngữ', '', 'admin', 'language', 'edit'),
(20, 'vi', 'quản trị ngôn ngữ', '', 'admin', 'language', 'edit'),
(21, 'af', 'Chỉnh sửa ngôn ngữ', '', 'admin', 'language', 'edit'),
(22, 'vi', 'Chỉnh sửa ngôn ngữ', '', 'admin', 'language', 'edit'),
(23, 'af', 'Ngôn ngữ', '', 'admin', 'language', 'edit'),
(24, 'vi', 'Ngôn ngữ', '', 'admin', 'language', 'edit'),
(25, 'af', 'Ngôn ngữ nguồn', '', 'admin', 'language', 'edit'),
(26, 'vi', 'Ngôn ngữ nguồn', '', 'admin', 'language', 'edit'),
(27, 'af', 'Module', '', 'admin', 'language', 'edit'),
(28, 'vi', 'Module', '', 'admin', 'language', 'edit'),
(29, 'af', 'Controller', '', 'admin', 'language', 'edit'),
(30, 'vi', 'Controller', '', 'admin', 'language', 'edit'),
(31, 'af', 'Action', '', 'admin', 'language', 'edit'),
(32, 'vi', 'Action', '', 'admin', 'language', 'edit'),
(33, 'af', 'Hủy', '', 'admin', 'language', 'edit'),
(34, 'vi', 'Hủy', '', 'admin', 'language', 'edit'),
(35, 'af', 'Cập nhật', '', 'admin', 'language', 'edit'),
(36, 'vi', 'Cập nhật', '', 'admin', 'language', 'edit'),
(37, 'af', 'quản trị ngôn ngữ', '', 'admin', 'language', 'delete'),
(38, 'vi', 'quản trị ngôn ngữ', '', 'admin', 'language', 'delete'),
(39, 'af', 'Xóa ngôn ngữ', '', 'admin', 'language', 'delete'),
(40, 'vi', 'Xóa ngôn ngữ', '', 'admin', 'language', 'delete'),
(41, 'af', 'Ngôn ngữ', '', 'admin', 'language', 'delete'),
(42, 'vi', 'Ngôn ngữ', '', 'admin', 'language', 'delete'),
(43, 'af', 'Ngôn ngữ nguồn', '', 'admin', 'language', 'delete'),
(44, 'vi', 'Ngôn ngữ nguồn', '', 'admin', 'language', 'delete'),
(45, 'af', 'Module', '', 'admin', 'language', 'delete'),
(46, 'vi', 'Module', '', 'admin', 'language', 'delete'),
(47, 'af', 'Controller', '', 'admin', 'language', 'delete'),
(48, 'vi', 'Controller', '', 'admin', 'language', 'delete'),
(49, 'af', 'Action', '', 'admin', 'language', 'delete'),
(50, 'vi', 'Action', '', 'admin', 'language', 'delete'),
(51, 'af', 'Hủy thao tác', '', 'admin', 'language', 'delete'),
(52, 'vi', 'Hủy thao tác', '', 'admin', 'language', 'delete'),
(53, 'af', 'Xóa', '', 'admin', 'language', 'delete'),
(54, 'vi', 'Xóa', '', 'admin', 'language', 'delete'),
(55, 'af', 'quản trị tin tức', '', 'admin', 'news', 'index'),
(56, 'vi', 'quản trị tin tức', '', 'admin', 'news', 'index'),
(57, 'af', 'Danh sách tin tức', '', 'admin', 'news', 'index'),
(58, 'vi', 'Danh sách tin tức', '', 'admin', 'news', 'index'),
(59, 'af', 'Thêm tin', '', 'admin', 'news', 'index'),
(60, 'vi', 'Thêm tin', '', 'admin', 'news', 'index'),
(61, 'af', 'Tìm kiếm', '', 'admin', 'news', 'index'),
(62, 'vi', 'Tìm kiếm', '', 'admin', 'news', 'index'),
(63, 'af', 'Lọc kết quả', '', 'admin', 'news', 'index'),
(64, 'vi', 'Lọc kết quả', '', 'admin', 'news', 'index'),
(65, 'af', 'Tất cả các thư mục', '', 'admin', 'news', 'index'),
(66, 'vi', 'Tất cả các thư mục', '', 'admin', 'news', 'index'),
(67, 'af', 'Không lọc', '', 'admin', 'news', 'index'),
(68, 'vi', 'Không lọc', '', 'admin', 'news', 'index'),
(69, 'af', 'Trạng thái', '', 'admin', 'news', 'index'),
(70, 'vi', 'Trạng thái', '', 'admin', 'news', 'index'),
(71, 'af', 'Đổi trạng thái bài viết', '', 'admin', 'news', 'index'),
(72, 'vi', 'Đổi trạng thái bài viết', '', 'admin', 'news', 'index'),
(73, 'af', 'Công cụ', '', 'admin', 'news', 'index'),
(74, 'vi', 'Công cụ', '', 'admin', 'news', 'index'),
(75, 'af', 'Bạn muốn xóa bài viết này?', '', 'admin', 'news', 'index'),
(76, 'vi', 'Bạn muốn xóa bài viết này?', '', 'admin', 'news', 'index'),
(77, 'af', 'Bạn đã xóa thành công', '', 'admin', 'news', 'index'),
(78, 'vi', 'Bạn đã xóa thành công', '', 'admin', 'news', 'index'),
(79, 'af', 'Chỉnh sửa bài viết', '', 'admin', 'news', 'index'),
(80, 'vi', 'Chỉnh sửa bài viết', '', 'admin', 'news', 'index'),
(81, 'af', 'Xóa bài viết', '', 'admin', 'news', 'index'),
(82, 'vi', 'Xóa bài viết', '', 'admin', 'news', 'index'),
(83, 'af', 'Copy bài viết', '', 'admin', 'news', 'index'),
(84, 'vi', 'Copy bài viết', '', 'admin', 'news', 'index'),
(85, 'af', 'Có tổng cộng', '', 'admin', 'news', 'index'),
(86, 'vi', 'Có tổng cộng', '', 'admin', 'news', 'index'),
(87, 'af', 'tin', '', 'admin', 'news', 'index'),
(88, 'vi', 'tin', '', 'admin', 'news', 'index'),
(89, 'af', 'Trước', '', 'admin', 'news', 'index'),
(90, 'vi', 'Trước', '', 'admin', 'news', 'index'),
(91, 'af', 'Sau', '', 'admin', 'news', 'index'),
(92, 'vi', 'Sau', '', 'admin', 'news', 'index'),
(93, 'af', 'Xóa', '', 'admin', 'news', 'index'),
(94, 'vi', 'Xóa', '', 'admin', 'news', 'index'),
(95, 'af', 'Copy', '', 'admin', 'news', 'index'),
(96, 'vi', 'Copy', '', 'admin', 'news', 'index'),
(97, 'af', 'quản trị các tham số cấu hình', '', 'admin', 'setting', 'index'),
(98, 'vi', 'quản trị các tham số cấu hình', '', 'admin', 'setting', 'index'),
(99, 'af', 'Danh sách các tham số cấu hình', '', 'admin', 'setting', 'index'),
(100, 'vi', 'Danh sách các tham số cấu hình', '', 'admin', 'setting', 'index'),
(101, 'af', 'Thêm tin', '', 'admin', 'setting', 'index'),
(102, 'vi', 'Thêm tin', '', 'admin', 'setting', 'index'),
(103, 'af', 'Tìm kiếm', '', 'admin', 'setting', 'index'),
(104, 'vi', 'Tìm kiếm', '', 'admin', 'setting', 'index'),
(105, 'af', 'Tên tham số', '', 'admin', 'setting', 'index'),
(106, 'vi', 'Tên tham số', '', 'admin', 'setting', 'index'),
(107, 'af', 'Giá trị', '', 'admin', 'setting', 'index'),
(108, 'vi', 'Giá trị', '', 'admin', 'setting', 'index'),
(109, 'af', 'Lọc kết quả', '', 'admin', 'setting', 'index'),
(110, 'vi', 'Lọc kết quả', '', 'admin', 'setting', 'index'),
(111, 'af', 'Công cụ', '', 'admin', 'setting', 'index'),
(112, 'vi', 'Công cụ', '', 'admin', 'setting', 'index'),
(113, 'af', 'Bạn muốn xóa bài viết này?', '', 'admin', 'setting', 'index'),
(114, 'vi', 'Bạn muốn xóa bài viết này?', '', 'admin', 'setting', 'index'),
(115, 'af', 'Bạn đã xóa thành công', '', 'admin', 'setting', 'index'),
(116, 'vi', 'Bạn đã xóa thành công', '', 'admin', 'setting', 'index'),
(117, 'af', 'Chỉnh sửa bài viết', '', 'admin', 'setting', 'index'),
(118, 'vi', 'Chỉnh sửa bài viết', '', 'admin', 'setting', 'index'),
(119, 'af', 'Xóa bài viết', '', 'admin', 'setting', 'index'),
(120, 'vi', 'Xóa bài viết', '', 'admin', 'setting', 'index'),
(121, 'af', 'Copy bài viết', '', 'admin', 'setting', 'index'),
(122, 'vi', 'Copy bài viết', '', 'admin', 'setting', 'index'),
(123, 'af', 'Có tổng cộng', '', 'admin', 'setting', 'index'),
(124, 'vi', 'Có tổng cộng', '', 'admin', 'setting', 'index'),
(125, 'af', 'tin', '', 'admin', 'setting', 'index'),
(126, 'vi', 'tin', '', 'admin', 'setting', 'index'),
(127, 'af', 'Trước', '', 'admin', 'setting', 'index'),
(128, 'vi', 'Trước', '', 'admin', 'setting', 'index'),
(129, 'af', 'Sau', '', 'admin', 'setting', 'index'),
(130, 'vi', 'Sau', '', 'admin', 'setting', 'index'),
(131, 'af', 'Xóa', '', 'admin', 'setting', 'index'),
(132, 'vi', 'Xóa', '', 'admin', 'setting', 'index'),
(133, 'af', 'Tạo tham số', '', 'admin', 'setting', 'index'),
(134, 'vi', 'Tạo tham số', '', 'admin', 'setting', 'index'),
(135, 'af', 'quản trị các tham số cấu hình', '', 'admin', 'setting', 'create'),
(136, 'vi', 'quản trị các tham số cấu hình', '', 'admin', 'setting', 'create'),
(137, 'af', 'Thêm tham số cấu hình', '', 'admin', 'setting', 'create'),
(138, 'vi', 'Thêm tham số cấu hình', '', 'admin', 'setting', 'create'),
(139, 'af', 'Danh sách tham số cấu hình', '', 'admin', 'setting', 'create'),
(140, 'vi', 'Danh sách tham số cấu hình', '', 'admin', 'setting', 'create'),
(141, 'af', 'Tên tham số', '', 'admin', 'setting', 'create'),
(142, 'vi', 'Tên tham số', '', 'admin', 'setting', 'create'),
(143, 'af', 'Giá trị', '', 'admin', 'setting', 'create'),
(144, 'vi', 'Giá trị', '', 'admin', 'setting', 'create'),
(145, 'af', 'Hủy thao tác', '', 'admin', 'setting', 'create'),
(146, 'vi', 'Hủy thao tác', '', 'admin', 'setting', 'create'),
(147, 'af', 'Tạo', '', 'admin', 'setting', 'create'),
(148, 'vi', 'Tạo', '', 'admin', 'setting', 'create'),
(149, 'af', 'quản trị ngôn ngữ', '', 'admin', 'language', 'export'),
(150, 'vi', 'quản trị ngôn ngữ', '', 'admin', 'language', 'export'),
(151, 'af', 'Xuất dữ liệu ra file excel', '', 'admin', 'language', 'export'),
(152, 'vi', 'Xuất dữ liệu ra file excel', '', 'admin', 'language', 'export'),
(153, 'af', 'Ngôn ngữ', '', 'admin', 'language', 'export'),
(154, 'vi', 'Ngôn ngữ', '', 'admin', 'language', 'export'),
(155, 'af', 'Ngôn ngữ nguồn', '', 'admin', 'language', 'export'),
(156, 'vi', 'Ngôn ngữ nguồn', '', 'admin', 'language', 'export'),
(157, 'af', 'Module', '', 'admin', 'language', 'export'),
(158, 'vi', 'Module', '', 'admin', 'language', 'export'),
(159, 'af', 'Controller', '', 'admin', 'language', 'export'),
(160, 'vi', 'Controller', '', 'admin', 'language', 'export'),
(161, 'af', 'Action', '', 'admin', 'language', 'export'),
(162, 'vi', 'Action', '', 'admin', 'language', 'export'),
(163, 'af', 'Hủy thao tác', '', 'admin', 'language', 'export'),
(164, 'vi', 'Hủy thao tác', '', 'admin', 'language', 'export'),
(165, 'af', 'Xuất', '', 'admin', 'language', 'export'),
(166, 'vi', 'Xuất', '', 'admin', 'language', 'export'),
(167, 'af', 'Tạo mới', '', 'admin', 'language', 'edit'),
(168, 'vi', 'Tạo mới', '', 'admin', 'language', 'edit'),
(169, 'af', 'Xóa', '', 'admin', 'language', 'edit'),
(170, 'vi', 'Xóa', '', 'admin', 'language', 'edit'),
(171, 'af', 'Export', '', 'admin', 'language', 'edit'),
(172, 'vi', 'Export', '', 'admin', 'language', 'edit'),
(173, 'af', 'Import', '', 'admin', 'language', 'edit'),
(174, 'vi', 'Import', '', 'admin', 'language', 'edit'),
(175, 'af', 'Chỉnh sửa', '', 'admin', 'language', 'create'),
(176, 'vi', 'Chỉnh sửa', '', 'admin', 'language', 'create'),
(177, 'af', 'Xóa', '', 'admin', 'language', 'create'),
(178, 'vi', 'Xóa', '', 'admin', 'language', 'create'),
(179, 'af', 'Export', '', 'admin', 'language', 'create'),
(180, 'vi', 'Export', '', 'admin', 'language', 'create'),
(181, 'af', 'Import', '', 'admin', 'language', 'create'),
(182, 'vi', 'Import', '', 'admin', 'language', 'create'),
(183, 'af', 'quản trị ngôn ngữ', '', 'admin', 'language', 'import'),
(184, 'vi', 'quản trị ngôn ngữ', '', 'admin', 'language', 'import'),
(185, 'af', 'Nhập dữ liệu từ file excel', '', 'admin', 'language', 'import'),
(186, 'vi', 'Nhập dữ liệu từ file excel', '', 'admin', 'language', 'import'),
(187, 'af', 'Chỉnh sửa', '', 'admin', 'language', 'import'),
(188, 'vi', 'Chỉnh sửa', '', 'admin', 'language', 'import'),
(189, 'af', 'Tạo mới', '', 'admin', 'language', 'import'),
(190, 'vi', 'Tạo mới', '', 'admin', 'language', 'import'),
(191, 'af', 'Xóa', '', 'admin', 'language', 'import'),
(192, 'vi', 'Xóa', '', 'admin', 'language', 'import'),
(193, 'af', 'Export', '', 'admin', 'language', 'import'),
(194, 'vi', 'Export', '', 'admin', 'language', 'import'),
(195, 'af', 'Ngôn ngữ', '', 'admin', 'language', 'import'),
(196, 'vi', 'Ngôn ngữ', '', 'admin', 'language', 'import'),
(197, 'af', 'File', '', 'admin', 'language', 'import'),
(198, 'vi', 'File', '', 'admin', 'language', 'import'),
(199, 'af', 'Hủy thao tác', '', 'admin', 'language', 'import'),
(200, 'vi', 'Hủy thao tác', '', 'admin', 'language', 'import'),
(201, 'af', 'Nhập', '', 'admin', 'language', 'import'),
(202, 'vi', 'Nhập', '', 'admin', 'language', 'import'),
(203, 'af', 'Chỉnh sửa', '', 'admin', 'language', 'delete'),
(204, 'vi', 'Chỉnh sửa', '', 'admin', 'language', 'delete'),
(205, 'af', 'Tạo mới', '', 'admin', 'language', 'delete'),
(206, 'vi', 'Tạo mới', '', 'admin', 'language', 'delete'),
(207, 'af', 'Export', '', 'admin', 'language', 'delete'),
(208, 'vi', 'Export', '', 'admin', 'language', 'delete'),
(209, 'af', 'Import', '', 'admin', 'language', 'delete'),
(210, 'vi', 'Import', '', 'admin', 'language', 'delete'),
(211, 'af', 'Chỉnh sửa', '', 'admin', 'language', 'export'),
(212, 'vi', 'Chỉnh sửa', '', 'admin', 'language', 'export'),
(213, 'af', 'Tạo mới', '', 'admin', 'language', 'export'),
(214, 'vi', 'Tạo mới', '', 'admin', 'language', 'export'),
(215, 'af', 'Xóa', '', 'admin', 'language', 'export'),
(216, 'vi', 'Xóa', '', 'admin', 'language', 'export'),
(217, 'af', 'Export', '', 'admin', 'language', 'export'),
(218, 'vi', 'Export', '', 'admin', 'language', 'export');

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE IF NOT EXISTS `tbl_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) CHARACTER SET utf8 NOT NULL,
  `value` varchar(512) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
