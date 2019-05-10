<?php 
namespace app\api\model;
use think\Model;
use think\Db;
use think\Request;			//接收请求信息
use think\Validate;			//验证请求参数
use think\Session;

/**
 * 
 */
class Food extends Model
{
	//菜品数据
	public function food_data(){	//请求数据,canteen_id
		$request = Request::instance();
		$canteen_id = $request ->param("canteen_id");		//城市id
		$user_id = Session::get('user_id');					//用户id
		$classify = Db::name('food_classify')->select();	//分类列表
		foreach ($classify as $k => $v) {
			//菜品列表
			$list = Db::name('food_good') ->where("classify_id",$v["classify_id"]) ->where("canteen_id",$canteen_id) ->select();
			$gross_num = 0;
			if(!$list->isEmpty()){
				//查询未付款订单菜品数量
				foreach ($list as $key => $val) {
					// 订单菜品数量;
					$good_num = Db::name('order')->where("good_id",$val["good_id"])->where("order_date",date("Y-m-d"))->where("is_pay",0)->where("user_id",$user_id) ->alias("a")->join("order_form b","a.order_id = b.order_id")->sum ("good_num");
					$val["good_num"] = $good_num;
					$list[$key] = $val;
					//订单菜品数量总计
					$gross_num = $gross_num + $good_num;
				}
				//添加菜品数量总计
				$v["gross_num"] = $gross_num;
				$food_classify[$k] = $v;
				$food_list[$k]["classify_name"] = $v["classify_name"];
				$food_list[$k]["list"] = $list;
			}
		}
		$res["food_classify"] = $food_classify;
		$res["food_list"]	= $food_list;
		if($classify !== false){ //查询成功
			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{//查询失败
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}		
		return $data;
	}
	//保存下单菜单
	public function save_order_from(){ //请求参数,food_list,canteen_id
		$request = Request::instance();
		$user_id = Session::get('user_id');					//用户id
		$canteen_id = $request ->param('canteen_id');		//餐厅id
		$food_list = $request ->param("food_list/a");		//菜品列表
		$order_num = order_num();							//订单编号
		$order_id = "";
		// 启动事务
		Db::startTrans();
		try{
			//判断用户是否有当天订单未付款
			$map_order["canteens_id"] = $canteen_id;
			$map_order["user_id"]     = $user_id;
			$map_order["order_date"]  = date("Y-m-d");       //当天时间
			$order = Db::name("order")->where($map_order)->find();
			if($order){//如存在，则更新菜品数量
				Db::name("order_form")->where("order_id",$order["order_id"])->where("is_pay",0)->delete();
				$order_id = $order["order_id"];
			}else{//保存订单，返回订单id
				$array_order = ["order_num"=>$order_num,"create_date"=>date("Y-m-d H:i:s"),"order_date" => date("Y-m-d"),"canteens_id"=>$canteen_id,"user_id"=>$canteen_id];
				$order_id = Db::name("order")->insertGetId($array_order);
			}
			foreach ($food_list as $k => $v) {
				$array_form = ["order_id"=>$order_id,"good_id"=>$v["good_id"],"good_num"=>$v["good_num"],"is_pay"=>0,"is_add"=>0,"create_date"=>date("Y-m-d H:i:s")];
				$data_all[$k] = $array_form;
			}
			Db::name("order_form")->insertAll($data_all);
		    // 提交事务
		    Db::commit();
			$data["code"] = 200;
			$data["msg"] = "添加成功";
		} catch (\Exception $e) {
		    // 回滚事务
		    Db::rollback();
		    $data["code"] = 400;
			$data["msg"] = "添加失败";
		}
		return $data;
	}
	//下单订单菜单详情,未付款订单
	public function order_details(){ //请求参数,canteen_id
		$request = Request::instance();
		$user_id = Session::get('user_id');					//用户id
		$canteen_id = $request ->param('canteen_id');		//餐厅id
		$map["is_pay"] = 0;						//未付款状态
		$map["user_id"] = $user_id;
		$map["canteens_id"] = $canteen_id;
		$map["order_date"] = date("Y-m-d");		//当天时间

		$res = Db::name('order')->alias("a")->where($map)->join("order_form b","a.order_id = b.order_id")->join("food_good c","c.good_id = b.good_id")->field("a.order_id,c.good_id,c.good_image,c.good_name,c.price,c.original_price,b.good_num,b.form_id")->select();
		if($res !== false){
			$data["code"] = 200;
			$data["msg"] = "查询成功";
			$data["data"] = $res;
		}else{
			$data["code"] = 400;
			$data["msg"] = "查询失败";
		}
		return $data;
	}
	//微信支付成功后调用，支付成功后的下单菜单,把is_pay改为1
	public function pay_order(){
		$request = Request::instance();
		$user_id = Session::get('user_id');					//用户id
		$canteen_id = $request ->param('canteen_id');		//餐厅id
		$map["canteens_id"] = $canteen_id;
		$map["user_id"] = $user_id;
		$map["order_date"] = date("Y-m-d");					//当天时间
		$order_id = "";
		// 启动事务
		Db::startTrans();
		try{
			//判断是否菜品存在付款加菜订单
			$order_form = Db::name('order')->where($map)->alias("a")->join("order_form b","b.order_id = a.order_id")->where("is_pay",1)->select();
			if(count($order_form)){//存在则加菜菜品
				//判断是否存在加菜数据
				$order_form_has = Db::name('order')->where($map)->alias("a")->join("order_form b","b.order_id = a.order_id")->where("is_pay",0)->where("is_add",0)->select();
				if(count($order_form_has)){//存在
					foreach ($order_form_has as $k => $v) {
						//存在与新增对比
						$order_form_add = Db::name('order')->where($map)->alias("a")->join("order_form b","b.order_id = a.order_id")->where("good_id",$v["good_id"])->where("is_pay",1)->where("is_add",1)->find();
						if($order_form_add){//存在，则数量叠加
							Db::name('order_form')->where("form_id",$order_form_add["form_id"])->setInc("good_num",$v["good_num"]);
							Db::name('order_form')->where("form_id",$v["form_id"]) ->delete();
						}else{
							Db::name('order_form')->where("form_id",$v["form_id"])->update(["is_add"=>1,"is_pay"=>1]);
						}
						$order_id = $v["order_id"];
					}
				}else{//不存在，新增加菜数据
					foreach ($order_form as $k => $v) {
						$map_form["order_id"] = $v["order_id"];
						$map_form["is_add"]   = 0;
						$map_form["is_pay"]   = 0;
						//变成加菜菜品
						Db::name('order_form')->where($map_form)->update(["is_pay"=>1,"is_add"=>1]);
						$order_id = $v["order_id"];
					}
				}
			}else{//不存在，则直接改变付款状态
				$order_form = Db::name('order')->where($map)->alias("a")->join("order_form b","b.order_id = a.order_id")->where("is_pay",0)->select();
				foreach ($order_form as $k => $v) {
					Db::name('order_form')->where("form_id",$v["form_id"])->update(["is_pay"=>1]);
					$order_id = $v["order_id"];
				}
			}
			// 提交事务
		    Db::commit();
			$data["code"] = 200;
			$data["msg"] = "付款成功";
			$data["order_id"] = $order_id;
		} catch (\Exception $e) {
		    // 回滚事务
		    Db::rollback();
		    $data["code"] = 400;
			$data["msg"] = "付款失败";
		}
		return $data;
	}

	//支付后的下单菜单详情
	public function pay_order_details(){
		$request = Request::instance();
		$user_id = Session::get('user_id');					//用户id
		$canteen_id = $request ->param('canteen_id');		//餐厅id
		$order_id = $request ->param('order_id');		    //订单id
		$map["user_id"] = $user_id;
		$map["canteens_id"] = $canteen_id;
		$map["order_date"] = date("Y-m-d");
		//餐厅详情
		$canteen_info = Db::name("canteen")->where("canteen_id",$canteen_id)->field("canteen_name,address") ->find();
		$order = Db::name("order")->where($map)->find();
		$order_num = $order["order_num"];
		$create_date = $order["create_date"];
		$order_list = Db::name("order")->alias("a")->join("order_form b","a.order_id = b.order_id")->join("food_good c","b.good_id = c.good_id")->where("is_add",0)->where($map)->field("good_name,good_num,original_price,price")->select();
		$order_list_add = Db::name("order")->alias("a")->join("order_form b","a.order_id = b.order_id")->join("food_good c","b.good_id = c.good_id")->where($map)->where("is_add",1)->field("good_name,good_num,original_price,price")->select();
		if($canteen_info || $order_list || $order_list_add){
			$res["canteen_info"] = $canteen_info;
			$res["order_list"] = $order_list;
			$res["order_list_add"] = $order_list_add;
			$res["order_num"] = $order_num;
			$res["create_date"] = $create_date;
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