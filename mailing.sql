-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 23-11-30 14:51
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
-- 테이블 구조 `sender`
--

CREATE TABLE `sender` (
  `sender_id` int(11) NOT NULL,
  `protocol` varchar(10) NOT NULL,
  `smtp_crypto` varchar(10) NOT NULL,
  `smtp_host` varchar(200) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `smtp_user` varchar(200) NOT NULL,
  `smtp_pass` varchar(200) NOT NULL,
  `registed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `sender`
--

INSERT INTO `sender` (`sender_id`, `protocol`, `smtp_crypto`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `registed_at`) VALUES
(1, 'smtp', 'ssl', 'jweverlyn.com', 465, 'contacto@jweverlyn.com', 'wjddn0915!', '2023-11-30 16:55:47');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `sender`
--
ALTER TABLE `sender`
  ADD PRIMARY KEY (`sender_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `sender`
--
ALTER TABLE `sender`
  MODIFY `sender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
