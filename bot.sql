-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2026-01-17 15:20:21
-- 服务器版本： 5.7.44-log
-- PHP 版本： 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `bot`
--

-- --------------------------------------------------------

--
-- 表的结构 `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL COMMENT '活动类型',
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `entitle` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '活动内容',
  `encontent` longtext COLLATE utf8mb4_unicode_ci,
  `memo` longtext COLLATE utf8mb4_unicode_ci COMMENT '活动',
  `enmemo` longtext COLLATE utf8mb4_unicode_ci,
  `apply_count` int(11) NOT NULL DEFAULT '0' COMMENT '申请次数',
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '活动图片',
  `can_apply` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1可申请 0不可申请',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0禁用',
  `app_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `app_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `activity_apply`
--

CREATE TABLE `activity_apply` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` int(11) NOT NULL COMMENT '活动id',
  `user_id` int(11) NOT NULL COMMENT '申请人',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1待审核 2通过 3拒绝',
  `check_time` datetime DEFAULT NULL COMMENT '审核时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `activity_types`
--

CREATE TABLE `activity_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '类型',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1可用 0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `activity_types`
--

INSERT INTO `activity_types` (`id`, `name`, `state`, `created_at`, `updated_at`) VALUES
(2, '现金回馈', 1, '2021-04-18 16:05:45', '2021-10-23 14:52:28'),
(5, '棋牌活动', 1, '2021-10-23 15:15:56', '2021-10-23 15:15:56'),
(6, '电子活动', 1, '2021-10-23 15:26:52', '2021-10-23 15:26:52'),
(7, '彩票活动', 1, '2021-10-23 15:42:37', '2021-10-23 15:42:37'),
(8, '视讯活动', 1, '2021-10-23 15:46:38', '2021-10-23 15:46:38'),
(9, '热门优惠', 1, '2021-10-25 02:56:11', '2021-10-25 02:56:11'),
(10, '体育活动', 1, '2022-11-22 08:14:28', '2022-11-22 08:14:28'),
(11, '捕鱼活动', 1, '2022-11-22 08:15:14', '2022-11-22 08:15:14'),
(12, '电竞活动', 1, '2022-11-22 09:11:01', '2022-11-22 09:11:01');

-- --------------------------------------------------------

--
-- 表的结构 `admin_extensions`
--

CREATE TABLE `admin_extensions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_enabled` tinyint(4) NOT NULL DEFAULT '0',
  `options` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_extensions`
--

INSERT INTO `admin_extensions` (`id`, `name`, `version`, `is_enabled`, `options`, `created_at`, `updated_at`) VALUES
(1, 'guanguans.dcat-login-captcha', '1.0.14', 1, NULL, '2022-07-30 02:24:48', '2022-07-30 02:24:56');

-- --------------------------------------------------------

--
-- 表的结构 `admin_extension_histories`
--

CREATE TABLE `admin_extension_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_extension_histories`
--

