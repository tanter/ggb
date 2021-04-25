<?php
namespace app\api\controller;


class News extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getList()
    {
        $c_id = input('c_id');
        if($c_id == 4){
            $data = '{"type":"ok","message":{"list":[{"id":60,"c_id":4,"lang":"hk","title":"BTC360\u6578\u5b57\u8cc7\u7522\u4ea4\u6613\u5e73\u81fa\u5546\u5bb6\u5165\u99d0\u516c\u544a","thumbnail":"https://huobi-1253283450.file.myqcloud.com/bit/banner/e82e0ec4-e43b-436f-8464-27418899a687.jpg","cover":"https://huobi-1253283450.file.myqcloud.com/bit/banner/e82e0ec4-e43b-436f-8464-27418899a687.jpg","sorts":0},{"id":59,"c_id":4,"lang":"hk","title":"\u95dc\u65bcBTC360\u6578\u5b57\u8cc7\u7522\u4ea4\u6613\u5e73\u81fa\u4e0a\u7dda\u516c\u544a","thumbnail":"https://huobi-1253283450.file.myqcloud.com/bit/banner/e82e0ec4-e43b-436f-8464-27418899a687.jpg","cover":"https://huobi-1253283450.file.myqcloud.com/bit/banner/e82e0ec4-e43b-436f-8464-27418899a687.jpg","sorts":0}],"count":2,"page":1,"limit":15}}';
        }else if($c_id ==5){
            $data = '{"type":"ok","message":{"list":[{"id":39,"c_id":5,"lang":"hk","title":"One","thumbnail":"https://huobi-1253283450.file.myqcloud.com/bit/banner/e82e0ec4-e43b-436f-8464-27418899a687.jpg","cover":"https://huobi-1253283450.file.myqcloud.com/bit/banner/e82e0ec4-e43b-436f-8464-27418899a687.jpg","sorts":3},{"id":40,"c_id":5,"lang":"hk","title":"Two","thumbnail":"https://huobi-1253283450.file.myqcloud.com/bit/banner/e82e0ec4-e43b-436f-8464-27418899a687.jpg","cover":"https://huobi-1253283450.file.myqcloud.com/bit/banner/e82e0ec4-e43b-436f-8464-27418899a687.jpg","sorts":2},{"id":41,"c_id":5,"lang":"hk","title":"Three","thumbnail":"https://huobi-1253283450.file.myqcloud.com/bit/banner/e82e0ec4-e43b-436f-8464-27418899a687.jpg","cover":"https://huobi-1253283450.file.myqcloud.com/bit/banner/e82e0ec4-e43b-436f-8464-27418899a687.jpg","sorts":1}],"count":3,"page":1,"limit":15}}';
        }
        return self::j($data);
    }
    public function detail()
    {
        $data = '{"type":"ok","message":{ "title":"隐私","content":"内容" }}';
        return self::j($data);
    }
}
