<?php 
namespace app\admin\Model;
use think\Model;
use app\admin\Model\PropertyType;
/**
 * 商品属性名表
 */
class PropertyName extends Model
{
	public function getCidAttr($value)
	{
		$PropertyType = new PropertyType;
		$type = $PropertyType ->where('cid',$value)->find();
		return $type->type_name;
	}
	//关联商品属性表
	public function propertyValue()
	{
		return $this->belongsTo('PropertyValue','name_id','name_id')->bind('value,value_id'); //注意，此处的外键是Product表的外键字段名
	}
}
?>