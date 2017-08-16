# Alpaca-Spa-Laravel

## 简介

### Alpaca-Spa-Laravel 简介

Alpaca-Spa-Laravel 是 **前后端分离** 开发的一个后台管理系统的DEMO。**Laravel**用来实现后端功能，**Alpaca-Spa**用来实现前端功能，前后端之间通过Json交换数据。
示例中主要功能有:

登录、注销
用户管理
权限管理
个人信息管理
定时任务管理

![图片名称](http://www.tkc8.com/images/sucai/img_show_1.png)

### 演示地址


| 内容 | 说明 |地址 |
| -------- | -------- |-------- |
|Alpaca-Spa | 主页 | http://www.tkc8.com |
|Alpaca-Spa-Laravel | 后台管理端  | http://full.tkc8.com  |
|Alpaca-Spa-Sui | 手机端sui  |http://full.tkc8.com/app  |

后台管理端登录账号是一个测试帐号，权限只有浏览功能，没有编辑等修改功能。


### 安装方式 （一定要注意storage、bootstrap目录及其子目录、文件的权限）


```
    下载好源码之后，你需要配置你的 Web 服务器的根目录为 public 目录。
    这个目录的  index.php 文件作为所有 HTTP 请求进入应用的前端处理器。

    你需要配置一些权限。
    storage 和 bootstrap 目录应该允许你的 Web 服务器写入，否则 Laravel 将无法写入。
```

### 目录结构

```
|--app
|　 --Common                  -- 用来放置一些公共的类、函数等
|　 --Models                  -- 用来放置与数据库对应的实体类文件
|　 --Modules                 -- 存放模块相关信息，里面包含控制器，业务逻辑等，
|     |--Manage               -- 后台管理模块儿后端（服务端）代码，前后分离开发，这里只返回Json格式的接口
|     |--Server               -- 用户前台模块儿后端（服务端）代码，同上，只返回Json格式的接口
|　 ExceptionHandler.php      -- 异常处理配置
|　 RouteProvider.php         -- 路由配置
|--bootstrap                  -- 是Laravel框架本身自带的一个目录，主要功能是提供应用初始化的一些相关功能，需要读写权限（含子目录）
|　 --Console                 -- Laravel Cli
|   --builder                 -- 代码自动生成工具
|   --crontab                 -- 定时任务工具（非linux shell）
|--config                     -- 配置文件目录
|   .env                      -- 将原来Laravel在外层的.env也挪到了config目录下面
|--public                     -- 入口目录，配置服务器时，应该将网站根目录设置为public
|　 --admin                   -- 后台管理模块儿的前端（客户端）部分（这里是前后分离开发，这里不含有任何php代码，也可以独立部署）
|   --app                     -- 用户前台模块儿的前端（客户端）部分（这里是前后分离开发，同上）
|   index.php                 -- php入口文件
|--storage                    -- 存放程序运行时的log、cache、session等文件，需要读写权限（含子目录）
|--vendor                     -- composer相关目录
|composer.json
|composer.lock

```


### 路由功能

推荐每一个模块拥有自己的一个路由配置文件

```
1 app/RouteProvider.php中可以配置整个系统的路由组织结构
2 app/Modules/Manage/router.php配置Manage模块的相关路由
3 app/Modules/Server/router.php配置Server模块的相关路由
4 bootstrap/builder/router.php配置代码生成工具的路由
5 bootstrap/crontab/router.php配置定时任务工具的路由
```

### 配置文件

```
1 配置文件存放在config目录中，与原Laravel的规则一样

2 处理与系统环境相关的配置。

  如果设置了环境变量MOD_ENV = DEVELOPMENT，系统会加载.env.development配置文件
  如果设置了环境变量MOD_ENV = PRODUCTION，系统会加载.env.production配置文件
  如果设置了环境变量MOD_ENV = TEST，系统会加载.env.test配置文件
  否则会默认加载.envt配置文件
```

### 权限控制

```
1 实现权限功能，需要在数据库中存在5张表：

  用户表、角色表、权限表、用户角色关系表、角色权限关系表。

  这样建立用户-角色-权限的对应关系。

2 登录权限控制

  1)如果当前控制器下的某一个动作不需要登录权限：

      protected function noLogin()
      {
          // 以下Action不需要登录权限
          return ['action1','action2'];
      }
      这样 action1 与 action2 就不需要登录也可以访问

  2)如果当前控制器下的所有动作都不需要登录权限：

      protected function noLogin()
      {
          this->isNoLogin =true;
      }
     这样当前控制器下的所有动作都不需要登录权限就可以直接访问

3 角色权限控制

  1)如果当前控制器下的某一个动作不需要角色权限控制：

      protected function withoutAuthActions()
      {
          // 以下Action不需要登录权限
          return ['action1','action2'];
      }
     这样 action1 与 action2 不需要角色权限也可以访问

  2)如果当前控制器下的所有动作都不需要登录权限：

      protected function noAuth()
      {
          this->isNoAuth =true;
      }
     这样当前控制器下的所有动作都不需要登录权限就可以直接访问

  3)重写当前控制器下某一个动作的角色权限

      protected function noAuth()
      {
          return [
                'actionName'=>function($result){
                     if($_GET['id'] == 1){
                        return true;
                     }
                 },
          ];
      }

     可以通过为action指定一个函数来自定义动作的角色权限控制功能，

     函数有一个参数$result，

     如果$result为true表示系统默认的角色权限控制判断当前动作有权限访问，false为没有权限访问，

```

### 定时任务功能

```

    示例中提供了PHP实现定时任务（非linux-shell方式，与操作系统无关）功能。

    适用于定时精确时间不低于1秒。web服务重启、或者php重启。该定时任务不会自动重启。
    可以用来处理大部分定时任务的结局方案，商城定时自动收货，关闭评论，订单回滚；定时发送邮件，数据备份等

    实现原理及更详细的内容请参考下面这篇文章：
    https://my.oschina.net/u/3381391/blog/1510260
```
![图片名称](http://www.tkc8.com/images/sucai/dsrw.png)

### 前端功能

```
    public\admin中存放前端代码，
    public\admin\index.html是前端入口文件，
    public\admin\main\controller存放前端main模块的控制器，
    public\admin\main\view存放前端main模块的视图页面，
```


### 自动生成代码


项目中提供了生成代码的工具：Alpaca-Builder

目的用来快速的编写代码，减少一些重复的工作，主要功能是根据输入的数据库表名声生成一下内容：

```
1 生成后端实体类
2 生成后端控制器
3 生成后端路由
4 生成前端JS控制器
5 生成前端编辑页面
6 生成前端列表页面
7 生成配置接口url
8 选择是否复制到对应页面
```
![图片名称](http://www.tkc8.com/images/sucai/img_show_2.png)

访问方式，浏览器中输入地址：你的域名\builder

（注意： 只有当配置文件中APP_ENV=local时，才容许访问）



### 开发流程

```
    后端（服务端）部分：

    1 建立数据表
    2 编写模型类，放在/app/Models
    3 编写控制器类，放在模块的Controllers目录下面，例如: /app/Modules/Manage/Controllers/{name}Controller.php
    4 *（可选）如果有比较复杂的业务逻辑需要处理，可以加一个Service层，放在模块的Service目录下面
    5 路由配置：路由一般放在当前模块目录下面，例如：/app/Modules/Manage/router.php

    前端（客户端）部分：

    项目采用前后分离开发，因此前端代码会更独立，html文件中不含有任何php代码
    1 编写列表显示页面（两个html）
       /public/admin/view/{name}/{name}ListView.html       页面主体
       /public/admin/view/{name}/{name}ListDisplay.html    页面table部分
    2 编写编辑页面（新增和修改用一个）
       /public/admin/view/{name}/{name}EditView.html
    3 编写前端控制器，实现与后端数据交互， ：
       路径：/public/admin/controller/{name}.js
       一般有三个方法：
       {name}ListView方法，        显示列表页面，调用后台数据接口查找列表数据
       {name}ListDisplay方法，     渲染显示数据
       {name}EditView方法          显示编辑页面，调用后台接口
    4 配置菜单：
        路径：/public/admin/view/layout/part/pageSidebar.html
    5 配置后端接口，建议是把后端地址写在配置文件里面：
        路径：/public/admin/main/main.js 中的API变量
```

##  交流方式

### 联系我们

QQ群： 298420174

![图片名称](http://www.tkc8.com/index_files/Image%20[10].png)

作者： Sponge
邮箱： 1796512918@qq.com

