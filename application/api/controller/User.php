<?php 
namespace app\api\controller;
use think\controller;
use app\api\model\User as UserModel;
/**
 * 用户接口
 */
class User extends Base
{
	private $UserModel;
	function _initialize(){
		parent::_initialize();
		$this->UserModel = new UserModel();
	
	}

	//用户信息
	public function user_info(){
		$res=$this->UserModel->user_info();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//用户信息保存
	public function user_info_preserve(){
		$res=$this->UserModel->user_info_preserve();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//积分规则
	public function integration_rule(){
		$res=$this->UserModel->integration_rule();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//积分获取
	public function integration_acquire(){
		$res=$this->UserModel->integration_acquire();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//积分支出
	public function integration_expend(){
		$res=$this->UserModel->integration_expend();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//用户用餐记录
	public function dinner_record(){
		$res=$this->UserModel->dinner_record();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
}
?>