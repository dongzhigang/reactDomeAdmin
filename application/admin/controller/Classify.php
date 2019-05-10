<?php 
namespace app\admin\Controller;
use think\Controller;
use app\admin\model\PropertyType;
use app\admin\model\PropertyValue;
use app\admin\Controller\Common;
/**
 * 商品分类
 */
class Classify extends Common
{
	
	//渲染view模板商品分类
    public function index()
    {
        $propertyType = new PropertyType;
        $lists =  $propertyType -> all();
        $this->assign('lists', $lists);
        return $this->fetch();
    }
    //渲染分类编辑view模板
    public function update()
    {   
        $id = $_REQUEST['id'];
        $propertyType = new PropertyType;
        $res = $propertyType ->where("id",$id)->find();
        if($res){
            //商品渲染
            $this->assign("data",$res->toArray());
        }else{
             $this->error("网络错误");
        }
        return $this->fetch();
    }
    //添加分类数据
    public function add_data()
    {
    	$data = array(
            'cid'       => md5(uniqid(md5(microtime(true)),true)),        //类目ID
            'type_name' => $_REQUEST['type_name'],                        //类目名称
            'dosc'    	=> $_REQUEST['dosc']                              //分类描述
        );
    	$propertyType = new PropertyType;
        $res = $propertyType ->where("type_name",$_REQUEST['type_name'])->find();
        if($res){
            $arrayName = array('code' => 2, 'data' => array() ,"msg" => "分类已存在");
        }else{
            $res =  $propertyType ->data($data)->allowField(true)->save();
            if($res){
                $arrayName = array('code' => 0, 'data' => array() ,'msg' => "添加成功" ); 
            }else{
                $arrayName = array('code' => 1, 'data' => array() ,'msg' => "添加失败" ); 
            }
        }
        return json($arrayName);
    }
    //更新分类
    public function update_data()
    {
        $data = array(
            'type_name'     => $_REQUEST['type_name'],                            //类目名称
            'dosc'          => $_REQUEST['dosc']                              //分类描述
        );
        $propertyType = new PropertyType;
        $res = $propertyType -> where("id",$_REQUEST['id']) -> update($data);
        if($res === false){
            $arrayName = array('code' => 1, "data" => array(), 'msg' => "修改失败" ); 
        }else{
            $arrayName = array('code' => 0, "data" => array(), 'msg' => "修改成功" ); 
        }
        return json($arrayName);
    }
    //删除分类
    public function del_data()
    {
    	$cid = $_REQUEST['cid'];
        $propertyType = new PropertyType;
        $name_id = $propertyType -> propertyName() -> where("cid",$cid) ->find()->name_id;
        $res = $propertyType -> propertyName() ->  where('cid',$cid)->delete();
        $propertyValue = new PropertyValue;
        $res = $propertyValue -> where('name_id',$name_id)->delete();
        $res = $propertyType -> where('cid',$cid)->delete();
        if($res){
            $arrayName = array('code' => 0,'data' => array() ,'msg' => "删除成功" );
        }else{
            $arrayName = array('code' => 1,'data' => array() ,'msg' => "删除失败" );
        }
        return json($arrayName);
    }

    //查找分类
    public function set_type(){
        if(isset($_REQUEST['id'])){
            //商品分类
            $propertyType = new PropertyType;
            $res = $propertyType -> all();;
            if($res){
                $arrayName = array('code' => 0,'data' => $res ,'msg' => "请求成功" );
            }else{
                $arrayName = array('code' => 1,'data' => array() ,'msg' => "请求失败" );
            }
            return json($arrayName);
        }
    }
    //查找属性
    public function set_property(){
        //商品分类
        $propertyType = new PropertyType;
        $res = $propertyType -> propertyName() -> where('cid',$_REQUEST['id'])->select();
        if($res){
            $arrayName = array('code' => 0,'data' => $res ,'msg' => "请求成功" );
        }else{
            $arrayName = array('code' => 1,'data' => array() ,'msg' => "请求失败" );
        }
        return json($arrayName);
    }
    //查找属性值
    public function set_propertyValue()
    {
        $propertyValue = new PropertyValue;
        $res = $propertyValue->where("name_id",$_REQUEST['id'])->select();
        if($res){
            $arrayName = array('code' => 0,'data' => $res ,'msg' => "请求成功" );
        }else{
            $arrayName = array('code' => 1,'data' => array() ,'msg' => "请求失败" );
        }
        return json($arrayName);
    }
}
?>

