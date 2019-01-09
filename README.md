# SchoolCMS
* SchoolCMS学校管理系统，中国首个开源『学校教务管理系统』建站更快速！
* 官方地址：http://schoolcms.org/

### 源代码平台
* Github：https://github.com/gongfuxiang/schoolcms
* 码云/开源中国：https://gitee.com/gongfuxiang/schoolcms

### 传送门
* 演示地址 http://schoolcms.gong.gg/demo/  （演示账号进入官方获取）

### 展示图片
![图片展示](https://images.gitee.com/uploads/images/2019/0109/173609_c33550ee_488475.gif "1547026351739.gif")


# 功能简介
&nbsp;&nbsp;&nbsp;后台<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;权限控制，支持多个管理员，学生管理，学生成绩，教师管理，文章管理，站点管理，网站布局自动化，多导航模式，友情链接，站点工具。
<br /><br />
&nbsp;&nbsp;&nbsp;前台<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;丰富的HTML5组建，电脑+手机自适应。在线注册（支持短信、邮箱），在线报名，在线考试，文章阅读。
<br /><br />
&nbsp;&nbsp;&nbsp;扩展性<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;支持多语言，独立模块式开发，完善的注释，易扩展。
<br /><br />
&nbsp;&nbsp;&nbsp;安全性<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;防止sql注入，代码高安全性。
<br /><br />
&nbsp;&nbsp;&nbsp;轻量级，高性能<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;支持多数据库，读写分离，高并发，内置缓存机制。

# 项目结构
```
schoolcms
├─core.php        入口公共文件
├─index.php       前台入口文件
├─admin.php       后台入口文件
├─README.md       README文件
├─robots.txt      爬虫规则定义文件
├─composer.json   Composer定义文件
├─changelog.txt   更新日志
├─Application     应用目录
│  ├─Admin        后台目录
│  │  ├─Common       应用函数目录
│  │  ├─Conf         应用配置目录
│  │  ├─Lang         应用语言包目录
│  │  ├─Controller   应用控制器目录
│  │  ├─Model        应用模型目录
│  │  └─View         应用视图目录
│  │     └─Default       默认模板目录
│  ├─Home         前台目录
│  │  ├─Common       应用函数目录
│  │  ├─Conf         应用配置目录
│  │  ├─Lang         应用语言包目录
│  │  ├─Controller   应用控制器目录
│  │  ├─Model        应用模型目录
│  │  └─View         应用视图目录
│  │     └─Default       默认模板目录
│  ├─Common       公共函数配置目录
│  │  ├─Common       公共方法目录
│  │  └─Conf         公共配置目录
│  └─Runtime      临时文件目录
├─Public          资源文件目录
│  ├─Admin        后台静态资源目录
│  │  └─Default       默认模板目录
│  ├─Home         前台静态资源目录
│  │  └─Default       默认模板目录
│  ├─Common       公共静态资源目录
│  └─Upload       用户上传附件资源目录
├─Install         安装引导目录
└─ThinkPHP        框架目录
```

# 后台基于ThinkPHP
ThinkPHP是一个快速、简单的基于MVC和面向对象的轻量级PHP开发框架，遵循Apache2开源协议发布，从诞生以来一直秉承简洁实用的设计原则，在保持出色的性能和至简的代码的同时，尤其注重开发体验和易用性，并且拥有众多的原创功能和特性，为WEB应用开发提供了强有力的支持。

# 前台基于AmazeUI
&nbsp;&nbsp;&nbsp;组件丰富，模块化<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;以移动优先（Mobile first）为理念，从小屏逐步扩展到大屏，最终实现所有屏幕适配，适应移动互联潮流。
<br /><br />
&nbsp;&nbsp;&nbsp;本地化支持<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;相比国外框架，Amaze UI 关注中文排版，根据用户代理调整字体，实现更好的中文排版效果；兼顾国内主流浏览器及 App 内置浏览器兼容支持。
<br /><br />
&nbsp;&nbsp;&nbsp;轻量级，高性能<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Amaze UI 面向 HTML5 开发，使用 CSS3 来做动画交互，平滑、高效，更适合移动设备，让 Web 应用更快速载入。

# 版权信息
SchoolMS遵循Apache2开源协议发布，并提供免费使用。<br />
本项目包含的第三方源码和二进制文件之版权信息另行标注。<br />
版权所有Copyright © 2011-2017 by SchoolMS (http://schoolcms.org)<br />
All rights reserved。<br />

# 更新日志
更多细节参阅 <a href="changelog.txt">changelog.txt</a>