-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 22 2022 г., 03:36
-- Версия сервера: 5.5.53
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `android_api`
--

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `id_like` int(11) NOT NULL,
  `id_music` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `music`
--

CREATE TABLE `music` (
  `id_music` int(11) NOT NULL,
  `name_music` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `path` text NOT NULL,
  `likei` int(11) NOT NULL,
  `date_music` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `music`
--

INSERT INTO `music` (`id_music`, `name_music`, `id_user`, `path`, `likei`, `date_music`) VALUES
(5, 'Джизус.mp3', 16, 'http://192.168.1.2/include/music/foldermore03', 0, '2022-09-12'),
(8, 'T-Fest.mp3', 14, 'http://192.168.1.2/include/music/foldermore02', 0, '2022-09-20'),
(9, 'InimaSalbatica.mp3', 14, 'http://192.168.1.2/include/music/foldermore02', 0, '2022-09-20');

-- --------------------------------------------------------

--
-- Структура таблицы `podpiska`
--

CREATE TABLE `podpiska` (
  `id_podpiska` int(11) NOT NULL,
  `id_user1` int(11) NOT NULL,
  `id_user2` int(11) NOT NULL,
  `data_podpiska` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `podpiska`
--

INSERT INTO `podpiska` (`id_podpiska`, `id_user1`, `id_user2`, `data_podpiska`) VALUES
(43, 12, 11, '0000-00-00'),
(44, 11, 13, '2017-05-20'),
(45, 11, 12, '2017-05-23'),
(46, 14, 12, '2022-09-06'),
(47, 14, 11, '2022-09-06'),
(48, 15, 14, '2022-09-06'),
(49, 14, 16, '2022-09-12');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(23) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `encrypted_password` varchar(80) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `folder` text NOT NULL,
  `photo` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `unique_id`, `name`, `email`, `encrypted_password`, `salt`, `created_at`, `updated_at`, `folder`, `photo`) VALUES
(11, '590738f4608730.94973994', 'Marina3', 'mbakanova@mail.ru', 'QGrj52k6RME5iBksmRmZw5ugO/o0ZjVhYjJlZDIz', '4f5ab2ed23', '2017-05-01 16:32:36', NULL, 'folderMarina3', ''),
(12, '590b275ea73a24.24733871', 'More', 'mbakanova2016@yandex.ru', 'qT6xz/3fMFdubeWvGI7SiKrseZNlNTgyNWIzODAw', 'e5825b3800', '2017-05-04 16:06:38', NULL, 'folderMore', ''),
(13, '5920964c5bce45.45330884', 'MVB', 'mb@ya.ru', 'TQdrJ4LHfOz+2aW5GV1kV52x2ukxOGI0YzY3ZjA0', '18b4c67f04', '2017-05-20 22:17:32', NULL, 'folderMVB', ''),
(14, '6317986cac6c73.83311573', 'more02', 'mbaka@yandex.ru', 'da/44h24dTLP0vEGg4TdfcFIv2M1MWE0ZmJhODlh', '51a4fba89a', '2022-09-06 21:58:52', NULL, 'foldermore02', ''),
(15, '6317a63d13c866.76489093', 'more_more', 'mba@ya.ru', 'KB5C9z9o3arO0xm11yJlgexl+mExNWFjZWEwN2Fk', '15acea07ad', '2022-09-06 22:57:49', NULL, 'foldermba@ya.ru', ''),
(16, '631f6f4b53c937.68411058', 'more03', 'mb@yandex.ru', '5ckwjyYrIHc+Fed34pKsX10AcQ1hZjdlYzlhNzAy', 'af7ec9a702', '2022-09-12 20:41:31', NULL, 'foldermore03', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `id_music` (`id_music`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`id_music`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `podpiska`
--
ALTER TABLE `podpiska`
  ADD PRIMARY KEY (`id_podpiska`),
  ADD KEY `id_user1` (`id_user1`),
  ADD KEY `id_user2` (`id_user2`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `music`
--
ALTER TABLE `music`
  MODIFY `id_music` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `podpiska`
--
ALTER TABLE `podpiska`
  MODIFY `id_podpiska` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`id_music`) REFERENCES `music` (`id_music`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `music`
--
ALTER TABLE `music`
  ADD CONSTRAINT `music_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `podpiska`
--
ALTER TABLE `podpiska`
  ADD CONSTRAINT `podpiska_ibfk_1` FOREIGN KEY (`id_user1`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `podpiska_ibfk_2` FOREIGN KEY (`id_user2`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
