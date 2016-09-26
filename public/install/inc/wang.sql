/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : wang

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-08-31 16:22:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for #wang#_admin
-- ----------------------------
DROP TABLE IF EXISTS `#wang#_admin`;
CREATE TABLE `#wang#_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '登录名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `encrypt` varchar(6) NOT NULL DEFAULT '',
  `realname` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `usertype` tinyint(4) NOT NULL DEFAULT '0',
  `logintime` int(10) unsigned NOT NULL COMMENT '登录时间',
  `loginip` varchar(30) NOT NULL COMMENT '登录IP',
  `islock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '锁定状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #wang#_admin
-- ----------------------------
INSERT INTO `#wang#_admin` VALUES ('1', 'wyn', '0d3cde9ac054e95ed35d23155a2d78e9', 'tuvwxy', '', '', '0', '1472627740', '0.0.0.0', '0');
INSERT INTO `#wang#_admin` VALUES ('2', 'wyn3', '', '4lRKTu', '', '553212320@qq.com', '0', '1472540993', '0.0.0.0', '1');

-- ----------------------------
-- Table structure for #wang#_article
-- ----------------------------
DROP TABLE IF EXISTS `#wang#_article`;
CREATE TABLE `#wang#_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '标题',
  `shorttitle` varchar(30) NOT NULL DEFAULT '' COMMENT '副标题',
  `color` char(10) NOT NULL DEFAULT '' COMMENT '标题颜色',
  `copyfrom` varchar(30) NOT NULL DEFAULT '',
  `author` varchar(30) NOT NULL DEFAULT '',
  `keywords` varchar(50) DEFAULT '' COMMENT '关键字',
  `litpic` varchar(150) NOT NULL DEFAULT '' COMMENT '缩略图',
  `content` text COMMENT '内容',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要描述',
  `publishtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `click` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  `commentflag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '允许评论',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '属性',
  `jumpurl` varchar(200) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1回收站',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'admin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #wang#_article
-- ----------------------------
INSERT INTO `#wang#_article` VALUES ('1', '新网站开通上线', '', '', '', '', '新网站开通上线', '', '新网站开通上线新网站开通上线新网站开通上线新网站开通上线新网站开通上线', '新网站开通上线新网站开通上线', '1470814964', '0', '0', '7', '1', '0', '', '1', '0', '0');

-- ----------------------------
-- Table structure for #wang#_category
-- ----------------------------
DROP TABLE IF EXISTS `#wang#_category`;
CREATE TABLE `#wang#_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '栏目分类名称',
  `ename` varchar(200) NOT NULL DEFAULT '' COMMENT '别名',
  `catpic` varchar(150) NOT NULL DEFAULT '',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类',
  `modelid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属模型',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类别',
  `seotitle` varchar(50) NOT NULL DEFAULT '',
  `keywords` varchar(50) DEFAULT '' COMMENT '关键字',
  `description` varchar(255) DEFAULT '' COMMENT '关键字',
  `template_category` varchar(60) NOT NULL DEFAULT '',
  `template_list` varchar(60) NOT NULL DEFAULT '',
  `template_show` varchar(60) NOT NULL DEFAULT '',
  `content` text COMMENT '内容',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '显示',
  `sort` smallint(6) NOT NULL DEFAULT '100' COMMENT '排序',
  `position` varchar(6) NOT NULL DEFAULT '1' COMMENT '导航出现的位置，默认1：主导航；2：底部；3：侧边',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #wang#_category
-- ----------------------------
INSERT INTO `#wang#_category` VALUES ('1', '产品中心', 'chanpinzhongxin', '', '0', '3', '0', '', '', '', '', 'List_product.html', 'Show_product.html', null, '0', '1', '1');
INSERT INTO `#wang#_category` VALUES ('2', '公司简介', 'about', '', '0', '2', '0', '', '', 'edi111t公司简介', '', 'List_page.html', 'Show_page.html', 'edi11t公司简介公司简介公司简介', '0', '100', '1');
INSERT INTO `#wang#_category` VALUES ('4', '联系我们', 'contact', '', '0', '2', '0', '', '', '联系我们联系我们', '', 'List_page.html', 'Show_page.html', null, '0', '50', '1');
INSERT INTO `#wang#_category` VALUES ('6', '电脑设备', 'computer', '', '1', '3', '0', '', '', '分类选择', '', 'List_product.html', 'Show_product.html', null, '0', '50', '1');
INSERT INTO `#wang#_category` VALUES ('7', '新闻中心', 'news', '', '0', '1', '0', '', '', '', '', 'List_article.html', 'Show_article.html', null, '0', '1', '1');
INSERT INTO `#wang#_category` VALUES ('8', '行业新闻', 'hangyexinwen', '', '7', '1', '0', '', '', '', '', 'List_article.html', 'Show_article.html', null, '0', '2', '1');

