<?php
/**
 * Created by PhpStorm.
 * User: ljx@dotamore.com
 * Date: 2019/2/9
 * Time: 20:48
 */

namespace Jiaxinli\Rpc\Exception;


class Base extends \Exception
{
    public $msgs   = [];

    public $status = 999;
    public $msg    = 'unknow_error';
    public $data   = [];

    public function __construct(array $params = [])
    {
        if(!is_array($params))
        {
            return;
        }

        if(array_key_exists('status',$params))
        {
            $this->status = $params['status'];
            $this->msg = $this->msgs[$params['status']]??$this->msg;
        }

        if(array_key_exists('msg',$params))
        {
            $this->msg = $params['msg'];
        }

    }

}