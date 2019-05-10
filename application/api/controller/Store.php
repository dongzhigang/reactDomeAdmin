<?php 
namespace app\api\controller;
use think\Controller;
use app\api\model\Store as StoreModel;

/**
 * 店铺接口
 */
class Store extends Base
{
	
	private $StoreModel;
	function _initialize(){
		parent::_initialize();
		$this->StoreModel = new StoreModel();
	
	}
	//店铺餐厅-扫码得到餐厅和桌位号
	public function store_canteen(){ //重定向
		$data = $this->StoreModel->store_canteen();	
		$this->redirect('http://localhost:3000/#/qrCode/'.$data["canteen_id"].'/'.$data["table_no"]);
	}
	//店铺信息
	public function store_info(){ 
		$res = $this->StoreModel->store_info();		
		echo json_encode($res,JSON_UNESCAPED_UNICODE);exit;
	}
}
?>