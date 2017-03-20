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
  `logintime` int(10) unsigned NOT NULL COMMENT '登录时间',
  `loginip` varchar(30) NOT NULL COMMENT '登录IP',
  `islock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '锁定状态',
  `createtime` int(10) NOT NULL DEFAULT '0' COMMENT '管理员创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_admin
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
  `start_time` datetime DEFAULT NULL COMMENT '广告开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '广告结束时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除 0：否；1：是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_banner
-- ----------------------------
INSERT INTO `#none#_banner` VALUES ('1', '首页大图', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_banner_detail
-- ----------------------------
INSERT INTO `#none#_banner_detail` VALUES ('3', '1', '2', '/uploads/20161219\\d57ee6aa088a79866cfa7f8d64c3546a.jpg', 'http://blog.csdn.net/free_ant/article/details/52701212');
INSERT INTO `#none#_banner_detail` VALUES ('4', '1', '2', '/uploads/20161219\\47aacf820659b5e3bcf08e74174e7946.jpg', 'http://blog.csdn.net/free_ant/article/details/52936756');
INSERT INTO `#none#_banner_detail` VALUES ('5', '1', '3', '/uploads/20161219\\d764a6c9cb36617eefd1340d2b3fb69e.jpg', 'http://blog.csdn.net/free_ant/article/details/52936722');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_category
-- ----------------------------

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
  `create_time` datetime NOT NULL COMMENT '创建时间',
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
INSERT INTO `#none#_flink` VALUES ('1', 'nonecms', '1', '', 'http://www.5none.com', '简单建站！', '0', null);

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
-- Table structure for #none#_model
-- ----------------------------
DROP TABLE IF EXISTS `#none#_model`;
CREATE TABLE `#none#_model` (
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
-- Records of #none#_model
-- ----------------------------
INSERT INTO `#none#_model` VALUES ('1', '文章模型', '', 'article', '1', '', 'List_article.html', 'Show_article.html', '1');
INSERT INTO `#none#_model` VALUES ('2', '单页模型', '', 'category', '1', '', 'List_page.html', 'Show_page.html', '2');
INSERT INTO `#none#_model` VALUES ('3', '产品模型', '', 'product', '1', '', 'List_product.html', 'Show_product.html', '3');
INSERT INTO `#none#_model` VALUES ('6', '留言本模型', '', 'comment', '1', '', 'Guestbook_index.html', 'Guestbook_detail.html', '6');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_product
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_system
-- ----------------------------
INSERT INTO `#none#_system` VALUES ('64', 'site_name', '站点名称', '', '', '0', '0', '#site_name#', '0');
INSERT INTO `#none#_system` VALUES ('65', 'site_title', '站点标题', '', '', '0', '0', '#site_name#', '0');
INSERT INTO `#none#_system` VALUES ('66', 'site_keywords', '站点关键字', '', '', '0', '0', '#site_name#', '0');
INSERT INTO `#none#_system` VALUES ('67', 'site_description', '站点描述', '', '', '0', '0', '#site_name#', '0');
INSERT INTO `#none#_system` VALUES ('68', 'site_address', '公司地址', '', '', '0', '0', '浙江省杭州市', '0');
INSERT INTO `#none#_system` VALUES ('69', 'site_closed', '关闭网站', '', 'radio', '0', '0', '0', '0');
INSERT INTO `#none#_system` VALUES ('70', 'site_icp', 'ICP备案证书号', '', '', '0', '0', '', '0');
INSERT INTO `#none#_system` VALUES ('71', 'site_tel', '客服电话', '', '', '0', '0', '0571-1122331111', '0');
INSERT INTO `#none#_system` VALUES ('72', 'site_fax', '传真', '', '', '0', '0', '0571-112231111', '0');
INSERT INTO `#none#_system` VALUES ('73', 'site_qq', '客服QQ号码', '多个客服的QQ号码请以半角逗号（,）分隔，如果需要设定昵称则在号码后跟 /昵称。', '', '0', '0', '553212320', '0');
INSERT INTO `#none#_system` VALUES ('74', 'site_email', '邮件地址', '', '', '0', '0', '553212320@qq.com', '0');
-- ----------------------------
--INSERT INTO `#none#_system` VALUES ('75', 'site_language', '系统语言', '', 'select', '0', '0', 'zh_cn', '0');
--INSERT INTO `#none#_system` VALUES ('76', 'site_rewrite', 'URL 重写', '', 'radio', '0', '0', '0', '0');
--INSERT INTO `#none#_system` VALUES ('77', 'site_map', '启用站点地图', '', 'radio', '0', '0', '0', '0');
--INSERT INTO `#none#_system` VALUES ('78', 'site_captcha', '启用验证码', '', 'radio', '0', '0', '0', '0');
--INSERT INTO `#none#_system` VALUES ('79', 'site_guestbook', '留言板强制中文输入', '强制用户留言时必须输入中文，可以有效抵御英文广告信息', 'radio', '0', '0', '0', '0');
--INSERT INTO `#none#_system` VALUES ('80', 'site_code', '统计/客服代码调用	', '', 'area', '0', '0', '', '0');
-- ----------------------------
INSERT INTO `#none#_system` VALUES ('81', 'display_thumbw', '缩略图宽度', '', '', '0', '0', '300', '0');
INSERT INTO `#none#_system` VALUES ('82', 'display_thumbh', '缩略图高度', '', '', '0', '0', '300', '0');
INSERT INTO `#none#_system` VALUES ('83', 'display_decimal', '价格保留小数位数', '将以四舍五入形式保留小数', '', '0', '0', '', '0');
INSERT INTO `#none#_system` VALUES ('84', 'display_article', '文章列表数量', '', '', '0', '0', '', '0');
INSERT INTO `#none#_system` VALUES ('85', 'display_iarticle', '首页展示文章数量', '', '', '0', '0', '', '0');
INSERT INTO `#none#_system` VALUES ('86', 'display_product', '商品列表数量', '', '', '0', '0', '', '0');
INSERT INTO `#none#_system` VALUES ('87', 'display_iproduct', '首页展示商品数量', '', '', '0', '0', '', '0');
INSERT INTO `#none#_system` VALUES ('88', 'defined_article', '文章自定义属性', '如\"颜色,尺寸,型号\"中间以英文逗号隔开', '', '0', '0', '', '0');
INSERT INTO `#none#_system` VALUES ('89', 'defined_product', '商品自定义属性', '如\"颜色,尺寸,型号\"中间以英文逗号隔开', '', '0', '0', '', '0');
-- ----------------------------
--INSERT INTO `#none#_system` VALUES ('90', 'mail_service', '邮件服务', '如果选择系统内置Mail服务则以下SMTP有关信息无需填写', 'radio', '0', '0', '0', '0');
--INSERT INTO `#none#_system` VALUES ('91', 'mail_host', 'SMTP服务器', '一般邮件服务器地址为：smtp.domain.com，如果是本机则对应localhost即可', '', '0', '0', '', '0');
--INSERT INTO `#none#_system` VALUES ('92', 'mail_port', '服务器端口', '', '', '0', '0', '', '0');
--INSERT INTO `#none#_system` VALUES ('93', 'mail_ssl', '是否使用SSL安全协议', '', '', '0', '0', 'on', '0');
--INSERT INTO `#none#_system` VALUES ('94', 'mail_username', '发件邮箱', '', '', '0', '0', '', '0');
--INSERT INTO `#none#_system` VALUES ('95', 'mail_password', '发件邮箱密码', '', '', '0', '0', '1111', '0');
-- ----------------------------
INSERT INTO `#none#_system` VALUES ('96', 'site_theme', '网站主题', '', 'select', '0', '0', '#site_theme#', '0');
INSERT INTO `#none#_system` VALUES ('97', 'site_mobile_theme', '移动端主题', '', 'select', '0', '0', 'default', '0');
