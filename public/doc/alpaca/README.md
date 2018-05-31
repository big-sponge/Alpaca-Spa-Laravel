# Alpaca-Spa-2.0 使用帮助

## 简介

### Alpaca-spa-2.0.js 简介

&emsp;&emsp;Alpaca-spa.js是一款轻量的前端JS框架，提供前端**路由**功能，前端**视图渲染**功能，前端**套页面**功能。目的是用来提高web项目的开发效率，前后端分离开发，同时使前端代码结构更加整洁。

&emsp;&emsp;Alpaca-spa.js 区别于其他框架的主要特点是轻巧灵活，**学习成本低**。框架没有复杂的概念与特性，几乎都是最基本的JavaScript语法，也就是说读者只要有JavaScript语言基础，就能很快学会使用 Alpaca-spa.js框架。

### 演示地址

Alpaca-Spa-Laravel :   http://full.tkc8.com

Alpaca-Spa :   http://www.tkc8.com

登录账号是一个测试帐号，权限只有浏览功能，没有编辑等修改功能。

## 入门示例

### 1. 引用Alpaca-spa-2.0.js
    Alpaca-spa-2.0.js 目前依赖于  jquery.js。使用Alpaca-spa-2.0.js 需要引用

```
1). jquery.js
    下载地址（或者直接在代码中引用）：http://spa.tkc8.com/common/js/jquery-2.1.4.min.js
2). Alpaca-spa-2.0.js&emsp;
    下载地址（或者直接在代码中引用）：http://spa.tkc8.com/common/js/alpaca-spa-2.0.js
```

### 2. 示例： Hello Alpaca

新建文件hello.html。在文件中编辑以下内容代码，用浏览器打开观察结果。

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        $().ready(function () {
            Alpaca.Tpl({data:{text:'Alpaca'},place:'body'});
        });
    </script>

</head>
<body>
hello {{=it.text}} !
</body>
</html>

```
结果如下
```
hello Alpaca !
```

&emsp;&emsp;示例中的Alpaca.Tpl( )方法，传递了一个对象作为参数，对像中有两个属性，data表示要传递的数据（对象格式），place表示要渲染的位置。

&emsp;&emsp;通过上面的示例可以发现 页面body元素中的 {{=it.text}}被替换成为了 参数data中的text字段，也就是“Alpaca”，从而达到了渲染数据的效果。

&emsp;&emsp;**注**， 模板中的 it 是固定关键字，代表传递过来的数据对象。关于Alpaca.Tpl( )方法的详细用法，后续章节会做详细介绍。


### 3. 示例：使用路由


新建文件router.html。在文件中编辑以下内容代码，用浏览器打开观察结果。

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        $().ready(function () {
            Alpaca.run();
        });
    </script>

</head>
<body>
</body>
</html>

```
结果如下，表示Alpaca路由运行成功
```
Welcome use Alpaca-spa 2.0 !
```


新建文件router-index.html。在文件中编辑以下内容代码。

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        //定义index模块
        Alpaca.IndexModule = {};
        //定义index控制器
        Alpaca.IndexModule.IndexController={
            //定义index动作
            indexAction:function(){
                alert('Hello Router');
            },
            //定义index动作
            index2Action:function(){
                Alpaca.Tpl({data:{text:'Hello'},place:'body'});
            },
        };
    </script>

    <script>
        $().ready(function () {
            Alpaca.run();
        });
    </script>

</head>
<body>
{{=it.text }} Alpaca.
</body>
</html>

