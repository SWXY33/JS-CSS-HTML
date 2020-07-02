/*
Navicat MySQL Data Transfer

Source Server         : test1
Source Server Version : 50562
Source Host           : localhost:3306
Source Database       : ording

Target Server Type    : MYSQL
Target Server Version : 50562
File Encoding         : 65001

Date: 2020-03-17 10:40:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for goods_order
-- ----------------------------
DROP TABLE IF EXISTS `goods_order`;
CREATE TABLE `goods_order` (
  `id` varchar(64) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `db_status` int(11) DEFAULT NULL,
  `consumer_id` varchar(64) DEFAULT NULL,
  `address_id` varchar(64) DEFAULT NULL,
  `store_id` varchar(64) DEFAULT NULL,
  `guest_book` varchar(255) DEFAULT NULL,
  `total_price` decimal(22,0) DEFAULT NULL,
  `payment_method` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods_order
-- ----------------------------
INSERT INTO `goods_order` VALUES ('402881a570e1191e0170e141eb59003a', '2020-03-16 10:52:36', '0', '4028819570d6e2840170d6e4a3790004', '402881a570e1191e0170e141e2330039', '402881a570e1191e0170e137ac9a001e', '', '0', '0');

-- ----------------------------
-- Table structure for order_menu
-- ----------------------------
DROP TABLE IF EXISTS `order_menu`;
CREATE TABLE `order_menu` (
  `id` varchar(64) DEFAULT NULL,
  `order_id` varchar(64) NOT NULL,
  `menu_id` varchar(64) NOT NULL,
  `count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_menu
-- ----------------------------
INSERT INTO `order_menu` VALUES ('4028819570d6e2840170d6e30f6b0003', '4028819570d6e2840170d6e30f4b0002', '402884e7549e5d9301549e86f40f0008', '1');
INSERT INTO `order_menu` VALUES ('4028819570d6e2840170d6e4a39f0007', '4028819570d6e2840170d6e4a39e0006', '402884e7548b6a8101548b72f3fb000d', '1');
INSERT INTO `order_menu` VALUES ('4028819570d6e2840170d6ed9955000a', '4028819570d6e2840170d6ed99550009', '402884e7548c03b701548c19c6f70003', '1');
INSERT INTO `order_menu` VALUES ('4028819570d6e2840170d6ed9955000b', '4028819570d6e2840170d6ed99550009', '402884e7548b6a8101548b72f3fb000d', '3');
INSERT INTO `order_menu` VALUES ('4028819570d6e2840170d6ed9955000c', '4028819570d6e2840170d6ed99550009', '402884e7548b6a8101548b7101bc000a', '1');
INSERT INTO `order_menu` VALUES ('402881a570e1191e0170e141eb5a003b', '402881a570e1191e0170e141eb59003a', '402881a570e1191e0170e1381f0e0021', '1');
INSERT INTO `order_menu` VALUES ('402881a570e1191e0170e141eb5a003c', '402881a570e1191e0170e141eb59003a', '402881a570e1191e0170e1387c7c0024', '1');
INSERT INTO `order_menu` VALUES ('402881a570e1191e0170e141eb5a003d', '402881a570e1191e0170e141eb59003a', '402881a570e1191e0170e138cd2e0027', '1');

-- ----------------------------
-- Table structure for phone_and_code
-- ----------------------------
DROP TABLE IF EXISTS `phone_and_code`;
CREATE TABLE `phone_and_code` (
  `phone` varchar(30) NOT NULL,
  `verify_code` varchar(20) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`phone`),
  UNIQUE KEY `phone_and_code_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phone_and_code
-- ----------------------------
INSERT INTO `phone_and_code` VALUES ('13077670902', '123456', '2020-03-14 09:13:46');
INSERT INTO `phone_and_code` VALUES ('13307739443', '359477', '2020-03-14 09:13:46');
INSERT INTO `phone_and_code` VALUES ('15177553656', '790309', '2020-03-14 10:43:46');
INSERT INTO `phone_and_code` VALUES ('15607731014', '888606', '2020-03-14 09:13:46');
INSERT INTO `phone_and_code` VALUES ('15607732013', '123456', '2020-03-14 09:13:46');
INSERT INTO `phone_and_code` VALUES ('15607732014', '123456', '2016-05-16 16:28:25');
INSERT INTO `phone_and_code` VALUES ('15607732015', '123456', '2016-05-11 14:27:55');
INSERT INTO `phone_and_code` VALUES ('15607732016', '123456', '2016-05-04 22:18:50');
INSERT INTO `phone_and_code` VALUES ('15607732017', '123456', '2016-05-13 15:26:53');
INSERT INTO `phone_and_code` VALUES ('15607732018', '123456', '2016-05-13 16:45:44');
INSERT INTO `phone_and_code` VALUES ('15607732513', '970573', '2020-03-14 10:32:32');
INSERT INTO `phone_and_code` VALUES ('15678389519', '848586', '2016-05-05 11:01:13');

-- ----------------------------
-- Table structure for pmi_t_privilege
-- ----------------------------
DROP TABLE IF EXISTS `pmi_t_privilege`;
CREATE TABLE `pmi_t_privilege` (
  `id` varchar(64) NOT NULL,
  `parent_id` varchar(64) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `order_num` int(11) DEFAULT NULL,
  `description` varchar(1500) DEFAULT NULL,
  `menu_icon_css` varchar(50) DEFAULT NULL,
  `sys_icon_css` varchar(50) DEFAULT NULL,
  `double_screen` int(1) DEFAULT NULL,
  `db_status` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_man_id` varchar(64) DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  `modify_man_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pmi_t_privilege
-- ----------------------------
INSERT INTO `pmi_t_privilege` VALUES ('402889e8549417650154941765140000', null, null, '1', 'sys-zzjg', '组织结构', '0', null, null, null, '0', '0', '2016-05-09 14:02:55', null, null, null);

-- ----------------------------
-- Table structure for pmi_t_privilege_for_menu
-- ----------------------------
DROP TABLE IF EXISTS `pmi_t_privilege_for_menu`;
CREATE TABLE `pmi_t_privilege_for_menu` (
  `id` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `parent_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `order_num` decimal(22,0) DEFAULT '0',
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `clevel` int(11) DEFAULT NULL,
  `root` varchar(64) DEFAULT NULL,
  `path` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `menuiconcss` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `sysiconcss` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `doublescreen` int(1) DEFAULT NULL,
  `description` varchar(1500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pmi_t_privilege_for_menu
-- ----------------------------
INSERT INTO `pmi_t_privilege_for_menu` VALUES ('402889e85494148b015494148bb50000', null, '组织结构', '0', 'sys-zzjg', '1', '402889e8549417650154941765140000', null, null, null, '0', null);

-- ----------------------------
-- Table structure for pmi_t_role_privilege
-- ----------------------------
DROP TABLE IF EXISTS `pmi_t_role_privilege`;
CREATE TABLE `pmi_t_role_privilege` (
  `user_type` int(11) NOT NULL,
  `privilege_id` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pmi_t_role_privilege
-- ----------------------------

-- ----------------------------
-- Table structure for rectipt_address
-- ----------------------------
DROP TABLE IF EXISTS `rectipt_address`;
CREATE TABLE `rectipt_address` (
  `id` varchar(64) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `db_status` int(11) DEFAULT NULL,
  `user_id` varchar(64) DEFAULT NULL,
  `receive_name` varchar(255) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rectipt_address
-- ----------------------------
INSERT INTO `rectipt_address` VALUES ('4028819570d6e2840170d6e30d460001', '2020-03-14 10:32:49', '0', '402884e65450dd8d015450e55d0d0002', '陆陆', '女士', '15607732513', null, null, null, '广东省');
INSERT INTO `rectipt_address` VALUES ('4028819570d6e2840170d6e4a3990005', '2020-03-14 10:34:33', '0', '4028819570d6e2840170d6e4a3790004', '陆陆', '女士', '15177553656', null, null, null, '广东省');
INSERT INTO `rectipt_address` VALUES ('402881a570e1191e0170e141e2330039', '2020-03-16 10:52:38', '0', '4028819570d6e2840170d6e4a3790004', '测试收货', '先生', '15177553656', null, null, null, '你自己找');
INSERT INTO `rectipt_address` VALUES ('402883ee54d18ec50154d1a424650015', '2016-05-21 12:47:56', '0', '402890f0536b5d8501536b5dbace0001', '辛杰伟', '先生', '15607732013', null, null, null, '桂电');

-- ----------------------------
-- Table structure for store_information
-- ----------------------------
DROP TABLE IF EXISTS `store_information`;
CREATE TABLE `store_information` (
  `id` varchar(64) NOT NULL,
  `business_id` varchar(64) DEFAULT NULL,
  `logo_id` varchar(64) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `store_describe` varchar(255) DEFAULT NULL,
  `store_province` varchar(255) DEFAULT NULL,
  `store_city` varchar(255) DEFAULT NULL,
  `store_county` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `longitude` decimal(22,6) DEFAULT NULL,
  `latitude` decimal(22,6) DEFAULT NULL,
  `db_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_information
-- ----------------------------
INSERT INTO `store_information` VALUES ('402881a570e1191e0170e131b3f20005', '402884e65450dd8d015450e55d0d0002', '402881a570e1191e0170e1319c290004', '2020-03-16 10:34:55', '阿牛哥', '	随便点敬请享受美食			', '402889e7545259fa01545259fae40000', '402883ef54525b950154525b95330000', '40283f8254561af70154561af7800000', '不知道自己找', '0.000000', '0.000000', '0');
INSERT INTO `store_information` VALUES ('402881a570e1191e0170e134f8150013', 'ff808081547ebd2701547ecc7c2b0001', '402881a570e1191e0170e134f5820012', '2020-03-16 10:38:29', '品柳香', '	柳味任你选=。=			', '402889e7545259fa01545259fae40000', '402883ef54525d760154525d76f70000', '40283f82545622070154562207cb0000', '不知道自己找', '0.000000', '0.000000', '0');
INSERT INTO `store_information` VALUES ('402881a570e1191e0170e137ac9a001e', '4028819570d6e2840170d6e4a3790004', '402881a570e1191e0170e136e1d6001d', '2020-03-16 10:41:27', 'CBS', '炸鸡炸翅汉堡薯条				', '402889e7545259fa01545259fae40000', '402883ef54525b950154525b95330000', '40283f825456261b015456261bc40000', '不知道自己找', '0.000000', '0.000000', '0');
INSERT INTO `store_information` VALUES ('402881a570e1191e0170e13a2d04002a', '402889ed547a846a01547aac374f0009', '402881a570e1191e0170e13968200029', '2020-03-16 10:44:11', '中简西餐', '	中简西餐，赶紧下单吧			', '402889e7545259fa01545259fae40000', '402883ef54525b950154525b95330000', '40287c8f54560e1d0154560e1d910000', '不知道自己找', '0.000000', '0.000000', '0');

-- ----------------------------
-- Table structure for store_menu
-- ----------------------------
DROP TABLE IF EXISTS `store_menu`;
CREATE TABLE `store_menu` (
  `id` varchar(64) NOT NULL,
  `store_id` varchar(64) DEFAULT NULL,
  `photo_id` varchar(64) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_type` varchar(50) DEFAULT NULL,
  `menu_price` decimal(22,6) DEFAULT NULL,
  `menu_describe` varchar(255) DEFAULT NULL,
  `db_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_menu
-- ----------------------------
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e13271ed0008', '402881a570e1191e0170e131b3f20005', '402881a570e1191e0170e131fd1b0007', '2020-03-16 10:35:44', '青椒炒肉片', '快餐', '10.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e132d95f000b', '402881a570e1191e0170e131b3f20005', '402881a570e1191e0170e132a80b000a', '2020-03-16 10:36:10', '蜜汁叉烧', '快餐', '12.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e1333e13000e', '402881a570e1191e0170e131b3f20005', '402881a570e1191e0170e1330d74000d', '2020-03-16 10:36:36', '咕噜肉', '快餐', '13.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e1356b0a0016', '402881a570e1191e0170e134f8150013', '402881a570e1191e0170e1353a050015', '2020-03-16 10:38:59', '桂林米粉', '快餐', '10.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e135e3fd0019', '402881a570e1191e0170e134f8150013', '402881a570e1191e0170e135b0b60018', '2020-03-16 10:39:30', '好吃', '快餐', '8.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e1381f0e0021', '402881a570e1191e0170e137ac9a001e', '402881a570e1191e0170e137da860020', '2020-03-16 10:41:56', '招牌不卖', '快餐', '12020.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e1387c7c0024', '402881a570e1191e0170e137ac9a001e', '402881a570e1191e0170e13851a10023', '2020-03-16 10:42:20', '超级汉堡', '快餐', '20.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e138cd2e0027', '402881a570e1191e0170e137ac9a001e', '402881a570e1191e0170e138a39c0026', '2020-03-16 10:42:41', '炸鸡腿', '快餐', '15.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e13aab3b002d', '402881a570e1191e0170e13a2d04002a', '402881a570e1191e0170e13a5daa002c', '2020-03-16 10:44:43', '牛腩煲', '快餐', '16.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e13b0dbd0030', '402881a570e1191e0170e13a2d04002a', '402881a570e1191e0170e13ad8f3002f', '2020-03-16 10:45:08', '水煮牛肉', '快餐', '18.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e13b94ac0033', '402881a570e1191e0170e13a2d04002a', '402881a570e1191e0170e13b41b10032', '2020-03-16 10:45:43', '烤鸭', '快餐', '14.000000', null, '0');
INSERT INTO `store_menu` VALUES ('402881a570e1191e0170e13bfee00036', '402881a570e1191e0170e13a2d04002a', '402881a570e1191e0170e13bdee20035', '2020-03-16 10:46:10', '蜜汁叉烧', '快餐', '10.000000', null, '0');

-- ----------------------------
-- Table structure for sys_combox
-- ----------------------------
DROP TABLE IF EXISTS `sys_combox`;
CREATE TABLE `sys_combox` (
  `id` varchar(64) NOT NULL,
  `parent_id` varchar(64) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sys_combox_text` (`text`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_combox
-- ----------------------------
INSERT INTO `sys_combox` VALUES ('40283f8254561a550154561a55980000', '402883ef54525b950154525b95330000', '马山县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561af70154561af7800000', '402883ef54525b950154525b95330000', '上林县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561b130154561b13c50000', '402883ef54525b950154525b95330000', '宾阳县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561b2b0154561b2bfe0000', '402883ef54525b950154525b95330000', '横县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561b440154561b44cf0000', '402883ef54525b950154525b95330000', '邕宁县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561b720154561b720a0000', '402883ef54525d760154525d76f70000', '兴安县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561d2c0154561d2c130000', '402883ef54525d760154525d76f70000', '全州县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561d5d0154561d5dcb0000', '402883ef54525d760154525d76f70000', '阳朔县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561d7f0154561d7fd80000', '402883ef54525d760154525d76f70000', '灌阳县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561da00154561da0800000', '402883ef54525d760154525d76f70000', '荔浦县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561dc90154561dc9cf0000', '402883ef54525d760154525d76f70000', '龙胜县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561ee70154561ee7890000', '402883ef54525d760154525d76f70000', '永福县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561f1b0154561f1bd60000', '402883ef54525d760154525d76f70000', '恭城县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561f340154561f34720000', '402883ef54525d760154525d76f70000', '资源县', '3');
INSERT INTO `sys_combox` VALUES ('40283f8254561f520154561f529f0000', '402883ef54525d760154525d76f70000', '平乐县', '3');
INSERT INTO `sys_combox` VALUES ('40283f82545621ed01545621ed570000', '402883ef54525d760154525d76f70000', '雁山区', '3');
INSERT INTO `sys_combox` VALUES ('40283f82545622070154562207cb0000', '402883ef54525d760154525d76f70000', '七星区', '3');
INSERT INTO `sys_combox` VALUES ('40283f825456222701545622270c0000', '402883ef54525d760154525d76f70000', '叠彩区', '3');
INSERT INTO `sys_combox` VALUES ('40283f82545622570154562257e30000', '402883ef54525d760154525d76f70000', '象山区', '3');
INSERT INTO `sys_combox` VALUES ('40283f82545622710154562271720000', '402883ef54525d760154525d76f70000', '秀峰区', '3');
INSERT INTO `sys_combox` VALUES ('40283f825456261b015456261bc40000', '402883ef54525b950154525b95330000', '兴宁区', '3');
INSERT INTO `sys_combox` VALUES ('40283f82545626500154562650dd0000', '402883ef54525b950154525b95330000', '江南区', '3');
INSERT INTO `sys_combox` VALUES ('40283f825456266c015456266c0e0000', '402883ef54525b950154525b95330000', '青秀区', '3');
INSERT INTO `sys_combox` VALUES ('40283f82545626870154562687c30000', '402883ef54525b950154525b95330000', '西乡塘区', '3');
INSERT INTO `sys_combox` VALUES ('40283f82545626a301545626a3550000', '402883ef54525b950154525b95330000', '邕宁区', '3');
INSERT INTO `sys_combox` VALUES ('40283f82545626ca01545626cace0000', '402883ef54525b950154525b95330000', '良庆区', '3');
INSERT INTO `sys_combox` VALUES ('40287c8f54560e1d0154560e1d910000', '402883ef54525b950154525b95330000', '武鸣县', '3');
INSERT INTO `sys_combox` VALUES ('40287c8f54560f1c0154560f1c4b0000', '402883ef54525b950154525b95330000', '隆安县', '3');
INSERT INTO `sys_combox` VALUES ('402883ef54525b950154525b95330000', '402889e7545259fa01545259fae40000', '南宁市', '2');
INSERT INTO `sys_combox` VALUES ('402883ef54525c9d0154525c9dd20000', '402883ef54525d760154525d76f70000', '临桂县', '3');
INSERT INTO `sys_combox` VALUES ('402883ef54525cf20154525cf21a0000', '402883ef54525d760154525d76f70000', '灵川县', '3');
INSERT INTO `sys_combox` VALUES ('402883ef54525d760154525d76f70000', '402889e7545259fa01545259fae40000', '桂林市', '2');
INSERT INTO `sys_combox` VALUES ('402889e7545259fa01545259fae40000', null, '广西壮族自治区', '1');

-- ----------------------------
-- Table structure for sys_files
-- ----------------------------
DROP TABLE IF EXISTS `sys_files`;
CREATE TABLE `sys_files` (
  `id` varchar(64) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `upload_time` datetime DEFAULT NULL,
  `base_path` varchar(255) DEFAULT '',
  `relative_path` varchar(255) DEFAULT NULL,
  `db_status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_files
-- ----------------------------
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e130544d0002', 'Penguins.jpg', '.jpg', '2020-03-16 10:33:25', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e13054360001.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e1319c290004', 'b9237697c93e1e222b0592353bc42d10120065.png', '.png', '2020-03-16 10:34:49', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e1319c200003.png', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e131fd1b0007', '2.jpg', '.jpg', '2020-03-16 10:35:14', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e131fd130006.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e132a80b000a', '63c2065910fc176df3dd6e4f5f1ca2dc66586.jpg', '.jpg', '2020-03-16 10:35:58', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e132a8050009.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e1330d74000d', '4.jpg', '.jpg', '2020-03-16 10:36:24', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e1330d6d000c.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e1343f290010', '34ddf402a3085f99550c4ffae08e15d075531.png', '.png', '2020-03-16 10:37:42', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e1343f23000f.png', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e134f5820012', '34ddf402a3085f99550c4ffae08e15d075531.png', '.png', '2020-03-16 10:38:29', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e134f5780011.png', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e1353a050015', '1.jpg', '.jpg', '2020-03-16 10:38:46', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e13539fa0014.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e135b0b60018', '6.jpg', '.jpg', '2020-03-16 10:39:17', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e135b0b10017.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e1361910001b', '34ddf402a3085f99550c4ffae08e15d075531.png', '.png', '2020-03-16 10:39:43', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e1361905001a.png', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e136e1d6001d', '5fa5e5e1785710c167944cf4811a471214324.jpg', '.jpg', '2020-03-16 10:40:35', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e136e1a5001c.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e137da860020', '5fa5e5e1785710c167944cf4811a471214324.jpg', '.jpg', '2020-03-16 10:41:38', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e137da56001f.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e13851a10023', '7b61308f190057fa1c069a6a97cf5ce1348510.jpg', '.jpg', '2020-03-16 10:42:09', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e13851380022.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e138a39c0026', 'faa25abf43c76e304d2eff61ab695c06379135.jpg', '.jpg', '2020-03-16 10:42:30', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e138a3970025.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e13968200029', 'a.png', '.png', '2020-03-16 10:43:20', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e13967ea0028.png', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e13a5daa002c', '5.jpg', '.jpg', '2020-03-16 10:44:23', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e13a5d9d002b.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e13ad8f3002f', '3.jpg', '.jpg', '2020-03-16 10:44:55', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e13ad8eb002e.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e13b41b10032', '5086354280d89475791a498161b9f62912288.jpg', '.jpg', '2020-03-16 10:45:21', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e13b41820031.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e13bdee20035', '63c2065910fc176df3dd6e4f5f1ca2dc66586.jpg', '.jpg', '2020-03-16 10:46:02', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e13bded80034.jpg', '0');
INSERT INTO `sys_files` VALUES ('402881a570e1191e0170e13c41710038', 'a.png', '.png', '2020-03-16 10:46:27', 'D:/eclise_workspace/images/', '2020/03/16/402881a570e1191e0170e13c416b0037.png', '0');

-- ----------------------------
-- Table structure for sys_users
-- ----------------------------
DROP TABLE IF EXISTS `sys_users`;
CREATE TABLE `sys_users` (
  `id` varchar(64) NOT NULL,
  `login_name` varchar(64) DEFAULT NULL,
  `login_pwd` varchar(64) DEFAULT NULL,
  `real_name` varchar(64) DEFAULT NULL,
  `tel` varchar(64) DEFAULT NULL,
  `photo_id` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `user_type` int(11) DEFAULT '0' COMMENT '用户类型',
  `db_status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_users
-- ----------------------------
INSERT INTO `sys_users` VALUES ('1', '1', '1', null, null, null, null, '0', '0');
INSERT INTO `sys_users` VALUES ('2c9f8c2c544db55001544dbd0ca70001', '13307739443', null, null, '13307739443', null, null, '1', '0');
INSERT INTO `sys_users` VALUES ('4028819570d6e2840170d6e4a3790004', '15177553656', '123456', '', '15177553656', '4028819570d82da70170d82f45f10009', '', '1', '0');
INSERT INTO `sys_users` VALUES ('402883f1548b398401548b3a18310001', 'test1', 'test1', 'test1', null, null, null, '0', '0');
INSERT INTO `sys_users` VALUES ('402883f1548b398401548b3a183c0002', 'test2', 'test2', 'test2', null, null, null, '0', '0');
INSERT INTO `sys_users` VALUES ('402884e65450dd8d015450e55d0d0002', '15607732513', '123456', '陆珊莉', '15607732513', '402881a570e1191e0170e130544d0002', '15607732513@163.COM', '1', '0');
INSERT INTO `sys_users` VALUES ('402884e7547c0db901547c2352c50001', '15607732017', null, null, '15607732017', null, null, '1', '0');
INSERT INTO `sys_users` VALUES ('402884ea54a93e840154a94aa6b10002', '15607732018', null, null, '15607732018', null, null, '1', '0');
INSERT INTO `sys_users` VALUES ('402884ea54a93e840154a9762c420004', null, '', null, '', null, '', '0', '0');
INSERT INTO `sys_users` VALUES ('402884ea54a93e840154a97730a60005', null, '', null, '', null, '', '0', '0');
INSERT INTO `sys_users` VALUES ('402889ed547a846a01547aa8cdba0001', '15607732014', null, null, '15607732014', null, null, '1', '0');
INSERT INTO `sys_users` VALUES ('402889ed547a846a01547aaa4d9a0005', '15607732015', '123456', '', '15607732015', '402884e7549e5d9301549e82bbb20005', '', '1', '0');
INSERT INTO `sys_users` VALUES ('402889ed547a846a01547aac374f0009', '15607732016', '123456', '', '15607732016', '402881a570e1191e0170e13c41710038', '', '1', '0');
INSERT INTO `sys_users` VALUES ('402890f0536b5d8501536b5dbace0001', 'admin', 'admin', '管理员', '15607732013', '40288de65443540d0154436267a70002', '15607732513@163.com', '2', '0');
INSERT INTO `sys_users` VALUES ('ff808081547ebd2701547ecc7c2b0001', '13077670902', '123456', '陈文文', '13077670902', '402881a570e1191e0170e1361910001b', '', '1', '0');
INSERT INTO `sys_users` VALUES ('ff808081547ebd2701547ed162da0002', '11111111111', '11111111111', null, '111111111', null, '111111111', '0', '0');
