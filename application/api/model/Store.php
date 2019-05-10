<?php 
namespace app\api\model;
use think\Model;
use think\Db;
use think\Request;			//接收请求信息
use think\Validate;			//验证请求参数
use think\Session;

/**
 * 店铺处理
 */
class Store extends Model
{
	//店铺餐厅-扫码得到餐厅和桌位号
	public function store_canteen(){ //请求参数.canteen_id,table_no
		$request = Request::instance();
		$data["canteen_id"] = $request ->param("canteen_id");			//餐厅id
		$data["table_no"] = $request ->param("table_no");			//桌位号
		return $data;
	}
	//店铺信息
	public function store_info(){ //请求参数,canteen_id
		$request = Request::instance();
		$canteen_id = $request ->param("canteen_id");			//餐厅id
		$res = Db::name('canteen')->where("canteen_id",$canteen_id)->alias("a")->join("store b","a.store_id = b.store_id")->field("store_logo,canteen_name")->find();
		if($res){
			$data["code"] = 200;
			$data["msg"] = "查询成功";
			$data["data"] = $res;
		}else{
			$data["code"] = 400;
			$data["msg"] = "查询失败";
		}
		return $data;
	}
}
?>