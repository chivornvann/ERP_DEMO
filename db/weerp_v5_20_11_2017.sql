/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1_3306
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : weerp_v5

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-11-20 22:54:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sma_addresses
-- ----------------------------
DROP TABLE IF EXISTS `sma_addresses`;
CREATE TABLE `sma_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `line1` varchar(50) NOT NULL,
  `line2` varchar(50) DEFAULT NULL,
  `city` varchar(25) NOT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `state` varchar(25) NOT NULL,
  `country` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_addresses
-- ----------------------------

-- ----------------------------
-- Table structure for sma_adjustments
-- ----------------------------
DROP TABLE IF EXISTS `sma_adjustments`;
CREATE TABLE `sma_adjustments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` text,
  `attachment` varchar(55) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_adjustments
-- ----------------------------
INSERT INTO `sma_adjustments` VALUES ('1', '2017-11-20 19:49:00', 'PR/2017/11/0001', '1', '', null, '1', null, null, null);
INSERT INTO `sma_adjustments` VALUES ('2', '2017-11-20 20:09:00', 'PR/2017/11/0002', '1', '&lt;p&gt;Drink My Self&lt;&sol;p&gt;', null, '1', null, null, null);
INSERT INTO `sma_adjustments` VALUES ('3', '2017-11-20 20:36:00', 'PR/2017/11/0007', '1', '', null, '1', null, null, null);
INSERT INTO `sma_adjustments` VALUES ('4', '2017-11-20 20:41:00', 'PR/2017/11/0009', '1', '&lt;p&gt;test&lt;&sol;p&gt;', null, '1', null, null, null);

-- ----------------------------
-- Table structure for sma_adjustment_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_adjustment_items`;
CREATE TABLE `sma_adjustment_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adjustment_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `adjustment_id` (`adjustment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_adjustment_items
-- ----------------------------
INSERT INTO `sma_adjustment_items` VALUES ('1', '1', '1', null, '1.0000', '1', '', 'subtraction');
INSERT INTO `sma_adjustment_items` VALUES ('2', '2', '1', null, '1.0000', '1', '', 'subtraction');
INSERT INTO `sma_adjustment_items` VALUES ('3', '3', '1', null, '10.0000', '1', '', 'addition');
INSERT INTO `sma_adjustment_items` VALUES ('6', '4', '1', null, '0.0000', '1', '', 'subtraction');

-- ----------------------------
-- Table structure for sma_bom
-- ----------------------------
DROP TABLE IF EXISTS `sma_bom`;
CREATE TABLE `sma_bom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_bom
-- ----------------------------
INSERT INTO `sma_bom` VALUES ('11', 'test', '2017-10-31 07:19:00', '', '1', null);

-- ----------------------------
-- Table structure for sma_bom_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_bom_items`;
CREATE TABLE `sma_bom_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bom_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` decimal(25,4) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_id` (`bom_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_bom_items
-- ----------------------------
INSERT INTO `sma_bom_items` VALUES ('48', '11', '1', '1', 'C001', 'Fanta', '1.0000', 'deduct');
INSERT INTO `sma_bom_items` VALUES ('49', '11', '3', '2', 'C002', 'CoCa', '1.0000', 'add');

-- ----------------------------
-- Table structure for sma_brands
-- ----------------------------
DROP TABLE IF EXISTS `sma_brands`;
CREATE TABLE `sma_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_brands
-- ----------------------------
INSERT INTO `sma_brands` VALUES ('1', 'coca', 'CocaCola', 'f3229d107b2ceb47c2dc7bf95f2bc2be.png');

-- ----------------------------
-- Table structure for sma_calendar
-- ----------------------------
DROP TABLE IF EXISTS `sma_calendar`;
CREATE TABLE `sma_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `color` varchar(7) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_calendar
-- ----------------------------

-- ----------------------------
-- Table structure for sma_captcha
-- ----------------------------
DROP TABLE IF EXISTS `sma_captcha`;
CREATE TABLE `sma_captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `word` varchar(20) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_captcha
-- ----------------------------

-- ----------------------------
-- Table structure for sma_categories
-- ----------------------------
DROP TABLE IF EXISTS `sma_categories`;
CREATE TABLE `sma_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `image` varchar(55) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_categories
-- ----------------------------
INSERT INTO `sma_categories` VALUES ('2', 'D001', 'Drink', '0b79bf65ab2c6f6353ec1981490928e7.jpg', '0');

