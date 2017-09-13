-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-09-13 09:13:19
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api`
--

-- --------------------------------------------------------

--
-- 表的结构 `api_app`
--

CREATE TABLE `api_app` (
  `aid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `data` varchar(2000) NOT NULL,
  `create_time` varchar(11) NOT NULL,
  `update_time` varchar(11) NOT NULL,
  `appkey` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据表';

--
-- 转存表中的数据 `api_app`
--

INSERT INTO `api_app` (`aid`, `uid`, `name`, `data`, `create_time`, `update_time`, `appkey`) VALUES
(15, 1, '卢本伟牛逼', '{\\"name\\":\\"卢本伟\\",\\"version\\":\\"1.0\\",\\"download\\":\\"http://api.pixelgm.com\\",\\"site\\":\\"http://api.pixelgm.com\\"}', '1505291180', '1505291180', '93h2JCnfEFdfMlj1');

-- --------------------------------------------------------

--
-- 表的结构 `api_user`
--

CREATE TABLE `api_user` (
  `uid` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(120) NOT NULL,
  `status` int(10) NOT NULL,
  `email` varchar(20) NOT NULL,
  `create_time` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `api_user`
--

INSERT INTO `api_user` (`uid`, `name`, `password`, `status`, `email`, `create_time`) VALUES
(1, 'admin', 'd93a5def7511da3d0f2d171d9c344e91', 1, 'admin@admin.com', '1505131486');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_app`
--
ALTER TABLE `api_app`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `api_user`
--
ALTER TABLE `api_user`
  ADD PRIMARY KEY (`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `api_app`
--
ALTER TABLE `api_app`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- 使用表AUTO_INCREMENT `api_user`
--
ALTER TABLE `api_user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
