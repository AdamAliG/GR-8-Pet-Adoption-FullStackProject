-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 23. Aug 2023 um 10:36
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.0.28

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
CREATE DATABASE IF NOT EXISTS `gr 8 - pet adoption - fullstackproject` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gr 8 - pet adoption - fullstackproject`;

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
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `status_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `adoption_applications`
--

INSERT INTO `adoption_applications` (`id`, `pet_id`, `user_id`, `details`, `application_date`, `status`, `status_date`) VALUES
(3, 8, 10, NULL, '2023-01-10', 'pending', '2023-01-10'),
(4, 9, 11, NULL, '2023-08-21', 'pending', '2023-08-21');

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
(4, NULL, 'In a cozy pet store, a timid guinea pig named Coco awaited a loving home. Emma, a kind-hearted girl, visited one day and their eyes met. A bond formed instantly. Through gentle care and shared veggies, Cocos world transformed. Emmas family grew by a furry bundle, filling their lives with joyous squeaks.', '64e5e7d22b93f.png', '2023-08-23 13:04:50'),
(5, NULL, 'Amidst rolling hills, a charming Highland cow named Hamish roamed with a wistful gaze. Lily, a nature enthusiast, felt an instant connection. She adopted Hamish, turning her backyard into his haven. Their days were filled with serene moments, and Hamishs presence brought countryside magic to Lilys life.', '64e5e8452a520.png', '2023-08-23 13:06:45'),
(7, NULL, 'In a bustling city, a blind pigeon named Piper radiated resilience. Maya, a compassionate soul, discovered Pipers unique beauty. Through patient gestures, trust blossomed. Maya became Pipers eyes, and their extraordinary bond inspired all around. In each flight, they found freedom and a shared journey of the heart.', '64e5e8d61b79a.png', '2023-08-23 13:09:10'),
(8, NULL, 'In a riverside haven, a vibrant kingfisher named Kip flitted about with mischievous flair. Mia, an avid bird watcher, admired Kips antics. Upon adopting him, her days gained a burst of color. Kips playful dives and vivid plumage made every moment enchanting, turning Mias world into a lively wonderland.', '64e5f0fcc68bb.png', '2023-08-23 13:14:00'),
(9, NULL, 'In a calm shelter, a relaxed kitten named Zen patiently awaited a companion. Alex, seeking tranquility, found Zens soothing presence irresistible. From that moment, their lives intertwined. Lazy afternoons and content purrs filled their shared space, creating a haven of serenity that brought smiles to both.', '64e5eac6b8e5f.png', '2023-08-23 13:17:26'),
(10, NULL, 'In a tranquil garden, a curious hedgehog named Hazel rolled into Lilys life. Nocturnal explorations and cozy snuggles formed an unbreakable bond. Lilys world lit up with prickly charm, as Hazels spiky exterior gave way to a heartwarming friendship, proving that even the shyest creatures can find a forever home.', '64e5eb02984aa.png', '2023-08-23 13:18:26'),
(11, NULL, 'In a quiet neighborhood, a curious Dachshund named Oscar wagged his way into Leos heart. His inquisitive nature led to hilarious escapades. Leos patient love tamed his antics, turning everyday walks into delightful explorations. Oscars wagging tail and snoopy charm made every moment a joyful adventure.', '64e5ebba6781c.png', '2023-08-23 13:21:30'),
(12, NULL, 'In a tranquil forest, a drowsy fox named Finn found solace under a moonlit sky. Ethan, a patient wanderer, stumbled upon him. Drawn to Finns peaceful aura, Ethan offered a haven. Together, they embraced quiet nights, forming an unbreakable bond that turned the forests serenity into their shared haven.', '64e5ec16b5e07.png', '2023-08-23 13:23:02'),
(13, NULL, 'In a tranquil farm, a timid yellow chick named Sunny sought companionship. The Johnson family arrived, and Lily, their daughter, instantly connected with Sunny. Patiently, they nurtured trust, sharing seeds and secrets. With each passing day, Sunnys feathers brightened, and Lily found a forever friend in their quiet moments.', '64e5ee4297505.png', '2023-08-23 13:30:32');

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
  `status` enum('in_progress','completed','cancelled') DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `foster_to_adopt`