```
在浏览器中输入http://127.0.0.1/examples/router-index.html#/index/index/index

结果弹出提示框：
```
Hello Router
```

在浏览器中输入http://127.0.0.1/examples/router-index.html#/index/index/index2

页面中显示：
```
Hello Alpaca.
```

通过上面两个例子，可以发现，Url中 :

\#/index/index/index 映射到 Alpaca.IndexModule.IndexController.indexAction()方法

\#/index/index/index2 映射到 Alpaca.IndexModule.IndexController.index2Action()方法

这就是Alpace路由的用途，将Url中hash部分映射到一个js方法。

关于路由的详细用法以及Alpaca.run()方法，后面章节会详细介绍。

##  模板语法

### 1. 语法

&emsp;&emsp;模板语法的作用是将JavaScript中的数据变量渲染到页面中。

&emsp;&emsp;Alpaca-spa.js 引用dot.js作为模板引擎，并且支持两种模板语法格式，分别是 alpaca 格式， dot.js 默认格式。常用的语法格式如下所示：


* Alpaca 格式 :

  + \<?spa ?\>在标签内可以使用任意的JS语法
  + \<?spa echo xxx ?\>                       输出变量
  + \<?spa if(){ ?\>xxx<?spa } ?\>   条件判断
  + \<?spa for(){ ?>xxx<?spa } ?\> for循环
  + \<?spa foreach(xxx as key => val) ?\> xxx \<?spa endForeach ?\>   foreach循环
* dot.js 格式 ：
  + {{ }}                                           在标签内可以使用JS表达式和dot.js语法
  + {{=value }}                               当前位置输出变量的值
  + {{ if(){ }} xxx {{ } }}       条件判断
  + {{ for(){ }} xxx {{ } }}     for循环


&emsp;&emsp;学习使用Alpaca-spa.js模板引擎 ，开发人员只需要掌握三种基本的语法格式即可： 输出变量，循环， 条件判断。

**提示：** 在标签\<?spa ?\> 或者{{ }}中，可以使用任意的JavaScript语法。

下面介绍如何使用这三种语法格式.

### 2. 输出变量

语法：

+ \<?spa echo it.xxx ?\>
+ {{=it.xxx}}

用途：在渲染页面时，将一个变量显示在页面上

参考如下示例：

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        $(function(){
            var data = {name : "Cheng",age : 26};
            Alpaca.Tpl({data:data ,from:"#template", to:"#content"});
        });
    </script>

    <script id='template' type="text">
        <div>Name:<?spa echo it.name ?>!</div>
        <div>Age:<?spa echo it.age ?>!</div>
    </script>

</head>
<body>
    <div id="content"></div>
</body>
</html>

```
示例中的Alpaca.Tpl( )方法，传递了一个对象作为参数，对像中有三个属性，data表示要传递的数据（对象格式），from表示模板元素，to表示要渲染的位置。在浏览器中运行这个页面，结果如下：

```
Name:Cheng!
Age:26!
```

### 3. 循环

语法：

+ \<?spa foreach() ?\>xxx\<?spa endForeach ?\>
+ {{ for(){ }}xxx{{ } }}

用途：在遍历数组或者对象时候使用

参考如下示例：

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        $(function(){
            var data = {
                result:[
                    {type:'支付宝',amount:'125',time:'2016-11-12'},
                    {type:'微信',amount:'130',time:'2016-10-12'}
                    ]
                };
            Alpaca.Tpl({data:data ,from:"#template", to:"#content"});
        });
    </script>
    <script id='template' type="text">
        <?spa foreach(it.result as key => value) ?>
            <div>
                <?spa echo key ?>:
                <div>支付方式：<?spa echo value['type'] ?></div>
                <div>支付金额：<?spa echo value['amount'] ?></div>
                <div>支付时间：<?spa echo value['time'] ?></div>
            </div>
        <?spa endForeach ?>
    </script>
</head>
<body>
    <div id="content"></div>
</body>
</html>

```
结果如下：

```
0:
支付方式：支付宝
支付金额：125
支付时间：2016-11-12
1:
支付方式：微信
支付金额：130
支付时间：2016-10-12
```

### 4. 条件判断

语法：

+ \<?spa if(condition){ ?\>xxx\<?spa } ?\>
+ {{ if(condition){ }}xxx{{ } }}


用途：在需要做条件判断的分支环境中使用

参考如下示例：

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        $(function(){
            var data = {check:true,};
            Alpaca.Tpl({data:data ,from:"#template", to:"#content"});
        });
    </script>
    <script id='template' type="text">
        <?spa if(it.check){ ?>
            <font>条件为true的情况</font>
        <?spa }else{ ?>
            <a>条件为false的情况</a>
        <?spa } ?>
    </script>
</head>
<body>
<div id="content"></div>
</body>
</html>

```
输出结果：
```
条件为true的情况
```


### 5. Alpaca.Tpl()方法
Alpaca.Tpl(option) 是一个用来渲染页面的方法，接受一个对象参数option，参数option中可以包含以下字段：

