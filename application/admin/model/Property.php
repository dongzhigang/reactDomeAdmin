<?php 
namespace app\admin\Model;
use think\Model;
/**
 * 商品 属性名  属性值 关联表
 */
class Property extends Model
{
	public function propertyName()
	{
		return $this->belongsTo('PropertyName','name_id','name_id')->bind('title'); //注意，此处的外键是Product表的外键字段名
	}
	public function propertyValue()
	{
		return $this->belongsTo('PropertyValue','value_id','value_id')->bind('value','value_id'); //注意，此处的外键是Product表的外键字段名
	}
}

?>