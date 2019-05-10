<?php 
namespace app\api\controller;
use think\controller;
use app\api\model\Card as CardModel;

/**
 * 卡卷接口
 */
class Card extends Base
{
	
	private $CardModel;
	function _initialize(){
		parent::_initialize();
		$this->CardModel = new CardModel();
	
	}
	//卡卷订单
	public function card_order(){
		$res=$this->CardModel->card_order();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//卡卷订单详情
	public function card_order_details(){
		$res=$this->CardModel->card_order_details();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//卡卷商城
	public function card_shopping(){
		$res=$this->CardModel->card_shopping();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//卡卷商城-详情
	public function card_shopping_details(){
		$res=$this->CardModel->card_shopping_details();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
	//我的购物卷
	public function my_coupon(){
		$res=$this->CardModel->my_coupon();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
}
?>