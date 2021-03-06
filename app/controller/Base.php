<?php
/**
 * Author: 孙武 QQ:1228746736
 * Date: 2018/5/11
 * Time: 0:08
 */

namespace app\controller;


use Sunwu\Errmsg\ErrCore;
use Sunwu\Errmsg\ErrMaps;
use think\Controller;
use think\Request;

class Base extends Controller
{
    function __construct(Request $request = null)
    {
        if (Request::instance()->isOptions()) die('options access');
        parent::__construct($request);
        $this->err = new ErrCore();

    }

    private $err;
    private $data;


    public function infoTips($errno)
    {
        return $this->err->err($errno);
    }

    function infoErrmsg($errmsg = '')
    {
        return $this->err->errmsg($errmsg);
    }

    public function infoEmpty()
    {
        return $this->err->err(10000);

    }

    public function infoSuccess()
    {
        return $this->err->err(0);
    }

    public function infoDbSelect($res)
    {
        if ($res) return $this->err->errdata(0, $res); else return $this->infoEmpty();
    }


    public function infoDbUpdate($res)
    {
        if ($res > 0) {
            return $this->infoSuccess();
        }
        return $this->infoTips(30001);
    }


    public function infoDbDelete()
    {

    }

    public function infoDbInsert($insertRes)
    {
        if ($insertRes > 0) {
            return $this->infoSuccess();
        }
        return $this->infoTips(30002);
    }


    public function infoDie($errmsg)
    {
        header("Content-Type:application/json; charset=utf-8");
        die(json_encode($this->infoErrmsg($errmsg)));
    }

    public function infoDieErrno($errno)
    {
        header("Content-Type:application/json; charset=utf-8");
        die(json_encode($this->err->err($errno)));
    }


}