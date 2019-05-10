<?php 
namespace app\api\model;
use think\Model;
use think\Db;
use think\Request;			//接收请求信息
use think\Validate;			//验证请求参数
use think\Session;
/**
 * 餐厅表处理
 */
class Canteen extends Model
{
	//城市列表
	public function city_list(){
		//查询城市
		$res = Db::name('city')->select();
		if($res !== false){ //查询成功
			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{//查询失败
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}		
		return $data;
	}
	//餐厅列表
	public function canteen_list(){//请求参数city_id,lng_lat,page,rows
		date_default_timezone_set('PRC'); //设置中国时区
		$current_time = strtotime(date("H:i"));	//当前时间
		$request = Request::instance();
		$city_id = $request ->param("city_id");			//城市id
		$page = $request ->param("page");			//页码
		$rows = $request ->param("rows");			//页数
		$lng_lat = $request ->param("lng_lat");			//当前经纬度
		$res = Db::name('canteen')->where("city_id",$city_id)->page($page,$rows)->alias("a")->join("store b","a.store_id = a.store_id")->field('canteen_id,canteen_name,canteen_logo,tag_dosc,current_lng_lat,comment_score,crowd_state,business_hours')->select();
		if($res !== false){ //查询成功
			foreach ($res as $k => $v){
				//火爆程度的判定 空闲1/3桌以内 拥挤2/3以内桌 爆满大于2/3以上,已取号的桌数/桌数总计，crowd_state拥挤状态，1空闲，2拥挤，3火爆
				//查询当天已取号的餐桌数，queue_status==1
				$dining_total = Db::name('queue_online')->where("canteen_id",$v["canteen_id"])->where("create_date",'like',date("Y-m-d")."%")->where("queue_status",1)->count("queue_id");
				//查询餐厅桌数总数
				$desk_total = Db::name('canteen_type')->where("canteen_id",$v["canteen_id"])->count("type_id");

				if($desk_total > 0){
					//餐厅水平
					$centeen_level = $dining_total / $desk_total;
					if($centeen_level < 0.33){	//空闲
						$v["crowd_state"] = 1;
						$res[$k] = $v;
					}else if ($centeen_level < 0.66) {	//拥挤
						$v["crowd_state"] = 2;
						$res[$k] = $v;
					}else if($centeen_level>=0.66){	//火爆
						$v["crowd_state"] = 3;
						$res[$k] = $v;
					}
				}else{
					$v["crowd_state"] = 1;
					$res[$k] = $v;
				}
				//判断餐厅状态canteen_status，1正常营业，2休息中
				$date_arr = explode("-",$v["business_hours"]);
				if(strtotime($date_arr[0]) <=$current_time  && $current_time <= strtotime($date_arr[1])){
					$v["canteen_status"] = 1;
					$res[$k] = $v;
				}else{
					$v["canteen_status"] = 2;
					$res[$k] = $v;
				}	
				//等待桌数
				$v["waiting_tables"] = $dining_total;
				$res[$k] = $v;
				//距离
				$v["canteen_distance"] = getdistance($lng_lat,$v["current_lng_lat"]);
				$res[$k] = $v;			
			}
			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{//查询失败
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}		
		return $data;
	}
	//餐厅详情
	public function canteen_detail(){	//请求参数,canteen_id,lng_lat
		date_default_timezone_set('PRC'); //设置中国时区
		$current_time = strtotime(date("H:i"));	//当前时间
		$request = Request::instance();
		$canteen_id = $request ->param("canteen_id");			//餐厅id
		$user_id = Session::get('user_id');					//用户id
		$lng_lat = $request ->param("lng_lat");			//当前经纬度

		$res = Db::name('canteen')->where("canteen_id",$canteen_id)->alias("a")->join("store b","a.store_id = a.store_id")->find();
		if($res){ //查询成功
			//餐桌类型列表
			$canteen_type = Db::name('canteen_type')->field('type_id,canteen_id,desk_name,waiting_time,desk_num,dinner_num')->where("canteen_id",$res["canteen_id"])->select();
			// return $canteen_type;
			$res["canteen_type"] = $canteen_type;
			//餐桌类型排队等待餐桌
			foreach ($canteen_type as $k => $v) { 
				$waiting_num = Db::name('queue_online')->where("canteen_id",$canteen_id)->where("type_id",$v["type_id"])->where("queue_status",1)->where("create_date",'like',date("Y-m-d")."%")->count("queue_id");
				//等待桌数
				$v["waiting_num"] = $waiting_num;
				$canteen_type[$k] = $v;
				//等待时间,
				$waiting_time = $v['waiting_time'];
				$v["waiting_time"] = $waiting_num*$waiting_time;
				$canteen_type[$k] = $v;
				//判断有没有取号，得到取号数据
				$take_number = Db::name('queue_online')->field('queue_id,type_id,dining_num,queue_status')->where("canteen_id",$canteen_id)->where("user_id",$user_id)->where("queue_status",1)->where("create_date",'like',date("Y-m-d")."%")->find();
				if($take_number){ //已取号queue_status,取号状态，1已取号，0已取消，-1已失效
					//判断取号处于桌号的那种类型
					if($take_number["type_id"] === $v["type_id"]){
						//取号等待桌数,比排队的少1
						$task_num = $waiting_num - 1;
						$take_number["waiting_num"] = $task_num;
						//取号等待时间，暂时无计算方案
						$take_number["waiting_time"] = $task_num*$waiting_time;
						//取号状态
						$res["queue_status"] = $take_number["queue_status"];
						//取号数据
						$res["take_number"] = $take_number;		
					}
					
				}else{
					//取号状态
					$res["queue_status"] = 0;
					//取号数据
					$res["take_number"] = array();
				}
			}
			//距离
			$res["canteen_distance"] = getdistance($lng_lat,$res["current_lng_lat"]);
			//判断餐厅状态canteen_status，1正常营业，2休息中
			$date_arr = explode("-",$res["business_hours"]);
			if(strtotime($date_arr[0]) <=$current_time  && $current_time <= strtotime($date_arr[1])){
				$res["canteen_status"] = 1;
			}else{
				$res["canteen_status"] = 2;
			}	

			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{//查询失败
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}		
		return $data;
	}
	//餐厅取号排队
	public function canteen_take(){	//请求参数,canteen_id,desk_num,user_id && 把,queue_status,改为1;
		$request = Request::instance();
		$canteen_id = $request ->param("canteen_id");		//餐厅id
		$desk_num = $request ->param("desk_num");			//就餐人数
		$user_id = Session::get('user_id');					//用户id

	    //根据餐厅id得到餐桌
		$res = Db::name('canteen_type')->where("canteen_id",$canteen_id)->select();
		//根据就餐人数得到餐桌号类型
		foreach ($res as $k => $v) {
			if(substr($v["desk_num"],0,1) <= $desk_num){
				//根据餐桌id,type_id,得到有多少人排队
				$type_id = $v["type_id"];
				$canteen_num = Db::name('queue_online')->where("type_id",$type_id)->where("create_date",'like',date("Y-m-d")."%")->count("queue_id");
				$dinner_num = $v["dinner_num"];
			}
		}
		//排队人数增加1
		$dinner_num = $dinner_num.($canteen_num+1);

		//添加排队数据
		$queue_id = Db::name('queue_online')->insertGetId(['canteen_id'=>$canteen_id,'user_id'=>$user_id,"type_id"=>$type_id,"desk_num"=>$desk_num,"dining_num"=>$dinner_num,"queue_status"=>1,"create_date"=>date("Y-m-d H:i:s")]);

		if($queue_id){
			$data["code"] = 200;
			$data["msg"]  = "取号成功";
			$data["queue_id"] = $queue_id;
		}else{
			$data["code"] = 400;
			$data["msg"]  = "取号失败";
		}
		return $data;
	} 
	//餐厅取消排队
	public function canteen_cancel(){	//请求参数,queue_id && 把,queue_status,改为0;
 		$request = Request::instance();
		$queue_id = $request ->param("queue_id");			//取号id
		$res = Db::name('queue_online')->where("queue_id",$queue_id) ->update(["queue_status"=>0,"update_date"=>date("Y-m-d H:i:s")]);
		if($res !== false){
			$data["code"] = 200;
			$data["msg"]  = "取消成功";
		}else{
			$data["code"] = 400;
			$data["msg"]  = "取消失败";
		}
		return $data;
	} 
	//取号详情
	public function take_number_details(){
		$request = Request::instance();
		$queue_id = $request ->param("queue_id");		//排队id
		$res =  Db::name('queue_online')->where("queue_id",$queue_id)->alias("a")->join("canteen b","a.canteen_id = b.canteen_id")->join("canteen_type c","a.type_id = c.type_id")->field("a.canteen_id,a.type_id,dining_num,waiting_time,canteen_name,dining_num,queue_status,desk_name,canteen_hint,a.create_date,address,current_lng_lat")->find();
		if ($res) {
			//等待桌数，queue_status == 1
			$waiting_num = Db::name('queue_online')->where("canteen_id",$res["canteen_id"])->where("type_id",$res["type_id"])->where("queue_status",1)->where("create_date",'like',date("Y-m-d")."%")->count("queue_id");
			if($waiting_num){
				$waiting_num = $waiting_num - 1;
			}
			//预估等待时间
			$res["waiting_num"] = $waiting_num;
			$res["waiting_time"] = $waiting_num*$res["waiting_time"];
			//已等待时间
			$date = strtotime(date("Y-m-d H:i:s"));
			$create_date = strtotime($res["create_date"]);
			$already_date =floor(($date - $create_date)%86400/60);
			$res["already_date"] = $already_date;

			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}
		return $data;
	}
	//餐厅评论
	public function canteen_comment(){	//请求参数canteen_id,comment_content,comment_level
		$request = Request::instance();
		$canteen_id = $request ->param("canteen_id");		//餐厅id
		$comment_content = $request ->param("comment_content");			//评论内容
		$comment_level = $request ->param('comment_level');					//评论等级
		$res = Db::name('canteen_comment')->insert(["canteen_id" => $canteen_id,"comment_content"=>$comment_content,"comment_level"=>$comment_level]);
		if($res){
			$data["code"] = 200;
			$data["msg"]  = "评论等级成功";
		}else{
			$data["code"] = 400;
			$data["msg"]  = "评论失败";
		}
		return $data;
	}
	//全部餐厅
	public function canteen_all(){
		$res = Db::name('canteen')->select();
		if($res->isEmpty() || $res){ //查询成功
			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{//查询失败
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}		
		return $data;
	}
	//查看餐厅-优惠卷关联的餐厅
	public function store_look(){	//请求参数card_id
		$request = Request::instance();
		$card_id = $request ->param("card_id");			//卡卷id
		//查找餐厅
		$res = Db::name('card_canteen')->where("card_id",$card_id)->alias('a')->join('canteen b ','b.canteen_id= a.canteen_id')->field("canteen_name,canteen_logo,address,phone")->select();
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
}
?>