<?php
namespace app\index\controller;


class Upload extends Base
{
  	public function __construct()
	{
		parent::__construct();
	}
  	
	public function uploadImg(){
		$res = self::upload_img();
		$key = input('key');
		if($key)$res['key'] = $key;
	    return self::json($res);
	}
}
