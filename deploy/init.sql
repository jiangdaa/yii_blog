-- yii_blog 数据库初始化脚本
-- 仓库中的迁移文件不完整（缺少业务表），此脚本按 common/models 中的模型还原建表语句，
-- 并把仓库自带的两个迁移标记为已应用，避免 yii migrate 重复建表。

SET NAMES utf8;

-- ---------- Yii 迁移记录 ----------
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL PRIMARY KEY,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `migration` (`version`, `apply_time`) VALUES
  ('m130524_201442_init', UNIX_TIMESTAMP()),
  ('m180209_141808_user_log', UNIX_TIMESTAMP());

-- ---------- 后台管理员 ----------
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adminname` varchar(100) NOT NULL COMMENT '管理员用户名',
  `adminemail` varchar(200) NOT NULL COMMENT '管理员邮箱',
  `adminpassword` varchar(64) NOT NULL COMMENT 'md5密码',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_adminname` (`adminname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 账号: admin / admin123
INSERT IGNORE INTO `admin` (`id`, `adminname`, `adminemail`, `adminpassword`) VALUES
  (1, 'admin', 'admin@blog.local', MD5('admin123'));

-- ---------- 前台用户 ----------
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名(默认为邮箱)',
  `email` varchar(200) NOT NULL COMMENT '邮箱',
  `password` varchar(64) NOT NULL COMMENT 'sha1(md5(密码).David)',
  `nick_name` varchar(100) NOT NULL COMMENT '昵称',
  `portrait` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `ip` bigint(20) DEFAULT NULL COMMENT '最近登录IP',
  `login_time` datetime DEFAULT NULL COMMENT '最近登录时间',
  `created_time` datetime DEFAULT NULL COMMENT '注册时间',
  `state` char(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_email` (`email`),
  UNIQUE KEY `uk_nick_name` (`nick_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 前台演示账号: demo@blog.local / demo123
INSERT IGNORE INTO `user` (`id`, `user_name`, `email`, `password`, `nick_name`, `portrait`, `created_time`, `state`) VALUES
  (1, 'demo@blog.local', 'demo@blog.local', SHA1(CONCAT(MD5('demo123'), 'David')), 'Demo用户', '', NOW(), '0');

-- ---------- 分类（type: category=文章分类, share=分享分类）----------
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '分类名称',
  `type` varchar(50) NOT NULL DEFAULT 'category' COMMENT '类型',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name_type` (`name`, `type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `category` (`id`, `name`, `type`) VALUES
  (1, '技术分享', 'category'),
  (2, '生活随笔', 'category'),
  (3, '实用工具', 'share');

-- ---------- 文章 ----------
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` longtext COMMENT '内容',
  `category` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `cover` varchar(255) NOT NULL DEFAULT '' COMMENT '封面',
  `author` varchar(100) NOT NULL DEFAULT '' COMMENT '作者',
  `issuetime` datetime DEFAULT NULL COMMENT '发布时间',
  `updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  `count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `praise` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `stick` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '置顶',
  `recommend` char(1) NOT NULL DEFAULT '0' COMMENT '推荐',
  `state` char(1) NOT NULL DEFAULT '1' COMMENT '发布状态',
  `existdel` char(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `article` (`id`, `title`, `content`, `category`, `author`, `issuetime`, `updatetime`, `count`, `praise`, `recommend`, `state`, `existdel`) VALUES
  (1, '欢迎使用 Yii Blog', '<p>这是一个基于 Yii2 高级模板开发的个人博客系统，支持文章发布、分类、评论、留言、友情链接、资源分享等功能。</p><p>后台可管理文章、用户、公告、权限等。</p>', 1, 'admin', NOW(), NOW(), 0, 0, '1', '1', '0'),
  (2, '博客功能介绍', '<p>前台功能：文章浏览、分类筛选、文章点赞、评论回复、留言板、关于博主、工具分享、用户注册登录。</p><p>后台功能：内容管理、用户管理、权限管理（RBAC）、系统日志、站点配置。</p>', 2, 'admin', NOW(), NOW(), 0, 0, '0', '1', '0');

-- ---------- 评论 ----------
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(10) unsigned NOT NULL COMMENT '文章ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父评论ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论用户ID',
  `comment_content` text NOT NULL COMMENT '评论内容',
  `comment_time` datetime DEFAULT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`),
  KEY `idx_aid` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------- 留言 ----------
CREATE TABLE IF NOT EXISTS `leave_msg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '留言用户ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父留言ID',
  `leave_msg` text NOT NULL COMMENT '留言内容',
  `leave_msg_time` datetime DEFAULT NULL COMMENT '留言时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------- 友情链接 ----------
CREATE TABLE IF NOT EXISTS `link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_name` varchar(100) NOT NULL COMMENT '链接名称',
  `link_url` varchar(255) NOT NULL COMMENT '链接地址',
  `link_logo` varchar(255) NOT NULL DEFAULT '' COMMENT '链接logo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `link` (`id`, `link_name`, `link_url`, `link_logo`) VALUES
  (1, 'GitHub', 'https://github.com', '');

-- ---------- 资源/工具分享 ----------
CREATE TABLE IF NOT EXISTS `share` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `share_name` varchar(255) NOT NULL COMMENT '资源名称',
  `share_describe` text COMMENT '资源描述',
  `cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `category` varchar(100) NOT NULL DEFAULT '' COMMENT '分类名称(冗余)',
  `author` varchar(100) NOT NULL DEFAULT '' COMMENT '作者',
  `cover` varchar(255) NOT NULL DEFAULT '' COMMENT '封面',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------- 公告 ----------
CREATE TABLE IF NOT EXISTS `announcement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COMMENT '公告内容',
  `is_disable` char(1) NOT NULL DEFAULT '0' COMMENT '是否禁用',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布人ID',
  `uname` varchar(100) NOT NULL DEFAULT '' COMMENT '发布人',
  `created_time` datetime DEFAULT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `announcement` (`id`, `content`, `is_disable`, `uid`, `uname`, `created_time`) VALUES
  (1, '欢迎来到我的博客！', '0', 1, 'admin', NOW());

-- ---------- 站点配置（必须存在 id=1 的记录）----------
CREATE TABLE IF NOT EXISTS `site_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(100) NOT NULL DEFAULT '' COMMENT '网站标题',
  `keyword` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'logo',
  `copyright` varchar(255) NOT NULL DEFAULT '' COMMENT '版权信息',
  `icp` varchar(100) NOT NULL DEFAULT '' COMMENT '备案信息',
  `title_suffix` varchar(100) NOT NULL DEFAULT '' COMMENT '标题后缀',
  `site_intro` text COMMENT '网站简介',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `site_config` (`id`, `site_name`, `keyword`, `logo`, `copyright`, `icp`, `title_suffix`, `site_intro`) VALUES
  (1, '我的博客', '博客,Yii2,PHP', '', 'Powered by Yii2', '', '-个人博客', '一个基于 Yii2 的个人博客');

-- ---------- 博主信息（必须存在 id=1 的记录）----------
CREATE TABLE IF NOT EXISTS `blogger_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blogger_name` varchar(100) NOT NULL DEFAULT '' COMMENT '博主名称',
  `blogger_signature` varchar(255) NOT NULL DEFAULT '' COMMENT '个性签名',
  `blogger_address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `qq` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `github` varchar(255) NOT NULL DEFAULT '',
  `weibo` varchar(255) NOT NULL DEFAULT '',
  `blogger_info` text COMMENT '博主介绍',
  `blogger_describe` text COMMENT '个人描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `blogger_info` (`id`, `blogger_name`, `blogger_signature`, `blogger_address`, `qq`, `email`, `github`, `weibo`) VALUES
  (1, '博主', 'Stay hungry, stay foolish.', '', '', '', '', '');

-- ---------- 后台操作日志（以 common/models/AdminLog.php 为准）----------
CREATE TABLE IF NOT EXISTS `admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned DEFAULT NULL COMMENT '操作用户ID',
  `admin_name` varchar(200) DEFAULT NULL COMMENT '操作用户名',
  `add_time` int(10) unsigned DEFAULT NULL COMMENT '记录时间',
  `admin_ip` varchar(200) DEFAULT NULL COMMENT '操作IP',
  `admin_agent` varchar(255) DEFAULT NULL COMMENT '浏览器UA',
  `log_title` varchar(200) DEFAULT NULL COMMENT '记录描述',
  `log_info` text COMMENT '日志信息',
  `controller` varchar(200) DEFAULT NULL COMMENT '控制器',
  `action` varchar(200) DEFAULT NULL COMMENT '方法',
  `model` varchar(200) DEFAULT NULL COMMENT '表名',
  `type` varchar(200) DEFAULT NULL COMMENT '操作类型',
  `handle_id` int(10) DEFAULT NULL COMMENT '操作对象ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