+ option.data

&emsp;&emsp;数据对象，为渲染模板提供数据

&emsp;&emsp;Alpaca.Tpl({data:{name:'Alpaca-spa'}})

+ option.from

&emsp;&emsp;模板位置，可以是任意的页面元素，选择方法与Jquery的选择器相同

&emsp;&emsp;Alpaca.Tpl({from:'#template',to:'#div',data:{name:'Alpaca-spa'}})

* option.to

&emsp;&emsp;被渲染位置

&emsp;&emsp;Alpaca.Tpl({from:'#template',to:'#div',data:{name:'Alpaca-spa'}})

+ option.place

&emsp;&emsp;指定模板渲染的位置。当place被指定时，模板位置与被渲染位置相同

&emsp;&emsp;Alpaca.Tpl({place:'body',data:{name:"zp"}})

+ option.template

&emsp;&emsp;指定渲染的模板文件。当template被指定时，模板从当前页面元素变为指定的html文件

&emsp;&emsp;Alpaca.Tpl({to:'body',template:'layer.html',data:{name:"zp"}})

&emsp;&emsp;**注：** 使用另一个页面作为模板，需要配置web服务器，在后面章节【视图高级用法】中会做详细介绍

示例

**使用参数：data from to：**

```
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>alpaca-spa.2.0</title>
        <script src="jquery-2.1.4.min.js"></script>
        <script src="alpaca-spa-2.0.js"></script>
        <script>
            $(function(){
                Alpaca.Tpl({from:'#template',to:'#content',data:{name:"Alpaca-spa"}});
            });
        </script>
        <script id='template' type="text">
            <font>Welcome to {{=it.name}}!</font>
        </script>
    </head>
    <body>
        <div id="content"></div>
    </body>
</html>
```

输出结果：

```Welcome to Alpaca-spa!```

**使用参数：place：**

```
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>alpaca-spa.2.0</title>
        <script src="jquery-2.1.4.min.js"></script>
        <script src="alpaca-spa-2.0.js"></script>
        <script>
            $(function(){
                Alpaca.Tpl({place:'body',data:{name:"Alpaca-spa"}});
            });
        </script>
    </head>
    <body>
        Hello {{=it.name}}!
    </body>
</html>
```
输出结果：
```
This is Alpaca-spa!
template：
```

**使用参数：template：**

创建两个html页面：template.html，test-template.html

**注：** 使用template参数指定另一个页面为模板时，需要配置web服务器，确保template路径正确，详情请参考后面章节【视图高级用法】。

template.html 文件用来做模板，内容如下：

```
<h1>This is {{=it.name}}.</h1>
```

test-template.html 文件是用来测试该示例的页面，内容如下：

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        $().ready(function () {
            var data = {name:"Alpaca-spa"};
            Alpaca.Tpl({template:'/examples/template.html',to:'body',data:data});
        });
    </script>
</head>
<body>
</body>
</html>

```

在浏览器中访问test-template.html页面，输出结果：
```
This is Alpaca-spa.
```

通过上面的示例，可以发现template.html中的内容被渲染到了当前页面。


##  路由

### 1. 什么是路由

&emsp;&emsp; 如果您已经看过前面入门示例中关于路由的示例，相信您已经了解了在Alpaca-Sap.js中，路由的功能是将Url中hash部分映射到一个js方法。

例如上面的示例：

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        //定义index模块
        Alpaca.IndexModule = {};
        //定义index控制器
        Alpaca.IndexModule.IndexController={
            //定义index动作
            indexAction:function(){
                alert('Hello Router');
            },
            //定义index动作
            index2Action:function(){
                Alpaca.Tpl({data:{text:'Hello'},place:'body'});
            },
        };
    </script>

    <script>
        $().ready(function () {
            Alpaca.run();
        });
    </script>

</head>
<body>
{{=it.text }} Alpaca.
</body>
</html>

```
在浏览器中输入http://127.0.0.1/examples/router-index.html#/index/index/index

结果弹出提示框：
```
Hello Router
```

在浏览器中输入http://127.0.0.1/examples/router-index.html#/index/index/index2

页面中显示：
```
Hello Alpaca.
```

可以发现，Url中hash的映射关系 :

