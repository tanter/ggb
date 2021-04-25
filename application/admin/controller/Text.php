<?php
namespace app\admin\controller;
use app\common\controller\Auth;

class Text extends Auth
{
	public function __construct()
	{
		parent::__construct();
	}
	public function getText()
    {
        $type = input('type');
        $condition['type'] = $type;
        $data = db('text')->where($condition)->select();
        return self::json(0,$data);
    }
    public function saveText()
    {
        $parms = $this->params();
        if(isset($parms['id'])){
            db('text')->update($parms);
        }else{
            $parms['id'] = db('text')->insertGetId($parms);
        }
        return self::json(0,$parms,'操作成功');
    }
    public function delText()
    {
        $id = intval(input('id'));
        $type = db('text')->where(['id'=>$id])->value('type');
        if($type == 'gonggao'){
            db('text')->where(['id'=>$id])->delete();
        }
        return self::json(0,'','操作成功');
    }
}
