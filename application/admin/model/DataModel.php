<?php
namespace app\admin\model;
use think\Model;
use think\Db;
/**
 * 原型mysql
 */
class DataModel extends Model
{	
	// 设置当前模型对应的完整数据表名称
    var $table = 'commodity';
	//查询数据列表
	public function data_list($page,$rows,$type)
	{	
		$res =  Db::table($this->table)->where("type=".$type)->page($page,$rows)->select();
		if($res){
			return json_encode($res);

		}else{
			return "查询失败";
		}
	}
	//添加数据
	public function data_add($data)
	{	
		$id = Db::table($this->table)->insert($data);
		if($id){
			return "添加成功";
		}else{
			return "添加失败";
		}
	}
}