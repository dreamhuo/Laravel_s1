/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : larabbs

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 12/07/2019 16:31:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_count` int(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, '分享', '分享创造，分享发现', 0);
INSERT INTO `categories` VALUES (2, '教程', '开发技巧、推荐扩展包等', 0);
INSERT INTO `categories` VALUES (3, '问答', '请保持友善，互帮互助', 0);
INSERT INTO `categories` VALUES (4, '公告', '站点公告', 0);

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images`  (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of images
-- ----------------------------
INSERT INTO `images` VALUES (1, 2, 'avatar', 'http://localhost:8082/uploads/images/avatars/201907/08/2_1562571480_yrsu1SUfTl.png', '2019-07-08 15:38:00', '2019-07-08 15:38:00');
INSERT INTO `images` VALUES (2, 2, 'topic', 'http://localhost:8082/uploads/images/topics/201907/08/2_1562571941_PSGGgkp8pv.png', '2019-07-08 15:45:41', '2019-07-08 15:45:41');
INSERT INTO `images` VALUES (3, 2, 'topic', 'http://localhost:8082/uploads/images/topics/201907/08/2_1562571943_1mHmA90jyd.png', '2019-07-08 15:45:43', '2019-07-08 15:45:43');
INSERT INTO `images` VALUES (4, 2, 'topic', 'http://localhost:8082/uploads/images/topics/201907/08/2_1562571944_BURDA9YRtf.png', '2019-07-08 15:45:45', '2019-07-08 15:45:45');
INSERT INTO `images` VALUES (5, 2, 'topic', 'http://localhost:8082/uploads/images/topics/201907/08/2_1562571999_U6zEg9JO5b.png', '2019-07-08 15:46:39', '2019-07-08 15:46:39');
INSERT INTO `images` VALUES (6, 2, 'avatar', 'http://localhost:8082/uploads/images/avatars/201907/08/2_1562572007_5b4E5BEGjm.png', '2019-07-08 15:46:48', '2019-07-08 15:46:48');
INSERT INTO `images` VALUES (7, 2, 'avatar', 'http://localhost:8082/uploads/images/avatars/201907/08/2_1562572024_Dt1Hp08xoV.jpg', '2019-07-08 15:47:04', '2019-07-08 15:47:04');
INSERT INTO `images` VALUES (8, 2, 'avatar', 'http://localhost:8082/uploads/images/avatars/201907/08/2_1562572060_DfOgFx2DET.png', '2019-07-08 15:47:40', '2019-07-08 15:47:40');
INSERT INTO `images` VALUES (9, 2, NULL, 'http://localhost:8082/uploads/images/avatars/201907/08/2_1562577503_KWe0wMLHXV.jpg', '2019-07-08 17:18:23', '2019-07-08 17:18:23');

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` int(10) UNSIGNED NOT NULL COMMENT '对应权限表的 id',
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '模型类型 App\\Models\\User ',
  `model_id` bigint(20) UNSIGNED NOT NULL COMMENT '模型id  对应模型 id',
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
INSERT INTO `model_has_permissions` VALUES (7, 'App\\Models\\User', 3);
INSERT INTO `model_has_permissions` VALUES (9, 'App\\Models\\User', 3);

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (8, 'App\\Models\\User', 2);
INSERT INTO `model_has_roles` VALUES (8, 'App\\Models\\User', 3);

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp(0) DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifications
-- ----------------------------
INSERT INTO `notifications` VALUES ('4ac62e16-e69d-42e5-9a40-22fd0d15cb09', 'App\\Notifications\\TopicReplied', 'App\\Models\\User', 3, '{\"reply_id\":39,\"reply_content\":\"<p>\\u9700\\u8981\\u8981\\u8981\\u8981\\u8981<\\/p>\",\"user_id\":4,\"user_name\":\"dDDsss\",\"user_avatar\":null,\"topic_link\":\"\\/topics\\/39\",\"topic_id\":39,\"topic_title\":\"\\u6709\\u56de\\u590d\\u7684\\u5e16\\u5b50\"}', '2019-06-19 14:34:33', '2019-06-19 10:44:23', '2019-06-19 14:34:33');
INSERT INTO `notifications` VALUES ('7eca2dd5-1de3-4414-9274-0a4ebb16b6fd', 'App\\Notifications\\TopicReplied', 'App\\Models\\User', 3, '{\"reply_id\":40,\"reply_content\":\"<p>\\u770b\\u4e00\\u4e0b\\u770b\\u4e0b<\\/p>\",\"user_id\":4,\"user_name\":\"dDDsss\",\"user_avatar\":null,\"topic_link\":\"\\/topics\\/39\",\"topic_id\":39,\"topic_title\":\"\\u6709\\u56de\\u590d\\u7684\\u5e16\\u5b50\"}', '2019-06-19 14:34:33', '2019-06-19 10:44:37', '2019-06-19 14:34:33');
INSERT INTO `notifications` VALUES ('6ea1548c-b5b8-4ed5-ac02-33266fab025f', 'App\\Notifications\\TopicReplied', 'App\\Models\\User', 3, '{\"reply_id\":41,\"reply_content\":\"<p>\\u770b\\u4e00\\u4e0b<\\/p>\",\"user_id\":4,\"user_name\":\"dDDsss\",\"user_avatar\":null,\"topic_link\":\"\\/topics\\/39\",\"topic_id\":39,\"topic_title\":\"\\u6709\\u56de\\u590d\\u7684\\u5e16\\u5b50\"}', '2019-06-19 14:34:33', '2019-06-19 10:46:58', '2019-06-19 14:34:33');
INSERT INTO `notifications` VALUES ('9963394c-f874-4661-a34f-d977aa7de6f3', 'App\\Notifications\\TopicReplied', 'App\\Models\\User', 3, '{\"reply_id\":42,\"reply_content\":\"<p>1212121<\\/p>\",\"user_id\":2,\"user_name\":\"fdsa\",\"user_avatar\":null,\"topic_link\":\"\\/topics\\/39\",\"topic_id\":39,\"topic_title\":\"\\u6709\\u56de\\u590d\\u7684\\u5e16\\u5b50\"}', '2019-06-19 14:34:33', '2019-06-19 13:22:39', '2019-06-19 14:34:33');
INSERT INTO `notifications` VALUES ('e16135f1-6988-4f74-9f13-d0e9bdbb743a', 'App\\Notifications\\TopicReplied', 'App\\Models\\User', 3, '{\"reply_id\":43,\"reply_content\":\"<p>32323232<\\/p>\",\"user_id\":2,\"user_name\":\"fdsa\",\"user_avatar\":null,\"topic_link\":\"\\/topics\\/39\",\"topic_id\":39,\"topic_title\":\"\\u6709\\u56de\\u590d\\u7684\\u5e16\\u5b50\"}', '2019-06-19 14:34:33', '2019-06-19 13:23:52', '2019-06-19 14:34:33');
INSERT INTO `notifications` VALUES ('00ee3a0d-7d1c-4a03-ab08-dd929f203daa', 'App\\Notifications\\TopicReplied', 'App\\Models\\User', 3, '{\"reply_id\":45,\"reply_content\":\"<p>123232<\\/p>\",\"user_id\":2,\"user_name\":\"fdsa\",\"user_avatar\":null,\"topic_link\":\"\\/topics\\/39\",\"topic_id\":39,\"topic_title\":\"\\u6709\\u56de\\u590d\\u7684\\u5e16\\u5b50\"}', '2019-06-19 14:34:33', '2019-06-19 13:34:17', '2019-06-19 14:34:33');
INSERT INTO `notifications` VALUES ('1599402e-85fe-443d-9059-e309f911a43d', 'App\\Notifications\\TopicReplied', 'App\\Models\\User', 3, '{\"reply_id\":46,\"reply_content\":\"<p>12121212121<\\/p>\",\"user_id\":2,\"user_name\":\"fdsa\",\"user_avatar\":null,\"topic_link\":\"\\/topics\\/39\",\"topic_id\":39,\"topic_title\":\"\\u6709\\u56de\\u590d\\u7684\\u5e16\\u5b50\"}', '2019-06-19 14:34:33', '2019-06-19 13:39:40', '2019-06-19 14:34:33');
INSERT INTO `notifications` VALUES ('bba95434-6043-4460-aec2-b8478e3ab4d6', 'App\\Notifications\\TopicReplied', 'App\\Models\\User', 3, '{\"reply_id\":47,\"reply_content\":\"<p>54325432543254325432<\\/p>\",\"user_id\":2,\"user_name\":\"fdsa\",\"user_avatar\":null,\"topic_link\":\"\\/topics\\/39\",\"topic_id\":39,\"topic_title\":\"\\u6709\\u56de\\u590d\\u7684\\u5e16\\u5b50\"}', '2019-06-19 14:34:33', '2019-06-19 13:39:52', '2019-06-19 14:34:33');
INSERT INTO `notifications` VALUES ('ee903242-4eef-474a-aa28-24e6fc442ad7', 'App\\Notifications\\TopicReplied', 'App\\Models\\User', 3, '{\"reply_id\":48,\"reply_content\":\"<p>43143243214321<\\/p>\",\"user_id\":2,\"user_name\":\"fdsa\",\"user_avatar\":null,\"topic_link\":\"\\/topics\\/39\",\"topic_id\":39,\"topic_title\":\"\\u6709\\u56de\\u590d\\u7684\\u5e16\\u5b50\"}', '2019-06-19 14:34:33', '2019-06-19 13:41:33', '2019-06-19 14:34:33');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '权限name',
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '权限分组，在模型中 protected $guard_name = \'admin\'; 与分组一样，才能设置',
  `created_at` timestamp(0) DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (6, 'edit articles3', 'web', '2019-06-21 15:55:32', '2019-06-21 15:55:32');
INSERT INTO `permissions` VALUES (5, 'edit articles2', 'web', '2019-06-21 15:44:09', '2019-06-21 15:44:09');
INSERT INTO `permissions` VALUES (4, 'edit articles', 'web', '2019-06-21 15:43:13', '2019-06-21 15:43:13');
INSERT INTO `permissions` VALUES (7, 'publish articles', 'admin', '2019-06-21 16:31:39', '2019-06-21 16:31:39');
INSERT INTO `permissions` VALUES (8, 'publish', 'admin', '2019-06-21 16:55:49', '2019-06-21 16:55:52');
INSERT INTO `permissions` VALUES (9, '编辑文章', 'admin', '2019-06-27 13:12:01', '2019-06-27 13:12:01');
INSERT INTO `permissions` VALUES (10, 'manage_contents', 'admin', '2019-07-11 09:43:23', '2019-07-11 09:43:25');
INSERT INTO `permissions` VALUES (11, 'manage_users', 'admin', '2019-07-11 09:43:40', '2019-07-11 09:43:43');
INSERT INTO `permissions` VALUES (12, 'manage_settings', 'admin', '2019-07-11 09:43:56', '2019-07-11 09:43:58');

-- ----------------------------
-- Table structure for replies
-- ----------------------------
DROP TABLE IF EXISTS `replies`;
CREATE TABLE `replies`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `topic_id` bigint(20) DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 55 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of replies
-- ----------------------------
INSERT INTO `replies` VALUES (15, 3, 53, '魂牵梦萦', '2019-06-18 15:26:57', '2019-06-18 15:26:57');
INSERT INTO `replies` VALUES (16, 3, 53, '321432143214321', '2019-06-18 15:29:23', '2019-06-18 15:29:23');
INSERT INTO `replies` VALUES (17, 3, 53, '魂牵梦萦要', '2019-06-18 15:31:20', '2019-06-18 15:31:20');
INSERT INTO `replies` VALUES (18, 3, 53, '魂牵梦萦要', '2019-06-18 15:34:28', '2019-06-18 15:34:28');
INSERT INTO `replies` VALUES (19, 3, 53, '魂牵梦萦要城', '2019-06-18 15:35:03', '2019-06-18 15:35:03');
INSERT INTO `replies` VALUES (53, 3, 41, '<p>回复一个</p>', '2019-07-10 15:02:41', '2019-07-10 15:02:41');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (10, 7);
INSERT INTO `role_has_permissions` VALUES (10, 8);
INSERT INTO `role_has_permissions` VALUES (11, 8);
INSERT INTO `role_has_permissions` VALUES (12, 8);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (5, 'writer3', 'web', '2019-06-21 15:55:32', '2019-06-21 15:55:32');
INSERT INTO `roles` VALUES (3, 'writer', 'web', '2019-06-21 15:43:13', '2019-06-21 15:43:13');
INSERT INTO `roles` VALUES (4, 'writer2', 'web', '2019-06-21 15:44:09', '2019-06-21 15:44:09');
INSERT INTO `roles` VALUES (6, 'superadmin', 'admin', '2019-06-21 16:31:39', '2019-06-21 16:31:39');
INSERT INTO `roles` VALUES (7, 'Maintainer', 'admin', '2019-07-11 09:41:38', '2019-07-11 09:41:41');
INSERT INTO `roles` VALUES (8, 'Founder', 'admin', '2019-07-11 09:42:01', '2019-07-11 09:42:04');

-- ----------------------------
-- Table structure for topics
-- ----------------------------
DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `reply_count` int(255) DEFAULT NULL,
  `view_count` int(255) DEFAULT NULL,
  `last_reply_user_id` int(255) DEFAULT NULL,
  `order` int(255) DEFAULT NULL,
  `excerpt` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `title`(`title`, `user_id`, `category_id`, `reply_count`, `view_count`, `last_reply_user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 56 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of topics
-- ----------------------------
INSERT INTO `topics` VALUES (38, '客厅fdsfdfd', 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, '霏霏 在在在在', '2019-06-17 13:26:01', '2019-06-17 13:26:01');
INSERT INTO `topics` VALUES (37, '魂牵梦萦', 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, '=============…魂牵梦萦', '2019-06-17 13:24:57', '2019-06-17 13:24:57');
INSERT INTO `topics` VALUES (33, '12121', 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, '暂未设置内容…', '2019-06-17 13:19:10', '2019-06-17 13:19:10');
INSERT INTO `topics` VALUES (32, '南市', 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-06-17 13:18:15', '2019-06-17 13:18:15');
INSERT INTO `topics` VALUES (31, '客厅', 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2019-06-17 13:18:01', '2019-06-17 13:18:01');
INSERT INTO `topics` VALUES (30, '户型简介', 3, 4, NULL, NULL, NULL, NULL, NULL, NULL, '圾有有有有有有未设置内容…', '2019-06-17 13:17:34', '2019-06-17 13:17:34');
INSERT INTO `topics` VALUES (29, '客厅', 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, '111111111111111111111111111111', '2019-06-17 13:16:00', '2019-06-17 13:16:00');
INSERT INTO `topics` VALUES (28, '客厅', 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, '21212121', '2019-06-17 13:15:29', '2019-06-17 13:15:29');
INSERT INTO `topics` VALUES (40, '35435432', 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, '暂未设4324324324置内容…', '2019-06-17 13:40:32', '2019-06-17 13:40:32');
INSERT INTO `topics` VALUES (41, '割发代首割发代首', 3, 2, 1, NULL, NULL, NULL, '====3243214321435====4354325432=暂未设置内容…', NULL, '<p>====3243214321435====4354325432=暂未设置内容…</p>', '2019-06-17 13:53:33', '2019-07-10 15:18:17');
INSERT INTO `topics` VALUES (44, '魂牵梦萦', 3, 2, NULL, NULL, NULL, NULL, '1魂牵梦4545454萦要要', NULL, '1魂牵梦4545454萦要要', '2019-06-17 14:19:13', '2019-06-17 14:19:13');
INSERT INTO `topics` VALUES (45, '需要要要', 3, 2, NULL, NULL, NULL, NULL, '魂牵梦萦魂牵梦萦魂牵梦萦', NULL, '<p><b>魂牵梦萦魂牵</b>梦<i>萦魂牵梦</i>萦</p>', '2019-06-17 15:15:35', '2019-06-17 15:15:35');
INSERT INTO `topics` VALUES (46, '1212121', 3, 2, NULL, NULL, NULL, NULL, '暂未设置内容…', NULL, '<p>暂未设置内容…<img alt=\"98平D户型2室2厅2卫1厨.png\" src=\"http://localhost:8082/uploads/images/topics/201906/17/3_1560756192_XSgFR9FgTN.png\" width=\"400\" height=\"400\"></p>', '2019-06-17 15:23:58', '2019-06-17 15:23:58');
INSERT INTO `topics` VALUES (47, '魂牵梦萦', 3, 3, NULL, NULL, NULL, NULL, '&lt;script&gt;alert(\'存在 XSS 安全威胁！\')&lt;/script&gt;', NULL, '<p><span style=\"font-size: 1px;\">&lt;script&gt;alert(\'存在 XSS 安全威胁！\')&lt;/script&gt;</span><br></p>', '2019-06-17 16:08:39', '2019-06-17 16:08:39');
INSERT INTO `topics` VALUES (48, '户型简介', 3, 2, NULL, NULL, NULL, NULL, 'alert(\'存在 XSS 安全威胁！\')', NULL, '<script>alert(\'存在 XSS 安全威胁！\')</script>', '2019-06-17 16:24:56', '2019-06-17 16:24:56');
INSERT INTO `topics` VALUES (49, '户型简介', 3, 2, NULL, NULL, NULL, NULL, '看一下是否正常    是不是正常', NULL, '<p>看一下是否正常</p>\r\n\r\n\r\n\r\n<p>是不是正常</p>', '2019-06-17 16:53:55', '2019-06-17 16:53:55');
INSERT INTO `topics` VALUES (53, '户型简介', 3, 2, 5, NULL, NULL, NULL, '要要要要', NULL, '<p>要要要要</p>', '2019-06-18 15:26:53', '2019-06-18 15:35:03');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `activation_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `introduction` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `notification_count` bigint(20) DEFAULT 0,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Token` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (2, '121212121', 'fdsa@fdsa.com', '$2y$10$8qJNP0aR5xnjKKCHL3uRj.Qy/Nw2vN0VBQsg7.992FXYoOB2LYcnq', 'Zi6HyyzU66', '2019-06-12 17:11:47', '2019-07-09 10:13:13', NULL, NULL, 0, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODA4MiIsImlhdCI6MTU2MjIwNzk2NiwiZXhwIjoxNTYyMjExNTY2LCJuYmYiOjE1NjIyMDc5NjYsImp0aSI6IldEd3JFZzVuT0Q4U3Y0MEsiLCJzdWIiOjIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.SPn6PTJ7im93ns34AeyiW1i5J3H_pVD5XajIZSZjIfw');
INSERT INTO `users` VALUES (3, 'tospur_pc', 'huo8008@126.com', '$2y$10$8qJNP0aR5xnjKKCHL3uRj.Qy/Nw2vN0VBQsg7.992FXYoOB2LYcnq', '2qwDQD53x1', '2019-06-13 10:38:39', '2019-06-19 14:34:33', 'http://localhost:8082/uploads/images/avatars/201906/13/3_1560412735_CgHBdMJc2b.jpg', '我是一只小小鸟我是一只小小鸟我是一只小小鸟我是一只小小鸟我是一只小小鸟我是一只小小鸟我是一只小小鸟我是一只小小鸟', 0, NULL, NULL);
INSERT INTO `users` VALUES (4, 'dDDsss', 'huo8009@126.com', '$2y$10$8qJNP0aR5xnjKKCHL3uRj.Qy/Nw2vN0VBQsg7.992FXYoOB2LYcnq', NULL, '2019-06-19 09:48:23', '2019-06-19 09:48:23', NULL, NULL, 0, NULL, NULL);
INSERT INTO `users` VALUES (5, 'huocs', NULL, '$2y$10$SrFClTaPjMsqx6dPGx8IIeKgDrxaJrhqPLhWB25f9hVI7ZhDK8Wo6', NULL, '2019-07-03 11:08:57', '2019-07-03 11:08:57', NULL, NULL, 0, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
