-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-02-18 12:54
-- 서버 버전: 10.4.32-MariaDB
-- PHP 버전: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `recipe`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `comment`
--

CREATE TABLE `comment` (
  `idx` int(11) NOT NULL,
  `comment_type` varchar(40) NOT NULL,
  `parent_idx` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `write_date` datetime NOT NULL,
  `writer_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `cooktip`
--

CREATE TABLE `cooktip` (
  `idx` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `writer_id` varchar(60) NOT NULL,
  `write_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `member`
--

CREATE TABLE `member` (
  `idx` int(11) NOT NULL,
  `user_id` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_image` varchar(200) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `join_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `member`
--

INSERT INTO `member` (`idx`, `user_id`, `password`, `user_name`, `user_image`, `email`, `join_date`) VALUES
(5, 'test1234', '*EF4B25DE463D6C8E8BE07C2506E3BBFECF200D4B', '테스트', '5_65d1bc0524af5_1708243973_0jq911698380030.jpg', 'wqdqwdqwd@dqwd', '2024-02-15 22:39:51'),
(6, 'a001', '*8D27D012AF0E2414F871C4D879BC6DD97194FC66', 'ㅇㄴㅇㄴ', '', 'aaa@naver.com', '2024-02-18 19:12:17');

-- --------------------------------------------------------

--
-- 테이블 구조 `recipe`
--

CREATE TABLE `recipe` (
  `idx` int(11) NOT NULL,
  `recipe_name` varchar(150) NOT NULL,
  `recipe_youtube` text NOT NULL,
  `recipe_text` text NOT NULL,
  `recipe_image` varchar(150) NOT NULL,
  `writer_id` varchar(60) NOT NULL,
  `write_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `recipe_grade`
--

CREATE TABLE `recipe_grade` (
  `grade` int(11) NOT NULL,
  `recipe_idx` int(11) NOT NULL,
  `user_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `recipe_scrap`
--

CREATE TABLE `recipe_scrap` (
  `idx` int(11) NOT NULL,
  `recipe_idx` int(11) NOT NULL,
  `user_id` varchar(60) NOT NULL,
  `scrap_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `cooktip`
--
ALTER TABLE `cooktip`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `recipe_grade`
--
ALTER TABLE `recipe_grade`
  ADD PRIMARY KEY (`user_id`,`recipe_idx`);

--
-- 테이블의 인덱스 `recipe_scrap`
--
ALTER TABLE `recipe_scrap`
  ADD PRIMARY KEY (`idx`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `cooktip`
--
ALTER TABLE `cooktip`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 테이블의 AUTO_INCREMENT `recipe`
--
ALTER TABLE `recipe`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 테이블의 AUTO_INCREMENT `recipe_scrap`
--
ALTER TABLE `recipe_scrap`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
