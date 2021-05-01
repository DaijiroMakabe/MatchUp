-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 01, 2021 at 08:01 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `matchup`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `unique_id` int(32) NOT NULL,
  `my_user_id` int(32) DEFAULT NULL COMMENT 'ユーザーID',
  `friend_id` int(32) DEFAULT NULL COMMENT '友達ID',
  `friendship_status` int(32) DEFAULT '0' COMMENT '承認ステータス'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`unique_id`, `my_user_id`, `friend_id`, `friendship_status`) VALUES
(74, 22, 19, 2),
(78, 19, 22, 2),
(80, 22, 25, 2),
(81, 25, 22, 2),
(84, 27, 17, 1),
(88, 18, 17, 1),
(89, 22, 18, 2),
(91, 27, 18, 2),
(92, 18, 27, 2),
(93, 28, 22, 2),
(94, 22, 28, 2),
(95, 22, 23, 1),
(96, 18, 22, 2),
(97, 22, 29, 2),
(98, 29, 22, 2),
(99, 29, 18, 2),
(100, 18, 29, 2),
(101, 22, 30, 1),
(102, 22, 17, 1),
(103, 25, 30, 2),
(104, 30, 25, 2),
(105, 25, 18, 2),
(106, 18, 25, 2);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(32) NOT NULL COMMENT 'ID',
  `incoming_msg_id` int(255) DEFAULT NULL COMMENT '受信',
  `outgoing_msg_id` int(255) DEFAULT NULL COMMENT '送信',
  `msg` varchar(1000) DEFAULT NULL COMMENT 'メッセージ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`) VALUES
(36, 25, 22, '初めまして'),
(37, 25, 22, 'こんにちは'),
(38, 25, 22, 'ハロー'),
(39, 22, 25, '初めまして'),
(40, 22, 25, '試合しましょう'),
(41, 25, 22, 'そうですね　試合しましょう'),
(42, 25, 22, '何時がいいですか？'),
(43, 22, 25, '16時からでお願い致します'),
(44, 22, 25, NULL),
(45, NULL, NULL, NULL),
(46, 25, 22, 'aaaa'),
(47, 25, 22, 'よろしくお願い致します'),
(48, 18, 22, 'こんにちは'),
(49, 18, 22, '初めまして'),
(50, 22, 18, '初めまして'),
(51, 22, 18, 'よろしくお願い致します'),
(52, 22, 29, 'こんにちは'),
(53, 22, 29, '初めまして'),
(54, 29, 22, 'こんにちは'),
(55, 29, 22, '試合しましょう'),
(56, 22, 29, 'よろしくお願い致します'),
(57, 18, 29, 'こんにちは'),
(58, 18, 29, '試合しましょう'),
(59, 25, 18, '初めまして'),
(60, 25, 18, 'こんにちは'),
(61, 18, 25, '初めまして'),
(62, 18, 25, '試合しましょう'),
(63, 25, 18, '何時が良いですか？'),
(64, 22, 29, 'ハロー'),
(65, 29, 18, 'こんにちは');

-- --------------------------------------------------------

--
-- Table structure for table `pwdReset`
--

CREATE TABLE `pwdReset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pwdReset`
--

INSERT INTO `pwdReset` (`pwdResetId`, `pwdResetEmail`, `pwdResetSelector`, `pwdResetToken`, `pwdResetExpires`) VALUES
(52, 'daijirou.makabe@gmail.com', 'b04c3b3645cc266c', '$2y$10$Kyg3tgc8jQnS25LjgVAFsuN3WFZdrfQY1ypAqMYGdomuFsnydwZdW', '1619132259');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `unique_id` int(32) NOT NULL COMMENT 'ID',
  `date` date NOT NULL,
  `my_user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `enemy_user_id` int(32) NOT NULL COMMENT '敵ユーザーID',
  `my_goals` int(32) NOT NULL DEFAULT '0' COMMENT 'ユーザーゴール',
  `enemy_goals` int(32) NOT NULL DEFAULT '0' COMMENT '敵ゴール',
  `result` char(32) NOT NULL COMMENT '結果'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`unique_id`, `date`, `my_user_id`, `enemy_user_id`, `my_goals`, `enemy_goals`, `result`) VALUES
(1, '2021-04-25', 22, 18, 2, 1, '勝利'),
(2, '2021-04-30', 22, 19, 3, 1, '勝利'),
(3, '2021-05-04', 22, 19, 0, 2, '敗北'),
(4, '2021-04-25', 22, 18, 2, 1, '勝利'),
(5, '2021-05-15', 25, 22, 3, 1, '勝利'),
(6, '2021-05-15', 29, 22, 2, 1, '勝利'),
(7, '2021-05-10', 22, 28, 3, 5, '敗北'),
(8, '2021-05-15', 25, 30, 3, 1, '勝利'),
(9, '2021-05-22', 18, 25, 3, 1, '勝利'),
(10, '2021-05-01', 18, 29, 1, 2, '敗北');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `unique_id` int(32) NOT NULL COMMENT 'ID',
  `date` date NOT NULL COMMENT '日付',
  `my_user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `enemy_user_id` int(32) NOT NULL COMMENT '敵ユーザーID',
  `start_time` char(32) NOT NULL COMMENT '開始時間',
  `end_time` char(32) NOT NULL COMMENT '終了時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`unique_id`, `date`, `my_user_id`, `enemy_user_id`, `start_time`, `end_time`) VALUES