-- ----------------------------
-- Table structure for sma_combo_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_combo_items`;
CREATE TABLE `sma_combo_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `quantity` decimal(12,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_combo_items
-- ----------------------------

-- ----------------------------
-- Table structure for sma_companies
-- ----------------------------
DROP TABLE IF EXISTS `sma_companies`;
CREATE TABLE `sma_companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `group_name` varchar(20) NOT NULL,
  `customer_group_id` int(11) DEFAULT NULL,
  `customer_group_name` varchar(100) DEFAULT NULL,
  `name` varchar(55) NOT NULL,
  `company` varchar(255) NOT NULL,
  `vat_no` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(55) NOT NULL,
  `state` varchar(55) DEFAULT NULL,
  `postal_code` varchar(8) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cf1` varchar(100) DEFAULT NULL,
  `cf2` varchar(100) DEFAULT NULL,
  `cf3` varchar(100) DEFAULT NULL,
  `cf4` varchar(100) DEFAULT NULL,
  `cf5` varchar(100) DEFAULT NULL,
  `cf6` varchar(100) DEFAULT NULL,
  `invoice_footer` text,
  `payment_term` int(11) DEFAULT '0',
  `logo` varchar(255) DEFAULT 'logo.png',
  `award_points` int(11) DEFAULT '0',
  `deposit_amount` decimal(25,4) DEFAULT NULL,
  `price_group_id` int(11) DEFAULT NULL,
  `price_group_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `group_id_2` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_companies
-- ----------------------------
INSERT INTO `sma_companies` VALUES ('1', null, '3', 'customer', '1', 'General', 'Walk-in Customer', 'Walk-in Customer', '', 'Customer Address', 'Petaling Jaya', 'Selangor', '46000', 'Malaysia', '0123456789', 'customer@tecdiary.com', '', '', '', '', '', '', null, '0', 'logo.png', '0', null, null, null);
INSERT INTO `sma_companies` VALUES ('2', null, '4', 'supplier', null, null, 'Test Supplier', 'Supplier Company Name', null, 'Supplier Address', 'Petaling Jaya', 'Selangor', '46050', 'Malaysia', '0123456789', 'supplier@tecdiary.com', '-', '-', '-', '-', '-', '-', null, '0', 'logo.png', '0', null, null, null);
INSERT INTO `sma_companies` VALUES ('3', null, null, 'biller', null, null, 'Mian Saleem', 'Test Biller', '5555', 'Biller adddress', 'City', '', '', 'Country', '012345678', 'saleem@tecdiary.com', '', '', '', '', '', '', ' Thank you for shopping with us. Please come again', '0', 'logo1.png', '0', null, null, null);

-- ----------------------------
-- Table structure for sma_convert
-- ----------------------------
DROP TABLE IF EXISTS `sma_convert`;
CREATE TABLE `sma_convert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(55) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `noted` varchar(200) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `bom_id` int(11) DEFAULT NULL,
  `biller_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_convert
-- ----------------------------
INSERT INTO `sma_convert` VALUES ('1', '2017/11/0014', '2017-11-06 08:22:00', '', '1', '1', null, '11', '3');

-- ----------------------------
-- Table structure for sma_convert_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_convert_items`;
CREATE TABLE `sma_convert_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `convert_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` decimal(25,4) NOT NULL,
  `cost` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_id` (`convert_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_convert_items
-- ----------------------------
INSERT INTO `sma_convert_items` VALUES ('1', '1', '1', '1', 'C001', 'Fanta', '1.0000', '0.0000', 'deduct');
INSERT INTO `sma_convert_items` VALUES ('2', '1', '3', '2', 'C002', 'CoCa', '1.0000', '0.0000', 'add');

-- ----------------------------
-- Table structure for sma_costing
-- ----------------------------
DROP TABLE IF EXISTS `sma_costing`;
CREATE TABLE `sma_costing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sale_item_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `purchase_item_id` int(11) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `purchase_net_unit_cost` decimal(25,4) DEFAULT NULL,
  `purchase_unit_cost` decimal(25,4) DEFAULT NULL,
  `sale_net_unit_price` decimal(25,4) NOT NULL,
  `sale_unit_price` decimal(25,4) NOT NULL,
  `quantity_balance` decimal(15,4) DEFAULT NULL,
  `inventory` tinyint(1) DEFAULT '0',
  `overselling` tinyint(1) DEFAULT '0',
  `option_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_costing
-- ----------------------------
INSERT INTO `sma_costing` VALUES ('1', '2017-10-17', '1', '1', '1', '1', '100.0000', '4.0000', '4.0000', '0.5000', '0.5000', '0.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('4', '2017-10-18', '1', '5', '3', '9', '2.0000', '2.4138', '2.4138', '0.5000', '0.5000', '14.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('10', '2017-10-19', '1', '10', '5', '3', '0.0000', '2.4138', '2.4138', '0.5000', '0.5000', '0.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('11', '2017-10-19', '1', '12', '4', '3', '2.0000', '2.4138', '2.4138', '3.0000', '3.0000', '0.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('12', '2017-10-19', '1', '12', '4', null, '12.0000', '2.4138', '2.4138', '3.0000', '3.0000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('13', '0000-00-00', null, '12', '4', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('16', '2017-10-19', '1', '14', '7', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '99.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('17', '2017-10-19', '2', '15', '8', '11', '1.0000', '4.0000', '4.0000', '0.5000', '0.5000', '9.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('18', '2017-10-19', '2', '16', '9', '11', '1.0000', '4.0000', '4.0000', '0.5000', '0.5000', '8.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('19', '2017-10-19', '2', '17', '10', '11', '2.0000', '4.0000', '4.0000', '0.5000', '0.5000', '6.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('20', '2017-10-19', '2', '18', '11', '11', '1.0000', '4.0000', '4.0000', '0.5000', '0.5000', '5.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('22', '2017-10-19', '2', '20', '13', '11', '1.0000', '4.0000', '4.0000', '0.5000', '0.5000', '4.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('37', '2017-10-19', '3', '35', '14', '15', '10.0000', '0.4000', '0.4000', '0.5000', '0.5000', '21.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('47', '2017-10-19', '1', '45', '15', '10', '4.0000', '0.5000', '0.5000', '0.5000', '0.5000', '65.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('48', '2017-10-20', '3', '46', '16', '15', '12.0000', '0.4000', '0.4000', '6.0000', '6.0000', '9.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('49', '2017-10-20', '3', '47', '17', '15', '9.0000', '0.4000', '0.4000', '5.0000', '5.0000', '0.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('50', '2017-10-20', '3', '47', '17', null, '10.0000', '0.4000', '0.4000', '5.0000', '5.0000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('51', '2017-10-20', null, '47', '17', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('53', '2017-10-20', '1', '49', '18', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '64.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('54', '2017-10-19', '1', '50', '19', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '63.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('56', '2017-10-20', '1', '52', '20', '10', '5.0000', '0.5000', '0.5000', '50.0000', '50.0000', '58.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('57', '2017-10-28', '3', '53', '21', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('58', '2017-10-28', null, '53', '21', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('59', '2017-10-28', '1', '54', '21', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '57.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('60', '2017-10-28', '3', '55', '22', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('61', '2017-10-28', null, '55', '22', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('62', '2017-10-28', '1', '56', '22', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '56.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('63', '2017-11-15', '1', '57', '23', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '55.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('64', '2017-11-15', '1', '58', '24', '10', '1.0000', '0.5000', '0.5000', '0.2000', '0.2000', '54.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('65', '2017-11-16', '3', '59', '25', null, '2.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('66', '2017-11-16', null, '59', '25', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('67', '2017-11-16', '1', '60', '25', '10', '2.0000', '0.5000', '0.5000', '0.5000', '0.5000', '52.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('68', '2017-11-16', '3', '61', '26', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('69', '2017-11-16', null, '61', '26', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('70', '2017-11-16', '1', '62', '26', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '51.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('71', '2017-11-16', '3', '63', '26', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('72', '2017-11-16', null, '63', '26', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('73', '2017-11-16', '1', '64', '26', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '51.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('74', '2017-11-16', '1', '65', '27', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '49.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('75', '2017-11-16', '3', '66', '27', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('76', '2017-11-16', null, '66', '27', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('77', '2017-11-16', '3', '67', '27', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('78', '2017-11-16', null, '67', '27', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('79', '2017-11-16', '1', '68', '27', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '49.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('80', '2017-11-16', '3', '69', '28', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('81', '2017-11-16', null, '69', '28', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('82', '2017-11-16', '1', '70', '28', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '47.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('83', '2017-11-16', '3', '71', '28', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('84', '2017-11-16', null, '71', '28', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('85', '2017-11-16', '1', '72', '29', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '46.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('86', '2017-11-16', '3', '73', '29', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('87', '2017-11-16', null, '73', '29', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('88', '2017-11-16', '1', '74', '29', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '46.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('89', '2017-11-16', '1', '75', '30', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '44.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('90', '2017-11-16', '3', '76', '30', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('91', '2017-11-16', null, '76', '30', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('92', '2017-11-16', '1', '77', '30', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '44.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('93', '2017-11-17', '3', '78', '31', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('94', '2017-11-17', null, '78', '31', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('95', '2017-11-17', '3', '79', '32', null, '5.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('96', '2017-11-17', null, '79', '32', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('97', '2017-11-17', '1', '80', '32', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '42.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('98', '2017-11-17', '1', '81', '33', '10', '6.0000', '0.5000', '0.5000', '0.5000', '0.5000', '36.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('99', '2017-11-17', '3', '82', '33', null, '6.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('100', '2017-11-17', null, '82', '33', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('101', '2017-11-17', '1', '83', '34', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '35.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('102', '2017-11-17', '3', '84', '34', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('103', '2017-11-17', null, '84', '34', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('104', '2017-11-17', '1', '85', '35', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '34.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('105', '2017-11-17', '1', '86', '35', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '34.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('106', '2017-11-17', '3', '87', '35', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('107', '2017-11-17', null, '87', '35', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('108', '2017-11-17', '1', '88', '36', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '32.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('109', '2017-11-17', '3', '89', '36', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('110', '2017-11-17', null, '89', '36', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('111', '2017-11-17', '3', '90', '37', null, '6.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('112', '2017-11-17', null, '90', '37', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('113', '2017-11-17', '3', '91', '38', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('114', '2017-11-17', null, '91', '38', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('115', '2017-11-17', '3', '92', '38', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('116', '2017-11-17', null, '92', '38', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('117', '2017-11-17', '1', '93', '39', '10', '7.0000', '0.5000', '0.5000', '0.5000', '0.5000', '25.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('118', '2017-11-17', '3', '94', '39', null, '7.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('119', '2017-11-17', null, '94', '39', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('120', '2017-11-17', '1', '95', '40', '10', '3.0000', '0.5000', '0.5000', '0.5000', '0.5000', '22.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('121', '2017-11-17', '3', '96', '40', null, '3.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('122', '2017-11-17', null, '96', '40', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('123', '2017-11-17', '3', '97', '41', null, '10.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('124', '2017-11-17', null, '97', '41', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('125', '2017-11-17', '1', '98', '42', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '21.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('126', '2017-11-17', '1', '99', '43', '10', '8.0000', '0.5000', '0.5000', '0.5000', '0.5000', '13.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('127', '2017-11-17', '3', '100', '43', null, '7.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('128', '2017-11-17', null, '100', '43', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('129', '2017-11-17', '3', '101', '44', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('130', '2017-11-17', null, '101', '44', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('131', '2017-11-17', '1', '102', '44', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '12.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('132', '2017-11-17', '1', '103', '45', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '11.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('133', '2017-11-17', '3', '104', '45', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('134', '2017-11-17', null, '104', '45', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('135', '2017-11-17', '3', '105', '46', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('136', '2017-11-17', null, '105', '46', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('137', '2017-11-17', '1', '106', '46', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '10.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('138', '2017-11-17', '3', '107', '46', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('139', '2017-11-17', null, '107', '46', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('140', '2017-11-17', '1', '108', '47', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '9.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('141', '2017-11-17', '3', '109', '47', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('142', '2017-11-17', null, '109', '47', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('143', '2017-11-17', '1', '110', '48', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '8.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('144', '2017-11-17', '3', '111', '48', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('145', '2017-11-17', null, '111', '48', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('146', '2017-11-17', '1', '112', '49', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '7.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('147', '2017-11-17', '3', '113', '49', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('148', '2017-11-17', null, '113', '49', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);
INSERT INTO `sma_costing` VALUES ('149', '2017-11-17', '1', '114', '49', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '7.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('150', '2017-11-17', '1', '115', '49', '10', '1.0000', '0.5000', '0.5000', '0.5000', '0.5000', '7.0000', '1', '0', null);
INSERT INTO `sma_costing` VALUES ('151', '2017-11-17', '3', '116', '49', null, '1.0000', '0.4000', '0.4000', '0.5000', '0.5000', null, '1', '1', null);
INSERT INTO `sma_costing` VALUES ('152', '2017-11-17', null, '116', '49', null, '0.0000', null, null, '0.0000', '0.0000', null, '0', '0', null);

-- ----------------------------
-- Table structure for sma_currencies
-- ----------------------------
DROP TABLE IF EXISTS `sma_currencies`;
CREATE TABLE `sma_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(55) NOT NULL,
  `rate` decimal(12,4) NOT NULL,
  `auto_update` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_currencies
-- ----------------------------
INSERT INTO `sma_currencies` VALUES ('1', 'USD', 'US Dollar', '1.0000', '0');
INSERT INTO `sma_currencies` VALUES ('3', 'KHR', 'Riel', '4000.0000', '0');

-- ----------------------------
-- Table structure for sma_customer_groups
-- ----------------------------
DROP TABLE IF EXISTS `sma_customer_groups`;
CREATE TABLE `sma_customer_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `percent` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_customer_groups
-- ----------------------------
INSERT INTO `sma_customer_groups` VALUES ('1', 'General', '0');
INSERT INTO `sma_customer_groups` VALUES ('2', 'Reseller', '-5');
INSERT INTO `sma_customer_groups` VALUES ('3', 'Distributor', '-15');
INSERT INTO `sma_customer_groups` VALUES ('4', 'New Customer (+10)', '10');

-- ----------------------------
-- Table structure for sma_date_format
-- ----------------------------
DROP TABLE IF EXISTS `sma_date_format`;
CREATE TABLE `sma_date_format` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `js` varchar(20) NOT NULL,
  `php` varchar(20) NOT NULL,
  `sql` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_date_format
-- ----------------------------
INSERT INTO `sma_date_format` VALUES ('1', 'mm-dd-yyyy', 'm-d-Y', '%m-%d-%Y');
INSERT INTO `sma_date_format` VALUES ('2', 'mm/dd/yyyy', 'm/d/Y', '%m/%d/%Y');
INSERT INTO `sma_date_format` VALUES ('3', 'mm.dd.yyyy', 'm.d.Y', '%m.%d.%Y');
INSERT INTO `sma_date_format` VALUES ('4', 'dd-mm-yyyy', 'd-m-Y', '%d-%m-%Y');
INSERT INTO `sma_date_format` VALUES ('5', 'dd/mm/yyyy', 'd/m/Y', '%d/%m/%Y');
INSERT INTO `sma_date_format` VALUES ('6', 'dd.mm.yyyy', 'd.m.Y', '%d.%m.%Y');

-- ----------------------------
-- Table structure for sma_deliveries
-- ----------------------------
DROP TABLE IF EXISTS `sma_deliveries`;
CREATE TABLE `sma_deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_id` int(11) NOT NULL,
  `do_reference_no` varchar(50) NOT NULL,
  `sale_reference_no` varchar(50) NOT NULL,
  `customer` varchar(55) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL,
  `attachment` varchar(50) DEFAULT NULL,
  `delivered_by` varchar(50) DEFAULT NULL,
  `received_by` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_deliveries
-- ----------------------------
INSERT INTO `sma_deliveries` VALUES ('1', '2017-10-11 05:46:00', '2', 'DO/2017/10/0001', 'SALE/2017/10/0002', 'Walk-in Customer', '<p>Customer Address Petaling Jaya Selangor 46000 Malaysia<br>Tel: 0123456789 Email: customer@tecdiary.com</p>', '', 'packing', null, '', '', '1', null, null);

-- ----------------------------
-- Table structure for sma_deposits
-- ----------------------------
DROP TABLE IF EXISTS `sma_deposits`;
CREATE TABLE `sma_deposits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(11) NOT NULL,
  `amount` decimal(25,4) NOT NULL,
  `paid_by` varchar(50) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_deposits
-- ----------------------------

-- ----------------------------
-- Table structure for sma_expenses
-- ----------------------------
DROP TABLE IF EXISTS `sma_expenses`;
CREATE TABLE `sma_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference` varchar(50) NOT NULL,
  `amount` decimal(25,4) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `created_by` varchar(55) NOT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_expenses
-- ----------------------------

-- ----------------------------
-- Table structure for sma_expense_categories
-- ----------------------------
DROP TABLE IF EXISTS `sma_expense_categories`;
CREATE TABLE `sma_expense_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_expense_categories
-- ----------------------------
INSERT INTO `sma_expense_categories` VALUES ('1', '001', 'Expense One');

-- ----------------------------
-- Table structure for sma_gift_cards
-- ----------------------------
DROP TABLE IF EXISTS `sma_gift_cards`;
CREATE TABLE `sma_gift_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `card_no` varchar(20) NOT NULL,
  `value` decimal(25,4) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `balance` decimal(25,4) NOT NULL,
  `expiry` date DEFAULT NULL,
  `created_by` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_no` (`card_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_gift_cards
-- ----------------------------

-- ----------------------------
-- Table structure for sma_gift_card_topups
-- ----------------------------
DROP TABLE IF EXISTS `sma_gift_card_topups`;
CREATE TABLE `sma_gift_card_topups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `card_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `card_id` (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_gift_card_topups
-- ----------------------------

-- ----------------------------
-- Table structure for sma_groups
-- ----------------------------
DROP TABLE IF EXISTS `sma_groups`;
CREATE TABLE `sma_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_groups
-- ----------------------------
INSERT INTO `sma_groups` VALUES ('1', 'owner', 'Owner');
INSERT INTO `sma_groups` VALUES ('2', 'admin', 'Administrator');
INSERT INTO `sma_groups` VALUES ('3', 'customer', 'Customer');
INSERT INTO `sma_groups` VALUES ('4', 'supplier', 'Supplier');
INSERT INTO `sma_groups` VALUES ('5', 'sales', 'Sales Staff');

-- ----------------------------
-- Table structure for sma_login_attempts
-- ----------------------------
DROP TABLE IF EXISTS `sma_login_attempts`;
CREATE TABLE `sma_login_attempts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_login_attempts
-- ----------------------------
INSERT INTO `sma_login_attempts` VALUES ('5', 0x3A3A31, 'owner@cloudnet.com.kh', '1511181513');
INSERT INTO `sma_login_attempts` VALUES ('6', 0x3A3A31, 'owner@cloudnet.com.kh', '1511181521');

-- ----------------------------
-- Table structure for sma_migrations
-- ----------------------------
DROP TABLE IF EXISTS `sma_migrations`;
CREATE TABLE `sma_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_migrations
-- ----------------------------
INSERT INTO `sma_migrations` VALUES ('315');

-- ----------------------------
-- Table structure for sma_notifications
-- ----------------------------
DROP TABLE IF EXISTS `sma_notifications`;
CREATE TABLE `sma_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_date` datetime DEFAULT NULL,
  `till_date` datetime DEFAULT NULL,
  `scope` tinyint(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_notifications
-- ----------------------------
INSERT INTO `sma_notifications` VALUES ('1', '<p>Thank you for purchasing Stock Manager Advance. Please don\'t forget to check the documentation in help folder. If you find any error/bug, please email to support@tecdiary.com with details. You can send us your valued suggestions/feedback too.</p><p>Please rate Stock Manager Advance on your download page of codecanyon.net</p>', '2014-08-15 17:00:57', '2015-01-01 00:00:00', '2017-01-01 00:00:00', '3');

-- ----------------------------
-- Table structure for sma_order_ref
-- ----------------------------
DROP TABLE IF EXISTS `sma_order_ref`;
CREATE TABLE `sma_order_ref` (
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `so` int(11) NOT NULL DEFAULT '1',
  `qu` int(11) NOT NULL DEFAULT '1',
  `po` int(11) NOT NULL DEFAULT '1',
  `to` int(11) NOT NULL DEFAULT '1',
  `pos` int(11) NOT NULL DEFAULT '1',
  `do` int(11) NOT NULL DEFAULT '1',
  `pay` int(11) NOT NULL DEFAULT '1',
  `re` int(11) NOT NULL DEFAULT '1',
  `rep` int(11) NOT NULL DEFAULT '1',
  `ex` int(11) NOT NULL DEFAULT '1',
  `ppay` int(11) NOT NULL DEFAULT '1',
  `qa` int(11) NOT NULL DEFAULT '1',
  `con` int(11) NOT NULL,
  PRIMARY KEY (`ref_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_order_ref
-- ----------------------------
INSERT INTO `sma_order_ref` VALUES ('1', '2015-03-01', '19', '2', '13', '1', '33', '2', '31', '1', '1', '1', '2', '13', '15');

-- ----------------------------
-- Table structure for sma_payments
-- ----------------------------
DROP TABLE IF EXISTS `sma_payments`;
CREATE TABLE `sma_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_id` int(11) DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `reference_no` varchar(50) NOT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `paid_by` varchar(20) NOT NULL,
  `cheque_no` varchar(20) DEFAULT NULL,
  `cc_no` varchar(20) DEFAULT NULL,
  `cc_holder` varchar(25) DEFAULT NULL,
  `cc_month` varchar(2) DEFAULT NULL,
  `cc_year` varchar(4) DEFAULT NULL,
  `cc_type` varchar(20) DEFAULT NULL,
  `amount` decimal(25,4) NOT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `pos_paid` decimal(25,4) DEFAULT '0.0000',
  `pos_balance` decimal(25,4) DEFAULT '0.0000',
  `approval_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_payments
-- ----------------------------
INSERT INTO `sma_payments` VALUES ('1', '2017-10-18 05:34:00', '2', null, null, 'IPAY/2017/10/0003', null, 'cash', '', '', '', '', '', 'Visa', '-10.0000', null, '1', null, 'received', '', '0.0000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('2', '2017-10-18 05:34:00', '1', null, null, 'IPAY/2017/10/0004', null, 'cash', '', '', '', '', '', 'Visa', '60.0000', null, '1', null, 'received', '', '0.0000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('3', '2017-10-21 05:49:00', '16', null, null, 'IPAY/2017/10/0005', null, 'cash', '', '', '', '', '', '', '6.0000', null, '1', null, 'received', '', '6.0000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('4', '2017-10-21 06:01:12', '17', null, null, 'IPAY/2017/10/0006', null, 'cash', '', '', '', '', '', '', '5.0000', null, '1', null, 'received', '', '5.0000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('5', '2017-10-21 05:08:00', '20', null, null, 'IPAY/2017/10/0007', null, 'cash', '', '', '', '', '', 'Visa', '250.0000', null, '1', null, 'received', '', '0.0000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('6', '2017-10-29 01:36:34', '21', null, null, 'IPAY/2017/10/0008', null, 'cash', '', '', '', '', '', '', '1.0000', null, '1', null, 'received', '', '1.0000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('7', '2017-10-29 01:50:49', '22', null, null, 'IPAY/2017/10/0009', null, 'cash', '', '', '', '', '', '', '1.0000', null, '1', null, 'received', '', '1.0000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('8', '2017-11-16 06:42:25', '23', null, null, 'IPAY/2017/11/0010', null, 'cash', '', '', '', '', '', '', '0.5000', null, '1', null, 'received', '', '0.5000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('9', '2017-11-16 06:43:33', '24', null, null, 'IPAY/2017/11/0011', null, 'cash', '', '', '', '', '', '', '0.2000', null, '1', null, 'received', '', '0.2000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('10', '2017-11-16 21:02:01', '26', null, null, 'IPAY/2017/11/0012', null, 'cash', '', '', '', '', '', '', '1.5000', null, '1', null, 'received', '', '1.5000', '-0.5000', null);
INSERT INTO `sma_payments` VALUES ('11', '2017-11-16 21:03:37', '27', null, null, 'IPAY/2017/11/0013', null, 'cash', '', '', '', '', '', '', '1.5000', null, '1', null, 'received', '', '1.5000', '-0.5000', null);
INSERT INTO `sma_payments` VALUES ('12', '2017-11-16 21:23:56', '28', null, null, 'IPAY/2017/11/0014', null, 'cash', '', '', '', '', '', '', '1.5000', null, '1', null, 'received', '', '1.5000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('13', '2017-11-16 21:25:29', '29', null, null, 'IPAY/2017/11/0015', null, 'cash', '', '', '', '', '', '', '1.5000', null, '1', null, 'received', '', '1.5000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('14', '2017-11-16 21:33:51', '30', null, null, 'IPAY/2017/11/0016', null, 'cash', '', '', '', '', '', '', '1.5000', null, '1', null, 'received', '', '1.5000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('15', '2017-11-17 00:22:24', '31', null, null, 'IPAY/2017/11/0017', null, 'cash', '', '', '', '', '', '', '0.5000', null, '1', null, 'received', '', '1.5000', '1.0000', null);
INSERT INTO `sma_payments` VALUES ('16', '2017-11-17 00:35:48', '34', null, null, 'IPAY/2017/11/0018', null, 'cash', '', '', '', '', '', '', '1.0000', null, '1', null, 'received', '', '3.0000', '2.0000', null);
INSERT INTO `sma_payments` VALUES ('17', '2017-11-17 00:36:37', '35', null, null, 'IPAY/2017/11/0019', null, 'cash', '', '', '', '', '', '', '1.5000', null, '1', null, 'received', '', '1.5000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('18', '2017-11-17 00:37:26', '36', null, null, 'IPAY/2017/11/0020', null, 'cash', '', '', '', '', '', '', '1.0000', null, '1', null, 'received', '', '2.5000', '1.5000', null);
INSERT INTO `sma_payments` VALUES ('19', '2017-11-17 01:00:52', '37', null, null, 'IPAY/2017/11/0021', null, 'cash', '', '', '', '', '', '', '3.0000', null, '1', null, 'received', '', '3.0000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('20', '2017-11-17 01:27:48', '40', null, null, 'IPAY/2017/11/0022', null, 'cash', '', '', '', '', '', '', '2.5000', null, '1', null, 'received', '', '2.5000', '-0.5000', null);
INSERT INTO `sma_payments` VALUES ('21', '2017-11-17 01:47:57', '42', null, null, 'IPAY/2017/11/0023', null, 'cash', '', '', '', '', '', '', '0.5000', null, '1', null, 'received', '', '0.5000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('22', '2017-11-17 01:58:17', '43', null, null, 'IPAY/2017/11/0024', null, 'cash', '', '', '', '', '', '', '7.5000', null, '1', null, 'received', '', '8.0000', '0.5000', null);
INSERT INTO `sma_payments` VALUES ('23', '2017-11-17 02:10:35', '44', null, null, 'IPAY/2017/11/0025', null, 'cash', '', '', '', '', '', '', '1.0000', null, '1', null, 'received', '', '1.2500', '0.2500', null);
INSERT INTO `sma_payments` VALUES ('24', '2017-11-17 02:11:11', '45', null, null, 'IPAY/2017/11/0026', null, 'cash', '', '', '', '', '', '', '1.0000', null, '1', null, 'received', '', '1.2500', '0.2500', null);
INSERT INTO `sma_payments` VALUES ('25', '2017-11-17 02:12:27', '46', null, null, 'IPAY/2017/11/0027', null, 'cash', '', '', '', '', '', '', '1.5000', null, '1', null, 'received', '', '1.5000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('26', '2017-11-17 02:27:18', '47', null, null, 'IPAY/2017/11/0028', null, 'cash', '', '', '', '', '', '', '1.0000', null, '1', null, 'received', '', '1.2500', '0.2500', null);
INSERT INTO `sma_payments` VALUES ('27', '2017-11-17 02:27:53', '48', null, null, 'IPAY/2017/11/0029', null, 'cash', '', '', '', '', '', '', '1.0000', null, '1', null, 'received', '', '1.0000', '0.0000', null);
INSERT INTO `sma_payments` VALUES ('28', '2017-11-17 20:19:40', '49', null, null, 'IPAY/2017/11/0030', null, 'cash', '', '', '', '', '', '', '2.5000', null, '1', null, 'received', '', '2.5000', '0.0000', null);

-- ----------------------------
-- Table structure for sma_paypal
-- ----------------------------
DROP TABLE IF EXISTS `sma_paypal`;
CREATE TABLE `sma_paypal` (
  `id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `account_email` varchar(255) NOT NULL,
  `paypal_currency` varchar(3) NOT NULL DEFAULT 'USD',
  `fixed_charges` decimal(25,4) NOT NULL DEFAULT '2.0000',
  `extra_charges_my` decimal(25,4) NOT NULL DEFAULT '3.9000',
  `extra_charges_other` decimal(25,4) NOT NULL DEFAULT '4.4000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_paypal
-- ----------------------------
INSERT INTO `sma_paypal` VALUES ('1', '1', 'mypaypal@paypal.com', 'USD', '0.0000', '0.0000', '0.0000');

-- ----------------------------
-- Table structure for sma_permissions
-- ----------------------------
DROP TABLE IF EXISTS `sma_permissions`;
CREATE TABLE `sma_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `products-index` tinyint(1) DEFAULT '0',
  `products-add` tinyint(1) DEFAULT '0',
  `products-edit` tinyint(1) DEFAULT '0',
  `products-delete` tinyint(1) DEFAULT '0',
  `products-cost` tinyint(1) DEFAULT '0',
  `products-price` tinyint(1) DEFAULT '0',
  `quotes-index` tinyint(1) DEFAULT '0',
  `quotes-add` tinyint(1) DEFAULT '0',
  `quotes-edit` tinyint(1) DEFAULT '0',
  `quotes-pdf` tinyint(1) DEFAULT '0',
  `quotes-email` tinyint(1) DEFAULT '0',
  `quotes-delete` tinyint(1) DEFAULT '0',
  `sales-index` tinyint(1) DEFAULT '0',
  `sales-add` tinyint(1) DEFAULT '0',
  `sales-edit` tinyint(1) DEFAULT '0',
  `sales-pdf` tinyint(1) DEFAULT '0',
  `sales-email` tinyint(1) DEFAULT '0',
  `sales-delete` tinyint(1) DEFAULT '0',
  `purchases-index` tinyint(1) DEFAULT '0',
  `purchases-add` tinyint(1) DEFAULT '0',
  `purchases-edit` tinyint(1) DEFAULT '0',
  `purchases-pdf` tinyint(1) DEFAULT '0',
  `purchases-email` tinyint(1) DEFAULT '0',
  `purchases-delete` tinyint(1) DEFAULT '0',
  `transfers-index` tinyint(1) DEFAULT '0',
  `transfers-add` tinyint(1) DEFAULT '0',
  `transfers-edit` tinyint(1) DEFAULT '0',
  `transfers-pdf` tinyint(1) DEFAULT '0',
  `transfers-email` tinyint(1) DEFAULT '0',
  `transfers-delete` tinyint(1) DEFAULT '0',
  `customers-index` tinyint(1) DEFAULT '0',
  `customers-add` tinyint(1) DEFAULT '0',
  `customers-edit` tinyint(1) DEFAULT '0',
  `customers-delete` tinyint(1) DEFAULT '0',
  `suppliers-index` tinyint(1) DEFAULT '0',
  `suppliers-add` tinyint(1) DEFAULT '0',
  `suppliers-edit` tinyint(1) DEFAULT '0',
  `suppliers-delete` tinyint(1) DEFAULT '0',
  `sales-deliveries` tinyint(1) DEFAULT '0',
  `sales-add_delivery` tinyint(1) DEFAULT '0',
  `sales-edit_delivery` tinyint(1) DEFAULT '0',
  `sales-delete_delivery` tinyint(1) DEFAULT '0',
  `sales-email_delivery` tinyint(1) DEFAULT '0',
  `sales-pdf_delivery` tinyint(1) DEFAULT '0',
  `sales-gift_cards` tinyint(1) DEFAULT '0',
  `sales-add_gift_card` tinyint(1) DEFAULT '0',
  `sales-edit_gift_card` tinyint(1) DEFAULT '0',
  `sales-delete_gift_card` tinyint(1) DEFAULT '0',
  `pos-index` tinyint(1) DEFAULT '0',
  `sales-return_sales` tinyint(1) DEFAULT '0',
  `reports-index` tinyint(1) DEFAULT '0',
  `reports-warehouse_stock` tinyint(1) DEFAULT '0',
  `reports-quantity_alerts` tinyint(1) DEFAULT '0',
  `reports-expiry_alerts` tinyint(1) DEFAULT '0',
  `reports-products` tinyint(1) DEFAULT '0',
  `reports-daily_sales` tinyint(1) DEFAULT '0',
  `reports-monthly_sales` tinyint(1) DEFAULT '0',
  `reports-sales` tinyint(1) DEFAULT '0',
  `reports-payments` tinyint(1) DEFAULT '0',
  `reports-purchases` tinyint(1) DEFAULT '0',
  `reports-profit_loss` tinyint(1) DEFAULT '0',
  `reports-customers` tinyint(1) DEFAULT '0',
  `reports-suppliers` tinyint(1) DEFAULT '0',
  `reports-staff` tinyint(1) DEFAULT '0',
  `reports-register` tinyint(1) DEFAULT '0',
  `sales-payments` tinyint(1) DEFAULT '0',
  `purchases-payments` tinyint(1) DEFAULT '0',
  `purchases-expenses` tinyint(1) DEFAULT '0',
  `products-adjustments` tinyint(1) NOT NULL DEFAULT '0',
  `bulk_actions` tinyint(1) NOT NULL DEFAULT '0',
  `customers-deposits` tinyint(1) NOT NULL DEFAULT '0',
  `customers-delete_deposit` tinyint(1) NOT NULL DEFAULT '0',
  `products-barcode` tinyint(1) NOT NULL DEFAULT '0',
  `purchases-return_purchases` tinyint(1) NOT NULL DEFAULT '0',
  `reports-expenses` tinyint(1) NOT NULL DEFAULT '0',
  `reports-daily_purchases` tinyint(1) DEFAULT '0',
  `reports-monthly_purchases` tinyint(1) DEFAULT '0',
  `products-stock_count` tinyint(1) DEFAULT '0',
  `edit_price` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_permissions
-- ----------------------------
INSERT INTO `sma_permissions` VALUES ('1', '5', '1', '0', '0', '0', '0', '0', '1', '1', '1', '1', '1', '0', '1', '1', '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1', '0', '0', '0', '0', '0', '1', '1', '1', '0', '0', '1', '1', '1', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `sma_permissions` VALUES ('2', '6', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', null, '1', '1', '1', '1', '1', '1', '1', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '0', '1', '1', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for sma_pos_register
-- ----------------------------
DROP TABLE IF EXISTS `sma_pos_register`;
CREATE TABLE `sma_pos_register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `cash_in_hand` decimal(25,4) NOT NULL,
  `status` varchar(10) NOT NULL,
  `total_cash` decimal(25,4) DEFAULT NULL,
  `total_cheques` int(11) DEFAULT NULL,
  `total_cc_slips` int(11) DEFAULT NULL,
  `total_cash_submitted` decimal(25,4) DEFAULT NULL,
  `total_cheques_submitted` int(11) DEFAULT NULL,
  `total_cc_slips_submitted` int(11) DEFAULT NULL,
  `note` text,
  `closed_at` timestamp NULL DEFAULT NULL,
  `transfer_opened_bills` varchar(50) DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_pos_register
-- ----------------------------
INSERT INTO `sma_pos_register` VALUES ('1', '2017-10-03 10:48:58', '1', '1000.0000', 'open', null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for sma_pos_settings
-- ----------------------------
DROP TABLE IF EXISTS `sma_pos_settings`;
CREATE TABLE `sma_pos_settings` (
  `pos_id` int(1) NOT NULL,
  `cat_limit` int(11) NOT NULL,
  `pro_limit` int(11) NOT NULL,
  `default_category` int(11) NOT NULL,
  `default_customer` int(11) NOT NULL,
  `default_biller` int(11) NOT NULL,
  `display_time` varchar(3) NOT NULL DEFAULT 'yes',
  `cf_title1` varchar(255) DEFAULT NULL,
  `cf_title2` varchar(255) DEFAULT NULL,
  `cf_value1` varchar(255) DEFAULT NULL,
  `cf_value2` varchar(255) DEFAULT NULL,
  `receipt_printer` varchar(55) DEFAULT NULL,
  `cash_drawer_codes` varchar(55) DEFAULT NULL,
  `focus_add_item` varchar(55) DEFAULT NULL,
  `add_manual_product` varchar(55) DEFAULT NULL,
  `customer_selection` varchar(55) DEFAULT NULL,
  `add_customer` varchar(55) DEFAULT NULL,
  `toggle_category_slider` varchar(55) DEFAULT NULL,
  `toggle_subcategory_slider` varchar(55) DEFAULT NULL,
  `cancel_sale` varchar(55) DEFAULT NULL,
  `suspend_sale` varchar(55) DEFAULT NULL,
  `print_items_list` varchar(55) DEFAULT NULL,
  `finalize_sale` varchar(55) DEFAULT NULL,
  `today_sale` varchar(55) DEFAULT NULL,
  `open_hold_bills` varchar(55) DEFAULT NULL,
  `close_register` varchar(55) DEFAULT NULL,
  `keyboard` tinyint(1) NOT NULL,
  `pos_printers` varchar(255) DEFAULT NULL,
  `java_applet` tinyint(1) NOT NULL,
  `product_button_color` varchar(20) NOT NULL DEFAULT 'default',
  `tooltips` tinyint(1) DEFAULT '1',
  `paypal_pro` tinyint(1) DEFAULT '0',
  `stripe` tinyint(1) DEFAULT '0',
  `rounding` tinyint(1) DEFAULT '0',
  `char_per_line` tinyint(4) DEFAULT '42',
  `pin_code` varchar(20) DEFAULT NULL,
  `purchase_code` varchar(100) DEFAULT 'purchase_code',
  `envato_username` varchar(50) DEFAULT 'envato_username',
  `version` varchar(10) DEFAULT '3.0.2.24',
  `after_sale_page` tinyint(1) DEFAULT '0',
  `item_order` tinyint(1) DEFAULT '0',
  `authorize` tinyint(1) DEFAULT '0',
  `toggle_brands_slider` varchar(55) DEFAULT NULL,
  `remote_printing` tinyint(1) DEFAULT '1',
  `printer` int(11) DEFAULT NULL,
  `order_printers` varchar(55) DEFAULT NULL,
  `auto_print` tinyint(1) DEFAULT '0',
  `customer_details` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_pos_settings
-- ----------------------------
INSERT INTO `sma_pos_settings` VALUES ('1', '22', '20', '2', '1', '3', '1', 'GST Reg', 'VAT Reg', '123456789', '987654321', null, 'x1C', 'Ctrl+F3', 'Ctrl+Shift+M', 'Ctrl+Shift+C', 'Ctrl+Shift+A', 'Ctrl+F11', 'Ctrl+F12', 'F4', 'F7', 'F9', 'F8', 'Ctrl+F1', 'Ctrl+F2', 'Ctrl+F10', '0', null, '0', 'default', '1', '0', '0', '0', '42', null, 'purchase_code', 'envato_username', '3.0.2.24', '0', '0', '0', '', '1', null, 'null', '0', '0');

-- ----------------------------
-- Table structure for sma_price_groups
-- ----------------------------
DROP TABLE IF EXISTS `sma_price_groups`;
CREATE TABLE `sma_price_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_price_groups
-- ----------------------------
INSERT INTO `sma_price_groups` VALUES ('1', 'Default');

-- ----------------------------
-- Table structure for sma_printers
-- ----------------------------
DROP TABLE IF EXISTS `sma_printers`;
CREATE TABLE `sma_printers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) NOT NULL,
  `type` varchar(25) NOT NULL,
  `profile` varchar(25) NOT NULL,
  `char_per_line` tinyint(3) unsigned DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `ip_address` varbinary(45) DEFAULT NULL,
  `port` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_printers
-- ----------------------------

-- ----------------------------
-- Table structure for sma_products
-- ----------------------------
DROP TABLE IF EXISTS `sma_products`;
CREATE TABLE `sma_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` char(255) NOT NULL,
  `unit` int(11) DEFAULT NULL,
  `cost` decimal(25,4) DEFAULT NULL,
  `price` decimal(25,4) NOT NULL,
  `alert_quantity` decimal(15,4) DEFAULT '20.0000',
  `image` varchar(255) DEFAULT 'no_image.png',
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `cf1` varchar(255) DEFAULT NULL,
  `cf2` varchar(255) DEFAULT NULL,
  `cf3` varchar(255) DEFAULT NULL,
  `cf4` varchar(255) DEFAULT NULL,
  `cf5` varchar(255) DEFAULT NULL,
  `cf6` varchar(255) DEFAULT NULL,
  `quantity` decimal(15,4) DEFAULT '0.0000',
  `tax_rate` int(11) DEFAULT NULL,
  `track_quantity` tinyint(1) DEFAULT '1',
  `details` varchar(1000) DEFAULT NULL,
  `warehouse` int(11) DEFAULT NULL,
  `barcode_symbology` varchar(55) NOT NULL DEFAULT 'code128',
  `file` varchar(100) DEFAULT NULL,
  `product_details` text,
  `tax_method` tinyint(1) DEFAULT '0',
  `type` varchar(55) NOT NULL DEFAULT 'standard',
  `supplier1` int(11) DEFAULT NULL,
  `supplier1price` decimal(25,4) DEFAULT NULL,
  `supplier2` int(11) DEFAULT NULL,
  `supplier2price` decimal(25,4) DEFAULT NULL,
  `supplier3` int(11) DEFAULT NULL,
  `supplier3price` decimal(25,4) DEFAULT NULL,
  `supplier4` int(11) DEFAULT NULL,
  `supplier4price` decimal(25,4) DEFAULT NULL,
  `supplier5` int(11) DEFAULT NULL,
  `supplier5price` decimal(25,4) DEFAULT NULL,
  `promotion` tinyint(1) DEFAULT '0',
  `promo_price` decimal(25,4) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `supplier1_part_no` varchar(50) DEFAULT NULL,
  `supplier2_part_no` varchar(50) DEFAULT NULL,
  `supplier3_part_no` varchar(50) DEFAULT NULL,
  `supplier4_part_no` varchar(50) DEFAULT NULL,
  `supplier5_part_no` varchar(50) DEFAULT NULL,
  `sale_unit` int(11) DEFAULT NULL,
  `purchase_unit` int(11) DEFAULT NULL,
  `brand` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `category_id` (`category_id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `category_id_2` (`category_id`),
  KEY `unit` (`unit`),
  KEY `brand` (`brand`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_products
-- ----------------------------
INSERT INTO `sma_products` VALUES ('1', 'C001', 'Fanta', '1', '0.0000', '0.5000', '10.0000', 'd648ba4722190a70c03a7633e6fc9fa6.png', '2', null, '', '', '', '', '', '', '5.0000', '1', '1', '', null, 'code128', '', '', '0', 'standard', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, null, null, '1', '2', '1');
INSERT INTO `sma_products` VALUES ('3', 'C002', 'CoCa', '1', '0.4000', '0.5000', '0.0000', 'no_image.png', '2', null, '', '', '', '', '', '', '-72.0000', '1', '1', '', null, 'code128', '', '', '0', 'standard', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, '', null, null, null, null, '1', '2', '0');

-- ----------------------------
-- Table structure for sma_product_photos
-- ----------------------------
DROP TABLE IF EXISTS `sma_product_photos`;
CREATE TABLE `sma_product_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_product_photos
-- ----------------------------
INSERT INTO `sma_product_photos` VALUES ('1', '1', 'c2988135aa07227c331ad67979a9c02e.jpg');

-- ----------------------------
-- Table structure for sma_product_prices
-- ----------------------------
DROP TABLE IF EXISTS `sma_product_prices`;
CREATE TABLE `sma_product_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `price_group_id` int(11) NOT NULL,
  `price` decimal(25,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `price_group_id` (`price_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_product_prices
-- ----------------------------

-- ----------------------------
-- Table structure for sma_product_units
-- ----------------------------
DROP TABLE IF EXISTS `sma_product_units`;
CREATE TABLE `sma_product_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_qty` decimal(11,5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `base_unit` (`unit_qty`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_product_units
-- ----------------------------
INSERT INTO `sma_product_units` VALUES ('7', '1', '1', '1.00000');
INSERT INTO `sma_product_units` VALUES ('8', '2', '1', '6.00000');
INSERT INTO `sma_product_units` VALUES ('11', '1', '3', '1.00000');
INSERT INTO `sma_product_units` VALUES ('12', '2', '3', '10.00000');

-- ----------------------------
-- Table structure for sma_product_variants
-- ----------------------------
DROP TABLE IF EXISTS `sma_product_variants`;
CREATE TABLE `sma_product_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `cost` decimal(25,4) DEFAULT NULL,
  `price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_product_variants
-- ----------------------------

-- ----------------------------
-- Table structure for sma_purchases
-- ----------------------------
DROP TABLE IF EXISTS `sma_purchases`;
CREATE TABLE `sma_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `product_discount` decimal(25,4) DEFAULT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `order_discount` decimal(25,4) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT NULL,
  `product_tax` decimal(25,4) DEFAULT NULL,
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `paid` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `status` varchar(55) DEFAULT '',
  `payment_status` varchar(20) DEFAULT 'pending',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `return_purchase_ref` varchar(55) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `return_purchase_total` decimal(25,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_purchases
-- ----------------------------
INSERT INTO `sma_purchases` VALUES ('2', 'PO/2017/10/0004', '2017-10-18 05:22:00', '2', 'Supplier Company Name', '1', '', '40.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '10.0000', '50.0000', '0.0000', 'received', 'pending', '1', null, null, null, '0', null, null, '0.0000', null, null, '0.0000');
INSERT INTO `sma_purchases` VALUES ('3', 'PO/2017/10/0005', '2017-10-19 05:34:00', '2', 'Supplier Company Name', '1', '', '4.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '4.0000', '0.0000', 'received', 'pending', '1', null, null, null, '0', null, null, '0.0000', null, null, '0.0000');
INSERT INTO `sma_purchases` VALUES ('4', 'PO/2017/10/0006', '2017-10-19 06:41:00', '2', 'Supplier Company Name', '1', '', '20.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '20.0000', '0.0000', 'received', 'pending', '1', '1', '2017-10-19 07:54:52', null, '0', null, null, '0.0000', null, null, '0.0000');
INSERT INTO `sma_purchases` VALUES ('5', 'PO/2017/10/0007', '2017-10-20 05:04:00', '2', 'Supplier Company Name', '1', '', '50.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '50.0000', '0.0000', 'received', 'pending', '1', null, null, null, '0', null, null, '0.0000', null, null, '0.0000');
INSERT INTO `sma_purchases` VALUES ('6', 'PO/2017/10/0008', '2017-10-20 05:20:00', '2', 'Supplier Company Name', '1', '', '4.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '4.0000', '0.0000', 'received', 'pending', '1', null, null, null, '0', null, null, '0.0000', null, null, '0.0000');
INSERT INTO `sma_purchases` VALUES ('7', 'PO/2017/10/0009', '2017-10-20 05:43:00', '2', 'Supplier Company Name', '1', '', '4.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '4.0000', '0.0000', 'received', 'pending', '1', '1', '2017-10-20 06:44:35', null, '0', null, null, '0.0000', null, null, '0.0000');
INSERT INTO `sma_purchases` VALUES ('8', 'PO/2017/10/0010', '2017-10-20 06:09:00', '2', 'Supplier Company Name', '1', '', '4.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '4.0000', '0.0000', 'received', 'pending', '1', null, null, null, '0', null, null, '0.0000', null, null, '0.0000');
INSERT INTO `sma_purchases` VALUES ('9', 'PO/2017/10/0011', '2017-10-20 06:10:00', '2', 'Supplier Company Name', '1', '', '8.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '8.0000', '0.0000', 'received', 'pending', '1', '1', '2017-10-20 07:11:19', null, '0', null, null, '0.0000', null, null, '0.0000');
INSERT INTO `sma_purchases` VALUES ('10', 'PO/2017/11/0012', '2017-11-20 21:32:00', '2', 'Supplier Company Name', '1', '', '0.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 'received', 'pending', '1', null, null, null, '0', null, null, '0.0000', null, null, '0.0000');

-- ----------------------------
-- Table structure for sma_purchase_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_purchase_items`;
CREATE TABLE `sma_purchase_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_cost` decimal(25,4) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(20) DEFAULT NULL,
  `discount` varchar(20) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `quantity_balance` decimal(15,4) DEFAULT '0.0000',
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `unit_cost` decimal(25,4) DEFAULT NULL,
  `real_unit_cost` decimal(25,4) DEFAULT NULL,
  `quantity_received` decimal(15,4) DEFAULT NULL,
  `supplier_part_no` varchar(50) DEFAULT NULL,
  `purchase_item_id` int(11) DEFAULT NULL,
  `product_unit_id` int(11) DEFAULT NULL,
  `product_unit_code` varchar(10) DEFAULT NULL,
  `unit_quantity` decimal(15,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_purchase_items
-- ----------------------------
INSERT INTO `sma_purchase_items` VALUES ('1', '2', null, '1', 'C001', 'Fanta', null, '4.0000', '120.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '40.0000', '0.0000', '2017-10-17', 'received', '4.0000', '4.0000', '120.0000', null, null, '2', 'case', '10.0000');
INSERT INTO `sma_purchase_items` VALUES ('3', '3', null, '1', 'C001', 'Fanta', null, '4.0000', '12.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '4.0000', '0.0000', '2017-10-18', 'received', '4.0000', '4.0000', '12.0000', null, null, '2', 'case', '1.0000');
INSERT INTO `sma_purchase_items` VALUES ('9', '4', null, '1', 'C001', 'Fanta', null, '4.0000', '30.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '20.0000', '0.0000', '2017-10-18', 'received', '4.0000', '4.0000', '30.0000', null, null, '2', 'case', '5.0000');
INSERT INTO `sma_purchase_items` VALUES ('10', '5', null, '1', 'C001', 'Fanta', null, '0.5000', '100.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '50.0000', '2.0000', '2017-10-19', 'received', '0.5000', '0.5000', '100.0000', null, null, '1', 'can', '100.0000');
INSERT INTO `sma_purchase_items` VALUES ('15', '8', null, '3', 'C002', 'CoCa', null, '4.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '4.0000', '0.0000', '2017-10-19', 'received', '4.0000', '0.4000', '10.0000', null, null, '2', 'case', '1.0000');
INSERT INTO `sma_purchase_items` VALUES ('17', '9', null, '3', 'C002', 'CoCa', null, '4.0000', '20.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '8.0000', '-1.0000', '2017-10-19', 'received', '4.0000', '0.4000', '20.0000', null, null, '2', 'case', '2.0000');
INSERT INTO `sma_purchase_items` VALUES ('18', null, null, '3', '', '', null, '0.0000', '0.0000', '1', '0.0000', null, null, null, null, null, '0.0000', '-71.0000', '0000-00-00', 'received', null, null, null, null, null, null, null, '0.0000');
INSERT INTO `sma_purchase_items` VALUES ('19', '10', null, '1', 'C001', 'Fanta', null, '0.0000', '6.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', null, '0.0000', '3.0000', '2017-11-20', 'received', '0.0000', '0.0000', '6.0000', null, null, '2', 'case', '1.0000');

-- ----------------------------
-- Table structure for sma_quotes
-- ----------------------------
DROP TABLE IF EXISTS `sma_quotes`;
CREATE TABLE `sma_quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `biller_id` int(11) NOT NULL,
  `biller` varchar(55) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `internal_note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount` decimal(25,4) DEFAULT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT '0.0000',
  `product_tax` decimal(25,4) DEFAULT '0.0000',
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT NULL,
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` varchar(55) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `supplier` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_quotes
-- ----------------------------
INSERT INTO `sma_quotes` VALUES ('1', '2017-10-15 02:43:00', 'QUOTE/2017/10/0001', '1', 'Walk-in Customer', '1', '3', 'Test Biller', '', null, '6.0000', '0.0000', '0.0000', null, '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '6.0000', 'completed', '1', '1', '2017-10-15 03:45:23', null, '0', null);

-- ----------------------------
-- Table structure for sma_quote_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_quote_items`;
CREATE TABLE `sma_quote_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  `product_unit_id` int(11) DEFAULT NULL,
  `product_unit_code` varchar(10) DEFAULT NULL,
  `unit_quantity` decimal(15,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quote_id` (`quote_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_quote_items
-- ----------------------------

-- ----------------------------
-- Table structure for sma_sales
-- ----------------------------
DROP TABLE IF EXISTS `sma_sales`;
CREATE TABLE `sma_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `biller` varchar(55) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `staff_note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT '0.0000',
  `order_discount` decimal(25,4) DEFAULT '0.0000',
  `product_tax` decimal(25,4) DEFAULT '0.0000',
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT '0.0000',
  `total_tax` decimal(25,4) DEFAULT '0.0000',
  `shipping` decimal(25,4) DEFAULT '0.0000',
  `grand_total` decimal(25,4) NOT NULL,
  `sale_status` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `payment_term` tinyint(4) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_items` tinyint(4) DEFAULT NULL,
  `pos` tinyint(1) NOT NULL DEFAULT '0',
  `paid` decimal(25,4) DEFAULT '0.0000',
  `return_id` int(11) DEFAULT NULL,
  `surcharge` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `attachment` varchar(55) DEFAULT NULL,
  `return_sale_ref` varchar(55) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `return_sale_total` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `rounding` decimal(10,4) DEFAULT NULL,
  `suspend_note` varchar(255) DEFAULT NULL,
  `currencies` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_sales
-- ----------------------------
INSERT INTO `sma_sales` VALUES ('1', '2017-10-18 05:31:00', 'SALE/2017/10/0004', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '60.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '60.0000', 'completed', 'paid', '0', null, '1', null, null, '120', '0', '60.0000', '2', '0.0000', null, 'SR/2017/10/0001', null, '-10.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('2', '2017-10-18 05:34:00', 'SALE/2017/10/0004', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', null, '-10.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '-10.0000', 'returned', 'paid', null, null, '1', null, null, null, '0', '-10.0000', null, '0.0000', null, 'SR/2017/10/0001', '1', '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('3', '2017-10-19 06:55:00', 'SALE/2017/10/0005', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'due', '0', null, '1', '1', '2017-10-19 07:57:36', '2', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('5', '2017-10-19 07:03:00', 'SALE/2017/10/0007', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '2.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2.0000', 'completed', 'due', '0', null, '1', '1', '2017-10-20 05:53:56', '4', '0', '0.0000', '6', '0.0000', null, 'SR/2017/10/0001', null, '-2.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('6', '2017-10-20 04:57:00', 'SALE/2017/10/0007', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', null, '-2.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '-2.0000', 'returned', 'pending', null, null, '1', null, null, null, '0', '0.0000', null, '0.0000', null, 'SR/2017/10/0001', '5', '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('7', '2017-10-20 05:04:00', 'SALE/2017/10/0008', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.5000', 'completed', 'due', '0', null, '1', '1', '2017-10-20 06:05:25', '1', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('8', '2017-10-20 05:21:00', 'SALE/2017/10/0009', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.5000', 'completed', 'pending', '0', null, '1', null, null, '1', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('9', '2017-10-20 05:27:00', 'SALE/2017/10/0010', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.5000', 'completed', 'pending', '0', null, '1', null, null, '1', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('10', '2017-10-20 05:33:00', 'SALE/2017/10/0011', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'pending', '0', null, '1', null, null, '2', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('11', '2017-10-20 05:35:00', 'SALE/2017/10/0012', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.5000', 'completed', 'pending', '0', null, '1', null, null, '1', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('12', '2017-10-20 05:36:00', 'SALE/2017/10/0013', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '2.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2.0000', 'completed', 'due', '0', null, '1', '1', '2017-10-20 08:32:19', '4', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('13', '2017-10-20 05:36:00', 'SALE/2017/10/0014', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.5000', 'completed', 'pending', '0', null, '1', null, null, '1', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('14', '2017-10-20 06:11:00', 'SALE/2017/10/0015', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '5.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '5.0000', 'completed', 'due', '0', null, '1', '1', '2017-10-20 07:47:34', '10', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('15', '2017-10-20 06:47:00', 'SALE/2017/10/0016', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '2.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2.0000', 'completed', 'due', '0', null, '1', '1', '2017-10-20 08:30:23', '4', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('16', '2017-10-21 05:49:00', 'SALE/POS/2017/10/0002', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '6.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '6.0000', 'completed', 'paid', '0', null, '1', null, null, '1', '1', '6.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, null);
INSERT INTO `sma_sales` VALUES ('17', '2017-10-21 06:01:12', 'SALE/POS/2017/10/0003', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '5.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '5.0000', 'completed', 'paid', '0', null, '1', null, null, '1', '1', '5.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, null);
INSERT INTO `sma_sales` VALUES ('18', '2017-10-21 05:04:00', 'SALE/2017/10/0017', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.5000', 'completed', 'due', '0', null, '1', '1', '2017-10-21 06:06:03', '1', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('19', '2017-10-20 05:36:00', 'SALE/2017/10/0014', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.5000', 'completed', 'pending', '0', null, '1', null, null, '1', '0', '0.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('20', '2017-10-21 05:06:00', 'SALE/2017/10/0018', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '250.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '250.0000', 'completed', 'paid', '0', null, '1', '1', '2017-10-21 06:08:01', '5', '0', '250.0000', null, '0.0000', null, null, null, '0.0000', null, null, null);
INSERT INTO `sma_sales` VALUES ('21', '2017-10-29 01:36:34', 'SALE/POS/2017/10/0004', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'paid', '0', null, '1', null, null, '2', '1', '1.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, null);
INSERT INTO `sma_sales` VALUES ('22', '2017-10-29 01:50:49', 'SALE/POS/2017/10/0005', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'paid', '0', null, '1', null, null, '2', '1', '1.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, null);
INSERT INTO `sma_sales` VALUES ('23', '2017-11-16 06:42:25', 'SALE/POS/2017/11/0006', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.5000', 'completed', 'paid', '0', null, '1', null, null, '1', '1', '0.5000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, null);
INSERT INTO `sma_sales` VALUES ('24', '2017-11-16 06:43:33', 'SALE/POS/2017/11/0007', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.2000', '0.3000', null, '0.3000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.2000', 'completed', 'paid', '0', null, '1', null, null, '1', '1', '0.2000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, null);
INSERT INTO `sma_sales` VALUES ('29', '2017-11-16 21:25:29', 'SALE/POS/2017/11/0012', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.5000', 'completed', 'paid', '0', null, '1', null, null, '3', '1', '1.5000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"1\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('30', '2017-11-16 21:33:51', 'SALE/POS/2017/11/0013', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.5000', 'completed', 'paid', '0', null, '1', null, null, '3', '1', '1.5000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"1.5\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"0\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('31', '2017-11-17 00:22:24', 'SALE/POS/2017/11/0014', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.5000', 'completed', 'paid', '0', null, '1', null, null, '1', '1', '0.5000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"1\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('32', '2017-11-17 00:25:01', 'SALE/POS/2017/11/0015', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '3.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '3.0000', 'completed', 'due', '0', null, '1', null, null, '6', '1', '0.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"1\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('33', '2017-11-17 00:28:20', 'SALE/POS/2017/11/0016', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '6.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '6.0000', 'completed', 'due', '0', null, '1', null, null, '12', '1', '0.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"1\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('34', '2017-11-17 00:35:48', 'SALE/POS/2017/11/0017', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'paid', '0', null, '1', null, null, '2', '1', '1.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"2\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"4000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('35', '2017-11-17 00:36:37', 'SALE/POS/2017/11/0018', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.5000', 'completed', 'paid', '0', null, '1', null, null, '3', '1', '1.5000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"1\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('36', '2017-11-17 00:37:26', 'SALE/POS/2017/11/0019', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'paid', '0', null, '1', null, null, '2', '1', '1.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"2\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('37', '2017-11-17 01:00:52', 'SALE/POS/2017/11/0020', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '3.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '3.0000', 'completed', 'paid', '0', null, '1', null, null, '6', '1', '3.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"1.5\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"6000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"},{\"amount\":\"0\",\"currency\":\"THB\",\"rate\":\"32.9000\"},{\"amount\":\"0\",\"currency\":\"MMK\",\"rate\":\"1363.0000\"}]');
INSERT INTO `sma_sales` VALUES ('38', '2017-11-17 01:23:06', 'SALE/POS/2017/11/0021', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'due', '0', null, '1', null, null, '2', '1', '0.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"11\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"0\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('39', '2017-11-17 01:25:12', 'SALE/POS/2017/11/0022', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '7.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '7.0000', 'completed', 'due', '0', null, '1', null, null, '14', '1', '0.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"5\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"8000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('40', '2017-11-17 01:27:48', 'SALE/POS/2017/11/0023', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '3.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '3.0000', 'completed', 'partial', '0', null, '1', null, null, '6', '1', '2.5000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"2\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('41', '2017-11-17 01:29:59', 'SALE/POS/2017/11/0024', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '5.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '5.0000', 'completed', 'due', '0', null, '1', null, null, '10', '1', '0.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"4\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('42', '2017-11-17 01:47:57', 'SALE/POS/2017/11/0025', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '0.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '0.5000', 'completed', 'paid', '0', null, '1', null, null, '1', '1', '0.5000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"0\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('43', '2017-11-17 01:58:17', 'SALE/POS/2017/11/0026', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '7.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '7.5000', 'completed', 'paid', '0', null, '1', null, null, '15', '1', '7.5000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"3\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"20000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('44', '2017-11-17 02:10:35', 'SALE/POS/2017/11/0027', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'paid', '0', null, '1', null, null, '2', '1', '1.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"0\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"5000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('45', '2017-11-17 02:11:11', 'SALE/POS/2017/11/0028', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'paid', '0', null, '1', null, null, '2', '1', '1.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"0\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"5000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('46', '2017-11-17 02:12:27', 'SALE/POS/2017/11/0029', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.5000', 'completed', 'paid', '0', null, '1', null, null, '3', '1', '1.5000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"1\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('47', '2017-11-17 02:27:18', 'SALE/POS/2017/11/0030', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'paid', '0', null, '1', null, null, '2', '1', '1.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"0\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"5000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('48', '2017-11-17 02:27:53', 'SALE/POS/2017/11/0031', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '1.0000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '1.0000', 'completed', 'paid', '0', null, '1', null, null, '2', '1', '1.0000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"0.5\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');
INSERT INTO `sma_sales` VALUES ('49', '2017-11-17 20:19:40', 'SALE/POS/2017/11/0032', '1', 'Walk-in Customer', '3', 'Test Biller', '1', '', '', '2.5000', '0.0000', null, '0.0000', '0.0000', '0.0000', '1', '0.0000', '0.0000', '0.0000', '2.5000', 'completed', 'paid', '0', null, '1', null, null, '5', '1', '2.5000', null, '0.0000', null, null, null, '0.0000', '0.0000', null, '[{\"amount\":\"2\",\"currency\":\"USD\",\"rate\":\"1.0000\"},{\"amount\":\"2000\",\"currency\":\"KHR\",\"rate\":\"4000.0000\"}]');

-- ----------------------------
-- Table structure for sma_sale_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_sale_items`;
CREATE TABLE `sma_sale_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `unit_price` decimal(25,4) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  `sale_item_id` int(11) DEFAULT NULL,
  `product_unit_id` int(11) DEFAULT NULL,
  `product_unit_code` varchar(10) DEFAULT NULL,
  `unit_quantity` decimal(15,4) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`sale_id`),
  KEY `sale_id_2` (`sale_id`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_sale_items
-- ----------------------------
INSERT INTO `sma_sale_items` VALUES ('1', '1', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '120.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '60.0000', '', '0.5000', null, '1', 'can', '120.0000', null);
INSERT INTO `sma_sale_items` VALUES ('2', '2', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '-20.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '-10.0000', '', '0.5000', '1', '1', 'can', '-20.0000', null);
INSERT INTO `sma_sale_items` VALUES ('5', '3', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '2.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '1.0000', '', '0.5000', null, '1', 'can', '2.0000', null);
INSERT INTO `sma_sale_items` VALUES ('10', '5', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '4.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2.0000', '', '0.5000', null, '1', 'can', '4.0000', null);
INSERT INTO `sma_sale_items` VALUES ('11', '6', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '-4.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '-2.0000', '', '0.5000', '10', '1', 'can', '-4.0000', null);
INSERT INTO `sma_sale_items` VALUES ('12', '4', '1', 'C001', 'Fanta', 'standard', null, '3.0000', '3.0000', '12.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '6.0000', '', '3.0000', null, '2', 'case', '2.0000', null);
INSERT INTO `sma_sale_items` VALUES ('14', '7', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', null);
INSERT INTO `sma_sale_items` VALUES ('35', '14', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '5.0000', '', '0.5000', null, '1', 'can', '10.0000', null);
INSERT INTO `sma_sale_items` VALUES ('45', '15', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '4.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2.0000', '', '0.5000', null, '1', 'can', '4.0000', null);
INSERT INTO `sma_sale_items` VALUES ('46', '16', '3', 'C002', 'CoCa', 'standard', null, '6.0000', '6.0000', '12.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '6.0000', '', '6.0000', null, '2', 'case', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('47', '17', '3', 'C002', 'CoCa', 'standard', null, '5.0000', '5.0000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '5.0000', '', '5.0000', null, '2', 'case', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('49', '18', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', null);
INSERT INTO `sma_sale_items` VALUES ('50', '19', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', null);
INSERT INTO `sma_sale_items` VALUES ('52', '20', '1', 'C001', 'Fanta', 'standard', null, '50.0000', '50.0000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '250.0000', '', '50.0000', null, '1', 'can', '5.0000', null);
INSERT INTO `sma_sale_items` VALUES ('53', '21', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', 'kk\r\n');
INSERT INTO `sma_sale_items` VALUES ('54', '21', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('55', '22', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('56', '22', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('57', '23', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('58', '24', '1', 'C001', 'Fanta', 'standard', null, '0.2000', '0.2000', '1.0000', '1', '0.0000', '1', '0.0000', '0.3', '0.3000', '0.2000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('59', '25', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '2.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '1.0000', '', '0.5000', null, '1', 'can', '2.0000', '');
INSERT INTO `sma_sale_items` VALUES ('60', '25', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '2.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '1.0000', '', '0.5000', null, '1', 'can', '2.0000', '');
INSERT INTO `sma_sale_items` VALUES ('61', '26', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('62', '26', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('63', '26', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('64', '26', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('65', '27', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('66', '27', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('67', '27', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('68', '27', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('69', '28', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('70', '28', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('71', '28', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('72', '29', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('73', '29', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('74', '29', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('75', '30', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('76', '30', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('77', '30', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('78', '31', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('79', '32', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '5.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '2.5000', '', '0.5000', null, '1', 'can', '5.0000', '');
INSERT INTO `sma_sale_items` VALUES ('80', '32', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('81', '33', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '6.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '3.0000', '', '0.5000', null, '1', 'can', '6.0000', '');
INSERT INTO `sma_sale_items` VALUES ('82', '33', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '6.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '3.0000', '', '0.5000', null, '1', 'can', '6.0000', '');
INSERT INTO `sma_sale_items` VALUES ('83', '34', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('84', '34', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('85', '35', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('86', '35', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('87', '35', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('88', '36', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('89', '36', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('90', '37', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '6.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '3.0000', '', '0.5000', null, '1', 'can', '6.0000', '');
INSERT INTO `sma_sale_items` VALUES ('91', '38', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('92', '38', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('93', '39', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '7.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '3.5000', '', '0.5000', null, '1', 'can', '7.0000', '');
INSERT INTO `sma_sale_items` VALUES ('94', '39', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '7.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '3.5000', '', '0.5000', null, '1', 'can', '7.0000', '');
INSERT INTO `sma_sale_items` VALUES ('95', '40', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '3.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '1.5000', '', '0.5000', null, '1', 'can', '3.0000', '');
INSERT INTO `sma_sale_items` VALUES ('96', '40', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '3.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '1.5000', '', '0.5000', null, '1', 'can', '3.0000', '');
INSERT INTO `sma_sale_items` VALUES ('97', '41', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '10.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '5.0000', '', '0.5000', null, '1', 'can', '10.0000', '');
INSERT INTO `sma_sale_items` VALUES ('98', '42', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('99', '43', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '8.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '4.0000', '', '0.5000', null, '1', 'can', '8.0000', '');
INSERT INTO `sma_sale_items` VALUES ('100', '43', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '7.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '3.5000', '', '0.5000', null, '1', 'can', '7.0000', '');
INSERT INTO `sma_sale_items` VALUES ('101', '44', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('102', '44', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('103', '45', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('104', '45', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('105', '46', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('106', '46', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('107', '46', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('108', '47', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('109', '47', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('110', '48', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('111', '48', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('112', '49', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('113', '49', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('114', '49', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('115', '49', '1', 'C001', 'Fanta', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');
INSERT INTO `sma_sale_items` VALUES ('116', '49', '3', 'C002', 'CoCa', 'standard', null, '0.5000', '0.5000', '1.0000', '1', '0.0000', '1', '0.0000', '0', '0.0000', '0.5000', '', '0.5000', null, '1', 'can', '1.0000', '');

-- ----------------------------
-- Table structure for sma_sessions
-- ----------------------------
DROP TABLE IF EXISTS `sma_sessions`;
CREATE TABLE `sma_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_sessions
-- ----------------------------
INSERT INTO `sma_sessions` VALUES ('0dlkaf4lv0a7pl8q780r8enh0i8c8coi', '::1', '1511190530', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313139303233363B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('0hrn4n8f06c26li687qnuirj1tqruun7', '::1', '1511190236', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313139303233363B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('0qsp8qee9l2r7jpn9v632ib6v9sf27ef', '::1', '1511193193', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313139333034343B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313933303132223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('258dhv4ei3nrpvdc1drt2atee7tntm4n', '::1', '1511184773', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138343533313B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('2relvhl5ge2tee9sv8gq0mcu68q6u66b', '::1', '1511191514', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313139313235313B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('46b5jqko9gb6kfl4mmtanr6ogebp6po5', '::1', '1511192940', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313139323634363B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313831353330223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B6C6173745F61637469766974797C693A313531313139323638303B72656769737465725F69647C733A313A2231223B636173685F696E5F68616E647C733A393A22313030302E30303030223B72656769737465725F6F70656E5F74696D657C733A31393A22323031372D31302D30332031303A34383A3538223B);
INSERT INTO `sma_sessions` VALUES ('6p0fmtvpfsbrevpq5b26tuhlqfc7r92g', '::1', '1511183645', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138333339343B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('alc39altjm356n2pm8g98si9qs6frncv', '::1', '1511182406', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138323233343B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('d1njoras0dlmpmgfflksv5gdv4rrbfrc', '::1', '1511183120', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138333039323B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('d777ccmplnf67cn4g5m3c8h9qu1j7gpd', '::1', '1511189759', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138393439383B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('de6qki7gsfq96il9tv8r5v9s04m7odo1', '::1', '1511192299', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313139323030333B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('dik1qb2ms1mjbi2c5hbtuh4dvt1s8vo2', '::1', '1511182904', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138323636383B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('f9tvtijhs8n1o643pqhvt4a2mja9js9v', '::1', '1511191222', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313139303933343B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('ge4jik44vuv1pestkolgoh50rmsr8jog', '::1', '1511188193', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138373931363B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('gpp0ahh04q63fr413niaabja38j9jp4d', '::1', '1511188969', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138383534353B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('hs2n6ihc9hsoq1dsid03nirpvd2uuh1o', '::1', '1511190811', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313139303536353B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('i79r5tkl34ru6ggkl327nlgarhv1ajn1', '::1', '1511184091', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138333834313B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('jlja0qdnst1b6ldbva01pmbdnl1phol8', '::1', '1511188508', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138383233313B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('ml8gqqscldej40rmg80qeiosiag5ufhg', '::1', '1511187868', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138373631303B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('n3evn3r5ebu4vjf6kdfiahfo88fnb0gm', '::1', '1511185104', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138343835333B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('nffv8eu10md6provfhd70gk614begmuo', '::1', '1511186408', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138363133393B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('nh2kqhe3k0kk79ohnm5vo0g0r9gfjch7', '::1', '1511190089', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138393834383B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('sj0rb0qg78cln2r6mbgg1mmnh335ova8', '::1', '1511185366', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138353239333B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('t97h2lq5ansmun17r3ofg1ktnv1oaqai', '::1', '1511186137', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138353831393B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('tdp0871hmnq46l12e4feo7otn7gke20a', '::1', '1511184497', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138343231333B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);
INSERT INTO `sma_sessions` VALUES ('tr06qeokpvnubegj4cnqohoo0lhhqaj6', '::1', '1511191850', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313139313630393B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B757365725F637372667C733A32303A2271326B67507051424A6D377673466545334E4F54223B);
INSERT INTO `sma_sessions` VALUES ('tui4eu1mu57f2d7pfs31ednp308acia8', '::1', '1511186686', 0x5F5F63695F6C6173745F726567656E65726174657C693A313531313138363437343B7265717565737465645F706167657C733A32343A2270726F64756374732F6164645F7573696E675F73746F636B223B6964656E746974797C733A353A226F776E6572223B757365726E616D657C733A353A226F776E6572223B656D61696C7C733A32303A226B6865616E672E68756F40676D61696C2E636F6D223B757365725F69647C733A313A2231223B6F6C645F6C6173745F6C6F67696E7C733A31303A2231353131313739393233223B6C6173745F69707C733A333A223A3A31223B6176617461727C4E3B67656E6465727C733A343A226D616C65223B67726F75705F69647C733A313A2231223B77617265686F7573655F69647C4E3B766965775F72696768747C733A313A2230223B656469745F72696768747C733A313A2230223B616C6C6F775F646973636F756E747C733A313A2230223B62696C6C65725F69647C4E3B636F6D70616E795F69647C4E3B73686F775F636F73747C733A313A2230223B73686F775F70726963657C733A313A2230223B);

-- ----------------------------
-- Table structure for sma_settings
-- ----------------------------
DROP TABLE IF EXISTS `sma_settings`;
CREATE TABLE `sma_settings` (
  `setting_id` int(1) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `logo2` varchar(255) NOT NULL,
  `site_name` varchar(55) NOT NULL,
  `language` varchar(20) NOT NULL,
  `default_warehouse` int(2) NOT NULL,
  `accounting_method` tinyint(4) NOT NULL DEFAULT '0',
  `default_currency` varchar(3) NOT NULL,
  `default_tax_rate` int(2) NOT NULL,
  `rows_per_page` int(2) NOT NULL,
  `version` varchar(10) NOT NULL DEFAULT '1.0',
  `default_tax_rate2` int(11) NOT NULL DEFAULT '0',
  `dateformat` int(11) NOT NULL,
  `sales_prefix` varchar(20) DEFAULT NULL,
  `quote_prefix` varchar(20) DEFAULT NULL,
  `purchase_prefix` varchar(20) DEFAULT NULL,
  `transfer_prefix` varchar(20) DEFAULT NULL,
  `delivery_prefix` varchar(20) DEFAULT NULL,
  `payment_prefix` varchar(20) DEFAULT NULL,
  `return_prefix` varchar(20) DEFAULT NULL,
  `returnp_prefix` varchar(20) DEFAULT NULL,
  `expense_prefix` varchar(20) DEFAULT NULL,
  `convert_prefix` varchar(20) DEFAULT NULL,
  `item_addition` tinyint(1) NOT NULL DEFAULT '0',
  `theme` varchar(20) NOT NULL,
  `product_serial` tinyint(4) NOT NULL,
  `default_discount` int(11) NOT NULL,
  `product_discount` tinyint(1) NOT NULL DEFAULT '0',
  `discount_method` tinyint(4) NOT NULL,
  `tax1` tinyint(4) NOT NULL,
  `tax2` tinyint(4) NOT NULL,
  `overselling` tinyint(1) NOT NULL DEFAULT '0',
  `restrict_user` tinyint(4) NOT NULL DEFAULT '0',
  `restrict_calendar` tinyint(4) NOT NULL DEFAULT '0',
  `timezone` varchar(100) DEFAULT NULL,
  `iwidth` int(11) NOT NULL DEFAULT '0',
  `iheight` int(11) NOT NULL,
  `twidth` int(11) NOT NULL,
  `theight` int(11) NOT NULL,
  `watermark` tinyint(1) DEFAULT NULL,
  `reg_ver` tinyint(1) DEFAULT NULL,
  `allow_reg` tinyint(1) DEFAULT NULL,
  `reg_notification` tinyint(1) DEFAULT NULL,
  `auto_reg` tinyint(1) DEFAULT NULL,
  `protocol` varchar(20) NOT NULL DEFAULT 'mail',
  `mailpath` varchar(55) DEFAULT '/usr/sbin/sendmail',
  `smtp_host` varchar(100) DEFAULT NULL,
  `smtp_user` varchar(100) DEFAULT NULL,
  `smtp_pass` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(10) DEFAULT '25',
  `smtp_crypto` varchar(10) DEFAULT NULL,
  `corn` datetime DEFAULT NULL,
  `customer_group` int(11) NOT NULL,
  `default_email` varchar(100) NOT NULL,
  `mmode` tinyint(1) NOT NULL,
  `bc_fix` tinyint(4) NOT NULL DEFAULT '0',
  `auto_detect_barcode` tinyint(1) NOT NULL DEFAULT '0',
  `captcha` tinyint(1) NOT NULL DEFAULT '1',
  `reference_format` tinyint(1) NOT NULL DEFAULT '1',
  `racks` tinyint(1) DEFAULT '0',
  `attributes` tinyint(1) NOT NULL DEFAULT '0',
  `product_expiry` tinyint(1) NOT NULL DEFAULT '0',
  `decimals` tinyint(2) NOT NULL DEFAULT '2',
  `qty_decimals` tinyint(2) NOT NULL DEFAULT '2',
  `decimals_sep` varchar(2) NOT NULL DEFAULT '.',
  `thousands_sep` varchar(2) NOT NULL DEFAULT ',',
  `invoice_view` tinyint(1) DEFAULT '0',
  `default_biller` int(11) DEFAULT NULL,
  `envato_username` varchar(50) DEFAULT NULL,
  `purchase_code` varchar(100) DEFAULT NULL,
  `rtl` tinyint(1) DEFAULT '0',
  `each_spent` decimal(15,4) DEFAULT NULL,
  `ca_point` tinyint(4) DEFAULT NULL,
  `each_sale` decimal(15,4) DEFAULT NULL,
  `sa_point` tinyint(4) DEFAULT NULL,
  `update` tinyint(1) DEFAULT '0',
  `sac` tinyint(1) DEFAULT '0',
  `display_all_products` tinyint(1) DEFAULT '0',
  `display_symbol` tinyint(1) DEFAULT NULL,
  `symbol` varchar(50) DEFAULT NULL,
  `remove_expired` tinyint(1) DEFAULT '0',
  `barcode_separator` varchar(2) NOT NULL DEFAULT '_',
  `set_focus` tinyint(1) NOT NULL DEFAULT '0',
  `price_group` int(11) DEFAULT NULL,
  `barcode_img` tinyint(1) NOT NULL DEFAULT '1',
  `ppayment_prefix` varchar(20) DEFAULT 'POP',
  `disable_editing` smallint(6) DEFAULT '90',
  `qa_prefix` varchar(55) DEFAULT NULL,
  `update_cost` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_settings
-- ----------------------------
INSERT INTO `sma_settings` VALUES ('1', 'logo2.png', 'logo3.png', 'Tech Plus Cambodia', 'english', '1', '2', 'USD', '1', '10', '3.0.2.24', '1', '5', 'SALE', 'QUOTE', 'PO', 'TR', 'DO', 'IPAY', 'SR', 'PR', '', null, '0', 'default', '1', '1', '1', '1', '1', '1', '1', '1', '0', 'Asia/Kuala_Lumpur', '800', '800', '60', '60', '0', '0', '0', '0', null, 'mail', '/usr/sbin/sendmail', 'pop.gmail.com', 'contact@sma.tecdiary.org', 'jEFTM4T63AiQ9dsidxhPKt9CIg4HQjCN58n/RW9vmdC/UDXCzRLR469ziZ0jjpFlbOg43LyoSmpJLBkcAHh0Yw==', '25', null, null, '1', 'contact@tecdiary.com', '0', '4', '1', '0', '2', '1', '1', '0', '2', '2', '.', ',', '0', '3', 'bspsk1234', '465ef3e6-dc77-42b7-b309-41cc68fd3e78', '0', null, null, null, null, '0', '0', '0', '0', '$', '0', '_', '0', '1', '1', 'POP', '90', '', '0');

-- ----------------------------
-- Table structure for sma_skrill
-- ----------------------------
DROP TABLE IF EXISTS `sma_skrill`;
CREATE TABLE `sma_skrill` (
  `id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `account_email` varchar(255) NOT NULL DEFAULT 'testaccount2@moneybookers.com',
  `secret_word` varchar(20) NOT NULL DEFAULT 'mbtest',
  `skrill_currency` varchar(3) NOT NULL DEFAULT 'USD',
  `fixed_charges` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `extra_charges_my` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `extra_charges_other` decimal(25,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_skrill
-- ----------------------------
INSERT INTO `sma_skrill` VALUES ('1', '1', 'testaccount2@moneybookers.com', 'mbtest', 'USD', '0.0000', '0.0000', '0.0000');

-- ----------------------------
-- Table structure for sma_stock_counts
-- ----------------------------
DROP TABLE IF EXISTS `sma_stock_counts`;
CREATE TABLE `sma_stock_counts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `initial_file` varchar(50) NOT NULL,
  `final_file` varchar(50) DEFAULT NULL,
  `brands` varchar(50) DEFAULT NULL,
  `brand_names` varchar(100) DEFAULT NULL,
  `categories` varchar(50) DEFAULT NULL,
  `category_names` varchar(100) DEFAULT NULL,
  `note` text,
  `products` int(11) DEFAULT NULL,
  `rows` int(11) DEFAULT NULL,
  `differences` int(11) DEFAULT NULL,
  `matches` int(11) DEFAULT NULL,
  `missing` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `finalized` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_stock_counts
-- ----------------------------
INSERT INTO `sma_stock_counts` VALUES ('1', '2017-10-07 21:02:00', '', '1', 'full', '5921d64e336ab4a64e25f28e23c98636.csv', null, '', '', '', '', null, '3', '5', null, null, null, '1', null, null, null);

-- ----------------------------
-- Table structure for sma_stock_count_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_stock_count_items`;
CREATE TABLE `sma_stock_count_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_count_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_variant` varchar(55) DEFAULT NULL,
  `product_variant_id` int(11) DEFAULT NULL,
  `expected` decimal(15,4) NOT NULL,
  `counted` decimal(15,4) NOT NULL,
  `cost` decimal(25,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_count_id` (`stock_count_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_stock_count_items
-- ----------------------------

-- ----------------------------
-- Table structure for sma_suspended_bills
-- ----------------------------
DROP TABLE IF EXISTS `sma_suspended_bills`;
CREATE TABLE `sma_suspended_bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(11) NOT NULL,
  `customer` varchar(55) DEFAULT NULL,
  `count` int(11) NOT NULL,
  `order_discount_id` varchar(20) DEFAULT NULL,
  `order_tax_id` int(11) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `suspend_note` varchar(255) DEFAULT NULL,
  `shipping` decimal(15,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_suspended_bills
-- ----------------------------

-- ----------------------------
-- Table structure for sma_suspended_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_suspended_items`;
CREATE TABLE `sma_suspended_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suspend_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `net_unit_price` decimal(25,4) NOT NULL,
  `unit_price` decimal(25,4) NOT NULL,
  `quantity` decimal(15,4) DEFAULT '0.0000',
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `real_unit_price` decimal(25,4) DEFAULT NULL,
  `product_unit_id` int(11) DEFAULT NULL,
  `product_unit_code` varchar(10) DEFAULT NULL,
  `unit_quantity` decimal(15,4) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_suspended_items
-- ----------------------------

-- ----------------------------
-- Table structure for sma_tax_rates
-- ----------------------------
DROP TABLE IF EXISTS `sma_tax_rates`;
CREATE TABLE `sma_tax_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `rate` decimal(12,4) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_tax_rates
-- ----------------------------
INSERT INTO `sma_tax_rates` VALUES ('1', 'No Tax', 'NT', '0.0000', '2');
INSERT INTO `sma_tax_rates` VALUES ('2', 'VAT @10%', 'VAT10', '10.0000', '1');
INSERT INTO `sma_tax_rates` VALUES ('3', 'GST @6%', 'GST', '6.0000', '1');
INSERT INTO `sma_tax_rates` VALUES ('4', 'VAT @20%', 'VT20', '20.0000', '1');

-- ----------------------------
-- Table structure for sma_transfers
-- ----------------------------
DROP TABLE IF EXISTS `sma_transfers`;
CREATE TABLE `sma_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_no` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_warehouse_id` int(11) NOT NULL,
  `from_warehouse_code` varchar(55) NOT NULL,
  `from_warehouse_name` varchar(55) NOT NULL,
  `to_warehouse_id` int(11) NOT NULL,
  `to_warehouse_code` varchar(55) NOT NULL,
  `to_warehouse_name` varchar(55) NOT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) DEFAULT NULL,
  `total_tax` decimal(25,4) DEFAULT NULL,
  `grand_total` decimal(25,4) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `status` varchar(55) NOT NULL DEFAULT 'pending',
  `shipping` decimal(25,4) NOT NULL DEFAULT '0.0000',
  `attachment` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_transfers
-- ----------------------------

-- ----------------------------
-- Table structure for sma_transfer_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_transfer_items`;
CREATE TABLE `sma_transfer_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `net_unit_cost` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) DEFAULT NULL,
  `quantity_balance` decimal(15,4) NOT NULL,
  `unit_cost` decimal(25,4) DEFAULT NULL,
  `real_unit_cost` decimal(25,4) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `product_unit_id` int(11) DEFAULT NULL,
  `product_unit_code` varchar(10) DEFAULT NULL,
  `unit_quantity` decimal(15,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transfer_id` (`transfer_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_transfer_items
-- ----------------------------

-- ----------------------------
-- Table structure for sma_units
-- ----------------------------
DROP TABLE IF EXISTS `sma_units`;
CREATE TABLE `sma_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(55) NOT NULL,
  `base_unit` int(11) DEFAULT NULL,
  `operator` varchar(1) DEFAULT NULL,
  `unit_value` varchar(55) DEFAULT NULL,
  `operation_value` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `base_unit` (`base_unit`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_units
-- ----------------------------
INSERT INTO `sma_units` VALUES ('1', 'can', 'Can', null, null, null, null);
INSERT INTO `sma_units` VALUES ('2', 'case', 'Case', '1', '*', null, '12');

-- ----------------------------
-- Table structure for sma_users
-- ----------------------------
DROP TABLE IF EXISTS `sma_users`;
CREATE TABLE `sma_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `last_ip_address` varbinary(45) DEFAULT NULL,
  `ip_address` varbinary(45) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(55) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `warehouse_id` int(10) unsigned DEFAULT NULL,
  `biller_id` int(10) unsigned DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `show_cost` tinyint(1) DEFAULT '0',
  `show_price` tinyint(1) DEFAULT '0',
  `award_points` int(11) DEFAULT '0',
  `view_right` tinyint(1) NOT NULL DEFAULT '0',
  `edit_right` tinyint(1) NOT NULL DEFAULT '0',
  `allow_discount` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`,`warehouse_id`,`biller_id`),
  KEY `group_id_2` (`group_id`,`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_users
-- ----------------------------
INSERT INTO `sma_users` VALUES ('1', 0x3A3A31, 0x0000, 'owner', '2c8ab736b2ccab4f50e72d5fd7d21020cbb77ae7', null, 'kheang.huo@gmail.com', null, null, null, null, '1351661704', '1511193185', '1', 'Owner', 'Owner', 'Tech Plus ', '093467272', null, 'male', '1', null, null, null, '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for sma_user_logins
-- ----------------------------
DROP TABLE IF EXISTS `sma_user_logins`;
CREATE TABLE `sma_user_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_user_logins
-- ----------------------------
INSERT INTO `sma_user_logins` VALUES ('1', '1', null, 0x3A3A31, 'owner@tecdiary.com', '2017-10-18 05:06:41');
INSERT INTO `sma_user_logins` VALUES ('2', '1', null, 0x3A3A31, 'owner@tecdiary.com', '2017-10-19 05:31:23');
INSERT INTO `sma_user_logins` VALUES ('3', '1', null, 0x3A3A31, 'owner@tecdiary.com', '2017-10-20 04:37:32');
INSERT INTO `sma_user_logins` VALUES ('4', '1', null, 0x3A3A31, 'owner@tecdiary.com', '2017-10-21 04:47:24');
INSERT INTO `sma_user_logins` VALUES ('5', '1', null, 0x3A3A31, 'owner@tecdiary.com', '2017-10-21 04:57:42');
INSERT INTO `sma_user_logins` VALUES ('6', '1', null, 0x3A3A31, 'owner@tecdiary.com', '2017-10-21 05:17:38');
INSERT INTO `sma_user_logins` VALUES ('7', '1', null, 0x3A3A31, 'owner@tecdiary.com', '2017-10-28 05:38:20');
INSERT INTO `sma_user_logins` VALUES ('8', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-10-28 05:40:40');
INSERT INTO `sma_user_logins` VALUES ('9', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-10-28 05:42:18');
INSERT INTO `sma_user_logins` VALUES ('10', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-10-28 05:43:29');
INSERT INTO `sma_user_logins` VALUES ('11', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-10-28 05:47:32');
INSERT INTO `sma_user_logins` VALUES ('12', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-10-28 06:01:50');
INSERT INTO `sma_user_logins` VALUES ('13', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-10-29 00:23:37');
INSERT INTO `sma_user_logins` VALUES ('14', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-10-29 00:24:23');
INSERT INTO `sma_user_logins` VALUES ('15', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-10-29 00:50:14');
INSERT INTO `sma_user_logins` VALUES ('16', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-10-31 04:43:11');
INSERT INTO `sma_user_logins` VALUES ('17', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-11-06 07:10:59');
INSERT INTO `sma_user_logins` VALUES ('18', '1', null, 0x3A3A31, 'kheang.huo@gmail.com', '2017-11-16 05:37:46');
INSERT INTO `sma_user_logins` VALUES ('19', '1', null, 0x3230332E3138392E3135332E313931, 'kheang.huo@gmail.com', '2017-11-15 19:08:27');
INSERT INTO `sma_user_logins` VALUES ('20', '1', null, 0x3230332E3138392E3135332E313931, 'kheang.huo@gmail.com', '2017-11-15 19:08:27');
INSERT INTO `sma_user_logins` VALUES ('21', '1', null, 0x3130332E3139372E3130352E3838, 'kheang.huo@gmail.com', '2017-11-15 20:08:47');
INSERT INTO `sma_user_logins` VALUES ('22', '1', null, 0x3A3A31, 'owner', '2017-11-15 20:45:51');
INSERT INTO `sma_user_logins` VALUES ('23', '1', null, 0x3A3A31, 'owner', '2017-11-15 21:13:33');
INSERT INTO `sma_user_logins` VALUES ('24', '1', null, 0x3A3A31, 'owner', '2017-11-16 19:39:35');
INSERT INTO `sma_user_logins` VALUES ('25', '1', null, 0x3A3A31, 'owner', '2017-11-17 17:47:48');
INSERT INTO `sma_user_logins` VALUES ('26', '1', null, 0x3A3A31, 'owner', '2017-11-17 19:44:32');
INSERT INTO `sma_user_logins` VALUES ('27', '1', null, 0x3A3A31, 'owner', '2017-11-20 19:12:03');
INSERT INTO `sma_user_logins` VALUES ('28', '1', null, 0x3A3A31, 'owner', '2017-11-20 19:38:50');
INSERT INTO `sma_user_logins` VALUES ('29', '1', null, 0x3A3A31, 'owner', '2017-11-20 22:44:32');
INSERT INTO `sma_user_logins` VALUES ('30', '1', null, 0x3A3A31, 'owner', '2017-11-20 22:50:12');
INSERT INTO `sma_user_logins` VALUES ('31', '1', null, 0x3A3A31, 'owner', '2017-11-20 22:53:05');

-- ----------------------------
-- Table structure for sma_using_stocks
-- ----------------------------
DROP TABLE IF EXISTS `sma_using_stocks`;
CREATE TABLE `sma_using_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` text,
  `attachment` varchar(55) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `count_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_using_stocks
-- ----------------------------
INSERT INTO `sma_using_stocks` VALUES ('9', '2017-11-20 22:18:00', 'PR/2017/11/0012', '1', '', 'a57f54593d8403bdd8e546fcb8ced21c.jpg', '1', null, null, null);

-- ----------------------------
-- Table structure for sma_using_stock_items
-- ----------------------------
DROP TABLE IF EXISTS `sma_using_stock_items`;
CREATE TABLE `sma_using_stock_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `using_stock_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL DEFAULT '0',
  `serial_no` varchar(255) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `adjustment_id` (`using_stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_using_stock_items
-- ----------------------------
INSERT INTO `sma_using_stock_items` VALUES ('27', '9', '1', null, '3.0000', '1', '0', '', 'subtraction');

-- ----------------------------
-- Table structure for sma_variants
-- ----------------------------
DROP TABLE IF EXISTS `sma_variants`;
CREATE TABLE `sma_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_variants
-- ----------------------------

-- ----------------------------
-- Table structure for sma_warehouses
-- ----------------------------
DROP TABLE IF EXISTS `sma_warehouses`;
CREATE TABLE `sma_warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `map` varchar(255) DEFAULT NULL,
  `phone` varchar(55) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `price_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_warehouses
-- ----------------------------
INSERT INTO `sma_warehouses` VALUES ('1', 'WHI', 'Warehouse 1', '<p>Address, City</p>', null, '012345678', 'whi@tecdiary.com', null);
INSERT INTO `sma_warehouses` VALUES ('2', 'WHII', 'Warehouse 2', '<p>Warehouse 2, Jalan Sultan Ismail, 54000, Kuala Lumpur</p>', null, '0105292122', 'whii@tecdiary.com', null);

-- ----------------------------
-- Table structure for sma_warehouses_products
-- ----------------------------
DROP TABLE IF EXISTS `sma_warehouses_products`;
CREATE TABLE `sma_warehouses_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `rack` varchar(55) DEFAULT NULL,
  `avg_cost` decimal(25,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_warehouses_products
-- ----------------------------
INSERT INTO `sma_warehouses_products` VALUES ('1', '1', '1', '5.0000', null, '0.1250');
INSERT INTO `sma_warehouses_products` VALUES ('4', '3', '1', '-72.0000', null, '0.4000');
INSERT INTO `sma_warehouses_products` VALUES ('5', '1', '2', '0.0000', null, '0.0000');
INSERT INTO `sma_warehouses_products` VALUES ('6', '3', '2', '0.0000', null, '0.4000');

-- ----------------------------
-- Table structure for sma_warehouses_products_variants
-- ----------------------------
DROP TABLE IF EXISTS `sma_warehouses_products_variants`;
CREATE TABLE `sma_warehouses_products_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `rack` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `option_id` (`option_id`),
  KEY `product_id` (`product_id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sma_warehouses_products_variants
-- ----------------------------
DROP TRIGGER IF EXISTS `delete_gl_trans_convert_update`;
DELIMITER ;;
CREATE TRIGGER `delete_gl_trans_convert_update` AFTER UPDATE ON `sma_convert` FOR EACH ROW BEGIN

	IF NEW.updated_by THEN
	
		DELETE FROM erp_gl_trans WHERE erp_gl_trans.reference_no = NEW.reference_no;
	
	END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `purchase_item_insert`;
DELIMITER ;;
CREATE TRIGGER `purchase_item_insert` BEFORE INSERT ON `sma_purchase_items` FOR EACH ROW BEGIN

IF NEW.option_id = 0 THEN

SET NEW.option_id = NULL ;
END
IF ;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `purchase_item_update`;
DELIMITER ;;
CREATE TRIGGER `purchase_item_update` BEFORE UPDATE ON `sma_purchase_items` FOR EACH ROW BEGIN

IF NEW.option_id = 0 THEN

SET NEW.option_id = NULL ;
END
IF ;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `sale_item_insert`;
DELIMITER ;;
CREATE TRIGGER `sale_item_insert` BEFORE INSERT ON `sma_sale_items` FOR EACH ROW BEGIN

IF NEW.option_id = 0 THEN

SET NEW.option_id = NULL ;
END
IF ;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `sale_item_update`;
DELIMITER ;;
CREATE TRIGGER `sale_item_update` BEFORE UPDATE ON `sma_sale_items` FOR EACH ROW BEGIN

IF NEW.option_id = 0 THEN

SET NEW.option_id = NULL ;
END
IF ;
END
;;
DELIMITER ;
