<?php
namespace trt;

defined('_MOTTO') or die('Restricted access');

trait Media
{
    public function Media()
    {
        \GOB::$paramT['html']['head']['cssfile'][]=\lib\base\File::pathF('MOtto/app/media/view/media.css');
        \GOB::$paramT['html']['head']['jsfile'][]=\lib\base\File::pathF('MOtto/app/media/view/media.js');
        \GOB::$paramT['html']['head']['js'][]=" var rootdir='".\PATH::$rootDir."' ";
    }
}
