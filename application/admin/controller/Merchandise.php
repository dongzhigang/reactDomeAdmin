<?php
namespace app\admin\Controller;
use think\Controller;
use app\admin\model\Product;
use app\admin\model\Property;
use app\admin\model\ProductImg;
use app\admin\Controller\Common;
/**
 * 商品查询
 */
class Merchandise extends Common
{	
	/**
     *渲染view模板商品列表
     */
    public function list_data()
    {   
        $Product = new Product;
        $list = $Product ->with('productSku,propertyType')->paginate(10);
        $page = $list->render();     
        $empty = $list->all();
        $this->assign('page', $page);
        $this->assign('list', $list);
        $this->assign('empty', $empty);
        //商品分类
        $type =  $Product->propertyType() -> select();
        $this->assign('type', $type);
        // 渲染模板输出
        return $this->fetch();
    }
    /**
     * 编辑商品view渲染
     */
    public function update($id)
    {   
        $Product = new Product;
        $res = $Product->with(['productSku','contents','propertyType','property'])->where("product_id",$id)->find();
        $value = $Product -> property() ->with('propertyValue') ->where(["product_id"=>$id,"name_id"=>$res->name_id]) ->select();
        // dump($valueAll);exit;
        if($res){
            //商品分类
            $type =  $Product->propertyType() -> select();
            $this->assign('type', $type);
            //属性
            $title = $Product->property()->with('propertyName')->where("name_id",$res->name_id)->find()->title;
            // dump($title);exit;
            $this->assign('title', $title);
            //属性值
            $this->assign('value', $value);
            //商品渲染
            $this->assign("res",$res->toArray());
        }else{
            $this->error("网络错误");
        }

        // 渲染模板输出
        return $this->fetch();
    }
    /**
     * 商品新增数据
     */
    public function add_data()
    {    
        // 实例化模型
        $Product = new Product;                                             //商品信息表
        $Common = new Common;                                               //公共部分

        $img = $_REQUEST['file'];
        $name = "/master";                                                   //主图目录
        $pathImg = str_replace('tem',$name,$img);                           //主图路径
        // echo $pathImg;exit;
        $date = date("Y-m-d");
        $Data = array(      
            'product_id'  => md5(uniqid(md5(microtime(true)),true)),        //商品id
            'cid'         => $_REQUEST['cid'],                              //分类id
            'pro_no'      => $Common -> pro_no(),                           //商品编码  
            'title'       => $_REQUEST['title'],                            //商品名称
            'keywords'    => $_REQUEST['keywords'],                         //商品关键词 
            'status'      => $_REQUEST['status'],                           //商品状态
            'img'         => $pathImg,                                          //商品主图
            'min_price'   => $_REQUEST['min_price'],                        //商品最低价               
            'docs'        => $_REQUEST['docs'],                             //商品描述
            'add_time'    => $date                                          //添加时间
        );
        $pieces = explode(",", $_REQUEST['cont_img']);                      //富文本图片路径
        $value_id = explode(",", $_REQUEST['value_id']);
        /**
         * 商品信息表
         * 
         */
        $res = $Product -> save($Data);
        // 更换主图图片目录
        $Common->change($img,$name);

        /**
         * 商品库存量表
         */
        $res = $Product -> productSku()  ->save(['price' => $_REQUEST['price'], 'stock' => $_REQUEST['stock']]);

        /**
         * 商品祥情描述
         */
            // 更换目录
        $detaName = "/DetailsImg";
        $content = str_replace("/tem",$detaName,$_REQUEST['content']);
        $res = $Product -> contents()    ->save(['content' => $content]);
        /**
         * 商品详情图片表
         */
        foreach ($pieces as $value) {
            $array = explode("/",$value);
            if (in_array("http:", $array))
            {
                $array = array_slice($array,4);
                $value = implode('/',$array);
                $values = str_replace("/tem",$detaName,$value);                      //替换掉临时目录
            }
            $res = $Product -> productImg()  ->save(['img' => $values,'add_time' => $date]);
            // 更换详情图片目录
            $Common->change($value,$detaName);
        }
        /**
         * 商品 属性名  属性值 关联表 property
         */
        foreach ($value_id as $value) {
          $res = $Product -> property() -> save(['name_id' => $_REQUEST['name_id'],'value_id' => $value]);
        }

        if($res){
            $arrayName = array('code' => 0, "data" => array(),'msg' => "添加成功" ); 
        }else{
            $arrayName = array('code' => 1, "data" => array(),'msg' => "添加失败" ); 
        }
        return json($arrayName);
    }
    /**
     * 商品更新
     * 
     */
    public function update_data()
    {   
        // 实例化模型
        $Product = new Product; 
        $Common  = new Common;

        $img = $_REQUEST['imgUrls'];
        $name = "/master";                                                  //主图目录
        $pathImg = str_replace('tem',$name,$img);                           //主图路径        
        $id = $_REQUEST['id'];                                              //获取产品id
        $date = date("Y-m-d");                                              //获取年月日
        $data = array(      
            'title'       => $_REQUEST['title'],                            //商品名称
            'keywords'    => $_REQUEST['keywords'],                         //商品关键词 
            'status'      => $_REQUEST['status'],                           //商品状态
            'cid'         => $_REQUEST['cid'],                              //商品分类
            'min_price'   => $_REQUEST['min_price'],                        //商品最低价               
            'docs'        => $_REQUEST['docs'],                             //商品描述
            'add_time'    => $date                                          //添加时间
        );
        $pieces  = explode(",", $_REQUEST['cont_img']);                     //富文本图片路径
        $value_id = explode(",", $_REQUEST['value_id']);                    //属性值id
        
        /**
         * 商品信息更新
         */
            //查询数据库主图路劲
        $path = $Product -> where("product_id",$id)->find()->img;           //保存原有图片路径，用于主图更新
            //判断路径是否一样，不一样就删除图片，一样就没有改变
        if($path != $pathImg){
             //删除图片
            $Common -> unlink($path);
        }
        $data['img'] = $pathImg;
        $res = $Product ->save($data,['product_id'=>$id]);
            // 更换主图图片目录
        $Common->change($img,$name);
        /**
         * 商品库存更新
         * 
         */
        $res = $Product ->productSku()->where('product_id',$id) ->update(['price'   => $_REQUEST['price'], 'stock' => $_REQUEST['stock']]);
        /**
         * 商品详情更新
         * 
         */
        $detaName = "/DetailsImg";
        $content = str_replace("/tem",$detaName,$_REQUEST['content']);                      //替换临时目录
        $res = $Product ->contents()  ->where('product_id',$id) ->update(['content' => $content]);        
            //获取请求图片路径集合,详情图更新
        $startName = Array(); //临时目录的路劲集合
        $endName = Array();   //更新目录的路劲集合
        foreach ($pieces as $key => $value) {
            $array = explode("/",$value);
            if (in_array("http:", $array))
            {
                $array = array_slice($array,4);
                $value = implode('/',$array);
                array_push($startName,$value);
                $value = str_replace("/tem",$detaName,$value);                      //替换掉临时目录
                array_push($endName,$value);
            }
        }
        $productImg = new ProductImg;
        $res = $productImg ->all(['product_id'=>$id]);                  //返回数据库的数据，获取图片路经集合
            //获取数据库图片路径集合
        $array = Array();
        foreach ($res as $key => $value) {
            array_push($array,$value->img);
        }
        $result=array_diff($array,$endName);                          //返回图片数据库数据和请求路径和的不同元素
        //检查文件是否存在
        foreach ($result as $key => $value) {
            if(file_exists($value)){                                    //文件存在，删除图片，删除没有用到的图片
                 //删除图片
                $Common -> unlink($value);
            }
        }
        //添加数据
        $data = Array();
        for ($i=0; $i < count($endName); $i++) { 
            $data[$i] = Array('img' => $endName[$i], 'add_time' => $date,'product_id'=>$id);
            // 更换详情图片目录
            $Common->change($startName[$i],$detaName);
        }
        $res = $productImg  ->where('product_id',$id) ->delete();
        $res = $productImg->saveAll($data);
        /**
         * 商品 属性名  属性值 关联表 property
         * 
         */
        $res = $Product ->property()  ->where('product_id',$id) ->delete();
        foreach ($value_id as $value) {
            $property = new Property; 
            $res = $property -> save(['name_id' => $_REQUEST['name_id'],'value_id' => $value,'product_id'=>$id]);
        }
        /**
         * 输出结果
         * 
         */
        $arrayName ='';
        if($res === false){
            $arrayName = array('code' => 1, "data" => array(), 'msg' => "修改失败" ); 
        }else{
            $arrayName = array('code' => 0, "data" => $arrayName, 'msg' => "修改成功" ); 
        }
        return json($arrayName);
    }
    //商品删除数据
    public function del_data()
    {
        $id = $_REQUEST['product_id'];
        $product = new Product;
        $Common = new Common;
         /**
         * 商品信息删除
         */
        //返回数据库图片路径集合，主图图片删除
        $imgRes = $product -> where('product_id',$id)->find()->img;

         //删除图片
        $Common -> unlink($imgRes);
        $res = $product -> where('product_id',$id)->delete();
        /**
         * 商品库存删除
         * 
         */
        $res = $product -> productSku() -> where('product_id',$id)->delete();
        /**
         * 商品详情删除
         * 
         */
        $res = $product -> contents() ->  where('product_id',$id)->delete();
        //返回数据库图片路径集合，详情图片删除
        $imgRes = $product -> productImg() -> where(['product_id'=>$id])->select();
        foreach ($imgRes as $key => $value) {
            $path = $value->img;
             //删除图片
            $Common -> unlink($path);
        }
        $res = $product -> productImg() -> where('product_id',$id)->delete();
        /**
         * 商品、属性名、属性值、关联表删除
         * 
         */
        $res = $product -> property() -> where('product_id',$id)->delete();
        /**
         * 输出结果
         * 
         */
        if($res){
            $arrayName = array('code' => 0, "data" => array(), 'msg' => "删除成功" );
        }else{
            $arrayName = array('code' => 1, "data" => array(), 'msg' => "删除失败" );
        }
        return json($arrayName);
    }
}