-- ----------------------------
-- Table structure for #wang#_log
-- ----------------------------
DROP TABLE IF EXISTS `#wang#_log`;
CREATE TABLE `#wang#_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '日志类型 1，登入；2，操作',
  `datetime` int(10) unsigned NOT NULL COMMENT '操作时间',
  `ip` varchar(15) DEFAULT '0' COMMENT '登入ip',
  `content` varchar(255) DEFAULT '' COMMENT '操作内容',
  `username` varchar(255) DEFAULT NULL,
  `userid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for #wang#_model
-- ----------------------------
DROP TABLE IF EXISTS `#wang#_model`;
CREATE TABLE `#wang#_model` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `tablename` varchar(30) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `template_category` varchar(60) NOT NULL DEFAULT '',
  `template_list` varchar(60) NOT NULL DEFAULT '',
  `template_show` varchar(60) NOT NULL DEFAULT '',
  `sort` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #wang#_model
-- ----------------------------
INSERT INTO `#wang#_model` VALUES ('1', '文章模型', '', 'article', '1', '', 'List_article.html', 'Show_article.html', '1');
INSERT INTO `#wang#_model` VALUES ('2', '单页模型', '', 'category', '1', '', 'List_page.html', 'Show_page.html', '2');
INSERT INTO `#wang#_model` VALUES ('3', '产品模型', '', 'product', '1', '', 'List_product.html', 'Show_product.html', '3');
INSERT INTO `#wang#_model` VALUES ('4', '图片模型', '', 'picture', '1', '', 'List_picture.html', 'Show_picture.html', '4');
INSERT INTO `#wang#_model` VALUES ('5', '软件下载模型', '', 'soft', '1', '', 'List_soft.html', 'Show_soft.html', '5');

