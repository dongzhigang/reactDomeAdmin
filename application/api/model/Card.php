<?php 
namespace app\api\model;
use think\Model;
use think\Db;
use think\Request;			//接收请求信息
use think\Validate;			//验证请求参数
use think\Session;

/**
 * 卡卷
 */
class Card extends Model
{
	//卡卷订单
	public function card_order(){
		$user_id = Session::get('user_id');
		$cardList = Db::name('my_coupon')->where("user_id",$user_id)->alias('a')->join('card_shopping b ','b.card_id= a.card_id')->select();
		//卡卷热销数据has_hot==1
		$hotList = Db::name('card_shopping')->where("has_hot",1)->select();
		$res["cardList"] = $cardList;
		$res["hotList"]	= $hotList;
		if(($cardList->isEmpty() || $cardList) && ($hotList->isEmpty() || $hotList)){ //查询成功
			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{//查询失败
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}
		return $data;
	}
	//卡卷订单详情
	public function card_order_details(){//请求参数coupon_id
		$request = Request::instance();
		$order_id = $request ->param("coupon_id");			//优惠卷id
		$res = Db::name('my_coupon')->where("coupon_id",$order_id)->alias('a')->join('card_shopping b ','b.card_id= a.card_id')->find();
		if($res){
			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}
		return $data;
	}
	//卡卷商城
	public function card_shopping(){
		$request = Request::instance();
		$page = $request ->param("page");			//页码
		$rows = $request ->param("rows");			//页数
		$res = Db::name('card_shopping')->page($page,$rows)->select();
		if($res->isEmpty() || $res){
			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}
		return $data;
	}
	//卡卷商城-详情
	public function card_shopping_details(){
		$request = Request::instance();
		$card_id = $request ->param("card_id");			//卡卷id
		$card_details = Db::name('card_shopping')->where("card_id",$card_id)->find();
		$res["card_details"] = $card_details;
		//优惠卷规则
		$card_rule = Db::name('card_rule')->where("card_id",$card_id)->select();
		if($card_rule->isEmpty() || $card_rule){
			$res["card_rule"] = $card_rule;
		}
		if($card_details){
			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}
		return $data;
	}
	//我的购物卷
	public function my_coupon(){//请求参数，is_expend，0未用，1已用，-1失效
		$user_id = Session::get('user_id');
		$request = Request::instance();
		$is_expend = $request ->param("is_expend");			//是否已用
		$res = Db::name('my_coupon') ->where("user_id",$user_id)->where("is_expend",$is_expend)->alias("a")->join("card_shopping b","a.card_id = b.card_id")->field('card_name,card_image,card_integration,card_sum,card_explain,useful_life') ->select();
		//有效期取到期
		if($res->isEmpty() || $res){
			foreach ($res as $key => $value) {
				$useful_life = explode("-",$value["useful_life"])[1];
				$value["useful_life"]= $useful_life;
				$res[$key] = $value;
			}
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