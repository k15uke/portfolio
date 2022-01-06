-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022 年 1 月 04 日 00:58
-- サーバのバージョン： 5.7.34
-- PHP のバージョン: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `todo`
--
CREATE DATABASE IF NOT EXISTS `todo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `todo`;

-- --------------------------------------------------------

--
-- テーブルの構造 `todo`
--

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `finished_date` date DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `family_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `user`, `pass`, `family_name`, `first_name`, `is_admin`, `is_deleted`, `create_date_time`, `update_date_time`) VALUES
(1, 'test1', '$2y$10$eSePpwz2hteTQZNXO1BvFeI.VCSGF/YqGdpZda/sHQDQWzAJoehYi', 'テスト', '花子', 0, 0, '2021-12-04 11:58:31', '2021-12-04 11:58:31'),
(2, 'test2', '$2y$10$btIzYtozzeEJ2J53ZU/Qz.YBK61RilXtGcVJkrZfz1r/fS8R72F.i', 'テスト', '太郎', 0, 0, '2021-12-04 11:58:31', '2021-12-04 11:58:31');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- データベース: `urattei`
--
CREATE DATABASE IF NOT EXISTS `urattei` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `urattei`;

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `text` varchar(512) NOT NULL,
  `likes` int(11) DEFAULT '0',
  `dislikes` int(11) DEFAULT '0',
  `posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `photo` int(11) DEFAULT '0',
  `is_deleted` int(11) DEFAULT '0',
  `edit_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `name`, `text`, `likes`, `dislikes`, `posted`, `photo`, `is_deleted`, `edit_date`) VALUES
(42, 5, 'test', '絵fcえqfcqrwれゔぁ', 1, 5, '2021-12-28 05:24:52', NULL, NULL, '2021-12-28 05:24:52'),
(46, 5, 'test', '絵rffれ', 2, 5, '2021-12-28 05:35:00', 0, 0, '2021-12-28 05:35:00'),
(47, 5, 'test', 'fe', 7, 4, '2021-12-28 05:40:19', 0, 0, '2021-12-28 05:40:19');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(254) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(256) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `posts` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `create_date`, `posts`) VALUES
(5, 'test', '1', '$2y$10$OoxeUZcJscGisBNzvfXG8OLqFQsyqpbZZVOav4ENUdcMag9Xt8KyO', '2021-12-28 05:52:24', 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
