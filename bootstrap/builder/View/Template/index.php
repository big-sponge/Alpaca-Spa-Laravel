<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>Alpaca - Builder</title>
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.min.css">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
    <style>
        .line-right {
            text-align: right;
        }
    </style>
</head>
<body ontouchstart>
<div class="page-group">
    <div class="page page-current">
        <!-- 你的html代码 -->
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left" href="" data-transition='slide-out'>
                <span class="icon icon-left"></span>
                返回
            </a>
            <h1 class="title">Alpaca-Builder</h1>
        </header>
        <nav class="bar bar-tab">
            <a class="tab-item active" href="#">
                <span class="icon icon-home"></span>
                <span class="tab-label">首页</span>
            </a>
            <a class="tab-item" href="#">
                <span class="icon icon-me"></span>
                <span class="tab-label">我</span>
            </a>
            <a class="tab-item" href="#">
                <span class="icon icon-settings"></span>
                <span class="tab-label">设置</span>
            </a>
        </nav>
        <div class="content">
            <form action="/builder/create/builder" id="sub-form">
                <div class="content-block-title">配置</div>
                <div class="list-block">
                    <ul>
                        <!-- Text inputs -->
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-name"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">数据表名称</div>
                                    <div class="item-input">
                                        <input type="text" placeholder="请输入数据表名称" name="table_name">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-email"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">表名前缀</div>
                                    <div class="item-input">
                                        <input type="text" placeholder="E-mail" value="tb_" name="table_prefix">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-email"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">中文名称</div>
                                    <div class="item-input">
                                        <input type="text" placeholder="中文名称" value="" name="table_name_cn">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-email"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">二级模块</div>
                                    <div class="item-input">
                                        <input type="text" placeholder="二级模块" value="" name="sub_module_name">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-email"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">后端模块</div>
                                    <div class="item-input">
                                        <input type="text" placeholder="后端模块" value="manage" name="b_module_name">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-email"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">前端模块</div>
                                    <div class="item-input">
                                        <input type="text" placeholder="前端模块" value="admin" name="f_module_name">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="content-block-title">后端</div>
                <div class="list-block">
                    <ul>
                        <!-- Switch (Checkbox) -->
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-toggle"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">生成Model</div>
                                    <div class="item-input line-right">
                                        <label class="label-switch">
                                            <input type="checkbox" checked name="is_init_model">
                                            <div class="checkbox"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-toggle"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">生成Controller</div>
                                    <div class="item-input line-right">
                                        <label class="label-switch">
                                            <input type="checkbox" checked name="is_init_b_controller">
                                            <div class="checkbox"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-toggle"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">配置Router</div>
                                    <div class="item-input line-right">
                                        <label class="label-switch">
                                            <input type="checkbox" checked name="is_init_b_router">
                                            <div class="checkbox"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="content-block-title">前端</div>
                <div class="list-block">
                    <ul>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-toggle"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">List页面</div>
                                    <div class="item-input line-right">
                                        <label class="label-switch">
                                            <input type="checkbox" checked name="is_init_list">
                                            <div class="checkbox"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-toggle"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">Edit页面</div>
                                    <div class="item-input line-right">
                                        <label class="label-switch">
                                            <input type="checkbox" checked name="is_init_edit">
                                            <div class="checkbox"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-toggle"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">前端Controller</div>
                                    <div class="item-input line-right">
                                        <label class="label-switch">
                                            <input type="checkbox" checked name="is_init_f_controller">
                                            <div class="checkbox"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-toggle"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">配置接口url</div>
                                    <div class="item-input line-right">
                                        <label class="label-switch">
                                            <input type="checkbox" checked name="is_init_inter">
                                            <div class="checkbox"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="content-block-title">自动复制到对应目录</div>
                <div class="list-block">
                    <ul>
                        <li>
                            <div class="item-content">
                                <div class="item-media"><i class="icon icon-form-toggle"></i></div>
                                <div class="item-inner">
                                    <div class="item-title label">复制到对应目录</div>
                                    <div class="item-input line-right">
                                        <label class="label-switch">
                                            <input type="checkbox" checked name="is_auto_copy">
                                            <div class="checkbox"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="content-block">
                    <div class="row">
                        <div class="col-50"><a href="#" class="button button-big button-fill button-danger">取消</a></div>
                        <div class="col-50"><a href="#" class="button button-big button-fill button-success" onclick="submit()">提交</a></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var submit = function () {
        $('#sub-form').submit();
    }
</script>
</body>
</html>




