<?php

/**
 * WeTrade
 * @author Chengcheng
 * @date 2016-11-08 15:50:00
 */
class WxTrade
{

    //微信相关配置
    public $config = [];

    /**
     * 微信支付相关单例，用于微信支付相关操作
     * @author Chengcheng
     * @date 2016年11月5日 14:47:40
     * @param array $orderArray
     * @param string $openId
     * @return string
     */
    public function getJsPay($orderArray,$openId)
    {
        $order = new WxPaymentDataOrder();
        $order->setAttribute('body', '美奢商城-支付');
        $order->setAttribute('trade_type', WxPaymentDataOrder::TRADE_TYPE_JSAPI);

        $good = new WxPaymentGoodData();
        $good->setAttribute('goods_id', 'iphone6s_16G');
        $good->setAttribute('wxpay_goods_id', '1111');
        $good->setAttribute('goods_name', 'iPhone6s 16G');
        $good->setAttribute('quantity', 1);
        $good->setAttribute('price', 1);
        $good->setAttribute('goods_category', "123456");
        $good->setAttribute('body', "苹果手机");

        //$order->setGoods(array($good));

        $order->setAttribute('out_trade_no', $orderArray['paySn']);
        $order->setAttribute('total_fee', $orderArray['FOrderAmount']);
        $order->setAttribute('notify_url', Mod::app()->homeUrl . '/shop/order/wx-notify');
        $order->setAttribute('openid', $openId);
        $result = WxPaymentApi::order($order);
        $pre_id = $result['prepay_id'];
        $jsApi  = new WxPaymentDataJsApi($pre_id);
        return $jsApi->getJsPayArray();
    }
}