\#/index/index/index 映射到 Alpaca.IndexModule.IndexController.indexAction()方法

\#/index/index/index2 映射到 Alpaca.IndexModule.IndexController.index2Action()方法


**路由的组成：**

&emsp;&emsp; Alpaca-Sap.js中，路由用Url中的hash部分表示，主要有三部分组成，模块，控制器，动作。格式：#/模块/控制器/动作

例如：Url中 #/admin/user/add 表示 admin模块，user控制器，add动作。

对应js代码中 Alpaca.AdminModule.UserController.addAction()方法。

那么如何在js代码中定义模块，控制器，方法呢？

**定义模块：**

```
Alpaca.AdminModule = {};
```
模块是Alpaca的一个对象，以Module结尾。上面示例定义了一个名为admin的模块。

**定义控制器：**

```
Alpaca.AdminModule.UserController ={};
```
控制器是模块的一个对象。以Controller 结尾。上面示例定义了一个名为user的控制器，属于admin模块。

**定义动作：**

```
Alpaca.AdminModule.UserController={
    addAction:function(){
        alert('Hello Router');
    },
}
```

动作是控制器中的一个方法，以Action 结尾。上面示例在user的控制器中定义了一个add方法，


### 2. 如何使用路由

在Alpaca-Spa.js中使用路由有三种方式：

* 1 在浏览器的地址栏中直接输入Url，例如上面的示例。

* 2 在页面加载完成时，使用 Alpaca.run()方法。

* 3 使用Alpaca.to()方法。

下面分别介绍Alpaca.run()方法与Alpaca.to()。


### 3. Alpaca.run()

Alpaca.run()一般在页面加载完成时调用，用来执行默认路由，例如：

```
$().ready(function () {
    Alpaca.run();
});

```
在浏览期中打开页面，结果如下：

```
Welcome use Alpaca-spa 2.0 !
```

这是因为当Alpaca.run()方法中的参数为空时，调用了Alpaca-Spa.js的内置默认路由:#/alpaca/alpaca/index , 对应方法： Alpaca.AlpacaModule.AlpacaController.indexAction()。 这个方法在页面中输出了: ```  Welcome use Alpaca-spa 2.0 !  ```

下面示例如何修改页面加载时的默认路由：

新建页面 router-default.html ，内容入下：
```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        //定义index模块
        Alpaca.IndexModule = {};
        //定义index控制器
        Alpaca.IndexModule.IndexController={
            //定义index动作
            indexAction:function(){
                document.write("Hello I'm your default Router.")
            },
        };
    </script>

    <script>
        $().ready(function () {
            Alpaca.run("#/index/index/index");
        });
    </script>

</head>
<body>

</body>
</html>
```
浏览器中打开页面，结果如下：

```
Hello I'm your default Router.
```

通过上面的示例，可以看出为Alpaca.run()方法传递一个参数"#/index/index/index"，就可以改变页面加载时执行默认的路由了。上面的示例中，我们将默认路由改为了#/index/index/index。


### 4. Alpaca.to()

在介绍Alpaca.to()方法使用之前，先来看一个示例：

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        //定义index模块
        Alpaca.IndexModule = {};
        //定义index控制器
        Alpaca.IndexModule.IndexController={
            //定义index动作
            indexAction:function(){
                Alpaca.Tpl({data:{title:"Test Router:"},place:"body"});
            },

            //定义index2动作
            index2Action:function(){
                $('#index2-content').html("调用index2！");
            }
        };
    </script>

    <script>
        $().ready(function () {
            Alpaca.run("#/index/index/index");
        });
    </script>

