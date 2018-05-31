/*!
 * Alpaca-spa JavaScript Library v2.0
 * https://gitHub.com
 * Author: ChengCheng
 * Date: 2017-03-07 21:00:00
 */

/* Router */
Router = function () {

    "use strict";

    var obj = {};

    /* Alpaca名字 */
    obj.AlpacaName = 'Alpaca.';

    /* 对应的alpaca对象 */
    obj.Alpaca = {};

    /* 模块前缀 */
    obj.ModulePostfix = 'Module';
    /* 控制器前缀 */
    obj.ControllerPostfix = 'Controller';
    /* 动作前缀 */
    obj.ActionPostfix = 'Action';

    /* 默认模块 */
    obj.DefaultModule = 'alpaca';
    /* 默认控制器 */
    obj.DefaultController = 'alpaca';
    /* 默认动作 */
    obj.DefaultAction = 'index';

    /* 模块 */
    obj.Module = null;
    /* 控制器 */
    obj.Controller = null;
    /* 动作 */
    obj.Action = null;

    /* 模块名称 */
    obj.ModuleName = null;
    /* 控制器名称 */
    obj.ControllerName = null;
    /* 动作名称 */
    obj.ActionName = null;

    /* 模块全名 */
    obj.ModuleFullName = null;
    /* 控制器全名 */
    obj.ControllerFullName = null;
    /* 动作全名 */
    obj.ActionFullName = null;

    /* 正在执行的hash */
    obj.InHash = null;

    /* 路由参数 */
    obj.Params = new Array();

    /* 路由参数 ?参数 */
    obj.QueryString = '';

    /* 获取路由中的参数 */
    obj.getParams = function (index, defaultValue) {
        var value = obj.Params[index];
        if(value){
            return value;
        }

       var getAlpacaQuery = function(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r   = obj.QueryString.match(reg);
            if (r != null) {
                return (r[2]);
            }
            return null;
        };

        value = getAlpacaQuery(index);
        if(value){
            return value;
        }

        var  getQueryStringUrl = function(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r   = window.location.search.substr(1).match(reg);
            if (r != null) {
                return (r[2]);
            }
            return null;
        };

        value = getQueryStringUrl(index);
        if(value){
            return value;
        }

        return defaultValue;
    };

    /* 解析路由 */
    obj.parser = function (inHash) {

        /* 格式化inHash */
        if (!inHash) {
            inHash = "";
        }
        /* 解析问号前面的 */
        if (inHash.indexOf("?") != -1) {
            this.QueryString = inHash.slice(inHash.indexOf("?") + 1);
            inHash = inHash.slice(0, inHash.indexOf("?"));
        }

        /* segments存放分割的路由 */
        var segments = new Array();
        segments     = inHash.split("/");

        /* 设置默认模块 */
        if (!segments[3]) {
            segments.splice(1, 0, this.DefaultModule);
        }
        /* 设置默认模块 */
        if (!segments[3]) {
            segments.splice(2, 0, this.DefaultController);
        }
        /* 设置默认模块 */
        if (!segments[3]) {
            segments.splice(3, 0, this.DefaultAction);
        }

        /* 保存路由中的其他字段到参数 */
        this.Params = segments.slice(4);

        /* 设置正在执行的hash，如果hash等于当前正在执行的hash，跳出，防止死循环 */
        if (this.InHash == inHash) {
            //return null;
        }
        this.InHash = inHash;

        /* 模块Module */
        this.Module         = segments[1];
        this.ModuleName     = this.Module + this.ModulePostfix;
        this.ModuleName     = this.ModuleName.replace(/(\w)/, function (v) {
            return v.toUpperCase();
        });
        this.ModuleFullName = this.AlpacaName + this.ModuleName;

        /* 控制器Controller */
        this.Controller         = segments[2];
        this.ControllerName     = this.Controller + this.ControllerPostfix;
        this.ControllerName     = this.ControllerName.replace(/(\w)/, function (v) {
            return v.toUpperCase();
        });
        this.ControllerFullName = this.ModuleFullName + "." + this.ControllerName;

        /* 动作Action */
        this.Action         = segments[3];
        this.ActionName     = this.Action + this.ActionPostfix;
        this.ActionFullName = this.ControllerFullName + "." + this.ActionName;

        /* 打印解析结果 */
        console.log(this.ModuleName, this.ControllerName, this.ActionName);

        /* 返回结果 */
        return this;
    };

    /* 启动路由 */
    obj.run = function (inHash) {
        /* 解析hash,创建一个路由实例 */
        var router ={};
        $.extend(router,this.parser(inHash));
        return router;
    };

    /* 返回路由 */
    return obj;
}();

