<?php
ini_set('date.timezone','Asia/Shanghai');

require_once __DIR__."/../lib/AlpacaSSL.php";

$order= new \stdClass();
$order->txnAmt='1000';                       //付款金额 (分)
$order->orderId='10230120301230120321';      //订单编号
$order->orderName='PAY收款';                 //订单名称:
$order->merId='1';                           //商户号

$encrypt_data = AlpacaSSL::model()->encrypt($order);
$action = 'http://full.tkc8.com/ssl/client/decrypt.php';

?>
<html lang="zh_CN">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
</head>
<body>

<br/>
<form id="pay_form" name="pay_form" action="<?php echo $action;?>" method="post">
        <input type="hidden" name="data" id="data" value="<?php echo $encrypt_data;?>" />
</form>
<div class="zhifu-da"><a>订单编号号：<?php echo $order->orderId;?></a></div>
<div class="zhifu-da"><a>订单名称：<?php echo $order->orderName;?></a></div>
<div class="zhifu-da"><a>支付金额（分）：<?php echo $order->txnAmt;?></a></div>
<div class="zhifu-da"><a>订单创建时间：<?php echo date('Y-m-d H:i:s',time());?></a></div>
<div class="zhifu-da"><a>加密信息：<?php echo $encrypt_data; ?></a></div>
<a class="next-bu" href="#" onclick='javascript:document.pay_form.submit();'>加密通知客户端</a>



</body>
</html>









