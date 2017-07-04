<?php

$output = '';
$output.="    /**\n";
$output.="     * 列表\n";
$output.="     * @author ChengCheng\n";
$output.="     * @date ".date('Y-m-d H:i:s')." \n";
$output.="     * @return array\n";
$output.="     */\n";
$output.="    public function get".$this->className."List()\n";
$output.="    {\n";
$output.="        /*\n";
$output.="         * 1 获取输入参数\n";
$output.="         * pageNum              页码\n";
$output.="         * pageSize             页面大小\n";
$output.="         * orders               排序，数组结构，支持多维度排序\n";
$output.="         * id                   ID\n";
$output.="         * */\n";
$output.="        \$this->requestData['pageNum']   = \$this->input('pageNum', null);\n";
$output.="        \$this->requestData['pageSize']  = \$this->input('pageSize', null);\n";
$output.="        \$this->requestData['orders']    = \$this->input('orders', null);\n";
$output.="        \$this->requestData['id']        = \$this->input('id', null);\n";
$output.="        \n";
$output.="        //2 查找信息\n";
$output.="        \$data = ".$this->className."::model()->getPageList(\$this->requestData);\n";
$output.="        \n";
$output.="        //3 设置返回结果\n";
$output.="        \$result['code'] = Code::SYSTEM_OK;\n";
$output.="        \$result['msg']  = Msg::SYSTEM_OK;\n";
$output.="        \$result['data'] = \$data;\n";
$output.="        \n";
$output.="        //4 返回结果\n";
$output.="        return \$this->ajaxReturn(\$result);\n";
$output.="    }\n";
$output.="\n";
$output.="\n";
$output.="\n";


$output.="    /**\n";
$output.="     * 编辑\n";
$output.="     * @author ChengCheng\n";
$output.="     * @date ".date('Y-m-d H:i:s')." \n";
$output.="     * @return array\n";
$output.="     */\n";
$output.="    public function dit".$this->className."List()\n";
$output.="    {\n";
$output.="        /*\n";
$output.="         * 1 获取输入参数\n";

foreach($this->fields as $f){
$output.="         * ".str_pad($f['field'],20)."".$f['comment']."\n";
}
$output.="         * */\n";
foreach($this->fields as $f){
$output.="        ".str_pad("\$this->requestData['".$f['field']."']",40)."= \$this->input('".$f['field']."', null);\n";
}
$output.="        \n";
$output.="        //2 编辑信息\n";
$output.="        \$result = ".$this->className."::model()->edit(\$this->requestData);\n";
$output.="        \n";
$output.="        //3 返回结果\n";
$output.="        return \$this->ajaxReturn(\$result);\n";
$output.="    }\n";
?>

<?php echo $output; ?>