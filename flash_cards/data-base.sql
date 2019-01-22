-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Sty 2019, 19:25
-- Wersja serwera: 10.1.31-MariaDB
-- Wersja PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `flash_cards`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sections_names`
--

CREATE TABLE `sections_names` (
  `id_section` int(11) NOT NULL,
  `section_name` varchar(30) NOT NULL,
  `general` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `sections_names`
--

INSERT INTO `sections_names` (`id_section`, `section_name`, `general`) VALUES
(1, 'podróże', 1),
(2, 'słówka 1 prywatne', 0),
(3, 'słówka 2', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `chapters_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `pass`, `chapters_max`) VALUES
(12, 'user', 'user@123.pl', '$2y$10$mJV5/1xzlN7jrYZvxw/HUOA4mCFa.sGdGMNmltTac5AdAtUQI0CQ2', 3),
(13, 'user2', 'user@1234.pl', '$2y$10$uklU5xI//za0rRRH5xSk5eoaWXEzWRv6uilb6yWzzWzTsLZDt9grG', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users_sections`
--

CREATE TABLE `users_sections` (
  `id_section` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_section_name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users_sections`
--

INSERT INTO `users_sections` (`id_section`, `id_user`, `id_section_name`) VALUES
(6, 13, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `words`
--

CREATE TABLE `words` (
  `id_word` int(11) NOT NULL,
  `word` varchar(30) NOT NULL,
  `description` varchar(30) NOT NULL,
  `section_name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `words`
--

INSERT INTO `words` (`id_word`, `word`, `description`, `section_name`) VALUES
(1, 'słówka dla każdego', 'słówka dla każdego', 1),
(2, 'słówka dla każdego', 'słówka dla każdego', 1),
(4, 'słówka dla każdego', 'słówka dla każdego', 3),
(5, 'podróże-word-1', 'podróże-description-1', 1),
(6, 'podróże-word-2', 'podróże-description-2', 1),
(7, 'podróże-word-3', 'podróże-description-3', 1),
(8, 'podróże-word-4', 'podróże-description-4', 1),
(9, 'podróże-word-5', 'podróże-description-5', 1),
(10, 'podróże-word-6', 'podróże-description-6', 1),
(11, 'podróże-word-7', 'podróże-description-7', 1),
(12, 'podróże-word-8', 'podróże-description-8', 1),
(13, 'podróże-word-9', 'podróże-description-9', 1),
(14, 'podróże-word-10', 'podróże-description-10', 1),
(15, 'podróże-word-11', 'podróże-description-11', 1),
(16, 'słówka prywatne', 'słówka prywatne', 2),
(17, 'słówka prywatne', 'słówka prywatne', 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `sections_names`
--
ALTER TABLE `sections_names`
  ADD PRIMARY KEY (`id_section`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users_sections`
--
ALTER TABLE `users_sections`
  ADD PRIMARY KEY (`id_section`),
  ADD KEY `id_user_chapter` (`id_user`),
  ADD KEY `chapter_name` (`id_section_name`);

--
-- Indeksy dla tabeli `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id_word`),
  ADD KEY `section_name` (`section_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `sections_names`
--
ALTER TABLE `sections_names`
  MODIFY `id_section` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `users_sections`
--
ALTER TABLE `users_sections`
  MODIFY `id_section` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `words`
--
ALTER TABLE `words`
  MODIFY `id_word` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `users_sections`
--
ALTER TABLE `users_sections`
  ADD CONSTRAINT `users_sections_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_sections_ibfk_2` FOREIGN KEY (`id_section_name`) REFERENCES `sections_names` (`id_section`);

--
-- Ograniczenia dla tabeli `words`
--
ALTER TABLE `words`
  ADD CONSTRAINT `words_ibfk_1` FOREIGN KEY (`section_name`) REFERENCES `sections_names` (`id_section`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
