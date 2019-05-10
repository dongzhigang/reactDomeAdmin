<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
class Index
{

    public function index()
    {
    	//添加数据
    	$leng = 10;
    	//餐厅数据 canteen
    	$data = [
    				'classify_id' => 2, 
                    'canteen_id'   =>1,
    				'good_image' => 'http://127.0.0.1/restaurantAdmin/public/images/tem/tem01.png',
    				'good_name'	   => '黑椒厚切嫩牛排',
                    'good_type'    => '份',
    				'price'=>'59.00',
    				'original_price' => "78.00",
    			];
    	for($i=1;$i<=$leng;$i++){
    		Db::name('food_good')->insert($data);
    	}
        
        return "111"; 
    }
}

