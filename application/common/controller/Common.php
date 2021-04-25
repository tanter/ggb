<?php
namespace app\common\controller;
use think\Controller;

use PHPExcel;
use PHPExcel_IOFactory;

class Common extends Controller
{
    protected $excelWidth = 20;// 默认excel宽度
    protected $excelHeight = 20;// 默认excel高度

    //跨域
    public function __construct()
    {
        parent::__construct();
        //header("Access-Control-Allow-Origin:*");
        //header('Access-Control-Allow-Methods:POST');
        //header('Access-Control-Allow-Headers:x-requested-with, content-type');
//        header('Access-Control-Allow-Origin:*');
//        header('Access-Control-Allow-Methods:*');
//        header('Access-Control-Allow-Headers:*');
//        header('Access-Control-Allow-Credentials:false');
    }
        /**创建日期
     * @return false|string
     */
    public static function getDate($str='Y-m-d H:i:s')
    {
        return date($str, time());
    }
    // 获取今日时间字符串
    public static function today_time_stamp()
    {
        return strtotime(self::getDate('Y-m-d'));
    }
    // 获取昨天时间戳
    public static function yesterday_time_stamp()
    {
        return strtotime("-1 day");
    }
    public static function getWallet($condition, $create=false)
    {
        $wallet = db('user_wallet')->where($condition)->find();
        if($create){
            $condition['add_time'] = self::getDate();
            $id = db('user_wallet')->insertGetId($condition);
            $wallet = db('user_wallet')->where(['id'=>$id])->find();
        }
        return $wallet;
    }
    public function params()
    {
        $params = $this->request->param();
        unset($params['token']);
        unset($params['path']);
        return $params;
    }   
    /**
     * 参数验证
     * @param array $opts
     * @param $scene
     */
    public static function verify($opts, $scene)
    {
        $validate = validate('Data');
        if ($validate->scene($scene)->check($opts) !== true) {
            echo json_encode(['code'=>2,'message'=>$validate->getError()]);
            exit;
        }
    }
    // 随机字符串
    public static function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    // 获取管理员ID
    public static function get_admin_id($token)
    {
        return db('admin')->where(['token'=>$token,'status'=>1])->value('id');
    }
    // 获取token值
    public static function get_token($id)
    {
        $str = md5(uniqid(md5(microtime(true)), true));
        $str = sha1($str . $id);
        return $str;
    }
    //返回JSON
    public static function json($code=0, $data=[], $message=null, $time=null) {
        if (is_array($code)){
            return json($code);
        }else{  
            return json(self::jsonArr($code, $data, $message, $time));
        }
    }

