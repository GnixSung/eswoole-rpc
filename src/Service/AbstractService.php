<?php

namespace App\Service;

use Jiaxinli\Rpc\Exception\ParamException;
use Jiaxinli\Rpc\Request;
use Jiaxinli\Rpc\Response;

/**
 * Created by PhpStorm.
 * User: ljx@dotamore.com
 * Date: 2019/4/1
 * Time: 11:59
 */

abstract class AbstractService
{
    protected $request;
    protected $response;

    protected $model;
    protected $isProxyModel = false;
    protected $redis;

    public function __construct(Request $request,Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    protected function getArg()
    {
        return $this->request->getArg();
    }

    protected function getMustArg()
    {
        $arg = $this->request->getArg();
        if(!$arg)
        {
            throw new ParamException();
        }
        return $arg;
    }

    //实现代理模型方法处理
    public function __call($name, $arguments)
    {
        if($this->isProxyModel)
        {
            //使用反射获取类及方法相关信息
            $reflection = new \ReflectionClass($this->model);
            //判断是否存在此方法
            if ($reflection->hasMethod($name))
            {
                $method = $reflection->getMethod($name);
                if ($method && $method->isPublic() && !$method->isAbstract())
                {
                    if ($method->isStatic()){
                        return $method->invokeArgs(null,$arguments);
                    }
                    else{
                        return $method->invokeArgs($this->model,$arguments);
                    }
                }
            }
            else
            {
                throw new ParamException(['status'=>Response::STATUS_SERVICE_ACTION_NOT_FOUND,'msg'=>'Call to undefined method']);
            }
        }
    }

}