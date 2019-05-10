<?php 
namespace app\admin\Controller;
use think\Controller;
use app\admin\Model\PropertyType;
use app\admin\model\PropertyName;
use app\admin\model\PropertyValue;
/**
 * 
 */
class Property extends Controller
{
	
	//商品属性
    public function property()
    {
    	$cid = $_GET['id'];
        $array = Array();
        $propertyType = new PropertyType;
        $type = $propertyType -> where('cid',$cid) ->find();
        $res = $propertyType -> propertyName() ->where('cid',$cid)->select();
        // dump($type);exit;
        // foreach ($res as $key => $value) {
        //     $type = $value;
        // }
        // dump($res);exit;
        $this->assign('list', $res);
        $this->assign('type', $type);
        return $this->fetch();
    }
    //添加商品属性
    public function property_add()
    {
        $data = Array(
            'cid'       => $_REQUEST['cid'],
            'name_id'   => md5(uniqid(md5(microtime(true)),true)),
            'title'     => $_REQUEST['title'],
            'is_sale'   => $_REQUEST['is_sale']
        );
        // dump($data);
        $propertyName = new PropertyName;
        $res = $propertyName -> save($data);
        if($res){
            $arrayName = array('code' => 0, "data" => array(),'msg' => "添加成功" ); 
        }else{
            $arrayName = array('code' => 1, "data" => array(),'msg' => "添加失败" ); 
        }
        return json($arrayName);
    }
    //删除属性
    public function del_datalist()
    {
    	$id = $_REQUEST['id'];
    	$propertyName = new PropertyName;
    	$propertyValue = new PropertyValue;
    	$name_id = $propertyName -> where("id",$id) ->find()->name_id;
    	$res = $propertyName -> destroy(["id"=>$id]);
    	$res = $propertyValue  -> destroy(["name_id"=>$name_id]);
    	if($res){
            $this->success('删除成功', 'Property/property');
        }else{
        	$this->error('删除失败');
        }
    }
    //添加属性值view模板
    public function addproperty($id) 
    {
    	$propertyName = new PropertyName;
    	$res = $propertyName ->where('id',$id)->find();
    	$this->assign('name_id', $res->name_id);
    	$this->assign('title', $res->title);
    	return $this->fetch();
    }

    //新增属性值
    public function newproperty()
    {
    	$data = Array(
            'value_id'  =>md5(uniqid(md5(microtime(true)),true)),
    		'name_id'   => $_REQUEST['name_id'],
    		'value'     => $_REQUEST['value']
    	);
    	$propertyValue = new PropertyValue;
    	$res = $propertyValue -> where('value',$_REQUEST['value'])->find();
    	if($res){
    			$arrayName = array('code' => -1, "data" => array(),'msg' => "属性值存在" );
    	}else{
    		$res = $propertyValue -> save($data);
    		if($res){
	            $arrayName = array('code' => 0, "data" => array(),'msg' => "添加成功" ); 
	        }else{
	            $arrayName = array('code' => 1, "data" => array(),'msg' => "添加失败" ); 
	        }
    	}
        return json($arrayName);
    }
    //删除属性值
    public function del_data()
    {
    	$id = $_REQUEST['id'];
    	$propertyValue = new PropertyValue;
    	$res = $propertyValue -> destroy(["id"=>$id]);
    	if($res){
            $this->success('删除成功', 'Property/property');
        }else{
        	$this->error('删除失败');
        }
    }

    //查看属性值view
    public function examine($id)
    {
    	$propertyName = new PropertyName;
        $res = $propertyName->propertyValue()->where("name_id",$id)->select();
        // dump($res);
        // exit;
        $this->assign('data', $res);
    	return $this->fetch();
    }
}
?>