</head>
<body>
<h4>{{= it.title}}</h4>
<a onclick='Alpaca.to("#/index/index/index2")'>点我执行index2</a>
<div id="index2-content"></div>
</body>
</html>
```
在浏览器中运行该页面，然后点击“点我执行index2”，结果如下：

```
<h4>Test Router:</h4>
点我执行index2
调用index2！
```

通过上面的示例，可以看出Alpaca.to()方法的作用是调用路由。

Alpaca.to()方法可以传递两个参数Alpaca.to(router,data), 其中router是上面示例中的路由，data是可选参数，一个对象类型，代表传递的数据。参考下面的示例：

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script>
        //定义index模块
        Alpaca.IndexModule = {};
        //定义index控制器
        Alpaca.IndexModule.IndexController={
            //定义index动作
            indexAction:function(){
                Alpaca.Tpl({data:{title:"Test Router:"},place:"body"});
            },

            //定义index2动作
            index2Action:function(data){
                $('#index2-content').html("调用index2: "+data.text);
            }
        };
    </script>

    <script>
        $().ready(function () {
            Alpaca.run("#/index/index/index");
        });
    </script>

</head>
<body>
<h4>{{= it.title}}</h4>
<a onclick='Alpaca.to("#/index/index/index2",{text:"hello alpaca!"})'>点我执行index2</a>
<div id="index2-content"></div>
</body>
</html>
```
在浏览器中运行该页面，然后点击“点我执行index2”，结果如下：

```
<h4>Test Router:</h4>
点我执行index2
调用index2: hello alpaca!
```

通过上面的示例，可以看出动作index2对应的方法可以接受一个参数data，这个data就是Alpaca.to(router,data)方法传递过去的data对象。

### 5. 关于hash何时被改变

```
条件1：当前执行的hash必须有效，
条件2：如果未使用layout，则view的CaptureTo等于DefaultLayoutCaptureTo
条件2：如果使用了layout，则layout的CaptureTo等于DefaultLayoutCaptureTo

```

##  视图高级用法

### 1 简介

&emsp;&emsp;视图功能是Alpaca-Spa.js的核心功能，主要解决前端JavaScript实现页面嵌套，页面数据渲染，页面局部渲染等功能。使用视图功能需要配置web服务器，例如apache, nginx等，将网站的根目录设置为项目所在的目录。

推荐的目录结构如下：

```
-application
　 -index
　　  -controller
　　     index.js
　　  -view
　　     -index
            index.html
            index-2.html
            index-3.html
　　     -layout
            -part
               leftMenu.html
            layout.html
　　  index.js
   -test
  　  -controller
　　     index.js
　　  -view
　　     -index
            index.html
            index-2.html
            index-3.html
  　  test.js
   index.html
```
```
1. 示例中的application是项目的根目录，应该将web服务器的根目录设置为此目录。

2. application目录下面有两个子目录，1个html文件。
   index        index目录用来存放当前项目中，所有index模块相关的文件
   test         test目录用来存放当前项目中，所有test模块相关的文件
   index.html   index.html用来做当前项目的入口文件

3.index目录里面有两个目录controller，view，一个js文件
   controller   用来存放index模块的控制器的js代码。里面有一个控制器js文件，index.js
   view         用来存放index模块的视图部分的js代码。
                示例中view目录里面有一个子目录index，用于存放index控制器中相关的模板，
                本示例中，有三个模板：index.html，index-2.html，index-3.html
                还有一个子目录layout，用于存放公共的布局信息，
                layout目录中的layout.html是默认的布局模板文件
                layout目录中的还有一个子目录part，用来存放页面中其他公共区域，例如菜单等
   index.js     index.js是index模块的模块级别的js代码。
                推荐在这个文件里面做模块的定义，例如：Alpaca.IndexModule = {};

4.test目录与index目录同理
```

### 2 使用View

了解完上面的目录结构之后，我们来学习使用Alpaca.View()方法，参看下面的示例。

application/index.html 文件中的内容:

```
<!DOCTYPE html>
<html>
<head>
    <title>Alpaca-Spa-2.0 JS</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>

    <script src="/common/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/alpaca-spa-2.0.js" type="text/javascript"></script>

    <script src="/index/index.js" type="text/javascript"></script>
    <script src="/index/controller/index.js" type="text/javascript"></script>

    <script>
        $().ready(function () {
            Alpaca.run("#/index/index/index");
        });
    </script>
</head>
<body>
<div id="content"> </div>
</body>
</html

```

application/index/index.js 文件中的内容:

```
/* 1 定义Index模块 */
Alpaca.IndexModule = {};
```

