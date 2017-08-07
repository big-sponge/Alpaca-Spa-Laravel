<script type="text/javascript" src="{{= g_baseUrl}}main/assets/js/plugins/tables/footable/footable.min.js"></script>
<script type="text/javascript" src="{{= g_baseUrl}}main/assets/js/plugins/forms/styling/switchery.min.js"></script>
<script type="text/javascript" src="{{= g_baseUrl}}main/assets/js/plugins/ui/moment/moment.min.js"></script>
<script type="text/javascript" src="{{= g_baseUrl}}main/assets/js/plugins/pagination/bs_pagination.min.js"></script>
<script type="text/javascript" src="{{= g_baseUrl}}main/assets/js/plugins/pagination/datepaginator.min.js"></script>
<script type="text/javascript" src="{{= g_baseUrl}}main/assets/js/plugins/notifications/sweet_alert.min.js"></script>

<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">XX管理</span> - XX列表</h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a><i class="icon-home2 position-left"></i> XX管理</a></li>
            <li class="active">XX列表</li>
        </ul>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <!-- Basic responsive configuration -->
    <div class="panel panel-flat" id="<?php echo $this->classNameLc; ?>-list-view">
        <div class="panel-heading">
            <button type="button" class="btn btn-primary" onclick='Alpaca.to("#/main/<?php echo $this->classNameLc; ?>/<?php echo $this->classNameLc; ?>EditView")'><i class="icon-diff-added position-left"></i> 添加XX</button>
        </div>
        <div class="datatable-header">
            <div class="dataTables_filter">
                <input type="text" class="" placeholder="查找." id="table-page-key">
                <button type="button" class="btn btn-primary" style="vertical-align: top" id="table-page-search"><i class="icon-search4 position-left"></i>查找</button>
            </div>

            <div class="dataTables_length">
                <span>每页:</span>
                <select style="height: 36px; border: 1px solid #ddd;" name ="table-page-size" >
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <div class="page-table-body"></div>
        <div class="datatable-footer">
            <div class="dataTables_info">
                <span name="table-page-info">显示 1 到 10 共 15 行</span>
            </div>
            <div class="dataTables_paginate">
                <input type="hidden" name ="table-page-num">
                <ul class="pagination-flat pagination-sm table-pagination"></ul>
            </div>
        </div>
    </div>
    <!-- /basic responsive configuration -->
    <!-- Footer -->
    <div id="page-content-footer"></div>
    <!-- /footer -->
</div>
<!-- /content area -->