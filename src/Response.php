<?php
/**
 * Created by PhpStorm.
 * User: ljx@dotamore.com
 * Date: 2019/3/31
 * Time: 22:22
 */

namespace Jiaxinli\Rpc;

class Response
{
    const STATUS_OK = 0;
    const STATUS_SERVICE_REJECT_REQUEST = 1;//服务端拒绝执行，比如缺参数，或是恶意调用
    const STATUS_SERVICE_NOT_FOUND = -1;//服务端告诉客户端没有该服务
    const STATUS_SERVICE_SERVICE_NOT_FOUND = -2;//服务端告诉客户端该服务不存在该服务组（服务控制器）
    const STATUS_SERVICE_ACTION_NOT_FOUND = -3;//服务端告诉客户端没有该action
    const STATUS_SERVICE_ERROR = -4;//服务端告诉客户端服务端出现了错误
    const STATUS_PACKAGE_ENCRYPT_DECODED_ERROR = -5;//服务端告诉客户端发过来的包openssl解密失败
    const STATUS_PACKAGE_DECODE_ERROR = -6;//服务端告诉客户端发过来的包无法成功解码为ServiceCaller

    const STATUS_CLIENT_WAIT_RESPONSE_TIMEOUT = -7;//客户端等待响应超时
    const STATUS_CLIENT_CONNECT_FAIL = -8;//客户端连接到服务端失败
    const STATUS_CLIENT_SERVER_NOT_FOUND = -9;//客户端无法找到该服务

    protected $message;
    protected $status = self::STATUS_OK;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


}