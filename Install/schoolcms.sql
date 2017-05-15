/*
 Navicat MySQL Data Transfer

 Source Server         : 本机
 Source Server Version : 50716
 Source Host           : localhost
 Source Database       : schoolcms_2.3

 Target Server Version : 50716
 File Encoding         : utf-8

 Date: 05/15/2017 10:01:41 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `sc_admin`
-- ----------------------------
DROP TABLE IF EXISTS `sc_admin`;
CREATE TABLE `sc_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `username` char(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `login_pwd` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `login_salt` char(6) NOT NULL DEFAULT '' COMMENT '登录密码配合加密字符串',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别（0保密，1女，2男）',
  `login_total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属角色组',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员';

-- ----------------------------
--  Records of `sc_admin`
-- ----------------------------
BEGIN;
INSERT INTO `sc_admin` VALUES ('1', 'admin', '36077bfba927857343a6130d378b987c', '878579', '', '0', '254', '1494385961', '1', '1481350313', '2017-05-10 11:12:41'), ('3', 'testtest', '7b2cf5343898484ee47727dfaedc1e02', '991606', '', '0', '26', '1491992579', '13', '1483947758', '2017-04-12 18:22:59');
COMMIT;

-- ----------------------------
--  Table structure for `sc_article`
-- ----------------------------
DROP TABLE IF EXISTS `sc_article`;
CREATE TABLE `sc_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '标题',
  `title_color` char(7) NOT NULL DEFAULT '' COMMENT '标题颜色',
  `article_class_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章分类',
  `jump_url` char(255) NOT NULL DEFAULT '' COMMENT '跳转url地址',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `content` text COMMENT '内容',
  `image` text COMMENT '图片数据（一维数组序列化）',
  `image_count` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文章图片数量',
  `access_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `article_class_id` (`article_class_id`),
  KEY `is_enable` (`is_enable`),
  KEY `access_count` (`access_count`),
  KEY `image_count` (`image_count`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章';

-- ----------------------------
--  Records of `sc_article`
-- ----------------------------
BEGIN;
INSERT INTO `sc_article` VALUES ('1', '我们翻了20多年的文献专利，就为了搞清楚VR从爆火到爆冷的秘', '', '16', '', '1', '<p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><img src=\"/Public/Upload/Article/image/2017/02/24/1487908153341367.jpg\" title=\"1487908153341367.jpg\" alt=\"11-1.jpg\"/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">看到大家在朋友圈各种晒虚拟现实（VR）的酷炫体验，感觉VR“忽如一夜春风来”似的进入大众视野。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">但是仔细一想，我好像只能将VR和游戏、电影联系起来，鬼知道“高大上”的VR技术到底经历了什么。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">VR电影不用说了，传说中的那种片子看不到，能看到的都是《西游伏妖篇》这种伪3D。去找个VR游戏室体验一把黑科技吧，结果头晕眼花吐苦胆，真是悲从中来不可断绝。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>这VR技术到底什么时候才能走进家门？我的脑海中闪过了技术生命周期理论、各种专利数据、国内外各种大牛生产的文献……</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">于是驱鼠杀奔CNKI官方网站，调出了库里存在的文献，惊讶地发现有许多文献都发霉长毛了，原因是它已经历了30多年的风雨。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>文献已人老珠黄，那么专利情况如何呢？</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>经过反复在国家知识产权局官网上查找VR的专利数据，你猜怎样？最古老的专利已经尘封了21年。21年前，电脑还是486\\586的天下，这跑满了21年的VR技术还会有多少应用价值呢？</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">2014-2016年短短3年时间，国家专利局公布了2585项专利，在这漫长的21年里，达到了一个新的高度。此前，1996-2013年的18年时间一共才公布了934项专利。这是一个产业爆发的信号啊。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>此信号跟市场/公众反馈是一样的吗？我们可从热搜关键词中查验一下VR的搜索热度。<br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>于是，我们收集了三组数据，定量的分析VR技术发展的生命历程，并尝试对其未来发展进行预测，结论如下：</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>1)&nbsp;中国人对VR技术的认识经历了从基础研究到科技产品研发，时间长达30来年。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">&nbsp;&nbsp;<br/>2)&nbsp;1996年至2014年期间我国的VR技术处于起步阶段，2015年以来的这两年，虽然有突飞性发展，但依然不够成熟。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>3)&nbsp;许多媒体说VR技术已经开始在教育、体育锻炼、游戏和医疗等领域布局和应用，但要市场真正接受，至少是从2019年起。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>这是怎么发现的呢？来看几组数据。</p><p class=\"text-sm-title\" style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; font-size: 18px; font-weight: 700; color: rgb(164, 29, 29); font-family: Arial, 微软雅黑, \"><br/></p><p class=\"text-big-title\" style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; font-size: 20px; font-weight: 700; color: rgb(164, 29, 29); font-family: Arial, 微软雅黑, \">第一组数据：VR文献，一只“倒扣的碗”的寓意</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>首先，我们查的是文献，文献数量的变化往往能反映出研究热点的变化。文献数量开始减少暗示着相关的理论研究比较成熟，开始转向实际应用。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>结果发现“虚拟现实”文献数量的变化竟像一个“倒扣的碗”！这个轨迹刻画了理论研究文献经历了高峰后逐步的下滑，往往暗示着实际应用的酝酿开始。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/>具体操作是这样的：我们分别以“虚拟现实”、“虚拟现实技术”和“虚拟现实系统”三个关键词在CNKI中进行文献查找，发现自1993年第一篇有关VR的文献在国内发表以来，历年有关VR的文献数量持续增加，并在2008年登上它的“珠穆朗玛峰”，随后开始走“下山之路”。</p><p><br/></p><p>原文来源 虎嗅网：https://www.huxiu.com/article/182456.html</p>', 'a:1:{i:0;s:60:\"/Public/Upload/Article/image/2017/02/24/1487908153341367.jpg\";}', '1', '171', '1484965691', '1487918803'), ('3', '互联网人就算不去阿里，也在要去阿里的路上', '#FF0000', '17', '', '1', '<p class=\"text-big-title\" style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; font-size: 20px; font-weight: 700; color: rgb(164, 29, 29); font-family: Arial, 微软雅黑, \"><img src=\"/Public/Upload/Article/image/2017/02/24/1487908588560079.jpg\" alt=\"1487908588560079.jpg\"/></p><p class=\"text-big-title\" style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; font-size: 20px; font-weight: 700; color: rgb(164, 29, 29); font-family: Arial, 微软雅黑, \">1</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">阿里巴巴园区旁边的五常中心小学，二十多年前还是余杭县五常公社东风生产大队所属的农村小学。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">2013年阿里巴巴从滨江区搬迁到这里，附近五常街道和仓前街道的房价开始坐上火箭，这个小学也摇身一变成了马云母校杭州师范大学的附属小学。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">阿里巴巴高层的孩子通常住在杭州城内各个名校的学区房里。但是因为五常小学离公司近，小学成绩又不是很要紧，所以还有相当一部分阿里老员工把孩子送到了五常小学就读。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">传说这些“橙二代”在学校里面已经有拼爹的苗头了：</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><blockquote style=\"box-sizing: border-box; padding: 25px 30px; margin: 0px; border: none; background-color: rgb(245, 245, 245); line-height: 23px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;\">“小子，我爸是P8，你爸是P几啊？”</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;\"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;\">“我爸妈都是中供铁军，你家是刚从北京新来的吧？”</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;\"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;\">“我妈是HRD，你知道什么是价值观第一吗？价值观第一就是我妈第一。”</p></blockquote><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">这时候回迁户家的孩子看着他们吹牛逼，就像《血色浪漫》和《阳关灿烂的日子》里胡同串子出身的顽主，眼瞅着大院子弟穿将校昵骑永久自行车拍婆子，只有流口水的份儿。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">现在这群小子还能流口水。等到马云投资138亿元的云谷学校建起来了，他们连口水也没得流了。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">这个云谷学校一年学费20万起，师生比例1比5，预计未来招生规模3000人，从幼儿园到高中十五年一贯制。阿里巴巴的合伙人将在全球范围延揽人才在该校任教，争取办成“浙江第一，全国一流，世界知名”的国际化学校。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">想入学该校，买学区房、拼成绩都不管用了。不仅有专门的考试还要筛查家长的背景。今年第一期入学的指标60人，已经被“橙二代”们包了个饺子。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><span style=\"box-sizing: border-box; font-weight: 700;\">按照阿里巴巴目前的人员结构，只要大家别都抢着生二胎，P7以上的员工的孩子，应该都有机会往云谷学校里挤一挤的。</span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">马云是这样寄语云谷学校的，</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><blockquote style=\"box-sizing: border-box; padding: 25px 30px; margin: 0px; border: none; background-color: rgb(245, 245, 245); line-height: 23px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;\">“云谷培养的孩子，一定要用全球化的眼光看问题……是中国未来的希望所在。”</p></blockquote><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">我相信有马总这样的关心，云谷学校的同学们一定能不负重托，担起DT时代勇攀科学人文高峰的重任，到时候争取跟北京的八一学校比一比，也发射一颗科研小卫星。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p class=\"text-big-title\" style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; font-size: 20px; font-weight: 700; color: rgb(164, 29, 29); font-family: Arial, 微软雅黑, \">2</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">为了你的下一代，互联网人就算不去阿里，也在要去阿里的路上。一张P7的工卡，顶半套学区房。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">网络安全大神吴翰清四年前离开阿里创业，做了两年把公司拆了分别卖给百度和阿里，他回了阿里，另一拨人去了百度。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">如今肯定是在阿里的人活得舒坦，不然公司今天来个90后副总裁，明天来个90后总经理，后天还要操心老板被境管的谣言，怎么能安心做技术呢？<br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">16年资本寒冬的到来，回大公司上班又变成了一种时髦，和两年前成群结队离职说要“改变世界，颠覆行业”一样时髦。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">吴翰清（道哥）月初写了一篇《我回阿里的29个月》在程序员的朋友圈里刷了屏，他说，</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><blockquote style=\"box-sizing: border-box; padding: 25px 30px; margin: 0px; border: none; background-color: rgb(245, 245, 245); line-height: 23px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px;\">“四年前我会狂妄地说要颠覆世界，现在看来世界根本不需要被颠覆。”</p></blockquote><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">春江水暖鸭先知，除了这些归巢的老阿里之外，嗅觉敏锐的还有媒体人。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">今年招兵买马之后，从前删帖催稿都忙不过来的阿里公关，现在也可以学百度陪着媒体人出国游山玩水了。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">当然媒体人成群结队去阿里这件事不是从去年开始的，18年前加入阿里的金建杭官至总裁，14年前加入的王帅也跻身合伙人，现在每天在微博上写打油诗，秀两个女儿的照片，趿着拖鞋在豪宅的花园里趴趴走。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">12年前加入的陶然现在是滴滴打车的副总裁，7年前加入的陈亮和21世纪经济报道的三位同事，颜乔、杨磊、顾建兵，都成了集团公关总监。但是时不我待，<span style=\"box-sizing: border-box; font-weight: 700;\">2012年之后，通过去大公司做公关这扇财务自由的大门就对媒体人关上了。</span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">王以超就没有赶上好时候，2013年才离开媒体去了京东。虽然从资历上来说，王以超和阿里巴巴合伙人王帅是同一年出生，他就职的《财经》和《财新》也不知道比王帅当年的《齐鲁晚报》、《济南时报》高到哪里去了。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">但是说什么都没用了，下水晚了十年，老板从马云换成了刘强东，财务自由变成了跳槽自由。王以超老师8年换了8个工作。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">如今王以超的微博认证还是36氪副总裁，在行上的认证还是Uber中国公关副总监，但是在朋友圈里他已经宣布自自己“上上上上，上优信二手车，做做做做，做公关总经理”去了。<br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">很多好事之徒总喜欢拿他来还开涮，比如在“即刻”上增加一个王以超又跳槽的提醒，或者在朋友圈发布一个王以超一年以内会离职的盘口。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">但是谁都不能否认，王以超有一个好心态。这么多次离职，虽然还没来得及实现财务自由，但是跟前东家都是和平分手，没有一次撕逼的。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p class=\"text-big-title\" style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; font-size: 20px; font-weight: 700; color: rgb(164, 29, 29); font-family: Arial, 微软雅黑, \">3</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">有些人的心态就没有那么好了。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">最近刷屏的两篇文章，《我那么努力！有两套房，却不得不离职，到底哪里出了问题》和《就算老公一毛钱股份都没拿到，在我心里，他依然是最牛逼的创业者》。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">前者是一个华为的高级工程师，在35岁的年纪背上了深圳的两套房贷，又遭遇了华为劝退，年收入从50万遽然降为20万，只好割肉卖掉一套学区房还债。接下来为了养育两个孩子，自己原本全职在家的太太也可能要重新出来找工作了。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">后者是一位互联网公司的运营，老公参与了一家游戏公司的创办，七年过去了只拿到了普通程序员的工资，期间有一次100万的分红用于结婚和买车，现在她在家全职带孩子，两万元的月收入要付9000元的房租和8000元的房贷，想要通过公司的股份套现缓解经济危机，结果发现老公根本不是公司的股东。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">这其中的是是非非很难讲清楚，很多剧情现在又出现了反转。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">但是其中确定的，是两个普通出身的家庭，身处过去十年二十年中国增长最迅猛的行业，本来以为自己的收入可以维持有车有房、太太全职在家、孩子接受更好教育的中产阶级生活，结果在2016年底2017年初的这个冬天，梦想被现实撞得粉碎。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">在垮掉之前，一个工程师自己动手，另一个工程师是老婆动手，用写一篇微信公众号文章宣泄不满，结果发现他们自己真的一点都不孤独。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">听说最近西二旗和中关村的程序员相亲，已经指明会写文章的姑娘优先。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">互联网人是好日子过久了，总以为12K的起薪是对程序员的羞辱，以为工资三年翻一番，职位五年跳三级是理所应当，以为一个大公司的中层加上几个90后泥腿子拿到几百万天使投资是正常现象。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">在1992年之前，中国哪一段历史可以说服你，寒门可以出贵子，阶层的流动可以一代以内完成？</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">2008年的金融危机后，哪一国的现状可以证明，中产阶级可以一人工作全家不饿，有房有车有医保，教育养老一劳永逸？</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">知乎上还有一票打抱不平的程序员摩拳擦掌，要为无产阶级兄弟讨回公道。但是写文章的华为员工已经承认了，作为一个农村出来的孩子，能够留在深圳还有一套自己的房子已经很不错了，之前又要生二胎又要学区房，是自己想多了。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">是的，我们这些童年享受了廉价的教育、医疗和住房，成年后通过高考跻身大城市，毕业后通过进入新兴行业获得收入增长的一代人都想多了。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">实际上就连“我是农民的儿子”这句话，从前也只有犯了错的省部级领导干部才有资格说。</p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \"><br/></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0px; color: rgb(51, 51, 51); font-family: Arial, 微软雅黑, \">如今一个落魄工程师在朋友圈写文章就敢随便用，这自媒体恐怕也要管一管了？</p><p><br/></p><p>原文来源 虎嗅网：https://www.huxiu.com/article/182469.html</p>', 'a:1:{i:0;s:60:\"/Public/Upload/Article/image/2017/02/24/1487908588560079.jpg\";}', '1', '30', '1484985139', '1487923760'), ('4', '奥斯卡“最佳影片”在中国的23年历程：从亡命天涯到爱乐之城', '', '17', '', '1', '<p><img src=\"/Public/Upload/Article/image/2017/02/24/1487909338925964.jpg\" title=\"1487909338925964.jpg\" alt=\"33.jpg\"/></p><p>奥斯卡“最佳影片”在中国的23年历程：从《亡命天涯》到《爱乐之城》</p><p>文/陈镔</p><p><br/></p><p>2017年奥斯卡颁奖在即，今年提名奥斯卡最佳影片的9部作品已经有三部登陆中国的大银幕——2月14日在中国内地起映的《爱乐之城》截至21日累积票房已达1.82亿，2016年末开画的《血战钢锯岭》和2017年初开画的《降临》分别拿下4.26亿和1.09亿。目前《爱乐之城》、《降临》和《血战钢锯岭》的全球票房也在提名的9部影片当中位列三甲，其中《爱乐之城》随着内地成绩的节节走高，有望冲击4亿美元的全球总票房大关，若如金球奖一样最终在奥斯卡颁奖礼上大丰收，则无疑将成为名利双收的最大赢家。</p><p>&nbsp;</p><p>事实上，奥斯卡奖和内地市场的联系正变得日益紧密：一方面，提名当年最佳影片的作品愈来愈频繁地被引进到国内，观众的欣赏水平也在与国际接轨；另外，资本层面上的连接在近年来持续加强，多部佳作的背后显现中国公司的身影，开拓出中美影视合作的新支流。</p><p>&nbsp;</p><p>下面，让我们从提名奥斯卡“最佳影片”的一系列作品入手，探寻奥斯卡奖“登陆”中国的缘起和未来。</p><p>&nbsp;</p><p>《亡命天涯》开启好莱坞中国征途，“最佳影片”连续11年被引进</p><p>&nbsp;</p><p>奥斯卡奖的正式名称为“美国电影艺术与科学学院奖”，第一届颁奖礼在1929年举行，迄今已有近90年的历史。</p><p>&nbsp;</p><p>在每年颁出的所有奖项中，“最佳影片”被认为代表了该年度电影工业的最高水准，其中尤以好莱坞出品的英语片为主；但由于价值观的差异和文化政策的限制，早期的奥斯卡“最佳影片”基本都被隔绝在外。</p><p>&nbsp;</p><p>直到1994年，在经历长期的市场低迷后，电影主管部门终于决定打开国门，启动了“十部进口大片”的新政。</p><p><br/></p><p><br/></p><p>据传在挑选第一部登陆的影片时，斩获奥斯卡“最佳影片”的《辛德勒的名单》和全球席卷逾9亿美元的《侏罗纪公园》在竞争中被刷下（均由史蒂文·斯皮尔伯格执导），最终胜出的是由哈里森·福特主演的《亡命天涯》。而该片也是1994年提名“最佳影片”的5强之一，由此成为奥斯卡与内地市场的首次官方接触。</p><p>&nbsp;</p><p>时隔一年，《阿甘正传》携“最佳影片”等6项大奖在全国公映，票房为1960万人民币。到了1998年，《泰坦尼克号》在时任国家领导人的亲自指示下得以驶入内地，不仅以3.6亿的成绩一举刷新影史记录，更成为世纪之交重大的文化事件之一。随后上映的《拯救大兵瑞恩》也拿下8230万，位居年度排行榜次席；该片与《伊丽莎白》和《美丽人生》均入选次年奥斯卡“最佳影片”的终选名单，创下中国市场单届奥斯卡引进数量的新高。</p><p>&nbsp;</p><p>进入新千年，奥斯卡登陆的步伐趋于稳健：从同期获得“最佳影片”的《角斗士》和“最佳外语片”的《卧虎藏龙》，到连续3年引进的《指环王》三部曲；虽然中间又经历两年的断档，但从2007年至今每年都至少有一部“最佳影片”提名作品进入内地院线。</p><p>&nbsp;</p><p>从2010年开始，奥斯卡“最佳影片”的入选名额扩大10部（两年后又调整为9部），同时伴随着国内市场容量的急剧膨胀，出现连续4年引进三部“最佳影片”的热潮，其中《阿凡达》、《盗梦空间》、《少年派的奇幻漂流》等片都是叫好又叫座。</p><p>&nbsp;</p><p>截至2016年，共有33部提名奥斯卡“最佳影片”的作品被引进内地，再加上今年已经上映的《爱乐之城》、《降临》和《血战钢锯岭》等3部影片，累计总票房接近58亿人民币。</p><p>&nbsp;</p><p>剧情片数量占优，科幻类型最受中国市场亲睐</p><p>&nbsp;</p><p>奥斯卡奖历来注重表彰人文上的艺术成就，因而剧情片的提名数量一直领先于其他类型，这一比例也在引进的奥斯卡最佳影片中得到体现：截至目前，共有11部提名或获奖的剧情片亮相内地银幕，接近总数的1/3。</p><p>&nbsp;</p><p>不过在市场反响上，虽然剧情片的口碑基本都处于中上水平，但票房号召力明显不足，单片平均仅有1572万的收成，在所有类型中居于末位。其中表现最好的是2015年上映的《模仿游戏》，但其时距离颁奖礼已过数月，又深处竞争火热的暑期档，5256万的成绩已殊为不易。另外诸如《国王的演讲》、《艺术家》、《钢琴师》和《女王》等均未能过千万，年代较久远的《伊丽莎白》和《美丽人生》甚至没有票房统计，剧情片的弱势可见一斑。</p><p>&nbsp;</p><p>最为符合国内观众口味的无疑是科幻片：从斩获13.4亿人民币的《阿凡达》，到《火星救援》、《盗梦空间》和《地心引力》等卖座大片，唯有今年刚上映的《降临》是近期引进的科幻片里的票房最低。这五部提名“最佳影片”的科幻片累计接近30亿元，可谓在中国市场名利双收的产品典范。</p><p>&nbsp;</p><p>唯一能在单片成绩上相抗衡的是冒险题材的《少年派的奇幻漂流》和《荒野猎人》，两片分别在11月和3月的淡季登场，合计拿下9.5亿元的票房，成绩相当傲人。</p><p>&nbsp;</p><p>另外，战争片和爱情片的数量都是4部，累计票房分别为6.48亿和6.17亿，可谓伯仲之间：前者由年初热卖逾4亿的《血战钢锯岭》打头阵，同由史蒂文·斯皮尔伯格执导的《战马》和《拯救大兵瑞恩》分列之后，排名最末的是拉塞尔·克劳主演的《怒海争锋》。爱情片则由《泰坦尼克号》和《爱乐之城》领衔，两片时隔近20年且同时斩获14项提名，浪漫经典永流传；另外两部则是带有歌舞元素的《悲惨世界》和《红磨坊》（后者引进时定名《梦断花都》）。随着《爱乐之城》持续热映，爱情片的排名还将继续上升。</p><p>&nbsp;</p><p>值得一提的是，提名“最佳影片”的动画片《飞屋环游记》和《玩具总动员3》均来自迪斯尼旗下的皮克斯工作室，而《指环王》三部曲则构成奇幻片的方阵，这两个类型的数量和票房都相对靠后。</p><p>&nbsp;</p><p>最后是引进5部但累计未过亿的动作片：由于《亡命天涯》、《卧虎藏龙》和《角斗士》的上映年份较早，彼时市场容量比较有限；而近年引进的《第九区》和《被解救的姜戈》也仅有1272万和1789万的收成，后者还爆出镜头删减问题而被迫“二次上映”，让痞导昆丁·塔伦蒂诺的内地首演不幸成为哑炮。</p><p>&nbsp;</p><p>中国资本迈入好莱坞，奥斯卡佳作陷“罗生门”</p><p>&nbsp;</p><p>说到中国资本与奥斯卡奖的关联，首先映入脑海的案例可能是“TCL中国剧院”：该剧院落成于1927年，曾在上世纪40年代作为奥斯卡奖的颁奖地点，同时也举办了多部好莱坞经典影片的首映式。在2013年，国内知名厂商TCL和中国剧院签订冠名协议，由此这座洛杉矶的地标建筑便在名称之外和中国产生了实质的连接。</p><p><br/></p><p><br/></p><p>TCL中国剧院的星光大道上已经留下了很多中国明星的手印</p><p><br/></p><p>近年随着内地市场在全球版图中的权重稳步上升，中国资本介入好莱坞的步伐由浅入深逐渐加码：前有万达收购AMC院线和传奇影业，随后阿里影业参投派拉蒙作品、复星入股Studio 8、万达牵手索尼影业等纷至沓来，显现中国影响力正从渠道端渗透到创作层面。</p><p>&nbsp;</p><p>而今年提名奥斯卡“最佳影片”的《爱乐之城》和《血战钢锯岭》背后均有中国资本的身影：2015年，电广传媒和狮门影业敲定3年15亿美元的合作事宜，而《爱乐之城》正是由狮门旗下的顶峰娱乐出品；《血战钢锯岭》的中国地区发行公司熙颐影业和联合出品方麒麟影业更是陷入了“中国版本署名权”的纠纷争议中，目前双方已经在中美两地影院都提起了法律诉讼，具体案情仍未明朗。</p><p>&nbsp;</p><p>可以期待，在未来的奥斯卡最佳影片中，中国元素将不仅仅停留在剧情的转捩点上（《地心引力》《火星救援》《降临》），而是深入到影视创作的更多面向中，让奥斯卡的多元传统与古老的东方文化交相辉映。</p><p><br/></p><p>原文来源 虎嗅网：https://www.huxiu.com/article/182474.html</p>', 'a:1:{i:0;s:60:\"/Public/Upload/Article/image/2017/02/24/1487909338925964.jpg\";}', '1', '42', '1484989903', '1487918853'), ('5', '如果你愿意，梁朝伟和我们来陪你', '', '17', '', '1', '<p><embed type=\"application/x-shockwave-flash\" class=\"edui-faked-video\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" src=\"http://player.youku.com/player.php/sid/XMTgyMTkwNjA0OA==/v.swf\" width=\"420\" height=\"280\" wmode=\"transparent\" play=\"true\" loop=\"false\" menu=\"false\" allowscriptaccess=\"never\" allowfullscreen=\"true\"/></p><p>由王家卫监制、张嘉佳执导的贺岁爱情喜剧《摆渡人》将于2016年12月23日全国上映。近日，影片发布“摆渡人前世今生”特辑，导演张嘉佳及梁朝伟、金城武、陈奕迅、Angelababy、张榕容、杜鹃、熊黛林等主演讲述自己心中的“摆渡人”，更谈及电影《摆渡人》拍摄的缘由。同时，影片发布海量剧照，二十大角色扮相同时曝光。</p><p><br/></p><p>视频来源 优酷网：http://v.youku.com/v_show/id_XMTgyMTkwNjA0OA==.html</p>', 'a:0:{}', '0', '25', '1485064767', '1487918896'), ('6', '金吉拉猫，英文名为chinchilla，属于新品种的猫', '', '17', '', '1', '<p><video class=\"edui-upload-video  vjs-default-skin      video-js\" controls=\"\" preload=\"none\" width=\"420\" height=\"280\" src=\"/Public/Upload/Article/video/2017/02/24/1487910089973766.mp4\" data-setup=\"{}\"></video></p><p>金吉拉猫是经过多年精心繁育而成的一个特色猫种。事实上，公认的金吉拉猫的祖先已难以考证，因为它是由很多种猫种繁育出来的，但是该猫种的起源却被详细地记录了下来。所以“金吉拉”这个名字不知道是于Chinnie而来的还是为该品种与名叫Chinchilla的南美栗鼠（即俗称的龙猫）有某些相同之处而来。</p><p><img src=\"/Public/Upload/Article/image/2017/02/24/1487910526632699.jpg\" title=\"1487910526632699.jpg\" alt=\"333.jpg\"/></p><p>历史上最成功的一只是Decies女士的出生于1895年的Ch Fulmer Zaida的金吉拉猫。它于6岁到10岁(1901-1905)之间连续获得了17个猫展的总冠军!现在的最高记录保持者是 Crockmore女士的雪云，它在1948-1955年间一共获得了18个冠军、5个后备冠军和1个第三名。</p><p><br/></p><p>金吉拉是最早纯人工育种，经过多年精心繁育而成的一个特色猫种。如今的金吉拉具有银色虎斑和烟色猫种的特点（尽管外表看来并不明显）。</p><p><br/></p><p>事实上，公认的金吉拉猫的祖先已难以考证，因为它是由很多种猫种繁育出来的。但是该猫种的起源却被详细地记录了下来。所有的线索都表明该猫种的繁育其实是由一只生于1882年的名叫Chinnie的母猫发展起来的。</p><p>所以“金吉拉”这个名字不知道是源于Chinnie而来的还是为该品种与名叫Chinchilla的南美栗鼠（即俗称的龙猫）有某些相同之处而来。</p><p><br/></p><p>经过繁育者们不懈的努力，金吉拉猫于1894年首次被作为一个独立的品种出现在英国水晶宫猫展上。</p><p><br/></p><p>原文来源 百度百科：http://baike.baidu.com/link?url=w6iQOS2ks0BWJvinCYkVRMgyiI16vMliqNY7Lip30jwfs1qJwkTQDBWlgU9oVbvJLURGeMAyg3isK4VJbEWVaOY7MsDeu17zKc2sADhWEeyg5UMKwJC6dalCQ2e0WwZX</p>', 'a:1:{i:0;s:60:\"/Public/Upload/Article/image/2017/02/24/1487910526632699.jpg\";}', '1', '22', '1485073500', '1487918944'), ('7', '微软执行副总裁沈向洋：对AlphaGo除了敬仰还是敬仰，但“脑科学+AI”最有意义', '', '17', '', '1', '<p><img src=\"/Public/Upload/Article/image/2017/02/24/1487910896781989.jpg\" title=\"1487910896781989.jpg\" alt=\"444.jpg\"/></p><p>在微软总部西雅图传闻中的34号楼，几家媒体已经开始在会议室落座等待。与其说是等待，不如说是翘首以盼。因为即将接受采访的这个人刚刚入选了美国工程院院士，工程界最高的荣誉之一。他就是微软全球执行副总裁沈向洋，微软核心管理层唯一的大陆华人，职位仅次于CEO ，也是美国科技行业职位最高的华人。</p><p><br/></p><p>除此之外，媒体更愿意让他能够分享一些对人工智能的思考与看法，去年（2016年）9月份微软新成立的“人工智能与研究事业部”由沈向洋全权负责。当然，还有一个八卦心（也可以说是好奇心）：对于陆奇离开微软，加入百度的看法，毕竟当时陆奇进入微软还是因为沈向洋的介绍。</p><p><br/></p><p>果然，沈向洋如期而到。据说，采访当天早上沈向洋才从外地匆匆忙忙赶回西雅图，但看到媒体的沈向洋完全没有倦容，很是兴奋的给大家介绍微软园区的情况。他总是能够知道媒体想要什么，不经意间透露一些料。</p><p><br/></p><p>“他更懂得识人”</p><p><br/></p><p>据说，在微软总部园区有一个停车场最靠近电梯，只有4个车位，其中有一个是萨提亚纳德拉的，还有一个就是沈向洋的，足以证明其在微软的位置。</p><p><br/></p><p>从1996年毕业于卡内基梅隆大学，然后进入微软研究院；再到2013年成为微软全球执行副总裁，职位仅次于CEO；再到2016年全面负责微软全球人工智能战略；2017年被选入美国工程院院士，沈向洋的每一步都成为了一个传奇。</p><p><br/></p><p>虽身居高位，但沈向洋从来没有架子。来自微软的员工透露，沈向洋非常随和，而且非常幽默，敢于自黑，在路上相遇总是喜欢主动和人打招呼。同时，在工作上沈向洋非常认真，在此次媒体采访之前，他还特意要了所有媒体的资料和介绍，做好了功课。</p><p><br/></p><p>在他负责微软人工智能与研究事业部之后不久，微软便在语音识别上取得了历史性突破。微软的对话语音识别技术在产业标准Switchboard语音识别基准测试中实现了出错率低至6.3%的突破，这意味着微软的语音识别系统的语音识别能力已经与人类专业高手持平。此前，更多是IBM在语音识别领域取得领先的地位。</p><p><br/></p><p>带领团队取得这一突破性进步的正是微软首席语音科学家黄学东，当问起为何微软能够取得这样的突破时，黄学东更愿意把功劳归为沈向洋。黄学东只提到了一句话“他更会识人”。</p><p><br/></p><p>微软员工透露，沈向洋用人举贤有不避亲，即使是空降到新团队也会把得力亲兵带过去一起干，同时也深入新团队了解情况，和一线码农一对一谈队伍，抓问题。</p><p><br/></p><p>对于陆奇离开微软，加入百度，沈向洋表示，“我只能祝福，非常感谢陆奇过去八年在微软做出的巨大贡献，我也非常相信陆奇在新的岗位上会再创辉煌。” 最初陆奇加入微软时，正是沈向洋向当时微软CEO鲍尔默进行的推荐。</p><p><br/></p><p>沈向洋当选为美国工程院院士正是因其“在计算机视觉和图形学的突出贡献，以及在业内的研发领导力。”</p><p><br/></p><p>AlphaGo让人敬仰，但未见商业化能力</p><p><br/></p><p>人工智能已经成为一个热词，每个公司CEO如果不谈那么一下人工智能都称不上是一个科技企业了。科技巨头纷纷投入人工智能当中，谷歌、IBM、微软以及英特尔等等。“人工智能实际上已经成为了一种文化。谷歌会说他们就是一家人工智能公司，就连Salesforce也会提到说要做人工智能，启动了一个叫’爱因斯坦’的项目。”沈向洋表示。</p><p><br/></p><p>谷歌因其AlphaGo大胜韩国世界围棋冠军李世石而被人所知；IBM的人工智能助手沃森被认为是其发展一百多年历史当中最具创新力第一次举措，也代表着人类进入人与机器相互融合阶段；微软则单独成立了人工智能与研究院……</p><p><br/></p><p>对于人工智能的发展，最让沈向洋兴奋的两点：一个是人工智能能力的增强；另外一个就是人机交互界面的彻底颠覆。</p><p><br/></p><p>“人工智能能力在不断增强，尤其在语音与计算机视觉方面。我认为，五年之内计算机视觉一定会超过人类；而十年之内，计算机视觉识别也一定会比人类更强。”沈向洋认为。</p><p><br/></p><p>正如上文提到的，微软语音识别技术出错率低已至6.3%，已经与人类专业高手持平。</p><p><br/></p><p>“最让我激动的还有就是所谓人机交互界面的彻底颠覆。”沈向洋表示，“无论人工智能到底怎么定义，这么多年以来，计算机科学的发展自始至终都在做一件事情——人机交互。包括手机、笔记本的发展都是如此。我们一直在研究如何与计算机同存共进。”</p><p><br/></p><p>沈向洋认为“用户图形界面”的概念正在被颠覆，语音用处越来越多，未来视频类技术也会随着跟上。而这也是微软一直在提的概念：对话式人工智能。比如其小娜、小冰。</p><p><br/></p><p>相比谷歌的AlphaGo在围棋方面大战人类，沈向洋更看重人工智能在商业领域的突破。</p><p><br/></p><p>“我对AlphaGo除了敬仰还是敬仰，真的非常了不起，的的确确打破了很多人对人工智能的想象。”沈向洋坦言，“但是AlphaGo虽然很了不起，我们却看不到它能真正应用到商业领域的地方。我个人认为，近三到五年，人工智能的突破还是在商业领域的应用。”</p><p><br/></p><p>具体来说是人工智能在传统商业领域，比如销售市场、客户支持、人力资源等领域的应用。</p><p><br/></p><p>沈向洋以市场销售为例。过去销售一件商品可能需要打很多拜访电话，有一个非常长的潜在客户名单。在面对这么多客户名字、公司的时候，需要判断在有限的时间里应该先联系谁，后联系谁。但是有了越来越多的数据可以参考和分析之后，可以利用人工智能技术让效率提升五倍、十倍。</p><p><br/></p><p>“脑科学+AI”将是最有意义的方向</p><p><br/></p><p>“AlphaGo已经证明了在围棋这个场景，机器比人厉害。但是未来，人工智能不需要证明它的计算能力和算法高于人，而是在无法理解的领域有所突破，也不光光是情感。”沈向洋表示。</p><p><br/></p><p>相比计算能力，沈向洋一直在强调人工智能的“情感”能力。他认为，虽然情感到底是什么至今都没有定论，但情感肯定不是计算，也不是计算出来的。之所以认为人类是智能的，就是因为人类有大脑。但对于大脑的神经科学的研究进展还非常缓慢，因此，沈向洋认为接下来“脑科学+AI”一定会成为科研角度最激动人心的方向。</p><p><br/></p><p>“如果我的学生说他想念博士的话，我会鼓励他们往这个方向去思考，这一定是接下来三十年最有意义的方向。”沈向洋提到。</p><p><br/></p><p>其实，微软的人工智能助理小冰已经带有“情感”的成分。这一“情感”成分来自大量的社交网站数据。小冰从诞生到现在已经有31个月，拥有4000万用户，在不断与其对话过程中，小冰也在不断深入学习，沈向洋认为小冰其实是数据驱动的方式在学习人类的情感。</p><p><br/></p><p>但是，当人工智能发展到拥有语言能力，语音能力，视觉能力以及理解能力的时候，人类是否会开始畏惧人工智能的发展呢？</p><p><br/></p><p>沈向洋直言：“我觉得畏惧也没有用。在任何一个技术浪潮到来的时候，我们都会非常谨慎。比如核能的例子，我们需要监管核能，因为一不小心就可能出大事。人工智能其实也产生过很多问题，包括伦理和偏见的问题。”</p><p><br/></p><p>因此，微软在公司内部成立了一个人工智能伦理委员会，不断学习和探讨这方面的问题。</p><p><br/></p><p>微软人工智能普及化</p><p><br/></p><p>在人工智能方面，微软一直强调“人工智能普及化”。这一概念是萨提亚在2016年Ignite大会上提出来的，并且描述了人工智能普及化的蓝图。</p><p><br/></p><p>微软这一概念更多的是针对开发者。微软上线了基于微软智能云的微软认知服务，在这个服务上微软开放了25个API，对于开发者来说可以介入语音、视觉、自然语言或者搜索等各种功能。据沈向洋透露，上线后很短时间内，微软已经累计了接近一百万个开发者。</p><p><br/></p><p>“我们相信，只有让这些开发者真正利用上最新的人工智能技术，才能通过他们让人工智能普及起来。”沈向洋表示。</p><p><br/></p><p>微软希望能够让更多人用到人工智能，享受到人工智能带来的技术、商业和用户体验上的提升。</p><p><br/></p><p>原文来源 虎嗅网：https://www.huxiu.com/article/182491.html</p>', 'a:1:{i:0;s:60:\"/Public/Upload/Article/image/2017/02/24/1487910896781989.jpg\";}', '1', '25', '1487819252', '1487923752'), ('8', '今天来揭秘主播的生活，我跟几位主播聊了聊她们当网红的感受', '', '17', '', '1', '<p><img src=\"/Public/Upload/Article/image/2017/02/24/1487911239364471.jpg\" alt=\"1487911239364471.jpg\"/></p><p>我跟6位主播聊了聊她们当网红的感受</p><p>前不久，有人说共享单车是人性的照妖镜，其实哪个领域不是呢？有人的地方就有江湖，江湖大了，就什么人都有。</p><p><br/></p><p>直播可以算是如今互联网最活跃的江湖了，超过300万的主播每天面对3亿多网民进行着各种各样的直播。</p><p><br/></p><p>这些主播里有明星、大V，也有学校中想出名的女生、夜场想赚钱的公关、工厂寂寞的女工、模特、COSER、礼仪、会打游戏会逗观众的资深玩家、有一技之长爱显摆的青年……他们有的凭借直播年入千万，有的却连饭都吃不起。</p><p><br/></p><p>今天，我找到了6位主播，他们都在直播间待了半年以上，如今已经可以把主播当成一个全职职业来谋生。在职业主播的眼里，直播界有哪些人性和现象呢，一起来听他们说说。</p><p><br/></p><p><img src=\"/Public/Upload/Article/image/2017/02/24/1487911239217867.jpg\" alt=\"1487911239217867.jpg\"/></p><p>注：文中所有主播昵称均为化名，图文无关</p><p>&nbsp;</p><p>慕容筱白——微博粉丝72万，直播半年，观看人数23000</p><p><br/></p><p>全中国长得好看的女的多了去了，真能当上网红的能有几个？网红也要讲究智商，你看见的傻白甜都是故意在卖蠢。</p><p><br/></p><p>做网红不要太聪明，太聪明你说出去的话总会有喷子想要反驳，而你卖卖蠢、犯犯傻，人们会觉得“这个姑娘真是可爱”，卖蠢、啥都不想，最容易把钱赚。</p><p><br/></p><p>要说当网红的“后遗症”，那就是以前到一个好看的景点都是拍风景，现在到一个好看的景点都想着先拍自己——哪个角度好看、怎么显得腿长、如何把摆拍拍出抓拍的效果……</p><p><br/></p><p>别以为有了美颜相机就能随时美若天仙，那些所谓的抓拍都是一次次快门累积出来的，废片/成片比上一百是常有的事，比姜文拍电影还费劲。</p><p><br/></p><p>虽然网友嘴上说着不喜欢网红脸，但身体很诚实，所以化妆遮瑕、收下巴是必须的。</p><p><br/></p><p>还有，装淑女真的很累，明明想说一句“妈卖批”但就是不能讲，只能说“今天去XXX看到了很多小萌物，好开心呀~”</p><p><br/></p><p><img src=\"/Public/Upload/Article/image/2017/02/24/1487911239850305.jpg\" alt=\"1487911239850305.jpg\"/></p><p>我是你刘姐——签约某公会，直播粉丝30万，观看人数15000</p><p>&nbsp;</p><p>其实直播套路大家都明白：公会从平台那里低价拿礼物开刷，带动观众刷礼物，观众的礼物平台、公会、主播分成。</p><p>&nbsp;</p><p>直播一年多我换过3个平台，大平台还不错，结算什么的比较及时，最怕那些小平台，两个月结算一次，明明结算比例公告和合同里写的很清楚，最后给钱的时候就能少出不少。</p><p>&nbsp;</p><p>直播的时候，为了吸引流量，鼓励我们露肉卖胸，等到算钱的时候跟我说我违规了，所以那几场直播的收入不能结算。违规了你不查封我直播间，让观众打赏着爽完了然后你不给钱？</p><p>&nbsp;</p><p>还有平台直接莫名其妙的“违规处理”，管你开没开播，不高兴就直接封号。这边你在家里睡觉呢，手机短信就告诉你封号了，之前的打赏也被扣除，至于什么时候违了什么规，你猜谁说了算？</p><p>&nbsp;</p><p>入行这么久，天天都能听见主播讨薪，一般公会欠薪的情况很少发生，大平台也几乎没有主播喊欠钱。所以珍爱直播，远离小平台。</p><p><br/></p><p>原文来源 虎嗅网：https://www.huxiu.com/article/182367.html</p>', 'a:3:{i:0;s:60:\"/Public/Upload/Article/image/2017/02/24/1487911239364471.jpg\";i:1;s:60:\"/Public/Upload/Article/image/2017/02/24/1487911239217867.jpg\";i:2;s:60:\"/Public/Upload/Article/image/2017/02/24/1487911239850305.jpg\";}', '3', '46', '1487819408', '1487923734'), ('9', '自定义跳转到第三方站点的一篇文章，由于简单所以复杂', '#CC00CC', '17', 'http://gong.gg/', '1', '<p>自定义跳转到第三方站点的一篇文章，由于简单所以复杂是</p><p>自定义跳转到第三方站点的一篇文章，由于简单所以复杂s是是是是</p>', 'a:0:{}', '0', '37', '1487920130', '1487944362');
COMMIT;

-- ----------------------------
--  Table structure for `sc_article_class`
-- ----------------------------
DROP TABLE IF EXISTS `sc_article_class`;
CREATE TABLE `sc_article_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='教室类别';

-- ----------------------------
--  Records of `sc_article_class`
-- ----------------------------
BEGIN;
INSERT INTO `sc_article_class` VALUES ('7', '0', '科学研究', '1', '0', '0', '2016-12-25 14:41:23'), ('10', '0', '校园景观', '1', '0', '0', '2016-12-25 14:42:31'), ('16', '0', '新闻八卦', '1', '0', '1482840545', '2016-12-27 20:09:05'), ('17', '0', '绿色校园', '1', '0', '1482840557', '2016-12-27 20:09:17'), ('18', '0', '人才培养', '1', '0', '1482840577', '2016-12-27 20:09:37'), ('24', '0', '合作交流', '1', '0', '1483951541', '2017-01-09 16:45:41');
COMMIT;

-- ----------------------------
--  Table structure for `sc_class`
-- ----------------------------
DROP TABLE IF EXISTS `sc_class`;
CREATE TABLE `sc_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `is_enable` (`is_enable`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='班级类别';

-- ----------------------------
--  Records of `sc_class`
-- ----------------------------
BEGIN;
INSERT INTO `sc_class` VALUES ('7', '0', '一年级', '1', '0', '0', '2016-12-25 14:41:23'), ('10', '0', '二年级', '1', '0', '0', '2016-12-25 14:42:31'), ('16', '10', '三年级', '1', '0', '1482840545', '2016-12-27 20:09:05'), ('17', '7', '一班', '1', '0', '1482840557', '2016-12-27 20:09:17'), ('18', '7', '二班', '1', '0', '1482840577', '2016-12-27 20:09:37'), ('19', '10', '天才班', '1', '0', '1482922284', '2016-12-28 18:51:24'), ('20', '10', '优秀班', '1', '0', '1482922305', '2016-12-28 18:51:45'), ('21', '10', '普通班', '1', '0', '1482922320', '2016-12-28 18:52:00'), ('22', '7', 'NickName', '1', '0', '1483927006', '2017-01-09 09:56:46'), ('23', '0', '好班级', '1', '0', '1483927617', '2017-01-09 10:06:57'), ('24', '16', '1班', '1', '0', '1483951541', '2017-01-09 16:45:41'), ('25', '0', '九年级', '1', '0', '1491922990', '2017-04-11 23:03:10'), ('26', '25', '三班', '1', '0', '1491922998', '2017-04-11 23:03:18');
COMMIT;

-- ----------------------------
--  Table structure for `sc_config`
-- ----------------------------
DROP TABLE IF EXISTS `sc_config`;
CREATE TABLE `sc_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '基本设置id',
  `value` text COMMENT '值',
  `name` char(60) NOT NULL DEFAULT '' COMMENT '名称',
  `describe` char(255) NOT NULL DEFAULT '' COMMENT '描述',
  `error_tips` char(150) NOT NULL DEFAULT '' COMMENT '错误提示',
  `type` char(30) NOT NULL DEFAULT '' COMMENT '类型（admin后台, home前台）',
  `only_tag` char(60) NOT NULL DEFAULT '' COMMENT '唯一的标记',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `only_tag` (`only_tag`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='基本配置参数';

-- ----------------------------
--  Records of `sc_config`
-- ----------------------------
BEGIN;
INSERT INTO `sc_config` VALUES ('15', '10', '分页数量', '分页显示数量', '分页不能超过3位数', 'admin', 'admin_page_number', '1494470659'), ('3', '20', '成绩等级', '差', '差,较差,中,良,优，不能超过3位数', 'admin', 'admin_fraction_weak', '1494470660'), ('4', '40', '成绩等级', '较差', '', 'admin', 'admin_fraction_poor', '1494470660'), ('5', '60', '成绩等级', '中', '', 'admin', 'admin_fraction_commonly', '1494470660'), ('6', '80', '成绩等级', '良', '', 'admin', 'admin_fraction_good', '1494470660'), ('7', '100', '成绩等级', '优', '', 'admin', 'admin_fraction_excellent', '1494470660'), ('8', '7', '学期', '当前学期类id', '请选择学期', 'admin', 'admin_semester_id', '1494470660'), ('11', '0', 'Excel编码', 'excel模块编码选择', '请选择编码', 'admin', 'admin_excel_charset', '1494470660'), ('16', 'SchoolCMS学校管理系统 - Powered by SchoolCMS', '站点标题', '浏览器标题，一般不超过80个字符', '站点标题不能为空', 'home', 'home_seo_site_title', '1491881206'), ('17', 'SchoolCMS,学校管理系统,教务管理系统', '站点关键字', '一般不超过100个字符，多个关键字以半圆角逗号 [ , ] 隔开', '站点关键字不能为空', 'home', 'home_seo_site_keywords', '1491881206'), ('18', 'SchoolCMS国内首个开源教务管理系统', '站点描述', '站点描述，一般不超过200个字符', '站点描述不能为空', 'home', 'home_seo_site_description', '1491881206'), ('19', '', 'ICP证书号', 'ICP域名备案号', '', 'home', 'home_site_icp', '1494759392'), ('20', '', '底部统计代码', '支持html，可用于添加流量统计代码', '', 'home', 'home_statistics_code', '0'), ('21', '1', '站点状态', '可暂时将站点关闭，其他人无法访问，但不影响管理员访问后台', '请选择站点状态', 'home', 'home_site_state', '1494759392'), ('22', '升级中...', '关闭原因', '支持html，当网站处于关闭状态时，关闭原因将显示在前台', '', 'home', 'home_site_close_reason', '1494759392'), ('23', 'Asia/Shanghai', '默认时区', '默认 亚洲/上海 [标准时+8]', '请选择默认时区', 'common', 'common_timezone', '1494759392'), ('24', '', '底部代码', '支持html，可用于添加流量统计代码', '', 'home', 'home_footer_info', '1494759392'), ('28', 'SchoolCMS', '站点名称', '', '站点名称不能为空', 'home', 'home_site_name', '1494759392'), ('29', '0', '链接模式', '详情ThinkPHP官网3.2版本文档 [http://www.thinkphp.cn/]', '请选择url模式', 'home', 'home_seo_url_model', '1491881206'), ('25', '2048000', '图片最大限制', '单位B [上传图片还受到服务器空间PHP配置最大上传 20M 限制]', '请填写图片上传最大限制', 'home', 'home_max_limit_image', '1494759392'), ('26', '51200000', '文件最大限制', '单位B [上传文件还受到服务器空间PHP配置最大上传 20M 限制]', '请填写文件上传最大限制', 'home', 'home_max_limit_file', '1494759392'), ('27', '102400000', '视频最大限制', '单位B [上传视频还受到服务器空间PHP配置最大上传 20M 限制]', '请填写视频上传最大限制', 'home', 'home_max_limit_video', '1494759392'), ('30', 'html', '伪静态后缀', '链接后面的后缀别名', '小写字母，不能超过8个字符', 'home', 'home_seo_url_html_suffix', '1491881206'), ('31', '1', '文章标题方案', '文章浏览器标题方案', '请选择文章标题方案', 'home', 'home_seo_article_browser', '1491881206'), ('32', '1', '频道标题方案', '频道浏览器标题方案', '请选择频道标题方案', 'home', 'home_seo_channel_browser', '1491881206'), ('33', '/Public/Upload/Home/image/home_logo.png', '站点logo', '尺寸最大180x38像数，支持 [jpg, png, gif]', '请上传网站logo', 'home', 'home_site_logo', '1494759392'), ('34', '1200', '页面最大宽度', '页面最大宽度，单位px，0则100%', '请填写页面最大宽度值', 'home', 'home_content_max_width', '1494759392'), ('35', '56.22', '图片比例', '为了站点自适应结构美观，图片尺寸需要统一比例[计算规则 比例值除以100再乘以图片宽度] 得到高度，[0不限制]', '图片比例值格式有误 0~100 之间，小数点后面最大两位', 'common', 'common_image_proportion', '1494470660'), ('36', 'sms,email', '是否开启注册', '关闭注册后，前台站点将无法注册，可选择 [ 短信, 邮箱 ]', '请选择是否开启注册状态', 'home', 'home_user_reg_state', '1494759392'), ('37', '1', '是否开启登录', '关闭后，前台站点将无法登录', '请选择是否开启登录状态', 'home', 'home_user_login_state', '1494759392'), ('38', '1', '获取验证码-开启图片验证码', '防止短信轰炸', '请选择是否开启强制图片验证码', 'home', 'home_img_verify_state', '1494759392'), ('39', '30', '获取验证码时间间隔', '防止频繁获取验证码，一般在 30~120 秒之间，单位 [秒]', '请填写获取验证码时间间隔', 'home', 'common_verify_time_interval', '1494759392'), ('40', '用户注册，验证码：#code#，10分钟内有效。如非本人操作请忽略本短信！', '用户注册-短信模板', '验证码变量标识符 [ #code# ]，详情云片官网 [https://www.yunpian.com/]', '请填写用户注册短信模板内容', 'home', 'home_sms_user_reg', '1490755448'), ('41', '美啦网', '短信签名', '发送短信包含的签名', '短信签名 3~8 个的中英文字符', 'home', 'common_sms_sign', '1490168548'), ('42', '17171d4ff3510ae8f532a70401e41067', '短信密钥', 'APIKEY接口请求密钥', '请填写APIKEY密钥', 'home', 'common_sms_apikey', '1490168548'), ('43', '密码找回，验证码：#code#，10分钟内有效。打死也不要告诉别人哦！', '密码找回-短信模板', '验证码变量标识符 [ #code# ]，详情云片官网 [https://www.yunpian.com/]', '请填写密码找回短信模板内容', 'home', 'home_sms_user_forget_pwd', '1490755448'), ('44', '600', '验证码有效时间', '验证码过期时间，一般10分钟左右，单位 [秒]', '请填写验证码有效时间', 'home', 'common_verify_expire_time', '1494759392'), ('45', 'smtp.163.com', 'SMTP服务器', '设置SMTP服务器的地址，如 smtp.163.com', '请填写SMTP服务器', 'common', 'common_email_smtp_host', '1489131056'), ('46', '25', 'SMTP端口', '设置SMTP服务器的端口，默认为 25', '请填写SMTP端口号', 'common', 'common_email_smtp_port', '1489131056'), ('47', 'weiletao88@163.com', '发信人邮件地址', '发信人邮件地址，使用SMTP协议发送的邮件地址，如 schoolcms@163.com', '请填写发信人邮件地址', 'common', 'common_email_smtp_account', '1489131056'), ('48', 'weiletao88@163.com', 'SMTP身份验证用户名', '如 schoolcms', '请填写SMTP身份验证用户名', 'common', 'common_email_smtp_name', '1489131056'), ('49', 'weiletao?', 'SMTP身份验证密码', 'schoolcms@163.com邮件的密码，如 123456', '请填写SMTP身份验证密码', 'common', 'common_email_smtp_pwd', '1489131056'), ('50', 'SchoolCMS', '发件人显示名称', '如 schoolcom', '', 'common', 'common_email_smtp_send_name', '1489131056'), ('51', '<p>用户注册，你的验证码是&nbsp;&nbsp;#code#</p><p><br/></p>', '用户注册-邮件模板', '验证码变量标识符 [ #code# ]', '', 'home', 'home_email_user_reg', '1490753353'), ('52', '<p>密码找回，你的验证码是&nbsp;&nbsp;#code#</p>', '密码找回-邮件模板', '验证码变量标识符 [ #code# ]', '', 'home', 'home_email_user_forget_pwd', '1490753353'), ('53', '<p>学生绑定，你的验证码是&nbsp;&nbsp;#code#</p>', '学生绑定-邮件模板', '验证码变量标识符 [ #code# ]', '', 'home', 'home_email_user_student_binding', '1490753353'), ('54', '学生绑定，验证码：#code#，10分钟内有效。打死也不要告诉别人哦！', '学生绑定-短信模板', '验证码变量标识符 [ #code# ]，详情云片官网 [https://www.yunpian.com/]', '请填写学生绑定短信模板内容', 'home', 'home_sms_user_student_binding', '1490755448'), ('55', '手机号码绑定，验证码：#code#，10分钟内有效。如非本人操作请忽略本短信！', '手机绑定-短信模板', '验证码变量标识符 [ #code# ]，详情云片官网 [https://www.yunpian.com/]', '请填写用手机绑定短信模板内容', 'home', 'home_sms_user_mobile_binding', '1490755448'), ('56', '<p>邮箱绑定，你的验证码是&nbsp;&nbsp;#code#</p><p><br/></p>', '邮箱绑定-邮件模板', '验证码变量标识符 [ #code# ]', '', 'home', 'home_email_user_email_binding', '1490753353'), ('57', 'Default', '默认模板', '前台默认模板', '请填写默认模板', 'common', 'common_default_theme', '1494812754');
COMMIT;

-- ----------------------------
--  Table structure for `sc_course`
-- ----------------------------
DROP TABLE IF EXISTS `sc_course`;
CREATE TABLE `sc_course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `semester_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '学期id',
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教师id',
  `class_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '班级id',
  `subject_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '科目id',
  `week_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '周天id',
  `interval_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '时段id',
  `room_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教室id',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态（0不可用，1可用）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `semester_teacher_class_subject_week_interval` (`semester_id`,`teacher_id`,`class_id`,`subject_id`,`week_id`,`interval_id`),
  UNIQUE KEY `semester_week_interval_room` (`semester_id`,`week_id`,`interval_id`,`room_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `class_id` (`class_id`),
  KEY `subject_id` (`subject_id`),
  KEY `week_id` (`week_id`),
  KEY `interval_id` (`interval_id`),
  KEY `semester_id` (`semester_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='教师课程';

-- ----------------------------
--  Records of `sc_course`
-- ----------------------------
BEGIN;
INSERT INTO `sc_course` VALUES ('11', '7', '4', '18', '17', '12', '14', '18', '1', '1484219105', '2017-01-14 18:00:16'), ('12', '7', '1', '17', '19', '12', '14', '17', '1', '1484367651', '2017-01-14 18:34:57'), ('13', '7', '2', '18', '20', '12', '14', '19', '1', '1484367695', '2017-01-14 12:21:35'), ('14', '7', '2', '19', '20', '14', '14', '17', '1', '1484367735', '2017-01-14 12:22:15');
COMMIT;

-- ----------------------------
--  Table structure for `sc_custom_view`
-- ----------------------------
DROP TABLE IF EXISTS `sc_custom_view`;
CREATE TABLE `sc_custom_view` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` char(60) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '内容',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `is_header` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否包含头部（0否, 1是）',
  `is_footer` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否包含尾部（0否, 1是）',
  `is_full_screen` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否满屏（0否, 1是）',
  `image` text COMMENT '图片数据（一维数组序列化）',
  `image_count` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文章图片数量',
  `access_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `is_enable` (`is_enable`),
  KEY `access_count` (`access_count`),
  KEY `image_count` (`image_count`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='自定义页面';

-- ----------------------------
--  Records of `sc_custom_view`
-- ----------------------------
BEGIN;
INSERT INTO `sc_custom_view` VALUES ('1', '测试自定义页面', '<p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><img src=\"/Public/Upload/CustomView/image/2017/02/28/1488268978709400.jpg\" title=\"1488268978709400.jpg\" alt=\"333.jpg\"/></span></p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \">秀，身材苗条！</span></p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"></span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">在欧美的排版业界中，使用 Arial 的作品意即是「不使用 Helvetica 的作品」，会被认為是设计师对字体的使用没有概念或是太容易妥协，基本上我大致也是同意。</p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \"><br/></p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">因為 Helvetica 只有 Mac 上才有內建，Windows 用戶除非花錢買，不然是沒有 Helvetica 能用，所以使用 Arial 的設計師往往被看成是不願意對 Typography 花錢，專業素養不到家的人。除了在確保網頁相容性等絕對必需的情況外，幾乎可以說是不應該使用的字體。</p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><br/></span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">在欧美的排版业界中，使用 Arial 的作品意即是「不使用 Helvetica 的作品」，会被认為是设计师对字体的使用没有概念或是太容易妥协，基本上我大致也是同意。</p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">因為 Helvetica 只有 Mac 上才有內建，Windows 用戶除非花錢買，不然是沒有 Helvetica 能用，所以使用 Arial 的設計師往往被看成是不願意對 Typography 花錢，專業素養不到家的人。除了在確保網頁相容性等絕對必需的情況外，幾乎可以說是不應該使用的字體。</p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><br/></span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">在欧美的排版业界中，使用 Arial 的作品意即是「不使用 Helvetica 的作品」，会被认為是设计师对字体的使用没有概念或是太容易妥协，基本上我大致也是同意。</p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">因為 Helvetica 只有 Mac 上才有內建，Windows 用戶除非花錢買，不然是沒有 Helvetica 能用，所以使用 Arial 的設計師往往被看成是不願意對 Typography 花錢，專業素養不到家的人。除了在確保網頁相容性等絕對必需的情況外，幾乎可以說是不應該使用的字體。</p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><br/></span></p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><br/></span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">在欧美的排版业界中，使用 Arial 的作品意即是「不使用 Helvetica 的作品」，会被认為是设计师对字体的使用没有概念或是太容易妥协，基本上我大致也是同意。</p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">因為 Helvetica 只有 Mac 上才有內建，Windows 用戶除非花錢買，不然是沒有 Helvetica 能用，所以使用 Arial 的設計師往往被看成是不願意對 Typography 花錢，專業素養不到家的人。除了在確保網頁相容性等絕對必需的情況外，幾乎可以說是不應該使用的字體。</p><p><span style=\"color: rgb(38, 38, 38); font-family: 微软雅黑, \"><br/></span></p><p style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">在欧美的排版业界中，使用 Arial 的作品意即是「不使用 Helvetica 的作品」，会被认為是设计师对字体的使用没有概念或是太容易妥协，基本上我大致也是同意。</p><p style=\"box-sizing: border-box; margin-top: 1.6rem; margin-bottom: 1.6rem; color: rgb(51, 51, 51); font-family: \">因為 Helvetica 只有 Mac 上才有內建，Windows 用戶除非花錢買，不然是沒有 Helvetica 能用，所以使用 Arial 的設計師往往被看成是不願意對 Typography 花錢，專業素養不到家的人。除了在確保網頁相容性等絕對必需的情況外，幾乎可以說是不應該使用的字體。</p><p><br/></p>', '1', '1', '1', '0', 'a:0:{}', '0', '514', '1484965691', '1488268982');
COMMIT;

-- ----------------------------
--  Table structure for `sc_fraction`
-- ----------------------------
DROP TABLE IF EXISTS `sc_fraction`;
CREATE TABLE `sc_fraction` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '成绩id',
  `semester_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '学期id',
  `student_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '学生id',
  `subject_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '科目id',
  `score_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '成绩期号',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分数',
  `comment` char(255) NOT NULL DEFAULT '' COMMENT '教师点评',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `semester_student_subject_score` (`semester_id`,`student_id`,`subject_id`,`score_id`),
  KEY `student_id` (`student_id`),
  KEY `subject_id` (`subject_id`),
  KEY `score_id` (`score_id`),
  KEY `score` (`score`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='学生成绩';

-- ----------------------------
--  Records of `sc_fraction`
-- ----------------------------
BEGIN;
INSERT INTO `sc_fraction` VALUES ('14', '7', '8', '19', '14', '88', '', '1483957162', '2017-01-09 18:19:22'), ('15', '7', '8', '19', '12', '98', 'sss', '1484041760', '2017-01-10 17:52:04'), ('16', '7', '8', '17', '14', '87', 'dd', '1484041823', '2017-01-10 17:50:23'), ('17', '7', '9', '17', '14', '77', '不错，比以前进步多了&lt;script&gt;alert(\'hello\');&lt;/script&gt;', '1484041940', '2017-01-10 17:52:20'), ('18', '7', '11', '20', '17', '78', '还不错的哦~', '1484056861', '2017-01-10 22:01:01'), ('19', '7', '10', '19', '14', '84', '', '1484057026', '2017-01-10 22:03:46'), ('20', '7', '12', '17', '14', '78', '哈哈哈很好的孩子', '1484393740', '2017-01-14 19:35:40'), ('21', '7', '9', '17', '12', '999', '', '1487858078', '2017-02-23 21:54:38'), ('22', '7', '20', '17', '12', '80', '很好', '1490277294', '2017-03-23 21:54:54'), ('23', '7', '20', '17', '14', '26', '', '1490351329', '2017-03-24 18:28:49'), ('24', '7', '20', '19', '12', '56', '', '1490351341', '2017-03-24 18:29:01'), ('25', '7', '20', '20', '12', '79', '', '1490351353', '2017-03-24 18:29:13'), ('26', '7', '8', '20', '14', '20', '', '1490351384', '2017-03-24 18:29:44'), ('27', '7', '8', '17', '12', '66', '', '1490351401', '2017-03-24 18:30:01'), ('28', '7', '8', '19', '17', '37', '', '1490351414', '2017-03-24 18:30:14'), ('29', '7', '10', '19', '20', '88', '', '1490351589', '2017-03-24 18:33:09'), ('30', '7', '12', '19', '14', '88', '哈哈哈哈', '1490511548', '2017-03-26 14:59:08'), ('31', '0', '9', '19', '12', '80', '小伙很好哦', '1491569100', '2017-04-07 21:51:10'), ('32', '0', '28', '20', '14', '60', '', '0', '2017-04-07 21:51:10'), ('33', '0', '12', '17', '12', '55', '', '0', '2017-04-07 21:51:10'), ('55', '7', '9', '19', '12', '80', '小伙很好哦', '1491569100', '2017-04-07 21:59:37'), ('56', '7', '28', '20', '14', '60', '', '0', '2017-04-07 21:59:37'), ('57', '7', '12', '17', '12', '55', '', '0', '2017-04-07 21:59:37'), ('58', '7', '57', '19', '20', '80', '', '1491981493', '2017-04-12 15:18:13'), ('59', '7', '38', '19', '20', '88', '', '1491981493', '2017-04-12 15:18:13');
COMMIT;

-- ----------------------------
--  Table structure for `sc_interval`
-- ----------------------------
DROP TABLE IF EXISTS `sc_interval`;
CREATE TABLE `sc_interval` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='时段类别';

-- ----------------------------
--  Records of `sc_interval`
-- ----------------------------
BEGIN;
INSERT INTO `sc_interval` VALUES ('14', '10:00-10:45', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '11:00-11:45', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '13:00-13:45', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '14:00-14:45', '1', '0', '1482851855', '2016-12-27 23:17:35'), ('21', '15:00-15:45', '1', '0', '1482852585', '2016-12-27 23:29:45'), ('22', '16:00-16:45', '1', '0', '1482852593', '2016-12-27 23:29:53');
COMMIT;

-- ----------------------------
--  Table structure for `sc_layout`
-- ----------------------------
DROP TABLE IF EXISTS `sc_layout`;
CREATE TABLE `sc_layout` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `type` char(60) NOT NULL DEFAULT '' COMMENT '布局类型',
  `value` char(60) NOT NULL DEFAULT '' COMMENT '布局类型值',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `value` (`value`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=521 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='布局管理';

-- ----------------------------
--  Records of `sc_layout`
-- ----------------------------
BEGIN;
INSERT INTO `sc_layout` VALUES ('1', 'home_link', '', '255', '1487657767', '1'), ('2', 'channel_link', '', '255', '1487657767', '1'), ('3', 'detail_link', '', '255', '1487657767', '1'), ('475', 'home', '84', '0', '1487728772', '1'), ('494', 'channel', '100', '0', '1487741535', '1'), ('501', 'detail', '100', '0', '1487747404', '1'), ('504', 'channel', '100', '1', '1487747719', '1'), ('505', 'home', '123', '2', '1487754569', '1'), ('507', 'home', '100', '1', '1487758192', '1'), ('509', 'detail', '100', '1', '1487835771', '1'), ('512', 'home', '100', '3', '1494318051', '1');
COMMIT;

-- ----------------------------
--  Table structure for `sc_layout_module`
-- ----------------------------
DROP TABLE IF EXISTS `sc_layout_module`;
CREATE TABLE `sc_layout_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `layout_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '布局id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '模块名称',
  `right_title` char(255) NOT NULL DEFAULT '' COMMENT '右标题+链接（名称;链接）',
  `article_id` char(255) NOT NULL DEFAULT '' COMMENT '指定主题id（1,2,3）',
  `keyword` char(255) NOT NULL DEFAULT '' COMMENT '标题包含的关键字（win-unix;win|unix）',
  `show_number` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '显示条数',
  `abstract_number` int(10) unsigned NOT NULL DEFAULT '80' COMMENT '摘要字数',
  `article_class_id` char(255) NOT NULL DEFAULT '' COMMENT '文章分类（序列化数据,一维数组）',
  `sort_type` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '排序方式',
  `add_time_interval` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间段',
  `upd_time_interval` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间段',
  `title_style` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标题样式',
  `link_open_way` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '打开方式',
  `date_format` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '日期格式',
  `data_cache_time` int(10) unsigned NOT NULL DEFAULT '60' COMMENT '数据缓存时间（单位分钟）',
  `summary` text COMMENT '自定义内容',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=865 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='布局模块';

-- ----------------------------
--  Records of `sc_layout_module`
-- ----------------------------
BEGIN;
INSERT INTO `sc_layout_module` VALUES ('788', '475', '', '', '', '', '10', '80', '0', '0', '0', '0', '310', '0', '0', '60', '', '1487728772', '1494323473'), ('789', '475', '热门文章', '更多;http://gong.gg', '', '', '8', '80', '0', '2', '0', '0', '1', '0', '0', '60', '', '1487728772', '1494492528'), ('827', '494', '热门文章', '更多;http://gong.gg', '', '', '10', '80', '0', '0', '0', '0', '1', '0', '1', '60', '', '1487741535', '1488125040'), ('836', '501', '热门文章', '更多;http://gong.gg', '', '', '10', '80', '0', '0', '0', '0', '1', '0', '0', '60', '', '1487747404', '1488125054'), ('840', '504', '美图', '', '', '', '6', '80', '0', '0', '0', '0', '12', '0', '0', '60', '', '1487747719', '1488125048'), ('841', '505', '关于我们', '更多;http://gong.gg', '', '', '10', '80', '0', '0', '0', '0', '2', '0', '0', '60', '', '1487754570', '1488124966'), ('842', '505', '校园动态', '更多;http://gong.gg', '', '', '10', '80', '0', '0', '0', '0', '2', '0', '0', '60', '', '1487754571', '1488125094'), ('843', '505', '领导新闻', '更多;http://gong.gg', '', '', '10', '80', '0', '0', '0', '0', '1', '0', '0', '60', '', '1487754572', '1488124984'), ('844', '505', '优秀学生', '更多;http://gong.gg', '', '', '10', '80', '0', '0', '0', '0', '1', '0', '0', '60', '', '1487754573', '1488124989'), ('845', '505', '生活常识', '更多;http://gong.gg', '', '', '10', '80', '0', '0', '0', '0', '2', '0', '1', '60', '', '1487754582', '1488125005'), ('846', '505', '学习技巧', '更多;http://gong.gg', '', '', '10', '80', '0', '0', '0', '0', '2', '0', '1', '60', '', '1487754583', '1488125016'), ('848', '507', '', '', '', '', '10', '160', '0', '0', '0', '0', '15', '0', '0', '60', '', '1487758192', '1488124907'), ('851', '509', '图文', '更多;http://gong.gg', '', '', '10', '80', '0', '0', '0', '0', '6', '0', '0', '60', '', '1487835771', '1488125059'), ('856', '512', '教师排行', '', '', '', '10', '80', '0', '0', '0', '0', '302', '0', '0', '60', '', '1494318051', '1494321671');
COMMIT;

-- ----------------------------
--  Table structure for `sc_link`
-- ----------------------------
DROP TABLE IF EXISTS `sc_link`;
CREATE TABLE `sc_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '导航名称',
  `url` char(255) NOT NULL DEFAULT '' COMMENT 'url地址',
  `describe` char(60) NOT NULL DEFAULT '' COMMENT '数据类型（custom:自定义导航, article_class:文章分类, customview:自定义页面）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `is_new_window_open` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否新窗口打开（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `sort` (`sort`),
  KEY `is_enable` (`is_enable`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='友情链接';

-- ----------------------------
--  Records of `sc_link`
-- ----------------------------
BEGIN;
INSERT INTO `sc_link` VALUES ('1', 'SchoolCMS', 'http://schoolcms.org/', 'SchoolCMS学校教务管理系统', '1', '1', '1', '1486292373', '2017-02-24 14:53:16'), ('12', 'AmazeUI', 'http://amazeui.org/', 'AmazeUI国内首个HTML5框架', '4', '1', '1', '1486353476', '2017-02-24 14:53:39'), ('13', '龚哥哥的博客', 'http://gong.gg/', '龚哥哥的博客', '2', '1', '1', '1486353528', '2017-02-24 14:53:21'), ('14', 'ThinkPHP', 'http://www.thinkphp.cn/', 'ThinkPHP', '3', '1', '1', '1487919160', '2017-02-24 14:53:31');
COMMIT;

-- ----------------------------
--  Table structure for `sc_mood`
-- ----------------------------
DROP TABLE IF EXISTS `sc_mood`;
CREATE TABLE `sc_mood` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `content` char(168) NOT NULL DEFAULT '' COMMENT '个人签名（最大字数168）',
  `visible` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见范围（0所有人可见, 1仅自己可见, 2好友可见, 3部分好友可见, 4部分好友不可见）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发表时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='用户说说';

-- ----------------------------
--  Records of `sc_mood`
-- ----------------------------
BEGIN;
INSERT INTO `sc_mood` VALUES ('21', '15', '大家好，新来的，多多关照~', '0', '1491658779'), ('26', '13', '嘻嘻嘻嘻是小狗', '0', '1491748949'), ('28', '12', '不是所有的往事都是美好的，也不是所有的回忆都应该被留下。', '0', '1491879049');
COMMIT;

-- ----------------------------
--  Table structure for `sc_mood_comments`
-- ----------------------------
DROP TABLE IF EXISTS `sc_mood_comments`;
CREATE TABLE `sc_mood_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `mood_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '说说id',
  `reply_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '说说被回复的id',
  `content` char(255) NOT NULL DEFAULT '' COMMENT '评论内容（1~255个字符之间）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `user_id` (`user_id`),
  KEY `mood_id` (`mood_id`),
  KEY `reply_id` (`reply_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COMMENT='说说评论';

-- ----------------------------
--  Records of `sc_mood_comments`
-- ----------------------------
BEGIN;
INSERT INTO `sc_mood_comments` VALUES ('57', '0', '13', '21', '0', '洗洗', '1491809198'), ('67', '0', '12', '26', '0', '你好，很高兴认识你', '1491809877'), ('68', '0', '12', '26', '0', '你好，在没有嘛，', '1491809893'), ('69', '67', '13', '26', '67', '你好，我也很高兴认识你哦。', '1491809913'), ('70', '68', '13', '26', '68', '在呢，无处不在。', '1491809923');
COMMIT;

-- ----------------------------
--  Table structure for `sc_mood_praise`
-- ----------------------------
DROP TABLE IF EXISTS `sc_mood_praise`;
CREATE TABLE `sc_mood_praise` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `mood_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '说说id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '赞说说的用户id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_mood` (`mood_id`,`user_id`),
  KEY `mood_id` (`mood_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COMMENT='说说点赞';

-- ----------------------------
--  Records of `sc_mood_praise`
-- ----------------------------
BEGIN;
INSERT INTO `sc_mood_praise` VALUES ('10', '23', '15', '1491718148'), ('54', '21', '13', '1491818026'), ('65', '28', '13', '1491879087'), ('68', '28', '15', '1491879159'), ('69', '21', '12', '1494325888');
COMMIT;

-- ----------------------------
--  Table structure for `sc_navigation`
-- ----------------------------
DROP TABLE IF EXISTS `sc_navigation`;
CREATE TABLE `sc_navigation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '导航名称',
  `url` char(255) NOT NULL DEFAULT '' COMMENT 'url地址',
  `value` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `data_type` char(30) NOT NULL DEFAULT '' COMMENT '数据类型（custom:自定义导航, article_class:文章分类, customview:自定义页面）',
  `nav_type` char(30) NOT NULL DEFAULT '' COMMENT '导航类型（header:顶部导航, footer:底部导航）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示（0否，1是）',
  `is_new_window_open` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否新窗口打开（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `is_show` (`is_show`),
  KEY `sort` (`sort`),
  KEY `nav_type` (`nav_type`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='导航';

-- ----------------------------
--  Records of `sc_navigation`
-- ----------------------------
BEGIN;
INSERT INTO `sc_navigation` VALUES ('2', '0', '绿色校园', '', '17', 'article_class', 'header', '0', '1', '0', '1486297310', '2017-02-24 16:18:50'), ('3', '0', '新闻八卦', '', '16', 'article_class', 'header', '0', '1', '0', '1486298744', '2017-02-24 16:16:30'), ('8', '0', '自定义页面', '', '1', 'customview', 'header', '0', '1', '0', '1486352254', '2017-02-24 16:03:59'), ('9', '0', '二级菜单', '', '1', 'customview', 'header', '0', '1', '0', '1486352437', '2017-02-24 16:06:24'), ('10', '9', '自定义页面2', '', '1', 'customview', 'header', '0', '1', '0', '1486352476', '2017-02-24 16:05:52'), ('12', '0', '底部导航测试', 'http://schoolcms.org/', '0', 'custom', 'footer', '2', '1', '0', '1486353476', '2017-02-06 12:00:32'), ('13', '0', '客户服务', '', '10', 'article_class', 'footer', '1', '1', '0', '1486353528', '2017-02-06 11:59:05'), ('14', '0', '龚哥哥的博客', 'http://gong.gg/', '0', 'custom', 'footer', '0', '1', '1', '1486525988', '2017-02-08 11:53:29'), ('15', '0', '联系我们', 'http://schoolcms.org/', '0', 'custom', 'footer', '0', '1', '0', '1486544708', '2017-02-08 17:05:08'), ('16', '0', '关于学生', '', '18', 'article_class', 'footer', '0', '1', '0', '1486544740', '2017-02-08 17:05:40'), ('17', '0', '教务系统', 'http://schoolcms.org/', '0', 'custom', 'header', '10', '1', '1', '1487923617', '2017-02-24 16:06:57');
COMMIT;

-- ----------------------------
--  Table structure for `sc_power`
-- ----------------------------
DROP TABLE IF EXISTS `sc_power`;
CREATE TABLE `sc_power` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权限父级id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '权限名称',
  `control` char(30) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action` char(30) NOT NULL DEFAULT '' COMMENT '方法名称',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示（0否，1是）',
  `icon` char(60) NOT NULL DEFAULT '' COMMENT '图标class',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='权限';

-- ----------------------------
--  Records of `sc_power`
-- ----------------------------
BEGIN;
INSERT INTO `sc_power` VALUES ('1', '0', '权限控制', 'Power', 'Index', '1', '1', 'am-icon-recycle', '1481612301'), ('4', '1', '角色管理', 'Power', 'Role', '11', '1', '', '1481639037'), ('8', '0', '类别管理', 'Routine', 'Index', '20', '1', 'am-icon-yelp', '1481697671'), ('10', '8', '班级分类', 'Class', 'Index', '20', '1', '', '1481727987'), ('11', '8', '科目分类', 'Subject', 'Index', '30', '1', '', '1481728003'), ('12', '8', '学期分类', 'Semester', 'Index', '0', '1', '', '1481728021'), ('13', '1', '权限分配', 'Power', 'Index', '21', '1', '', '1482156143'), ('15', '1', '权限添加/编辑', 'Power', 'PowerSave', '22', '0', '', '1482243750'), ('16', '1', '权限删除', 'Power', 'PowerDelete', '23', '0', '', '1482243797'), ('17', '1', '角色组添加/编辑页面', 'Power', 'RoleSaveInfo', '12', '0', '', '1482243855'), ('18', '1', '角色组添加/编辑', 'Power', 'RoleSave', '13', '0', '', '1482243888'), ('19', '1', '管理员添加/编辑页面', 'Admin', 'SaveInfo', '2', '0', '', '1482244637'), ('20', '1', '管理员添加/编辑', 'Admin', 'Save', '3', '0', '', '1482244666'), ('21', '1', '管理员删除', 'Admin', 'Delete', '4', '0', '', '1482244688'), ('22', '1', '管理员列表', 'Admin', 'Index', '1', '1', '', '1482568868'), ('23', '1', '角色删除', 'Power', 'RoleDelete', '14', '0', '', '1482569155'), ('24', '8', '成绩分类', 'Score', 'Index', '40', '1', '', '1482638641'), ('25', '8', '周分类', 'Week', 'Index', '50', '1', '', '1482638899'), ('26', '8', '时段分类', 'Interval', 'Index', '60', '1', '', '1482638982'), ('27', '8', '地区管理', 'Region', 'Index', '70', '1', '', '1482639024'), ('28', '0', '学生管理', 'Student', 'Index', '2', '1', 'am-icon-mortar-board fs-12', '1482854151'), ('29', '28', '学生列表', 'Student', 'Index', '1', '1', '', '1482854186'), ('30', '0', '成绩管理', 'Fraction', 'Index', '3', '1', 'am-icon-line-chart fs-12', '1482854384'), ('31', '30', '学生成绩', 'Fraction', 'Index', '1', '1', '', '1482854429'), ('32', '28', '学生添加/编辑页面', 'Student', 'SaveInfo', '2', '0', '', '1482915262'), ('33', '28', '学生添加/编辑', 'Student', 'Save', '3', '0', '', '1482915761'), ('34', '28', '学生删除', 'Student', 'Delete', '4', '0', '', '1482915804'), ('35', '30', '成绩录入页面', 'Fraction', 'SaveInfo', '2', '0', '', '1483096318'), ('36', '30', '成绩删除', 'Fraction', 'Delete', '4', '0', '', '1483096348'), ('37', '30', '成绩添加/编辑', 'Fraction', 'Save', '3', '0', '', '1483176255'), ('38', '0', '教师管理', 'Teacher', 'Index', '4', '1', 'am-icon-legal', '1483283430'), ('39', '38', '教师管理', 'Teacher', 'Index', '1', '1', '', '1483283546'), ('40', '38', '课程安排', 'Course', 'Index', '20', '1', '', '1483283640'), ('41', '0', '后台配置', 'Config', 'Index', '0', '1', 'am-icon-gear', '1483362358'), ('42', '41', '配置保存', 'Config', 'Save', '1', '0', '', '1483432335'), ('43', '8', '学期添加/编辑', 'Semester', 'Save', '1', '0', '', '1483456550'), ('44', '8', '班级添加/编辑', 'Class', 'Save', '21', '0', '', '1483456605'), ('45', '8', '科目添加/编辑', 'Subject', 'Save', '31', '0', '', '1483456640'), ('46', '8', '成绩添加/编辑', 'Score', 'Save', '41', '0', '', '1483456687'), ('47', '8', '周添加/编辑', 'Week', 'Save', '51', '0', '', '1483456721'), ('48', '8', '时段添加/编辑', 'Interval', 'Save', '61', '0', '', '1483456748'), ('49', '8', '地区添加/编辑', 'Region', 'Save', '71', '0', '', '1483456778'), ('50', '8', '学期删除', 'Semester', 'Delete', '2', '0', '', '1483457140'), ('51', '8', '班级删除', 'Class', 'Delete', '22', '0', '', '1483457222'), ('52', '8', '科目删除', 'Subject', 'Delete', '32', '0', '', '1483457265'), ('53', '8', '成绩删除', 'Score', 'Delete', '42', '0', '', '1483457291'), ('54', '8', '周删除', 'Week', 'Delete', '52', '0', '', '1483457365'), ('55', '8', '时段删除', 'Interval', 'Delete', '62', '0', '', '1483457405'), ('56', '8', '地区删除', 'Region', 'Delete', '72', '0', '', '1483457442'), ('57', '38', '教师添加/编辑页面', 'Teacher', 'SaveInfo', '2', '0', '', '1483616439'), ('58', '38', '教师添加/编辑', 'Teacher', 'Save', '3', '0', '', '1483616492'), ('59', '38', '教师删除', 'Teacher', 'Delete', '4', '0', '', '1483616569'), ('60', '38', '课程添加/编辑页面', 'Course', 'SaveInfo', '21', '0', '', '1483790861'), ('61', '38', '课程添加/编辑', 'Course', 'Save', '22', '0', '', '1483790940'), ('62', '38', '课程删除', 'Course', 'Delete', '23', '0', '', '1483790962'), ('63', '28', 'Excel导出', 'Student', 'ExcelExport', '5', '0', '', '1484058295'), ('64', '30', 'Excel导出', 'Fraction', 'ExcelExport', '5', '0', '', '1484058375'), ('65', '38', 'Excel导出', 'Teacher', 'ExcelExport', '5', '0', '', '1484058437'), ('66', '38', 'Excel导出', 'Course', 'ExcelExport', '24', '0', '', '1484058488'), ('67', '38', '课程状态更新', 'Course', 'StateUpdate', '25', '0', '', '1484231130'), ('68', '8', '教室管理', 'Room', 'Index', '80', '1', '', '1484304475'), ('69', '8', '教室添加/编辑', 'Room', 'Save', '81', '0', '', '1484304519'), ('70', '8', '教室删除', 'Room', 'Delete', '82', '0', '', '1484304545'), ('71', '8', '文章分类', 'ArticleClass', 'Index', '90', '1', '', '1484580289'), ('72', '8', '文章分类编辑/添加', 'ArticleClass', 'Save', '91', '0', '', '1484580380'), ('73', '8', '文章分类删除', 'ArticleClass', 'Delete', '92', '0', '', '1484580436'), ('74', '0', '文章管理', 'Article', 'Index', '5', '1', 'am-icon-folder-open', '1484581913'), ('75', '74', '文章管理', 'Article', 'Index', '0', '1', '', '1484581938'), ('76', '74', '文章添加/编辑页面', 'Article', 'SaveInfo', '1', '0', '', '1484740785'), ('77', '74', '文章添加/编辑', 'Article', 'Save', '2', '0', '', '1484740810'), ('78', '74', '文章删除', 'Article', 'Delete', '3', '0', '', '1484740826'), ('79', '74', 'Excel导出', 'Article', 'ExcelExport', '6', '0', '', '1484981822'), ('80', '74', '文章状态更新', 'Article', 'StateUpdate', '7', '0', '', '1484982416'), ('81', '0', '站点配置', 'Site', 'Index', '9', '1', 'am-icon-cogs', '1486182943'), ('82', '102', '中间导航', 'NavHeader', 'Index', '0', '1', '', '1486183114'), ('83', '102', '底部导航', 'NavFooter', 'Index', '11', '1', '', '1486183145'), ('84', '102', '导航添加/编辑页面', 'NavHeader', 'SaveInfo', '1', '0', '', '1486183347'), ('85', '102', '导航添加/编辑', 'NavHeader', 'Save', '2', '0', '', '1486183367'), ('86', '102', '导航删除', 'NavHeader', 'Delete', '3', '0', '', '1486183410'), ('87', '102', '导航状态更新', 'NavHeader', 'StateUpdate', '4', '0', '', '1486183462'), ('88', '102', '导航添加/编辑页面', 'NavFooter', 'SaveInfo', '12', '0', '', '1486183538'), ('89', '102', '导航添加/编辑', 'NavFooter', 'Save', '13', '0', '', '1486183800'), ('90', '102', '导航删除', 'NavFooter', 'Delete', '14', '0', '', '1486192992'), ('91', '102', '导航状态更新', 'NavFooter', 'StateUpdate', '15', '0', '', '1486193042'), ('92', '102', '自定义页面', 'CustomView', 'Index', '21', '1', '', '1486193400'), ('93', '102', '自定义页面添加/编辑页面', 'CustomView', 'SaveInfo', '22', '0', '', '1486193449'), ('94', '102', '自定义页面添加/编辑', 'CustomView', 'Save', '23', '0', '', '1486193473'), ('95', '102', '自定义页面删除', 'CustomView', 'Delete', '24', '0', '', '1486193516'), ('96', '102', '自定义页面状态更新', 'CustomView', 'StateUpdate', '25', '0', '', '1486193582'), ('97', '102', '友情链接', 'Link', 'Index', '31', '1', '', '1486194358'), ('98', '102', '友情链接添加/编辑页面', 'Link', 'SaveInfo', '32', '0', '', '1486194392'), ('99', '102', '友情链接添加/编辑', 'Link', 'Save', '33', '0', '', '1486194413'), ('100', '102', '友情链接删除', 'Link', 'Delete', '34', '0', '', '1486194435'), ('101', '102', '友情链接状态更新', 'Link', 'StateUpdate', '35', '0', '', '1486194479'), ('102', '0', '网站管理', 'NavHeader', 'Index', '10', '1', 'am-icon-university fs-12', '1486561030'), ('103', '81', '站点设置', 'Site', 'Index', '0', '1', '', '1486561470'), ('104', '81', '短信设置', 'Sms', 'Index', '3', '1', '', '1486561615'), ('105', '81', '站点设置添加/编辑', 'Site', 'Save', '1', '0', '', '1486561780'), ('106', '81', 'SEO设置', 'Seo', 'Index', '51', '1', '', '1486561958'), ('107', '81', '短信设置添加/编辑', 'Sms', 'Save', '4', '0', '', '1486562011'), ('108', '81', 'SEO设置添加/编辑', 'Seo', 'Save', '52', '0', '', '1486562038'), ('109', '102', '页面设置', 'View', 'Index', '41', '1', '', '1486562396'), ('110', '102', '获取模块数据/保存', 'View', 'GetLayoutModuleData', '42', '0', '', '1486562436'), ('111', '102', '布局添加/编辑', 'View', 'LayoutSave', '43', '0', '', '1486562480'), ('112', '102', '模块添加', 'View', 'ModuleAdd', '47', '0', '', '1487341698'), ('113', '102', '模块保存', 'View', 'ModuleSave', '48', '0', '', '1487341728'), ('114', '102', '布局状态更新', 'View', 'StateUpdate', '44', '0', '', '1487563663'), ('115', '102', '布局删除', 'View', 'LayoutDelete', '45', '0', '', '1487569443'), ('116', '102', '模块删除', 'View', 'ModuleDelete', '49', '0', '', '1487569470'), ('117', '102', '布局排序保存', 'View', 'LayoutSortSave', '46', '0', '', '1487578045'), ('118', '0', '工具', 'Tool', 'Index', '30', '1', 'am-icon-coffee', '1488108044'), ('119', '118', '缓存管理', 'Cache', 'Index', '1', '1', '', '1488108107'), ('120', '118', '站点缓存更新', 'Cache', 'SiteUpdate', '2', '0', '', '1488108235'), ('121', '118', '模板缓存更新', 'Cache', 'TemplateUpdate', '2', '0', '', '1488108390'), ('122', '118', '模块缓存更新', 'Cache', 'ModuleUpdate', '3', '0', '', '1488108436'), ('123', '81', '邮箱设置', 'Email', 'Index', '5', '1', '', '1488531116'), ('124', '81', '邮箱添加/编辑', 'Email', 'Save', '6', '0', '', '1489056600'), ('125', '81', '邮件发送测试', 'Email', 'EmailTest', '7', '0', '', '1489131159'), ('126', '0', '用户管理', 'User', 'Index', '11', '1', 'am-icon-user', '1490794162'), ('127', '126', '用户列表', 'User', 'Index', '0', '1', '', '1490794316'), ('128', '126', '用户编辑/添加页面', 'User', 'SaveInfo', '1', '0', '', '1490794458'), ('129', '126', '用户添加/编辑', 'User', 'Save', '2', '0', '', '1490794510'), ('130', '126', '用户删除', 'User', 'Delete', '3', '0', '', '1490794585'), ('131', '28', 'Excel导入', 'Student', 'ExcelImport', '6', '0', '', '1491468767'), ('132', '30', 'Excel导入', 'Fraction', 'ExcelImport', '6', '0', '', '1491569358'), ('133', '0', '冒泡管理', 'Bubble', 'Index', '12', '1', 'am-icon-slideshare', '1491818684'), ('134', '133', '冒泡广场', 'Bubble', 'Index', '0', '1', '', '1491818817'), ('135', '133', '说说删除', 'Bubble', 'MoodDelete', '1', '0', '', '1491992341'), ('136', '133', '说说点赞删除', 'Bubble', 'MoodPraiseDelete', '2', '0', '', '1491992378'), ('137', '133', '说说评论删除', 'Bubble', 'MoodCommentsDelete', '3', '0', '', '1491992409'), ('138', '102', '主题管理', 'Theme', 'Index', '60', '1', '', '1494381693'), ('139', '102', '主题管理添加/编辑', 'Theme', 'Save', '61', '0', '', '1494398194'), ('140', '102', '主题上传安装', 'Theme', 'Upload', '62', '0', '', '1494405096'), ('141', '102', '主题删除', 'Theme', 'Delete', '63', '0', '', '1494410655'), ('142', '102', '布局导出', 'View', 'LayoutExport', '50', '0', '', '1494490765'), ('143', '102', '布局导入', 'View', 'LayoutImport', '51', '0', '', '1494490833');
COMMIT;

-- ----------------------------
--  Table structure for `sc_region`
-- ----------------------------
DROP TABLE IF EXISTS `sc_region`;
CREATE TABLE `sc_region` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `is_enable` (`is_enable`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='地区';

-- ----------------------------
--  Records of `sc_region`
-- ----------------------------
BEGIN;
INSERT INTO `sc_region` VALUES ('7', '0', '谯家镇2', '1', '2', '0', '2016-12-25 14:41:23'), ('8', '7', '印山村2', '1', '0', '0', '2016-12-25 14:41:38'), ('9', '8', '康家坨', '1', '0', '0', '2016-12-25 14:41:54'), ('10', '0', '夹石镇', '0', '1', '0', '2016-12-25 14:42:31'), ('11', '10', '水进湾', '1', '0', '0', '2016-12-25 14:42:53'), ('12', '0', '小垫矮', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '8', '麻池', '1', '0', '0', '2016-12-25 17:19:00'), ('15', '8', '并蛋鸭', '1', '0', '0', '2016-12-25 17:19:17'), ('17', '0', '试试水', '1', '0', '1482847113', '2016-12-27 21:58:33'), ('18', '7', '时代复分', '1', '0', '1482850246', '2016-12-27 22:50:46'), ('19', '9', '的方法发', '1', '0', '1482851116', '2016-12-27 23:05:16'), ('20', '17', 'sdfsd', '1', '0', '1484204770', '2017-01-12 15:06:10'), ('21', '0', '鲁竹坝', '1', '0', '1491923034', '2017-04-11 23:03:54'), ('22', '0', '熊家岩', '1', '0', '1491923042', '2017-04-11 23:04:02'), ('23', '0', '洞下槽', '1', '0', '1491923051', '2017-04-11 23:04:11'), ('24', '0', '蓼叶村', '1', '0', '1491923062', '2017-04-11 23:04:22'), ('25', '0', '张家槽', '1', '0', '1491923073', '2017-04-11 23:04:33');
COMMIT;

-- ----------------------------
--  Table structure for `sc_role`
-- ----------------------------
DROP TABLE IF EXISTS `sc_role`;
CREATE TABLE `sc_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色组id',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '角色名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='角色组';

-- ----------------------------
--  Records of `sc_role`
-- ----------------------------
BEGIN;
INSERT INTO `sc_role` VALUES ('1', '系统管理员', '1', '1481350313', '2017-01-08 17:06:24'), ('13', '超级管理员', '1', '1484402362', '2017-01-14 21:59:22');
COMMIT;

-- ----------------------------
--  Table structure for `sc_role_power`
-- ----------------------------
DROP TABLE IF EXISTS `sc_role_power`;
CREATE TABLE `sc_role_power` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关联id',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `power_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权限id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `power_id` (`power_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1376 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='角色与权限管理';

-- ----------------------------
--  Records of `sc_role_power`
-- ----------------------------
BEGIN;
INSERT INTO `sc_role_power` VALUES ('1263', '13', '41', '1491992489'), ('1264', '13', '42', '1491992489'), ('1265', '13', '1', '1491992489'), ('1266', '13', '22', '1491992489'), ('1267', '13', '4', '1491992489'), ('1268', '13', '28', '1491992489'), ('1269', '13', '29', '1491992489'), ('1270', '13', '32', '1491992489'), ('1271', '13', '33', '1491992489'), ('1272', '13', '34', '1491992489'), ('1273', '13', '63', '1491992489'), ('1274', '13', '131', '1491992489'), ('1275', '13', '30', '1491992489'), ('1276', '13', '31', '1491992489'), ('1277', '13', '35', '1491992489'), ('1278', '13', '37', '1491992489'), ('1279', '13', '36', '1491992489'), ('1280', '13', '64', '1491992489'), ('1281', '13', '132', '1491992489'), ('1282', '13', '38', '1491992489'), ('1283', '13', '39', '1491992489'), ('1284', '13', '57', '1491992489'), ('1285', '13', '58', '1491992489'), ('1286', '13', '59', '1491992489'), ('1287', '13', '65', '1491992489'), ('1288', '13', '40', '1491992489'), ('1289', '13', '60', '1491992489'), ('1290', '13', '61', '1491992489'), ('1291', '13', '62', '1491992489'), ('1292', '13', '66', '1491992489'), ('1293', '13', '67', '1491992489'), ('1294', '13', '74', '1491992489'), ('1295', '13', '75', '1491992489'), ('1296', '13', '76', '1491992489'), ('1297', '13', '77', '1491992489'), ('1298', '13', '78', '1491992489'), ('1299', '13', '79', '1491992489'), ('1300', '13', '80', '1491992489'), ('1301', '13', '81', '1491992489'), ('1302', '13', '103', '1491992489'), ('1303', '13', '105', '1491992489'), ('1304', '13', '104', '1491992489'), ('1305', '13', '107', '1491992489'), ('1306', '13', '123', '1491992489'), ('1307', '13', '124', '1491992489'), ('1308', '13', '125', '1491992489'), ('1309', '13', '106', '1491992489'), ('1310', '13', '108', '1491992489'), ('1311', '13', '102', '1491992489'), ('1312', '13', '82', '1491992489'), ('1313', '13', '84', '1491992489'), ('1314', '13', '85', '1491992489'), ('1315', '13', '86', '1491992489'), ('1316', '13', '87', '1491992489'), ('1317', '13', '83', '1491992489'), ('1318', '13', '88', '1491992489'), ('1319', '13', '89', '1491992489'), ('1320', '13', '90', '1491992489'), ('1321', '13', '91', '1491992489'), ('1322', '13', '92', '1491992489'), ('1323', '13', '93', '1491992489'), ('1324', '13', '94', '1491992489'), ('1325', '13', '95', '1491992489'), ('1326', '13', '96', '1491992489'), ('1327', '13', '97', '1491992489'), ('1328', '13', '98', '1491992489'), ('1329', '13', '99', '1491992489'), ('1330', '13', '100', '1491992489'), ('1331', '13', '101', '1491992489'), ('1332', '13', '109', '1491992489'), ('1333', '13', '126', '1491992489'), ('1334', '13', '127', '1491992489'), ('1335', '13', '128', '1491992489'), ('1336', '13', '129', '1491992489'), ('1337', '13', '130', '1491992489'), ('1338', '13', '133', '1491992489'), ('1339', '13', '134', '1491992489'), ('1340', '13', '135', '1491992489'), ('1341', '13', '136', '1491992489'), ('1342', '13', '137', '1491992489'), ('1343', '13', '8', '1491992489'), ('1344', '13', '12', '1491992489'), ('1345', '13', '43', '1491992489'), ('1346', '13', '50', '1491992489'), ('1347', '13', '10', '1491992489'), ('1348', '13', '44', '1491992489'), ('1349', '13', '51', '1491992489'), ('1350', '13', '11', '1491992489'), ('1351', '13', '45', '1491992489'), ('1352', '13', '52', '1491992489'), ('1353', '13', '24', '1491992489'), ('1354', '13', '46', '1491992489'), ('1355', '13', '53', '1491992489'), ('1356', '13', '25', '1491992489'), ('1357', '13', '47', '1491992489'), ('1358', '13', '54', '1491992489'), ('1359', '13', '26', '1491992489'), ('1360', '13', '48', '1491992489'), ('1361', '13', '55', '1491992489'), ('1362', '13', '27', '1491992489'), ('1363', '13', '49', '1491992489'), ('1364', '13', '56', '1491992489'), ('1365', '13', '68', '1491992489'), ('1366', '13', '69', '1491992489'), ('1367', '13', '70', '1491992489'), ('1368', '13', '71', '1491992489'), ('1369', '13', '72', '1491992489'), ('1370', '13', '73', '1491992489'), ('1371', '13', '118', '1491992489'), ('1372', '13', '119', '1491992489'), ('1373', '13', '120', '1491992489'), ('1374', '13', '121', '1491992489'), ('1375', '13', '122', '1491992489');
COMMIT;

-- ----------------------------
--  Table structure for `sc_room`
-- ----------------------------
DROP TABLE IF EXISTS `sc_room`;
CREATE TABLE `sc_room` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `is_enable` (`is_enable`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='教室类别';

-- ----------------------------
--  Records of `sc_room`
-- ----------------------------
BEGIN;
INSERT INTO `sc_room` VALUES ('7', '0', '东区', '1', '0', '0', '2016-12-25 14:41:23'), ('10', '0', '西北区', '1', '0', '0', '2016-12-25 14:42:31'), ('16', '0', '天才班专用教室1号', '1', '0', '1482840545', '2016-12-27 20:09:05'), ('17', '7', '教室一', '1', '0', '1482840557', '2016-12-27 20:09:17'), ('18', '7', '教室二', '1', '0', '1482840577', '2016-12-27 20:09:37'), ('19', '10', '教室一', '1', '0', '1482922284', '2016-12-28 18:51:24'), ('20', '10', '教室二', '1', '0', '1482922305', '2016-12-28 18:51:45'), ('21', '10', '教室三', '1', '0', '1482922320', '2016-12-28 18:52:00'), ('24', '0', 'VIP教室', '1', '0', '1483951541', '2017-01-09 16:45:41');
COMMIT;

-- ----------------------------
--  Table structure for `sc_score`
-- ----------------------------
DROP TABLE IF EXISTS `sc_score`;
CREATE TABLE `sc_score` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='成绩类别';

-- ----------------------------
--  Records of `sc_score`
-- ----------------------------
BEGIN;
INSERT INTO `sc_score` VALUES ('12', '第一期', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '第二期', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '第三期', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '第四期', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '第五期', '1', '0', '1482851855', '2016-12-27 23:17:35');
COMMIT;

-- ----------------------------
--  Table structure for `sc_semester`
-- ----------------------------
DROP TABLE IF EXISTS `sc_semester`;
CREATE TABLE `sc_semester` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='学期类别';

-- ----------------------------
--  Records of `sc_semester`
-- ----------------------------
BEGIN;
INSERT INTO `sc_semester` VALUES ('7', '2016上学期', '1', '255', '0', '2016-12-25 14:41:23'), ('8', '2016下学期', '1', '0', '0', '2016-12-25 14:41:38'), ('18', '测试学期', '1', '0', '1483952728', '2017-01-09 17:05:28');
COMMIT;

-- ----------------------------
--  Table structure for `sc_student`
-- ----------------------------
DROP TABLE IF EXISTS `sc_student`;
CREATE TABLE `sc_student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '学生id',
  `number` char(15) NOT NULL DEFAULT '' COMMENT '学生编号-唯一（年份+8位自增id，不足以0前置补齐）',
  `username` char(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `id_card` char(18) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别（0保密，1女，2男）',
  `birthday` int(11) NOT NULL DEFAULT '0' COMMENT '生日',
  `semester_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '学期id',
  `class_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '班级id',
  `region_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '地区id',
  `address` char(150) NOT NULL DEFAULT '' COMMENT '详细地址',
  `tel` char(15) NOT NULL DEFAULT '' COMMENT '座机号码',
  `my_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码-学生本人',
  `parent_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码-家长',
  `email` char(60) NOT NULL DEFAULT '' COMMENT '电子邮箱（最大长度60个字符）',
  `state` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '学生状态（0待入学, 1在读, 2已毕业, 3弃学, 4已开除）',
  `tuition_state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '学费缴纳状态（0未缴费，1缴费）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_card_semester_id` (`id_card`,`semester_id`),
  UNIQUE KEY `number_id_card_semester_id` (`number`,`id_card`,`semester_id`),
  KEY `class_id` (`class_id`),
  KEY `region_id` (`region_id`),
  KEY `state` (`state`),
  KEY `tuition_state` (`tuition_state`),
  KEY `birthday` (`birthday`),
  KEY `gender` (`gender`),
  KEY `semester_id` (`semester_id`),
  KEY `my_mobile` (`my_mobile`),
  KEY `parent_mobile` (`parent_mobile`),
  KEY `email` (`email`),
  KEY `number` (`number`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='学生';

-- ----------------------------
--  Records of `sc_student`
-- ----------------------------
BEGIN;
INSERT INTO `sc_student` VALUES ('8', '201700000008', '留洋厄尔', '142613199904234622', '2', '917391600', '7', '22', '7', '尔尔', '03667879265', '17091959688', '17602128368', 'fuxiang.gong@qq.com', '0', '0', '1483932878', '1490164767'), ('9', '201700000009', '张三', '533338198988888888', '2', '735948000', '7', '19', '8', '学校附近的888号', '17000000000', '', '17602128368', 'fuxiang.gong@qq.com', '1', '1', '1483936027', '1490239419'), ('10', '201700000010', '武松打虎', '677771999999999992', '2', '633740400', '7', '23', '9', '', '17666666666', '', '17602128368', '', '1', '1', '1483936080', '1490351228'), ('11', '201700000011', '小花', '211118199102111666', '1', '735948000', '7', '19', '11', '住校', '13199999999', '', '17602128368', '386392432@qq.com', '1', '1', '1483936138', '1490350032'), ('12', '201700000012', '大哥哥', '399998198898998887', '2', '839368800', '7', '16', '14', '', '13222222222', '17091959688', '17602128368', 'fuxiang.gong@qq.com', '1', '1', '1483936199', '1490511285'), ('13', '201700000013', '地地道道', '441801198810252656', '2', '1483830000', '8', '18', '9', '111', '15915110562', '', '17602128368', '', '3', '1', '1483948630', '1491641761'), ('14', '201700000014', '测试学生', '522228199111111111', '2', '666547200', '8', '17', '9', '20号', '', '', '17602128368', '386392432@qq.com', '0', '0', '1488426236', '1488449382'), ('19', '201700000014', 'ddddd', '522228199111111111', '0', '1264633200', '7', '17', '8', '1111', '', '', '17602128368', '', '0', '0', '1490179826', '0'), ('20', '201700000013', '地地道道', '441801198810252656', '2', '1299279600', '7', '17', '7', '11', '', '', '17602128368', '', '1', '0', '1490180081', '1490180350'), ('28', '201700000028', 'excel导入', '522228199602111888', '1', '666201600', '7', '18', '14', '44顺丰速递发', '', '', '17000000011', '', '0', '1', '0', '0'), ('29', '201700000029', 'excel导入2', '522228199602111899', '1', '666201600', '7', '18', '14', '44顺丰速递发', '', '', '17000000011', '', '0', '1', '0', '0'), ('30', '201700000030', 'excel导入3', '522228199602111877', '1', '666201600', '7', '18', '14', '44顺丰速递发', '', '', '17000000011', '', '0', '1', '0', '0'), ('31', '201700000031', 'excel导入4', '522228199602111866', '1', '666201600', '7', '18', '14', '44顺丰速递发', '', '', '17000000011', '', '0', '1', '0', '0'), ('32', '201700000032', 'excel导入5', '522228199602111855', '1', '666201600', '7', '18', '14', '大范甘迪哥', '', '', '17000000011', '', '0', '0', '0', '0'), ('33', '201700000033', 'excel导入6', '522228199602111844', '1', '666201600', '7', '18', '14', '大范甘迪哥', '', '', '17000000011', '', '0', '0', '0', '0'), ('34', '201700000034', 'excel导入77', '522228199602111833', '1', '666201600', '7', '18', '14', '大范甘迪哥', '', '', '17000000011', '', '0', '0', '0', '1491551457'), ('35', '201700000035', 'excel导入77', '522228199602110000', '1', '666201600', '7', '18', '14', '大范甘迪哥', '', '', '17000000011', '', '0', '0', '0', '0'), ('36', '201700000036', 'excel导入10', '522228199602111831', '1', '666201600', '7', '18', '14', '大范甘迪哥', '', '', '17000000011', '', '0', '0', '0', '0'), ('37', '201700000037', 'excel导入11', '522228199602111830', '1', '666201600', '7', '18', '14', 'fff放飞关', '', '', '17000000011', '', '0', '0', '0', '0'), ('38', '201700000038', '导入测试数据1', '522228199102111555', '2', '667152000', '7', '20', '9', '东方时代浮点数', '021-22222222', '17602128368', '17091959688', 'fuxiang.gong@qq.com', '0', '1', '0', '0'), ('39', '201700000039', '导入测试数据2', '522228199102111551', '1', '667152000', '7', '20', '9', '东方时代浮点数', '021-22222222', '17602128368', '17091959688', 'fuxiang.gong@qq.com', '1', '1', '0', '0'), ('40', '201700000040', '留洋厄尔', '142613199904234622', '2', '917366400', '8', '22', '7', '尔尔', '03667879265', '17091959688', '17602128368', 'fuxiang.gong@qq.com', '0', '0', '1483932878', '0'), ('41', '201700000041', '张三', '533338198988888888', '2', '735926400', '8', '19', '8', '学校附近的888号', '17000000000', '', '17602128368', 'fuxiang.gong@qq.com', '1', '1', '1483936027', '0'), ('42', '201700000042', '武松打虎', '677771999999999992', '2', '633715200', '8', '23', '9', '', '17666666666', '', '17602128368', '', '1', '1', '1483936080', '0'), ('43', '201700000043', '小花', '211118199102111666', '1', '735926400', '8', '19', '11', '住校', '13199999999', '', '17602128368', '386392432@qq.com', '1', '1', '1483936138', '0'), ('44', '201700000044', '大哥哥', '399998198898998887', '2', '839347200', '8', '16', '14', '', '13222222222', '17091959688', '17602128368', 'fuxiang.gong@qq.com', '1', '1', '1483936199', '0'), ('45', '201700000045', 'excel导入', '522228199602111888', '1', '666201600', '8', '18', '14', '44顺丰速递发', '', '', '17000000011', '', '0', '1', '0', '0'), ('46', '201700000046', 'excel导入2', '522228199602111899', '1', '666201600', '8', '18', '14', '44顺丰速递发', '', '', '17000000011', '', '0', '1', '0', '0'), ('47', '201700000047', 'excel导入3', '522228199602111877', '1', '666201600', '8', '18', '14', '44顺丰速递发', '', '', '17000000011', '', '0', '1', '0', '0'), ('48', '201700000048', 'excel导入4', '522228199602111866', '1', '666201600', '8', '18', '14', '44顺丰速递发', '', '', '17000000011', '', '0', '1', '0', '0'), ('49', '201700000049', 'excel导入5', '522228199602111855', '1', '666201600', '8', '18', '14', '大范甘迪哥', '', '', '17000000011', '', '0', '0', '0', '0'), ('50', '201700000050', 'excel导入6', '522228199602111844', '1', '666201600', '8', '18', '14', '大范甘迪哥', '', '', '17000000011', '', '0', '0', '0', '0'), ('51', '201700000051', 'excel导入77', '522228199602111833', '1', '666201600', '8', '18', '14', '大范甘迪哥', '', '', '17000000011', '', '0', '0', '0', '0'), ('52', '201700000052', 'excel导入77', '522228199602110000', '1', '666201600', '8', '18', '14', '大范甘迪哥', '', '', '17000000011', '', '0', '0', '0', '0'), ('53', '201700000053', 'excel导入10', '522228199602111831', '1', '666201600', '8', '18', '14', '大范甘迪哥', '', '', '17000000011', '', '0', '0', '0', '0'), ('54', '201700000054', 'excel导入11', '522228199602111830', '1', '666201600', '8', '18', '14', 'fff放飞关', '', '', '17000000011', '', '0', '0', '0', '0'), ('55', '201700000055', '导入测试数据1', '522228199102111555', '2', '667152000', '8', '20', '9', '东方时代浮点数', '021-22222222', '17602128368', '17091959688', 'fuxiang.gong@qq.com', '0', '1', '0', '0'), ('56', '201700000056', '导入测试数据2', '522228199102111551', '1', '667152000', '8', '20', '9', '东方时代浮点数', '021-22222222', '17602128368', '17091959688', 'fuxiang.gong@qq.com', '1', '1', '0', '0'), ('57', '201700000057', '导入测试数据2', '522228199102111999', '2', '667152000', '7', '20', '9', 'sfSD发生的发收到', '021-22222222', '17602128368', '17091959688', 'fuxiang.gong@qq.com', '1', '1', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `sc_subject`
-- ----------------------------
DROP TABLE IF EXISTS `sc_subject`;
CREATE TABLE `sc_subject` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='科目类别';

-- ----------------------------
--  Records of `sc_subject`
-- ----------------------------
BEGIN;
INSERT INTO `sc_subject` VALUES ('17', '政治', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '化学', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '地理', '1', '0', '1482851855', '2016-12-27 23:17:35');
COMMIT;

-- ----------------------------
--  Table structure for `sc_teacher`
-- ----------------------------
DROP TABLE IF EXISTS `sc_teacher`;
CREATE TABLE `sc_teacher` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '学生id',
  `username` char(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `id_card` char(18) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别（0保密，1女，2男）',
  `birthday` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生日',
  `address` char(150) NOT NULL DEFAULT '' COMMENT '详细地址',
  `tel` char(15) NOT NULL DEFAULT '' COMMENT '联系方式（手机或座机）',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` char(60) NOT NULL DEFAULT '' COMMENT '电子邮箱（最大长度60个字符）',
  `state` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '教师状态（0待报道, 1在职, 2已离职, 3已退休, 4已开除）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_card` (`id_card`),
  KEY `state` (`state`),
  KEY `birthday` (`birthday`),
  KEY `gender` (`gender`),
  KEY `tel` (`tel`),
  KEY `mobile` (`mobile`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='教师';

-- ----------------------------
--  Records of `sc_teacher`
-- ----------------------------
BEGIN;
INSERT INTO `sc_teacher` VALUES ('1', '张老师', '222228198888888888', '0', '318182400', '', '021-22222222', '17602128368', 'fuxiang.gong@qq.com', '0', '1483936487', '1489128497'), ('2', '刘老师', '822228198999999999', '2', '2390400', '哈哈呵呵', '021-33333333', '13162155626', '', '1', '1483957038', '1488449060'), ('3', 'hello', '522228198888888888', '2', '1367424000', '梵蒂冈', '17602128368', '', '', '2', '1484211799', '0'), ('4', '的方法', '522229199999999933', '2', '1367424000', '电饭锅sdfsfsdfdfs', '021-33333333', '', '', '1', '1484211920', '0');
COMMIT;

-- ----------------------------
--  Table structure for `sc_teacher_subject`
-- ----------------------------
DROP TABLE IF EXISTS `sc_teacher_subject`;
CREATE TABLE `sc_teacher_subject` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关联id',
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教师id',
  `subject_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '科目id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `teacher_subject` (`teacher_id`,`subject_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='教师科目关联';

-- ----------------------------
--  Records of `sc_teacher_subject`
-- ----------------------------
BEGIN;
INSERT INTO `sc_teacher_subject` VALUES ('14', '4', '17', '1484212426'), ('15', '4', '20', '1484212426'), ('16', '3', '19', '1484212442'), ('17', '3', '20', '1484212442'), ('45', '2', '20', '1488449060'), ('51', '1', '19', '1489128497');
COMMIT;

-- ----------------------------
--  Table structure for `sc_user`
-- ----------------------------
DROP TABLE IF EXISTS `sc_user`;
CREATE TABLE `sc_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` char(50) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `pwd` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '配合密码加密的随机数',
  `nickname` char(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别（0保密，1女，2男）',
  `birthday` int(11) NOT NULL DEFAULT '0' COMMENT '生日',
  `signature` char(168) NOT NULL DEFAULT '' COMMENT '个人签名（最大字数168）',
  `describe` char(255) NOT NULL DEFAULT '' COMMENT '个人描述（最大字数255）',
  `state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户状态',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `mobile` (`mobile`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
--  Records of `sc_user`
-- ----------------------------
BEGIN;
INSERT INTO `sc_user` VALUES ('12', '17602128368', 'gfx@gongfuxiang.com', '2e5a15ef6dce8cadb0999a34b0191e97', '161176', 'gongfuxiang', '2', '702684000', '测试删除说说', '', '0', '1489117020', '1494325853'), ('13', '17091959688', 'fuxiang.gong@qq.com', '3b270aeb48531e52c9b5fa28dd8f3339', '778722', '魔鬼', '2', '666201600', 'hello', '喜欢睡觉觉', '0', '1489141439', '1492101203'), ('15', '13162155626', '', '8412e2af117e9cfd3d102cedade8c58d', '327579', '测试用户', '0', '0', '测试看看哈', '', '1', '1490867166', '1491982342');
COMMIT;

-- ----------------------------
--  Table structure for `sc_user_student`
-- ----------------------------
DROP TABLE IF EXISTS `sc_user_student`;
CREATE TABLE `sc_user_student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `student_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '学生id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_student` (`user_id`,`student_id`),
  KEY `user_id` (`user_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='用户关联学生';

-- ----------------------------
--  Records of `sc_user_student`
-- ----------------------------
BEGIN;
INSERT INTO `sc_user_student` VALUES ('1', '13', '8', '1490176253'), ('2', '13', '14', '1490177248'), ('4', '13', '9', '1490239994'), ('5', '13', '13', '1490240196'), ('6', '13', '11', '1490350607'), ('7', '13', '10', '1490351197'), ('8', '13', '12', '1490511525');
COMMIT;

-- ----------------------------
--  Table structure for `sc_week`
-- ----------------------------
DROP TABLE IF EXISTS `sc_week`;
CREATE TABLE `sc_week` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` char(30) NOT NULL COMMENT '名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用（0否，1是）',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='周天类别';

-- ----------------------------
--  Records of `sc_week`
-- ----------------------------
BEGIN;
INSERT INTO `sc_week` VALUES ('12', '星期一', '1', '0', '0', '2016-12-25 14:43:30'), ('14', '星期二', '1', '0', '0', '2016-12-25 17:19:00'), ('17', '星期三', '1', '0', '1482840012', '2016-12-27 20:00:12'), ('19', '星期四', '1', '0', '1482851842', '2016-12-27 23:17:22'), ('20', '星期五', '1', '0', '1482851855', '2016-12-27 23:17:35'), ('21', '星期六', '1', '0', '1482852585', '2016-12-27 23:29:45'), ('22', '星期日', '1', '0', '1482852593', '2016-12-27 23:29:53');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
