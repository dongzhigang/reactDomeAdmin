<?php 
namespace app\api\model;
use think\Model;
use think\Db;
use think\Request;			//接收请求信息
use think\Validate;			//验证请求参数
use think\Session;
/**
 *
 *用户处理
 * 
 */
class User extends Model
{	
	//用户信息
	public function user_info(){
		$user_id = Session::get('user_id');
		//查询用户
		$res = Db::name('user')->where("user_id",$user_id)->find();
		if($res){ //查询成功
			$data["code"] = 200;
			$data["msg"]  = "查询成功";
			$data["data"] = $res;
		}else{//查询失败
			$data["code"] = 400;
			$data["msg"]  = "查询失败";
		}		
		return $data;
	}
	//用户信息保存
	public function user_info_preserve(){
		$request = Request::instance();
		$user_id = Session::get('user_id');
		$phone = $request ->param("phone");			//手机
		$user_name = $request ->param("user_name");			//用户名
		$birthday = $request ->param("birthday");			//出生日期
		/**验证规则条件*/
		$rules = [
		    'user_name'  => 'require|max:25',
		    'phone'   => 'require|max:11|regex:/^1[3-8]{1}\d{9}$/',
		];
		//提示信息
		$msg = [
		    'user_name.require' => '用户名必须',
		    'user_name.max'     => '名称最多不能超过25个字符',
		    'phone.require' => '手机号码必须',
		    'phone.max'   => '手机号码最多不能超过11个字符',
		    'phone.regex'   => '手机号码格式不正确',
		];
		$paramData = [
		    'user_name'  => $user_name,
		    'phone'   =>$phone,
		];
		$validate = new Validate($rules, $msg);
		$result   = $validate->check($paramData);
		if($result === false){
			$data["code"] = 400;
			$data["msg"] = $validate->getError();
		}else{
			$res = Db::name('user')->where("user_id",$user_id)->update(['user_name' => $user_name,"phone"=>$phone,"birthday"=>$birthday]);
			if($res!==false){
				$data["code"] = 200;
				$data["msg"] = "更新成功";
			}else {
				$data["code"] = 400;
				$data["msg"] = "保存失败";
			}
		}
		return $data;
	}
	//用户用餐记录
	public function dinner_record(){
		$user_id = Session::get('user_id');
		$res = Db::name('dinner_record')->where("user_id",$user_id)->select();
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
	//积分规则
	public function integration_rule(){
		//积分规则
		$res = Db::name('integration_rule')->select();
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
	//积分获取
	public function integration_acquire(){
		$user_id = Session::get('user_id');
		//积分获取
		$res = Db::name('integration_acquire')->where("user_id",$user_id)->select();
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
	//积分支出,关联卡卷表card_shopping查询
	public function integration_expend(){
		$user_id = Session::get('user_id');
		//积分支出查询卡卷订单是否已使用is_expend==1
		$res = Db::name('my_coupon')->where("user_id",$user_id)->where("is_expend",1) ->alias('a')->join('card_shopping b ','b.card_id= a.card_id')->select();
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
}
?>