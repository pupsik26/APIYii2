-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 30 2022 г., 20:39
-- Версия сервера: 10.4.22-MariaDB
-- Версия PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `project`
--

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Купить маски для персонала', 1, '2022-05-25 21:00:00', '2022-05-25 21:00:00'),
(4, 'Обновить систему компов в 304 кабинете', 0, '2022-05-25 21:00:00', '2022-05-25 21:00:00'),
(5, 'В 127 кабинете виснет программа 1С(=)), прошу разобраться!', 1, '2022-05-25 21:00:00', '2022-05-25 21:00:00'),
(6, 'Вывоз мусора. Подписать контракт с компанией на вывоз мусора', 1, '2022-05-25 21:00:00', '2022-05-25 21:00:00'),
(7, 'Тест изменения времени', 1, '2022-05-25 21:00:00', '2022-05-25 21:00:00'),
(13, 'Еще одно задание', 0, '2022-05-26 19:07:49', '2022-05-26 19:07:49'),
(62, 'new comment', 0, '2022-05-29 22:29:14', '2022-05-29 22:29:14'),
(63, 'new comment', 0, '2022-05-29 23:12:37', '2022-05-29 23:12:37'),
(64, 'new comment', 0, '2022-05-29 23:13:50', '2022-05-29 23:13:50'),
(65, 'new comment', 0, '2022-05-29 23:22:36', '2022-05-29 23:22:36');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `created_at`, `updated_at`) VALUES
(2, 'vadim.kazakov26', 'vadim.kazakov26@yandex.ru', '2022-05-25', '2022-05-25'),
(3, 'Петька программист', 'petya.prograammist@lol.com', '2022-05-26', '2022-05-26'),
(10, 'newUser', 'rr@mail.ru', '2022-05-29', '2022-05-29'),
(12, 'newUser_1', 'rrr@mail.ru', '2022-05-30', '2022-05-30'),
(15, 'newUser_2', 'rrrrr@mail.ru', '2022-05-30', '2022-05-30'),
(16, 'newUser_3', 'rrrrrr@mail.ru', '2022-05-30', '2022-05-30'),
(17, 'newUser_555', 'test@mail.ru', '2022-05-30', '2022-05-30');

-- --------------------------------------------------------

--
-- Структура таблицы `user_message`
--

CREATE TABLE `user_message` (
  `id` int(11) NOT NULL,
  `id_message` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `user_message`
--

INSERT INTO `user_message` (`id`, `id_message`, `id_user`, `created_at`, `updated_at`) VALUES
(11, 62, 16, '2022-05-30', '2022-05-30'),
(12, 63, 17, '2022-05-30', '2022-05-30'),
(13, 64, 17, '2022-05-30', '2022-05-30'),
(14, 65, 16, '2022-05-30', '2022-05-30'),
(15, 7, 3, '2022-05-30', '2022-05-30'),
(16, 5, 2, '2022-05-30', '2022-05-30');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_message`
--
ALTER TABLE `user_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_messages_message_id_fk` (`id_message`),
  ADD KEY `user_messages_user_id_fk` (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `user_message`
--
ALTER TABLE `user_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `user_message`
--
ALTER TABLE `user_message`
  ADD CONSTRAINT `user_messages_message_id_fk` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_messages_user_id_fk` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
