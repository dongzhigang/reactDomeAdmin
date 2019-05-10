<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin;
use app\admin\Controller\Common;
class User extends Common
{
	//查询用户列表
    public function user()
    {	
    	// 查询数据
    	$admin = new Admin;
    	$lists = $admin->paginate(10);
    	$page = $lists->render();
        $empty = $lists->all();
    	$this->assign('page', $page);
    	$this->assign('lists', $lists);
        $this->assign('empty', $empty);
		// 渲染模板输出
		return $this->fetch();
    }
    //添加用户
    public function add_data()
    {
        $data = array(
            'userName'      => $_REQUEST['userName'],
            'password'          => $_REQUEST['password'],
            'limits'        => $_REQUEST['limits'],
        );
        $admin = new Admin;
        $res =  $admin ->data($data)->allowField(true)->save();
        if($res){
            $arrayName = array('code' => 0, 'data' => "添加成功" ); 
        }else{
            $arrayName = array('code' => 1, 'data' => "添加失败" ); 
        }
        header("Content-type: text/json");
        echo json_encode($arrayName);
    }
    //删除用户
    public function del_data()
    {
        $id = $_REQUEST['id'];
        $Commodity = new Admin;
        $res = $Commodity -> destroy(["id"=>$id]);
        if($res){
            $arrayName = array('code' => 0,'data' => "删除成功" );
        }else{
            $arrayName = array('code' => 1,'data' => "删除失败" );
        }
        header("Content-type: text/json");
        echo json_encode($arrayName);
    }
    //更新用户
    public function update_data()
    {

        $data = array(
            'userName'      => $_REQUEST['userName'],
            'password'          => $_REQUEST['password'],
            'limits'        => $_REQUEST['limits'],
        );
        $admin = new Admin;
        $res = $admin -> where("id",$_REQUEST['id']) -> update($data);
        if($res === false){
            $arrayName = array('code' => 1, "data" => array(), 'msg' => "修改失败" ); 
        }else{
            $arrayName = array('code' => 0, "data" => array(), 'msg' => "修改成功" ); 
        }
        header("Content-type: text/json");
        echo json_encode($arrayName); 
    }
    //编辑用户view渲染模板
    public function update(){
        $id = $_REQUEST['id'];
        $admin = new Admin;
        $res = $admin -> where("id",$id) ->find();
        if($res){
            $this -> assign("data",$res -> toArray());
        }else{
            $this->error("网络错误");
        }
       // 渲染模板输出
       return $this->fetch(); 
    }
}