/* View对象 */
ViewModel = function () {

    "use strict";

    /* 创建对象 */
    var obj = {};

    /* 视图view默认渲染的位置 */
    obj.DefaultViewCaptureTo = "#content";

    /* 布局layout默认渲染的位置 */
    obj.DefaultLayoutCaptureTo = "body";

    /* 模板文件默认扩展名 */
    obj.TemplatePostfix = 'html';

    /* 对应的alpaca对象 */
    obj.Alpaca = {};

    /* 创建视图模板 */
    obj.create = function () {

        /*定义对象，*/
        var view = {};

        /*对应的Alpaca*/
        view.Alpaca = this.Alpaca;

        /*名字,默认时action的名字*/
        view.Name = (function () {
            /* 如果没有路由，直接返回 */
            if (!view.Alpaca.Router) {
                return '';
            }
            return view.Alpaca.Router.Action;
        }());

        /*模板路径 - 设置默认模板路径*/
        view.Template = (function () {

            /*如果没有路由，直接返回*/
            if (!view.Alpaca.Router) {
                return '';
            }

            /*生成模板路径*/
            var path = view.Alpaca.Config['baseUrl'];
            path += view.Alpaca.Router.Module;
            path += "/view/" + view.Alpaca.Router.Controller + "/";
            path += view.Alpaca.Router.Action + ".";
            path += view.Alpaca.ViewModel.TemplatePostfix;
            return path;
        }());

        /*渲染位置*/
        view.CaptureTo = this.DefaultViewCaptureTo;

        /*是否使用layout，默认false*/
        view.IsUseLayout = false;

        /* 是否是Final，默认false。true时控制器中的onDisplay方法可以修改view */
        view.IsFinal = false;

        /* 要渲染的数据 */
        view.Data = {};

        /* 使用的layout对象 */
        view.Layout = null;

        /* layout中的数据 */
        view.LayoutData = {};

        /* part中的数据, */
        view.PartData = {};

        /* 子视图集合 */
        view.Children = [];

        /* child中的数据, */
        view.ChildData = {};

        /* 加载模板 */
        view.loadTemplate = function (url) {
            var htmlObj = view.Alpaca.$.ajax({
                type: "get",
                url: url,
                async: false

            });
            return htmlObj.responseText;
        };

        /* 渲染数据 */
        view.loadData = function (tpl, data) {
            var interText = view.Alpaca.DoT.template(tpl);
            return interText(data);
        };

        /* 显示视图的方法 */
        view.show = function (captureTo, html) {
            if (captureTo == 'html') {
                document.getElementsByTagName("html")[0].innerHTML = html;
            } else {
                view.Alpaca.$(captureTo).html(html);
            }
            /* 调用视图加载完成事件 */
            $(captureTo).ready(function () {
                view.onLoad();
            });

            return this;
        };

        /* 加载完成时候执行的事件 */
        view.LoadEvent = [];

        /* 加载完成时候执行的事件，在onLoad之后 */
        view.ReadyEvent = [];

        /* 视图加载完成后调用的事件 */
        view.onLoad = function () {
            /* 执行事件 */
            if (this.LoadEvent) {
                for (var index in this.LoadEvent) {
                    this.LoadEvent[index](this);
                }
            }
            /* 触发ready事件 */
            this.onReady();
            return this;
        };

        /* 视图加载完成后调用的事件 在onLoad之后 */
        view.onReady = function () {
            /* 执行事件 */
            if (this.ReadyEvent) {
                for (var index in this.ReadyEvent) {
                    this.ReadyEvent[index](this);
                }
            }
            return this;
        };

        /* 添加load事件 */
        view.load = function (func) {
            this.LoadEvent.push(func);
            return this;
        };

        /* 添加ready事件 */
        view.ready = function (func) {
            this.ReadyEvent.push(func);
            return this;
        };

        /* 设置数据 data:要设置的数据，isReset: true时候，覆盖原来的数据 */
        view.setData = function (data, isReset) {
            /* isReset = true时候，覆盖原来的数据， */
            if (!this.Data) {
                this.Data = {};
            }

            if (isReset) {
                /* 覆盖原来的数据 */
                this.Data = data;
            } else {
                /* 合并数据 */
                for (var i in data) {
                    this.Data[i] = data[i];
                }
            }
            return this;
        };

        /* 设置渲染位置 */
        view.setCaptureTo = function (captureTo) {
            this.CaptureTo = captureTo;
            return this;
        };

        /* 设置模板 */
        view.setTemplate = function (template) {
            this.Template = template;
            return this;
        };

        /* 设置Final */
        view.setFinal = function (value) {
            this.Final = Boolean(value);
            return this;
        };

        /* 设置模板 */
        view.setLayout = function (layout) {
            this.Layout = layout;
            this.Layout.addChild(this);
            this.IsUseLayout = true;
            return this;
        };

        /* 设置是否使用layout */
        view.setUseLayout = function (value) {
            this.UseLayout = Boolean(value);
            if (value && !this.Layout) {
                this.setLayout(view.Alpaca.ViewModel.layout());
            }
            return this;
        };

        /* 在view中设置layout的data */
        view.setLayoutData = function (data) {
            /* LayoutData为定义时，设置LayoutData为空对象 */
            if (!this.LayoutData) {
                this.LayoutData = {};
            }

            /* 合并数据 */
            for (var i in data) {
                this.LayoutData[i] = data[i];
            }
            return this;
        };

        /* 添加子视图 */
        view.addChild = function (child, captureTo) {
            /* 渲染位置 */
            if (captureTo) {
                child.setCaptureTo(captureTo);
            }
            /* 添加子视图 */
            this.Children.push(child);
            return this;
        };

        /* 在设置View中设置Part的Data */
        view.setPartData = function (partData) {
            /* LayoutData为定义时，设置LayoutData为空对象 */
            if (!this.PartData) {
                this.PartData = {};
            }

            /* 合并数据 */
            for (var name in partData) {
                /* name就是part中Name的名字 */
                var data = partData[name];
                if (!this.PartData[name]) {
                    this.PartData[name] = {};
                }
                /* 合并数据 */
                for (var i in data) {
                    this.PartData[name][i] = data[i];
                }

            }
            return this;
        };

        /* 在设置View中设置Child的Data */
        view.setChildData = function (partData) {
            /* LayoutData为定义时，设置LayoutData为空对象 */
            if (!this.ChildData) {
                this.ChildData = {};
            }

            /* 合并数据 */
            for (var name in partData) {
                /* name就是part中Name的名字 */
                var data = partData[name];
                if (!this.ChildData[name]) {
                    this.ChildData[name] = {};
                }
                /* 合并数据 */
                for (var i in data) {
                    this.ChildData[name][i] = data[i];
                }
            }
            return this;
        };

        /* 判断是否有子视图 */
        view.hasChildren = function () {
            return (0 < (this.Children).length);
        };

        /* 渲染子视图 */
        view.childRender = function (view) {
            if (view.hasChildren) {
                for (var index in view.Children) {
                    /* 填充子视图中的数据 */
                    if (view.ChildData[view.Children[index].Name]) {
                        view.Children[index].setData(view.ChildData[view.Children[index].Name]);
                    }
                    /* 渲染子视图 */
                    view.Children[index].router =view.router;
                    view.Children[index].render();
                }
            }
        };

        /* 渲染视图 */
        view.render = function () {

            /* 添加渲染子视图的事件，在show函数中加载完视图模板会调用该事件 */
            this.load(this.childRender);

            /* 加载模板 */
            var tpl = this.loadTemplate(this.Template);

            /* 渲染数据 */
            var html = this.loadData(tpl, this.Data);

            /* 显示视图 */
            var show = this.show(this.CaptureTo, html);

            return html;
        };

        /* 显示视图 */
        view.display = function () {
            /* 判断是否使用了模板，如果使用了layout，直接渲染layout（layout中会渲染view） */
            if (this.Layout && this.IsUseLayout) {
                /* 合并数据-视图中设置的layout数据 */
                for (var index in this.LayoutData) {
                    this.Layout.Data[index] = this.LayoutData[index];
                }
                /* 合并数据-视图中设置的part数据,将数据放入layout中的ChildData */
                for (var name in this.PartData) {
                    var data   = {};
                    data[name] = this.PartData[name];
                    this.Layout.setChildData(data);
                }
                /* 渲染layout */
                this.Layout.router =this.router;
                this.Layout.render();
            } else {
                /* 渲染自己 */
                this.render();
            }
        };

        /* 返回结果 */
        return view;
    };

    /*
     * 创建view视图，一般用于页面主视图
     * option.data：         数据，
     * option.to：           渲染位置，
     * option.from：         使用dom元素作为模板，
     * option.template：     模板位置，
     */
    obj.view = function (option) {

        /* 创建视图 */
        var view = obj.create();

        /* 格式化 */
        if (!option) {
            option = {};
        }

        /* 如果设置了data */
        if (option['data']) {
            view.setData(option['data']);
        }

        /* 如果设置了name */
        if (option['name']) {
            view.Name = option['name'];
        }

        /* 如果参数中传递了captureTo，设置captureTo，否则用默认值 */
        if (option['to']) {
            view.setCaptureTo(option['to']);
        }

        /* 如果设置了captureFrom，重置获取template方法 */
        if (option['from']) {
            view.loadTemplate = function () {
                return obj.Alpaca.$(option['from']).html();
            };
            view.setTemplate('');
        }
        /* 如果参数中传递了template，否则用默认值 */
        else if (option['template'] && !option['notFormat']) {
            /* segments存放分割的路径 */
            var segments = option['template'].split("/");

            if (segments[0]) {
                segments.splice(0, 0, '');
            }

            /* 设置默认模块 */
            if (!segments[3]) {
                segments.splice(1, 0, obj.Alpaca.Router.Module);
            }
            /* 设置默认模块 */
            if (!segments[3]) {
                segments.splice(2, 0, obj.Alpaca.Router.Controller);
            }
            /* 设置默认模块 */
            if (!segments[3]) {
                segments.splice(3, 0, obj.Alpaca.Router.Action);
            }

            /* 设置路径 */
            var path = obj.Alpaca.Config['baseUrl'];
            path += segments[1];
            path += "/view/" + segments[2] + "/";
            path += segments[3] + ".";
            path += obj.Alpaca.ViewModel.TemplatePostfix;
            view.setTemplate(path);
        } else if (option['template']) {
            view.setTemplate(option['template']);
        }

        /* 返回视图 */
        return view;
    };

    /* 创建创建layout视图，一般用于页面布局视图 */
    obj.layout = function (option) {

        /* 格式化 */
        if (!option) {
            option = {};
        }

        /* 不格式化template路径，输入的什么就是什么 */
        option['notFormat'] = true;

        /* 设置captureTo，如果没有指定to，则使用layout默认的captureTo */
        if (!option['to']) {
            option['to'] = obj.Alpaca.ViewModel.DefaultLayoutCaptureTo;
        }

        /* 设置name，如果没有指定name，设置默认layout作为当前模板的名字 */
        if (!option['name']) {
            option['name'] = 'layout';
        }

        /* 设置template，如果没有指定template，设置默认template */
        if (!option['template']) {
            /* 如果没有路由，直接返回 */
            if (!obj.Alpaca.Router) {
                return '';
            }

            /* 生成模板路径 */
            var path           = obj.Alpaca.Config['baseUrl'];
            path += obj.Alpaca.Router.Module;
            path += "/view/layout/";
            path += option['name'];
            path += ".";
            path += obj.Alpaca.ViewModel.TemplatePostfix;
            option['template'] = path;
        } else {
            /* 加上文件扩展名 */
            option['template'] += "." + obj.Alpaca.ViewModel.TemplatePostfix;
        }

        /* 通过view创建layout */
        var layout = obj.view(option);

        /* 返回结果 */
        return layout;
    };

    /* 创建创建part视图，一般用于页面布局中的菜单，页头，页尾等 */
    obj.part = function (option) {

        /* 格式化 */
        if (!option) {
            option = {};
        }

        /* 不格式化template路径，输入的什么就是什么 */
        option['notFormat'] = true;

        /* 设置name，如果没有指定name，设置默认part */
        if (!option['name']) {
            option['name'] = 'part';
        }

        /* 设置captureTo，如果没有指定to，则使用part默认的的name */
        if (!option['to']) {
            option['to'] = "#" + option['name'];
        }

        /* 设置template，如果没有指定template，设置默认template */
        if (!option['template']) {
            /* 如果没有路由，直接返回 */
            if (!obj.Alpaca.Router) {
                return '';
            }

            /* 生成模板路径 */
            var path           = obj.Alpaca.Config['baseUrl'];
            path += obj.Alpaca.Router.Module;
            path += "/view/layout/part/";
            path += option['name'];
            path += ".";
            path += obj.Alpaca.ViewModel.TemplatePostfix;
            option['template'] = path;
        } else {
            /* 加上文件扩展名 */
            option['template'] += "." + obj.Alpaca.ViewModel.TemplatePostfix;
        }

        /* 通过view创建layout */
        var part = obj.view(option);

        /* 返回结果 */
        return part;
    };

    /* 返回视图 */
    return obj;
}();

