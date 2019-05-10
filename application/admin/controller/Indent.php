<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\Controller\Common;

/**
 * 订单管理
 */
class Indent extends Common
{
	
	public function index()
	{
		return $this->fetch();
	}
}
?>