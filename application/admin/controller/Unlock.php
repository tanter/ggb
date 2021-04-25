<?php
namespace app\admin\controller;
use app\common\controller\Auth;

class Unlock extends Auth
{
	// 获取解锁方式
	public function getType(){
		$data = db('unlock_type')->select();
		return self::json(0, ['type'=>$data]);
	}
	// 获取解锁值
	public function getUnlock()
	{
		$page  = input('page', 1);
		$limit = input('limit', 10);
		$classify = intval(input('classify'));
		$list = db('unlock')->where(['is_delete'=>0,'unlock_classify'=>$classify])->limit(($page - 1)*$limit, $limit)->order('id desc')->select();
		$total = db('unlock')->where(['is_delete'=>0,'unlock_classify'=>$classify])->count();
		$userCount = db('user')->count();

		foreach($list as $index=>$item){
			// 获取有多少人解锁
			$list[$index]['unlock_count'] = '';
			$list[$index]['unlock_money'] = '';
			if($item['unlock_type'] > 1){
				$list[$index]['unlock_count'] = self::round(db('user_unlock')->where(['unlock_id'=>$item['id']])->count(), 0);
				if ($item['unlock_type'] > 2){
					$list[$index]['unlock_money'] = self::round(db('user_unlock')->where(['unlock_id'=>$item['id']])->sum('unlock_value'));
				}
			}
		}

		return self::json(0, ['list'=>$list, 'total'=>$total]);
	}
	// 保存添加解锁值
	public function saveUnlock()
	{
		$id   = intval(input('id'));
		$name = input('name');
		$unlock_type = input('unlock_type');
		$unlock_value = input('unlock_value');
		$unlock_classify = intval(input('classify'));

		if(empty($id)){
			$id = db('unlock')->insertGetId([
					'name'=>$name,
					'unlock_type'=>$unlock_type,
					'unlock_value'=>$unlock_value,
					'unlock_classify'=>$unlock_classify,
					'is_delete'=>0
				]);
			return self::json(0, ['id'=>$id], '添加成功');
		}else{
			db('unlock')->where(['id'=>$id])->update([
					'name'=>$name,
					'unlock_type'=>$unlock_type,
					'unlock_value'=>$unlock_value
				]);
			return self::json(0, [], '保存成功');
		}
	}
	// 删除
	public function delUnlock()
	{
		$id = intval(input('id'));
		db('unlock')->where(['id'=>$id])->update(['is_delete'=>1]);
		return self::json(0, [], '删除成功');
	}
}
