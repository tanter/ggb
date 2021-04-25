

var __socket = {
    ws_url: 'wss://api.huobi.pro/ws',
    //['eosusdt', 'ethusdt', 'ltcusdt', 'bchusdt', 'etcusdt', 'xrpusdt', 'btcusdt'],
    symbols: {
        eosusdt: 'EOS/USDT',
        ethusdt: 'ETH/USDT',
        ltcusdt: 'LTC/USDT',
        bchusdt: 'BCH/USDT',
        etcusdt: 'ETC/USDT',
        xrpusdt: 'XRP/USDT',
        btcusdt: 'BTC/USDT'
    },
    // periods : ['1min', '5min', '15min', '30min', '60min', '1day', '1week'],
    // type: 'step1',  // step0, step1, step2, step3, step4, step5
    // period: '1min',
    wss: null,
    /**
    // market_depth 买10 卖10
    // daymarket 最新行情
    // match_trade 当前交易
    */
    typeObj: {
        kline: 'kline',
        detail: 'daymarket',
        trade: 'match_trade',
        depth: 'market_depth'
    },
    events: {},
    init: function () {
        this.init = {}
    },
    ffff: function(v) {
        return parseFloat(v).toFixed(4)
    },
    create: function () {
        var that = this
        var wss = this.wss = new WebSocket(this.ws_url);
        console.log('create')
        wss.onopen = function () {
            console.log('open')
            that.setSub('1min')
        }
        wss.onmessage = function (data) {
            that.blob(data, function (msg) {
                if (msg.ping) {
                    wss.send(JSON.stringify({
                        pong: msg.ping
                    }));
                } else if (msg.tick) {
                    var chs = msg.ch.split('.')
                    var type = that.typeObj[chs[2]]
                    var period = chs[3]
                    var symbol = that.symbols[chs[1]];
                    switch (chs[2]) {
                        // k 线图
                        case 'kline':
                            msg.tick.time = msg.tick.id * 1000
                            msg.tick.volume = msg.tick.vol
                            msg.tick.type = type
                            msg.tick.period = period
                            msg.tick.symbol = symbol
                            that.events[type] && that.events[type](msg.tick)
                            break;
                        // 当前交易
                        case 'trade':
                            msg.tick.type = type
                            msg.tick.symbol = symbol
                            that.events[type] && that.events[type](msg.tick)
                            break;
                        // 买10 卖10
                        case 'depth':
                            msg.tick.type = type
                            msg.tick.symbol = symbol
                            msg.tick.asks.length = 10
                            msg.tick.bids.length = 10
                            that.events[type] && that.events[type](msg.tick)
                            break;
                        case 'detail':
                            msg.tick.type = type
                            msg.tick.symbol = symbol
                            msg.tick.currency_name = symbol.split('/')[0]
                            msg.tick.now_price = msg.tick.close

                            msg.tick.volume = that.ffff(msg.tick.vol)
                            msg.tick.change = that.ffff((msg.tick.close - msg.tick.open) / msg.tick.open * 100)
                            that.events[type] && that.events[type](msg.tick)
                            break;
                        default:
                            break;
                    }
                } else {
                    console.log(msg);
                }
            })
        };
        wss.onerror = function () {
            console.log('onerror')
            that.create()
        }
    },
    // 建立订阅
    // sub 订阅
    // unsub 取消订阅
    setSub: function (period) {
        this.__setSub('unsub', period)
        this.__setSub('sub', period)
    },
    // market_depth 买10 卖10
    // daymarket 最新行情
    // match_trade 当前交易
    on: function (evt, callback) {
        this.events[evt] = callback
    },
    __setSub: function (key, period) {
        var arr = []
        for (var symbol in this.symbols) {
            arr.push({
                [key]: `market.${symbol}.kline.${period}`,
                "id": 'k_line_id'
            })
            arr.push({
                [key]: `market.${symbol}.trade.detail`,
                "id": 'trade_id'
            })
            arr.push({
                [key]: `market.${symbol}.depth.step1`,
                "id": 'depth_id'
            })
            arr.push({
                [key]: `market.${symbol}.detail`,
                "id": 'detail_id'
            })
        }
        var that = this
        arr.forEach(function (o) {
            that.wss.send(JSON.stringify(o))
        })
    },
    blob: function (evt, callback) {
        if (evt.data instanceof Blob) {
            let result = '';
            let reader = new FileReader(); //FileReader：从Blob对象中读取数据
            reader.onload = function () {
                result = JSON.parse(pako.inflate(reader.result, { to: 'string' }));
                callback(result)
            }
            reader.readAsBinaryString(evt.data);//将返回的数据解析为字符串格式
        }
    }
}
