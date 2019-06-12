/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : weibo

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 12/06/2019 16:49:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for followers
-- ----------------------------
DROP TABLE IF EXISTS `followers`;
CREATE TABLE `followers`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `follower_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `follower_id`(`follower_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of followers
-- ----------------------------
INSERT INTO `followers` VALUES (8, 1, 2, NULL, NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for statuses
-- ----------------------------
DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of statuses
-- ----------------------------
INSERT INTO `statuses` VALUES (1, '这是第一条微博', 1, '2019-06-11 06:00:50', '2019-06-11 06:00:50');
INSERT INTO `statuses` VALUES (14, 'fdsafdsafdsa', 1, '2019-06-12 02:19:25', '2019-06-12 02:19:25');
INSERT INTO `statuses` VALUES (18, '魂牵梦萦=魂牵梦萦=魂牵梦萦=\r\n魂牵梦萦=', 2, '2019-06-12 06:07:18', '2019-06-12 06:07:18');
INSERT INTO `statuses` VALUES (11, '这是第一条微博这是第一条微博这是第一条微博这是第一条微博这是第一条微博这是第一条微博这是第一条微博这是第一条微博这是第一条微博', 1, '2019-06-11 09:12:28', '2019-06-11 09:12:28');
INSERT INTO `statuses` VALUES (12, '范德萨范德萨', 1, '2019-06-12 01:44:13', '2019-06-12 01:44:13');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `activation_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'huocs', 'huo8008@126.com', NULL, '$2y$10$8JcuUmI.4xUsWmx62zzG3uP/7przGQAvFvozI9ACFbwrwQVpQH66C', 'djf7aTdiVedfEJcw5GGFo7qSr8SYYiltx7lA1ORD5ssuyojSMHtnPEg5uJUS', '2019-06-05 07:08:37', '2019-06-12 06:41:33', 1, NULL, NULL);
INSERT INTO `users` VALUES (2, '魂牵梦萦=', 'fdsa@fdsa.com', NULL, '$2y$10$E24Bnl91wvt4MwKRrlTd5uYHo0JbdKEqRrfLm/qZEfYyWdItzgAo6', 'oo8o6ckISsaJZlHyDvAZclrrKo2ddI6JMoHYFp98hrJ84C3XrtnU7NbzEH5d', '2019-06-10 06:30:17', '2019-06-10 09:24:47', 0, NULL, NULL);
INSERT INTO `users` VALUES (3, '全家便利店1', 'rewq@rewq.com', NULL, '$2y$10$fH8Y0pRb/8qt4foT/l19suD5iVeq1X4KKc0XDDEL8DJT/q7MUO64i', NULL, '2019-06-11 06:00:50', '2019-06-11 06:19:24', 0, NULL, NULL);
INSERT INTO `users` VALUES (4, '全家便利店1', 'rewq1@rewq.com', NULL, '$2y$10$ptfRvqpPEpqOD3l3WgmM9utPaZ.KDVQFAf8ExGttWYmvckaxopaIy', NULL, '2019-06-11 06:18:33', '2019-06-11 06:18:33', 0, NULL, NULL);
INSERT INTO `users` VALUES (5, 'fdsa1@fdsa.com', 'fdsa1@fdsa.com', NULL, '$2y$10$JZnnRy.Ek0C.IaChfs7REu5MJxKKRqjmtuWNAxes.6G5byl8HNxi.', NULL, '2019-06-11 06:20:00', '2019-06-11 06:20:00', 0, NULL, NULL);
INSERT INTO `users` VALUES (6, 'fdsa2@fdsa.com', 'fdsa2@fdsa.com', NULL, '$2y$10$0fbzlA9wZPXrw8WyGtO4IuXqloJBjZX5tcTzhWmwKzBtLl.PALPdi', NULL, '2019-06-11 06:33:00', '2019-06-11 06:33:00', 0, NULL, NULL);
INSERT INTO `users` VALUES (7, 'ssdfd', 'fdsa3@fdsa.com', NULL, '$2y$10$jFQYIOoUfT3cqVouYqvcp.FkS9Y5xSOf3b3xu1sXs4uvclOkiWMce', NULL, '2019-06-11 08:13:35', '2019-06-11 08:13:35', 0, 'urdr2l4Z7T', 0);

SET FOREIGN_KEY_CHECKS = 1;
