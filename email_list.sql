-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 23-12-03 10:53
-- 서버 버전: 10.4.24-MariaDB
-- PHP 버전: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `mailing`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `email_list`
--

CREATE TABLE `email_list` (
  `list_id` int(11) NOT NULL,
  `list` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `email_list`
--

INSERT INTO `email_list` (`list_id`, `list`) VALUES
(1, 'General - Peru'),
(2, 'Test list'),
(3, 'General - Argentina'),
(4, 'General - Colombia'),
(5, 'General - Brasil'),
(6, 'General - Korea'),
(7, 'Heavy Machinery - Latin'),
(8, 'Heavy Machinery - World'),
(9, 'Heavy Machinery - Brasil');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `email_list`
--
ALTER TABLE `email_list`
  ADD PRIMARY KEY (`list_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `email_list`
--
ALTER TABLE `email_list`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
