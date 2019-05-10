<?php
namespace app\index\controller;
use think\Controller;
class Index
{

    public function index()
    {
    	//添加数据
    	// $leng = 10;
    	//餐厅数据 canteen
    	// $data = [
    	// 			'canteen_name' => '小熊美食(天河南二路店)', 
    	// 			'canteen_logo' => 'http://127.0.0.1/restaurantAdmin/public/images/tem/logo.png',
    	// 			'tag_desc'	   => '西餐',
    	// 			'current_lng_lat'=>'113.329127,23.126902',
    	// 			'comment_score' => 2,
    	// 			'address'=>'天河南二路33号丰兴广场首层华润万家超市隔壁',
    	// 			'phone'	=>	'13632482567',
    	// 			'business_hours' => '11:00-22:00',
    	// 			'crowd_state' => 1,
    	// 			'Waiting_tables'=>9
    	// 		];
    	// for($i=0;$i<$leng;$i++){
    	// 	Db::name('canteen')->insert($data);
    	// }
        
        return "111"; 
    }
}