application/index/controller/index.js 文件中的内容:
```
/* 1 定义Index模块中的IndexController */
Alpaca.IndexModule.IndexController = {
	//index动作，创建一个视图
	indexAction : function (){
		//视图默认渲染到#content位置，可以通过参数中传递to字段改变渲染位置
		//视图模板默认位于index/view/index/index.html,
		//即：默认模板位置为：[模块名]/view/[控制器名]/[动作名].html
		//可以通过参数中传递template字段改变模块路径
		var view = new Alpaca.View();
		return view;
	},
};
```

application/index/view/index.html 文件中的内容:
```
hello View !!
```

在浏览器中，访问网站根目录下的index.html，结果如下：

```
hello View !
```

&emsp;&emsp;上面的示例中，我们创建了index模块，index控制器，index动作，并且在indexAction中通过Alpaca.View()方法创建了一个视图，运行结果是视图模板中的内容被渲染到了页面的#content位置中。这就是Alpaca.View()的用途。

**Alpaca.View()方法**

Alpaca.View(option) 是一个用来创建视图页面的方法，接受一个对象参数option，参数option中可以包含以下字段：

+ **option.data**

&emsp;&emsp;数据对象，为渲染模板提供数据

&emsp;&emsp;例如：Alpaca.View({data:{name:'Alpaca-spa'}})

+ **option.to**

&emsp;&emsp;设置被渲染位置，默认位置是#content

&emsp;&emsp;例如：Alpaca.View({data:{name:'Alpaca-spa'},to:'#divId'})

+ **option.template**

&emsp;&emsp;指定渲染的模板文件。默认是所属模块view目录下所属controller同名目录下action同名的.html文件，即：默认模板位置为：[模块名]/view/[控制器名]/[动作名].html

&emsp;&emsp;如果需要改变视图模板，只需要这样写即可：template:'index2'，这样就会使用同名controller下的index2.html作为模板。

&emsp;&emsp;这是因为函数内部自动格式化了该参数，如果不想使用自动格式化功能，请使用notFormat参数，设置notFormat:true 即可。

&emsp;&emsp;例如：Alpaca.View({data:{name:'Alpaca-spa'},to:'body',template:'index2'})

+ **option.notFormat**

&emsp;&emsp;默认为false，表示系统会自动格式化template参数，如果设置为true，如下例，视图将使用根目录下的index-test.html文件作为视图模板。
Alpaca.View(template:'/index-test.html',notFormat:true})


### 3 使用Layout和Part

&emsp;&emsp;实际的web项目开发中，大部分页面都是有结构的，比如总体的布局，公用的菜单、页头、页尾等。Alpaca-sap.js使用layout，part来解决这类问题。

继续上面介绍View的示例：

修改application/index/controller/index.js 文件中的内容为：

```
/* 1 定义Index模块中的IndexController */
Alpaca.IndexModule.IndexController = {
	//index动作，创建一个视图
	indexAction : function (){
		//视图默认渲染到#content位置，可以通过参数中传递to字段改变渲染位置
		//视图模板默认位于index/view/index/index.html
		//可以通过参数中传递template字段改变模块路径
		//即：默认模板位置为：[模块名]/view/[控制器名]/[动作名].html
		var view = new Alpaca.View();
		return view;
	},

	//test，测试layout,part。
	//layout视图默认渲染到body位置, 默认layout文件路径是view/layout/layout.html
	//part视图默认路径是view/layout/part目录下与其创建参数中name字段同名的html文件
	//part视图默认渲染位置是 id与其创建参数中name字段同名的元素位置。
	testAction : function (){

		//视图
		var view = new Alpaca.View();

		//layout 布局视图
		var layout = new Alpaca.Layout();

		//part 部件视图，默认路由位于view/layout/part中，文件名默认与name属性相同
		//part 的默认渲染位置与其name属性相同，当然也可以通过to属性指定
		var part = new Alpaca.Part({name:'leftMenu'});

		//将part添加到layout中，part的默认渲染位置与其name属性相同，也可以通过to属性指定
		layout.addChild(part);

		//设置视图的layout
		view.setLayout(layout);

		//在view中，向layout中传递数据
		view.setLayoutData({'layoutData':666});

		//在view中，向part中传递数据
		view.setPartData({leftMenu:{'partData':888}});

		return view;
	},
};
```

application/index/view/layout/layout.html 文件中的内容为：

```
<h2>This layout ! {{=it.layoutData}}</h2>

<div id="content" style="border: 1px dashed green"></div>

<div id="leftMenu" style="border: 1px dashed green"></div>
```