    public static function jsonArr($code=0, $data=[], $message=null, $time=null)
    {
        $event = request()->path();
        return ['code'=>$code, 'data'=>$data, 'message'=>$message, 'time'=>$time, 'event'=>$event];
    }
    // 保留两位小数
    public static function round($num, $r=2){
        return sprintf("%.".$r."f",$num);
    }
    // 上传图片
    public static function upload_img($config=[])
    {
        if(!is_array($config))$config = [];
        if(!isset($config['file'])) $config['file'] = 'file';
        if(!isset($config['exts'])) $config['exts'] = array('png', 'jpg', 'jpeg', 'gif', 'PNG', 'JPG', 'JPEG', 'GIF');
        if(!isset($config['size'])) $config['size'] = 1024 * 1024 * 5;
        if(!isset($config['fileClassify'])) $config['fileClassify'] = 'uploads';

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($config['file']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $ds = '/';
        $info = $file->validate(['size'=>$config['size'], 'ext'=>join(',', $config['exts'])])->rule('uniqid')->move('.'. $ds . $config['fileClassify'],true,false);
        if($info){
            $filename = $info->getSaveName();
            $path = $ds.$config['fileClassify'].$ds.$filename;
            $url = request()->domain().$path;
            return self::jsonArr(0,['url'=>$url, 'path'=>$path]);
        }else{
            // 上传失败获取错误信息
          return self::jsonArr(1,null, $file->getError());
        }
    }
     /**
     * 生成excel表格数据
     * @param array $list
     * @param array $param ['id'=>['编号',20],'name'=>['姓名',20]] 标题+宽度
     * @param string $title excel 表格标题
     * @param array $del ['state'] 需要删除的字段
     * @param int $height
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public function createExcel($list=[],$param=[],$title='',$del=[], $height=0,$path=false)
    {
        if(is_object($list)) $data = $list->toArray()['data'];
        else $data = $list;
        if(empty($param))$param = array_keys($data[0]);

        if(empty($height))$height = $this->excelHeight;

        // vendor('phpexcel.PHPExcel');//调用类库,路径是基于vendor文件夹的
        // vendor('phpexcel.PHPExcel.Worksheet.Drawing');
        // vendor('phpexcel.PHPExcel.Writer.Excel2007');
        $objExcel = new \PHPExcel();
        $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
        if(!empty($data)){
            $objActSheet = $objExcel->getActiveSheet();
            $letter = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            $i = 0;
            $arr = [];
            foreach ($param as $key=>$value){
                if(in_array($key,$del))continue;

                if(is_string($value)){
                    $param[$key] = [$value,$this->excelWidth];
                }else{
                    if(!isset($param[$key][0]))$param[$key][0] = $key;
                    if(!isset($param[$key][1]))$param[$key][1] = $this->excelWidth;
                }

                //设置表格宽度
                $objActSheet->getColumnDimension($letter[$i])->setWidth($param[$key][1]);
                //填充表头信息
                $objActSheet->setCellValue("$letter[$i]1",$param[$key][0]);

                $arr[$i] = $key;
                $i++;
            }

            //填充表格信息
            foreach($data as $index => $item) {
                $index += 2;
                $j=0;
                foreach ($arr as $a){
                    $objActSheet->setCellValueExplicit($letter[$j] . $index, $item[$a],\PHPExcel_Cell_DataType::TYPE_STRING);
                    $j++;
                }
                $objActSheet->getRowDimension($index)->setRowHeight($height);
            }
        }
        $outfile = $title.date('YmdHis', time()).rand(100,999).".xlsx";
        if($path){
            $objWriter->save('excel/'.$outfile);
            return request()->domain().'/excel/'.$outfile;
        }else{
            ob_end_clean();
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header('Content-Disposition:inline;filename="'.$outfile.'"');
            header("Content-Transfer-Encoding: binary");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: no-cache");
            $objWriter->save('php://output');
        }
    }
  
      // 阿里云人脸识别
    public static function aliyun_face_recognition($image_url, $bool = true)
    {
        try{
            header("content-type:text/html;charset=utf-8");
            $akId = 'LTAIIBCxuCyW6qPZ';
            $akSecret = 'N951pDlM74O3o5JO6bViCZpfGIzEpF';
            //更新api信息
            //官方API   https://help.aliyun.com/knowledge_detail/53399.html
            $url = "https://dtplus-cn-shanghai.data.aliyuncs.com/face/detect";
            $rq_data['type']=0;
            $rq_data['image_url'] = $bool ? $image_url : 'http://imgsrc.baidu.com/imgad/pic/item/38dbb6fd5266d01671f6f0dc9d2bd40734fa3552.jpg';

            //$rq_data['type']=1;
            //$rq_data['content']='data:image/jpeg;base64,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';

            $options = array(
                'http' => array(
                    'header' => array(
                        'accept'=> "application/json",
                        'content-type'=> "application/json",
                        'date'=> gmdate("D, d M Y H:i:s \G\M\T"),
                        'authorization' => ''
                    ),
                    'method' => "POST", //可以是 GET, POST, DELETE, PUT
                    'content' => json_encode($rq_data) //如有数据，请用json_encode()进行编码
                )
            );
            $http = $options['http'];
            $header = $http['header'];
            $urlObj = parse_url($url);
            if(empty($urlObj["query"]))
                $path = $urlObj["path"];
            else
                $path = $urlObj["path"]."?".$urlObj["query"];
            $body = $http['content'];
            if(empty($body))
                $bodymd5 = $body;
            else
                $bodymd5 = base64_encode(md5($body,true));
            $stringToSign = $http['method']."\n".$header['accept']."\n".$bodymd5."\n".$header['content-type']."\n".$header['date']."\n".$path;
            $signature = base64_encode(
                hash_hmac(
                    "sha1",
                    $stringToSign,
                    $akSecret, true));
            $authHeader = "Dataplus "."$akId".":"."$signature";
            $options['http']['header']['authorization'] = $authHeader;
            $options['http']['header'] = implode(
                array_map(
                    function($key, $val){
                        return $key.":".$val."\r\n";
                    },
                    array_keys($options['http']['header']),
                    $options['http']['header']));
            $context = stream_context_create($options);
            $file = file_get_contents($url, false, $context );
            return self::jsonArr(0, json_decode($file, true));
        }catch(Exception $e){
            return self::jsonArr(1, $e->getMessage());
        }
    }
    // 发送短信验证码
    public static function send_sms($phone, $code){
        $aliyun = new AliyunSms();
        return $aliyun->aliyunSendSms($phone, $code);
    }
     /**
     * [idenDist 身份证识别，官网：https://market.aliyun.com/products/57124001/cmapi010401.html]
     * @param  [type] $host    [description]
     * @param  [type] $path    [description]
     * @param  [type] $method  [description]
     * @param  [type] $appcode [购买提供的code]
     * @return [array]          [查看网官返回结果]
     */
    public static function idenDist($imageSrc, $side)
    {
        if (!file_exists($imageSrc)) return ['code'=>false, 'message'=>'身份证图片文件不存在'];

        // 身份证识别
        $url = "https://dm-51.data.aliyun.com/rest/160601/ocr/ocr_idcard.json";
        $appcode = "5cfdd1c9cabf45748be916b9e724020a";
        $file = $imageSrc;
        //如果输入带有inputs, 设置为True，否则设为False
        $is_old_format = false;
        //如果没有configure字段，config设为空
        $config = array(
            "side" => $side
        );
        if($fp = fopen($file, "rb", 0)) {
            $binary = fread($fp, filesize($file)); // 文件读取
            fclose($fp);
            $base64 = base64_encode($binary); // 转码
        }
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
        $querys = "";
        if($is_old_format == TRUE){
            $request = array();
            $request["image"] = array(
                "dataType" => 50,
                "dataValue" => "$base64"
            );
            if(count($config) > 0){
                $request["configure"] = array(
                    "dataType" => 50,
                    "dataValue" => json_encode($config)
                );
            }
            $body = json_encode(array("inputs" => array($request)));
        }else{
            $request = array(
                "image" => "$base64"
            );
            if(count($config) > 0){
                $request["configure"] = json_encode($config);
            }
            $body = json_encode($request);
        }
        $method = "POST";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$url, "https://")){
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        $result = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $rheader = substr($result, 0, $header_size);
        $rbody = substr($result, $header_size);
        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        if($httpCode == 200){
            if($is_old_format){
                $output = json_decode($rbody, true);
                $result_str = $output["outputs"][0]["outputValue"]["dataValue"];
            }else{
                $result_str = $rbody;
            }
            $result = json_decode($result_str, true);
            return $result;
        }else{
            if($side != 'back'){
                return ['success'=>false, 'message'=>'正面未认识成功，请手动认证'];
            }else{
                return ['success'=>false, 'message'=>'反面未认识成功，请手动认证'];
            }
        }
    }
    /**
     * [idenAuth 身份证认证，官网：https://market.aliyun.com/products/57000002/cmapi028815.html#sku=yuncode2281500001]
     * @param  [type] $idCardNum [身份证件号]
     * @param  [type] $realName  [身份证姓名]
     * @param  [type] $appcode   [购买提供的code]
     * @return [type]            [查看网官返回结果]
     */
    public static function idenAuth($idCardNum, $realName)
    {
        $host = "https://simpleinfo.market.alicloudapi.com";
        $path = "/simple";
        $method = "POST";
        $appcode = "5cfdd1c9cabf45748be916b9e724020a";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8");
        $querys = "";
        $bodys = "idCardNum=".$idCardNum."&realName=".$realName;
        $url = $host . $path;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
        // 返回结果
        $result = curl_exec($curl);
        // 结果转对象 $result->code 获取
        $result = json_decode($result);
        return $result;
    }