-- ----------------------------
-- Table structure for #wang#_product
-- ----------------------------
DROP TABLE IF EXISTS `#wang#_product`;
CREATE TABLE `#wang#_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '标题',
  `color` char(10) NOT NULL DEFAULT '' COMMENT '标题颜色',
  `keywords` varchar(50) DEFAULT '' COMMENT '关键字',
  `litpic` varchar(150) NOT NULL DEFAULT '' COMMENT '缩略图',
  `pictureurls` text COMMENT '图片地址',
  `content` text COMMENT '内容',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要描述',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `marketprice` decimal(8,2) NOT NULL DEFAULT '0.00',
  `brand` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌',
  `units` varchar(50) NOT NULL DEFAULT '' COMMENT '单位',
  `specification` varchar(50) NOT NULL DEFAULT '' COMMENT '规格',
  `publishtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `click` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  `commentflag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '允许评论',
  `flag` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '属性',
  `jumpurl` varchar(200) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1回收站',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'admin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #wang#_product
-- ----------------------------
INSERT INTO `#wang#_product` VALUES ('3', '士大夫撒', '', '', '', null, '从SQL Server转到Oracle也许会感到不适，因为Oracle里没有文件组和数据文件的概念。但是有表空间的概念，表空间是Oracle的逻辑结构，一个Oracle数据库可以有一个或者多个表空间，一个表空间又对应着多个物理的数据库文件。其实SQL Server的文件组转到Oracle就是表空间，Oracle的表空间转到SQL Server就是文件组。这篇博文重点来讨论Oracle的表空间', '', '0.00', '0.00', '', '', '', '0', '0', '750', '1', '1', '0', '', '0', '0', '0');
INSERT INTO `#wang#_product` VALUES ('5', '士大夫撒', '', '', '', null, '从SQL Server转到Oracle也许会感到不适，因为Oracle里没有文件组和数据文件的概念。但是有表空间的概念，表空间是Oracle的逻辑结构，一个Oracle数据库可以有一个或者多个表空间，一个表空间又对应着多个物理的数据库文件。其实SQL Server的文件组转到Oracle就是表空间，Oracle的表空间转到SQL Server就是文件组。这篇博文重点来讨论Oracle的表空间', '', '0.00', '0.00', '', '', '', '0', '0', '7195', '1', '1', '0', '', '0', '0', '0');
INSERT INTO `#wang#_product` VALUES ('6', 'wang12', '', '', '', null, '从SQL Server转到Oracle也许会感到不适，因为Oracle里没有文件组和数据文件的概念。但是有表空间的概念，表空间是Oracle的逻辑结构，一个Oracle数据库可以有一个或者多个表空间，一个表空间又对应着多个物理的数据库文件。其实SQL Server的文件组转到Oracle就是表空间，Oracle的表空间转到SQL Server就是文件组。这篇博文重点来讨论Oracle的表空间', '', '0.00', '0.00', '', '', '', '0', '0', '2307', '1', '1', '0', '', '0', '0', '0');
INSERT INTO `#wang#_product` VALUES ('7', '士大夫撒', '', '', '', null, '从SQL Server转到Oracle也许会感到不适，因为Oracle里没有文件组和数据文件的概念。但是有表空间的概念，表空间是Oracle的逻辑结构，一个Oracle数据库可以有一个或者多个表空间，一个表空间又对应着多个物理的数据库文件。其实SQL Server的文件组转到Oracle就是表空间，Oracle的表空间转到SQL Server就是文件组。这篇博文重点来讨论Oracle的表空间', '', '0.00', '0.00', '', '', '', '0', '0', '9948', '1', '1', '0', '', '0', '0', '0');
INSERT INTO `#wang#_product` VALUES ('8', 'wang12', '', '', '', null, '从SQL Server转到Oracle也许会感到不适，因为Oracle里没有文件组和数据文件的概念。但是有表空间的概念，表空间是Oracle的逻辑结构，一个Oracle数据库可以有一个或者多个表空间，一个表空间又对应着多个物理的数据库文件。其实SQL Server的文件组转到Oracle就是表空间，Oracle的表空间转到SQL Server就是文件组。这篇博文重点来讨论Oracle的表空间', '', '0.00', '0.00', '', '', '', '0', '0', '2819', '1', '1', '0', '', '0', '0', '0');
INSERT INTO `#wang#_product` VALUES ('9', '士大夫撒', '', '', '', null, '从SQL Server转到Oracle也许会感到不适，因为Oracle里没有文件组和数据文件的概念。但是有表空间的概念，表空间是Oracle的逻辑结构，一个Oracle数据库可以有一个或者多个表空间，一个表空间又对应着多个物理的数据库文件。其实SQL Server的文件组转到Oracle就是表空间，Oracle的表空间转到SQL Server就是文件组。这篇博文重点来讨论Oracle的表空间', '', '0.00', '0.00', '', '', '', '4294967295', '4294967295', '4250', '6', '1', '0', '', '0', '0', '0');
INSERT INTO `#wang#_product` VALUES ('10', 'wang12', '', '', '', null, '从SQL Server转到Oracle也许会感到不适，因为Oracle里没有文件组和数据文件的概念。但是有表空间的概念，表空间是Oracle的逻辑结构，一个Oracle数据库可以有一个或者多个表空间，一个表空间又对应着多个物理的数据库文件。其实SQL Server的文件组转到Oracle就是表空间，Oracle的表空间转到SQL Server就是文件组。这篇博文重点来讨论Oracle的表空间', '', '0.00', '0.00', '', '', '', '4294967295', '4294967295', '2795', '6', '1', '0', '', '0', '0', '0');
INSERT INTO `#wang#_product` VALUES ('11', '商品测试', '', 'test', '', null, '啊发顺丰大是大非', '测试测试', '1.00', '0.00', 'test', 'kg', '', '1470627731', '0', '0', '1', '1', '0', '', '0', '0', '0');
INSERT INTO `#wang#_product` VALUES ('23', '图片测试', '', '', '', 'http://localhost/tp5/public/uploads/37\\592d01b45c742f43d75f7909f78172.jpg|http://localhost/tp5/public/uploads/c2\\10b8f4e3f8c93347d7750878a1d2cd.jpg', '图片测试图片测试图片测试图片测试图片测试', '图片测试', '1.00', '0.00', 'test', '个', '', '1470720246', '0', '0', '1', '1', '0', '', '0', '0', '0');
INSERT INTO `#wang#_product` VALUES ('24', '电脑设备', '', '', '', 'http://www.mbeazy.com/uploads/20160809\\eae300067413e5a7fae9b82af0086ed3.jpg', '电脑设备电脑设备电脑设备电脑设备', '电脑设备电脑设备电脑设备', '14000.00', '0.00', 'dell', '台', '', '1470722017', '0', '0', '6', '1', '0', '', '1', '0', '0');
INSERT INTO `#wang#_product` VALUES ('25', '1111', '', '', '', '/uploads/20160817\\8bc17f896b1b558519fa12d93ba57daf.jpg', '[content]', '', '1.00', '0.00', '', '', '', '1471401204', '0', '0', '0', '1', '0', '', '0', '0', '0');
INSERT INTO `#wang#_product` VALUES ('26', '缩略图测试', '', '', '/tp5/public/uploads/20160817/20160817104703-thumb.jpeg', '/uploads/20160817\\d8d98347854ad6180cfdd27df38660ec.jpg', '缩略图测试缩略图测试缩略图测试缩略图测试缩略图测试缩略图测试缩略图测试', '', '1.00', '0.00', '', '', '', '1471402023', '0', '0', '1', '1', '0', '', '0', '0', '0');