INSERT INTO `admin_extension_histories` (`id`, `name`, `type`, `version`, `detail`, `created_at`, `updated_at`) VALUES
(1, 'guanguans.dcat-login-captcha', 1, '1.0.0', 'Initial release.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(2, 'guanguans.dcat-login-captcha', 1, '1.0.1', 'Add default config file.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(3, 'guanguans.dcat-login-captcha', 1, '1.0.1', 'Add annotation for facades.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(4, 'guanguans.dcat-login-captcha', 1, '1.0.1', 'Optimize `login_captcha_check` function.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(5, 'guanguans.dcat-login-captcha', 1, '1.0.1', 'Optimize captcha generate.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(6, 'guanguans.dcat-login-captcha', 1, '1.0.1', 'Optimize get setting config.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(7, 'guanguans.dcat-login-captcha', 1, '1.0.1', 'Rename `dcat_login_captcha_check`->`login_captcha_check`.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(8, 'guanguans.dcat-login-captcha', 1, '1.0.1', 'Rename `dcat_login_captcha_url`->`login_captcha_url`.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(9, 'guanguans.dcat-login-captcha', 1, '1.0.2', 'Add login_captcha_get function.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(10, 'guanguans.dcat-login-captcha', 1, '1.0.2', 'Update lang files.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(11, 'guanguans.dcat-login-captcha', 1, '1.0.2', 'Update extension alias and description.', '2022-07-30 02:24:48', '2022-07-30 02:24:48'),
(12, 'guanguans.dcat-login-captcha', 1, '1.0.2', 'Optimize LoginCaptchaServiceProvider.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(13, 'guanguans.dcat-login-captcha', 1, '1.0.2', 'Optimize setting form.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(14, 'guanguans.dcat-login-captcha', 1, '1.0.3', 'Add CleanObContents Middleware.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(15, 'guanguans.dcat-login-captcha', 1, '1.0.4', 'Add SetResponseContentType Middleware.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(16, 'guanguans.dcat-login-captcha', 1, '1.0.4', 'Add content type setting config.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(17, 'guanguans.dcat-login-captcha', 1, '1.0.5', 'Add BootingHandler.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(18, 'guanguans.dcat-login-captcha', 1, '1.0.6', 'Rename src/BootingAdmin.php -> src/BootingHandler.php.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(19, 'guanguans.dcat-login-captcha', 1, '1.0.6', 'Remove src/Http/Controllers/CaptchaController.php`.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(20, 'guanguans.dcat-login-captcha', 1, '1.0.7', 'Optimize `buildCaptchaJsScript`.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(21, 'guanguans.dcat-login-captcha', 1, '1.0.8', 'Fix cant match routing path(#8).', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(22, 'guanguans.dcat-login-captcha', 1, '1.0.9', 'Add parameters to the `SetResponseContentType` middleware.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(23, 'guanguans.dcat-login-captcha', 1, '1.0.9', 'Update github config files.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(24, 'guanguans.dcat-login-captcha', 1, '1.0.9', 'Update phpunit/phpunit requirement from ^7.0 || ^8.0 to ^7.0 || ^8.0 || ^9.0.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(25, 'guanguans.dcat-login-captcha', 1, '1.0.9', 'Optimize booting `BootingHandler`.', '2022-07-30 02:24:49', '2022-07-30 02:24:49'),
(26, 'guanguans.dcat-login-captcha', 1, '1.0.9', 'Optimize setting form .', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(27, 'guanguans.dcat-login-captcha', 1, '1.0.10', 'Compatible callback type.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(28, 'guanguans.dcat-login-captcha', 1, '1.0.11', 'Rename `phrase_session_key` -> `captcha_phrase_session_key`.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(29, 'guanguans.dcat-login-captcha', 1, '1.0.11', 'Generate captcha random url.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(30, 'guanguans.dcat-login-captcha', 1, '1.0.11', 'Replace `Closure routing` -> `CaptchaController`.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(31, 'guanguans.dcat-login-captcha', 1, '1.0.11', 'Bump actions/cache from 2 to 3.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(32, 'guanguans.dcat-login-captcha', 1, '1.0.11', 'Bump actions/checkout from 2 to 3.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(33, 'guanguans.dcat-login-captcha', 1, '1.0.11', 'Update overtrue/phplint requirement from ^2.3 || ^3.0 to ^2.3 || ^3.0 || ^4.0.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(34, 'guanguans.dcat-login-captcha', 1, '1.0.12', 'Bump codecov/codecov-action from 2.1.0 to 3.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(35, 'guanguans.dcat-login-captcha', 1, '1.0.12', 'Update author info.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(36, 'guanguans.dcat-login-captcha', 1, '1.0.13', 'Update JS.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(37, 'guanguans.dcat-login-captcha', 1, '1.0.14', 'Rename login_captcha_get -> login_captcha_content.', '2022-07-30 02:24:50', '2022-07-30 02:24:50'),
(38, 'guanguans.dcat-login-captcha', 1, '1.0.14', 'Update github config files.', '2022-07-30 02:24:50', '2022-07-30 02:24:50');

-- --------------------------------------------------------

--
-- 表的结构 `admin_menu`
--

CREATE TABLE `admin_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `show` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `extension`, `show`, `created_at`, `updated_at`) VALUES
(1, 0, 1, '首页', 'fa-home', '/', '', 1, '2020-11-18 16:54:08', '2021-05-19 13:45:27'),
(2, 0, 44, '管理设置', 'fa-address-card', NULL, '', 1, '2020-11-18 16:54:08', '2022-06-12 03:56:11'),
(3, 2, 45, '管理员', 'fa-group', 'auth/users', '', 1, '2020-11-18 16:54:08', '2022-06-12 03:56:11'),
(4, 2, 46, '角色管理', NULL, 'auth/roles', '', 1, '2020-11-18 16:54:08', '2022-06-12 03:56:11'),
(5, 2, 47, '权限设置', NULL, 'auth/permissions', '', 1, '2020-11-18 16:54:08', '2022-06-12 03:56:11'),
(6, 2, 48, '菜单管理', 'fa-align-justify', 'auth/menu', '', 1, '2020-11-18 16:54:08', '2022-06-12 03:56:11'),
(7, 2, 49, '扩展', NULL, 'auth/extensions', '', 0, '2020-11-18 16:54:08', '2022-06-12 03:56:11'),
(8, 0, 7, '会员管理', 'fa-user-o', NULL, '', 1, '2020-11-18 22:23:13', '2022-06-12 03:56:11'),
(9, 8, 8, '会员列表', 'fa-user', 'users', '', 1, '2020-11-18 22:24:01', '2022-06-12 03:56:11'),
(10, 8, 10, '会员等级', 'fa-address-book-o', 'user-vips', '', 1, '2020-11-19 08:18:54', '2022-06-12 03:56:11'),
(11, 70, 36, '站内信', 'fa-envelope-o', 'messages', '', 1, '2020-12-16 08:04:34', '2025-08-24 08:33:23'),
(12, 0, 13, '财务管理', 'fa-database', NULL, '', 1, '2020-12-17 01:32:41', '2022-06-12 03:56:11'),
(13, 12, 14, '充值管理', NULL, 'recharge', '', 1, '2020-12-17 01:40:45', '2022-06-12 03:56:11'),
(14, 12, 15, '提款审核', NULL, 'withdraws', '', 1, '2020-12-17 06:09:51', '2022-06-12 03:56:11'),
(15, 0, 18, '支付设置', 'fa-bookmark-o', NULL, '', 1, '2020-12-17 07:47:02', '2022-06-12 03:56:11'),
(16, 15, 21, '收款银行卡管理', NULL, 'pay-settings', '', 1, '2020-12-17 07:47:22', '2022-06-12 03:56:11'),
(17, 15, 22, '银行类型', NULL, 'banks', '', 1, '2020-12-17 07:47:44', '2022-06-12 03:56:11'),
(18, 15, 20, 'USDT钱包设置', NULL, 'pay-config', '', 0, '2020-12-18 06:45:32', '2022-06-12 03:56:11'),
(19, 0, 28, '活动管理', 'fa-yelp', NULL, '', 1, '2020-12-20 04:22:39', '2022-06-12 03:56:11'),
(20, 19, 29, '活动列表', NULL, 'activities', '', 1, '2020-12-20 04:23:42', '2022-06-12 03:56:11'),
(21, 19, 30, '活动申请', NULL, 'activity-apply', '', 1, '2020-12-20 13:05:44', '2022-06-12 03:56:11'),
(22, 19, 31, '活动类型', NULL, 'activity-types', '', 1, '2020-12-23 09:00:30', '2022-06-12 03:56:11'),
(23, 12, 16, '额度转换记录', NULL, 'transfer-logs', '', 1, '2020-12-23 09:22:41', '2022-06-12 03:56:11'),
(24, 12, 17, '财务报表', NULL, 'finance-report', '', 1, '2020-12-25 08:21:56', '2022-06-12 03:56:11'),
(25, 0, 35, '下注管理', 'fa-align-right', NULL, '', 0, '2020-12-27 02:26:59', '2022-06-12 03:56:11'),
(26, 8, 12, '下注记录', 'fa-align-right', 'game-records', '', 1, '2020-12-27 02:27:19', '2022-06-12 03:56:11'),
(27, 0, 41, '接口管理', NULL, NULL, '', 0, '2020-12-28 02:28:20', '2022-06-12 03:56:11'),
(28, 27, 42, '接口管理', NULL, 'apis', '', 1, '2020-12-28 02:28:30', '2022-06-12 03:56:11'),
(29, 27, 43, '游戏列表', NULL, 'game-lists', '', 1, '2020-12-28 03:02:09', '2022-06-12 03:56:11'),
(30, 0, 2, '系统设置', 'fa-cogs', NULL, '', 1, '2020-12-30 12:13:57', '2021-08-23 13:45:18'),
(31, 30, 3, '系统设置', 'fa-gear', 'system-setting', '', 1, '2020-12-30 12:14:06', '2022-04-26 02:34:06'),
(34, 0, 23, '代理管理', 'fa-address-book-o', NULL, '', 1, '2021-01-07 11:32:07', '2022-06-12 03:56:11'),
(35, 34, 24, '代理列表', NULL, 'agents', '', 1, '2021-01-07 11:32:22', '2022-06-12 03:56:11'),
(36, 34, 25, '代理申请管理', NULL, 'agent-applys', '', 1, '2021-02-03 06:04:35', '2022-06-12 03:56:11'),
(37, 34, 26, '代理佣金报表', NULL, 'agent-commission', '', 1, '2021-02-03 06:48:21', '2022-06-12 03:56:11'),
(38, 34, 27, '代理结算方案', NULL, 'agent-settlements', '', 1, '2021-02-03 07:49:46', '2022-06-12 03:56:11'),
(43, 15, 19, '收款方式管理', NULL, 'code-pay', '', 1, '2021-03-31 03:08:50', '2022-06-12 03:56:11'),
(44, 0, 32, '红包管理', 'fa-window-restore', NULL, '', 1, '2021-03-31 09:00:33', '2022-06-12 03:56:11'),
(45, 44, 34, '红包管理', 'fa-file-photo-o', '/red-envelopes', '', 1, '2021-03-31 09:01:21', '2022-06-12 03:56:11'),
(46, 30, 4, '日志管理', 'fa-file-text-o', 'user-operate-logs', '', 1, NULL, '2022-06-12 03:56:11'),
(47, 44, 33, '会员红包领取', NULL, 'userredpacket', '', 1, NULL, '2022-06-12 03:56:11'),
(48, 8, 11, '会员返水', 'fa fa-list', 'fanshui', '', 1, NULL, '2022-06-12 03:56:11'),
(49, 8, 9, '银行卡/USDT绑定', 'fa-credit-card', 'usercard', '', 1, NULL, '2022-06-12 03:56:11'),
(50, 0, 37, '内容管理', 'fa-clone', '/admin/activities', '', 1, '2021-05-19 13:54:03', '2022-06-12 03:56:11'),
(54, 50, 38, '文章分类', 'fa-500px', 'articlescate', '', 1, '2021-06-23 07:23:39', '2022-06-12 03:56:11'),
(55, 50, 39, '文章管理', 'fa-align-justify', 'articles', '', 1, '2021-06-23 07:24:10', '2022-06-12 03:56:11'),
(56, 0, 50, '日志管理', 'fa-align-justify', NULL, '', 0, '2021-09-05 07:40:42', '2022-06-12 03:56:11'),
(57, 56, 51, '会员操作日志', 'fa-circle-o', 'user-operate-logs', '', 0, '2021-09-05 07:41:37', '2022-06-12 03:56:11'),
(58, 30, 5, 'Banner管理', 'fa-picture-o', 'banners', '', 1, '2021-09-09 03:58:58', '2022-06-12 03:56:11'),
(59, 0, 52, '运营工具', 'fa-briefcase', NULL, '', 0, '2021-09-10 02:46:54', '2022-06-12 03:56:11'),
(60, 30, 6, '数据清理', 'fa-scissors', 'clear', '', 1, '2021-09-10 02:48:28', '2022-06-12 03:56:11'),
(61, 0, 40, '接口管理', 'fa-anchor', '', '', 1, '2022-06-12 03:55:42', '2022-06-12 03:56:11'),
(62, 61, 53, '接口开关', 'fa-anchor', '/apis', '', 1, '2022-10-02 03:00:23', '2022-10-02 03:00:23'),
(63, 61, 54, '游戏管理', 'fa-gamepad', 'game-lists', '', 1, '2022-12-03 08:14:48', '2022-12-03 08:14:50'),
(64, 61, 55, 'APP热门游戏', 'fa-gamepad', 'game-lists-app', '', 1, '2022-12-03 08:22:23', '2022-12-03 08:22:24'),
(65, 50, 40, '赞助管理', 'fa-handshake-o', 'sponsors', '', 1, '2025-08-24 03:30:29', '2025-08-24 03:34:57'),
(70, 0, 60, '客服管理', 'fa-comments', '', '', 1, '2025-08-24 08:31:34', '2025-08-24 08:31:34'),
(71, 70, 10, '工单管理', 'fa-ticket', 'work-orders', '', 1, '2025-08-24 08:31:34', '2025-08-24 08:31:34'),
(72, 15, 61, 'USDT充值配置', 'fa-expeditedssl', '/pay-config', '', 1, '2025-08-26 10:05:21', '2025-08-26 10:05:21'),
(73, 2, 62, '地区管理', 'fa-map-marker', '/regions', '', 1, '2025-12-21 19:41:18', '2025-12-21 19:41:46'),
(74, 61, 56, '游戏类目', 'fa-tags', 'game-categories', '', 1, '2025-12-27 13:58:09', '2025-12-27 13:58:09');

-- --------------------------------------------------------

--
-- 表的结构 `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '0',
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `http_method`, `http_path`, `order`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, '管理设置', '管理设置', '', '', 1, 0, '2020-12-31 11:16:09', '2021-05-19 13:47:40'),
(2, '会员管理', 'users', '', '/auth/users*', 2, 1, '2020-12-31 11:16:09', '2021-05-19 13:47:02'),
(3, '角色', 'roles', '', '/auth/roles*', 3, 1, '2020-12-31 11:16:09', '2021-05-19 13:46:07'),
(4, '权限', 'permissions', '', '/auth/permissions*', 4, 1, '2020-12-31 11:16:09', '2021-05-19 13:46:17'),
(5, '菜单', 'menu', '', '/auth/menu*', 5, 1, '2020-12-31 11:16:09', '2021-05-19 13:46:28'),
(6, '扩展', 'extension', '', '/auth/extensions*', 6, 1, '2020-12-31 11:16:09', '2021-05-19 13:46:35');

-- --------------------------------------------------------

--
-- 表的结构 `admin_permission_menu`
--

CREATE TABLE `admin_permission_menu` (
  `permission_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_permission_menu`
--

INSERT INTO `admin_permission_menu` (`permission_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(2, 50, NULL, NULL),
(2, 51, NULL, NULL),
(2, 52, NULL, NULL),
(3, 50, NULL, NULL),
(3, 51, NULL, NULL),
(3, 52, NULL, NULL),
(4, 50, NULL, NULL),
(4, 51, NULL, NULL),
(4, 52, NULL, NULL),
(5, 50, NULL, NULL),
(5, 51, NULL, NULL),
(5, 52, NULL, NULL),
(6, 50, NULL, NULL),
(6, 51, NULL, NULL),
(6, 52, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'administrator', '2020-12-31 11:16:09', '2020-12-31 11:16:09');

-- --------------------------------------------------------

--
-- 表的结构 `admin_role_menu`
--

CREATE TABLE `admin_role_menu` (
  `role_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_role_menu`
--

INSERT INTO `admin_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, 50, NULL, NULL),
(1, 51, NULL, NULL),
(1, 52, NULL, NULL),
(1, 54, NULL, NULL),
(1, 55, NULL, NULL),
(1, 61, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_role_permissions`
--

CREATE TABLE `admin_role_permissions` (
  `role_id` bigint(20) NOT NULL,
  `permission_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_role_permissions`
--

INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL),
(1, 3, NULL, NULL),
(1, 4, NULL, NULL),
(1, 5, NULL, NULL),
(1, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_role_users`
--

CREATE TABLE `admin_role_users` (
  `role_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_role_users`
--

INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_settings`
--

CREATE TABLE `admin_settings` (
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_settings`
--

INSERT INTO `admin_settings` (`slug`, `value`, `created_at`, `updated_at`) VALUES
('guanguans:dcat-login-captcha', '{\"length\":4,\"charset\":\"abcdefghijklmnpqrstuvwxyz23456789ABCDEFGHIJKLMNOPQRSTUVWXYZ\",\"width\":150,\"height\":43,\"type\":\"png\",\"font\":null,\"fingerprint\":null,\"captcha_phrase_session_key\":\"login_captcha_phrase\"}', '2022-07-30 02:24:56', '2022-07-30 02:24:56');

-- --------------------------------------------------------

--
-- 表的结构 `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$FfMto0oPwdZLy/PhfucvXexmt8sWhzr4zexOCoRNn3bvcwwruyMXy', 'Administrator', NULL, 'npGv1Ql0i7DCOyZ2IFwjc5QrraeWST3n3BlrfdoXp99JIXJDiv5Ttk7JlVd3', '2020-12-31 11:16:09', '2022-09-29 18:17:11');

-- --------------------------------------------------------

--
-- 表的结构 `agent_apply`
--

CREATE TABLE `agent_apply` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apply_info` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1待审核 2通过 3拒绝',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `agent_apply`
--

INSERT INTO `agent_apply` (`id`, `user_id`, `mobile`, `apply_info`, `state`, `created_at`, `updated_at`) VALUES
(1, 28, '18888888888', '646456446464', 2, '2025-10-18 07:27:40', '2025-10-18 13:37:44'),
(2, 48, '18900007777', 'YII', 2, '2025-10-18 13:37:30', '2025-12-31 10:33:32'),
(3, 64, '13222233344', '3', 1, '2025-10-19 16:11:17', '2025-10-19 16:11:17');

-- --------------------------------------------------------

--
-- 表的结构 `agent_settlements`
--

CREATE TABLE `agent_settlements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '方案名称',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '结算类型 1返点 2返佣',
  `realperson` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '真人',
  `electron` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '电子',
  `joker` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '棋牌',
  `sport` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '体育',
  `fish` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '捕鱼',
  `lottery` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '彩票',
  `e_sport` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '电竞',
  `member_fs` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '会员返水',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `agent_settlements`
--

INSERT INTO `agent_settlements` (`id`, `name`, `type`, `realperson`, `electron`, `joker`, `sport`, `fish`, `lottery`, `e_sport`, `member_fs`, `state`, `created_at`, `updated_at`) VALUES
(9, '10', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '10.00', 1, '2025-10-19 19:30:40', '2025-10-19 19:30:40'),
(10, '15', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '15.00', 1, '2025-10-19 19:30:53', '2025-10-19 19:30:53'),
(11, '20', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '20.00', 1, '2025-10-19 19:31:02', '2025-10-19 19:31:02'),
(12, '25', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '25.00', 1, '2025-10-19 19:31:40', '2025-10-19 19:31:40'),
(13, '30', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '30.00', 1, '2025-10-19 19:31:49', '2025-10-19 19:31:49'),
(14, '35', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '35.00', 1, '2025-10-19 19:32:08', '2025-10-19 19:32:08'),
(15, '40', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '40.00', 1, '2025-10-19 19:32:16', '2025-10-19 19:32:16'),
(16, '45', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '45.00', 1, '2025-10-19 19:32:23', '2025-10-19 19:32:23'),
(17, '50', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '50.00', 1, '2025-10-19 19:32:35', '2025-10-19 19:32:35'),
(18, '55', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '55.00', 1, '2025-10-19 19:32:43', '2025-10-19 19:32:43'),
(19, '60', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '60.00', 1, '2025-10-19 19:32:52', '2025-10-19 19:32:52'),
(20, '65', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '65.00', 1, '2025-10-19 19:33:02', '2025-10-19 19:33:02'),
(21, '66', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '66.00', 1, '2025-10-19 19:33:10', '2025-10-19 19:33:10'),
(22, '67', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '67.00', 1, '2025-10-19 19:33:19', '2025-10-19 19:33:19'),
(23, '68', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '68.00', 1, '2025-10-19 19:33:29', '2025-10-19 19:33:29'),
(24, '69', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '69.00', 1, '2025-10-19 19:33:40', '2025-10-19 19:33:40'),
(25, '70', 2, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '70.00', 1, '2025-10-19 19:33:50', '2025-10-19 19:33:50');

-- --------------------------------------------------------

--
-- 表的结构 `apis`
--

CREATE TABLE `apis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'api代码',
  `api_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'api名称',
  `api_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'api余额',
  `game_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '游戏类型',
  `plat_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '平台类型',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `app_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'app状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL COMMENT '排序',
  `app_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `apis`
--

INSERT INTO `apis` (`id`, `api_code`, `api_name`, `api_money`, `game_type`, `plat_type`, `state`, `app_state`, `created_at`, `updated_at`, `order_by`, `app_icon`) VALUES
(1, 'CURRENCY', '通用额度', '0.00', NULL, NULL, 0, 0, '2022-09-21 07:52:50', '2026-01-15 22:43:11', 456, NULL),
(2, 'DBZR', 'DB真人', '0.00', NULL, NULL, 1, 1, '2022-09-21 07:52:50', '2026-01-14 16:35:41', 456, '2022-12-10/34b0d0879727da0ac11d8f09c0bf7206.png'),
(3, 'DBDZ', 'DB电子', '0.00', NULL, NULL, 1, 1, '2022-09-21 07:52:50', '2026-01-15 09:11:48', 456, '2022-12-10/29f965aa6f6c7f53ec744f8f81367f89.png'),
(4, 'EVO', 'EVO', '0.00', NULL, NULL, 1, 1, '2022-09-21 07:52:50', '2026-01-15 09:12:00', 456, '2022-12-10/a03c7574ec65635dd2fa0be9c3dfae30.png'),
(6, 'DBKY', '开元棋牌', '0.00', NULL, NULL, 1, 1, '2022-09-21 07:52:50', '2026-01-15 13:18:17', 456, '2022-12-10/02e1e771fc11b5c305a5c38ef75327f8.png'),
(8, 'GMAG', 'GMAG', '0.00', NULL, NULL, 1, 1, '2022-09-21 07:52:50', '2026-01-15 16:54:10', 456, '2022-12-10/fd670b28cc73897394d5860bcbdd876a.png'),
(9, 'DBTY', 'DB熊猫', '0.00', NULL, NULL, 1, 1, '2022-09-21 07:52:50', '2026-01-17 00:34:35', 456, '2022-12-10/fdd6464a91ff4072171c51191bed0973.png'),
(10, 'GDQ', '高登棋牌', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:37', 456, '2022-12-10/0d47127eabbeb54a8b50e18680f5d1b1.png'),
(12, 'JOKER', 'JOKER电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:38', 456, '2022-12-10/ea64e03cf9445ff05365a5807899ce35.png'),
(13, 'IA', '小艾电竞', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:40', 456, '2022-12-10/d5daebc9c6e25d73aef775d8912da86c.png'),
(14, 'TFG', '雷火电竞', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:40', 456, '2022-12-10/c767fe5e41e28806806166de3271f248.png'),
(15, 'SBO', 'SBO体育', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:41', 456, '2022-12-10/cc37cf3a3067ee1241c636181fe0efba.png'),
(16, 'IBC', '沙巴体育', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:44', 456, '2022-12-10/60941e7420bd0f69f5264935585dd2db.png'),
(18, 'CQ9', 'CQ9电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:45', 456, '2022-12-10/b222863f90f72ac5b9c9ca6c0d06c04a.png'),
(19, 'TCG', '天成彩票', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:45', 1, '2022-12-10/87ce1f54217ee9a36ba076c0ce7bf755.png'),
(20, 'JDB', 'JDB电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:48', 456, '2022-12-10/9d95c017879d998fb7bfa0f5d59e2e25.png'),
(21, 'BG', 'BG视讯', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:46', 456, '2022-12-10/ff36d9083bc8bd3b9089a711fac89f4c.png'),
(22, 'PNG', 'PNG电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:47', 456, '2022-12-10/6680ea7f6b59d9f7e6d6047dfff35ccb.png'),
(25, 'AB', '欧博视讯', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:49', 456, '2022-12-10/34263f1185042143a51ec817466e74b6.png'),
(26, 'PG', 'PG电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:32:50', 456, '2022-12-10/2b67c357e356449b591ec75f15c3e5e2.png'),
(27, 'PP', 'PP电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:01', 456, '2022-12-10/f5b2e7a8e1342aec883c656073429bc1.png'),
(29, 'PT', 'PT电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:01', 456, '2022-12-10/bd333f8231b7101938a5942e78ed0bed.png'),
(31, 'MG', 'MG电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:02', 456, '2022-12-10/2ff88c76c1243400a8a39661af0e9386.png'),
(32, 'LEG', '乐游棋牌', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:03', 456, '2022-12-10/5b82c2e84b89fab29f8d011e2f23d17e.png'),
(33, 'SS', '三晟体育', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:05', 456, '2022-12-10/1455a676afa5fbb98fc48d8742822d35.png'),
(34, 'DG', 'DG视讯', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:04', 456, '2022-12-10/6f2748a19cb90d7329b558c49525ac48.png'),
(35, 'KX', '凯旋棋牌', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:06', 456, '2022-12-10/f98b24a4520bf15283f4654bf287942f.png'),
(36, 'NW', '新世界棋牌', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:08', 456, '2022-12-10/d973c39a5471129cbc0b902420fe4dfc.png'),
(37, 'OBCP', 'DB彩票', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:07', 456, '2022-12-10/308b2397efc6830af41093cd229158a4.png'),
(38, 'WALI', '瓦力棋牌', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:12', 456, '2022-12-10/5d414b3d63d1cb7ede1ed11946302d95.png'),
(39, 'VR', 'VR彩票', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:25', 456, '2022-12-10/d93a4a87bcf6d59ebbd04c2f2e22b803.png'),
(41, 'EVO', 'EVO视讯', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:13', 456, '2022-12-10/6d37ae7287bc58ab5e907b928b8836b2.png'),
(42, 'SEXY', 'SEXY视讯', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:14', 456, '2022-12-10/1a443a9dd1c857002f3da34f3c456021.png'),
(43, 'CMD', 'CMD体育', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:15', 456, '2022-12-10/bef1de28d5e6d9c769909addb7c52803.png'),
(45, 'XJ', '小金体育', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:15', 456, '2022-12-10/3b8883928eda8477a3119e27e911bf50.png'),
(46, 'HG', '皇冠体育', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:16', 456, '2022-12-10/fcc634fe211f9cf38cfe23de6d10aed3.png'),
(47, 'NEWBB', 'NEWBB体育', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:23', 456, '2022-12-10/e453f7efd42c0a101dc9b6859332b5aa.png'),
(48, 'BBCARD', 'BB棋牌', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:22', 456, '2022-12-10/10d74c139a46bbf69dcec9a8b435a5d7.png'),
(50, 'AI', 'AI体育', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:22', 456, '2022-12-10/e97771b98e2cdc7e73f12a4d7b775654.png'),
(52, 'MT', '美天棋牌', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:21', 456, '2022-12-10/0c46cecc8ae8d99f5375ba66b1b34e87.png'),
(53, 'SGWIN', '双赢彩票', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:51', 456, '2022-12-10/73de23e622c8c56df02859cdfbf0f2f8.png'),
(54, 'LG', '幸运棋牌', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:51', 456, '2022-12-10/994bb70d041248819884380f6c39e0de.png'),
(55, 'IM', 'IM体育', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:50', 456, '2022-12-10/5c665e75a0b974efd31cff04e8fad37d.png'),
(57, 'FC', '发财电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:50', 456, '2022-12-10/1b4579a1ec60c5eccb77d7e630885c04.png'),
(58, 'SG', 'SG电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:49', 456, '2022-12-10/be08e07728f48b2ce72369c2e02b9eab.png'),
(59, 'AECP', 'AE彩票', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:48', 456, '2022-12-10/60183de692615bb0887fb16436cadcd4.png'),
(60, 'MW', 'MW电子', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:48', 456, '2022-12-10/b251c50c3d8383aa50fcb2be78f81d0e.png'),
(61, 'IGSS', 'IG彩票', '0.00', NULL, NULL, 0, 1, '2022-09-21 07:52:50', '2026-01-15 22:33:47', 456, '2022-12-10/92cdf187a3abf72325de80d5abeb2207.png'),
(62, 'FB', 'FB体育', '0.00', NULL, NULL, 0, 1, '2022-09-24 09:05:25', '2026-01-15 22:33:47', 0, '2022-12-10/87157af028b9206c536bdfaf0728ad56.png'),
(63, 'TH', '天豪棋牌', '0.00', NULL, NULL, 0, 1, '2022-09-24 09:05:25', '2026-01-15 22:33:39', NULL, '2022-12-14/825a998394c0d34324a974a66a529f76.png'),
(64, 'WELIVE', 'WE视讯', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:33:43', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(65, 'XGPS', 'GPS电子', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:33:38', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(66, 'XGPS', 'GPS电子', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:33:41', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(67, 'AS', 'AS棋牌', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:33:37', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(68, 'VG', 'VG财神棋牌', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:33:36', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(69, 'SGCARD', '双赢棋牌', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:33:40', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(70, 'FG', 'FG乐游', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:33:35', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(71, 'PB', '平博体育', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:33:35', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(72, 'OG', 'OG真人', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:33:34', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(73, 'CG', 'CG电子', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:33:34', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(74, 'YBCP', '优博彩票', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:00', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(75, 'GW', '世彩彩票', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:01', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(76, 'SBOS', 'FUNKY GAME', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:13', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(77, 'MGQP', 'MG棋牌', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:11', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(78, 'YOO', '云游棋牌', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:04', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(79, 'OBTY', '熊猫体育', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:05', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(80, 'AGDZ', 'PLAYACE', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:06', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(81, 'OBBY', 'DB捕鱼', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:07', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(82, 'OBQP', 'DB棋牌', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:08', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(83, 'OBDZ', 'DB电子', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:09', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(85, 'RSG', 'RSG电子', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:15', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(86, 'TP', 'TP电子', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:15', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(87, 'DLCP', '大力彩票', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:16', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(88, 'EG', 'EG电子', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:17', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(89, 'HLQP', '欢乐棋牌', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:23', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(90, 'BGQP', 'BG棋牌', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:22', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(91, 'LB', 'LB彩票', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:21', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(92, 'DPZR', 'DP真人', '0.00', NULL, NULL, 1, 1, '2025-09-06 07:07:23', '2026-01-17 00:43:16', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(93, 'DBDJ', 'DB电竞', '0.00', NULL, NULL, 1, 1, '2025-09-06 07:07:23', '2026-01-17 00:43:20', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(94, 'DPTY', 'DP体育', '0.00', NULL, NULL, 1, 1, '2025-09-06 07:07:23', '2026-01-17 00:43:17', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(95, 'VIA', 'VIA视讯', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2025-10-18 16:54:32', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png'),
(96, 'IMDJ', 'IM电竞', '0.00', NULL, NULL, 0, 1, '2025-09-06 07:07:23', '2026-01-15 22:34:28', 0, '2025-09-06/e87264f7e0ecac2fccfb74db27768987.png');

-- --------------------------------------------------------

--
-- 表的结构 `articles`
--

CREATE TABLE `articles` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `enname` varchar(255) DEFAULT NULL,
  `cateid` int(10) DEFAULT NULL,
  `content` longtext,
  `encontent` longtext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stor` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `articles`
--

INSERT INTO `articles` (`id`, `name`, `enname`, `cateid`, `content`, `encontent`, `created_at`, `updated_at`, `stor`) VALUES
(20, '重要活动', '重要活动', 6, '<p>尊敬的客户：星乐最新官方域名&nbsp; &nbsp;bot.leyu666.lol&nbsp; &nbsp;感谢您的支持与信任！祝您游戏愉快！</p>', '<p>尊敬的客户：星乐最新官方域名&nbsp; &nbsp;bot.leyu666.lol&nbsp; &nbsp;感谢您的支持与信任！祝您游戏愉快！</p>', '2026-01-09 23:10:17', '2026-01-09 23:10:17', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `articlescate`
--

CREATE TABLE `articlescate` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `articlescate`
--

INSERT INTO `articlescate` (`id`, `name`, `Created_at`, `Updated_at`) VALUES
(1, '新手帮助', NULL, NULL),
(2, '隐私保护', NULL, NULL),
(3, '规则条款', NULL, NULL),
(4, '联系我们', NULL, NULL),
(5, '代理加盟', NULL, NULL),
(6, '网站公告', NULL, NULL),
(7, '关于我们', NULL, NULL),
(8, '联络我们', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '银行代码',
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '银行名称',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `max_amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '最大限额',
  `bank_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `banks`
--

INSERT INTO `banks` (`id`, `code`, `bank_name`, `order`, `max_amount`, `bank_img`, `state`, `created_at`, `updated_at`) VALUES
(1, 'nyyh', '中国农业银行', 1, '20000.00', 'Abc', 1, '2021-01-07 11:27:45', '2021-01-07 11:27:45'),
(2, 'ZGYH', '中国银行', 2, '0.00', 'Boc', 1, '2021-04-16 08:14:41', '2021-04-16 08:19:14'),
(6, 'JTYH', '交通银行', 0, '0.00', 'Bocom', 1, '2021-05-14 05:50:54', '2021-05-14 05:50:54'),
(7, 'TYPE', '工商银行', 1, '1111.00', NULL, 1, '2021-05-15 05:47:55', '2022-04-30 10:54:37'),
(8, 'JSYH', '建设银行', 0, '500000.00', NULL, 1, '2022-05-01 09:09:17', '2022-05-01 09:09:17'),
(9, 'ZXYH', '中信银行', 0, '500000.00', NULL, 1, '2022-05-01 09:09:54', '2022-05-01 09:10:15'),
(10, 'xyyh', '兴业银行', 0, '500000.00', NULL, 1, '2022-05-01 09:10:41', '2022-05-01 09:10:41'),
(11, 'GDYH', '光大银行', 0, '0.00', NULL, 1, '2022-05-01 09:11:12', '2022-05-01 09:11:12'),
(12, 'MSYH', '民生银行', 0, '500000.00', NULL, 1, '2022-05-01 11:43:15', '2022-05-01 11:43:15');

-- --------------------------------------------------------

--
-- 表的结构 `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1pc banner 2移动端',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '标题',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片地址',
  `jump_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '跳转链接',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1显示 0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `banners`
--

INSERT INTO `banners` (`id`, `type`, `title`, `pic`, `jump_url`, `order`, `state`, `created_at`, `updated_at`) VALUES
(2, 1, '1', '2025-09-06/f57aafda0e4fe086e30129ba26a28906.png', '/sport', 1, 1, '2021-10-20 03:03:50', '2025-09-06 05:49:26'),
(3, 1, '2', '2025-09-06/6d8d252fdaceb9516fd3e3285757b81e.jpg', '/member/game?plat_name=dl&game_type=2', 2, 1, '2021-10-20 03:07:36', '2025-09-06 05:50:58'),
(4, 1, '3', '2025-09-06/b680857b7082318719e24878a39a8365.png', '/member/game?plat_name=leg&game_type=7', 3, 1, '2021-10-20 03:09:23', '2025-09-06 05:49:50'),
(5, 1, '4', '2025-09-06/389a0df3172565404da191e17b3d7899.jpg', '/member/game?plat_name=bg&game_type=1', 4, 1, '2021-10-20 06:13:01', '2025-09-06 05:50:02'),
(6, 1, '5', '2025-09-06/8cf876fca5d5dfe40064c37e611b15ab.jpg', '/member/game?plat_name=hc&game_type=2', 5, 1, '2021-10-20 06:14:55', '2025-09-06 05:50:16'),
(7, 1, '6', '2025-09-06/9cef4283bfca1bb01bf215b8053c6279.jpg', '/sport', 0, 1, '2022-04-13 02:11:37', '2025-09-06 05:50:44'),
(8, 2, '1', '2025-09-06/5ddea2ea37ad24b01dd9b9444808507d.png', '/pages/discount/index', 1, 1, '2022-04-26 02:36:19', '2025-09-06 05:52:07'),
(9, 2, '2', '2025-09-06/6bbfd87ca13dc2e344ac3c23c3894eae.png', '/pages/discount/index', 2, 1, '2022-04-26 02:36:39', '2025-09-06 05:52:21'),
(10, 2, '3', '2025-09-06/b37d0d416a0f19a175d2aa65cc5fc788.jpg', '/pages/discount/index', 3, 1, '2022-04-26 02:37:00', '2025-09-06 05:52:32'),
(11, 2, '4', '2025-09-06/451b74b13fe5ae7b5a4c5f79af4368ed.jpg', '/pages/discount/index', 4, 1, '2022-04-26 02:37:21', '2025-09-06 05:52:44'),
(12, 2, '5', '2025-09-06/8d04f5e767bd70faedc2a3e47eba98f6.jpg', '/pages/discount/index', 5, 1, '2022-04-26 02:37:42', '2025-09-06 05:53:00');

-- --------------------------------------------------------

--
-- 表的结构 `code_pay`
--

CREATE TABLE `code_pay` (
  `id` int(11) NOT NULL,
  `mch_id` varchar(255) DEFAULT NULL COMMENT '商户号',
  `key` varchar(255) DEFAULT NULL COMMENT 'key',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  `status` int(1) DEFAULT '1' COMMENT '0禁用1启用',
  `payimg` varchar(255) DEFAULT NULL,
  `min_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `max_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `code_pay`
--

INSERT INTO `code_pay` (`id`, `mch_id`, `key`, `content`, `status`, `payimg`, `min_price`, `max_price`, `created_at`, `updated_at`) VALUES
(3, 'weixin', NULL, '微信收款码', 1, 'images/02e88a2a1131259edb6885547945f3a1.png', '100.00', '10000000.00', '2022-04-23 07:24:30', '2022-11-26 02:42:35'),
(4, '12312345678@qq.com', NULL, '支付宝二维码', 1, 'images/27beb1828ddbbc82e1ac788e97055c22.png', '100.00', '1000000.00', '2021-05-08 13:38:41', '2022-11-26 02:42:55');

-- --------------------------------------------------------

--
-- 表的结构 `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `gamereport`
--

CREATE TABLE `gamereport` (
  `id` int(10) NOT NULL,
  `uid` int(10) DEFAULT '0',
  `addtime` int(10) DEFAULT '0',
  `pid` int(10) DEFAULT '0',
  `recnum` int(10) DEFAULT '0',
  `rechangenum` int(10) DEFAULT '0',
  `totalrechange` decimal(10,2) DEFAULT '0.00',
  `withdrawnum` int(10) DEFAULT '0',
  `totalwithdraw` decimal(10,2) DEFAULT '0.00',
  `betnum` int(10) DEFAULT NULL COMMENT '下注次数',
  `totalbet` decimal(10,2) DEFAULT '0.00',
  `totalvalidamount` decimal(10,2) DEFAULT NULL COMMENT '有效下注',
  `totalwinloss` decimal(10,2) DEFAULT '0.00',
  `redpackectnum` int(10) DEFAULT '0',
  `totalredpackect` decimal(10,2) DEFAULT '0.00',
  `releasewater` decimal(10,2) DEFAULT NULL COMMENT '返水',
  `rakeback` decimal(10,2) DEFAULT NULL COMMENT '返佣金',
  `rakebacknum` int(10) DEFAULT NULL COMMENT '返佣金次数',
  `releasewaternum` int(10) DEFAULT NULL COMMENT '返水次数',
  `isagent` int(1) DEFAULT '0',
  `updated_at` varchar(20) DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `game_categories`
--

CREATE TABLE `game_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pid` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '游戏类目名称',
  `image` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '类目编码',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序，数字越小越靠前',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `game_categories`
--

INSERT INTO `game_categories` (`id`, `pid`, `name`, `image`, `code`, `order`, `created_at`, `updated_at`) VALUES
(1, 0, '真人', '2026-01-17/5ca8ee3da61f27e2f6263193221e6863.png', 'realbet', 0, '2025-12-27 13:58:09', '2026-01-17 02:26:38'),
(2, 0, '体育', '2026-01-17/e69a4031161f50f2388a7339f94927e6.png', 'sport', 1, '2025-12-27 13:58:09', '2026-01-17 02:27:54'),
(3, 0, '电子', '2026-01-17/b0fcef606865dcfe494dc1f9ed050e9d.png', 'concise', 2, '2025-12-27 13:58:09', '2026-01-17 02:29:06'),
(4, 0, '电竞', '2026-01-16/a2e4677a213b43683571a42420c8bd43.png', 'gaming', 3, '2025-12-27 13:58:09', '2026-01-16 15:39:31'),
(5, 0, '棋牌', '2026-01-16/c8da3fb0e62b035db68959ad314a699b.png', 'joker', 4, '2025-12-27 13:58:09', '2026-01-16 15:39:54'),
(6, 0, '彩票', '2026-01-16/a4dd695021a69b1c8e01199f659995e6.png', 'lottery', 5, '2025-12-27 13:58:09', '2026-01-16 15:40:35'),
(7, 0, '捕鱼', '2026-01-16/d3cffe9c15e265f3cad9685f231a0208.png', 'fishing', 6, '2025-12-27 13:58:09', '2026-01-16 15:41:42');

-- --------------------------------------------------------

--
-- 表的结构 `game_lists`
--

CREATE TABLE `game_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `platform_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '平台名称',
  `with_api` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '游戏名称',
  `name_en` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '游戏英文名称',
  `keywords` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '关键词',
  `venue_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `game_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `game_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `game_title_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分类id',
  `tag_id` bigint(20) DEFAULT NULL,
  `order_by` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `transferstatus` tinyint(4) NOT NULL DEFAULT '0',
  `is_hot` int(11) NOT NULL DEFAULT '0' COMMENT '1热门游戏 0不是',
  `is_new` int(11) NOT NULL DEFAULT '0' COMMENT '1最新游戏 0不是',
  `is_recommend` int(11) NOT NULL DEFAULT '0' COMMENT '1推荐游戏 0不是',
  `is_pc` int(11) NOT NULL DEFAULT '1' COMMENT '1pc显示 0不是',
  `is_mobile` int(11) NOT NULL DEFAULT '1' COMMENT '1手机展示 0不是',
  `site_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '网站状态',
  `app_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'app状态',
  `is_top` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是顶级分类',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `check_yes_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_no_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_logo_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `game_lists`
--

INSERT INTO `game_lists` (`id`, `platform_name`, `with_api`, `name`, `name_en`, `keywords`, `venue_code`, `game_code`, `game_icon`, `game_title_img`, `category_id`, `tag_id`, `order_by`, `transferstatus`, `is_hot`, `is_new`, `is_recommend`, `is_pc`, `is_mobile`, `site_state`, `app_state`, `is_top`, `created_at`, `updated_at`, `check_yes_img`, `check_no_img`, `mobile_img`, `api_logo_img`, `app_img`, `app_icon`, `header_logo`) VALUES
(635, 'DBZR', 'dbzhenren', 'DB真人', NULL, NULL, NULL, '0', NULL, NULL, 'realbet', NULL, 0, 1, 1, 0, 0, 1, 1, 1, 1, 1, '2022-09-24 07:04:46', '2026-01-14 16:35:19', NULL, NULL, 'images/sx2.png', 'images/pcsx (1).png', 'images/hotsx (3).jpg', NULL, NULL),
(636, 'DBDZ', 'dbdianzi', 'DB电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 07:16:41', '2026-01-15 23:38:12', '', '', 'images/sx1.png', 'images/pcsx (2).png', 'images/hotsx (4).jpg', NULL, NULL),
(637, 'EVO', 'dbevo', 'EVO', NULL, NULL, NULL, '0', NULL, NULL, 'realbet', NULL, 0, 1, 1, 0, 0, 1, 1, 1, 1, 1, '2022-09-24 07:45:00', '2026-01-15 09:11:22', '', '', 'images/sx6.png', 'images/pcsx (3).png', 'images/hotsx (5).jpg', NULL, NULL),
(638, 'DBKY', 'dbkaiyuan', '开元棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 1, 0, 0, 1, 1, 1, 1, 1, '2022-09-24 07:46:11', '2026-01-15 13:21:30', '', '', 'images/sx5.png', 'images/pcsx (4).png', 'images/hotsx (6).jpg', NULL, NULL),
(639, 'GMAG', 'dbgmag', 'MG真人', NULL, NULL, NULL, 'mg_smm', NULL, NULL, 'realbet', NULL, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, '2026-01-16 20:13:57', '2026-01-17 02:41:08', NULL, NULL, 'images/sx3.png', 'images/pcsx (4).png', 'images/hotsx (6).jpg', NULL, NULL),
(640, 'GMAG', 'dbgmag', 'BTI Game', 'BTI Game', NULL, NULL, 'bti-games', NULL, NULL, 'sport', NULL, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, '2026-01-16 20:13:57', '2026-01-16 20:14:45', NULL, NULL, 'images/sx3.png', 'images/pcsx (4).png', 'images/hotsx (6).jpg', NULL, NULL),
(641, 'GMAG', 'dbgmag', 'Lobby', 'Lobby', NULL, NULL, 'cq9_lobby', NULL, NULL, 'concise', NULL, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, '2026-01-16 20:13:57', '2026-01-16 20:14:45', NULL, NULL, 'images/sx3.png', 'images/pcsx (4).png', 'images/hotsx (6).jpg', NULL, NULL),
(642, 'GMAG', 'dbgmag', 'JDB游戏大厅', 'JDB Lobby', NULL, NULL, 'jdb_lobby', NULL, NULL, 'concise', NULL, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, '2026-01-16 20:13:57', '2026-01-16 20:14:45', NULL, NULL, 'images/sx3.png', 'images/pcsx (4).png', 'images/hotsx (6).jpg', NULL, NULL),
(643, 'GMAG', 'dbgmag', 'Poker lobby', 'Poker lobby', NULL, NULL, 'lobby_launch_chel', NULL, NULL, 'realbet', NULL, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, '2026-01-16 20:13:57', '2026-01-17 02:02:29', NULL, NULL, 'images/sx3.png', 'images/pcsx (4).png', 'images/hotsx (6).jpg', NULL, NULL),
(645, 'DG', 'dp', 'DG视讯', NULL, NULL, 'dg_zr', '0', NULL, NULL, 'realbet', NULL, 0, 1, 1, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 08:31:53', '2026-01-01 09:43:25', '', '', 'images/sx1.png', 'images/pcsx (8).png', 'images/hotsx (10).jpg', NULL, NULL),
(646, 'EVO', NULL, 'EVO视讯', NULL, NULL, NULL, '0', NULL, NULL, 'realbet', NULL, 0, 1, 1, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 08:33:48', '2025-08-27 11:58:14', '', '', 'images/sx6.png', 'images/pcsx (9).png', 'images/hotsx (11).jpg', NULL, NULL),
(647, 'SEXY', NULL, 'SEXY视讯', NULL, NULL, NULL, '0', NULL, NULL, 'realbet', NULL, 0, 1, 1, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 08:35:05', '2025-09-06 07:56:58', '', '', 'images/sx5.png', 'images/pcsx (10).png', 'images/hotsx (12).jpg', NULL, NULL),
(649, 'DPTY', 'dp', '熊猫体育', NULL, NULL, 'ty', '0', NULL, NULL, 'sport', NULL, 0, 1, 1, 0, 0, 1, 1, 1, 1, 1, '2022-09-24 08:56:51', '2026-01-17 00:44:11', '', '', 'images/ty1.png', 'images/pcty (1).png', 'images/hotty (1).jpg', NULL, NULL),
(650, 'SBO', 'dp', 'SBO体育', NULL, NULL, 'sbo_ty', '0', NULL, NULL, 'sport', NULL, 0, 1, 1, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 08:59:02', '2026-01-01 09:43:36', '', '', 'images/ty2.png', 'images/pcty (2).png', 'images/hotty (2).jpg', NULL, NULL),
(651, 'IBC', 'dp', '沙巴体育', NULL, NULL, 'sb_ty', '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 08:59:56', '2026-01-01 09:43:44', '', '', 'images/ty3.png', 'images/pcty (3).png', 'images/hotty (3).jpg', NULL, NULL),
(652, 'BBIN', NULL, 'BBIN体育', NULL, NULL, NULL, '0', NULL, NULL, 'sport', NULL, -1, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:00:59', '2025-08-31 14:50:34', '', '', 'images/ty1.png', 'images/pcty (1).png', 'images/hotty (4).jpg', NULL, NULL),
(653, 'SS', NULL, '三晟体育', NULL, NULL, NULL, '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:02:29', '2022-12-08 01:14:01', '', '', 'images/ty2.png', 'images/pcty (2).png', 'images/hotty (5).jpg', NULL, NULL),
(654, 'CMD', NULL, 'CMD体育', NULL, NULL, NULL, '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:03:44', '2022-12-08 01:15:07', '', '', 'images/ty3.png', 'images/pcty (3).png', 'images/hotty (6).jpg', NULL, NULL),
(655, 'FB', 'dp', 'FB体育', NULL, NULL, 'fb_ty', '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:04:58', '2026-01-01 09:43:53', '', '', 'images/ty1.png', 'images/pcty (1).png', 'images/hotty (7).jpg', NULL, NULL),
(656, 'XJ', NULL, '小金体育', NULL, NULL, NULL, '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:07:05', '2022-12-08 01:17:07', '', '', 'images/ty2.png', 'images/pcty (2).png', 'images/hotty (8).jpg', NULL, NULL),
(657, 'HG', NULL, '皇冠体育', NULL, NULL, NULL, '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:08:48', '2022-12-07 13:35:51', '', '', 'images/ty3.png', 'images/pcty (3).png', 'images/hotty (9).jpg', NULL, NULL),
(658, 'AI', NULL, 'AI体育', NULL, NULL, NULL, '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:11:14', '2022-12-08 01:19:07', '', '', 'images/ty1.png', 'images/pcty (1).png', 'images/hotty (10).jpg', NULL, NULL),
(661, 'IA', NULL, '小艾电竞', NULL, NULL, NULL, '0', NULL, NULL, 'gaming', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:24:54', '2025-09-01 04:50:06', '', '', 'images/dj1.png', 'images/pcdj1.png', 'images/hotdj (1).jpg', NULL, NULL),
(662, 'TFG', NULL, '雷火电竞', NULL, NULL, 'lh_dj', '0', NULL, NULL, 'gaming', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:46:07', '2025-12-29 14:43:07', '', '', 'images/dj3.png', 'images/pcdj2.png', 'images/hotdj (2).jpg', NULL, NULL),
(663, 'IMDJ', NULL, 'IM电竞', NULL, NULL, 'im_dj', '0', NULL, NULL, 'gaming', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:47:25', '2025-12-29 14:41:57', '', '', 'images/dj2.png', 'images/pcdj1.png', 'images/hotdj (3).jpg', NULL, NULL),
(664, 'OBQP', NULL, 'DB棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:53:09', '2025-12-29 15:53:42', '', '', 'images/qp5.png', 'images/pcqp (1).png', 'images/htqp (1).jpg', NULL, NULL),
(665, 'BBCARD', NULL, 'BBIN棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 09:55:28', '2025-08-27 11:57:27', '', '', 'images/qp4.png', 'images/pcqp (2).png', 'images/htqp (2).jpg', NULL, NULL),
(666, 'KY', NULL, '开元棋牌', NULL, NULL, 'ky_qp', '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, '2022-09-24 10:23:48', '2025-12-29 15:53:04', '', '', 'images/qp3.png', 'images/pcqp (3).png', 'images/htqp (3).jpg', NULL, NULL),
(667, 'BL', NULL, '博乐棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 10:25:33', '2025-08-27 11:57:28', '', '', 'images/qp2.png', 'images/pcqp (4).png', 'images/htqp (4).jpg', NULL, NULL),
(668, 'GDQ', NULL, '高登棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 10:27:46', '2025-08-27 11:57:28', '', '', 'images/qp1.png', 'images/pcqp (5).png', 'images/htqp (5).jpg', NULL, NULL),
(669, 'TH', NULL, '天豪棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 10:29:24', '2025-08-27 11:57:29', '', '', 'images/qp5.png', 'images/pcqp (6).png', 'images/htqp (6).jpg', NULL, NULL),
(670, 'LEG', NULL, '乐游棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 10:31:03', '2025-08-27 11:57:30', '', '', 'images/qp4.png', 'images/pcqp (1).png', 'images/htqp (7).jpg', NULL, NULL),
(671, 'KX', NULL, '凯旋棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 10:32:15', '2025-08-27 11:57:31', '', '', 'images/qp3.png', 'images/pcqp (2).png', 'images/htqp (8).jpg', NULL, NULL),
(672, 'NW', NULL, '新世界棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 10:32:59', '2025-08-27 11:57:31', '', '', 'images/qp2.png', 'images/pcqp (3).png', 'images/htqp (9).jpg', NULL, NULL),
(674, 'WALI', NULL, '瓦力棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 10:35:59', '2025-08-27 11:57:32', '', '', 'images/qp1.png', 'images/pcqp (4).png', 'images/htqp (10).jpg', NULL, NULL),
(675, 'MT', NULL, '美天棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 10:41:08', '2025-08-27 11:57:35', '', '', 'images/qp5.png', 'images/pcqp (5).png', 'images/htqp (11).jpg', NULL, NULL),
(676, 'LG', NULL, '幸运棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 11:52:36', '2025-08-27 11:57:36', '', '', 'images/qp4.png', 'images/pcqp (6).png', 'images/htqp (12).jpg', NULL, NULL),
(678, 'OBCP', NULL, 'DB彩票', NULL, NULL, 'cp', '0', NULL, NULL, 'lottery', NULL, 10, 1, 0, 0, 0, 1, 1, 1, 1, 1, '2022-09-24 11:59:51', '2025-12-29 14:39:48', '', '', 'images/cp3.png', 'images/pccp (1).png', 'images/hotcp (1).jpg', NULL, NULL),
(679, 'BBIN', NULL, 'BBIN彩票', NULL, NULL, NULL, '0', NULL, NULL, 'lottery', NULL, 9, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 12:01:50', '2025-09-01 04:59:55', '', '', 'images/cp2.png', 'images/pccp (2).png', 'images/hotcp (2).jpg', NULL, NULL),
(680, 'TCG', NULL, '天成彩票', NULL, NULL, 'tc_cp', '0', NULL, NULL, 'lottery', NULL, 8, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 12:04:20', '2025-12-29 14:41:19', '', '', 'images/cp1.png', 'images/pccp (3).png', 'images/hotcp (3).jpg', NULL, NULL),
(681, 'SGWIN', NULL, '双赢彩票', NULL, NULL, NULL, '0', NULL, NULL, 'lottery', NULL, 7, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 12:06:40', '2025-09-01 05:00:47', '', '', 'images/cp3.png', 'images/pccp (4).png', 'images/hotcp (4).jpg', NULL, NULL),
(682, 'IGSS', NULL, 'IG时时彩', NULL, NULL, NULL, 'SSC', NULL, NULL, 'lottery', NULL, 6, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 12:13:36', '2025-09-01 05:02:44', NULL, NULL, 'images/cp2.png', 'images/pccp (5).png', 'images/hotcp (5).jpg', NULL, NULL),
(683, 'IGSS', NULL, 'IG官方彩', NULL, NULL, NULL, 'GFC', NULL, NULL, 'lottery', NULL, 5, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 12:14:45', '2025-09-01 05:03:04', '', '', 'images/cp1.png', 'images/pccp (1).png', 'images/hotcp (6).jpg', NULL, NULL),
(684, 'IGSS', NULL, 'IG香港彩', NULL, NULL, NULL, 'XGC', NULL, NULL, 'lottery', NULL, 4, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 12:15:48', '2025-09-01 05:04:15', '', '', 'images/cp3.png', 'images/pccp (2).png', 'images/hotcp (7).jpg', NULL, NULL),
(685, 'VR', NULL, 'VR彩票', NULL, NULL, 'vr_cp', '0', NULL, NULL, 'lottery', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 12:18:10', '2025-12-29 14:40:49', '', '', 'images/cp2.png', 'images/pccp (3).png', 'images/hotcp (8).jpg', NULL, NULL),
(687, 'AGDZ', NULL, 'AG电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 13:38:26', '2025-08-27 11:57:44', '', '', 'images/dz5.png', 'images/pcdz (1).png', 'images/hotdz (1).jpg', NULL, NULL),
(688, 'BBIN', NULL, 'BBIN电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 13:40:32', '2025-08-27 11:57:44', '', '', 'images/dz4.png', 'images/pcdz (2).png', 'images/hotdz (2).jpg', NULL, NULL),
(689, 'OBDZ', NULL, 'DB电子', NULL, NULL, 'dz', '10', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, '2022-09-24 13:41:37', '2025-12-29 15:48:32', '', '', 'images/dz3.png', 'images/pcdz (3).png', 'images/hotdz (3).jpg', NULL, NULL),
(692, 'JOKER', NULL, 'JOKER电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 13:55:55', '2025-08-27 11:57:46', '', '', 'images/dz2.png', 'images/pcdz (4).png', 'images/hotdz (4).jpg', NULL, NULL),
(693, 'CQ9', NULL, 'CQ9电子', NULL, NULL, 'cq9_dz', '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 13:57:30', '2025-12-29 14:43:36', '', '', 'images/dz1.png', 'images/pcdz (5).png', 'images/hotdz (5).jpg', NULL, NULL),
(694, 'JDB', NULL, 'JDB电子', NULL, NULL, 'jdb_dz', '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 13:58:46', '2025-12-29 14:45:09', '', '', 'images/dz5.png', 'images/pcdz (6).png', 'images/hotdz (6).jpg', NULL, NULL),
(696, 'PNG', NULL, 'PNG电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 14:00:51', '2025-08-27 11:57:50', '', '', 'images/dz4.png', 'images/pcdz (1).png', 'images/hotdz (7).jpg', NULL, NULL),
(697, 'PG', NULL, 'PG电子', NULL, NULL, 'pg_dz', '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 14:01:11', '2025-12-29 14:46:29', '', '', 'images/dz3.png', 'images/pcdz (2).png', 'images/hotdz (8).jpg', NULL, NULL),
(698, 'PP', NULL, 'PP电子', NULL, NULL, 'pp_dz', '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 14:04:18', '2025-12-29 14:44:28', '', '', 'images/dz2.png', 'images/pcdz (3).png', 'images/hotdz (9).jpg', NULL, NULL),
(700, 'MG', NULL, 'MG电子', NULL, NULL, 'mg_dz', '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 14:06:29', '2025-12-29 14:46:01', '', '', 'images/dz1.png', 'images/pcdz (4).png', 'images/hotdz (10).jpg', NULL, NULL),
(701, 'PT', NULL, 'PT电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 14:06:48', '2025-08-27 11:57:53', '', '', 'images/dz5.png', 'images/pcdz (5).png', 'images/hotdz (11).jpg', NULL, NULL),
(703, 'SG', NULL, 'SG电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 14:12:54', '2025-08-27 11:57:54', '', '', 'images/dz4.png', 'images/pcdz (6).png', 'images/hotdz (12).jpg', NULL, NULL),
(704, 'FC', NULL, '发财电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 14:13:15', '2025-08-27 11:57:54', '', '', 'images/dz3.png', 'images/pcdz (1).png', 'images/hotdz (13).jpg', NULL, NULL),
(705, 'MW', NULL, 'MW电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 15:14:28', '2025-08-27 11:57:55', '', '', 'images/dz2.png', 'images/pcdz (2).png', 'images/hotdz (14).jpg', NULL, NULL),
(706, 'NEWBB', NULL, 'NEWBB体育', NULL, NULL, NULL, '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-09-24 15:38:08', '2022-12-08 01:19:20', '', '', 'images/ty2.png', 'images/pcty (2).png', 'images/hotty (11).jpg', NULL, NULL),
(707, 'JDB', NULL, '财神捕鱼', NULL, NULL, NULL, '7_7003', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 07:52:17', '2025-08-27 11:57:56', NULL, NULL, 'images/by3.png', 'images/pcby.png', 'images/hotby (1).jpg', NULL, NULL),
(708, 'JDB', NULL, '龙王捕鱼', NULL, NULL, NULL, '7_7001', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 07:53:27', '2025-08-27 11:57:57', NULL, NULL, 'images/by2.png', 'images/pcby.png', 'images/hotby (2).jpg', NULL, NULL),
(709, 'JDB', NULL, '龙王捕鱼2', NULL, NULL, NULL, '7_7002', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 07:54:02', '2025-08-27 11:57:57', NULL, NULL, 'images/by1.png', 'images/pcby.png', 'images/hotby (3).jpg', NULL, NULL),
(711, 'CQ9', NULL, '黄金渔场', NULL, NULL, NULL, 'AB3', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:21:10', '2025-08-27 11:57:58', NULL, NULL, 'images/by3.png', 'images/pcby.png', 'images/hotby (4).jpg', NULL, NULL),
(712, 'CQ9', NULL, '欢乐捕鱼', NULL, NULL, NULL, 'AT05', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:23:34', '2025-08-27 11:57:58', NULL, NULL, 'images/by2.png', 'images/pcby.png', 'images/hotby (5).jpg', NULL, NULL),
(713, 'CQ9', NULL, '一炮捕鱼', NULL, NULL, NULL, 'AT01', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:24:52', '2025-08-27 11:57:59', NULL, NULL, 'images/by1.png', 'images/pcby.png', 'images/hotby (6).jpg', NULL, NULL),
(714, 'JDB', NULL, '五龙捕鱼', NULL, NULL, NULL, '7_7004', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:54:33', '2025-08-27 11:58:00', NULL, NULL, 'images/by3.png', 'images/pcby.png', 'images/hotby (7).jpg', NULL, NULL),
(715, 'JDB', NULL, '捕鱼一路发', NULL, NULL, NULL, '7_7005', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:56:12', '2025-08-27 11:58:00', NULL, NULL, 'images/by2.png', 'images/pcby.png', 'images/hotby (8).jpg', NULL, NULL),
(716, 'JDB', NULL, '猎龙高手', NULL, NULL, NULL, '7_7006', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:56:42', '2025-08-27 11:58:01', NULL, NULL, 'images/by1.png', 'images/pcby.png', 'images/hotby (9).jpg', NULL, NULL),
(717, 'JDB', NULL, '捕鱼迪斯可', NULL, NULL, NULL, '7_7007', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:57:13', '2025-08-27 11:58:03', NULL, NULL, 'images/by3.png', 'images/pcby.png', 'images/hotby (10).jpg', NULL, NULL),
(718, 'LEG', NULL, '捕鱼大作战', NULL, NULL, NULL, '510', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:57:58', '2025-08-27 11:58:03', NULL, NULL, 'images/by2.png', 'images/pcby.png', 'images/hotby (11).jpg', NULL, NULL),
(719, 'KY', NULL, '红包捕鱼', NULL, NULL, NULL, '510', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:58:40', '2025-08-27 11:58:04', NULL, NULL, 'images/by1.png', 'images/pcby.png', 'images/hotby (12).jpg', NULL, NULL),
(720, 'KY', NULL, '李逵捕鱼', NULL, NULL, NULL, '520', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:59:04', '2025-08-27 11:58:04', NULL, NULL, 'images/by3.png', 'images/pcby.png', 'images/hotby (1).jpg', NULL, NULL),
(721, 'AT', NULL, '龙珠捕鱼', NULL, NULL, NULL, 'cmf0001', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:59:30', '2025-08-27 11:58:05', NULL, NULL, 'images/by2.png', 'images/pcby.png', 'images/hotby (2).jpg', NULL, NULL),
(722, 'AT', NULL, '神魔捕鱼', NULL, NULL, NULL, 'cmf0002', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 08:59:58', '2025-08-27 11:58:05', NULL, NULL, 'images/by1.png', 'images/pcby.png', 'images/hotby (3).jpg', NULL, NULL),
(723, 'AGDZ', NULL, 'PA捕鱼', NULL, NULL, NULL, '0', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 09:00:53', '2025-08-27 11:58:06', NULL, NULL, 'images/by3.png', 'images/pcby.png', 'images/hotby (4).jpg', NULL, NULL),
(724, 'OBBY', NULL, 'DB捕鱼', NULL, NULL, 'by', '834', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, '2022-12-07 09:01:26', '2025-12-29 15:55:00', NULL, NULL, 'images/by2.png', 'images/pcby.png', 'images/hotby (5).jpg', NULL, NULL),
(725, 'BBIN', NULL, 'BBIN捕鱼', NULL, NULL, NULL, '0', NULL, NULL, 'fishing', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2022-12-07 09:02:06', '2025-08-27 11:58:06', NULL, NULL, 'images/by1.png', 'images/pcby.png', 'images/hotby (6).jpg', NULL, NULL),
(726, 'IM', NULL, 'IM体育', NULL, NULL, NULL, '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:47:53', '2025-09-06 07:47:53', NULL, NULL, 'images/ty3.png', NULL, 'images/hotty (12).jpg', NULL, NULL),
(727, 'WELIVE', NULL, 'WE视讯', NULL, NULL, NULL, '0', NULL, NULL, 'realbet', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:48:31', '2025-09-06 07:48:31', NULL, NULL, 'images/sx4.png', 'images/pcsx (11).png', 'images/hotsx (13).jpg', NULL, NULL),
(728, 'XGPS', NULL, 'GPS电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:48:53', '2025-09-06 07:48:53', NULL, NULL, 'images/dz1.png', 'images/pcdz (3).png', 'images/hotdz (15).jpg', NULL, NULL),
(729, 'AS', NULL, 'AS棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:49:12', '2025-09-06 07:49:12', NULL, NULL, 'images/qp3.png', 'images/pcqp (1).png', 'images/htqp (13).jpg', NULL, NULL),
(730, 'VG', NULL, 'VG财神棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:49:28', '2025-09-06 07:49:28', NULL, NULL, 'images/qp2.png', 'images/pcqp (2).png', 'images/htqp (14).jpg', NULL, NULL),
(731, 'SGCARD', NULL, '双赢棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:49:47', '2025-09-06 07:49:47', NULL, NULL, 'images/qp1.png', 'images/pcqp (3).png', 'images/htqp (15).jpg', NULL, NULL),
(732, 'FG', NULL, 'FG乐游', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:50:05', '2025-09-06 07:50:05', NULL, NULL, 'images/qp5.png', 'images/pcqp (4).png', 'images/htqp (16).jpg', NULL, NULL),
(733, 'PB', NULL, '平博体育', NULL, NULL, NULL, '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:50:28', '2025-09-06 07:50:28', NULL, NULL, 'images/ty1.png', 'images/pcty (3).png', 'images/hotty (13).jpg', NULL, NULL),
(734, 'OG', NULL, 'OG视讯', NULL, NULL, NULL, '0', NULL, NULL, 'realbet', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:51:00', '2025-09-06 07:51:00', NULL, NULL, 'images/sx3.png', 'images/pcsx (12).png', 'images/hotsx (14).jpg', NULL, NULL),
(735, 'CG', NULL, 'CG电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:51:13', '2025-09-06 07:51:13', NULL, NULL, 'images/dz5.png', 'images/pcdz (4).png', 'images/hotdz (16).jpg', NULL, NULL),
(736, 'YBCP', NULL, '优博彩票', NULL, NULL, NULL, '0', NULL, NULL, 'lottery', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:51:30', '2025-09-06 07:51:30', NULL, NULL, 'images/cp1.png', 'images/pccp (4).png', 'images/hotcp (9).jpg', NULL, NULL),
(737, 'GW', NULL, '世彩彩票', NULL, NULL, NULL, '0', NULL, NULL, 'lottery', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:51:43', '2025-09-06 07:51:43', NULL, NULL, 'images/cp3.png', 'images/pccp (5).png', 'images/hotcp (10).jpg', NULL, NULL),
(738, 'SBOS', NULL, 'FUNKY GAME', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:52:13', '2025-09-06 07:52:13', NULL, NULL, 'images/dz4.png', 'images/pcdz (5).png', 'images/hotdz (17).jpg', NULL, NULL),
(739, 'MGQP', NULL, 'MG棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:52:27', '2025-09-06 07:52:27', NULL, NULL, 'images/qp4.png', 'images/pcqp (5).png', 'images/htqp (17).jpg', NULL, NULL),
(740, 'YOO', NULL, '云游棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:52:42', '2025-09-06 07:52:42', NULL, NULL, 'images/qp3.png', 'images/pcqp (6).png', 'images/htqp (18).jpg', NULL, NULL),
(741, 'RSG', NULL, 'RSG电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:52:57', '2025-09-06 07:52:57', NULL, NULL, 'images/dz3.png', 'images/pcdz (6).png', 'images/hotdz (18).jpg', NULL, NULL),
(742, 'TP', NULL, 'TP电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:53:11', '2025-09-06 07:53:11', NULL, NULL, 'images/dz2.png', 'images/pcdz (1).png', 'images/hotdz (19).jpg', NULL, NULL),
(743, 'DLCP', NULL, '大力彩票', NULL, NULL, NULL, '0', NULL, NULL, 'lottery', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:53:25', '2025-09-06 07:53:25', NULL, NULL, 'images/cp2.png', 'images/pccp (1).png', 'images/hotcp (1).jpg', NULL, NULL),
(744, 'EG', NULL, 'EG电子', NULL, NULL, NULL, '0', NULL, NULL, 'concise', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:53:36', '2025-09-06 07:53:36', NULL, NULL, 'images/dz1.png', 'images/pcdz (2).png', 'images/hotdz (20).jpg', NULL, NULL),
(745, 'HLQP', NULL, '欢乐棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:53:50', '2025-09-06 07:53:50', NULL, NULL, 'images/qp2.png', 'images/pcqp (1).png', 'images/htqp (19).jpg', NULL, NULL),
(746, 'BGQP', NULL, 'BG棋牌', NULL, NULL, NULL, '0', NULL, NULL, 'joker', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:54:06', '2025-09-06 07:54:06', NULL, NULL, 'images/qp1.png', 'images/pcqp(2).png', 'images/htqp (20).jpg', NULL, NULL),
(747, 'LB', NULL, 'LB彩票', NULL, NULL, NULL, '0', NULL, NULL, 'lottery', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:54:20', '2025-09-06 07:54:20', NULL, NULL, 'images/cp1.png', 'images/pccp (2).png', 'images/hotcp (2).jpg', NULL, NULL),
(748, 'DPZR', NULL, 'DP视讯', NULL, NULL, NULL, '0', NULL, NULL, 'realbet', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:54:48', '2025-09-06 07:54:48', NULL, NULL, 'images/sx2.png', 'images/pcsx (13).png', 'images/hotsx (1).jpg', NULL, NULL),
(749, 'DBDJ', 'dp', 'DB电竞', NULL, NULL, 'dj', '0', NULL, NULL, 'gaming', NULL, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, '2025-09-06 07:55:02', '2026-01-17 01:24:58', NULL, NULL, 'images/dj1.png', 'images/pcdj2.png', 'images/hotdj (4).jpg', NULL, NULL),
(750, 'DPTY', NULL, 'DP体育', NULL, NULL, NULL, '0', NULL, NULL, 'sport', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:55:20', '2025-09-06 07:55:20', NULL, NULL, 'images/ty2.png', 'images/pcty (1).png', 'images/hotty (14).jpg', NULL, NULL),
(751, 'VIA', NULL, 'VIA视讯', NULL, NULL, NULL, '0', NULL, NULL, 'realbet', NULL, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, '2025-09-06 07:55:32', '2025-09-06 07:55:32', NULL, NULL, 'images/sx1.png', 'images/pcsx (14).png', 'images/hotsx (2).jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `game_lists_app`
--

CREATE TABLE `game_lists_app` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `platform_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '平台名称',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '游戏名称',
  `name_en` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '游戏英文名称',
  `keywords` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '关键词',
  `game_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `game_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `game_title_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分类id',
  `tag_id` bigint(20) DEFAULT NULL,
  `order_by` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_hot` int(11) NOT NULL DEFAULT '0' COMMENT '1热门游戏 0不是',
  `app_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'app状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `app_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `game_lists_app`
--

INSERT INTO `game_lists_app` (`id`, `platform_name`, `name`, `name_en`, `keywords`, `game_code`, `game_icon`, `game_title_img`, `category_id`, `tag_id`, `order_by`, `is_hot`, `app_state`, `created_at`, `updated_at`, `app_img`, `app_icon`) VALUES
(707, 'LEG', '德州扑克', NULL, NULL, '620', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:14:05', '2022-12-06 16:04:03', 'images/686166e2358841cfacbb9c5c35985684.png', NULL),
(708, 'LEG', '二八杠', NULL, NULL, '720', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:14:47', '2022-12-06 14:14:47', 'images/39d4b3ed82355a3a16e9b36fcc32655b.png', NULL),
(709, 'LEG', '抢庄牛牛', NULL, NULL, '830', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:15:25', '2022-12-06 14:15:25', 'images/bbfedc6322982997574a0b119f56d171.png', NULL),
(710, 'LEG', '扎金花', NULL, NULL, '220', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:16:07', '2022-12-06 14:16:07', 'images/af768ffc81d504c18b69322264735cdd.png', NULL),
(711, 'LEG', '三公', NULL, NULL, '860', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:16:32', '2022-12-06 14:16:32', 'images/d3b3518d80efead4f713c7564396cece.png', NULL),
(712, 'LEG', '21点', NULL, NULL, '600', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:20:35', '2022-12-06 14:20:35', 'images/ab732996baf7d8b8cc2cf5065ffd85d3.png', NULL),
(713, 'LEG', '极速扎金花', NULL, NULL, '230', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:49:07', '2022-12-06 14:49:07', 'images/61eb363013fc55a6f64530bfffa16c79.png', NULL),
(714, 'LEG', '通比牛牛', NULL, NULL, '870', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:49:28', '2022-12-06 14:49:28', 'images/7a8e91a7a9e5d8020ee06b8ff6524536.png', NULL),
(715, 'LEG', '抢庄牌九', NULL, NULL, '730', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:49:52', '2022-12-06 14:49:52', 'images/2a7a297666aa38ee7b78beae78f78337.png', NULL),
(716, 'KY', '极速百家乐', NULL, NULL, '3001', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:52:31', '2022-12-06 14:52:31', 'images/fe8897989862e75b8004580d5d7723ad.png', NULL),
(717, 'KY', '文房四宝', NULL, NULL, '90010', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:52:57', '2022-12-06 14:52:57', 'images/ab243ade593acca1280f9e83003698f4.png', NULL),
(718, 'KY', '看牌抢庄三公', NULL, NULL, '2890', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:53:38', '2022-12-06 14:53:38', 'images/25a5524c0d091b2cd6e913dba386ca77.png', NULL),
(719, 'KY', '二人斗地主', NULL, NULL, '1640', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 14:54:12', '2022-12-06 16:05:05', 'images/7669dc10ad1d0d27c50229b3968eb1ea.png', NULL),
(730, 'KY', '红黑大战', NULL, NULL, '950', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 16:06:37', '2022-12-06 16:11:04', 'images/fd63a1b49de2f0f6296bf6d8c27a7d30.png', NULL),
(731, 'KY', '李逵捕鱼', NULL, NULL, '520', NULL, NULL, 'fishing', NULL, 99, 0, 1, '2022-12-06 16:07:22', '2022-12-06 16:07:22', 'images/da3b2e0c17d3f5cd8ce3b970017ec409.png', NULL),
(732, 'KY', '水果机', NULL, NULL, '1890', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 16:07:52', '2022-12-06 16:07:52', 'images/39480c3c32cdb607434599f284c42c91.png', NULL),
(733, 'KY', '鱼虾蟹', NULL, NULL, '1930', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 16:08:20', '2022-12-06 16:08:20', 'images/84b2de7cd3bd32c5b5f0ec295a102138.png', NULL),
(734, 'KY', '跑得快', NULL, NULL, '8130', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 16:08:52', '2022-12-06 16:08:52', 'images/21972bbbb600d49501bbef84e6f6b9fa.png', NULL),
(735, 'KY', '五星宏辉', NULL, NULL, '1970', NULL, NULL, 'joker', NULL, 0, 0, 1, '2022-12-06 16:09:24', '2022-12-06 16:09:24', 'images/a75d0a214a8983c66e8c5d01572c3c8e.png', NULL),
(736, 'KY', '血战到底', NULL, NULL, '1660', NULL, NULL, 'joker', NULL, 99, 0, 1, '2022-12-06 16:10:01', '2022-12-06 16:10:01', 'images/1c483512009b3aeee4472ab2d8c3badf.png', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `game_records`
--

CREATE TABLE `game_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `bet_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '注单id',
  `transfer_no` bigint(19) UNSIGNED DEFAULT NULL COMMENT '交易单号',
  `round_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '局号',
  `bet_point_id` bigint(19) UNSIGNED DEFAULT NULL COMMENT '下注玩法ID',
  `bet_flag` tinyint(1) DEFAULT '0' COMMENT '重算标志',
  `table_code` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '台桌号',
  `boot_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '靴号',
  `player_id` bigint(19) UNSIGNED DEFAULT NULL COMMENT '玩家ID',
  `game_type_id` bigint(19) UNSIGNED DEFAULT NULL COMMENT '游戏类型ID',
  `match_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform_id` bigint(19) UNSIGNED DEFAULT NULL COMMENT '厅ID',
  `platform_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '厅名称',
  `game_type_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '游戏名称',
  `bet_point_name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '玩法名称',
  `pay_amount` decimal(15,4) DEFAULT '0.0000' COMMENT '返奖金额',
  `before_amount` decimal(15,4) DEFAULT '0.0000' COMMENT '下注前余额',
  `judge_result` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '结果',
  `login_ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '登录IP',
  `bet_time` datetime NOT NULL COMMENT '下注时间',
  `platform_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '平台',
  `game_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '游戏类型',
  `game_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bet_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '下注金额',
  `valid_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '有效投注金额',
  `win_loss` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '输赢金额',
  `is_back` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1已反水 0未反水',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 1已结算 2未结算 0无效注单',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `game_records`
--

INSERT INTO `game_records` (`id`, `user_id`, `username`, `bet_id`, `transfer_no`, `round_no`, `bet_point_id`, `bet_flag`, `table_code`, `boot_no`, `player_id`, `game_type_id`, `match_type`, `platform_id`, `platform_name`, `game_type_name`, `bet_point_name`, `pay_amount`, `before_amount`, `judge_result`, `login_ip`, `bet_time`, `platform_type`, `game_type`, `game_code`, `bet_amount`, `valid_amount`, `win_loss`, `is_back`, `status`, `created_at`, `updated_at`) VALUES
(11983, 39, 'ceshis', '1219669832238468224', NULL, 'GC0826115443', 3001, 0, NULL, NULL, NULL, 2001, NULL, 3, '亚太厅', '经典百家乐', '庄', '20.0000', '740.0000', NULL, NULL, '2026-01-15 14:32:28', 'dbzhenren', 'realbet', '2001', '20.00', '0.00', '0.00', 0, 1, '2026-01-15 14:38:48', '2026-01-15 14:38:48'),
(11984, 39, 'ceshis', '1219669832238468225', NULL, 'GC0826115443', 3002, 0, NULL, NULL, NULL, 2001, NULL, 3, '亚太厅', '经典百家乐', '闲', '10.0000', '740.0000', NULL, NULL, '2026-01-15 14:32:28', 'dbzhenren', 'realbet', '2001', '10.00', '0.00', '0.00', 0, 1, '2026-01-15 14:38:48', '2026-01-15 14:38:48'),
(11985, 39, 'ceshis', '1219669832242662528', NULL, 'GC0826115443', 3003, 0, NULL, NULL, NULL, 2001, NULL, 3, '亚太厅', '经典百家乐', '和', '90.0000', '740.0000', NULL, NULL, '2026-01-15 14:32:28', 'dbzhenren', 'realbet', '2001', '10.00', '10.00', '80.00', 0, 1, '2026-01-15 14:38:48', '2026-01-15 14:38:48'),
(11986, 39, 'ceshis', 'c5525b0d-02bd-4b46-a3ec-da18ab0166fe', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', '0.0000', NULL, NULL, '2026-01-15 03:30:43', 'dbevo', 'megaball', 'MegaBall00000001', '250.00', '250.00', '300.00', 0, 1, '2026-01-15 07:43:12', '2026-01-15 07:43:12'),
(11987, 39, 'ceshis', '163bffd0-bc07-4fd3-a07b-032842fae905', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', '0.0000', NULL, NULL, '2026-01-15 07:05:38', 'dbevo', 'megaball', 'MegaBall00000001', '120.00', '120.00', '-100.00', 0, 1, '2026-01-15 07:43:12', '2026-01-15 07:43:12'),
(11988, 39, 'ceshis', 'eb9efec8-6f91-4b46-9ea4-98b561015d6c', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', '0.0000', NULL, NULL, '2026-01-15 02:55:21', 'dbevo', 'topcard', 'TopCard000000001', '6000.00', '6000.00', '-6000.00', 0, 1, '2026-01-15 07:43:12', '2026-01-15 07:43:12'),
(11989, 39, 'ceshis', '50-1768625804-6807702773-2', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', '0.0000', NULL, NULL, '2026-01-17 12:57:31', 'dbkaiyuan', '220', '44040002', '75.00', '75.00', '-75.00', 0, 1, '2026-01-17 13:06:28', '2026-01-17 13:06:28'),
(11990, 39, 'ceshis', '50-1768625855-6807708055-3', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.0000', '0.0000', NULL, NULL, '2026-01-17 12:57:48', 'dbkaiyuan', '220', '44040002', '15.00', '15.00', '-15.00', 0, 1, '2026-01-17 13:06:28', '2026-01-17 13:06:28');

-- --------------------------------------------------------

--
-- 表的结构 `game_tags`
--

CREATE TABLE `game_tags` (
  `id` bigint(20) NOT NULL,
  `name` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT '0' COMMENT '给某个会员发消息',
  `vip_id` int(11) DEFAULT NULL COMMENT 'vip等级id',
  `isagent` int(1) DEFAULT '0' COMMENT '1针对代理 2vip黑名单',
  `type` int(11) NOT NULL COMMENT '1通知 2活动 3公告',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `vip_id`, `isagent`, `type`, `title`, `content`, `created_at`, `updated_at`) VALUES
(8, 0, 1, 1, 3, '遵守', '<p>请自觉遵守本站秩序</p>', '2021-10-12 07:09:06', '2025-08-25 08:03:37');

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2016_01_04_173148_create_admin_tables', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_09_07_090635_create_admin_settings_table', 1),
(5, '2020_09_22_015815_create_admin_extensions_table', 1),
(6, '2020_11_01_083237_update_admin_menu_table', 1),
(7, '2020_11_24_111402_create_users_table', 1),
(8, '2020_11_25_102449_create_recharge_table', 1),
(9, '2020_11_25_183755_create_user_cards_table', 1),
(10, '2020_11_29_211446_create_withdraws_table', 1),
(11, '2020_11_29_212718_create_suggestions_table', 1),
(12, '2020_12_01_202428_create_messages_table', 1),
(13, '2020_12_01_204154_create_user_messages_table', 1),
(14, '2020_12_16_151534_create_user_vip_table', 1),
(15, '2020_12_17_144810_create_pay_setting_table', 1),
(16, '2020_12_17_153644_create_banks_table', 1),
(17, '2020_12_18_142828_create_system_config_table', 1),
(18, '2020_12_19_101712_create_activity_apply_table', 2),
(19, '2020_12_19_103413_create_activities_table', 2),
(20, '2020_12_21_151323_create_tranfer_logs_table', 3),
(21, '2020_12_23_164453_create_activity_types_table', 3),
(22, '2020_12_25_170051_create_game_records_table', 3),
(23, '2020_12_27_110141_create_apis_table', 3),
(24, '2020_12_28_102854_create_game_lists_table', 3),
(25, '2021_01_01_201738_add_is_agent_to_users_table', 4),
(26, '2021_01_04_202011_create_templates_table', 5),
(27, '2021_01_07_203644_create_agent_apply_table', 6),
(28, '2021_01_23_095121_add_api_token_to_users_table', 7),
(29, '2021_02_01_152419_edit_api_type_to_transfer_logs_table', 8),
(30, '2021_02_03_145311_create_agent_settlements_table', 9),
(31, '2021_02_03_161027_add_settlement_id_to_users_table', 9),
(32, '2021_09_05_101619_create_user_operate_logs_table', 10),
(33, '2021_09_06_101015_add_reg_ip_to_users_table', 11),
(34, '2021_09_09_102636_create_banners_table', 12),
(35, '2021_10_13_145446_change_banner_to_activities_table', 13),
(36, '2021_10_20_144657_edit_pic_to_banners_table', 14),
(37, '2022_04_28_170305_create_sessions_table', 15),
(38, '2024_01_01_000000_create_sponsors_table', 16),
(39, '2024_01_01_000001_add_sponsor_menu', 17);

-- --------------------------------------------------------

--
-- 表的结构 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `pay_setting`
--

CREATE TABLE `pay_setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` int(11) NOT NULL,
  `bank_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '卡号',
  `bank_owner` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '持卡人姓名',
  `bank_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支行信息',
  `info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1可用 0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `pay_setting`
--

INSERT INTO `pay_setting` (`id`, `bank_id`, `bank_no`, `bank_owner`, `bank_address`, `info`, `state`, `created_at`, `updated_at`) VALUES
(14, 2, '65022226633888115666', '张三', '香港国际银行', '1111', 1, '2022-08-16 10:38:55', '2022-08-16 10:38:55');

-- --------------------------------------------------------

--
-- 表的结构 `recharge`
--

CREATE TABLE `recharge` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '系统订单号',
  `out_trade_no` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户订单号',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `cash_fee` decimal(8,2) NOT NULL COMMENT '手续费',
  `real_money` decimal(10,2) NOT NULL COMMENT '实到金额',
  `pay_way` tinyint(4) NOT NULL COMMENT '支付方式: 1=银行卡转账, 2=ZGPAY支付, 3=支付宝扫描, 4=微信扫描, 5=USDT-TRC20, 6=USDT-ERC20, 7=EBpay, 8=预留, 10=充值赠送, 11=代理充值, 66=客服代充',
  `bank` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '开户行',
  `bank_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '卡号',
  `bank_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '开户行',
  `bank_owner` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '持卡人姓名',
  `info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `usdt_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `state` tinyint(4) DEFAULT '1' COMMENT '状态：1=待支付，2=已完成，3=已拒绝，4=已取消',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tron_tx_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'TRON交易哈希',
  `tron_usdt_amount` decimal(15,6) DEFAULT NULL COMMENT 'TRON USDT充值金额',
  `tron_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'TRON收款地址',
  `tron_network` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'TRON网络类型(TRC20)',
  `tron_confirmations` int(11) DEFAULT '0' COMMENT 'TRON交易确认数',
  `tron_paid_at` timestamp NULL DEFAULT NULL COMMENT 'TRON支付时间',
  `tron_verify_result` text COLLATE utf8mb4_unicode_ci COMMENT 'TRON验证结果',
  `is_back` int(1) NOT NULL DEFAULT '0' COMMENT '是否反佣，1是，0否',
  `telegram_message_id` bigint(20) DEFAULT NULL COMMENT 'Telegram消息ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `recharge`
--

INSERT INTO `recharge` (`id`, `order_no`, `out_trade_no`, `user_id`, `amount`, `cash_fee`, `real_money`, `pay_way`, `bank`, `bank_no`, `bank_address`, `bank_owner`, `info`, `usdt_rate`, `state`, `created_at`, `updated_at`, `tron_tx_hash`, `tron_usdt_amount`, `tron_address`, `tron_network`, `tron_confirmations`, `tron_paid_at`, `tron_verify_result`, `is_back`, `telegram_message_id`) VALUES
(53, '17663250977577', '17663250975303', 96, '60000.00', '0.00', '60000.00', 66, NULL, NULL, NULL, NULL, '客服代充', '0.00', 2, '2025-12-21 21:51:37', '2025-12-21 21:51:37', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(54, '17671500645614', '17671500649224', 22, '1000.00', '0.00', '1000.00', 66, NULL, NULL, NULL, NULL, '客服代充', '0.00', 2, '2025-12-31 11:01:04', '2025-12-31 11:01:04', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(55, '17673293385333', '17673293381226', 25, '500.00', '0.00', '500.00', 66, NULL, NULL, NULL, NULL, '客服代充', '0.00', 2, '2026-01-02 12:48:58', '2026-01-02 12:48:58', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(56, NULL, 'TRON_1767451655255457', 25, '715.00', '0.00', '715.00', 5, NULL, NULL, NULL, NULL, '订单超时未支付，已自动取消', '7.15', 4, '2026-01-03 22:47:35', '2026-01-03 22:58:02', NULL, '100.329000', NULL, 'TRC20', 0, NULL, NULL, 0, NULL),
(57, NULL, 'TRON_1767453355181026', 18, '715.00', '0.00', '715.00', 5, NULL, NULL, NULL, NULL, '用户取消订单', '7.15', 4, '2026-01-03 23:15:55', '2026-01-03 23:16:03', NULL, '100.530000', NULL, 'TRC20', 0, NULL, NULL, 0, NULL),
(58, NULL, 'TRON_1767453704187743', 18, '715.00', '0.00', '715.00', 5, NULL, NULL, NULL, NULL, '用户取消订单', '7.15', 4, '2026-01-03 23:21:44', '2026-01-03 23:21:52', NULL, '100.467000', NULL, 'TRC20', 0, NULL, NULL, 0, NULL),
(59, NULL, 'TRON_1767453877189356', 18, '715.00', '0.00', '715.00', 5, NULL, NULL, NULL, NULL, '用户取消订单', '7.15', 4, '2026-01-03 23:24:37', '2026-01-03 23:24:43', NULL, '100.444000', NULL, 'TRC20', 0, NULL, NULL, 0, NULL),
(60, NULL, 'TRON_1767455713253618', 25, '715.00', '0.00', '715.00', 5, NULL, NULL, NULL, NULL, '用户取消订单', '7.15', 4, '2026-01-03 23:55:13', '2026-01-03 23:55:21', NULL, '100.480000', NULL, 'TRC20', 0, NULL, NULL, 0, NULL),
(61, NULL, 'TRON_1767456053182517', 18, '715.00', '0.00', '715.00', 5, NULL, NULL, NULL, NULL, '用户取消订单', '7.15', 4, '2026-01-04 00:00:53', '2026-01-04 00:00:59', NULL, '100.104000', NULL, 'TRC20', 0, NULL, NULL, 0, NULL),
(62, NULL, 'TRON_176746038817815', 1, '7150.00', '0.00', '7150.00', 5, NULL, NULL, NULL, NULL, '用户取消订单', '7.15', 4, '2026-01-04 01:13:09', '2026-01-04 01:13:54', NULL, '1000.827000', NULL, 'TRC20', 0, NULL, NULL, 0, NULL),
(63, NULL, 'TRON_1767525152256050', 25, '3575.00', '0.00', '3575.00', 5, NULL, NULL, NULL, NULL, 'Telegram TRC20充值', '7.15', 2, '2026-01-04 19:12:32', '2026-01-04 19:12:45', 'ADMIN_MANUAL_20260104191245_63', '500.862000', NULL, 'TRC20', 0, NULL, NULL, 0, 758),
(64, NULL, 'TRON_1767525710259807', 25, '715.00', '0.00', '715.00', 5, NULL, NULL, NULL, NULL, 'Telegram TRC20充值', '7.15', 2, '2026-01-04 19:21:50', '2026-01-04 19:22:03', 'ADMIN_MANUAL_20260104192203_64', '100.649000', NULL, 'TRC20', 0, NULL, NULL, 0, 763),
(65, NULL, 'TRON_1767525799187206', 18, '1430.00', '0.00', '1430.00', 5, NULL, NULL, NULL, NULL, 'Telegram TRC20充值', '7.15', 2, '2026-01-04 19:23:19', '2026-01-04 19:23:25', 'ADMIN_MANUAL_20260104192325_65', '200.369000', NULL, 'TRC20', 0, NULL, NULL, 0, 768),
(66, NULL, 'TRON_1767556693248122', 24, '715.00', '0.00', '715.00', 5, NULL, NULL, NULL, NULL, '用户取消订单', '7.15', 4, '2026-01-05 03:58:13', '2026-01-05 03:58:27', NULL, '100.080000', NULL, 'TRC20', 0, NULL, NULL, 0, 790),
(67, NULL, 'TRON_1767587114185634', 18, '71.50', '0.00', '71.50', 5, NULL, NULL, NULL, NULL, '订单超时未支付，已自动取消', '7.15', 4, '2026-01-05 12:25:14', '2026-01-05 12:36:02', NULL, '10.227000', NULL, 'TRC20', 0, NULL, NULL, 0, 801),
(68, 'TRON_176758812468', 'TRON_1767587981184826', 18, '71.50', '0.00', '71.50', 5, NULL, NULL, NULL, NULL, 'TRON USDT充值成功，交易哈希: d20586abacefcd6fd3fca7a157aa32ab40a989dae8ec88009b744224fe93daf5，实际到账: 10.492 USDT', '7.15', 2, '2026-01-05 12:39:41', '2026-01-05 12:42:04', 'd20586abacefcd6fd3fca7a157aa32ab40a989dae8ec88009b744224fe93daf5', '10.492000', NULL, 'TRC20', 23, '2026-01-05 12:42:04', NULL, 0, 803),
(69, NULL, 'TRON_176759331534676', 3, '7150.00', '0.00', '7150.00', 5, NULL, NULL, NULL, NULL, '订单超时未支付，已自动取消', '7.15', 4, '2026-01-05 14:08:35', '2026-01-05 14:19:02', NULL, '1000.289000', NULL, 'TRC20', 0, NULL, NULL, 0, 822),
(70, NULL, 'TRON_1767716191185947', 18, '7150.00', '0.00', '7150.00', 5, NULL, NULL, NULL, NULL, '订单超时未支付，已自动取消', '7.15', 4, '2026-01-07 00:16:31', '2026-01-07 00:27:02', NULL, '1000.914000', NULL, 'TRC20', 0, NULL, NULL, 0, 840);

-- --------------------------------------------------------

--
-- 表的结构 `red_envelopes`
--

CREATE TABLE `red_envelopes` (
  `id` int(11) NOT NULL,
  `day_flow` decimal(10,2) DEFAULT NULL COMMENT '当天流水',
  `recharge` decimal(10,2) DEFAULT NULL COMMENT '充值金额',
  `flow_money` decimal(10,2) DEFAULT NULL COMMENT '流水金额',
  `money` decimal(10,2) DEFAULT NULL COMMENT '领取红包金额',
  `start_time` timestamp NULL DEFAULT NULL COMMENT '红包领取开始时间',
  `end_time` timestamp NULL DEFAULT NULL COMMENT '红包领取结束时间',
  `status` int(1) DEFAULT '1' COMMENT '0禁用1启用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `red_envelopes`
--

INSERT INTO `red_envelopes` (`id`, `day_flow`, `recharge`, `flow_money`, `money`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES
(1, '100.00', '1.00', '10000.00', '2.00', '2022-07-01 02:59:04', '2022-07-31 03:00:04', 1, '2021-04-23 02:53:46', '2022-07-04 17:32:48'),
(2, '1000.00', '5.00', '10000.00', '2.00', '2022-07-01 02:56:48', '2022-07-31 02:57:48', 1, '2022-07-15 02:56:40', '2022-07-16 12:55:18');

-- --------------------------------------------------------

--
-- 表的结构 `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地区名称',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地区代码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态: 1-启用, 0-禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地区表';

--
-- 转存表中的数据 `regions`
--

INSERT INTO `regions` (`id`, `name`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, '菲律宾', 'B', 1, '2025-12-21 19:55:56', '2025-12-21 19:56:42'),
(2, '南斯拉夫', 'N', 1, '2025-12-21 19:56:10', '2025-12-21 19:56:54'),
(3, '阿联酋', 'A', 1, '2025-12-21 19:56:31', '2025-12-21 19:56:31');

-- --------------------------------------------------------

--
-- 表的结构 `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0D7bN7r3LKiekfP10w7KSH3qzseT0okbUeylvHip', NULL, '154.222.29.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo2OntzOjU6ImFkbWluIjthOjE6e3M6NDoicHJldiI7YTowOnt9fXM6NjoiX2ZsYXNoIjthOjI6e3M6MzoibmV3IjthOjA6e31zOjM6Im9sZCI7YTowOnt9fXM6NjoiX3Rva2VuIjtzOjQwOiJMMzFIVGtjQUhkZlV3UWdtWWVKQXZINm5kbG1rWEM4R1I4TmdOSjQ3IjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NDoiaHR0cHM6Ly9ib3RhZC5sZXl1NjY2LmxvbC9lcC9nYW1lLWNhdGVnb3JpZXMiO31zOjIwOiJsb2dpbl9jYXB0Y2hhX3BocmFzZSI7czo0OiJhaFBtIjtzOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1768634371),
('EDzxzsBzRp9997gMO0FasPQcnRwwm7rk6inzSAdq', NULL, '164.92.227.229', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ2lzbFl3bTFjSllMVTNjdXBmYWhTQ1h4d0ZVZk5IcTE4YjlQS1lNWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vYm90YXBpLmxleXU2NjYubG9sIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768631965),
('w4g9wAyatuhF4nwwXqga8U83P4YrzG22u5jlXaIL', NULL, '164.92.227.229', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU09lYkR6Y3dma1JVblgxSjBqZGtpV0M4dFphaTRlWlFrVVUyMHFpbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vYm90YXBpLmxleXU2NjYubG9sIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768631963);

-- --------------------------------------------------------

--
-- 表的结构 `sponsors`
--

CREATE TABLE `sponsors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '赞助名称',
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '赞助标题',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '赞助商Logo',
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '活动图片',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT '赞助详情',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT '状态：active=正常，inactive=禁用',
  `sort_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '跳转链接',
  `link_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal' COMMENT '链接类型：internal=内部链接，external=外部链接',
  `content` longtext COLLATE utf8mb4_unicode_ci COMMENT '文章内容',
  `content_type` enum('link','article') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'link' COMMENT '内容类型：link=链接地址，article=文章内容',
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布',
  `published_at` timestamp NULL DEFAULT NULL COMMENT '发布时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='赞助商管理表';

--
-- 转存表中的数据 `sponsors`
--

INSERT INTO `sponsors` (`id`, `name`, `title`, `logo`, `banner`, `description`, `status`, `sort_order`, `link_url`, `link_type`, `content`, `content_type`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, '尤文图斯', '官方区域合作伙伴', '2025-08-24/37923df41d8e71eca4755857e44e6df5.png', '2025-08-24/d8e1edda0d8575cd6c4e845fcda984b4.png', '尤文图斯足球俱乐部是意大利最成功的足球俱乐部之一，拥有悠久的历史和辉煌的成就。', 'active', 1, 'https://www.avfc.co.uk/', 'external', '<p>测试</p>\r\n<p>https://www.juventus.com/</p>', 'link', 1, '2025-08-24 04:50:31', '2025-08-24 03:34:57', '2025-08-24 05:56:50'),
(2, '阿斯顿维拉', '官方全球顶级合作伙伴', '2025-08-24/2fb0cf04342a376492c2cf7876d99489.png', '2025-08-24/22ed06dd6dc0aede53aa0766d8d6bbbe.png', '阿斯顿维拉足球俱乐部是英格兰足球超级联赛的知名俱乐部，拥有丰富的足球传统。', 'active', 2, 'https://www.avfc.co.uk/', 'external', '<p>https://www.avfc.co.uk/</p>', 'link', 1, '2025-08-24 04:50:31', '2025-08-24 03:34:57', '2025-08-24 05:57:16'),
(3, '皇家马德里', '官方战略合作伙伴', '2025-08-24/d2caf61311c9df4ab888a0dd8518bb19.png', '2025-08-24/a44e4890765f186f1ea072cb82e4f266.jpg', '皇家马德里是世界上最成功的足球俱乐部之一，拥有众多世界级球星。', 'active', 3, '', 'external', '<p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://api.xxxx.com/uploads/tinymce/images/200726c904d4572c154624b0615ba68968aaaa8134763.jpg\" alt=\"\" width=\"400\" height=\"250\" /></p>\r\n<p>皇家马德里足球俱乐部（Real Madrid CF），简称&ldquo;皇马&rdquo;，是一家位于西班牙首都马德里的足球俱乐部，球队成立于1902年3月6日，前称马德里足球队。</p>\r\n<p>1905年，成功摘得队史上的首个冠军&mdash;&mdash;西班牙国王杯。</p>\r\n<p>1920年6月29日，时任西班牙国王阿方索十三世把\"Real\"（西语，皇家之意）一词加于俱乐部名前，徽章上加上了皇冠，以此来推动足球运动在西班牙首都马德里市的发展。从此，俱乐部正式名为皇家马德里足球俱乐部。皇家马德里足球俱乐部拥有众多世界球星。</p>\r\n<p>2000年12月11日被国际足球联合会（FIFA）评为20世纪最伟大的球队。</p>\r\n<p>2009年9月10日被国际足球历史和统计联合会评为20世纪欧洲最佳俱乐部。北京时间2024年12月27日，皇家马德里当选2024年环球足球奖最佳男子俱乐部 。皇家马德里夺得过15次欧冠冠军（欧洲足坛第一）、36次西班牙足球甲级联赛冠军（西班牙第一）、20次西班牙国王杯冠军、13次西班牙超级杯冠军、2次欧洲联盟杯冠军、6次欧洲超级杯冠军、9次洲际杯冠军（含旧版世俱杯）。</p>', 'article', 1, '2025-08-24 04:50:31', '2025-08-24 03:34:57', '2025-08-24 06:01:34');

-- --------------------------------------------------------

--
-- 表的结构 `sponsors_backup`
--

CREATE TABLE `sponsors_backup` (
  `id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '赞助名称',
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '赞助标题',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '赞助商Logo',
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '活动图片',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT '赞助详情',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active' COMMENT '状态：active=正常，inactive=禁用',
  `sort_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '跳转链接',
  `link_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal' COMMENT '链接类型：internal=内部链接，external=外部链接',
  `content` longtext COLLATE utf8mb4_unicode_ci COMMENT '文章内容',
  `content_type` enum('link','article','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'link' COMMENT '内容类型：link=链接地址，article=文章内容，both=链接+文章',
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布',
  `published_at` timestamp NULL DEFAULT NULL COMMENT '发布时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `sponsors_backup`
--

INSERT INTO `sponsors_backup` (`id`, `name`, `title`, `logo`, `banner`, `description`, `status`, `sort_order`, `link_url`, `link_type`, `content`, `content_type`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, '尤文图斯', '官方区域合作伙伴', 'ddf471901f2b4fff9ee57015a1698227.png', '93b000fa1d3246ce9b90a62c018714af.png', '尤文图斯足球俱乐部是意大利最成功的足球俱乐部之一，拥有悠久的历史和辉煌的成就。', 'active', 1, '/zhanzhuye?type=1', 'internal', NULL, 'link', 1, '2025-08-24 04:31:34', '2025-08-24 03:34:57', '2025-08-24 03:34:57'),
(2, '阿斯顿维拉', '官方全球顶级合作伙伴', 'ddf471901f2b4fff9ee57015a1698227.png', 'bd72c14c428d41ce8105a0d82a1bb696.png', '阿斯顿维拉足球俱乐部是英格兰足球超级联赛的知名俱乐部，拥有丰富的足球传统。', 'active', 2, '/zhanzhuye?type=2', 'internal', NULL, 'link', 1, '2025-08-24 04:31:34', '2025-08-24 03:34:57', '2025-08-24 03:34:57'),
(3, '皇家马德里', '官方战略合作伙伴', 'ddf471901f2b4fff9ee57015a1698227.png', '93b000fa1d3246ce9b90a62c018714af.png', '皇家马德里是世界上最成功的足球俱乐部之一，拥有众多世界级球星。', 'active', 3, '/zhanzhuye?type=3', 'internal', NULL, 'link', 1, '2025-08-24 04:31:34', '2025-08-24 03:34:57', '2025-08-24 03:34:57');

-- --------------------------------------------------------

--
-- 表的结构 `suggestions`
--

CREATE TABLE `suggestions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL COMMENT '问题类型',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '附图',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `syslog`
--

CREATE TABLE `syslog` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL DEFAULT '10',
  `type` int(2) NOT NULL DEFAULT '0',
  `memo` varchar(255) DEFAULT NULL,
  `addtime` varchar(20) NOT NULL,
  `updated_at` varchar(20) NOT NULL,
  `created_at` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `system_config`
--

CREATE TABLE `system_config` (
  `key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `system_config`
--

INSERT INTO `system_config` (`key`, `value`) VALUES
('accountday', '30'),
('activity_apply_audio', ''),
('agen_applyt_audio', ''),
('agent_apply_audio', ''),
('agentday', '60'),
('android_download_qrcode', ''),
('android_download_url', ''),
('android_version', ''),
('api_secret', 'vNHnodftHULT0kOAJDUu9TPXK0PZs28y'),
('app_download_switch', '1'),
('app_logo', '2026-01-15/4d6cfc03ddf5672fd6f617a0baa7a758.png'),
('applyday', '30'),
('auto_refresh', '0'),
('auto_refresh_interval', '10'),
('companypay_des', ''),
('companypay_title', ''),
('content', ''),
('cors_enabled', '1'),
('daily_withdraw_times', '3'),
('damaliang', '0'),
('default_system', 'kefu'),
('dp_api_account', 'BTM494'),
('dp_api_secret', 'XC3OQ1sBQEcT13jvBqQ3WuvERPfyCuSaVvDzTMdjMHhGwgJGvAG7BbTLhX0rCeMyG8pk0i7g6XBr3qBPD4JxL6mvwbilYLjpRzCZ'),
('dp_api_url', 'https://bgcgw.bguwvz.com/bw-gameapi-client-gateway/bw-gameapi-client-server'),
('fanshui', '1'),
('game_api', 'https://apis.msh.cool/'),
('gameorder', '30'),
('gongdan_enabled', '0'),
('gongdan_url', ''),
('ios_download_qrcode', ''),
('ios_download_url', ''),
('ios_version', ''),
('isclose', '0'),
('kefu_enabled', '1'),
('kefu_username', ''),
('kf_url', 'https://www.baidu.com'),
('max_price', '100000'),
('max_recharge_money', '50000000'),
('max_withdraw_money', '100000'),
('merchant_account', 'msdemo'),
('min_fanshui_money', '0'),
('min_price', '10'),
('min_recharge_money', '100'),
('min_withdraw_money', '50'),
('notice_set', '1'),
('onlinepay_des', ''),
('onlinepay_title', ''),
('pussy_agent', 'ssg_911'),
('pussy_api_account', 'kTvFRDSGxdAPzYzRUMNY'),
('pussy_api_secret', '8H87Y36h6XKWV895EAV8'),
('pussy_api_url', 'http://api.pussy888.com/'),
('recharge_apply_audio', ''),
('recharge_bank_enabled', '1'),
('recharge_erc20_enabled', '1'),
('recharge_fee', '0'),
('recharge_trc20_enabled', '1'),
('redpacket', '0'),
('repair_tips', '网站正在升级维护，维护时间预计两小时，请耐心等待！!'),
('safe_domain', ''),
('service_type', 'gongdan'),
('settlement', '7'),
('settlementlevel', '7'),
('settlementtypes', '1'),
('show_selector', '0'),
('site_keyword', '星云娱乐关键词'),
('site_logo', '2026-01-15/10f20fe16f8ef3480b1754a69dd3e69f.png'),
('site_name', '星云娱乐城'),
('site_state', '1'),
('site_title', '星云娱乐'),
('syslogday', '30'),
('telegram_bot_game_url', 'https://bot.leyu666.lol'),
('telegram_bot_main_image', '2026-01-17/67874fa11f17ad2a53f545db90f8ae6e.png'),
('telegram_bot_official_url', 'https://bot.leyu666.lol'),
('telegram_bot_token', '8406679198:AAFzKQFTEy9OkHRYhKU3FQTmm7NMHt_ESaI'),
('telegram_bot_username', ''),
('tron_api_key', '输入 TRC20 API密钥'),
('tron_api_key_enabled', '0'),
('tron_api_url', 'https://apilist.tronscanapi.com'),
('tron_confirmations', '6'),
('tron_exchange_rate', '7.15'),
('tron_max_amount', '50000'),
('tron_min_amount', '10'),
('tron_usdt_address', 'TSEcubAEyjPCfKe9PDBhfFmWpEzwX5BqY8'),
('tron_usdt_qrcode', '2026-01-03/photo_2026-01-03_22-12-02.jpg'),
('webcontent', '<div class=\"gs_p\" style=\"text-align: center;\" data-mce-style=\"text-align: center;\"><span style=\"font-weight: bold;\" data-mce-style=\"font-weight: bold;\">欢迎您的到来，</span></div><div class=\"gs_p\" style=\"text-align: center;\" data-mce-style=\"text-align: center;\"><span style=\"font-weight: bold;\" data-mce-style=\"font-weight: bold;\">期待与您共度美好时光！</span></div>'),
('withdraw_apply_audio', ''),
('withdraw_bank_enabled', '1'),
('withdraw_begin_time', '00:00:00'),
('withdraw_cash_fee', '2'),
('withdraw_end', '5'),
('withdraw_end_time', '23:59:59'),
('withdraw_erc20_enabled', '1'),
('withdraw_fee', '0'),
('withdraw_fee_usdt_erc', '10'),
('withdraw_fee_usdt_trc', '3'),
('withdraw_start', '1'),
('withdraw_trc20_enabled', '1'),
('withdraw_usdt_rate', '73'),
('work_order_audio', ''),
('work_order_auto_close_days', '30'),
('work_order_category_default', 'general'),
('work_order_notification', '1'),
('work_order_priority_default', 'normal');

-- --------------------------------------------------------

--
-- 表的结构 `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '模板名称',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '缩略图',
  `client_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1pc 2wap 3app',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `template_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '模板标识',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1可用 0禁用 2正在使用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `templates`
--

INSERT INTO `templates` (`id`, `name`, `pic`, `client_type`, `sort`, `template_id`, `state`, `created_at`, `updated_at`) VALUES
(8, 'mb1', 'images/e679b0ff69fbed8d5e96ddf160e2eef2.png', 2, 0, 'mb1', 2, '2021-02-24 11:33:15', '2022-02-20 15:15:59'),
(21, 'mb12', 'images/7712c0db4a5b04d4dd80fcc1868fd517.png', 1, 0, 'mb12', 2, '2021-10-11 15:12:06', '2022-01-23 10:35:23');

-- --------------------------------------------------------

--
-- 表的结构 `transfer_logs`
--

CREATE TABLE `transfer_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `api_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'api账户类型',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `transfer_type` int(20) NOT NULL COMMENT '0 转入游戏 1转出游戏',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '转换金额',
  `cash_fee` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `real_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实到金额',
  `before_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '转换前余额',
  `after_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '转换后金额',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1成功 0失败 2 待结算',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `platform_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '游戲平臺',
  `addtime` int(10) DEFAULT '0',
  `settlementsday` int(2) DEFAULT '0' COMMENT '结算天数',
  `betid` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '結算單號',
  `remark` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bet_money` decimal(20,4) NOT NULL DEFAULT '0.0000' COMMENT '投注金额',
  `win_money` decimal(20,4) NOT NULL DEFAULT '0.0000' COMMENT '输赢金额',
  `yongjin` decimal(20,4) NOT NULL DEFAULT '0.0000' COMMENT '佣金'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `transfer_logs`
--

INSERT INTO `transfer_logs` (`id`, `order_no`, `api_type`, `user_id`, `transfer_type`, `money`, `cash_fee`, `real_money`, `before_money`, `after_money`, `state`, `created_at`, `updated_at`, `platform_type`, `addtime`, `settlementsday`, `betid`, `remark`, `bet_money`, `win_money`, `yongjin`) VALUES
(1, '176844503539263358', 'dbevo', 39, 0, '-7000.00', '0.00', '-7000.00', '7000.00', '0.00', 1, '2026-01-15 10:43:55', '2026-01-15 10:43:57', 'evo', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(2, '176845334639537172', 'dbzhenren', 39, 0, '-1000.00', '0.00', '-1000.00', '1000.00', '0.00', 1, '2026-01-15 13:02:26', '2026-01-15 13:02:26', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(3, '176845364539341522', 'dbzhenren', 39, 0, '-6000.00', '0.00', '-6000.00', '6000.00', '0.00', 1, '2026-01-15 13:07:25', '2026-01-15 13:07:25', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(4, '176845392739967070', 'dbzhenren', 39, 0, '-500.00', '0.00', '-500.00', '500.00', '0.00', 1, '2026-01-15 13:12:07', '2026-01-15 13:12:07', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(5, '176845611639738207', 'dbzhenren', 39, 0, '-800.00', '0.00', '-800.00', '800.00', '0.00', 1, '2026-01-15 13:48:36', '2026-01-15 13:48:37', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(6, '176848247239512597', 'dbgmag', 39, 0, '-1000.00', '0.00', '-1000.00', '1000.00', '0.00', 1, '2026-01-15 21:07:52', '2026-01-15 21:07:52', 'gmag', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(7, '20260115224217393945', 'dbgmag', 39, 1, '596.00', '0.00', '596.00', '0.00', '1192.00', 1, '2026-01-15 22:42:17', '2026-01-15 22:42:18', 'gmag', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(8, '176848821239836571', 'dbevo', 39, 0, '-596.00', '0.00', '-596.00', '596.00', '0.00', 1, '2026-01-15 22:43:32', '2026-01-15 22:43:34', 'evo', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(9, '20260115224358859695', 'dbevo', 39, 1, '2176.00', '0.00', '2176.00', '0.00', '4352.00', 1, '2026-01-15 22:43:58', '2026-01-15 22:43:59', 'evo', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(10, '176848824939433223', 'dbevo', 39, 0, '-2176.00', '0.00', '-2176.00', '2176.00', '0.00', 1, '2026-01-15 22:44:09', '2026-01-15 22:44:10', 'evo', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(11, '20260115224424445731', 'dbevo', 39, 1, '2176.00', '0.00', '2176.00', '0.00', '4352.00', 1, '2026-01-15 22:44:24', '2026-01-15 22:44:25', 'evo', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(12, '176848827139898347', 'dbzhenren', 39, 0, '-2176.00', '0.00', '-2176.00', '2176.00', '0.00', 1, '2026-01-15 22:44:31', '2026-01-15 22:44:32', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(13, '20260115224444947120', 'dbzhenren', 39, 1, '10476.00', '0.00', '10476.00', '0.00', '0.00', 0, '2026-01-15 22:44:44', '2026-01-15 22:44:44', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(14, '20260115224456518634', 'dbzhenren', 39, 1, '10476.00', '0.00', '10476.00', '0.00', '0.00', 0, '2026-01-15 22:44:56', '2026-01-15 22:44:56', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(15, '20260115224524963153', 'dbzhenren', 39, 1, '10476.00', '0.00', '10476.00', '0.00', '0.00', 0, '2026-01-15 22:45:24', '2026-01-15 22:45:24', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(16, '20260115224727251870', 'dbzhenren', 39, 0, '1000.00', '0.00', '1000.00', '1000.00', '-1000.00', 1, '2026-01-15 22:47:27', '2026-01-15 22:47:28', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(17, '20260115224731605466', 'dbzhenren', 39, 1, '1000.00', '0.00', '1000.00', '0.00', '2000.00', 1, '2026-01-15 22:47:31', '2026-01-15 22:47:32', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(18, '20260115224827704163', 'dbevo', 39, 0, '1000.00', '0.00', '1000.00', '1000.00', '-1000.00', 1, '2026-01-15 22:48:27', '2026-01-15 22:48:28', 'evo', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(19, '20260115224832555918', 'dbevo', 39, 1, '1000.00', '0.00', '1000.00', '0.00', '2000.00', 1, '2026-01-15 22:48:32', '2026-01-15 22:48:33', 'evo', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(20, '176848852039484328', 'dbzhenren', 39, 0, '-1000.00', '0.00', '-1000.00', '1000.00', '0.00', 1, '2026-01-15 22:48:40', '2026-01-15 22:48:40', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(21, '20260115224933703467', 'dbzhenren', 39, 1, '1000.00', '0.00', '1000.00', '0.00', '2000.00', 1, '2026-01-15 22:49:33', '2026-01-15 22:49:34', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(22, '20260115224952854518', 'dbevo', 39, 0, '1000.00', '0.00', '1000.00', '1000.00', '-1000.00', 1, '2026-01-15 22:49:52', '2026-01-15 22:49:53', 'evo', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(23, '20260115225831826841', 'dbevo', 39, 1, '1000.00', '0.00', '1000.00', '0.00', '2000.00', 1, '2026-01-15 22:58:31', '2026-01-15 22:58:32', 'evo', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(24, '20260115231654304912', 'dbzhenren', 39, 1, '2996.00', '0.00', '2996.00', '1000.00', '6992.00', 1, '2026-01-15 23:16:54', '2026-01-15 23:16:55', 'dbzr', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(33, '176854442539803456', 'dbgmag', 39, 0, '-100.00', '0.00', '-100.00', '100.00', '0.00', 1, '2026-01-16 14:20:25', '2026-01-16 14:20:26', 'gmag', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000'),
(34, '176862040639507605', 'dbkaiyuan', 39, 0, '-2000.00', '0.00', '-2000.00', '2000.00', '0.00', 1, '2026-01-17 11:26:46', '2026-01-17 11:26:47', 'dbky', 0, 0, NULL, NULL, '0.0000', '0.0000', '0.0000');

-- --------------------------------------------------------

--
-- 表的结构 `userredpacket`
--

CREATE TABLE `userredpacket` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `redpacketid` int(10) NOT NULL,
  `redpacketfee` decimal(10,2) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `redpacketmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(1) NOT NULL DEFAULT '0',
  `usetime` varchar(30) DEFAULT NULL,
  `isuse` int(1) DEFAULT '0',
  `created_at` varchar(30) NOT NULL,
  `updated_at` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `telegram_id` bigint(20) DEFAULT NULL COMMENT 'Telegram用户ID',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '上级账号',
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '会员账号',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `first_password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `realname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '真实姓名',
  `vip` int(11) NOT NULL DEFAULT '1' COMMENT 'VIP级别',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '等级',
  `exp` int(11) NOT NULL DEFAULT '0' COMMENT '经验值',
  `paypwd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付密码',
  `isonline` int(11) NOT NULL DEFAULT '0' COMMENT '是否在线',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowagent` int(11) NOT NULL DEFAULT '0' COMMENT '是否允许发展下级代理',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `mbalance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '码量余额',
  `totalgame` decimal(10,2) NOT NULL DEFAULT '0.00',
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机',
  `mail` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `paysum` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计充值',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `region_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '所属地区ID',
  `isdel` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已删除',
  `isblack` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否在黑名单',
  `lastip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '最后登录IP',
  `last_login_ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '上次登录地址',
  `logintime` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `sourceurl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '来源',
  `loginsum` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `birthday` date DEFAULT NULL COMMENT '出生日期',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `isagent` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1代理 0会员',
  `agent_level` bigint(20) DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `settlement_id` int(11) NOT NULL DEFAULT '0' COMMENT '结算方案id',
  `fanshuifee` decimal(5,2) DEFAULT NULL COMMENT '返水',
  `settlementday` int(10) DEFAULT '0' COMMENT '最后一次结算时间',
  `reg_ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '注册ip',
  `transferstatus` int(1) DEFAULT '1' COMMENT '0 转账 1免转',
  `money_address` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_language` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cn' COMMENT '默认语种'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `telegram_id`, `fid`, `username`, `password`, `first_password`, `api_token`, `realname`, `vip`, `level`, `exp`, `paypwd`, `isonline`, `avatar`, `allowagent`, `balance`, `mbalance`, `totalgame`, `phone`, `mail`, `paysum`, `status`, `region_id`, `isdel`, `isblack`, `lastip`, `last_login_ip_address`, `logintime`, `sourceurl`, `loginsum`, `birthday`, `deleted_at`, `created_at`, `updated_at`, `isagent`, `agent_level`, `pid`, `settlement_id`, `fanshuifee`, `settlementday`, `reg_ip`, `transferstatus`, `money_address`, `default_language`) VALUES
(1, 5003219595, 0, '41570525', '$2y$10$KZErJ7jWPT7oh2QoVBiLZuqKk95dHIuFbokdbV.erbilCV3JUM2QS', NULL, 'XuuGCXSaPJdsPyI5yipcFs7mKbRga3nJ5oDy0O6tgLVx2U8mrRydIBVZiyAS', '大可爱', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 16:50:49', '2026-01-05 13:17:58', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(2, 7792686404, 0, '70113297', '$2y$10$ytoL4A2zJuWtzK/GeuHlvOHO.xeCpgKt30vl4zMhUU8G2sRlLI6hi', NULL, 'hM2BdX3VPkgQLVeqOHwm9vvKbnJVY4SGiRoIuKyOLijgbpl2xShALq3wwmj4', 'D', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 17:34:05', '2025-12-29 17:34:05', 0, 0, 0, 0, NULL, 0, NULL, 1, '6', 'cn'),
(3, 5596275864, 0, '49972597', '$2y$10$ASQpjAheVMUWqpo2AvGXo.cmjPfKDB7jI/0WJ2BuQOz0ahTIeozZi', NULL, 'BPXz54Nrfzj13zAGDu2oSKgM2aAEz7l7EkO7W2WkQSOSd9a8I6xkTHt5nakK', '叶凡', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 17:40:02', '2025-12-29 17:40:04', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(4, 2018047388, 0, '25071564', '$2y$10$DOXX/dn7iWUND/.1RH.ea.mtH2VxSpBcERchUuN3MUXriKU8.9bWa', NULL, 'OQhLp8dzuTlOknTHz2HjJ854vVxpu4K0BxXANk2YgwJ56EY60uHF5kHxNply', 'KM包网-Snow', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 17:42:10', '2025-12-29 17:42:11', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(5, 7459674081, 0, '31739065', '$2y$10$MUziIix6sdnNso3O1zuuluIWA5Hdf.JdA8c8j6mkcobLlBkx/lkza', NULL, 'NG26ost0geIp4DkH7253ljYalPvUCpe8d2t3vicJzFtv0AVWdtH3rrN47Hzi', '林阳', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 18:13:59', '2025-12-29 18:13:59', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(6, 1968138658, 0, '44829881', '$2y$10$miiMWU5qMAhaIlaWsQE8yeJs1PS5dKgMuh35Qpji86Q.5FdwrizfK', NULL, '7QpUsseM539UnOOF8cyP728OPGaIHknQQwuN1RPgiI83Rpr8WdxH55V24A9I', '元宝', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 18:27:40', '2025-12-29 18:27:40', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(7, 1578912659, 0, '72963959', '$2y$10$ylM339ED9UM9vB6bG.9eQOOcFgB3UfJLrSJhb411tN8x/EYaDik9y', NULL, '7iK6bYjErriK2oRIncGDUh2xy1uk5JKMuhgiZp70BnPx7yLfaova0zuEZ2rr', '啊北', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 18:28:19', '2025-12-29 18:28:19', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(8, 586912056, 0, '19112969', '$2y$10$G2LnJ6mqRYFmAeFvRiqtQeYpwFgoNxkfS6BaaS4wrY234KVVAIiem', NULL, 'GtJf7PwijxclgcPzTZ9aihRl099GSDHPCclpZF4y7C8bIIcnOlgCNgiKA1uj', '道长（有人盗名已经更改，谨防假冒）', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 18:32:46', '2025-12-29 18:32:46', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(9, 7906087778, 0, '96014509', '$2y$10$fxpjYlyXLb3YdYM1U5htt.ue7hxn7dCl9AtA43sdpbttBDt7PRDVm', NULL, 'EEFGmkxjnrykKnxnK82ieedZ8p3DahMJ3SWHWHVQiaf8dGl810Hxs15XLuel', '万里[收菠菜/收六合]', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 18:32:57', '2025-12-29 18:32:57', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(10, NULL, 0, 'na1', '$2y$10$Gl6HT6l/vZNHFaxxcDYQs.OybAQKhyr0usz.GgxUOydh3aFXD3Vnu', NULL, NULL, 'na1', 1, 0, 0, '', 1, NULL, 1, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, 1, 0, 0, '195.86.217.208', NULL, 1767076963, NULL, 3, NULL, NULL, '2025-12-29 20:53:33', '2025-12-30 14:42:43', 1, 1, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(11, NULL, 10, 'na2', '$2y$10$x6hz6g33rRGrCTOid60ysuWf8jwN7ravIZQFTIyRp0Cl7NcKRJO6e', NULL, NULL, 'na2', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, 1, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 20:53:52', '2025-12-29 20:53:52', 1, 2, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(12, NULL, 11, 'na3', '$2y$10$uxm8HJKFRGkVZLEwAYD45ehWCjgDpusAuDxkusnhvr9CRKXkG6yqG', NULL, NULL, 'na3', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, 1, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 20:54:05', '2025-12-29 20:54:34', 1, 3, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(13, NULL, 12, 'na4', '$2y$10$9jey2kpQbz3tp8wT3gkf4u5ljDUY2hBDWZnuvo3xxsRyx2i5s9fiK', NULL, NULL, 'na4', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, 1, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 20:54:20', '2025-12-29 20:54:43', 1, 4, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(14, NULL, 13, 'na5', '$2y$10$lDfIZZQs9pTUzoDwqWwM2uQWjjFQaO7ELXkVfvtjR0ZWoAez.yWma', NULL, NULL, 'na5', 1, 0, 0, '', 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, 1, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 20:55:01', '2025-12-29 20:55:01', 1, 5, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(15, NULL, 0, 'na2001', '$2y$10$USdUOKwCPjsPnNn.4QXf.O80jPo8xlQvlRAj6frkt/ownIJWTJKcO', NULL, NULL, 'na2001', 1, 0, 0, '$2y$10$vLPJK1DU1JIBUCLjrr//ZecBNpJWwv6lYGhJNTS2xJAld2OLUlFm.', 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 20:58:08', '2025-12-29 20:58:08', 1, 0, 10, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(16, 5001752334, 0, '96865421', '$2y$10$cwF8uVgTzi3NWvmYPYMtY.YfJPY.1Pgc2jF6tk/QYNl7zXXXIR4h.', NULL, 'k3GsJdKI2lULeFAjs8ZtVERFIp8D0klEDq7689Ao42BM5CQlZDy7gZLqR6E2', 'pclam', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 21:18:11', '2025-12-29 21:18:11', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(17, 5622429249, 0, '87644821', '$2y$10$F7kc2xoQizhnkCXJJf8F9uU3aa1ATcQ6m0NfaDoCPUEpiwCwjhpSy', NULL, 'FZmVXhr5TFpBwYoG7tUbfQZIdWluXvxa1hEO36krt47A2LzcuTPSvatGrkGz', '金牌客服_乔治 拒绝私聊', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 22:33:30', '2025-12-29 22:33:30', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(18, 6804153364, 0, '24203078', '$2y$10$T9VITIEnWc5Nh3lhgMiYD.WifJisWRsf4pjEPyzMsfFqrQjc9kgea', NULL, 'ec5uvGnTorYXZ0klXYBM4nDT0UKoJtyCBlEWWXQym48BaY9WnUKqoIJLpaQs', 'Su', 3, 0, 0, NULL, 0, NULL, 0, '1451.50', '0.00', '0.00', NULL, NULL, '1430.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 22:57:34', '2026-01-05 12:47:43', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(19, NULL, 0, 'xiaoxiao123', '$2y$10$XcZN1KTs15SPyq/OUG45xeJDZGJgxkH0BK4POEKNoMnjvCCJmKNyC', NULL, 'pVJwhS2p4IoZzMRokCPncb3RojkLIzcFDutw4HhURhqZQq7qsz3TERjmvwOY', '帅哥', 1, 0, 0, '$2y$10$0taPFCbUVNd.9PF9B8A5yungtqXsch7Ij0kQTU95eFrLvID2ec6Ly', 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-29 23:36:57', '2025-12-29 23:36:57', 0, 0, 0, 0, NULL, 0, NULL, 0, NULL, 'cn'),
(20, NULL, 0, 'c111111', '$2y$10$LnzZkQG.n7jDKofhgPf3vO1Xwx9ebYoa2GBZbz7fMFIT.JNa7zv9a', NULL, 'bXrblLFRyM6q7wiBfBQQ2a0utlK70mh4BocFJs1gNvcSzhE6G5CUTaZjy5Pr', 'c111111', 1, 0, 0, '$2y$10$/8yQgEvRmhb8RtcV3l.t1.SxPS9/yo2xUgjPWx2b9UhiBBqygZ9K2', 1, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, '195.86.217.47', NULL, 1767250772, NULL, 0, NULL, NULL, '2025-12-30 14:44:26', '2026-01-01 14:59:32', 0, 0, 0, 0, NULL, 0, NULL, 0, NULL, 'cn'),
(21, 5723492924, 0, '06188230', '$2y$10$lis0rZjQAsdYCCkNNYLAK.h7IzUO56qwP91VGplDVNBh3aHwMgn.K', NULL, 'kJlh8FDCvP2NaG0F496zGSkLmvNMBq4rk74TNfLE9SeahWKlkDQT0BnAFlQB', 'Cullen-3', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 10:15:32', '2025-12-31 10:15:32', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(22, NULL, 0, 'cm-111', '$2y$10$.KaPIesBoXHhKs0JatH4DuNQ4iWYgdehYf2NkhlkGa1kuSt/dqtfS', NULL, NULL, 'cash markert', 1, 0, 0, '$2y$10$CDlgvZqcWfozPU.OLZRnz.GmOHr.LvuVgDqGv3yd2b/nXHe6YYd0u', 0, NULL, 1, '1000.00', '0.00', '0.00', '11112342352323', NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 11:00:16', '2025-12-31 11:01:04', 0, 0, 10, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(23, 8498580759, 0, '84022849', '$2y$10$v28LNlr4BrRZaAsnB36BXeWdFaWgwt.QX0f1XJSXbaSV3yH9hK6j2', NULL, 'sgWAKHyubyMiUcQjcpGWzd52UbTipN3AbxW9uhqwuwhEKpoj8aGWun4NyAEG', 'bakulee - 3', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 11:50:30', '2025-12-31 11:50:30', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(24, 5868882297, 0, '45004376', '$2y$10$avzZSaitlFzet0uKR5ao2.K0O9Sq8JAdxYoAPhRpGh6sMgLA7f/i2', NULL, 'IES9r5gaITe9EcTdpSVgJ8OK9tvPzMZjfUR58In0fPy9zrHQp7daGGWwsB4L', 'Dick-sonic', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 12:47:08', '2025-12-31 12:47:08', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(25, 7765421112, 0, '25457124', '$2y$10$TuEPH.jJ5dedZS6E3/pLJueyv.u9vtuo04.61cqvttPAjYHfCT6Be', NULL, '7SBrzp0biu55WrPE8nWNUZgEBdcSgDLcIcm5XL63SqduTuBjk22Kmt7ubuOU', 'Xiaoxia', 3, 0, 0, NULL, 0, NULL, 0, '4790.00', '10000.00', '0.00', NULL, NULL, '4290.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 13:46:48', '2026-01-05 13:09:25', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(26, NULL, 0, 'ssg_911', '$2y$10$58XdEIkxZZHNpNbKTGKMYe8SoPrUdu2SDEBy8O/XBX.D7jS7xXia.', NULL, NULL, 'ceshi1', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', '14444444444', 'ceshi1@qq.com', '0.00', 1, 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 15:47:05', '2025-12-31 15:47:05', 1, 1, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(27, NULL, 26, 'nas1', '$2y$10$jYnkPFZwJjzrDE6kCM71/eZVBOOcLPl3KnjvNchXbzlVmj1GkRF7C', NULL, NULL, 'nas1', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', '15555555555', 'nas1@qq.com', '0.00', 1, 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 15:53:29', '2025-12-31 15:53:29', 1, 2, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(28, NULL, 27, 'nas2', '$2y$10$glVmJRfb4HqO2xzB2fcuoemGQFdJA6dpCqER1d97BxrYwk.27k80u', NULL, NULL, 'nas2', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', '14444444443', 'nas2@qq.com', '0.00', 1, 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 15:54:09', '2025-12-31 15:54:09', 1, 3, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(29, NULL, 26, 'nas10', '$2y$10$Ny8i4/ygeSjPB6eu0C1t0.yCSREVrjz4ABY.2gBMGy1H.JUaVCOlC', NULL, NULL, 'nas10', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', '14444444441', 'nas10@qq.com', '0.00', 1, 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 15:58:44', '2025-12-31 15:58:44', 1, 2, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(30, NULL, 26, 'nas11', '$2y$10$ZQSfPelDBuJdv.CFkwcqneTE1Bpr5zjS4FchpbUsbReEUlmGZRTeO', NULL, NULL, 'nas11', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', '14444444442', 'nas11@qq.com', '0.00', 1, 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 16:03:25', '2025-12-31 16:03:25', 1, 2, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(31, NULL, 26, 'nas12', '$2y$10$ieWK3knixiW04X7hadiUy.kCL6aidubRWEdsNCkeGCrwhtn00THGu', NULL, NULL, 'nas12', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', '14444444445', 'nas12@qq.com', '0.00', 1, 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 16:06:11', '2025-12-31 16:06:11', 1, 2, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(32, NULL, 26, 'nas13', '$2y$10$6mK65FU5l.fZ8d8auQMBE.8bOxoRaY5vewN4dFFejwniAesgyFItq', NULL, NULL, 'nas13', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', '14444444446', 'nas13@qq.com', '0.00', 1, 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 16:09:58', '2025-12-31 16:09:58', 1, 2, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(33, NULL, 26, 'nas14', '$2y$10$tbETCLUBkT3VTO/C73vLkeH5G157uukNHaBIc32/WKFOJa8Xbeo.i', NULL, NULL, 'nas14', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', '14444444447', 'nas14@qq.com', '0.00', 1, 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 16:11:08', '2025-12-31 16:11:08', 1, 2, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(34, NULL, 26, 'nas15', '$2y$10$dT7EcFn/P6dLUQsjKLIwGOUhjVKqEu4tA8gyIw7L/HHe70jTMg8Fu', NULL, NULL, 'nas15', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', '14444444448', 'nas15@qq.com', '0.00', 1, 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 16:12:31', '2025-12-31 16:12:31', 1, 2, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(35, NULL, 26, 'nas16', '$2y$10$4n4.jbx99iEn.MMVgUQAiebUy4XrYTTrci61OsjAub4Zqm6fwbK4W', NULL, NULL, 'nas16', 1, 0, 0, '', 0, NULL, 1, '0.00', '0.00', '0.00', '14444444449', 'nas16@qq.com', '0.00', 1, 2, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 16:13:40', '2025-12-31 16:13:40', 1, 2, 0, 9, '10.00', 0, NULL, 1, NULL, 'cn'),
(36, 818028545, 0, '71203285', '$2y$10$RhcwzwT3JbucPhvDISAwju66QE5tJHTxyoeg/MFtIe977q8IvRdOC', NULL, 'DfNmB3TpK4CkcxNMERQbo8in4cDFGHmF1nZ8arjNEHoWoWXqXle6RRmPShKa', '嘉明', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-12-31 19:33:39', '2025-12-31 19:33:39', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(37, 1078834923, 0, '44793574', '$2y$10$7UKa2UT3wUNR9zXJlBxjJO69FxRNerV1uOOisYm1cQ06H7aqwmNA6', NULL, 'ZmNEWqmsDCxVgqUddhMezyYc04BwlJ8kNjACNtGyTb9d5xBRFMEf5FZ6ZSzl', '雷 洛', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-01-02 00:07:24', '2026-01-02 00:07:24', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(38, NULL, 0, 'winston224', '$2y$10$D4i/mYNmeBZG0SekH4tZUes2BfyqvdfN.CVQWozxaPjod1uGzN3nq', NULL, 'cm0qVv2ni6RdZsdPXwQMo17l8ZdubVrB2OYSfh2wCniWJxxJnTQ3ZFjQtPtk', 'winston224', 1, 0, 0, '$2y$10$6XgUrmtWHj80xYGE4c0/jepXjHQj0AUtGWQB5fJWU0VA3AbexwpOW', 1, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, '182.239.115.157', NULL, 1767511446, NULL, 0, NULL, NULL, '2026-01-04 09:27:38', '2026-01-04 15:24:06', 0, 0, 0, 0, NULL, 0, NULL, 0, NULL, 'cn'),
(39, NULL, 0, 'ceshis', '$2y$10$5ZdJL6FZ0psezoa6sDZKKOXEtlXVtffZSXj4YgxeI8r6PDh8Hh.eW', NULL, 'P425iPBrRENh3IZDCAOYlfqRoFejm2rmRLRdsisKwgEC8NLcT2tANC2VZ03I', 'ceshi', 1, 0, 0, '$2y$10$rBu94Wkv15GKKNzKQwGW9eY9AGEBjGRJCoO2Lw0wXWGXsNcea6hFK', 1, NULL, 1, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, '163.204.68.94', NULL, 1768619093, NULL, 0, NULL, NULL, '2026-01-14 16:56:46', '2026-01-17 11:26:47', 0, 0, 0, 0, NULL, 0, NULL, 0, NULL, 'cn'),
(40, 8025331916, 0, 'dp8025331916', '$2y$10$GwFWTquNrT8PsNVLzG/CCumdgT3lw25L7/hLDMq1uiAvMUyi4aYq6', NULL, 'HOz2ejoZlorIXEWGPeQmzp5D886HQWYhURWn1aJNWUgTjQ9ElgqDQnhsDbzW', '李', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-01-14 22:33:26', '2026-01-14 22:33:26', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(41, 8325933181, 0, 'dp8325933181', '$2y$10$y7leMsKeOD9fFlIZnKdzdOpKo9HiCYCyHAoGlGC02TLMjmSCyUEre', NULL, '7KEj5KQ6qA3f35TWDr9pdY2qE4Ag3MEcvyDnRzPxelAzQLV5I7vJHZqD3w7G', 'Miriam', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-01-15 01:50:21', '2026-01-15 01:50:21', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn'),
(42, NULL, 0, 'hop1998', '$2y$10$nUsdmQm11XOFmheLbJKnye7FL2rm1LxJ2Wz3J87dndCEacZkVlXHe', NULL, 'QBjNm9QXUJcUo4ChHOIAlDW7yO2ewj1dfC2mAZCAsPI0i0rfXTUH8XwXMo9y', 'hop1998', 1, 0, 0, '$2y$10$tHDnmtEpkh5PBWSdsPseUOH43XKQTntPWMwOeij3B2OQyfORJABie', 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-01-15 12:44:34', '2026-01-15 12:44:34', 0, 0, 0, 0, NULL, 0, NULL, 0, NULL, 'cn'),
(43, 5207655223, 0, 'dp5207655223', '$2y$10$vbapfX5k5/3iOsM6RwReWe6f1NeHilpzDJdwFxQiOnyIkXKb8McN.', NULL, 'dTIQn1gmNxreVBCoYBvSqaDeo5aXPPjiRSFbqhQDdblaKbRsmArv1r6ikKyU', '👓', 1, 0, 0, NULL, 0, NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, '0.00', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-01-16 14:08:19', '2026-01-16 14:08:19', 0, 0, 0, 0, NULL, 0, NULL, 1, NULL, 'cn');

-- --------------------------------------------------------

--
-- 表的结构 `usersmoney`
--

CREATE TABLE `usersmoney` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `ag_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `allbet_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bbin_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bg_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `og_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pt_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gd_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dg_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `qt_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `ky_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `ig_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jdb_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fg_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `avia_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `leg_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bng_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dt_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gg_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT NULL,
  `vrbet_money` decimal(10,2) DEFAULT '0.00',
  `hlgame_money` decimal(10,2) DEFAULT '0.00',
  `hbb_money` decimal(10,2) DEFAULT '0.00',
  `qg_money` decimal(10,2) DEFAULT '0.00',
  `hc_money` decimal(10,2) DEFAULT '0.00',
  `play99_money` decimal(10,2) DEFAULT '0.00',
  `yb_money` decimal(10,2) DEFAULT '0.00',
  `ly_money` decimal(10,2) DEFAULT '0.00',
  `kx_money` decimal(10,2) DEFAULT '0.00',
  `dfw_money` decimal(10,2) DEFAULT '0.00',
  `xsj_money` decimal(10,2) DEFAULT '0.00',
  `ld_money` decimal(10,2) DEFAULT '0.00',
  `ae_money` decimal(10,2) DEFAULT '0.00',
  `oap_money` decimal(10,2) DEFAULT '0.00',
  `ia_money` decimal(10,2) DEFAULT '0.00',
  `sy_money` decimal(10,2) DEFAULT '0.00',
  `xsbo_money` decimal(10,2) DEFAULT '0.00',
  `ps_money` decimal(10,2) DEFAULT '0.00',
  `habaner_money` decimal(10,2) DEFAULT '0.00',
  `jz_money` decimal(10,2) DEFAULT '0.00',
  `cmd_money` decimal(10,2) DEFAULT '0.00',
  `sbtest_money` decimal(10,2) DEFAULT '0.00',
  `wm_money` decimal(10,2) DEFAULT '0.00',
  `zeus_money` decimal(10,2) DEFAULT '0.00',
  `cg_money` decimal(10,2) DEFAULT '0.00',
  `icg_money` decimal(10,2) DEFAULT '0.00',
  `pp_money` decimal(10,2) DEFAULT '0.00',
  `pg_money` decimal(10,2) DEFAULT '0.00',
  `sg_money` decimal(10,2) DEFAULT '0.00',
  `vg_money` decimal(10,2) DEFAULT '0.00',
  `tc_money` decimal(10,2) DEFAULT '0.00',
  `datqp_money` decimal(10,2) DEFAULT '0.00',
  `tm_money` decimal(10,2) DEFAULT '0.00',
  `ap_money` decimal(10,2) DEFAULT '0.00',
  `kx2_money` decimal(10,2) DEFAULT '0.00',
  `imone_money` decimal(10,2) DEFAULT '0.00',
  `obgzr_money` decimal(10,2) DEFAULT '0.00',
  `obgqp_money` decimal(10,2) DEFAULT '0.00',
  `saba_money` decimal(10,2) DEFAULT '0.00',
  `obgcp_money` decimal(10,2) DEFAULT '0.00',
  `obgdj_money` decimal(10,2) DEFAULT '0.00',
  `obgty_money` decimal(10,2) DEFAULT '0.00',
  `obgdy_money` decimal(10,2) DEFAULT '0.00',
  `dl_money` decimal(10,2) DEFAULT '0.00',
  `obgpy_money` decimal(10,2) DEFAULT '0.00',
  `xjty_money` decimal(10,2) DEFAULT '0.00',
  `hgty_money` decimal(10,2) DEFAULT '0.00',
  `cqty_money` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `user_api`
--

CREATE TABLE `user_api` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `api_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '消息id',
  `api_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `user_api`
--

INSERT INTO `user_api` (`id`, `user_id`, `api_user`, `api_pass`, `api_code`, `api_money`, `created_at`, `updated_at`) VALUES
(1, 6, 'ss112422', '123456', 'JDB', '10.00', '2025-10-13 10:05:13', '2025-10-13 10:05:13'),
(2, 13, 'k112411', '123456', 'JDB', '10.00', '2025-10-15 09:06:16', '2025-10-15 09:06:16'),
(3, 15, 'tt123456', '123456', 'JDB', '9.00', '2025-10-15 09:10:06', '2025-10-15 09:12:55'),
(4, 15, 'tt123456', '123456', 'AG', '0.00', '2025-10-15 09:10:18', '2025-10-15 09:10:50'),
(6, 15, 'tt123456', '123456', 'LEG', '0.00', '2025-10-15 09:12:40', '2025-10-15 09:12:54'),
(7, 17, 'r112411', '123456', 'JDB', '10.00', '2025-10-15 09:25:35', '2025-10-15 09:25:36'),
(9, 21, 'OOO123123', '123456', 'IGSS', '8.00', '2025-10-15 09:41:49', '2025-10-15 09:50:52'),
(10, 21, 'OOO123123', '123456', 'JDB', '2.00', '2025-10-15 09:51:53', '2025-10-15 09:51:54'),
(11, 19, 'xx123456', '123456', 'AG', '0.00', '2025-10-15 10:12:59', '2025-10-15 10:13:28'),
(12, 19, 'xiaoxiao123', '123456', 'DG', '0.00', '2025-10-15 10:13:26', '2026-01-17 01:05:16'),
(13, 19, 'xx123456', '123456', 'WM', '0.00', '2025-10-15 10:14:27', '2025-10-15 10:14:27'),
(14, 19, 'xx123456', '123456', 'AB', '0.00', '2025-10-15 10:14:34', '2025-10-15 10:14:34'),
(15, 19, 'xx123456', '123456', 'JDB', '94.00', '2025-10-15 10:14:57', '2025-10-15 10:15:01'),
(16, 23, '999BBB', '123456', 'JDB', '25.00', '2025-10-18 05:58:19', '2025-10-18 08:59:15'),
(18, 25, 'WW1111', '123456', 'WM', '0.00', '2025-10-18 07:02:38', '2025-10-18 07:02:38'),
(19, 25, 'WW1111', '123456', 'AG', '0.00', '2025-10-18 07:03:43', '2025-10-18 07:04:23'),
(20, 25, 'WW1111', '123456', 'BBIN', '0.00', '2025-10-18 07:03:56', '2025-10-18 07:10:45'),
(21, 25, '25457124', '123456', 'OBZR', '16.00', '2025-10-18 07:04:20', '2026-01-17 01:04:41'),
(22, 25, 'WW1111', '123456', 'JDB', '10.00', '2025-10-18 07:05:37', '2025-10-18 07:10:46'),
(23, 28, 'AA3333', '123456', 'BBIN', '0.00', '2025-10-18 07:30:39', '2025-10-18 07:30:53'),
(24, 28, 'nas2', '123456', 'DG', '0.00', '2025-10-18 07:30:51', '2026-01-17 01:05:16'),
(26, 28, 'AA3333', '123456', 'WM', '250.00', '2025-10-18 07:59:35', '2025-10-19 18:58:44'),
(27, 33, 'CC3333', '123456', 'WM', '0.00', '2025-10-18 08:24:08', '2025-10-18 17:18:27'),
(28, 33, 'CC3333', '123456', 'BBIN', '0.00', '2025-10-18 08:24:20', '2025-10-19 09:11:00'),
(29, 34, 'cc112411', '123456', 'JDB', '0.00', '2025-10-18 08:30:46', '2025-10-18 08:38:18'),
(30, 12, 'c112411', '123456', 'JDB', '0.00', '2025-10-18 08:39:08', '2025-10-18 08:39:08'),
(31, 36, 'gg112411', '123456', 'JDB', '10.00', '2025-10-18 08:51:44', '2025-10-18 08:51:45'),
(32, 23, '999BBB', '123456', 'AG', '0.00', '2025-10-18 08:58:45', '2025-10-18 08:59:14'),
(33, 23, '999BBB', '123456', 'KY', '0.00', '2025-10-18 08:59:00', '2025-10-18 08:59:00'),
(35, 38, 'MM2222', '123456', 'JDB', '0.00', '2025-10-18 09:19:45', '2025-10-18 09:20:58'),
(36, 38, 'MM2222', '123456', 'WM', '0.00', '2025-10-18 09:49:47', '2025-10-18 09:49:56'),
(37, 38, 'MM2222', '123456', 'BBIN', '0.00', '2025-10-18 09:49:54', '2025-10-18 09:50:12'),
(38, 40, 'JHY2222', '123456', 'AG', '0.00', '2025-10-18 11:16:23', '2025-10-18 11:20:22'),
(39, 40, 'JHY2222', '123456', 'WM', '0.00', '2025-10-18 11:18:18', '2025-10-18 11:28:18'),
(40, 40, 'JHY2222', '123456', 'SEXY', '0.00', '2025-10-18 11:20:54', '2025-10-18 11:20:54'),
(41, 40, 'JHY2222', '123456', 'AGDZ', '0.00', '2025-10-18 11:21:00', '2025-10-18 11:21:17'),
(42, 40, 'JHY2222', '123456', 'BBIN', '0.00', '2025-10-18 11:21:14', '2025-10-18 11:21:41'),
(44, 12, 'na3', '123456', 'DG', '0.00', '2025-10-18 11:38:52', '2026-01-17 01:05:16'),
(45, 41, '121212', '123456', 'JDB', '10.00', '2025-10-18 12:38:49', '2025-10-18 12:38:50'),
(46, 53, 'MH4444', '123456', 'WM', '10.00', '2025-10-18 16:10:40', '2025-10-18 16:10:44'),
(47, 49, 'TY4444', '123456', 'WM', '0.00', '2025-10-18 16:13:48', '2025-10-20 13:35:49'),
(48, 45, 'GH4444', '123456', 'AG', '0.00', '2025-10-18 16:18:31', '2025-10-19 16:19:29'),
(49, 45, 'GH4444', '123456', 'WM', '10.00', '2025-10-18 16:18:53', '2025-10-19 16:38:38'),
(50, 54, 'YY1234', '123456', 'WM', '0.00', '2025-10-18 16:38:52', '2025-10-18 16:42:47'),
(51, 54, 'YY1234', '123456', 'BBIN', '0.00', '2025-10-18 16:40:51', '2025-10-18 16:41:07'),
(52, 54, 'YY1234', '123456', 'OBZR', '0.00', '2025-10-18 16:41:05', '2025-10-18 16:41:48'),
(53, 55, 'UU1234', '123456', 'WM', '0.00', '2025-10-18 16:45:59', '2025-10-18 16:48:59'),
(54, 56, 'TT1234', '123456', 'WM', '10.00', '2025-10-18 16:51:06', '2025-10-18 16:51:48'),
(55, 56, 'TT1234', '123456', 'OBZR', '0.00', '2025-10-18 16:51:47', '2025-10-18 16:51:59'),
(56, 56, 'TT1234', '123456', 'OBZR', '0.00', '2025-10-18 16:51:47', '2025-10-18 16:51:47'),
(57, 57, 'MM1234', '123456', 'WM', '0.00', '2025-10-18 16:56:24', '2025-10-18 17:01:10'),
(58, 58, 'gameover123', '123456', 'WM', '10.00', '2025-10-18 17:25:49', '2025-10-18 21:47:56'),
(59, 58, 'gameover123', '123456', 'CQ9', '0.00', '2025-10-18 21:42:19', '2025-10-18 21:43:03'),
(60, 33, 'nas14', '123456', 'OBTY', '30.00', '2025-10-19 09:10:58', '2026-01-17 01:04:54'),
(61, 61, 'YYY1234', '123456', 'WM', '0.00', '2025-10-19 09:18:15', '2025-10-20 13:35:57'),
(62, 65, 'KL4444', '123456', 'WM', '120.00', '2025-10-19 16:27:44', '2025-10-19 16:36:41'),
(63, 65, 'KL4444', '123456', 'OBZR', '0.00', '2025-10-19 16:31:42', '2025-10-19 16:31:42'),
(64, 45, 'GH4444', '123456', 'BBIN', '0.00', '2025-10-19 16:55:46', '2025-10-19 16:57:01'),
(65, 45, 'GH4444', '123456', 'OBZR', '0.00', '2025-10-19 16:57:00', '2025-10-19 17:05:16'),
(66, 66, 'vip1234', '123456', 'WM', '0.00', '2025-10-19 17:05:00', '2025-10-19 17:10:39'),
(67, 45, 'GH4444', '123456', 'IGSS', '0.00', '2025-10-19 17:05:15', '2025-10-20 04:54:51'),
(68, 45, 'GH4444', '123456', 'VR', '0.00', '2025-10-19 17:05:40', '2025-10-19 17:08:04'),
(69, 66, 'vip1234', '123456', 'AG', '0.00', '2025-10-19 17:10:57', '2025-10-19 17:11:13'),
(70, 66, 'vip1234', '123456', 'IGSS', '10.00', '2025-10-19 17:11:30', '2025-10-19 17:11:31'),
(71, 32, 'ss112411', '123456', 'PG', '0.00', '2025-10-19 17:22:25', '2025-10-19 17:22:25'),
(72, 28, 'nas2', '123456', 'OBZR', '0.00', '2025-10-19 18:36:05', '2026-01-17 01:04:41'),
(73, 28, 'AA3333', '123456', 'PNG', '0.00', '2025-10-19 18:41:26', '2025-10-19 18:42:01'),
(74, 28, 'AA3333', '123456', 'OBQP', '0.00', '2025-10-19 18:43:29', '2025-10-19 18:43:49'),
(75, 28, 'AA3333', '123456', 'JDB', '0.00', '2025-10-19 18:44:09', '2025-10-19 18:50:42'),
(76, 28, 'AA3333', '123456', 'WELIVE', '0.00', '2025-10-19 18:46:33', '2025-10-19 18:46:33'),
(77, 28, 'AA3333', '123456', 'BG', '0.00', '2025-10-19 18:46:44', '2025-10-19 18:46:44'),
(78, 28, 'AA3333', '123456', 'AB', '0.00', '2025-10-19 18:46:51', '2025-10-19 18:47:29'),
(79, 70, 'ZX4444', '123456', 'WM', '0.00', '2025-10-20 06:13:18', '2025-10-20 06:18:00'),
(80, 71, 'ZX5555', '123456', 'WM', '10.00', '2025-10-20 06:23:40', '2025-10-20 13:35:33'),
(81, 75, 'TR4444', '123456', 'OBZR', '40.00', '2025-10-20 07:20:23', '2025-10-20 08:18:32'),
(82, 75, 'TR4444', '123456', 'BBIN', '0.00', '2025-10-20 07:23:51', '2025-10-20 08:13:35'),
(83, 75, 'TR4444', '123456', 'AG', '0.00', '2025-10-20 08:14:01', '2025-10-20 08:16:56'),
(84, 75, 'TR4444', '123456', 'WM', '0.00', '2025-10-20 08:16:53', '2025-10-20 08:18:31'),
(85, 76, 'tianxia11', '123456', 'WM', '10.00', '2025-10-20 12:18:35', '2025-10-20 12:39:13'),
(86, 77, 'tianxia112', '123456', 'WM', '10.00', '2025-10-20 12:27:14', '2025-10-20 12:42:34'),
(87, 77, 'tianxia112', '123456', 'AGDZ', '0.00', '2025-10-20 12:29:10', '2025-10-20 12:29:10'),
(88, 77, 'tianxia112', '123456', 'JDB', '0.00', '2025-10-20 12:35:47', '2025-10-20 12:35:47'),
(89, 76, 'tianxia11', '123456', 'JDB', '20.00', '2025-10-20 12:38:22', '2025-10-20 12:39:06'),
(90, 78, 'a123456', '123456', 'WM', '0.00', '2025-10-20 12:49:32', '2025-10-20 12:51:47'),
(91, 79, 'tianxia1123', '123456', 'WM', '0.00', '2025-10-20 12:54:23', '2025-10-20 12:54:23'),
(92, 26, 'AA1111', '123456', 'WM', '0.00', '2025-10-20 12:55:10', '2025-10-20 12:59:29'),
(93, 80, 'cs8939', '123456', 'WM', '0.00', '2025-10-20 13:02:18', '2025-10-20 13:02:18'),
(94, 81, 'kakakoko1', '123456', 'WM', '0.00', '2025-10-20 13:28:34', '2025-10-20 13:34:30'),
(95, 82, 'tianxia11211', '123456', 'WM', '10.00', '2025-10-20 13:42:49', '2025-10-20 13:47:19'),
(96, 87, 'KK4444', '123456', 'WM', '0.00', '2025-10-22 06:25:52', '2025-10-22 06:28:43'),
(97, 93, 'FF22222', '123456', 'WM', '0.50', '2025-10-22 10:18:44', '2025-10-24 19:23:42'),
(98, 94, 'FF44444', '123456', 'WM', '10.00', '2025-10-22 11:23:21', '2025-10-22 11:23:25'),
(99, 42, 'GH1111', '123456', 'WM', '0.00', '2025-10-25 16:52:03', '2025-10-25 16:52:03'),
(100, 20, 'my343110132', '123456', 'pussy', '0.00', '2025-12-30 23:49:12', '2025-12-30 23:49:12'),
(101, 26, 'my624701146', '123456', 'pussy', '0.00', '2025-12-31 15:47:06', '2025-12-31 15:47:06'),
(102, 27, 'my808213811', '123456', 'pussy', '0.00', '2025-12-31 15:53:30', '2025-12-31 15:53:30'),
(103, 28, 'my555089523', '123456', 'pussy', '0.00', '2025-12-31 15:54:09', '2025-12-31 15:54:09'),
(104, 2, '70113297', '123456', 'OBTY', '0.00', '2026-01-01 09:41:46', '2026-01-17 01:04:54'),
(105, 1, 'AG41570525', '123456', 'AG', '0.00', '2026-01-01 10:46:23', '2026-01-01 10:46:23'),
(106, 1, '41570525', '123456', 'GMAG', '0.00', '2026-01-01 10:47:02', '2026-01-17 15:20:21'),
(107, 20, 'c111111', '123456', 'OBTY', '0.00', '2026-01-01 11:15:06', '2026-01-17 01:04:54'),
(108, 20, 'AGc111111', '123456', 'AG', '0.00', '2026-01-01 14:59:55', '2026-01-01 14:59:55'),
(109, 2, 'AG70113297', '123456', 'AG', '0.00', '2026-01-01 15:26:23', '2026-01-01 15:26:23'),
(110, 1, '41570525', '123456', 'OBTY', '0.00', '2026-01-01 23:03:41', '2026-01-17 01:04:54'),
(111, 1, 'KY41570525', '123456', 'KY', '0.00', '2026-01-01 23:17:50', '2026-01-01 23:17:50'),
(112, 1, 'CP41570525', '123456', 'OBCP', '0.00', '2026-01-01 23:22:10', '2026-01-01 23:22:10'),
(115, 39, 'ceshis', '123456', 'DPTY', '0.00', '2026-01-17 00:55:21', '2026-01-17 01:05:39'),
(116, 1, '41570525', '123456', 'DBZR', '0.00', '2026-01-17 01:04:03', '2026-01-17 15:20:20'),
(117, 39, 'ceshis', '123456', 'DBZR', '0.00', '2026-01-17 01:04:03', '2026-01-17 15:20:21'),
(158, 2, '70113297', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(159, 3, '49972597', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(160, 4, '25071564', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(161, 5, '31739065', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(162, 6, '44829881', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(163, 7, '72963959', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(164, 8, '19112969', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(165, 9, '96014509', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(166, 10, 'na1', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(167, 11, 'na2', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(168, 12, 'na3', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(169, 13, 'na4', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(170, 14, 'na5', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(171, 15, 'na2001', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(172, 16, '96865421', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(173, 17, '87644821', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(174, 18, '24203078', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(175, 19, 'xiaoxiao123', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(176, 20, 'c111111', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(177, 21, '06188230', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(178, 22, 'cm-111', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(179, 23, '84022849', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(180, 24, '45004376', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(181, 26, 'ssg_911', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(182, 27, 'nas1', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(183, 29, 'nas10', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(184, 30, 'nas11', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(185, 31, 'nas12', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(186, 32, 'nas13', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(187, 33, 'nas14', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(188, 34, 'nas15', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(189, 35, 'nas16', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(190, 36, '71203285', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(191, 37, '44793574', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(192, 38, 'winston224', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(193, 39, 'ceshis', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(194, 40, 'dp8025331916', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(195, 41, 'dp8325933181', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(196, 42, 'hop1998', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(197, 43, 'dp5207655223', '123456', 'OBZR', '0.00', '2026-01-17 01:04:41', '2026-01-17 01:04:41'),
(198, 3, '49972597', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(199, 4, '25071564', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(200, 5, '31739065', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(201, 6, '44829881', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(202, 7, '72963959', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(203, 8, '19112969', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(204, 9, '96014509', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(205, 10, 'na1', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(206, 11, 'na2', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(207, 12, 'na3', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(208, 13, 'na4', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(209, 14, 'na5', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(210, 15, 'na2001', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(211, 16, '96865421', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(212, 17, '87644821', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(213, 18, '24203078', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(214, 19, 'xiaoxiao123', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(215, 21, '06188230', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(216, 22, 'cm-111', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(217, 23, '84022849', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(218, 24, '45004376', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(219, 25, '25457124', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(220, 26, 'ssg_911', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(221, 27, 'nas1', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(222, 28, 'nas2', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(223, 29, 'nas10', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(224, 30, 'nas11', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(225, 31, 'nas12', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(226, 32, 'nas13', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(227, 34, 'nas15', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(228, 35, 'nas16', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(229, 36, '71203285', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(230, 37, '44793574', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(231, 38, 'winston224', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(232, 39, 'ceshis', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(233, 40, 'dp8025331916', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(234, 41, 'dp8325933181', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(235, 42, 'hop1998', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(236, 43, 'dp5207655223', '123456', 'OBTY', '0.00', '2026-01-17 01:04:54', '2026-01-17 01:04:54'),
(237, 1, '41570525', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(238, 2, '70113297', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(239, 3, '49972597', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(240, 4, '25071564', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(241, 5, '31739065', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(242, 6, '44829881', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(243, 7, '72963959', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(244, 8, '19112969', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(245, 9, '96014509', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(246, 10, 'na1', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(247, 11, 'na2', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(248, 12, 'na3', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(249, 13, 'na4', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(250, 14, 'na5', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(251, 15, 'na2001', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(252, 16, '96865421', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(253, 17, '87644821', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(254, 18, '24203078', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(255, 19, 'xiaoxiao123', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(256, 20, 'c111111', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(257, 21, '06188230', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(258, 22, 'cm-111', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(259, 23, '84022849', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(260, 24, '45004376', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(261, 25, '25457124', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(262, 26, 'ssg_911', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(263, 27, 'nas1', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(264, 28, 'nas2', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(265, 29, 'nas10', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(266, 30, 'nas11', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(267, 31, 'nas12', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(268, 32, 'nas13', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(269, 33, 'nas14', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(270, 34, 'nas15', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(271, 35, 'nas16', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(272, 36, '71203285', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(273, 37, '44793574', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(274, 38, 'winston224', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(275, 39, 'ceshis', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(276, 40, 'dp8025331916', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(277, 41, 'dp8325933181', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(278, 42, 'hop1998', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(279, 43, 'dp5207655223', '123456', 'DBTY', '0.00', '2026-01-17 01:04:58', '2026-01-17 01:04:58'),
(280, 1, '41570525', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(281, 2, '70113297', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(282, 3, '49972597', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(283, 4, '25071564', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(284, 5, '31739065', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(285, 6, '44829881', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(286, 7, '72963959', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(287, 8, '19112969', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(288, 9, '96014509', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(289, 10, 'na1', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(290, 11, 'na2', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(291, 13, 'na4', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(292, 14, 'na5', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(293, 15, 'na2001', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(294, 16, '96865421', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(295, 17, '87644821', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(296, 18, '24203078', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(297, 20, 'c111111', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(298, 21, '06188230', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(299, 22, 'cm-111', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(300, 23, '84022849', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(301, 24, '45004376', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(302, 25, '25457124', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(303, 26, 'ssg_911', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(304, 27, 'nas1', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(305, 29, 'nas10', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(306, 30, 'nas11', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(307, 31, 'nas12', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(308, 32, 'nas13', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(309, 33, 'nas14', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(310, 34, 'nas15', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(311, 35, 'nas16', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(312, 36, '71203285', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(313, 37, '44793574', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(314, 38, 'winston224', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(315, 39, 'ceshis', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(316, 40, 'dp8025331916', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(317, 41, 'dp8325933181', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(318, 42, 'hop1998', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(319, 43, 'dp5207655223', '123456', 'DG', '0.00', '2026-01-17 01:05:16', '2026-01-17 01:05:16'),
(363, 1, '41570525', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(364, 2, '70113297', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(365, 3, '49972597', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(366, 4, '25071564', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(367, 5, '31739065', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(368, 6, '44829881', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(369, 7, '72963959', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(370, 8, '19112969', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(371, 9, '96014509', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(372, 10, 'na1', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(373, 11, 'na2', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(374, 12, 'na3', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(375, 13, 'na4', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(376, 14, 'na5', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(377, 15, 'na2001', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(378, 16, '96865421', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(379, 17, '87644821', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(380, 18, '24203078', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(381, 19, 'xiaoxiao123', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(382, 20, 'c111111', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(383, 21, '06188230', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(384, 22, 'cm-111', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(385, 23, '84022849', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(386, 24, '45004376', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(387, 25, '25457124', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(388, 26, 'ssg_911', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(389, 27, 'nas1', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(390, 28, 'nas2', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(391, 29, 'nas10', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(392, 30, 'nas11', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(393, 31, 'nas12', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(394, 32, 'nas13', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(395, 33, 'nas14', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(396, 34, 'nas15', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(397, 35, 'nas16', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(398, 36, '71203285', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(399, 37, '44793574', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(400, 38, 'winston224', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(401, 40, 'dp8025331916', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(402, 41, 'dp8325933181', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(403, 42, 'hop1998', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(404, 43, 'dp5207655223', '123456', 'DPTY', '0.00', '2026-01-17 01:05:39', '2026-01-17 01:05:39'),
(405, 1, '41570525', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(406, 2, '70113297', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(407, 3, '49972597', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(408, 4, '25071564', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(409, 5, '31739065', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(410, 6, '44829881', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(411, 7, '72963959', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(412, 8, '19112969', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(413, 9, '96014509', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(414, 10, 'na1', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(415, 11, 'na2', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(416, 12, 'na3', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(417, 13, 'na4', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(418, 14, 'na5', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(419, 15, 'na2001', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(420, 16, '96865421', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(421, 17, '87644821', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(422, 18, '24203078', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(423, 19, 'xiaoxiao123', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(424, 20, 'c111111', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(425, 21, '06188230', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(426, 22, 'cm-111', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(427, 23, '84022849', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(428, 24, '45004376', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(429, 25, '25457124', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(430, 26, 'ssg_911', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(431, 27, 'nas1', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(432, 28, 'nas2', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(433, 29, 'nas10', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(434, 30, 'nas11', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(435, 31, 'nas12', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(436, 32, 'nas13', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(437, 33, 'nas14', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(438, 34, 'nas15', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(439, 35, 'nas16', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(440, 36, '71203285', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(441, 37, '44793574', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(442, 38, 'winston224', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(443, 39, 'ceshis', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(444, 40, 'dp8025331916', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(445, 41, 'dp8325933181', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(446, 42, 'hop1998', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(447, 43, 'dp5207655223', '123456', 'DBDZ', '0.00', '2026-01-17 01:05:54', '2026-01-17 01:05:54'),
(448, 39, 'DJceshis', '123456', 'DBDJ', '0.00', '2026-01-17 01:06:16', '2026-01-17 01:06:16'),
(449, 1, '5003219595', '123456', 'GMAG', '0.00', '2026-01-17 01:05:30', '2026-01-17 15:20:22'),
(450, 2, '70113297', '123456', 'EVO', '0.00', '2026-01-17 01:58:31', '2026-01-17 07:20:21'),
(451, 1, '41570525', '123456', 'EVO', '0.00', '2026-01-17 01:59:06', '2026-01-17 07:20:21'),
(452, 2, '70113297', '123456', 'GMAG', '0.00', '2026-01-17 02:28:20', '2026-01-17 15:20:20'),
(453, 40, 'dp8025331916', '123456', 'GMAG', '0.00', '2026-01-17 02:30:45', '2026-01-17 15:20:21'),
(454, 40, 'dp8025331916', '123456', 'GMAG', '0.00', NULL, '2026-01-17 15:20:21'),
(455, 2, '70113297', '123456', 'GMAG', '0.00', NULL, '2026-01-17 15:20:22'),
(456, 2, '70113297', '123456', 'GMAG', '0.00', NULL, '2026-01-17 15:20:20'),
(457, 1, '41570525', '123456', 'GMAG', '0.00', NULL, '2026-01-17 15:20:21'),
(458, 39, 'ceshis', '123456', 'GMAG', '471.30', NULL, '2026-01-17 15:20:21'),
(459, 39, 'ceshis', '123456', 'DBKY', '1825.35', '2026-01-17 11:04:56', '2026-01-17 12:57:52');

-- --------------------------------------------------------

--
-- 表的结构 `user_cards`
--

CREATE TABLE `user_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `bank` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '开户行',
  `bank_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '卡号',
  `bank_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '开户行',
  `bank_owner` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '持卡人姓名',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `user_messages`
--

CREATE TABLE `user_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `message_id` int(11) NOT NULL COMMENT '消息id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `user_operate_logs`
--

CREATE TABLE `user_operate_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `type` tinyint(4) NOT NULL COMMENT '操作类型 1登录 2登出 3会员操作 4代理后台登入 5代理后台登出 6会员转入接口异常',
  `login_ua` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '登录请求头',
  `login_ip` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '登录ip',
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ip地址',
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `user_operate_logs`
--

INSERT INTO `user_operate_logs` (`id`, `user_id`, `type`, `login_ua`, `login_ip`, `ip_address`, `desc`, `info`, `created_at`, `updated_at`) VALUES
(311, 98, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.76.21', '', '代理【na3】登录成功', '', '2025-12-21 21:29:36', '2025-12-21 21:29:36'),
(312, 98, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.76.21', '', '会员【na3】注销账号', '', '2025-12-21 21:51:05', '2025-12-21 21:51:05'),
(313, 96, 7, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.76.21', '未知地区', '管理员调整【na1】账户余额，调整金额数60000，调整前金额0.00，调整后金额60000', '', '2025-12-21 21:51:39', '2025-12-21 21:51:39'),
(314, 96, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.76.21', '', '代理【na1】登录成功', '', '2025-12-21 21:51:55', '2025-12-21 21:51:55'),
(315, 96, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.76.21', '', '会员【na1】注销账号', '', '2025-12-21 22:43:27', '2025-12-21 22:43:27'),
(316, 100, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.76.21', '', '代理【na5】登录成功', '', '2025-12-21 22:43:38', '2025-12-21 22:43:38'),
(317, 100, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.76.21', '', '会员【na5】注销账号', '', '2025-12-21 22:54:34', '2025-12-21 22:54:34'),
(318, 96, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.76.21', '', '代理【na1】登录成功', '', '2025-12-21 22:55:05', '2025-12-21 22:55:05'),
(319, 96, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.76.21', '', '代理【na1】登录成功', '', '2025-12-22 09:33:00', '2025-12-22 09:33:00'),
(320, 96, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.76.21', '', '代理【na1】登录成功', '', '2025-12-25 22:58:23', '2025-12-25 22:58:23'),
(321, 10, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '154.222.29.236', '', '代理【na1】登录成功', '', '2025-12-29 20:55:19', '2025-12-29 20:55:19'),
(322, 10, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '163.204.68.209', '', '代理【na1】登录成功', '', '2025-12-30 09:08:32', '2025-12-30 09:08:32'),
(323, 10, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '195.86.217.208', '', '代理【na1】登录成功', '', '2025-12-30 14:42:43', '2025-12-30 14:42:43'),
(324, 22, 7, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.1 Safari/605.1.15', '115.132.25.206', '未知地区', '管理员调整【cm-111】账户余额，调整金额数1000，调整前金额0.00，调整后金额1000', '', '2025-12-31 11:01:06', '2025-12-31 11:01:06'),
(325, 25, 7, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '167.179.56.25', '未知地区', '管理员调整【25457124】账户余额，调整金额数500，调整前金额0.00，调整后金额500', '', '2026-01-02 12:49:00', '2026-01-02 12:49:00'),
(326, 25, 7, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '167.179.56.25', '', '管理员审核【25457124】充值通过充值金额3575.00', '', '2026-01-04 19:12:47', '2026-01-04 19:12:47'),
(327, 25, 7, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '167.179.56.25', '', '管理员审核【25457124】充值通过充值金额715.00', '', '2026-01-04 19:22:05', '2026-01-04 19:22:05'),
(328, 18, 7, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '167.179.56.25', '', '管理员审核【24203078】充值通过充值金额1430.00', '', '2026-01-04 19:23:27', '2026-01-04 19:23:27');

-- --------------------------------------------------------

--
-- 表的结构 `user_vip`
--

CREATE TABLE `user_vip` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vipname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '等级名称',
  `viptype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '反水类型',
  `rebate_switch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '反水开关：1 开启 0 关闭',
  `recharge` decimal(12,2) DEFAULT NULL COMMENT '升级条件：充值金额',
  `flow` decimal(12,2) DEFAULT NULL COMMENT '升级条件：流水',
  `un_flow` bigint(20) DEFAULT NULL,
  `realperson` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '真人',
  `realperson_switch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '真人反水开关：1 开启 0 关闭',
  `electron` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '电子',
  `electron_switch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '电子反水开关：1 开启 0 关闭',
  `joker` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '棋牌',
  `joker_switch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '棋牌反水开关：1 开启 0 关闭',
  `sport` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '体育',
  `sport_switch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '体育反水开关：1 开启 0 关闭',
  `fish` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '捕鱼',
  `fish_switch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '捕鱼反水开关：1 开启 0 关闭',
  `lottery` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '彩票',
  `lottery_switch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '彩票反水开关：1 开启 0 关闭',
  `e_sport` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '电竞',
  `e_sport_switch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '电竞反水开关：1 开启 0 关闭',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `exp` int(11) NOT NULL DEFAULT '0' COMMENT '经验',
  `is_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否默认',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `vrberfee` decimal(6,2) DEFAULT NULL,
  `ldfee` decimal(6,2) DEFAULT NULL,
  `vippic` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_num` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `user_vip`
--

INSERT INTO `user_vip` (`id`, `vipname`, `viptype`, `rebate_switch`, `recharge`, `flow`, `un_flow`, `realperson`, `realperson_switch`, `electron`, `electron_switch`, `joker`, `joker_switch`, `sport`, `sport_switch`, `fish`, `fish_switch`, `lottery`, `lottery_switch`, `e_sport`, `e_sport_switch`, `status`, `exp`, `is_default`, `created_at`, `updated_at`, `vrberfee`, `ldfee`, `vippic`, `cash_num`) VALUES
(1, 'VIP1', 1, 1, '0.00', '0.00', NULL, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, 1, 0, 1, '2021-04-18 15:44:39', '2025-10-18 12:22:46', NULL, NULL, 'vip-1', 0),
(3, 'VIP2', 1, 1, '0.00', '0.00', NULL, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, '0.00', 0, 1, 0, 1, '2021-04-18 15:44:39', '2025-10-18 12:23:41', NULL, NULL, 'vip-2', 0),
(4, 'VIP3', 1, 1, '0.00', '10000.00', NULL, '6.00', 1, '6.00', 1, '6.00', 1, '6.00', 1, '0.58', 1, '6.00', 1, '6.00', 1, 1, 0, 1, '2021-04-18 15:45:14', '2022-05-22 02:42:19', NULL, NULL, 'vip-3', 0),
(6, 'VIP4', 1, 1, '0.00', '50000.00', NULL, '7.00', 1, '7.00', 1, '7.00', 1, '7.00', 1, '0.58', 1, '7.00', 1, '7.00', 1, 1, 0, 0, '2022-05-09 16:36:46', '2022-05-22 02:48:11', NULL, NULL, 'vip-4', 0),
(7, 'VIP5', 1, 1, '0.00', '100000.00', NULL, '8.00', 1, '8.00', 1, '8.00', 1, '8.00', 1, '0.00', 1, '8.00', 1, '8.00', 1, 1, 0, 0, '2022-05-22 02:40:49', '2022-05-22 03:02:43', NULL, NULL, 'vip-5', 0),
(8, 'VIP6', 1, 1, '0.00', '200000.00', NULL, '9.00', 1, '9.00', 1, '9.00', 1, '9.00', 1, '0.00', 1, '9.00', 1, '9.00', 1, 1, 0, 0, '2022-05-22 02:41:22', '2022-05-22 03:02:58', NULL, NULL, 'vip-6', 0),
(9, 'VIP7', 1, 1, '0.00', '500000.00', NULL, '10.00', 1, '10.00', 1, '10.00', 1, '10.00', 1, '0.00', 1, '10.00', 1, '10.00', 1, 1, 0, 0, '2022-05-22 03:19:05', '2022-05-22 03:19:05', NULL, NULL, 'vip-7', 0),
(10, 'VIP8', 1, 1, '0.00', '1000000.00', NULL, '11.00', 1, '11.00', 1, '11.00', 1, '11.00', 1, '0.00', 1, '11.00', 1, '11.00', 1, 1, 0, 0, '2022-05-22 03:19:35', '2022-05-22 03:19:35', NULL, NULL, 'vip-8', 0),
(11, 'VIP9', 1, 1, '0.00', '5000000.00', NULL, '12.00', 1, '12.00', 1, '12.00', 1, '12.00', 1, '0.00', 1, '12.00', 1, '12.00', 1, 1, 0, 0, '2022-05-22 03:20:12', '2022-05-22 03:20:12', NULL, NULL, 'vip-9', 0),
(12, 'VIP10', 1, 1, '0.00', '10000000.00', NULL, '13.00', 1, '13.00', 1, '13.00', 1, '13.00', 1, '0.00', 1, '13.00', 1, '13.00', 1, 1, 0, 0, '2022-05-22 03:21:53', '2022-05-22 03:21:53', NULL, NULL, 'vip-10', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user_vip_log`
--

CREATE TABLE `user_vip_log` (
  `id` bigint(20) NOT NULL COMMENT '序号',
  `user_id` bigint(20) NOT NULL COMMENT '用户ID',
  `vip_id` bigint(20) NOT NULL COMMENT '等级ID',
  `降级等级ID` int(11) DEFAULT NULL COMMENT '降级等级ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '升级时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `un_at` timestamp NULL DEFAULT NULL COMMENT '降级时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='玩家会员日志表';

-- --------------------------------------------------------

--
-- 表的结构 `withdraws`
--

CREATE TABLE `withdraws` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '类型1银行卡 2usdt',
  `card_id` int(11) NOT NULL COMMENT '银行卡id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `cash_fee` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `real_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实到金额',
  `usdt_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1待审核 2通过 3拒绝',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_back` int(1) NOT NULL DEFAULT '0' COMMENT '是否返佣：1是，0否',
  `usdt_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'USDT钱包地址',
  `usdt_network` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '网络类型(TRC20/ERC20)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `withdraws`
--

INSERT INTO `withdraws` (`id`, `order_no`, `type`, `card_id`, `user_id`, `amount`, `cash_fee`, `real_money`, `usdt_rate`, `info`, `state`, `created_at`, `updated_at`, `is_back`, `usdt_address`, `usdt_network`) VALUES
(20, 'W20260104210138259001', 2, 0, 25, '1000.00', '0.00', '1000.00', '7.15', '管理员拒绝', 3, '2026-01-04 21:01:38', '2026-01-05 12:15:16', 0, 'TCporUfdnT6NBXreQJD8WzDm7fvweh8CrA', 'TRC20'),
(21, 'W20260105121720258555', 2, 0, 25, '1000.00', '0.00', '1000.00', '7.15', '管理员拒绝', 3, '2026-01-05 12:17:20', '2026-01-05 13:09:26', 0, 'TCporUfdnT6NBXreQJD8WzDm7fvweh8CrA', 'TRC20'),
(22, 'W20260105124743187296', 2, 0, 18, '50.00', '0.00', '50.00', '7.15', 'TronLink转账成功，交易哈希：9e96114cb326d46c78a40e1986409de8a355c81668ff70cdb0024a505f8edf01', 2, '2026-01-05 12:47:43', '2026-01-05 12:56:50', 0, 'TCporUfdnT6NBXreQJD8WzDm7fvweh8CrA', 'TRC20');

-- --------------------------------------------------------

--
-- 表的结构 `work_orders`
--

CREATE TABLE `work_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工单编号',
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT '用户ID',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工单标题',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工单内容',
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general' COMMENT '工单分类',
  `priority` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal' COMMENT '优先级',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT '工单状态',
  `admin_reply` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '管理员回复',
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '处理管理员ID',
  `admin_reply_time` timestamp NULL DEFAULT NULL COMMENT '管理员回复时间',
  `closed_at` timestamp NULL DEFAULT NULL COMMENT '关闭时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='工单表';

-- --------------------------------------------------------

--
-- 表的结构 `work_orders_with_users`
--

CREATE TABLE `work_orders_with_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `display_username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_realname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_reply` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_reply_time` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='工单用户关联表';

-- --------------------------------------------------------

--
-- 表的结构 `work_order_replies`
--

CREATE TABLE `work_order_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL COMMENT '工单ID',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '用户ID',
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT '管理员ID',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '回复内容',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user' COMMENT '回复类型：user/admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '软删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='工单回复表';

-- --------------------------------------------------------

--
-- 表的结构 `work_order_replies_with_users`
--

CREATE TABLE `work_order_replies_with_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='工单回复用户关联表';

--
-- 转储表的索引
--

--
-- 表的索引 `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `activity_apply`
--
ALTER TABLE `activity_apply`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `activity_types`
--
ALTER TABLE `activity_types`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `admin_extensions`
--
ALTER TABLE `admin_extensions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `admin_extensions_name_unique` (`name`) USING BTREE;

--
-- 表的索引 `admin_extension_histories`
--
ALTER TABLE `admin_extension_histories`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `admin_extension_histories_name_index` (`name`) USING BTREE;

--
-- 表的索引 `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `admin_permissions_slug_unique` (`slug`) USING BTREE;

--
-- 表的索引 `admin_permission_menu`
--
ALTER TABLE `admin_permission_menu`
  ADD UNIQUE KEY `admin_permission_menu_permission_id_menu_id_unique` (`permission_id`,`menu_id`) USING BTREE;

--
-- 表的索引 `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `admin_roles_slug_unique` (`slug`) USING BTREE;

--
-- 表的索引 `admin_role_menu`
--
ALTER TABLE `admin_role_menu`
  ADD UNIQUE KEY `admin_role_menu_role_id_menu_id_unique` (`role_id`,`menu_id`) USING BTREE;

--
-- 表的索引 `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  ADD UNIQUE KEY `admin_role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`) USING BTREE;

--
-- 表的索引 `admin_role_users`
--
ALTER TABLE `admin_role_users`
  ADD UNIQUE KEY `admin_role_users_role_id_user_id_unique` (`role_id`,`user_id`) USING BTREE;

--
-- 表的索引 `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`slug`) USING BTREE;

--
-- 表的索引 `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `admin_users_username_unique` (`username`) USING BTREE;

--
-- 表的索引 `agent_apply`
--
ALTER TABLE `agent_apply`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `agent_settlements`
--
ALTER TABLE `agent_settlements`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `apis`
--
ALTER TABLE `apis`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `articlescate`
--
ALTER TABLE `articlescate`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `code_pay`
--
ALTER TABLE `code_pay`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `gamereport`
--
ALTER TABLE `gamereport`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `game_categories`
--
ALTER TABLE `game_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `game_categories_code_unique` (`code`);

--
-- 表的索引 `game_lists`
--
ALTER TABLE `game_lists`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `game_lists_app`
--
ALTER TABLE `game_lists_app`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `game_records`
--
ALTER TABLE `game_records`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `bet_id` (`bet_id`) USING BTREE,
  ADD KEY `status` (`status`) USING BTREE,
  ADD KEY `platform_type` (`platform_type`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `username` (`username`) USING BTREE,
  ADD KEY `created_at` (`created_at`) USING BTREE,
  ADD KEY `index_updated_at_user_id` (`updated_at`,`user_id`) USING BTREE,
  ADD KEY `idx_transfer_no` (`transfer_no`),
  ADD KEY `idx_round_no` (`round_no`),
  ADD KEY `idx_player_id` (`player_id`);

--
-- 表的索引 `game_tags`
--
ALTER TABLE `game_tags`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`) USING BTREE;

--
-- 表的索引 `pay_setting`
--
ALTER TABLE `pay_setting`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `recharge`
--
ALTER TABLE `recharge`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx_tron_tx_hash` (`tron_tx_hash`(191)),
  ADD KEY `idx_tron_address` (`tron_address`(191)),
  ADD KEY `idx_tron_network` (`tron_network`);

--
-- 表的索引 `red_envelopes`
--
ALTER TABLE `red_envelopes`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- 表的索引 `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sponsors_status_sort_order_index` (`status`,`sort_order`),
  ADD KEY `idx_content_type_published` (`content_type`,`is_published`),
  ADD KEY `idx_published_at` (`published_at`);

--
-- 表的索引 `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `syslog`
--
ALTER TABLE `syslog`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `system_config`
--
ALTER TABLE `system_config`
  ADD PRIMARY KEY (`key`) USING BTREE;

--
-- 表的索引 `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `transfer_logs`
--
ALTER TABLE `transfer_logs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `order_no` (`order_no`) USING BTREE,
  ADD KEY `api_type` (`api_type`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `transfer_type` (`transfer_type`) USING BTREE,
  ADD KEY `platform_type` (`platform_type`) USING BTREE,
  ADD KEY `betid` (`betid`) USING BTREE,
  ADD KEY `created_at` (`created_at`) USING BTREE,
  ADD KEY `state` (`state`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- 表的索引 `userredpacket`
--
ALTER TABLE `userredpacket`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`) USING BTREE,
  ADD UNIQUE KEY `users_telegram_id_unique` (`telegram_id`) USING BTREE;

--
-- 表的索引 `usersmoney`
--
ALTER TABLE `usersmoney`
  ADD PRIMARY KEY (`id`,`user_id`) USING BTREE;

--
-- 表的索引 `user_api`
--
ALTER TABLE `user_api`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `user_cards`
--
ALTER TABLE `user_cards`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `user_messages`
--
ALTER TABLE `user_messages`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `user_operate_logs`
--
ALTER TABLE `user_operate_logs`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user_vip`
--
ALTER TABLE `user_vip`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `user_vip_log`
--
ALTER TABLE `user_vip_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `work_orders`
--
ALTER TABLE `work_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `work_orders_order_no_unique` (`order_no`),
  ADD KEY `work_orders_user_id_status_index` (`user_id`,`status`),
  ADD KEY `work_orders_status_priority_index` (`status`,`priority`),
  ADD KEY `work_orders_order_no_index` (`order_no`),
  ADD KEY `idx_deleted_at` (`deleted_at`);

--
-- 表的索引 `work_orders_with_users`
--
ALTER TABLE `work_orders_with_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_orders_with_users_user_id_index` (`user_id`),
  ADD KEY `work_orders_with_users_status_index` (`status`);

--
-- 表的索引 `work_order_replies`
--
ALTER TABLE `work_order_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_replies_work_order_id_index` (`work_order_id`),
  ADD KEY `work_order_replies_work_order_id_created_at_index` (`work_order_id`,`created_at`);

--
-- 表的索引 `work_order_replies_with_users`
--
ALTER TABLE `work_order_replies_with_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_replies_with_users_work_order_id_index` (`work_order_id`),
  ADD KEY `work_order_replies_with_users_user_id_index` (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `activity_apply`
--
ALTER TABLE `activity_apply`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `activity_types`
--
ALTER TABLE `activity_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `admin_extensions`
--
ALTER TABLE `admin_extensions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `admin_extension_histories`
--
ALTER TABLE `admin_extension_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- 使用表AUTO_INCREMENT `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- 使用表AUTO_INCREMENT `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `agent_apply`
--
ALTER TABLE `agent_apply`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `agent_settlements`
--
ALTER TABLE `agent_settlements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 使用表AUTO_INCREMENT `apis`
--
ALTER TABLE `apis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- 使用表AUTO_INCREMENT `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `articlescate`
--
ALTER TABLE `articlescate`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `code_pay`
--
ALTER TABLE `code_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `gamereport`
--
ALTER TABLE `gamereport`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `game_categories`
--
ALTER TABLE `game_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `game_lists`
--
ALTER TABLE `game_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=752;

--
-- 使用表AUTO_INCREMENT `game_lists_app`
--
ALTER TABLE `game_lists_app`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=737;

--
-- 使用表AUTO_INCREMENT `game_records`
--
ALTER TABLE `game_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11991;

--
-- 使用表AUTO_INCREMENT `game_tags`
--
ALTER TABLE `game_tags`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- 使用表AUTO_INCREMENT `pay_setting`
--
ALTER TABLE `pay_setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `recharge`
--
ALTER TABLE `recharge`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- 使用表AUTO_INCREMENT `red_envelopes`
--
ALTER TABLE `red_envelopes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `syslog`
--
ALTER TABLE `syslog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 使用表AUTO_INCREMENT `transfer_logs`
--
ALTER TABLE `transfer_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 使用表AUTO_INCREMENT `userredpacket`
--
ALTER TABLE `userredpacket`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- 使用表AUTO_INCREMENT `usersmoney`
--
ALTER TABLE `usersmoney`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_api`
--
ALTER TABLE `user_api`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=460;

--
-- 使用表AUTO_INCREMENT `user_cards`
--
ALTER TABLE `user_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_messages`
--
ALTER TABLE `user_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_operate_logs`
--
ALTER TABLE `user_operate_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- 使用表AUTO_INCREMENT `user_vip`
--
ALTER TABLE `user_vip`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `user_vip_log`
--
ALTER TABLE `user_vip_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '序号';

--
-- 使用表AUTO_INCREMENT `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `work_orders`
--
ALTER TABLE `work_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `work_orders_with_users`
--
ALTER TABLE `work_orders_with_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `work_order_replies`
--
ALTER TABLE `work_order_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `work_order_replies_with_users`
--
ALTER TABLE `work_order_replies_with_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
