<?php
/**
 * Created by PhpStorm.
 * User: ljx@dotamore.com
 * Date: 2019/2/9
 * Time: 21:27
 */

namespace Jiaxinli\Rpc\Exception;


class ParamException extends Base
{
    public $msgs   = [
        1003 => 'Missing parameters', //缺少参数
    ];

    public $status = '1003';
    public $msg    = 'Missing parameters';
}