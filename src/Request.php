<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/11/7
 * Time: 8:41 PM
 */

namespace Jiaxinli\Rpc;


use EasySwoole\Utility\Random;

class Request
{
    protected $packageId;
    protected $service;
    protected $version;
    protected $action;
    protected $arg;
    protected $isKeep;
    protected $fd;
    protected $rawData;
    protected $requestTime;


    public function __construct(int $fd)
    {
        $this->initialize();
        $this->setFd($fd);
    }

    /**
     * @return mixed
     */
    public function getPackageId()
    {
        return $this->packageId;
    }

    /**
     * @param mixed $packageId
     */
    public function setPackageId($packageId): void
    {
        $this->packageId = $packageId;
    }

    /**
     * @param mixed $service
     */
    public function setService($service): void
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version): void
    {
        $this->version = $version;
    }

    /**
     * @param mixed $isKeep
     */
    public function setIsKeep($isKeep): void
    {
        $this->isKeep = $isKeep;
    }

    /**
     * @return mixed
     */
    public function getIsKeep()
    {
        return $this->isKeep;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getArg()
    {
        return $this->arg;
    }

    /**
     * @param mixed $arg
     */
    public function setArg($arg): void
    {
        $this->arg = $arg;
    }

    /**
     * @return mixed
     */
    public function getFd()
    {
        return $this->fd;
    }

    /**
     * @param mixed $fd
     */
    public function setFd($fd): void
    {
        $this->fd = $fd;
    }

    /**
     * @return mixed
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * @param mixed $rawData
     */
    public function setRawData($rawData): void
    {
        $this->rawData = $rawData;
    }

    public static function pack(string $data):string
    {
        //"\n"是为了处理客户端读包结束
        return pack('N', strlen($data)).$data."\n";
    }

    public static function unpack(string $data):string
    {
        return substr($data,'4');
    }

    /**
     * @return mixed
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * @param mixed $requestTime
     */
    public function setRequestTime($requestTime): void
    {
        $this->requestTime = $requestTime;
    }

    public function proxyActionAssemblyArg()
    {
        $arg = $this->getArg();
        $action = $this->getAction();
        $tempArg = [
            $action,$arg
        ];
        $this->setArg($tempArg);
    }

    public function checkSetParam(string $data)
    {
        //解包
        //检查标准参数 service(必填) action(必填) args(可选)
        $data = self::unpack($data);
        $arrData = unserialize($data);

        //检查必须参数
        if(!is_array($arrData) || !isset($arrData['service']) || empty($arrData['service']) ||
            !isset($arrData['action']) || empty($arrData['action']))
        {
            return false;
        }

        //设置参数
        if(isset($arrData['arg']))
        {
            $this->setArg($arrData['arg']);
        }

        //设置版本
        if(isset($arrData['version']) && is_numeric($arrData['version']) && $arrData['version']>0)
        {
            $this->setVersion($arrData['version']);
        }
        else
        {
            $this->setVersion(1);
        }

        //是否保持长连接
        $isKeep = isset($arrData['isKeep']) && $arrData['isKeep'] ? true : false;
        $this->setIsKeep($isKeep);

        $this->setService($arrData['service']);
        $this->setAction($arrData['action']);
        $this->setRawData($arrData);
        return true;
    }

    protected function initialize(): void
    {
        if(empty($this->packageId)){
            $this->packageId = Random::character(32);
        }
        if(empty($this->requestTime)){
            $this->requestTime = time();
        }
    }
}