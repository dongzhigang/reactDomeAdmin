<?php 
namespace app\api\controller;
use think\Controller;
use think\Session;
header("content-type:text/html;charset=utf-8");         //设置编码
header('Access-Control-Allow-Origin: *');
/**
 * 基础
 */
class Base extends Controller
{
	function _initialize()
    {
    	//保存用户id
    	Session::set('user_id',1);
    	//保存用户信息
    	if(Session::get('user')){	//已登录

    	}else{	//未登录
    		Session::set('user',1);
    	}
    }
}
?>