    protected  function timeInit($starttime=null,$endtime=null)
    {
        if(empty($starttime)) $starttime = '2019-01-01 00:00:00';
        if(empty($endtime)) $endtime = '2099-01-01 00:00:00';

        if($starttime>$endtime){
            $temp = $starttime;
            $starttime = $endtime;
            $endtime = $temp;
        }
        if($starttime==$endtime){
            $starttime.= ' 00:00:00';
            $endtime.= ' 23:59:59';
        }
        if(strlen($starttime)<11)$starttime.=' 00:00:00';
        if(strlen($endtime)<11)$endtime .=' 23:59:59';
        return [$starttime,$endtime];
    }
    private function createInvitationCodeSourceString()
    {
        return 'uZpFh5QivwLiVSpua8F2giH2sa5mllwoBVZW5WvlTNiPZWrugmecNBqZyvKsk48u';
    }
    // id生成邀请码
    protected function create_invitation_code($user_id) {
        $source_string = $this->createInvitationCodeSourceString();
        $num = $user_id;
        $code = '';
        while ( $num > 0) {
            $mod = $num % 35;
            $num = ($num - $mod) / 35;
            $code = $source_string[$mod].$code;
        }

        if(empty($code[3]))
            $code = str_pad($code,4,'0',STR_PAD_LEFT);
        return $code;
    }
    // 邀请码反推ID
    protected function decode_invitation_code($code) {

        $source_string = $this->createInvitationCodeSourceString();

        if (strrpos($code, '0') !== false)

            $code = substr($code, strrpos($code, '0')+1);

        $len = strlen($code);

        $code = strrev($code);

        $num = 0;

        for ($i=0; $i < $len; $i++) {

            $num += strpos($source_string, $code[$i]) * pow(35, $i);

        }

        return $num;

    }

