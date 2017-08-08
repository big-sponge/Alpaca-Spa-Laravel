<script>
<?php foreach($this->fields as $f): ?>
<?php if($f['in_type'] == 'enum'){ ?>
    var enum_<?php echo $f['field']; ?> = function(value){
<?php foreach($f['in_value'] as $e): ?>
        if(value == '<?php echo $e['value']; ?>'){
            return "<?php echo $e['label']; ?>";
        }
<?php endForeach; ?>
    };
<?php } ?>
<?php endForeach; ?>
</script>


<table class="table table-togglable table-hover">
    <thead>
    <tr>
        <!--<th data-toggle="true">编号</th>-->
        <!-- <th data-hide="phone,tablet">描述</th>-->
<?php foreach($this->fields as $f): ?>
        <th data-hide=""><?php echo $f['in_name']; ?></th>
<?php endForeach; ?>
        <th data-hide="">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php echo "<?spa foreach(it.list as key => item): ?>\n" ?>
        <tr>
<?php foreach($this->fields as $f): ?>
<?php if($f['in_type'] == 'string'){ ?>
           <td>{{= item.<?php echo $f['field']; ?> }}</td>
<?php }else{ ?>
           <td>{{ var enum_text = enum_<?php echo $f['field']; ?>(item.<?php echo $f['field']; ?>); }} {{= enum_text }}</td>
<?php } ?>
<?php endForeach; ?>
            <td>
                <button type="button" class="btn btn-default btn-xs" onclick='edit<?php echo $this->className; ?>("{{= item.id }}")'><i class="icon-hat position-left"></i>编辑</button>
                <button type="button" class="btn btn-default btn-xs" onclick='delete<?php echo $this->className; ?>("{{= item.id }}")'><i class="icon-cross2 position-left"></i>删除</button>
            </td>
        </tr>
    <?php echo "<?spa endForeach; ?>\n" ?>
    </tbody>
</table>

<script>
    var edit<?php echo $this->className; ?> = function(id){
        Alpaca.to("#/main/<?php echo $this->classNameLc ?>/<?php echo $this->classNameLc ?>EditView/"+id,{id:id});
    };

    var delete<?php echo $this->className; ?>= function(id){
        var param = {
            id: id,
            url: API['<?php echo $this->classNameLc ?>_delete'],
            callback: function () {
                Alpaca.to("#/main/<?php echo $this->classNameLc ?>/<?php echo $this->classNameLc ?>ListView");
            }
        };
        Alpaca.to("#/main/index/delete/" + id, param);
    };

</script>
