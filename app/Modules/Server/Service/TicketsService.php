<?php
namespace App\Modules\Server\Service;

use App\Common\Visitor;
use App\Common\Wechat\WeChat;
use App\Common\Msg;
use App\Common\Code;
use App\Models\Ticket;
use App\Models\TicketOrder;
use App\Models\TicketOrderDeatil;
use App\Models\UserMember;
use App\Models\UserWx;
use Illuminate\Support\Facades\DB;

/**
 * TicketsService
 * @author Chengcheng
 * @date 2016-10-19 15:50:00
 */
class TicketsService
{
    /**
     * 生成订单
     * @author Chengcheng
     * @param array $request
     * @return array
     */
    public static function createOrder($request)
    {
        //1 生成订单 -订单表数据
        $order                = new TicketOrder();
        $order->buyer_id      = Visitor::user()->id;
        $order->reciver_name  = Visitor::user()->name;
        $order->reciver_phone = $request['mobile'];
        $order->sn            = date('YmdHis') . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT) . Visitor::user()->id;

        //DB::beginTransaction();
        $order->save();
        if (empty($order->id)) {
            $result["code"] = Code::SYSTEM_ERROR;
            $result["msg"]  = Msg::SYSTEM_ERROR;
            return $result;
        }

        $ticketIds = array_column($request['tickets'], null, 'id');
        $tickets   = Ticket::model()->whereIn('id', $ticketIds)->where('state',0)->lockForUpdate()->get()->toArray();
        if (count($ticketIds) != count($tickets)) {
            $result["code"] = Code::SYSTEM_ERROR;
            $result["msg"]  = Msg::SYSTEM_ERROR;
            return $result;
        }

        foreach ($tickets as $ticket) {
            $orderTicket               = new TicketOrderDeatil();
            $orderTicket->order_id     = $order->id;
            $orderTicket->ticket_id    = $ticket->id;
            $orderTicket->ticket_name  = $ticket->name;
            $orderTicket->ticket_label = $ticket->label;
            $orderTicket->area         = $ticket->area;
            $orderTicket->row          = $ticket->area;
            $orderTicket->column       = $ticket->column;
            $orderTicket->buy_time     = Visitor::user()->time;
            $orderTicket->save();
        }

        $data= [];
        $data['order_id'] = $order->id;

        //4 返回结果
        $result["code"] = Code::SYSTEM_ERROR;
        $result["msg"]  = Msg::SYSTEM_ERROR;
        $result["data"]  = $data;
        return $result;
    }
}
