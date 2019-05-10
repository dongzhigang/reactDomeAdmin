<?php 
namespace app\api\controller;
use think\Controller;
use app\api\model\Food as FoodModel;

/**
 *
 * 菜品接口
 */
class Food extends Base
{
	
	private $FoodModel;
	function _initialize(){
		parent::_initialize();
		$this->FoodModel = new FoodModel();
	
	}

	//菜品数据
	public function food_data(){
		$res=$this->FoodModel->food_data();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//保存菜品下单菜单
	public function save_order_from(){
		$res=$this->FoodModel->save_order_from();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//下单菜单详情
	public function order_details(){
		$res=$this->FoodModel->order_details();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//支付后的下单菜单
	public function pay_order(){
		$res=$this->FoodModel->pay_order();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//支付后的下单菜单详情
	public function pay_order_details(){
		$res=$this->FoodModel->pay_order_details();	
		// return $res;
		// var_dump($res);	
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
}
?>