-- ----------------------------
-- Table structure for #wang#_system
-- ----------------------------
DROP TABLE IF EXISTS `#wang#_system`;
CREATE TABLE `#wang#_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '标识',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '说明',
  `tvalue` varchar(150) NOT NULL DEFAULT '' COMMENT '参数类型',
  `typeid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '类型',
  `groupid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分组',
  `value` text,
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #wang#_system
-- ----------------------------
INSERT INTO `#wang#_system` VALUES ('64', 'site_name', '站点名称', '', '', '0', '0', '我的网站', '0');
INSERT INTO `#wang#_system` VALUES ('65', 'site_title', '站点标题', '', '', '0', '0', '我的网站', '0');
INSERT INTO `#wang#_system` VALUES ('66', 'site_keywords', '站点关键字', '', '', '0', '0', '我的网站', '0');
INSERT INTO `#wang#_system` VALUES ('67', 'site_description', '站点描述', '', '', '0', '0', '我的网站', '0');
INSERT INTO `#wang#_system` VALUES ('68', 'site_address', '公司地址', '', '', '0', '0', '浙江省杭州市', '0');
INSERT INTO `#wang#_system` VALUES ('69', 'site_closed', '关闭网站', '', 'radio', '0', '0', '0', '0');
INSERT INTO `#wang#_system` VALUES ('70', 'site_icp', 'ICP备案证书号', '', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('71', 'site_tel', '客服电话', '', '', '0', '0', '0571-1122331111', '0');
INSERT INTO `#wang#_system` VALUES ('72', 'site_fax', '传真', '', '', '0', '0', '0571-112231111', '0');
INSERT INTO `#wang#_system` VALUES ('73', 'site_qq', '客服QQ号码', '多个客服的QQ号码请以半角逗号（,）分隔，如果需要设定昵称则在号码后跟 /昵称。', '', '0', '0', '553212320', '0');
INSERT INTO `#wang#_system` VALUES ('74', 'site_email', '邮件地址', '', '', '0', '0', '553212320@qq.com', '0');
INSERT INTO `#wang#_system` VALUES ('75', 'site_language', '系统语言', '', 'select', '0', '0', 'zh_cn', '0');
INSERT INTO `#wang#_system` VALUES ('76', 'site_rewrite', 'URL 重写', '', 'radio', '0', '0', '0', '0');
INSERT INTO `#wang#_system` VALUES ('77', 'site_map', '启用站点地图', '', 'radio', '0', '0', '0', '0');
INSERT INTO `#wang#_system` VALUES ('78', 'site_captcha', '启用验证码', '', 'radio', '0', '0', '0', '0');
INSERT INTO `#wang#_system` VALUES ('79', 'site_guestbook', '留言板强制中文输入', '强制用户留言时必须输入中文，可以有效抵御英文广告信息', 'radio', '0', '0', '0', '0');
INSERT INTO `#wang#_system` VALUES ('80', 'site_code', '统计/客服代码调用	', '', 'area', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('81', 'display_thumbw', '缩略图宽度', '', '', '0', '0', '300', '0');
INSERT INTO `#wang#_system` VALUES ('82', 'display_thumbh', '缩略图高度', '', '', '0', '0', '300', '0');
INSERT INTO `#wang#_system` VALUES ('83', 'display_decimal', '价格保留小数位数', '将以四舍五入形式保留小数', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('84', 'display_article', '文章列表数量', '', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('85', 'display_iarticle', '首页展示文章数量', '', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('86', 'display_product', '商品列表数量', '', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('87', 'display_iproduct', '首页展示商品数量', '', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('88', 'defined_article', '文章自定义属性', '如\"颜色,尺寸,型号\"中间以英文逗号隔开', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('89', 'defined_product', '商品自定义属性', '如\"颜色,尺寸,型号\"中间以英文逗号隔开', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('90', 'mail_service', '邮件服务', '如果选择系统内置Mail服务则以下SMTP有关信息无需填写', 'radio', '0', '0', '0', '0');
INSERT INTO `#wang#_system` VALUES ('91', 'mail_host', 'SMTP服务器', '一般邮件服务器地址为：smtp.domain.com，如果是本机则对应localhost即可', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('92', 'mail_port', '服务器端口', '', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('93', 'mail_ssl', '是否使用SSL安全协议', '', '', '0', '0', 'on', '0');
INSERT INTO `#wang#_system` VALUES ('94', 'mail_username', '发件邮箱', '', '', '0', '0', '', '0');
INSERT INTO `#wang#_system` VALUES ('95', 'mail_password', '发件邮箱密码', '', '', '0', '0', '1111', '0');
INSERT INTO `#wang#_system` VALUES ('96', 'site_theme', '网站主题', '', 'select', '0', '0', 'default', '0');
