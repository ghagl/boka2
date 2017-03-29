--
-- Stockholms universitet
-- DSV
--
-- @dsvauthor Gustaf Haglund <ghaglund@dsv.su.se>
-- <Please contact Erik Thuning instead.>
--
-- Copyright (C) 2017 The Stockholm University
--
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU Affero General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU Affero General Public License for more details.
--
-- You should have received a copy of the GNU Affero General Public License
-- along with this program.  If not, see <http://www.gnu.org/licenses/>.
--

SET NAMES utf8;
SET time_zone = '+00:00';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `administrators`;
CREATE TABLE `administrators` (
  `uid` varchar(100) COLLATE utf8mb4_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;


DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `image` varchar(200) COLLATE utf8mb4_swedish_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_swedish_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;


DROP TABLE IF EXISTS `loans`;
CREATE TABLE `loans` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(255) NOT NULL,
  `loaner_email` varchar(500) COLLATE utf8mb4_swedish_ci NOT NULL,
  `time` datetime NOT NULL,
  `totime` datetime NOT NULL,
  `returned` varchar(5) COLLATE utf8mb4_swedish_ci NOT NULL DEFAULT 'false',
  `ex` bigint(255) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;


DROP TABLE IF EXISTS `objects`;
CREATE TABLE `objects` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) COLLATE utf8mb4_swedish_ci NOT NULL,
  `information` varchar(150) COLLATE utf8mb4_swedish_ci NOT NULL,
  `category_id` bigint(255) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `ex` bigint(255) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=644 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;


-- 2017-03-26 20:09:25