/* 模板引擎
 * doT.js
 * 2011-2014, Laura Doktorova, https://github.com/olado/doT
 * Licensed under the MIT license.
 */
(function () {
    "use strict";

    var doT = {
        name: "doT",
        version: "1.1.1",
        templateSettings: {
            evaluate: /\{\{([\s\S]+?(\}?)+)\}\}/g,
            interpolate: /\{\{=([\s\S]+?)\}\}/g,
            encode: /\{\{!([\s\S]+?)\}\}/g,
            use: /\{\{#([\s\S]+?)\}\}/g,
            useParams: /(^|[^\w$])def(?:\.|\[[\'\"])([\w$\.]+)(?:[\'\"]\])?\s*\:\s*([\w$\.]+|\"[^\"]+\"|\'[^\']+\'|\{[^\}]+\})/g,
            define: /\{\{##\s*([\w\.$]+)\s*(\:|=)([\s\S]+?)#\}\}/g,
            defineParams: /^\s*([\w$]+):([\s\S]+)/,
            conditional: /\{\{\?(\?)?\s*([\s\S]*?)\s*\}\}/g,
            iterate: /\{\{~\s*(?:\}\}|([\s\S]+?)\s*\:\s*([\w$]+)\s*(?:\:\s*([\w$]+))?\s*\}\})/g,

            evaluateSpa: /<\?spa \s*([\s\S]+?(\}?)+)\s*\?>/g,
            interpolateSpa: /<\?spa echo ([\s\S]+?)\?>/g,
            encodeSpa: /\{\{!([\s\S]+?)\}\}/g,
            useSpa: /\{\{#([\s\S]+?)\}\}/g,
            useParamsSpa: /(^|[^\w$])def(?:\.|\[[\'\"])([\w$\.]+)(?:[\'\"]\])?\s*\:\s*([\w$\.]+|\"[^\"]+\"|\'[^\']+\'|\{[^\}]+\})/g,
            defineSpa: /\{\{##\s*([\w\.$]+)\s*(\:|=)([\s\S]+?)#\}\}/g,
            defineParamsSpa: /^\s*([\w$]+):([\s\S]+)/,
            endIterateSpa: /<\?spa \s*endForeach(|;)\s*\?>/g,
            conditionalSpa: /\{\{\?(\?)?\s*([\s\S]*?)\s*\}\}/g,
            iterateSpa: /<\?spa \s*foreach\(\s*([\s\S]+?)\s*as\s*([\w$]+)\s*(?:=>\s*([\w$]+))?\s*\)(|:)\s*\?>/g,
            for: /<\?spa for\(\s*var\s*([\s\S]+?)\s*in\s*([\s\S]+?)\s*\)\s*\?>/g,
            endFor: /<\?spa \s*endFor(|;)\s*\?>/g,

            varname: "it",
            strip: true,
            append: true,
            selfcontained: false,
            doNotSkipEncoded: false
        },
        template: undefined,
        compile: undefined,
        log: true
    }, _globals;

    doT.encodeHTMLSource = function (doNotSkipEncoded) {
        var encodeHTMLRules = {"&": "&#38;", "<": "&#60;", ">": "&#62;", '"': "&#34;", "'": "&#39;", "/": "&#47;"},
            matchHTML       = doNotSkipEncoded ? /[&<>"'\/]/g : /&(?!#?\w+;)|<|>|"|'|\//g;
        return function (code) {
            return code ? code.toString().replace(matchHTML, function (m) {
                return encodeHTMLRules[m] || m;
            }) : "";
        };
    };

    _globals = (function () {
        return this || (0, eval)("this");
    }());

    /* istanbul ignore else */
    if (typeof module !== "undefined" && module.exports) {
        module.exports = doT;
    } else if (typeof define === "function" && define.amd) {
        define(function () {
            return doT;
        });
    } else {
        _globals.doT = doT;
    }

    var startend = {
        append: {start: "'+(", end: ")+'", startencode: "'+encodeHTML("},
        split: {start: "';out+=(", end: ");out+='", startencode: "';out+=encodeHTML("}
    }, skip      = /$^/;

    function resolveDefs(c, block, def) {
        return ((typeof block === "string") ? block : block.toString())
            .replace((c.define || c.defineSpa ) || skip, function (m, code, assign, value) {
                if (code.indexOf("def.") === 0) {
                    code = code.substring(4);
                }
                if (!(code in def)) {
                    if (assign === ":") {
                        if (c.defineParams) value.replace(c.defineParams, function (m, param, v) {
                            def[code] = {arg: param, text: v};
                        });
                        if (c.defineParamsSpa) value.replace(c.defineParamsSpa, function (m, param, v) {
                            def[code] = {arg: param, text: v};
                        });
                        if (!(code in def)) def[code] = value;
                    } else {
                        new Function("def", "def['" + code + "']=" + value)(def);
                    }
                }
                return "";
            })
            .replace((c.use || c.useSpa ) || skip, function (m, code) {
                if (c.useParams) code = code.replace(c.useParams, function (m, s, d, param) {
                    if (def[d] && def[d].arg && param) {
                        var rw        = (d + ":" + param).replace(/'|\\/g, "_");
                        def.__exp     = def.__exp || {};
                        def.__exp[rw] = def[d].text.replace(new RegExp("(^|[^\\w$])" + def[d].arg + "([^\\w$])", "g"), "$1" + param + "$2");
                        return s + "def.__exp['" + rw + "']";
                    }
                });
                if (c.useParamsSpa) code = code.replace(c.useParamsSpa, function (m, s, d, param) {
                    if (def[d] && def[d].arg && param) {
                        var rw        = (d + ":" + param).replace(/'|\\/g, "_");
                        def.__exp     = def.__exp || {};
                        def.__exp[rw] = def[d].text.replace(new RegExp("(^|[^\\w$])" + def[d].arg + "([^\\w$])", "g"), "$1" + param + "$2");
                        return s + "def.__exp['" + rw + "']";
                    }
                });
                var v = new Function("def", "return " + code)(def);
                return v ? resolveDefs(c, v, def) : v;
            });
    }

    function unescape(code) {
        return code.replace(/\\('|\\)/g, "$1").replace(/[\r\t\n]/g, " ");
    }

    doT.template = function (tmpl, c, def) {
        c                                                                          = c || doT.templateSettings;
        var cse = c.append ? startend.append : startend.split, needhtmlencode, sid = 0, indv,
            str                                                                    = ((c.use || c.useSpa) || (c.define || c.defineSpa)) ? resolveDefs(c, tmpl, def || {}) : tmpl;

        str = ("var out='" + (c.strip ? str.replace(/(^|\r|\n)\t* +| +\t*(\r|\n|$)/g, " ")
            .replace(/\r|\n|\t|\/\*[\s\S]*?\*\//g, "") : str)
            .replace(/'|\\/g, "\\$&")
            .replace(c.interpolate || skip, function (m, code) {
                return cse.start + unescape(code) + cse.end;
            })
            .replace(c.encode || skip, function (m, code) {
                needhtmlencode = true;
                return cse.startencode + unescape(code) + cse.end;
            })
            .replace(c.conditional || skip, function (m, elsecase, code) {
                return elsecase ?
                    (code ? "';}else if(" + unescape(code) + "){out+='" : "';}else{out+='") :
                    (code ? "';if(" + unescape(code) + "){out+='" : "';}out+='");
            })
            .replace(c.iterate || skip, function (m, iterate, vname, iname) {
                if (!iterate) return "';} } out+='";
                sid += 1;
                indv    = iname || "i" + sid;
                iterate = unescape(iterate);
                return "';var arr" + sid + "=" + iterate + ";if(arr" + sid + "){var " + vname + "," + indv + "=-1,l" + sid + "=arr" + sid + ".length-1;while(" + indv + "<l" + sid + "){"
                    + vname + "=arr" + sid + "[" + indv + "+=1];out+='";
            })
            .replace(c.evaluate || skip, function (m, code) {
                return "';" + unescape(code) + "out+='";
            })

            .replace(c.endIterateSpa || skip, function () {
                return "';} } out+='";
            })
            .replace(c.interpolateSpa || skip, function (m, code) {
                return cse.start + unescape(code) + cse.end;
            })
            .replace(c.encodeSpa || skip, function (m, code) {
                needhtmlencode = true;
                return cse.startencode + unescape(code) + cse.end;
            })
            .replace(c.conditionalSpa || skip, function (m, elsecase, code) {
                return elsecase ?
                    (code ? "';}else if(" + unescape(code) + "){out+='" : "';}else{out+='") :
                    (code ? "';if(" + unescape(code) + "){out+='" : "';}out+='");
            })
            .replace(c.iterateSpa || skip, function (m, iterate, iname, vname) {
                if (!iterate) return "';} } out+='";
                sid += 1;
                indv    = iname || "i" + sid;
                iterate = unescape(iterate);
                return "';var arr" + sid + "=" + iterate + ";if(arr" + sid + "){var " + vname + "," + indv + "=-1,l" + sid + "=arr" + sid + ".length-1;while(" + indv + "<l" + sid + "){"
                    + vname + "=arr" + sid + "[" + indv + "+=1];out+='";
            })
            .replace(c.evaluateSpa || skip, function (m, code) {
                return "';" + unescape(code) + "out+='";
            })
            .replace(c.for || skip, function (m, key, iterate) {
                return "';for(var " + key + " in " + iterate + "){;out+='";
            })
            .replace(c.endFor || skip, function () {
                return "'; } out+='";
            })


        + "';return out;")
            .replace(/\n/g, "\\n").replace(/\t/g, '\\t').replace(/\r/g, "\\r")
            .replace(/(\s|;|\}|^|\{)out\+='';/g, '$1').replace(/\+''/g, "");


        if (needhtmlencode) {
            if (!c.selfcontained && _globals && !_globals._encodeHTML) _globals._encodeHTML = doT.encodeHTMLSource(c.doNotSkipEncoded);
            str = "var encodeHTML = typeof _encodeHTML !== 'undefined' ? _encodeHTML : ("
                + doT.encodeHTMLSource.toString() + "(" + (c.doNotSkipEncoded || '') + "));"
                + str;
        }
        try {
            return new Function(c.varname, str);
        } catch (e) {
            /* istanbul ignore else */
            if (typeof console !== "undefined") console.log("Could not create a template function: " + str);
            throw e;
        }
    };

    doT.compile = function (tmpl, def) {
        return doT.template(tmpl, null, def);
    };
}());

/* Alpaca对象 */
Alpaca = function () {

    "use strict";

    var obj = {};

    obj.Name = 'Alpaca.';

    /* 版本信息 */
    obj.Version = {
        version: '2.0.0',
        note: 'update view and router.'
    };

    /* 配置属性 */
    obj.Config = {
        baseUrl: '/'
    };

    /* 配置 - 引用的$(JQuery 等) */
    obj.$ = $;

    /* 配置 - 模板引擎 */
    obj.DoT = doT;

    /* 配置 - 路由 - 创建路由的方法 */
    obj.NewRouter = Router;

    /* /路由实例 */
    obj.Router = null;

    /* 配置 - 视图 - 创建视图的方法 */
    obj.ViewModel        = ViewModel;
    obj.ViewModel.Alpaca = obj;

    /* 请求参数 */
    obj.requestData = {};

    /* 创建view视图 */
    obj.View = function (option) {
        var view = obj.ViewModel.view(option);
        return view;
    };

    /* 创建layout视图 */
    obj.Layout = function (option) {
        var layout = obj.ViewModel.layout(option);
        return layout;
    };

    /* 创建part视图 */
    obj.Part = function (option) {
        var part = obj.ViewModel.part(option);
        return part;
    };

    /* 快捷视图模板渲染方法 */
    obj.Tpl = function (option) {
        /* 格式化 */
        if (!option) {
            option = {};
        }

        /* 不格式化template路径，输入的什么就是什么 */
        if (option['notFormat'] !== false) {
            option['notFormat'] = true;
        }

        /* 如果设置了place,则from，to，全部等于place */
        if (option['place']) {
            option['from'] = option['place'];
            option['to']   = option['place'];
        }

        /* 创建视图 */
        var view = obj.View(option);

        /* 渲染、显示 */
        view.display();
    };

    /* hash改变事件集合 */
    obj.HashChange = [];

    /* 是否改变hash */
    obj.isChangeHash = undefined;

    /* 启动Alpaca */
    obj.run = function (runHash) {

        /* 记录当前页面路由 */
        var nowHash = window.location.hash;

        /* 格式化 */
        if (!nowHash) {
            nowHash = '';
        }
        if (!runHash) {
            runHash = '';
        }

        /* 解决刷新问题，防治每次刷新都进入默认路由，而不是进入url中的hash路由 */
        if (runHash != '' && nowHash == '') {
            /* url中的hash为空，应用默认路由 */
            this.to(runHash);
        } else {
            /* url中的hash不为空 执行url中Hash路由. */
            this.to(nowHash);
        }
        return true;
    };

    /* 调用Alpaca路由 */
    obj.to = function (inHash, data) {

        /* 开始路由 */
        this.Router        = this.NewRouter;
        this.Router.Alpaca = this;

        /* 根据hash创建路由对象 */
        var router = this.Router.run(inHash);

        /* 检查路由对象是否正确 */
        var runAction = obj.check(router);

        /* 执行动作 */
        if (!data) {
            data = {};
        }
        var result = obj.doAction(runAction, router, data, inHash);

        /* 返回结果 */
        return result;
    };

    /* 获取要执行的action，检查路由是否正确解析 */
    obj.check = function (router) {

        /* 定义要执行的action的名字 */
        var actionName = '';
        /* 获取内置模块Alpaca模块，里面处理了一些出错信息 */
        var alpacaController = this.Name + "AlpacaModule.AlpacaController";

        /* 检查模块名，控制器名，动作名 */
        if (!eval(router.ModuleFullName)) {
            /* 模块名不正确 */
            actionName = alpacaController + ".moduleNotFoundAction";
        } else if (!eval(router.ControllerFullName)) {
            /* 控制器名不正确 */
            actionName = alpacaController + ".controllerNotFoundAction";
        } else if (!eval(router.ActionFullName)) {
            /* 动作名不正确 */
            actionName = alpacaController + ".actionNotFoundAction";
        } else {
            actionName = router.ActionFullName;
        }

        /* 返回处理后的结果 */
        return actionName;
    };

    /* 执行模块或者控制器中的init方法，该方法在action方法之前执行 */
    obj.init = function (router) {
        /* 执行模块init方法，如果该方法存在 */
        var moduleResult = undefined;
        if (eval(router.ModuleFullName) && eval(router.ModuleFullName + ".init")) {
            moduleResult = eval(router.ModuleFullName + ".init" + "()");
        }
        if (moduleResult !== undefined) {
            return moduleResult;
        }

        /* 执行控制器init方法，如果该方法存在 */
        var controllerResult = undefined;
        if (eval(router.ModuleFullName) && eval(router.ControllerFullName) && eval(router.ControllerFullName + ".init")) {
            controllerResult = eval(router.ControllerFullName + ".init" + "()");
        }
        if (controllerResult !== undefined) {
            return controllerResult;
        }

        return undefined;
    };

    /* 执行模块或者控制器中的release方法，该方法在action方法之前执行 */
    obj.release = function (router) {

        /* 执行控制器release方法，如果该方法存在 */
        if (eval(router.ModuleFullName) && eval(router.ControllerFullName) && eval(router.ControllerFullName + ".release")) {
            eval(this.ControllerFullName + ".release" + "()");
        }

        /* 执行模块release方法，如果该方法存在 */
        if (eval(router.ModuleFullName) && eval(router.ModuleFullName + ".release")) {
            eval(router.ModuleFullName + ".release" + "()");
        }
    };

    /* 执行解析后路由对应的方法 */
    obj.doAction = function (actionName, router, data, inHash) {

        /* 执行分发之前的事件 */
        var initResult = obj.init(router);
        if (initResult !== undefined) {
            return;
        }

        /* 判断actionName是否为空 */
        if (!actionName) {
            return;
        }

        /* 执行Action */
        var result = eval(actionName + "(data)");
        if (result == false || !result) {
            router.InHash = null;
            return false;
        }

        /* 设置hash,解决什么时候修改url中的hash:，
         条件1：inHsah必须有效，
         条件2：如果未使用layout，则view的CaptureTo等于DefaultLayoutCaptureTo
         条件2：如果使用了layout，则layout的CaptureTo等于DefaultLayoutCaptureTo
         */
        var isSetHash = inHash && ( result.CaptureTo == Alpaca.ViewModel.DefaultLayoutCaptureTo || (result.IsUseLayout == true && result.Layout.CaptureTo == Alpaca.ViewModel.DefaultLayoutCaptureTo));
        if (isSetHash || this.isChangeHash === true) {
            /* 关闭浏览器内置onHashChange事件 */
            window.onhashchange = null;
            /* 设置hash */
            window.location.hash = inHash;
            /* 触发Alpaca自己的hashChange事件事件 */
            obj.onHashChange();
            /* 打开浏览器内置onHashChange事件 */
            setTimeout(function () {
                window.onhashchange = obj.changeHash;
            }, 50);
        }

        /* 返回的结果是一个视图View对象时候 */
        if (result) {
            result.router = router;
            result.display();
        }
        /* 执行分发后的事件 */
        obj.release(router);

        /* 清空路由中的hash */
        obj.Router.InHash = null;
        /* 返回结果 */
        return result;
    };

    /* changeHash,处理当hash变化时候，调用alpaca */
    obj.changeHash = function () {
        obj.to(window.location.hash);
        obj.onHashChange();
    };

    /* 触发hash改变事件 */
    obj.onHashChange = function () {
        for (var index in this.HashChange) {
            this.HashChange[index]();
        }
    };

    /* 添加hash改变事件 */
    obj.addHashChangeEvent = function (func) {
        this['HashChange'].push(func);
    };

    /* 设置 onHashChange 事件 */
    window.onhashchange = obj.changeHash;

    /* 重命名-Alpaca */
    obj.reName = function () {
        return Alpaca;
    };

    /* 重命名-$ */
    obj.reNameJQuery = function (jquery) {
        obj.$ = jquery;
    };

    /* 以下是辅助函数 */

    /* 暂停 */
    obj.sleep = function (time) {
        for (var t = Date.now(); Date.now() - t <= time;) {
        }
    };

    /* 返回alpaca */
    return obj;
}();

/* Alpaca模块 */
Alpaca.AlpacaModule = {
    /* Alpaca控制器 */
    AlpacaController: {
        /* action没有找到 */
        actionNotFoundAction: function () {
            alert("The action is not found !");
        },
        /* controller没有找到 */
        controllerNotFoundAction: function () {
            alert("The controller is not found !");
        },
        /* module没有找到 */
        moduleNotFoundAction: function () {
            alert("The module is not found !");
        },
        /* index首页 */
        indexAction: function () {
            document.write('Welcome use Alpaca-spa 2.0 !');
        }
    }
};

/* 重命名view */
View = function (data) {
    return Alpaca.View(data);
};

/* 快捷视图模板渲染方法 */
Tpl = function (option) {
    Alpaca.Tpl(option);
};

/* 快捷方式调用Alpaca路由 */
To = function (path, data) {
    Alpaca.to(path, data);
};