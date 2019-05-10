/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : restaurant

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2019-05-10 15:35:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for canteen
-- ----------------------------
DROP TABLE IF EXISTS `canteen`;
CREATE TABLE `canteen` (
  `canteen_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '店铺id',
  `store_id` int(32) DEFAULT NULL COMMENT '店铺id',
  `city_id` int(255) DEFAULT NULL COMMENT '城市id',
  `canteen_name` varchar(255) DEFAULT NULL COMMENT '餐厅名称',
  `tag_dosc` varchar(255) DEFAULT NULL COMMENT '标签描述',
  `current_lng_lat` varchar(255) DEFAULT NULL COMMENT '餐厅经纬度',
  `comment_score` int(1) DEFAULT NULL COMMENT '店铺评分',
  `address` varchar(255) DEFAULT NULL COMMENT '店铺地址',
  `phone` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `business_hours` varchar(20) DEFAULT NULL COMMENT '营业时间',
  `canteen_hint` varchar(255) DEFAULT NULL COMMENT '提示',
  `crowd_state` int(1) DEFAULT NULL COMMENT '拥挤状态，1火爆，2拥挤，3，空闲',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`canteen_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=gbk COMMENT='餐厅表';

-- ----------------------------
-- Records of canteen
-- ----------------------------
INSERT INTO `canteen` VALUES ('1', '1', '1', '小熊美食总店(壬丰大夏)', '西餐', '113.341512,23.138541', '3', '天河南二路33号丰兴广场首层华润万家超市隔壁', '020-12345678', '8:00-22:00', '听到叫号请到迎宾台，过号请重新取号', '1', null);
INSERT INTO `canteen` VALUES ('2', '1', '2', '小熊美食(太古汇)', '西餐', '113.339166,23.13989', '2', '天河南二路33号丰兴广场首层华润万家超市隔壁', '020-12345678', '11:00-22:00', '听到叫号请到迎宾台，过号请重新取号', '1', null);
INSERT INTO `canteen` VALUES ('3', '1', '3', '小熊美食(天河南二路店)', '西餐', '113.339849,23.138373', '2', '天河南二路33号丰兴广场首层华润万家超市隔壁', '020-12345678', '11:00-22:00', '听到叫号请到迎宾台，过号请重新取号', '1', null);
INSERT INTO `canteen` VALUES ('4', '1', '1', '小熊美食(天河南二路店)', '西餐', '113.340927,23.139611', '2', '天河南二路33号丰兴广场首层华润万家超市隔壁', '020-12345678', '11:00-22:00', '听到叫号请到迎宾台，过号请重新取号', '1', null);
INSERT INTO `canteen` VALUES ('5', '1', '2', '小熊美食(天河南二路店)', '西餐', '113.342607,23.139927', '2', '天河南二路33号丰兴广场首层华润万家超市隔壁', '020-12345678', '11:00-22:00', '听到叫号请到迎宾台，过号请重新取号', '1', null);
INSERT INTO `canteen` VALUES ('6', '1', '3', '小熊美食(天河南二路店)', '西餐', '113.343388,23.142386', '2', '天河南二路33号丰兴广场首层华润万家超市隔壁', '020-12345678', '11:00-22:00', '听到叫号请到迎宾台，过号请重新取号', '1', null);
INSERT INTO `canteen` VALUES ('7', '1', '1', '小熊美食(天河南二路店)', '西餐', '113.331288,23.14251', '2', '天河南二路33号丰兴广场首层华润万家超市隔壁', '020-12345678', '11:00-22:00', '听到叫号请到迎宾台，过号请重新取号', '1', null);
INSERT INTO `canteen` VALUES ('8', '1', '2', '小熊美食(天河南二路店)', '西餐', '113.331082,23.156001', '2', '天河南二路33号丰兴广场首层华润万家超市隔壁', '020-12345678', '11:00-22:00', '听到叫号请到迎宾台，过号请重新取号', '1', null);
INSERT INTO `canteen` VALUES ('9', '1', '3', '小熊美食(天河南二路店)', '西餐', '113.413438,23.137658', '2', '天河南二路33号丰兴广场首层华润万家超市隔壁', '020-12345678', '11:00-22:00', '听到叫号请到迎宾台，过号请重新取号', '1', null);
INSERT INTO `canteen` VALUES ('10', '1', '1', '小熊美食(天河南二路店)', '西餐', '113.435788,23.120443', '2', '天河南二路33号丰兴广场首层华润万家超市隔壁', '020-12345678', '11:00-22:00', '听到叫号请到迎宾台，过号请重新取号', '1', null);

-- ----------------------------
-- Table structure for canteen_comment
-- ----------------------------
DROP TABLE IF EXISTS `canteen_comment`;
CREATE TABLE `canteen_comment` (
  `comment_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `canteen_id` int(32) DEFAULT NULL COMMENT '餐厅id',
  `comment_level` int(1) DEFAULT NULL COMMENT '评论等级',
  `comment_content` varchar(255) DEFAULT NULL COMMENT '评论内容',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COMMENT='店铺评论';

-- ----------------------------
-- Records of canteen_comment
-- ----------------------------
INSERT INTO `canteen_comment` VALUES ('1', '1', '3', 'ddddddd');

-- ----------------------------
-- Table structure for canteen_type
-- ----------------------------
DROP TABLE IF EXISTS `canteen_type`;
CREATE TABLE `canteen_type` (
  `type_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '餐桌id',
  `canteen_id` int(11) DEFAULT NULL COMMENT '餐厅id',
  `desk_name` varchar(255) DEFAULT NULL COMMENT '餐桌名称',
  `desk_num` varchar(255) DEFAULT NULL COMMENT '餐桌人数',
  `waiting_time` varchar(255) DEFAULT NULL COMMENT '等待时间',
  `dinner_num` varchar(10) DEFAULT NULL COMMENT '桌号,A是1-2人，B是3-4人，C是5-8人，D是9人以上',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_date` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk COMMENT='餐桌表';

-- ----------------------------
-- Records of canteen_type
-- ----------------------------
INSERT INTO `canteen_type` VALUES ('1', '1', '小桌', '1-2人', '15', 'A', '2019-02-25 00:00:00', '2019-02-25 00:00:00');
INSERT INTO `canteen_type` VALUES ('2', '1', '中桌', '3-4人', '15', 'B', '2019-02-25 00:00:00', '2019-02-25 00:00:00');
INSERT INTO `canteen_type` VALUES ('3', '1', '大桌', '5-8人', '30', 'C', '2019-02-25 00:00:00', '2019-02-25 00:00:00');
INSERT INTO `canteen_type` VALUES ('4', '1', '特大桌', '9人', '30', 'D', '2019-02-25 00:00:00', '2019-02-25 00:00:00');

-- ----------------------------
-- Table structure for card_canteen
-- ----------------------------
DROP TABLE IF EXISTS `card_canteen`;
CREATE TABLE `card_canteen` (
  `card_canteen_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '卡卷餐厅id',
  `canteen_id` int(32) DEFAULT NULL COMMENT '餐厅id',
  `card_id` int(32) DEFAULT NULL COMMENT '卡卷id',
  PRIMARY KEY (`card_canteen_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk COMMENT='卡卷关联餐厅';

-- ----------------------------
-- Records of card_canteen
-- ----------------------------
INSERT INTO `card_canteen` VALUES ('1', '1', '1');
INSERT INTO `card_canteen` VALUES ('2', '2', '1');
INSERT INTO `card_canteen` VALUES ('3', '3', '1');

-- ----------------------------
-- Table structure for card_rule
-- ----------------------------
DROP TABLE IF EXISTS `card_rule`;
CREATE TABLE `card_rule` (
  `rule_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '卡卷规则id',
  `card_id` int(32) DEFAULT NULL COMMENT '卡卷id',
  `rule_comtent` varchar(255) DEFAULT NULL COMMENT '规则内容',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk COMMENT='卡卷规则';

-- ----------------------------
-- Records of card_rule
-- ----------------------------
INSERT INTO `card_rule` VALUES ('1', '1', '1、凭此券可获得价值600元的意式浓缩咖啡一份', '2019-03-01 17:00:12');
INSERT INTO `card_rule` VALUES ('2', '1', '2、每张单限用一张卡券；', '2019-03-01 17:00:26');
INSERT INTO `card_rule` VALUES ('3', '1', '3、不可与其他卡券同时使用', '2019-03-01 17:00:38');
INSERT INTO `card_rule` VALUES ('4', '1', '4、可以用储值买单。', '2019-03-01 17:00:50');

-- ----------------------------
-- Table structure for card_shopping
-- ----------------------------
DROP TABLE IF EXISTS `card_shopping`;
CREATE TABLE `card_shopping` (
  `card_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '卡卷id',
  `canteen_id` int(32) DEFAULT NULL COMMENT '餐厅id',
  `card_name` varchar(50) DEFAULT NULL COMMENT '卡卷名称',
  `card_image` varchar(255) DEFAULT NULL COMMENT '卡卷图片',
  `card_integration` int(10) DEFAULT NULL COMMENT '卡卷积分',
  `card_sum` int(10) DEFAULT NULL COMMENT '卡卷金额',
  `card_explain` varchar(255) DEFAULT NULL COMMENT '卡卷说明',
  `useful_life` varchar(50) DEFAULT NULL COMMENT '有效期',
  `has_hot` int(1) DEFAULT NULL COMMENT '是否热销,0否，1是',
  `card_dosc` varchar(255) DEFAULT NULL COMMENT '卡卷简介',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`card_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk COMMENT='卡卷商城';

-- ----------------------------
-- Records of card_shopping
-- ----------------------------
INSERT INTO `card_shopping` VALUES ('1', '1', '意式浓缩咖啡', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '150', '20', ' 不可与其他卡券同时使用，每张单仅限用一次', '2018.12.25-2018.01.31', '0', '源自马来西亚咖啡豆，以92摄氏度的热水，借由9bar高压冲过研磨成很细的咖啡粉末来冲出美味的咖啡。', '2019-03-01 11:20:34');
INSERT INTO `card_shopping` VALUES ('2', '1', '意式浓缩咖啡2', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '130', '0', ' 不可与其他卡券同时使用，每张单仅限用一次', '2018.12.25-2018.01.31', '1', '源自马来西亚咖啡豆，以92摄氏度的热水，借由9bar高压冲过研磨成很细的咖啡粉末来冲出美味的咖啡。', '2019-03-01 11:20:59');
INSERT INTO `card_shopping` VALUES ('3', '1', '意式浓缩咖啡3', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '140', '14', '不可与其他卡券同时使用，每张单仅限用一次。', '2018.12.25-2018.01.31', '2', '源自马来西亚咖啡豆，以92摄氏度的热水，借由9bar高压冲过研磨成很细的咖啡粉末来冲出美味的咖啡。', '2019-03-01 11:34:17');

-- ----------------------------
-- Table structure for city
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `city_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '城市id',
  `city_name` varchar(255) DEFAULT NULL COMMENT '城市名称',
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk COMMENT='餐厅所属城市';

-- ----------------------------
-- Records of city
-- ----------------------------
INSERT INTO `city` VALUES ('1', '广州');
INSERT INTO `city` VALUES ('2', '佛山');
INSERT INTO `city` VALUES ('3', '上海');

-- ----------------------------
-- Table structure for dinner_record
-- ----------------------------
DROP TABLE IF EXISTS `dinner_record`;
CREATE TABLE `dinner_record` (
  `record_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '记录id',
  `user_id` int(32) DEFAULT NULL COMMENT '用户id',
  `dinner_date` datetime DEFAULT NULL COMMENT '用餐时间',
  `dinner_sum` varchar(10) DEFAULT NULL COMMENT '买单人',
  `pay_name` varchar(255) DEFAULT NULL COMMENT '用餐人',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk COMMENT='用餐表';

-- ----------------------------
-- Records of dinner_record
-- ----------------------------
INSERT INTO `dinner_record` VALUES ('1', '1', '2019-03-04 14:20:00', '530.09', '亦客', '2019-03-04 14:20:25');
INSERT INTO `dinner_record` VALUES ('2', '1', '2019-03-04 14:44:45', '420.25', '亦客', '2019-03-04 14:44:56');

-- ----------------------------
-- Table structure for food_classify
-- ----------------------------
DROP TABLE IF EXISTS `food_classify`;
CREATE TABLE `food_classify` (
  `classify_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `classify_name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`classify_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=gbk COMMENT='菜品分类';

-- ----------------------------
-- Records of food_classify
-- ----------------------------
INSERT INTO `food_classify` VALUES ('1', '热销', '2019-03-05 10:08:47');
INSERT INTO `food_classify` VALUES ('2', '套餐', '2019-03-05 10:09:07');
INSERT INTO `food_classify` VALUES ('3', '折扣', '2019-03-05 10:09:38');
INSERT INTO `food_classify` VALUES ('4', '扒类', '2019-03-05 10:09:55');
INSERT INTO `food_classify` VALUES ('5', '小食', '2019-03-05 10:10:10');

-- ----------------------------
-- Table structure for food_good
-- ----------------------------
DROP TABLE IF EXISTS `food_good`;
CREATE TABLE `food_good` (
  `good_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '单品菜',
  `classify_id` int(32) DEFAULT NULL COMMENT '分类id',
  `canteen_id` int(32) DEFAULT NULL COMMENT '餐厅id',
  `good_name` varchar(255) DEFAULT NULL COMMENT '菜品名称',
  `good_image` varchar(255) DEFAULT NULL COMMENT '菜品图片',
  `good_type` varchar(255) DEFAULT NULL COMMENT '菜品类型',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `original_price` decimal(10,2) DEFAULT NULL COMMENT '原价',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`good_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of food_good
-- ----------------------------
INSERT INTO `food_good` VALUES ('1', '1', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('2', '1', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('3', '1', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.06', '78.00', null);
INSERT INTO `food_good` VALUES ('4', '1', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.08', '78.00', null);
INSERT INTO `food_good` VALUES ('5', '1', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.78', '78.00', null);
INSERT INTO `food_good` VALUES ('6', '1', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('7', '1', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('8', '1', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('9', '1', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('10', '1', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('11', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('12', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('13', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('14', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('15', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('16', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('17', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('18', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('19', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('20', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('21', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('22', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('23', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('24', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('25', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('26', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('27', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('28', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('29', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('30', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('31', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('32', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('33', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('34', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('35', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('36', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('37', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('38', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('39', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);
INSERT INTO `food_good` VALUES ('40', '2', '1', '黑椒厚切嫩牛排', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png', '份', '59.00', '78.00', null);

-- ----------------------------
-- Table structure for integration_acquire
-- ----------------------------
DROP TABLE IF EXISTS `integration_acquire`;
CREATE TABLE `integration_acquire` (
  `acquire_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '获取id',
  `user_id` int(32) DEFAULT NULL COMMENT '用户id',
  `canteen_name` varchar(50) DEFAULT NULL COMMENT '餐厅名称',
  `consume_sum` int(10) DEFAULT NULL COMMENT '消费金额',
  `acquire_integration` int(10) DEFAULT NULL COMMENT '获得积分',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`acquire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk COMMENT='积分获取';

-- ----------------------------
-- Records of integration_acquire
-- ----------------------------
INSERT INTO `integration_acquire` VALUES ('1', '1', '小熊美食总店(壬丰大夏)', '635', '635', '2019-03-01 10:52:49');
INSERT INTO `integration_acquire` VALUES ('2', '1', '天河二路店', '500', '500', '2019-03-01 11:06:12');

-- ----------------------------
-- Table structure for integration_rule
-- ----------------------------
DROP TABLE IF EXISTS `integration_rule`;
CREATE TABLE `integration_rule` (
  `rule_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '规则id',
  `rule_name` varchar(255) DEFAULT NULL COMMENT '规则名称',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk COMMENT='积分规则';

-- ----------------------------
-- Records of integration_rule
-- ----------------------------
INSERT INTO `integration_rule` VALUES ('1', '1、消费1元等于1积分。', '2019-03-01 10:31:23');
INSERT INTO `integration_rule` VALUES ('2', '1、消费1元等于1积分。', '2019-03-01 10:42:28');

-- ----------------------------
-- Table structure for my_coupon
-- ----------------------------
DROP TABLE IF EXISTS `my_coupon`;
CREATE TABLE `my_coupon` (
  `coupon_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '优惠卷id',
  `card_id` int(32) DEFAULT NULL COMMENT '卡卷id',
  `user_id` int(32) DEFAULT NULL COMMENT '用户id',
  `coupon_num` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `convert_date` datetime DEFAULT NULL COMMENT '兑换日期',
  `is_expend` int(1) DEFAULT NULL COMMENT '是否已用，0未用，1已用，2失效',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk COMMENT='我的优惠卷';

-- ----------------------------
-- Records of my_coupon
-- ----------------------------
INSERT INTO `my_coupon` VALUES ('1', '1', '1', '1100598014637', '2019-03-01 11:25:39', '0', '2019-03-01 11:25:44');
INSERT INTO `my_coupon` VALUES ('2', '2', '1', '1100598014638', '2019-03-01 11:26:08', '1', '2019-03-01 11:26:13');
INSERT INTO `my_coupon` VALUES ('3', '3', '1', '1100598014638', '2019-03-01 11:33:45', '2', '2019-03-01 11:33:47');

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '支付id',
  `canteens_id` int(32) DEFAULT NULL COMMENT '餐厅id',
  `user_id` int(32) DEFAULT NULL COMMENT '用户id',
  `order_num` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `order_date` date DEFAULT NULL COMMENT '订单日期',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk COMMENT='支付订单';

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('1', '1', '1', '2019030817461392786', '2019-03-08', '2019-03-08 17:46:13');
INSERT INTO `order` VALUES ('3', '1', '1', '2019031114333128468', '2019-03-11', '2019-03-11 14:33:31');

-- ----------------------------
-- Table structure for order_form
-- ----------------------------
DROP TABLE IF EXISTS `order_form`;
CREATE TABLE `order_form` (
  `form_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_id` int(32) DEFAULT NULL COMMENT '订单id',
  `good_id` int(32) DEFAULT NULL COMMENT '菜品id',
  `good_num` int(10) DEFAULT NULL COMMENT '菜品数量',
  `is_add` int(1) DEFAULT NULL COMMENT '是否加菜，0不是，1是',
  `is_pay` int(1) DEFAULT NULL COMMENT '是否支付,0否，1是',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`form_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=gbk ROW_FORMAT=FIXED COMMENT='订单菜品表';

-- ----------------------------
-- Records of order_form
-- ----------------------------
INSERT INTO `order_form` VALUES ('41', '3', '3', '1', '1', '1', '2019-03-11 17:12:03');
INSERT INTO `order_form` VALUES ('8', '1', '1', '1', '0', '1', '2019-03-08 17:52:37');
INSERT INTO `order_form` VALUES ('11', '1', '1', '6', '1', '1', '2019-03-08 17:54:12');
INSERT INTO `order_form` VALUES ('28', '1', '2', '1', '1', '1', '2019-03-08 18:47:15');
INSERT INTO `order_form` VALUES ('34', '3', '5', '1', '0', '1', '2019-03-11 14:33:31');
INSERT INTO `order_form` VALUES ('40', '3', '2', '3', '1', '1', '2019-03-11 17:12:03');
INSERT INTO `order_form` VALUES ('39', '3', '1', '1', '1', '1', '2019-03-11 17:12:03');

-- ----------------------------
-- Table structure for queue_online
-- ----------------------------
DROP TABLE IF EXISTS `queue_online`;
CREATE TABLE `queue_online` (
  `queue_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '排队id',
  `canteen_id` int(32) DEFAULT NULL COMMENT '餐厅id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `type_id` int(11) DEFAULT NULL COMMENT '餐桌id',
  `desk_num` int(11) DEFAULT NULL COMMENT '就餐人数',
  `dining_num` varchar(10) DEFAULT NULL COMMENT '排队号',
  `queue_status` int(1) DEFAULT NULL COMMENT '取号状态，1已取号，0已取消，-1已失效',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_date` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`queue_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=gbk COMMENT='排队表';

-- ----------------------------
-- Records of queue_online
-- ----------------------------
INSERT INTO `queue_online` VALUES ('1', '1', '1', '1', '1', 'A1', '0', '2019-03-14 00:00:00', '2019-03-14 10:43:44');
INSERT INTO `queue_online` VALUES ('2', '1', '1', '1', '1', 'A2', '0', '2019-03-14 00:00:00', '2019-03-14 10:43:53');
INSERT INTO `queue_online` VALUES ('3', '1', '1', '1', '1', 'A3', '0', '2019-03-14 00:00:00', '2019-03-14 10:45:27');
INSERT INTO `queue_online` VALUES ('4', '1', '2', '1', '1', 'A4', '0', '2019-03-14 10:45:16', null);
INSERT INTO `queue_online` VALUES ('5', '1', '1', '1', '1', 'A5', '0', '2019-03-14 10:45:34', '2019-03-14 10:56:29');
INSERT INTO `queue_online` VALUES ('6', '1', '1', '1', '1', 'A6', '0', '2019-03-14 10:56:33', '2019-03-14 11:03:19');
INSERT INTO `queue_online` VALUES ('7', '1', '1', '1', '1', 'A7', '0', '2019-03-14 11:03:22', '2019-03-14 11:15:18');
INSERT INTO `queue_online` VALUES ('8', '1', '1', '1', '1', 'A8', '0', '2019-03-14 11:18:25', '2019-03-14 11:37:57');
INSERT INTO `queue_online` VALUES ('9', '1', '1', '3', '7', 'C1', '0', '2019-03-14 11:40:01', '2019-03-14 11:41:50');
INSERT INTO `queue_online` VALUES ('10', '1', '1', '1', '1', 'A9', '0', '2019-03-14 11:42:00', '2019-03-14 11:42:20');
INSERT INTO `queue_online` VALUES ('11', '1', '1', '4', '11', 'D1', '0', '2019-03-14 11:51:55', '2019-03-14 14:55:42');
INSERT INTO `queue_online` VALUES ('12', '1', '1', '4', '27', 'D2', '1', '2019-03-14 14:58:11', null);
INSERT INTO `queue_online` VALUES ('13', '1', '1', '1', '1', 'A1', '1', '2019-03-19 12:20:57', null);

-- ----------------------------
-- Table structure for store
-- ----------------------------
DROP TABLE IF EXISTS `store`;
CREATE TABLE `store` (
  `store_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '店铺id',
  `store_name` varchar(50) DEFAULT NULL COMMENT '店铺名',
  `store_logo` varchar(255) DEFAULT NULL COMMENT '店铺logo',
  `canteen_logo` varchar(255) DEFAULT NULL COMMENT '餐厅头像',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COMMENT='店铺';

-- ----------------------------
-- Records of store
-- ----------------------------
INSERT INTO `store` VALUES ('1', '小熊美食', 'http://127.0.0.1/restaurantAdmin/public/images/tem/storlogo.png', 'http://127.0.0.1/restaurantAdmin/public/images/tem/logo.png', '2019-03-04 15:06:12');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(32) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名称',
  `phone` varchar(11) DEFAULT NULL COMMENT '用户手机号码',
  `user_logo` varchar(255) DEFAULT NULL COMMENT '用户logo',
  `birthday` date DEFAULT NULL COMMENT '用户生日',
  `user_card` varchar(255) DEFAULT NULL COMMENT '会员卡',
  `accumulative_integral` int(10) DEFAULT NULL COMMENT '累计积分',
  `usable_integral` int(10) DEFAULT NULL COMMENT '可用积分',
  `create_date` datetime DEFAULT NULL COMMENT '创建时间',
  `update_date` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '亦客', '13632482567', 'http://127.0.0.1/restaurantAdmin/public/images/tem/tx.png', '2019-03-04', 'http://192.168.1.8/restaurantAdmin/public/images/clubCard/clubCard.png', '500', '300', '2019-02-28 11:14:51', null);