--

INSERT INTO `foster_to_adopt` (`id`, `user_id`, `pet_id`, `start_date`, `end_date`, `status`, `description`) VALUES
(1, 10, 8, '2023-08-24', '2023-09-06', 'in_progress', 'Description'),
(6, 11, 9, '2023-08-24', '2023-08-31', 'in_progress', 'Descrition');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `read_flag` enum('false','true') NOT NULL DEFAULT 'false',
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `content`, `read_flag`, `timestamp`) VALUES
(2, 9, 11, '<a href=\'pet_crud/details.php?id=9\'>Cesar</a> is in Fost-to-Adopt process by you! have a great time with eachother!', 'true', '2023-08-21 13:02:17'),
(3, 16, 10, 'hello', 'false', '2023-08-23 05:38:10'),
(4, 16, 10, 'how are you', 'false', '2023-08-23 05:51:48'),
(5, 16, 17, 'hello', 'false', '2023-08-23 06:11:48'),
(6, 17, 16, 'hey', 'false', '2023-08-23 06:52:18');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `species` enum('dog','cat','bird','hamster','fish') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `breed` varchar(100) DEFAULT 'No Breed',
  `status` enum('not adopted','adopted','pending') DEFAULT 'not adopted',
  `age` int(11) NOT NULL,
  `image` varchar(150) DEFAULT 'avatar.jpg',
  `size` enum('small','medium','big') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `pets`
--

INSERT INTO `pets` (`id`, `name`, `species`, `description`, `location`, `added_by`, `breed`, `status`, `age`, `image`, `size`) VALUES
(8, 'Aki', 'dog', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 'Austria -Vienna', 9, 'Akita', 'not adopted', 7, 'avatar.jpg', 'big'),
(9, 'Cesar', 'dog', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 'Graz - Austria', 9, 'Shepherd', 'not adopted', 4, 'avatar.jpg', 'medium');

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
  `role` enum('user','admin') DEFAULT 'user',
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `user_type` enum('individual','shelter','agency') DEFAULT 'individual'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `registration_date`, `pictures`, `role`, `is_approved`, `user_type`) VALUES
(9, 'user1', '$2y$10$.z0JnHxzMeBehrYUVQg0ROFUSYJK4I8wm6xU2s3XDsO12ikwNm34y', 'user1@gmail.com', '2023-08-01', '64de27ec8c308.jpg', 'admin', 0, 'individual'),
(10, 'user2', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'user2@gmail.com', '0000-00-00', '64df2ae2ab09e.jpg', 'user', 0, 'individual'),
(11, 'user3', '$2y$10$.z0JnHxzMeBehrYUVQg0ROFUSYJK4I8wm6xU2s3XDsO12ikwNm34y', 'user@gmail.com', '2023-08-21', '64e32a0db95f4.jpg', 'user', 0, 'individual'),
(13, 'Adam', '$2y$10$e2zQtLbKhvqE1foDcbD80OybewFdR35lxb6vaIMesuuMkcv3Zxr/y', 'electron.adam@proton.me', '2023-08-22', '64e4a31bc594f.png', 'admin', 0, 'individual'),
(16, 'User1', '$2y$10$2PeWnz4PPOoC3C/ZOj3IouinSDGLO2nd2YcwwSFSLkYnUE4RVqdB2', 'email@email.com', '2023-08-23', '64e544fa62c34.png', 'user', 1, ''),
(17, 'User2', '$2y$10$699D.0w8eQJYa643QUrXguetzOYx7.tKTxnyOQ6rwvFfXYUOvVsVu', 'email@email2.com', '2023-08-23', '64e545206d9e2.png', 'user', 1, 'shelter');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `adoption_stories`
--
ALTER TABLE `adoption_stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `foster_to_adopt`
--
ALTER TABLE `foster_to_adopt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD CONSTRAINT `adoption_applications_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adoption_applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
