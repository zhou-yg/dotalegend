-- phpMyAdmin SQL Dump
-- version 3.3.10
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2014 年 09 月 08 日 14:33
-- 服务器版本: 5.1.56
-- PHP 版本: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `dotalegend`
--

-- --------------------------------------------------------

--
-- 表的结构 `upgrade`
--

CREATE TABLE IF NOT EXISTS `upgrade` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `heroId` int(4) DEFAULT NULL,
  `blue` varchar(256) DEFAULT NULL,
  `blue1` varchar(256) DEFAULT NULL,
  `blue2` varchar(256) DEFAULT NULL,
  `purple` varchar(256) DEFAULT NULL,
  `purple1` varchar(256) DEFAULT NULL,
  `purple2` varchar(256) DEFAULT NULL,
  `purple3` varchar(256) DEFAULT NULL,
  `purple4` varchar(256) DEFAULT NULL,
  `orange` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `upgrade`
--

