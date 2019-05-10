<?php 
// 应用公共文件
// 
/*
 计算两个坐标的距离 单位km千米
*/
function getdistance($point1, $point2)
{
    $p1=explode(",",$point1);
    $p2=explode(",",$point2);
   // 将角度转为狐度
    $radLat1 = deg2rad($p1[1]); //deg2rad()函数将角度转换为弧度
    $radLat2 = deg2rad($p2[1]);
    $radLng1 = deg2rad($p1[0]);
    $radLng2 = deg2rad($p2[0]);
    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;
    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
    //如果大于30km
    // if($s>30*1000){
    //   $s="大于30km";
    // }else if($s>=1000){
    //   $s= round($s/1000,2)."km";
    // }else if($s<1000){
    //  $s=  round($s)."m";
    // }
    if($s>=1000){
        $s = round($s/1000,2)."km";
    }else if($s<1000){
        $s = round($s)."m";
    }
    return $s; 
}
//会员卡
function club_card(){
    header("content-type:text/html;charset=utf-8");         //设置编码
    header("Content-type:image/png");
    $myImage=imageCreatetruecolor(553,256); //参数为宽度和高度
    $bg=ImageCreateFromPng("public/images/clubCard/cardBg.png");

    $color=imagecolorallocatealpha($myImage , 255 , 255 , 255 ,0);//拾取一个完全透明的颜色
    // imagealphablending($myImage ,false);//关闭混合模式，以便透明颜色能覆盖原画布
    imagefill($myImage , 0 , 0, $color);//填充
    imagecopy($myImage,$bg,0,0,0,0,553,256);             // 将背景图片拷贝到画布相应位置

    $font = "public/images/font/consolab.ttf";
    $str = "NO.12345678";
    $white=ImageColorAllocate($myImage, 255, 255, 255);
    imagettftext($myImage, 18, 0, (553-strlen($str)*15), 30, $white,$font,$str);
    ImagePng($myImage,'public/images/clubCard/clubCard.png');
    $url =  "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME'])."/public/images/clubCard/clubCard.png";
    imagedestroy($bg);                                   // 销毁背景图片
    ImageDestroy($myImage);
    return $url;
}
//订单编号
function order_num(){
    $str = date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    return $str;
}
?>