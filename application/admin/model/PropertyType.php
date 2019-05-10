<?php 
namespace app\admin\Model;
use think\Model;
/**
 * 商品类目表
 */
class PropertyType extends Model
{
	//关联商品属性表
	 public function propertyName()
	{
		return $this->belongsTo('PropertyName','cid','cid')->bind('title,name_id'); //注意，此处的外键是Product表的外键字段名
	}
}
?>