application/index/view/layout/part/leftMenu.html 文件中的内容为：

```
<div> This is View for leftMenu (part view)  {{=it.partData}}</div>
```

在浏览器中访问index.html#/index/index/test,结果如下：

```

This layout ! 666

This is View for test action
This is View for leftMenu (part view) 888

```

上面的示例演示了如何使用 layout、part来渲染复杂页面。


**Alpaca.Layout()方法**

Alpaca.Layout(option) 是用来创建一个layout布局的视图对象的方法，接受一个对象参数option，参数option中可以包含以下字段：

+ **option.data**

&emsp;&emsp;数据对象，为渲染模板提供数据

&emsp;&emsp;例如：Alpaca.Layout({data:{name:'Alpaca-spa'}})

+ **option.to**

&emsp;&emsp;设置被渲染位置，默认位置是body

&emsp;&emsp;例如：Alpaca.Layout({data:{name:'Alpaca-spa'},to:'#divId'})

+ **option.name**

&emsp;&emsp;指定layout的名字。默认为layout

&emsp;&emsp;layout默认的模板路径是所属模块view目录下layout目录下的layout.html文件

&emsp;&emsp;通过name字段可以修改模板的路径为：所属模块view目录下layout目录下与name同名的html文件

&emsp;&emsp;例如：Alpaca.Layout({data:{name:'Alpaca-spa'},to:'body',name:'layout2'})


**Alpaca.Part()方法**

Alpaca.Part(option) 是用来创建一个part布局的视图对象的方法，接受一个对象参数option，参数option中可以包含以下字段：

+ **option.data**

&emsp;&emsp;数据对象，为渲染模板提供数据

&emsp;&emsp;例如：Alpaca.Part({data:{name:'Alpaca-spa'}})

+ **option.name**

&emsp;&emsp;指定Part的名字。

&emsp;&emsp;Part默认的模板路径是所属模块view\layout\part目录下与其name同名的html文件

&emsp;&emsp;Part默认的渲染位置是id与其name同名的元素

&emsp;&emsp;通过name字段可以达到指定他的视图模板路径，以及渲染位置的效果，例如，

&emsp;&emsp;例如：Alpaca.Part({data:{name:'Alpaca-spa'},name:'top'})

+ **option.to**

&emsp;&emsp;设置被渲染位置，默认位置是id与其name同名的元素

&emsp;&emsp;例如：Alpaca.Part({data:{name:'Alpaca-spa'},to:'#divId'})

### 4 ready()方法

视图渲染完毕后会执行view.ready()方法，例如

```
var view = new Alpaca.View()

//视图渲染完成后执行ready方法。
view.ready(function () {
	console.log('视图渲染完成了...');
})

return view;
```

### 5 自定义显示效果

通过设置view.show方法可以自定义视图显示效果，例如：

```
var view = new Alpaca.View();

//自定义视图渲染效果为闪入效果。
//注意：在自定义视图显示效果时，需要调用onLoad事件，来触发执行ready函数。
view.show = function (to, html) {
    var that = this;
    $(to).fadeOut("fast", function () {
        $(to).html(html);
        $(to).fadeIn("fast", function () {
            that.onLoad();
        });
    });
};

return view;
```
上面面示例代码，实现了视图渲染时的闪入效果。

### 6 init()与release()方法

&emsp;&emsp;如果在控制器中定义了init()方法，那么在执行当前控制器的所有action方法前都会执行init()方法。如果在控制器中定义了release()方法，那么在执行完成当前控制器的所有action方法之后，都会执行release()方法，

参考示例：

```
/* 定义Index模块中的TestController */
Alpaca.IndexModule.TestController = {

	//init方法,当前控制下的所有动作在执行前，都回执行init方法
	init:function(){
		console.log('执行action之前，执行init()方法');
	},

	//release方法,当前控制下的所有动作在执行前，都回执行release方法
	release:function(){
		console.log('执行action之后，执行release)方法');
	},
};
```

##  内置对象与方法



##  交流方式

### 联系我们

QQ群： 298420174

![图片名称](http://www.tkc8.com/index_files/Image%20[10].png)

作者： Sponge
邮箱： 1796512918@qq.com

