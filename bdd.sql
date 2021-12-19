CREATE TABLE `BATIMENT` (
  `playerId` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `standardProduction` float NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `RESSOURCES` (
  `playerId` int(11) NOT NULL,
  `bois` bigint(20) NOT NULL,
  `pierre` bigint(20) NOT NULL,
  `nourriture` bigint(20) NOT NULL,
  `villageois` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `USER` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastTimeOnline` timestamp NOT NULL DEFAULT current_timestamp(),
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



ALTER TABLE `RESSOURCES`
  ADD PRIMARY KEY (`playerId`);

ALTER TABLE `USER`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `USER`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `BATIMENT`
  ADD CONSTRAINT `lockPlayerId` FOREIGN KEY (`playerId`) REFERENCES `USER` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `RESSOURCES`
  ADD CONSTRAINT `assignToPlayer` FOREIGN KEY (`playerId`) REFERENCES `USER` (`id`);

CREATE TRIGGER `createAccount` AFTER INSERT ON `USER`
 FOR EACH ROW INSERT INTO RESSOURCES(`playerId`, `bois`, `pierre`, `nourriture`, `villageois`) VALUES(new.id, 500, 500, 500, 50)