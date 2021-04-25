<?php
namespace app\api\controller;


class Lang extends Base
{
    public function __construct()
    {
        parent::__construct();
    }
    public function set()
    {
        $data = '{"message": "Switch lange success!(zh)","session_id": "0sH0pqmdqPB2qdQIK4dGX0nbva92rZDm3SJ66H4d","type": "ok"}';
        return self::j($data);
    }
}
