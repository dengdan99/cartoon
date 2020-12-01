/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50731
Source Host           : localhost:3306
Source Database       : cartoon

Target Server Type    : MYSQL
Target Server Version : 50731
File Encoding         : 65001

Date: 2020-10-15 21:06:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for xwx_extra_config
-- ----------------------------
DROP TABLE IF EXISTS `xwx_extra_config`;
CREATE TABLE `xwx_extra_config` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `val` text COLLATE utf8mb4_unicode_ci,
  `create_time` bigint(255) DEFAULT NULL,
  `update_time` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='平台配置';

-- ----------------------------
-- Records of xwx_extra_config
-- ----------------------------
INSERT INTO `xwx_extra_config` VALUES ('1', 'site_name', '悟空漫画', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('2', 'schema', 'http://', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('3', 'domain', 'm.mh.fanyuwangluo.com', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('4', 'img_domain', 'dfs.w.fanyuwangluo.com/', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('5', 'mobile_domain', 'm.mh.fanyuwangluo.com', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('6', 'mip_domain', 'mip.mh.fanyuwangluo.com', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('7', 'admin_domain', 'admin.mh.fanyuwangluo.com', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('8', 'api_domain', 'api.mh.fanyuwangluo.com', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('9', 'app_domain', 'app.mh.fanyuwangluo.com', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('10', 'salt', 'hanmantai', '1602756049', '1602758449');
INSERT INTO `xwx_extra_config` VALUES ('11', 'api_key', 'hahmh', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('12', 'app_key', 'hahmh', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('13', 'front_tpl', 'default', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('14', 'cdn', 'bootcdn', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('15', 'back_end_page', '10', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('16', 'img_per_page', '0', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('17', 'booklist_page', '12', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('19', 'book_end_point', 'id', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('20', 'name_format', 'pure', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('21', 'sitemap_gen_num', '1000', '1602756049', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('22', 'baidu_js', '<script>console.log(\"测试js代码测试修改\"+\'测试\'+\'test\')</script>', '1602756049', '1602758414');
INSERT INTO `xwx_extra_config` VALUES ('69', 'money_unit_text', '金币', '1602758185', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('70', 'money_unit_m', '100', '1602758185', '1602758185');
INSERT INTO `xwx_extra_config` VALUES ('71', 'payment_list', '[\r\n    \'default\' => [ \r\n        \'channel\' => [\r\n        ]\r\n    ],\r\n    \'pay\' => [\r\n        \'appid\' => \'\',\r\n        \'mchid\' => \'mhzf342\',\r\n        \'appkey\' => \'arcoIJzQvB79mIirzAxrhHy2yYAaW1gL\',\r\n        \'channel\' => [\r\n            [\'type\' => 1, \'code\' => 1, \'img\' => \'zhi\', \'title\' => \'支付宝\',\'class\'=>\'pay-box2\'],\r\n            [\'type\' => 2, \'code\' => 3, \'img\' => \'weixin\', \'title\' => \'微信支付\',\'class\'=>\'pay-box\']\r\n        ]\r\n    ],\r\n    \'kami\' => [\r\n        \'url\' => \'\' \r\n    ],\r\n    \'vip\' => [  \r\n        [\'month\' => 1, \'price\' => 5],\r\n        [\'month\' => 6, \'price\' => 100],\r\n        [\'month\' => 12, \'price\' => 400]\r\n    ],\r\n    \'charge_money\' => [\r\n        [\'days\'=>1,\'price\'=>49,\'extra\'=>0,\'icon\'=>\'热销\',\'text1\'=>\'VIP1天\',\'text2\'=>\'多福多寿\',\'img\'=>\'/static/images/zuan.png\',\'type\'=>1],\r\n        [\'days\'=>30,\'price\'=>99,\'extra\'=>15,\'icon\'=>\'热销\',\'text1\'=>\'VIP45天\',\'text2\'=>\'月卡加半月\',\'img\'=>\'/static/images/zuan.png\',\'type\'=>1],\r\n        [\'days\'=>90,\'price\'=>199,\'extra\'=>30,\'icon\'=>\'热销\',\'text1\'=>\'VIP120天\',\'text2\'=>\'季度加一个月\',\'img\'=>\'/static/images/zuan.png\',\'type\'=>1],\r\n        [\'days\'=>180,\'price\'=>399,\'extra\'=>0,\'icon\'=>\'热销\',\'text1\'=>\'VIP180天\',\'text2\'=>\'半年\',\'img\'=>\'/static/images/zuan.png\',\'type\'=>1],\r\n        [\'days\'=>36500,\'price\'=>499,\'extra\'=>3650,\'icon\'=>\'热销1\',\'text1\'=>\'VIP40150天\',\'text2\'=>\'110年\',\'img\'=>\'/static/images/zuan.png\',\'type\'=>1],\r\n        [\'days\'=>0,\'price\'=>49,\'extra\'=>0,\'icon\'=>\'热销\',\'text1\'=>\'4900金币\',\'text2\'=>\'1元等于100金币\',\'img\'=>\'/static/images/jinbi.png\',\'type\'=>2],\r\n        [\'days\'=>0,\'price\'=>69,\'extra\'=>39,\'icon\'=>\'热销\',\'text1\'=>\'6900+3900金币\',\'text2\'=>\'1元等于100金币\',\'img\'=>\'/static/images/jinbi.png\',\'type\'=>2],\r\n        [\'days\'=>0,\'price\'=>99,\'extra\'=>69,\'icon\'=>\'热销\',\'text1\'=>\'9900+6900金币\',\'text2\'=>\'1元等于100金币\',\'img\'=>\'/static/images/jinbi.png\',\'type\'=>2],\r\n    ],\r\n    \'money\' => [1, 5, 10, 30, 50],\r\n    \'promotional_rewards_rate\' => 0.1,\r\n    \'reg_rewards\' => 1, \r\n    \'mobile_bind_rewards\' => 0, \r\n    \'pay_type\'=>[1=>\'支付宝\',2=>\'微信\',3=>\'QQ\',4=>\'卡密\',5=>\'PayPal\'],\r\n]', '1602759991', '1602763033');