(2, '2021-04-30', 22, 19, '09:00', '12:00'),
(3, '2021-05-30', 22, 18, '10:30', '12:00'),
(9, '2021-05-15', 29, 22, '13:00', '14:00'),
(10, '2021-05-17', 18, 22, '14:00', '17:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `team_name` char(255) NOT NULL COMMENT 'チームネーム',
  `user_name` char(255) NOT NULL COMMENT '監督者ネーム',
  `image` char(255) NOT NULL COMMENT 'チームイメージ',
  `mail` char(255) NOT NULL COMMENT 'メールアドレス',
  `password` char(255) NOT NULL COMMENT 'パスワード',
  `region` char(255) NOT NULL COMMENT '地域',
  `age` char(255) NOT NULL COMMENT '年代',
  `category` char(255) NOT NULL COMMENT '種目',
  `match_up_flg` char(32) NOT NULL DEFAULT '0' COMMENT 'ステータス',
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '役割'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `team_name`, `user_name`, `image`, `mail`, `password`, `region`, `age`, `category`, `match_up_flg`, `role`) VALUES
(17, '埼玉FC', '鈴木一郎', 'img/20210410093546taro.png', 'test@gmail.com', '$2y$10$mcBLHsMVETipm2yBVkv1h.5BNe3mhTGLRcdpxf07kUv.vluIp.9Vi', '草加市', '小学校低学年', 'サッカー', '0', 1),
(18, '草加FC', '鈴木二郎', 'img/20210409081635taro.png', 'test2@gmail.com', '$2y$10$fhnI3EYXgmagay89ANlRYupLFpYGS3Upaz/FkHtLlY0GhsJ.ORkqe', '草加市', '小学校低学年', 'サッカー', '1', 1),
(19, '草加ドラゴンズ', '野球吾郎', 'img/20210409082237member1.png', 'test3@gmail.com', '$2y$10$2BSU5jqVt8XmJ2cF4xkSueCug5l66AnM1.5Oa4yZ7Ib/ffQKbdI.y', '草加市', '小学校低学年', '野球', '0', 1),
(20, '草加バスケットボールクラブ', '鈴木四郎', 'img/20210409082442member2.png', 'test5@gmail.com', '$2y$10$G7TP7NQ.6HlaJTMOru5ztedscbAveEb0vj5uc3PEBx.35mGQWoRRK', '草加市', '小学校低学年', 'バスケットボール', '0', 1),
(21, '松原キッカーズ', '田中太郎', 'img/20210411151008member1.png', 'test8@gmail.com', '$2y$10$gON3A0M3TCtqYyPexqHJlOpiGHm1MWxB6kXXbMGO6PW.UWYI4tZ1S', '草加市', '小学校中学年', '野球', '0', 1),
(22, '羽生FC', '田中二郎', 'img/20210427224801member2.png', 'test9@gmail.com', '$2y$10$iZslqdqlp1.Ae1sTbKg5Juv14/NAx1hVZmYyM0FXMdJTDyZAdaYyO', '三郷市', '小学校低学年', 'サッカー', '1', 1),
(23, '新田ミニバス', '佐藤一郎', 'img/20210411152608member2.png', 'test10@gmail.com', '$2y$10$s.BdI7Ipm1d5FDwBzEI0luWQGw1rJeIFRVWKV0/35U1B0wtmhMbwq', '草加市', '小学校高学年', 'バスケットボール', '0', 1),
(25, '三郷FC', '田中四郎', 'img/20210413080459member3.png', 'test13@gmail.com', '$2y$10$IUaBM2rz9rshX07JB18yJuhbvbKjicO.ag3khQRPzEOXu7CV9VEOi', '草加市', '小学校低学年', 'サッカー', '1', 1),
(26, '桶川FC', 'テスト太郎', 'img/20210417133306member2.png', 'test13@gmail.com', '$2y$10$LRu0mKH/w5LP6nJYB7cUqemlkwuXUn0h0l/ksrCfirpBkFoIWLOoG', '桶川市', '小学校中学年', 'サッカー', '0', 0),
(28, 'テストチーム', 'テスト二郎', 'img/20210424171054member1.png', 'test14@gmail.com', '$2y$10$xS75mCyRN6jTjw99HWVHIOCdKRYPL08InFX7M6YL1oq.7zW6rQnIW', '桶川市', '小学校低学年', 'サッカー', '1', 1),
(29, '秩父FC', 'テスト吾郎', 'img/20210425165912member1.png', 'test20@gmail.com', '$2y$10$RXkQuzCCmfaRoxGEOMJQUuqSOaBzxb2jmfny7fZkJQKt.083liKqq', '秩父市', '小学校中学年', 'サッカー', '1', 1),
(30, 'テストFC', 'テストテスト', 'img/20210425170132member3.png', 'test21@gmail.com', '$2y$10$hTyOjmhTVmCqSjkIeb9BUOKw93hVUOrq0YZTjokY32WAC5POnANga', '草加市', '小学校低学年', 'サッカー', '0', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`unique_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `pwdReset`
--
ALTER TABLE `pwdReset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`unique_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`unique_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `unique_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `pwdReset`
--
ALTER TABLE `pwdReset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `unique_id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `unique_id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=31;