<?php 
namespace app\admin\Controller;
use think\Controller;
use think\Session;
use app\admin\model\Admin;
/**
 * 
 */
class Login extends Controller
{
	//忘记密码view渲染
	public function updatePwd()
	{	
		return $this->fetch();
	}
	//登录
	public function login()
	{			
		return $this->fetch();
	}

	//登录
	public function loginButton()
	{	
		$userName = $_REQUEST["userName"];
		$password = $_REQUEST["password"];
		$admin = new Admin;
		$res = $admin -> where(["userName" => $userName,"password" => $password])->find();
		if($res){
			$limits = $res->toArray()["limits"];				//获取用户权限
			Session::set('userName',$userName);					//存储用户名
			Session::set('limits',$limits);						//存储权限
			$arrayName = array('code' =>0 ,"data" => array(),"msg" =>"登录成功" );
		}else{
			$arrayName = array('code' =>1 ,"data" => array() ,"msg" =>"登录失败，用户名或密码错误");
		}
		header("Content-type: text/json");
        echo json_encode($arrayName);
	}
	//修改密码
	public function revamp()
	{
		$userName    = $_REQUEST["userName"];
		$password    = $_REQUEST["password"];
		$newPassword = $_REQUEST["newPassword"];
		$admin = new Admin;
		$res = $admin -> where(["password" => $password,"userName" => $userName])->update(["password" => $newPassword]);
		if($res){
			$arrayName = array('code' => 0 , "data" => array(), "msg" => "修改成功" );
		}else{
			$arrayName = array('code' => 0 , "data" => array(), "msg" => "修改失败" );
		}
		header("Content-type: text/json");
        echo json_encode($arrayName);
	}
}
?>