# Alpaca-Spa-Laravel

## 简介

### Alpaca-Spa-Laravel 简介

&emsp;&emsp;Alpaca-Spa-Laravel 是用Alpaca-Spa + Laravel 前后端分离开发的一款后台管理系统的DEMO. 主要功能模块有登录、定时任务管理、用户管理、权限管理、个人信息管理等。在实际开发中可以根据具体的需求添加新的功能。
开发模式为前后分离开发，Alpaca-Spa负责实现前端功能，包括组织页面结构，渲染页面数据、样式，交互逻辑等，Laravel负责提供后台功能，访问数据库，处理业务逻辑，提供数据接口给前端，

### 演示地址

Alpaca-Spa-Laravel :   http://full.tkc8.com

Alpaca-Spa :   http://www.tkc8.com

登录账号是一个测试帐号，权限只有浏览功能，没有编辑等修改功能。

## 目录结构

```
-app
　 -Common
　 -Console
　 -Models
　 -Modules
　  ExceptionHandler.php
　  RouteProvider.php
-bootstrap
-builder
-config
-crontab
-public
　 -admin
   index.php
-storage
-vendor
.env.development
composer.json
composer.lock

```

```
1.app/Common用来放置一些公共的类、函数等

2.app/Models用来放置与数据库对应的实体类文件

3.app/Modules存放模块相关信息，里面包含控制器，业务逻辑等，

             本示例中只有一个Manage模块，用来实现后台管理的相关功能

4.config存放配置文件

5.builder 中是一个自动生成代码的工具，这里先不做详细介绍

6.bootstrap 是Laravel框架本身自带的一个目录，主要功能是提供应用初始化的一些相关功能

7.storage 中存放应用运行时候的文件，例如log，cache等

8.vendor 中存放通过composer加载的相关插件

9.public 入口目录，配置服务器时，应该将网站根目录设置为public

10.public\index,php 后台服务Laravel框架的入口文件

11.public\admin 后台服务Laravel框架的入口文件

```
### 路由功能

```
1 app/RouteProvider.php中可以配置整个系统的路由组织结构

2 app/Modules/Manage/Route.php配置Manage模块的相关路由，推荐每一个模块拥有自己的一个路由配置文件

```

### 配置文件

```
1 配置文件存放在config目录中

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

      protected function withoutLoginActions()
      {
          // 以下Action不需要登录权限
          return ['action1','action2'];
      }
      这样 action1 与 action2 就不需要登录也可以访问

  2)如果当前控制器下的所有动作都不需要登录权限：

      protected function withoutLoginActions()
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

      protected function withoutAuthActions()
      {
          this->isNoAuth =true;
      }
     这样当前控制器下的所有动作都不需要登录权限就可以直接访问

  3)重写当前控制器下某一个动作的角色权限

      protected function withoutAuthActions()
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
    框架提供了php处理定时任务的方法，具体可以参见演示地址

```

### 前端功能

```
    public\admin中存放前端代码，

    public\admin\index.html是前端入口文件，

    public\admin\main\controller存放前端main模块的控制器，

    public\admin\main\view存放前端main模块的视图页面，

```




作者： Sponge
邮箱： 1796512918@qq.com

