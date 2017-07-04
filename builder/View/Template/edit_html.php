<script type="text/javascript" src="{{= g_baseUrl}}main/assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="{{= g_baseUrl}}common/js/md5-min.js"></script>
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">XXX管理</span> - 编辑XX</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a><i class="icon-home2 position-left"></i> XXX管理</a></li>
            <li class="active">编辑XX</li>
        </ul>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <!-- Basic responsive configuration -->
    <form id="<?php echo $this->className; ?>-edit">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h5 class="panel-title">编辑XXX<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label>ID:</label>
                            <input type="text" class="form-control" placeholder="id" name="id" readonly>
                        </div>
<?php foreach($this->fields as $f): ?>
<?php if($f['field'] == 'id'){ continue; } ?>
 <?php if($f['in_type'] == 'string'){ ?>
                        <div class="form-group">
                            <label><?php echo $f['in_name']; ?>:</label>
                            <input type="text" class="form-control" placeholder="请输入<?php echo $f['in_name']; ?>" name="<?php echo $f['field']; ?>">
                        </div>
<?php }elseif($f['in_type'] == 'enum'){?>
                        <div class="form-group">
                            <label><?php echo $f['in_name']; ?>:</label>
                            <select multiple="multiple" class="select" name="<?php echo $f['field']; ?>">
<?php foreach($f['in_enum'] as $e): ?>
                            <option value="<?php echo $e['value']; ?>"><?php echo $e['label']; ?></option>
<?php endForeach; ?>
                            </select>
                        </div>
<?php }?>
<?php endForeach; ?>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" onclick="submit<?php echo $this->className; ?>()"><i class="icon-checkmark3 position-left"></i>保存</button>
                            <button type="button" class="btn btn-default" onclick="cancel()"><i class="icon-undo position-left"></i>取消</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- /basic responsive configuration -->
    <!-- Footer -->
    <div id="page-content-footer"></div>
    <!-- /footer -->
</div>
<!-- /content area -->
<script>

    /* 填充表单 */
    var fill<?php echo $this->className; ?> = function (data) {
<?php foreach($this->fields as $f): ?>
        $('#<?php echo $this->className; ?>-edit input[name ="<?php echo $f['field'];?>"]').val(data.<?php echo $f['field']; ?>);
<?php endForeach; ?>
    };


    /* 提交表单 */
    var submit<?php echo $this->className; ?> = function () {
        var request  = {};
        request.id = $('#<?php echo $this->className; ?>-edit input[name ="id"]').val();
<?php foreach($this->fields as $f): ?>
<?php if($f['field'] == 'id'){ continue; } ?>
        request.<?php echo $f['field']; ?> = $('#<?php echo $this->className; ?>-edit input[name ="<?php echo $f['field']; ?>"]').val();
<?php endForeach; ?>

        AlpacaAjax({
            url: g_url + API['XXX_edit'],
            data: request,
            async: false,
            success: function (data) {
                console.log(data);
                Notific(data.msg);
                if(data.code == 9900){
                    Alpaca.to("#/XXX");
                }
            },
        });
    };

    /* 取消 */
    var cancel = function () {
        Alpaca.to("#/XXX");
    }

</script>













