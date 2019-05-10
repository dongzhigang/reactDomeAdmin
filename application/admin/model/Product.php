<?php 
namespace app\admin\Model;
use think\Model;
// use app\admin\Model\PropertyType;
/**
 * 商品信息表模块
 */
class Product extends Model
{	
    //设置产品状态
    public function getStatusAttr($value)
    {
        if($value == 0 ){
            return '下架';
        }else{
            return '上架';
        }
    }  
 	//关联商品库存量表
    public function productSku()
	{
		return $this->belongsTo('ProductSku','product_id','product_id')->bind('price,stock'); //注意，此处的外键是Product表的外键字段名
	}
    //关联商品详情表
	public function contents()
    {
        return $this->belongsTo('Contents','product_id','product_id')->bind('content');
    }
    //关联商品图片表
	public function productImg()
    {
        return $this->belongsTo('ProductImg','product_id','product_id');
    }

    //关联商品分类
    public function propertyType()
    {
        return $this->belongsTo('PropertyType','cid','cid')->bind('type_name');
    }
    //关联商品 属性名  属性值 关联表 property
    public function property()
    {
        return $this->belongsTo('Property','product_id','product_id')->bind('name_id,value_id');
    }
}

?>
