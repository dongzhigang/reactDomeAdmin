<?php 
namespace app\api\controller;
use think\Controller;
use app\api\model\Canteen as CanteenModel;

/**
 * 在线取号接口-餐厅
 */
class Canteen extends Base
{
	private $CanteenModel;
	function _initialize(){
		parent::_initialize();
		$this->CanteenModel = new CanteenModel();
	
	}
	//城市列表接口
	public function city_list(){
		$res=$this->CanteenModel->city_list();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//餐厅列表接口
	public function canteen_list(){
		$res=$this->CanteenModel->canteen_list();
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//餐厅详情
	public function canteen_detail(){
		$res=$this->CanteenModel->canteen_detail();
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//餐厅取号排队
	public function canteen_take(){
		$res=$this->CanteenModel->canteen_take();
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	} 
	//餐厅取消排队
	public function canteen_cancel(){
		$res=$this->CanteenModel->canteen_cancel();
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	} 
	//餐厅评论
	public function canteen_comment(){
		$res=$this->CanteenModel->canteen_comment();
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//全部餐厅
	public function canteen_all(){
		$res=$this->CanteenModel->canteen_all();
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//查看餐厅
	public function store_look(){
		$res=$this->CanteenModel->store_look();
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//取号详情
	public function take_number_details(){
		$res=$this->CanteenModel->take_number_details();
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}


	public function imap_gc(){
		echo club_card();
	}
}
?>