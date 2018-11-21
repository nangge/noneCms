/*
Navicat MySQL Data Transfer

Source Server         : centos
Source Server Version : 50638
Source Host           : 127.0.0.1
Source Database       : NoneCMS

Target Server Type    : MYSQL
Target Server Version : 50638
File Encoding         : 65001

Date: 2018-09-19 14:58:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for #none#_admin
-- ----------------------------
DROP TABLE IF EXISTS `#none#_admin`;
CREATE TABLE `#none#_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '登录名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `encrypt` varchar(6) NOT NULL DEFAULT '',
  `realname` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `usertype` tinyint(4) NOT NULL DEFAULT '0',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `loginip` varchar(30) NOT NULL DEFAULT '' COMMENT '登录IP',
  `islock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '锁定状态',
  `createtime` int(10) NOT NULL DEFAULT '0' COMMENT '管理员创建时间',
  `role_id` int(10) DEFAULT '0' COMMENT '角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_admin
-- ----------------------------
INSERT INTO `#none#_admin` VALUES ('1', 'admin', 'e154f8031e1380355e3a645978739012', 'KFVGxU', '', '', '9', '1536921886', '192.168.1.46', '0', '0', '0');

-- ----------------------------
-- Table structure for #none#_admin_power
-- ----------------------------
DROP TABLE IF EXISTS `#none#_admin_power`;
CREATE TABLE `#none#_admin_power` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `name` varchar(255) NOT NULL COMMENT '操作名称',
  `route` varchar(255) NOT NULL COMMENT '路由 =》MVC',
  `parent` int(10) DEFAULT '0' COMMENT '父级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_admin_power
-- ----------------------------
INSERT INTO `#none#_admin_power` VALUES ('1', '后台管理', 'main/index', '0');
INSERT INTO `#none#_admin_power` VALUES ('2', '系统设置', 'index/system', '1');
INSERT INTO `#none#_admin_power` VALUES ('3', '清除缓存', 'index/clear', '1');
INSERT INTO `#none#_admin_power` VALUES ('4', '查看操作记录', 'log/index', '1');
INSERT INTO `#none#_admin_power` VALUES ('5', '文章管理', 'article/index', '0');
INSERT INTO `#none#_admin_power` VALUES ('6', '添加文章', 'article/add', '5');
INSERT INTO `#none#_admin_power` VALUES ('7', '编辑文章', 'article/edit', '5');
INSERT INTO `#none#_admin_power` VALUES ('8', '删除文章', 'article/dele', '5');
INSERT INTO `#none#_admin_power` VALUES ('9', '移动文章分类', 'article/move', '5');
INSERT INTO `#none#_admin_power` VALUES ('10', '产品管理', 'product/index', '0');
INSERT INTO `#none#_admin_power` VALUES ('11', '添加产品', 'product/add', '10');
INSERT INTO `#none#_admin_power` VALUES ('12', '编辑产品', 'product/edit', '10');
INSERT INTO `#none#_admin_power` VALUES ('13', '删除产品', 'product/dele', '10');
INSERT INTO `#none#_admin_power` VALUES ('14', '移动产品分类', 'product/move', '10');
INSERT INTO `#none#_admin_power` VALUES ('15', '单页管理', 'page/index', '0');
INSERT INTO `#none#_admin_power` VALUES ('16', '添加单页', 'page/add', '15');
INSERT INTO `#none#_admin_power` VALUES ('17', '修改单页', 'page/edit', '15');
INSERT INTO `#none#_admin_power` VALUES ('18', '删除单页', 'page/dele', '15');
INSERT INTO `#none#_admin_power` VALUES ('19', '导航管理', 'nav/index', '0');
INSERT INTO `#none#_admin_power` VALUES ('20', '添加导航', 'nav/add', '19');
INSERT INTO `#none#_admin_power` VALUES ('21', '修改导航', 'nav/edit', '19');
INSERT INTO `#none#_admin_power` VALUES ('22', '删除导航', 'nav/dele', '19');
INSERT INTO `#none#_admin_power` VALUES ('23', '管理员管理', 'admin/index', '0');
INSERT INTO `#none#_admin_power` VALUES ('24', '添加管理员', 'admin/add', '23');
INSERT INTO `#none#_admin_power` VALUES ('25', '修改管理员', 'admin/edit', '23');
INSERT INTO `#none#_admin_power` VALUES ('26', '删除管理员', 'admin/dele', '23');
INSERT INTO `#none#_admin_power` VALUES ('27', '幻灯广告管理', 'banner/index', '0');
INSERT INTO `#none#_admin_power` VALUES ('28', '添加幻灯广告', 'banner/add', '27');
INSERT INTO `#none#_admin_power` VALUES ('29', '修改幻灯广告', 'banner/edit', '27');
INSERT INTO `#none#_admin_power` VALUES ('30', '删除幻灯广告', 'banner/dele', '27');
INSERT INTO `#none#_admin_power` VALUES ('31', '添加幻灯图片集', 'banner/adddetail', '27');
INSERT INTO `#none#_admin_power` VALUES ('32', '修改幻灯图片集', 'banner/editdetail', '27');
INSERT INTO `#none#_admin_power` VALUES ('33', '删除幻灯图片集', 'banner/deledetail', '27');
INSERT INTO `#none#_admin_power` VALUES ('34', '友情链接管理', 'flink/index', '0');
INSERT INTO `#none#_admin_power` VALUES ('35', '添加友链', 'flink/add', '34');
INSERT INTO `#none#_admin_power` VALUES ('36', '修改友链', 'flink/edit', '34');
INSERT INTO `#none#_admin_power` VALUES ('37', '删除友链', 'flink/dele', '34');
INSERT INTO `#none#_admin_power` VALUES ('38', '转载文章', 'article/copy', '5');
INSERT INTO `#none#_admin_power` VALUES ('39', '角色管理', 'role/index', '0');
INSERT INTO `#none#_admin_power` VALUES ('40', '添加角色', 'role/add', '39');
INSERT INTO `#none#_admin_power` VALUES ('41', '修改角色', 'role/edit', '39');
INSERT INTO `#none#_admin_power` VALUES ('42', '删除角色', 'role/dele', '39');
INSERT INTO `#none#_admin_power` VALUES ('43', '幻灯图片集管理', 'banner/banlist', '27');
INSERT INTO `#none#_admin_power` VALUES ('44', '留言管理', 'comment/index', '0');
INSERT INTO `#none#_admin_power` VALUES ('45', '回复留言', 'comment/add', '44');
INSERT INTO `#none#_admin_power` VALUES ('46', '删除留言', 'comment/dele', '44');

-- ----------------------------
-- Table structure for #none#_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `#none#_admin_role`;
CREATE TABLE `#none#_admin_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `name` varchar(255) NOT NULL COMMENT '角色名',
  `power` varchar(255) DEFAULT '' COMMENT '拥有的权限',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_admin_role
-- ----------------------------

-- ----------------------------
-- Table structure for #none#_article
-- ----------------------------
DROP TABLE IF EXISTS `#none#_article`;
CREATE TABLE `#none#_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '标题',
  `shorttitle` varchar(30) NOT NULL DEFAULT '' COMMENT '副标题',
  `color` char(10) NOT NULL DEFAULT '' COMMENT '标题颜色',
  `copyfrom` varchar(150) NOT NULL DEFAULT '',
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
  `editor` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_article
-- ----------------------------

-- ----------------------------
-- Table structure for #none#_banner
-- ----------------------------
DROP TABLE IF EXISTS `#none#_banner`;
CREATE TABLE `#none#_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'banner 标题',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'banner 类型 1：banner大图；2：广告',
  `start_time` int(11) DEFAULT NULL COMMENT '广告开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '广告结束时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除 0：否；1：是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_banner
-- ----------------------------
INSERT INTO `#none#_banner` VALUES ('1', '首页大图', '1', '1484512321', '1645710511', '0');

-- ----------------------------
-- Table structure for #none#_banner_detail
-- ----------------------------
DROP TABLE IF EXISTS `#none#_banner_detail`;
CREATE TABLE `#none#_banner_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '所属banner id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '图片标题',
  `img` varchar(255) DEFAULT '' COMMENT '图片地址',
  `url` varchar(255) DEFAULT '' COMMENT '图片链接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_banner_detail
-- ----------------------------
INSERT INTO `#none#_banner_detail` VALUES ('1', '1', '2222', '/uploads/20161219\\d57ee6aa088a79866cfa7f8d64c3546a.jpg', 'http://blog.csdn.net/free_ant/article/details/52701212');
INSERT INTO `#none#_banner_detail` VALUES ('2', '1', '2', '/uploads/20161219\\47aacf820659b5e3bcf08e74174e7946.jpg', 'http://blog.csdn.net/free_ant/article/details/52936756');
INSERT INTO `#none#_banner_detail` VALUES ('3', '1', '3', '/uploads/20161219\\d764a6c9cb36617eefd1340d2b3fb69e.jpg', 'http://blog.csdn.net/free_ant/article/details/52936722');

-- ----------------------------
-- Table structure for #none#_category
-- ----------------------------
DROP TABLE IF EXISTS `#none#_category`;
CREATE TABLE `#none#_category` (
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
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 ，显示；1， 不显示',
  `sort` smallint(6) NOT NULL DEFAULT '100' COMMENT '排序',
  `position` varchar(6) NOT NULL DEFAULT '1' COMMENT '导航出现的位置，默认1：主导航；2：底部；3：侧边',
  `outurl` varchar(255) NOT NULL DEFAULT '' COMMENT '外链url',
  `flag` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '属性：8 百度富文本框编辑；9 Markdown编辑',
  `editor` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_category
-- ----------------------------
INSERT INTO `#none#_category` VALUES ('45', '文章模型', 'blog', '', '0', '1', '0', '', '', '', '', '', '', null, '0', '50', '1', '', 0,'0');
INSERT INTO `#none#_category` VALUES ('46', '产品模型', 'product', '', '0', '3', '0', '', '', '', '', '', '', null, '0', '50', '1', '', 0,'0');
INSERT INTO `#none#_category` VALUES ('47', '新闻', 'news', '', '0', '1', '0', '', '', '', '', 'List_article.html', 'Show_article.html', null, '0', '50', '1', '', 0,'0');
INSERT INTO `#none#_category` VALUES ('48', '我的博客', 'blog', '', '0', '0', '1', '', '', '', '', 'List_article.html', 'Show_article.html', null, '0', '0', '1', 'http://5none.com', 0,'0');
INSERT INTO `#none#_category` VALUES ('49', '关于我们', 'about', '', '0', '2', '0', '', '', '<p>发士大夫</p>', '', 'List_page.html', 'Show_article.html', '暗示法撒旦', '0', '0', '1', '', 0,'0');
INSERT INTO `#none#_category` VALUES ('50', '意见反馈', 'feedback', '', '0', '6', '0', '', '', '', '', 'Guestbook_index.html', '', null, '0', '0', '1', '', 0,'0');
INSERT INTO `#none#_category` VALUES ('51', '二级栏目', '', '', '46', '3', '0', '', '', '', '', 'List_product.html', 'Show_product.html', null, '0', '0', '1', '', 0,'0');

-- ----------------------------
-- Table structure for #none#_chat
-- ----------------------------
DROP TABLE IF EXISTS `#none#_chat`;
CREATE TABLE `#none#_chat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户登录id',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT '消息类型 say:广播；prisay:私聊',
  `receive_id` int(10) DEFAULT NULL,
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '消息内容',
  `name` varchar(255) NOT NULL DEFAULT 'nango' COMMENT '用户名称',
  `client_id` int(10) DEFAULT '0' COMMENT '发送消息客户端id',
  `to_client_id` varchar(4) DEFAULT '' COMMENT '私聊对象客户端id',
  `send_time` int(10) DEFAULT NULL COMMENT '发送消息时间',
  `room_id` int(5) DEFAULT '1' COMMENT '房间id',
  `ip` varchar(50) DEFAULT NULL COMMENT '客户端ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for #none#_comment
-- ----------------------------
DROP TABLE IF EXISTS `#none#_comment`;
CREATE TABLE `#none#_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '留言标题',
  `username` varchar(10) NOT NULL DEFAULT '' COMMENT '留言者姓名',
  `tel` varchar(12) DEFAULT '' COMMENT '电话',
  `email` varchar(255) DEFAULT '' COMMENT 'email',
  `qq` varchar(15) DEFAULT '' COMMENT 'qq',
  `content` varchar(255) NOT NULL COMMENT '留言内容',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `rid` int(10) DEFAULT '0' COMMENT '回复id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评论状态 1：已删除',
  `uid` int(10) DEFAULT '0' COMMENT '用户id',
  `aid` int(10) DEFAULT '0' COMMENT '管理员id',
  `from` varchar(10) DEFAULT '' COMMENT '评论来源：本站 or 第三方站（多说）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_comment
-- ----------------------------

-- ----------------------------
-- Table structure for #none#_flink
-- ----------------------------
DROP TABLE IF EXISTS `#none#_flink`;
CREATE TABLE `#none#_flink` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '友情链接名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '记录类型：1：友情链接；2：公告',
  `logo` varchar(255) DEFAULT '' COMMENT 'logo',
  `url` varchar(255) DEFAULT NULL COMMENT 'url',
  `description` varchar(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_flink
-- ----------------------------
INSERT INTO `#none#_flink` VALUES ('1', 'nonecms', '1', '', 'http://www.5none.com', '简单建站！', '1', null);

-- ----------------------------
-- Table structure for #none#_log
-- ----------------------------
DROP TABLE IF EXISTS `#none#_log`;
CREATE TABLE `#none#_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '日志类型 1，登入；2，操作',
  `datetime` int(10) unsigned NOT NULL COMMENT '操作时间',
  `ip` varchar(15) DEFAULT '0' COMMENT '登入ip',
  `content` varchar(255) DEFAULT '' COMMENT '操作内容',
  `username` varchar(255) DEFAULT NULL,
  `userid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_log
-- ----------------------------

-- ----------------------------
-- Table structure for #none#_modeln
-- ----------------------------
DROP TABLE IF EXISTS `#none#_modeln`;
CREATE TABLE `#none#_modeln` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `tablename` varchar(30) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `template_category` varchar(60) NOT NULL DEFAULT '',
  `template_list` varchar(60) NOT NULL DEFAULT '',
  `template_show` varchar(60) NOT NULL DEFAULT '',
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_modeln
-- ----------------------------
INSERT INTO `#none#_modeln` VALUES ('1', '文章模型', '', 'article', '1', '', 'List_article.html', 'Show_article.html', '1');
INSERT INTO `#none#_modeln` VALUES ('2', '单页模型', '', 'category', '1', '', 'List_page.html', 'Show_page.html', '2');
INSERT INTO `#none#_modeln` VALUES ('3', '产品模型', '', 'product', '1', '', 'List_product.html', 'Show_product.html', '3');
INSERT INTO `#none#_modeln` VALUES ('6', '留言本模型', '', 'comment', '1', '', 'Guestbook_index.html', 'Guestbook_detail.html', '6');

-- ----------------------------
-- Table structure for #none#_product
-- ----------------------------
DROP TABLE IF EXISTS `#none#_product`;
CREATE TABLE `#none#_product` (
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
  `editor` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_product
-- ----------------------------
INSERT INTO `#none#_product` VALUES ('29', 'NoneCms 增加了Markdown编辑器', '', '', '/uploads/20161219\\d57ee6aa088a79866cfa7f8d64c3546a.jpg', '/uploads/20161219\\47aacf820659b5e3bcf08e74174e7946.jpg', '<p>sfasfdasdfasdfsd</p>', '', '1.00', '0.00', 'sdf', '', '', '1479887452', '1479967806', '1', '46', '1', '0', '', '0', '0', '0','0');
INSERT INTO `#none#_product` VALUES ('30', 'NoneCms 增加了聊天室功能，欢迎使用', '', '哈哈', '/uploads/20161219\\d764a6c9cb36617eefd1340d2b3fb69e.jpg', '/uploads/20161219\\47aacf820659b5e3bcf08e74174e7946.jpg|/uploads/20161219\\d764a6c9cb36617eefd1340d2b3fb69e.jpg', '<p>contentcontentcontentcontentcontentcontentcontentcontent</p>', '', '1.00', '0.00', 'sdf', '', '', '1479957877', '0', '1', '46', '1', '0', '', '0', '0', '0','0');
INSERT INTO `#none#_product` VALUES ('31', 'CENTOS7 下部署RSync', '', '', '/uploads/20161219\\d57ee6aa088a79866cfa7f8d64c3546a.jpg', '/uploads/20161219\\47aacf820659b5e3bcf08e74174e7946.jpg', '     ', '', '0.00', '0.00', '', '', '', '1479977262', '1479977572', '0', '46', '1', '0', '', '0', '0', '0','0');
INSERT INTO `#none#_product` VALUES ('32', 'NoneCms 是一款开源软件', '', '', '/uploads/20161219\\47aacf820659b5e3bcf08e74174e7946.jpg', '/uploads/20161219\\47aacf820659b5e3bcf08e74174e7946.jpg', '<p>afas</p>', 'asf', '1.00', '0.00', 'fas', '', '', '1479977715', '0', '0', '46', '1', '0', '', '0', '0', '0','0');


-- ----------------------------
-- Table structure for #none#_system
-- ----------------------------
DROP TABLE IF EXISTS `#none#_system`;
CREATE TABLE `#none#_system` (
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_system
-- ----------------------------
INSERT INTO `#none#_system` VALUES ('1', 'site_name', '站点名称', '', '', '0', '0', '我的网站', '0');
INSERT INTO `#none#_system` VALUES ('2', 'site_title', '站点标题', '', '', '0', '0', '我的网站', '0');
INSERT INTO `#none#_system` VALUES ('3', 'site_keywords', '站点关键字', '', '', '0', '0', '我的网站', '0');
INSERT INTO `#none#_system` VALUES ('4', 'site_description', '站点描述', '', '', '0', '0', '我的网站', '0');
INSERT INTO `#none#_system` VALUES ('5', 'site_address', '公司地址', '', '', '0', '0', '浙江省杭州市', '0');
INSERT INTO `#none#_system` VALUES ('6', 'site_closed', '关闭网站', '', 'radio', '0', '0', '0', '0');
INSERT INTO `#none#_system` VALUES ('7', 'site_icp', 'ICP备案证书号', '', '', '0', '0', '', '0');
INSERT INTO `#none#_system` VALUES ('8', 'site_tel', '客服电话', '', '', '0', '0', '0571-11223311', '0');
INSERT INTO `#none#_system` VALUES ('9', 'site_fax', '传真', '', '', '0', '0', '0571-112231111', '0');
INSERT INTO `#none#_system` VALUES ('10', 'site_qq', '客服QQ号码', '多个客服的QQ号码请以半角逗号（,）分隔，如果需要设定昵称则在号码后跟 /昵称。', '', '0', '0', '553212320', '0');
INSERT INTO `#none#_system` VALUES ('11', 'site_email', '邮件地址', '', '', '0', '0', '553212320@qq.com', '0');
INSERT INTO `#none#_system` VALUES ('12', 'display_thumbw', '缩略图宽度', '', '', '0', '0', '300', '0');
INSERT INTO `#none#_system` VALUES ('13', 'display_thumbh', '缩略图高度', '', '', '0', '0', '300', '0');
INSERT INTO `#none#_system` VALUES ('14', 'site_editor', '编辑器选择', '如果选择Markdown编辑器，则前台展示页面需引入editor.md相关js；具体操作流程看文章：blog.5none.com', 'radio', '0', '0', 'markdown', '0');
INSERT INTO `#none#_system` VALUES ('15', 'site_theme', '网站主题', '', 'select', '0', '0', 'default', '0');
INSERT INTO `#none#_system` VALUES ('16', 'site_mobile_theme', '移动端主题', '', 'select', '0', '0', 'default', '0');
INSERT INTO `#none#_system` VALUES ('17', 'email_host', '邮箱服务器主机地址', '', '', '0', '0', 'default', '0');
INSERT INTO `#none#_system` VALUES ('18', 'email_port', '端口号', '', '', '0', '0', '25', '0');
INSERT INTO `#none#_system` VALUES ('19', 'email_username', '邮箱用户名', '', '', '0', '0', 'default', '0');
INSERT INTO `#none#_system` VALUES ('20', 'email_password', '邮箱授权码', '', '', '0', '0', 'default', '0');
INSERT INTO `#none#_system` VALUES ('21', 'email_fromemail', '发件人邮箱', '', '', '0', '0', 'default', '0');
INSERT INTO `#none#_system` VALUES ('22', 'email_fromuser', '发件人用户名', '', '', '0', '0', 'default', '0');
INSERT INTO `#none#_system` VALUES ('23', 'email_debug', '开启调试模式', ' 0 No output  1 Commands 2 Data and commands 3 As 2 plus connection status 4 Low-level data output.', '', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for #none#_user
-- ----------------------------
DROP TABLE IF EXISTS `#none#_user`;
CREATE TABLE `#none#_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `img` text,
  `create_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL DEFAULT '',
  `accesstoken` varchar(32) NOT NULL DEFAULT '',
  `accesstoken_expire` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_user
-- ----------------------------
INSERT INTO `#none#_user` VALUES ('1', 'nonecms', '553212320@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 0x646174613A696D6167652F6A7065673B6261736536342C2F396A2F34414151536B5A4A5267414241514141415141424141442F2F67413851314A4651565250556A6F675A325174616E426C5A7942324D5334774943683163326C755A79424A536B6367536C4246527942324E6A49704C4342786457467361585235494430674D54417743762F6241454D4141514542415145424151454241514542415145424151454241514542415145424151454241514542415145424151454241514542415145424151454241514542415145424151454241514542415145424151454241662F6241454D4241514542415145424151454241514542415145424151454241514542415145424151454241514542415145424151454241514542415145424151454241514542415145424151454241514542415145424151454241662F41414245494142344148674D4249674143455145444551482F7841416641414142425145424151454241514141414141414141414141514944424155474277674A4367762F784143314541414341514D444167514442515545424141414158304241674D4142424546456945785151595455574548496E45554D6F47526F51676A5172484246564C523843517A596E4B4343516F574678675A4769556D4A7967704B6A51314E6A63344F547044524556475230684A536C4E5556565A5857466C615932526C5A6D646F6157707A6448563264336835656F4F456859614869496D4B6B704F556C5A61586D4A6D616F714F6B7061616E714B6D7173724F3074626133754C6D367773504578636248794D6E4B3074505531646258324E6E6134654C6A354F586D352B6A7036764879382F5431397666342B66722F7841416641514144415145424151454241514542414141414141414141514944424155474277674A4367762F78414331455141434151494542414D454277554542414142416E6341415149444551514649544547456B4652423246784579497967516755517047687363454A497A4E53384256696374454B46695130345358784678675A4769596E4B436B714E5459334F446B3651305246526B644953557054564656575631685A576D4E6B5A575A6E61476C7163335231646E64346558714367345346686F6549695971536B3553566C7065596D5A71696F36536C7071656F71617179733753317472653475627243773854467873664979637253303954563174665932647269342B546C3575666F36657279382F5431397666342B66722F3267414D41774541416845444551412F415032442F77434377482F425233582F4150676E39384850414466446E772F59654B766A5238636646327365442F414E767179535461543463303751394566552F45336A4B6178677732743332697933336836773066516E614F33763954316D336C75336B744C4F347337762B49663975562F465878412B4150777A2B503841346C3137346C654976326A50694A34782B49592B4F477566454C7863392F7157696638414343586C765A326569615670375062576D6A65484C722B31745031485474506968614F4D543666625770537A657868722B76542F41494B792F735361522B322F6F4F67655072727862644456666756384A5069367677353842517A4C7079363938516646336948345861374A665336793932693279582F672F77434833694C775174734C565A6F377678565961784666524453587462762B5A4C34332F734865442F4266374B33684834642B50666939465A66744A5850696D4C346D61483458763558314C54394873504533682F523950314C776272786E764A4A74536B74376277316F4C616A6678775257567471576E53323970625457734D4A664C4B7174476E6C746172435745684E2B326A586E566A6572482B464F6A374A3375344F6E477442786A76566D72744A4F2F6F5A745472317366536F75474B6E424F6C4F685470545559543932634B6A714B306B7071704B6E4A536C65304975797530342F68744271692B4E374336316D3168577831537869746F7645466E4249456379737A4B6459736F3049614F316C6B5A4557496743316C4C326D2B525774704867302B5879462B7A61747144796F676153423556754A596353655769374A397A47566D6A6942416242526432315544454E725833777431543457334B367A34725A7242744D767070622B53786552347862524C4C4244706E6B546552466653336D7070426D316B58375050434A764D7A444649563569316E734E64746B76744E61473175335969373079346E6A5552454B706534696B6D6A6A684B504D7A72736A4C5344687041674B37387169686A6162715532354B3975654D593363767453546C46744C653757736D377537626375616D716D43714B46574B6A4C6C54644F556D34714C537447536A4B4B6276306B375274625379532F314F2F774275483976442F676E352B7A5A384F6250773334393037576834772B4F576B2B492F682F384142665276422F773738552B4E7645336950786E71746D32683658465957576C517444623342316A55394F6A73467533686C3143636C644F6A764A59335650346E663278664475726547504733686E34322F74416545374C776C3853644938412B485042637476344E385961667239374E6436484E426F4F6F66384C4F305335754E4D76394D385436584B2F3262576E3053303132326D6E682B3258576C364862506258622F7742486D756543496646306C724E3467747445316154535A356A703133716C6E64616C6661584D43724735306D3475627333476E33586E4B6B6B647861584E764E453063637362704B694D6E7735385376324E76326576474773366C652B4B6641326B6135716B327133656F36686536355A617234694E315065336B6C3171453554567646446F4C75397548616153646B5A64354F596D354A39374D6F3036744655384C686C44447A584C4B6D3552584D6E474F6B6E65373565586D707150736F707530314E6536655A6C63716C43704F70694D544F6464576C436F6C7A636B6B3034745857696153556D31556C5A65357974335838347678662B48326E2F41426B2B4771654C377678546F2B677858577258552F687532757275396134314365306D73724F356E4F6D36625933537244645336694C5733764E556B7439686775376F524C5A77696158383750465867335676682F71567670312F64324E784463616462586C6C4A6154784F733970654437526258684B744C48496C3345336E517A4C497979524D6A49466A5A516637494C6A39687A396D75533173644D69384161636D6E77435735744C4E644D384F51577473317949784D385676486F4C4B736B72515147516B7649336C49544D53716B5A6366374358374D6C6E7156336670384D2F446C337146796977547A36726F6569617170676745617778785258326D7A775165576952786F594949747361434E634A38703857685372596561536358525556616D724A716235564B5633336B335A4A7057337532326578694B754778464E4E526C484574726E717555705261303559714E6C5A4B4E7233556E7A6171566B6F722F2F32513D3D, '1537327719', '1537335624', '', '5bb8a5b75598e141a6cf6b8b013bca53', '1537342824');
