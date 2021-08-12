<?php
namespace app\admin\controller\datastatistics;
// use think\Request;
// use think\Db;
// use think\Controller;
use app\admin\controller\Common;
class Index extends Common
{
	public function _initialize()
    {
    	parent::_initialize();
    }

    public function index()
    {
    	dump($this);
    }
}
?>