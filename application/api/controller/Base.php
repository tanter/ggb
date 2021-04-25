<?php
namespace app\api\controller;
use app\common\controller\Common;

class Base extends Common
{
	public function __construct()
	{
		parent::__construct();
	}
	public static function j($str){
	    return self::json(json_decode($str, true));
    }
}
