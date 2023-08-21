-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Aug 2023 um 09:37
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `gr 8 - pet adoption - fullstackproject`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adoption_applications`
--

CREATE TABLE `adoption_applications` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `application_date` date DEFAULT curdate(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adoption_stories`
--

CREATE TABLE `adoption_stories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `story` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `adoption_stories`
--

INSERT INTO `adoption_stories` (`id`, `user_id`, `story`, `photo`, `timestamp`) VALUES
(2, NULL, 'Such wow! Much heartwarm! Me, Doge, was alone at shelter, but then, hooman came! Eyes met, tails wagged. Adopted! Many cuddles, treats, park runs. Hooman and Doge, bestest pals forever. Adoption, amaze! Love, much grow! Happily ever after, yasss! 🐾❤️', '64e3102078266.png', '2023-08-18 14:34:30'),
(3, NULL, 'In a bustling city, a blind pigeon named Lumi found hope in an unexpected place. A compassionate woman adopted Lumi, providing a safe haven. With patient care, Lumi navigated life through sounds and scents, inspiring everyone with resilience. In their journey together, they discovered a world illuminated by love.', '64e30fce4e602.png', '2023-08-20 19:16:26');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `timeslot` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `foster_to_adopt`
--

CREATE TABLE `foster_to_adopt` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('in_progress','completed','terminated') DEFAULT 'in_progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `species` enum('dog','cat','bird','hamster','fish','other') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `breed` varchar(100) DEFAULT 'No Breed',
  `status` enum('not adopted','adopted','pending') DEFAULT 'not adopted',
  `age` int(11) NOT NULL,
  `image` varchar(150) DEFAULT 'default.jpg',
  `size` enum('small','medium','big') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `pets`
--

INSERT INTO `pets` (`id`, `name`, `species`, `description`, `location`, `added_by`, `breed`, `status`, `age`, `image`, `size`) VALUES
(8, 'Aki', 'dog', 'Description', 'Berlin - Germany', 9, 'Akita', 'not adopted', 5, '64de54c50c9e4.jpg', 'big');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pet_matchmaker`
--

CREATE TABLE `pet_matchmaker` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `preferences` text DEFAULT NULL,
  `matched_pet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `resource_library`
--

CREATE TABLE `resource_library` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `category` enum('pet_care','training','behavior','other') DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `registration_date` date DEFAULT curdate(),
  `pictures` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `registration_date`, `pictures`, `role`) VALUES
(7, 'Adam', '6f649d6db9caef94d142e4c6de49f938ddf65cc70a0989f60d82ffff6ea148e5', 'electron.adam@proton.me', '2023-08-14', '64da39f6ae2af.png', 'admin'),
(8, 'Ada', '6f649d6db9caef94d142e4c6de49f938ddf65cc70a0989f60d82ffff6ea148e5', 'milegy@proton.me', '2023-08-14', '64dde75de1c62.png', 'user'),
(9, 'user1', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'user1@gmail.com', '2023-08-17', '64de27ec8c308.jpg', 'admin'),
(11, 'lorenz', '0869a908426ef0462e864c8cd0fa9bf2e81a51e3b65c26ed2137b165fa325056', 'bozo@bozo.com', '2023-08-17', '64de66892d70b.jpg', 'user');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `adoption_stories`
--
ALTER TABLE `adoption_stories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `foster_to_adopt`
--
ALTER TABLE `foster_to_adopt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indizes für die Tabelle `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indizes für die Tabelle `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indizes für die Tabelle `pet_matchmaker`
--
ALTER TABLE `pet_matchmaker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `matched_pet_id` (`matched_pet_id`);

--
-- Indizes für die Tabelle `resource_library`
--
ALTER TABLE `resource_library`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `adoption_applications`
--
ALTER TABLE `adoption_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `adoption_stories`
--
ALTER TABLE `adoption_stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `foster_to_adopt`
--
ALTER TABLE `foster_to_adopt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `pet_matchmaker`
--
ALTER TABLE `pet_matchmaker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `resource_library`
--
ALTER TABLE `resource_library`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD CONSTRAINT `adoption_applications_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`),
  ADD CONSTRAINT `adoption_applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `adoption_stories`
--
ALTER TABLE `adoption_stories`
  ADD CONSTRAINT `adoption_stories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `foster_to_adopt`
--
ALTER TABLE `foster_to_adopt`
  ADD CONSTRAINT `foster_to_adopt_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `foster_to_adopt_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`);

--
-- Constraints der Tabelle `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `pet_matchmaker`
--
ALTER TABLE `pet_matchmaker`
  ADD CONSTRAINT `pet_matchmaker_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pet_matchmaker_ibfk_2` FOREIGN KEY (`matched_pet_id`) REFERENCES `pets` (`id`);

--
-- Constraints der Tabelle `resource_library`
--
ALTER TABLE `resource_library`
  ADD CONSTRAINT `resource_library_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