    // 获取用户合约总的折合
    protected function get_user_hy_total_zh($uid)
    {
        $ch = db('user_deal_lines_c_h')->where('type','in','1,2')->where(['user_id'=>$uid])->select();
        $zh = 0;
        foreach ($ch as $item){
            $price = $this->get_currency_jy_value($item['currency'], 2, 2, 'value');
            $zh += $item['position'] * $price / $item['multiple'];
        }
        return $zh;
    }
    // 用户合约总资产
    protected function get_user_hy_total_usdt($uid)
    {
        $user = db('user')->field('hy_usdt,hy_usdt_lock')->where(['id'=>$uid])->find();
        $zh = $this->get_user_hy_total_zh($uid);
        return $user['hy_usdt'] + $user['hy_usdt_lock'] + $zh;
    }
    // 获取用户合约总盈亏
    protected function get_user_hy_profit_loss($uid)
    {
        return db('user_deal_lines_c_h')->where(['user_id'=>$uid])->where('type','in','1,2')->sum('floating_pl');
    }
    // 持仓占用交易保证金
    protected function get_user_hy_margin($uid)
    {
        return db('user_deal_lines_c_h')->where(['user_id'=>$uid])->where('type','in','1,2')->sum('margin');
    }
    // 获取风险率
    protected function get_user_hazard_rate($uid)
    {
        // 风险率
        $margin = $this->get_user_hy_margin($uid);
        if($margin==0){
            return 0;
        }else{
            $total = $this->get_user_hy_total_usdt($uid); // 合约账户总资产
            $pl = $this->get_user_hy_profit_loss($uid); // 合约账户总亏损
            // 净值=（合约账户总资产+合约账户总亏损）
            // 风险率＝客户账户净值÷持仓占用交易保证金
            return round(($total + $pl) / $margin * 100, 4) .'%';
        }
    }
}
