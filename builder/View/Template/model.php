<?php

$output = '';
$output.="<?php \n";
$output.="namespace App\\Models;";
$output.=" \n\n";
$output.="use App\\Models\\Base\\BaseModel;";
$output.=" \n\n";
$output.="/** \n";
$output.=" * \n";
$output.=" * @author ChengCheng \n";
$output.=" * @date ".date('Y-m-d H:i:s')." \n";

$constFields = [];

foreach ($this->fields as $f)
{
    $output.=" * @property ".str_replace(' ', '', $f['db_type'])." ".$f['field']." '".$f['comment']."'' \n";

    if($f['in_type'] == 'enum'){
        $constField = [];
        foreach($f['in_enum'] as $enum){
            $constField[] = $enum['const'];
        }
        array_push($constFields,$constField);
    }

}

$output.=" */ \n";
$output.="class ".$this->className." extends BaseModel \n";
$output.="{ \n";
$output.="    // 数据表名字\n";
$output.="    protected \$table = \"".$this->tableName."\"; \n";
$output.="\n";

if(!empty($constFields)){
    $output.="    // 枚举字段";
    foreach($constFields as $consts){
        $output.="\n";
        foreach($consts as $const){
            $output.="    ".$const."\n";
        }
    }
    $output.="\n";
}


$output.="    /**\n";
$output.="     * 分页查询\n";
$output.="     * @author ChengCheng\n";
$output.="     * @date ".date('Y-m-d H:i:s')." \n";
$output.="     * @param string \$data\n";
$output.="     * @return array\n";
$output.="     */\n";
$output.="    public function getPageList(\$data)\n";
$output.="    {\n";
$output.="        //查询条件\n";
$output.="        \$query = \$this;";
$output.="        \n";
$output.="        //根据id查询\n";
$output.="        if (isset(\$data['id'])) {\n";
$output.="            \$query = \$query->where('id', \$data['id']);\n";
$output.="        //根据id查询\n";
$output.="        }\n";
$output.="        \n";
$output.="        //总数\n";
$output.="        \$total = \$query->count();\n";
$output.="        \n";
$output.="        //分页参数\n";
$output.="        \$pageSize = isset(\$data['pageSize']) ? \$data['pageSize'] : 0;\n";
$output.="        \$pageNum  = isset(\$data['pageNum']) ? \$data['pageNum'] : 1;\n";
$output.="        \$limit    = \$pageSize;\n";
$output.="        \$offset   = (\$pageNum - 1) * \$pageSize;\n";
$output.="        \n";
$output.="        //排序参数\n";
$output.="        if(!empty(\$data['orders'])){\n";
$output.="            foreach(\$data['orders'] as \$order){\n";
$output.="                \$query = \$query->orderBy(\$order[0],\$order[1]);\n";
$output.="            }\n";
$output.="        }else{\n";
$output.="            \$query = \$query->orderBy('id','desc');\n";
$output.="        }\n";
$output.="        \n";
$output.="        //分页查找\n";
$output.="        \$info = \$query->offset(\$offset)->limit(\$limit)->get();\n";
$output.="        \n";
$output.="        //返回结果，查找数据列表，总数\n";
$output.="        \$result          = array();\n";
$output.="        \$result['list']  = \$info->toArray();\n";
$output.="        \$result['total'] = \$total;\n";
$output.="        return \$result;\n";
$output.="    }\n";
$output.="}\n";
?>

<?php echo $output; ?>