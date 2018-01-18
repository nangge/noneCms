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
  `logintime` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '登录时间',
  `loginip` varchar(30) NOT NULL DEFAULT '' COMMENT '登录IP',
  `islock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '锁定状态',
  `createtime` int(10) NOT NULL DEFAULT '0' COMMENT '管理员创建时间',
  `role_id` int(10) DEFAULT '0' COMMENT '角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

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
  `start_time` int DEFAULT NULL COMMENT '广告开始时间',
  `end_time` int DEFAULT NULL COMMENT '广告结束时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除 0：否；1：是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_banner
-- ----------------------------
INSERT INTO `#none#_banner` VALUES ('1', '首页大图', '1', 1484512321, 1645710511, '0');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

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
  `create_time` int NOT NULL COMMENT '创建时间',
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_model
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of #none#_system
-- ----------------------------
INSERT INTO `#none#_system` VALUES ('1', 'site_name', '站点名称', '', '', '0', '0', '#site_name#', '0');
INSERT INTO `#none#_system` VALUES ('2', 'site_title', '站点标题', '', '', '0', '0', '#site_name#', '0');
INSERT INTO `#none#_system` VALUES ('3', 'site_keywords', '站点关键字', '', '', '0', '0', '#site_name#', '0');
INSERT INTO `#none#_system` VALUES ('4', 'site_description', '站点描述', '', '', '0', '0', '#site_name#', '0');
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
INSERT INTO `#none#_system` VALUES ('15', 'site_theme', '网站主题', '', 'select', '0', '0', '#site_theme#', '0');
INSERT INTO `#none#_system` VALUES ('16', 'site_mobile_theme', '移动端主题', '', 'select', '0', '0', 'default', '0');
