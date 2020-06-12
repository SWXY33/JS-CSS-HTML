/*
 Navicat Premium Data Transfer

 Source Server         : find
 Source Server Type    : MySQL
 Source Server Version : 50562
 Source Host           : localhost:3306
 Source Schema         : test

 Target Server Type    : MySQL
 Target Server Version : 50562
 File Encoding         : 65001

 Date: 12/06/2020 16:13:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for blog
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of blog
-- ----------------------------
INSERT INTO `blog` VALUES (1, 'JFinal Demo Title here', 'JFinal Demo Content here');
INSERT INTO `blog` VALUES (2, 'test 111', 'test 111');
INSERT INTO `blog` VALUES (3, 'test 222', 'test 222');
INSERT INTO `blog` VALUES (4, 'test 33', 'test 33');
INSERT INTO `blog` VALUES (5, 'test 42', 'test 42');
INSERT INTO `blog` VALUES (9, 'test 2', 'test 2');
INSERT INTO `blog` VALUES (10, 'test 3', 'test 3');
INSERT INTO `blog` VALUES (11, '编辑测试', 'JFinal Demo Content here');
INSERT INTO `blog` VALUES (12, 'test 1', 'test 1');
INSERT INTO `blog` VALUES (13, 'test 2', 'test 2');
INSERT INTO `blog` VALUES (14, 'test 3', 'test 3');
INSERT INTO `blog` VALUES (15, 'test 4', 'test 4');
INSERT INTO `blog` VALUES (16, '新人员1', '1');
INSERT INTO `blog` VALUES (17, '新人员1', '1');
INSERT INTO `blog` VALUES (18, '新人员1', '1');
INSERT INTO `blog` VALUES (19, '新人员2', '2');
INSERT INTO `blog` VALUES (20, '111', '111');
INSERT INTO `blog` VALUES (21, 'giscafer', 'giscafer');
INSERT INTO `blog` VALUES (22, '测试主键重复1', '测试主键重复1');
INSERT INTO `blog` VALUES (23, '测试主键重复2', '测试主键重复2');
INSERT INTO `blog` VALUES (24, '新人员333', '333');
INSERT INTO `blog` VALUES (25, '新增测试', '');

-- ----------------------------
-- Table structure for login
-- ----------------------------
DROP TABLE IF EXISTS `login`;
CREATE TABLE `login`  (
  `id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `loginname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `job` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of login
-- ----------------------------
INSERT INTO `login` VALUES ('46ffddf9c25846159d5bcb448a3ada06', 'admin', 'admin', 'admin');
INSERT INTO `login` VALUES ('4f448e2c20d1425ea0cbb0a170e27516', '陆珊莉', '测试', '123456');
INSERT INTO `login` VALUES ('60adf794dec041ab8ffcc1148f3ca76b', '俊仪', 'APP', '111');
INSERT INTO `login` VALUES ('88c096439faa41d4aee418a876cb2762', '欧海容', '123', '1');
INSERT INTO `login` VALUES ('d4554270a3e94d548d66616298af12da', '陈小东', '设计', '123');
INSERT INTO `login` VALUES ('f432533ee6f64ed9942a092bd9e403e8', '12', '测试', '123456');
INSERT INTO `login` VALUES ('f468e4f53ea14d7aa3d82345560d7624', '77', '2', '123');

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `keywords` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `autor` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `addtime` date NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES (2, '新闻2', '军事', '李四', '2018-01-13', '港媒称歼20开展首次实战训练');
INSERT INTO `news` VALUES (3, '新闻3', '科技', '王五', '2018-01-12', '英特尔再曝新漏洞，黑客可控制笔记本');
INSERT INTO `news` VALUES (5, '新闻5', '历史', '赵七', '2018-01-06', '毛泽东生前警卫：不孤独因有毛主席相伴');
INSERT INTO `news` VALUES (4, '新闻4', '电影', '马六', '2018-01-09', '2018内地好莱坞引进片前瞻');
INSERT INTO `news` VALUES (1, '新闻1', '社会', '张三', '2018-01-14', '2018春运售票进入高峰期');
INSERT INTO `news` VALUES (6, '新闻6', '财经', '周八', '2018-01-01', '新年楼市松绑真相');

-- ----------------------------
-- Table structure for oprate
-- ----------------------------
DROP TABLE IF EXISTS `oprate`;
CREATE TABLE `oprate`  (
  `oprate_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `oprate_time` datetime NULL DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user_pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user_job` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`oprate_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of oprate
-- ----------------------------
INSERT INTO `oprate` VALUES ('0194ebdcc13a4a1c840b60ac308b51bd', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-20 11:04:19', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('04f311bea1aa4c49bb69625878ce5061', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 14:55:24', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('0773eaf7437046d9a9d128efd002819b', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:39:46', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('0a6767fe674c4c21b423110a66c404a1', '88c096439faa41d4aee418a876cb2762', '2020-03-27 17:50:14', 'login', '欧海容', '123', '1');
INSERT INTO `oprate` VALUES ('0a6b2adbb6814a62bfca1cd20a79f43a', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-20 11:19:58', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('0ce5c94d1f3041eeb9298196e895f7a8', '60adf794dec041ab8ffcc1148f3ca76b', '2020-03-19 14:49:10', 'add', '俊仪', '111', 'APP');
INSERT INTO `oprate` VALUES ('10d7306495344a4586e183877c846887', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 14:37:55', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('11106382bf4e42439c2591c198c208b5', 'all', '2020-03-19 14:50:09', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('130f4fbba3904b1c844cfb0bbb7825d3', 'all', '2020-03-27 17:53:40', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('173afd864107460493e67d906f718611', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:02:04', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('18b92942895843f8b71971de1b8458af', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-27 14:35:19', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('192b6da4441a463d82760b5f46c049c7', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:29:04', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('1ae9d4bd2ec047f08585e8aa7efff331', 'all', '2020-03-20 11:02:17', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('1d7a832ec5104223a33867df8d3dd37b', '4f448e2c20d1425ea0cbb0a170e27516', '2020-03-27 17:20:36', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('1f9b79ce321a47799fd702e0449ce7cc', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-20 11:53:31', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('23fcb3290b02429e933b8eb711c5847c', 'all', '2020-03-20 10:54:00', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('26527984f4b8456ebfb11a924ee30e7f', 'all', '2020-03-20 10:55:17', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('2e4f90864ac644f5aac6ffd7111e741d', 'all', '2020-03-19 15:01:31', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('33fa2b61b09a478ba5e8970b32b4dc77', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:27:55', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('34d77ac98c734f719ce32a78232ede05', 'all', '2020-03-20 11:27:45', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('3558380423044a3ea7a36e92436a9ed9', '4f448e2c20d1425ea0cbb0a170e27516', '2020-03-27 17:00:03', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('358c2a7c211e4a1c9c577e1d58caf1ae', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:41:17', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('397136cfb28749908bcce6d4a2ba2e15', 'all', '2020-03-19 14:47:22', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('3c2b46fa28a64deeacd6b90fdb07dc99', '4f448e2c20d1425ea0cbb0a170e27516', '2020-03-27 17:52:59', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('3ed9cab02be84e10bbab70864a9ff6f8', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:44:51', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('42dd605ae2df49fb9f28dd2e2661ad1f', 'all', '2020-03-20 10:59:38', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('4c1d39d6853a430fab172cea33072a57', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-20 11:41:31', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('57642119d0e14ba481202f3f9cb09f96', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 14:38:08', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('5f6d8cb3515f41579a7f276614f61d08', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-19 17:57:08', 'add', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('614e5ac9856143e89e9db3cddae4b4a9', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 14:36:32', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('64bf22014b6641e298fcdb6af94049b0', 'all', '2020-03-19 14:55:22', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('69bdccab40e340c681f82f4366e63edb', 'all', '2020-03-20 10:56:32', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('6b0d6ab8b70f4d728b4187f34f74bf25', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 14:34:13', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('6c3bebddc1ad471895106c58c4f0fcdb', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:27:32', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('6cbecc6b4ba94ecabda08240d23b528b', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 14:37:14', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('6e73e151ed054700853c91b9d057bc90', 'all', '2020-03-20 14:32:01', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('77275288d7674198a9379942effe2f54', 'e4c133c74b2a471fa052adfe9508b5e6', '2020-03-19 11:58:32', 'delete', '2', '2', '2');
INSERT INTO `oprate` VALUES ('7a2109ff0c694e129c75a18e3cff3b96', 'f432533ee6f64ed9942a092bd9e403e8', '2020-03-19 14:46:26', 'add', '12', '123456', '测试');
INSERT INTO `oprate` VALUES ('7ec76f48f99f4729a75c60b9a0ad31c4', 'all', '2020-03-19 14:09:05', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('824d3abbbf1f419f9ff6dfd375c9809a', '4f448e2c20d1425ea0cbb0a170e27516', '2020-03-27 17:55:04', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('85a08e749c40414d97ba778211f26f69', '4f448e2c20d1425ea0cbb0a170e27516', '2020-03-27 17:15:58', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('8a1bdfc8fc9b432095aa2c312d1e9424', 'all', '2020-03-19 14:34:10', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('9059d3956a3645529138009b324692f9', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-20 11:26:35', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('90d3c842fa114d42b4742cce409a7fa2', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-27 14:26:05', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('9114e7aec4a44e06b22d4187b3a5477f', 'all', '2020-03-19 11:58:06', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('950c202bcaf84db18b8677af0ca7640c', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 15:01:36', 'logout', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('963fee98ffba45039b7d5d3646f21911', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-20 11:27:37', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('99e3bd325d6a46c8ae9fcd1717d03791', 'all', '2020-03-19 14:09:40', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('9cf90a194f1e4386812029476da5edaf', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 14:47:28', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('a287e9928e78449ba4f2ce28a6352cbf', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 14:37:08', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('a28b845d693749cfa717c6780bf2b4f8', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:39:14', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('a3d2ea4db46f48a19ea74433b10ad5a1', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-30 11:07:44', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('ad13daa4cce24bbb86f75ede30d56152', '4f448e2c20d1425ea0cbb0a170e27516', '2020-03-27 17:52:00', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('b1c03d448f144983a68d3bc382292548', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-27 14:23:21', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('b456d35ebe054a3bb40bfd52526142b2', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:39:40', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('b6313da3898e489aa13ba1870d59d5e8', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 14:37:15', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('b7d9f55a604a4915b3a417d66726565c', 'all', '2020-03-20 11:02:34', 'query', 'all', 'all', 'all');
INSERT INTO `oprate` VALUES ('bd2d315c5959427f94406533ea6be632', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:43:18', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('be9ebe586b844b5aaec87c3c8f16e953', '4f448e2c20d1425ea0cbb0a170e27516', '2020-03-27 17:26:19', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('c4451ac56aee4abaa42633416120bf1a', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-20 11:27:18', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('c6fabc2b9b94460ca71eb1f2c718e7fe', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 15:01:34', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('cb2f185c196448a08b6e81ccdea1b3c8', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 10:59:34', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('cc7f1e9938574414b06e85369008d247', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-19 14:36:22', 'update', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('ceab654c30324644afb11a32b3c4ea2d', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-20 11:20:28', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('d7b79245287742e8b4ed6fe6ab846b27', '4f448e2c20d1425ea0cbb0a170e27516', '2020-03-27 17:22:09', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('db492f0a16cc487ca91ebd2dd9670e9d', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-20 14:32:13', 'update', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('e1d2731589724611a7edc43a0af4c4c0', 'f468e4f53ea14d7aa3d82345560d7624', '2020-03-19 12:01:42', 'add', '77', '123', '2');
INSERT INTO `oprate` VALUES ('e230e8d69eaa41dfb0cce1d2b8ff9b32', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-27 14:30:57', 'login', '陆珊莉', '测试', '123456');
INSERT INTO `oprate` VALUES ('e962be73422249858e8d9711ad26d475', '60adf794dec041ab8ffcc1148f3ca76b', '2020-03-19 14:50:12', 'update', '俊仪', 'APP', '111');
INSERT INTO `oprate` VALUES ('ee1025fe9eda41ea894c46593527bcb8', '46ffddf9c25846159d5bcb448a3ada06', '2020-03-20 08:41:58', 'login', 'admin', 'admin', 'admin');
INSERT INTO `oprate` VALUES ('fdb583ff9708400482d3f798c5d06005', '528905156d5b47bc8fcfde6e4e2641f5', '2020-03-20 11:29:52', 'login', '陆珊莉', '测试', '123456');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `age` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, '张三', 20);
INSERT INTO `user` VALUES (2, '2', 2);
INSERT INTO `user` VALUES (9, '张三', 20);
INSERT INTO `user` VALUES (10, '陈恒', 11);
INSERT INTO `user` VALUES (11, '陈恒', 11);

-- ----------------------------
-- Table structure for user_inf
-- ----------------------------
DROP TABLE IF EXISTS `user_inf`;
CREATE TABLE `user_inf`  (
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `month_num` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `before_num` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `now_num` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `price` double(10, 1) NULL DEFAULT NULL,
  `num` int(255) NULL DEFAULT NULL,
  `total_money` double(255, 1) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_inf
-- ----------------------------
INSERT INTO `user_inf` VALUES ('4f448e2c20d1425ea0cbb0a170e27516', '陆珊莉', '12345678901', '良田', '2020-03', '22', '35', 0.8, 13, 10.4);
INSERT INTO `user_inf` VALUES ('88c096439faa41d4aee418a876cb2762', '欧海容', '158****6928', '塘坪', '2020-03', '0', '66', 0.8, 66, 52.8);

-- ----------------------------
-- View structure for gc_schedule_check_v
-- ----------------------------
DROP VIEW IF EXISTS `gc_schedule_check_v`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `gc_schedule_check_v` AS select `t2`.`name` AS `name`,`t1`.`pid` AS `pid`,date_format(`t1`.`checkTime`,'%Y-%m-%d') AS `checkTime`,`t1`.`checkStatus` AS `checkStatus` from (`gc_schedule_check` `t1` join `gc_schedule_person` `t2` on((`t1`.`pid` = `t2`.`pid`))) order by `t1`.`pid`;

-- ----------------------------
-- View structure for gc_schedule_group_person_v
-- ----------------------------
DROP VIEW IF EXISTS `gc_schedule_group_person_v`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `gc_schedule_group_person_v` AS select `t1`.`pid` AS `pid`,`t1`.`name` AS `name`,`t2`.`groupName` AS `groupName`,`t2`.`gid` AS `gid` from (`gc_schedule_person` `t1` left join `gc_schedule_group` `t2` on((`t2`.`groupItem` like concat('%',`t1`.`name`,'%'))));

-- ----------------------------
-- View structure for gc_schedule_scheduler_check_v
-- ----------------------------
DROP VIEW IF EXISTS `gc_schedule_scheduler_check_v`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `gc_schedule_scheduler_check_v` AS select `t3`.`name` AS `name`,`t3`.`pid` AS `pid`,`t3`.`day` AS `checkTime`,`t3`.`events` AS `checkStatus` from `gc_schedule_scheduler` `t3` where (`t3`.`pid` in (select `gc_schedule_check_v`.`pid` from `gc_schedule_check_v`) and (not(`t3`.`day` in (select `gc_schedule_check_v`.`checkTime` from `gc_schedule_check_v`)))) order by `t3`.`pid`;

SET FOREIGN_KEY_CHECKS = 1;
