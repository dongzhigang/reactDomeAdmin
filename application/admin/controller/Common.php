<?php 
namespace app\admin\Controller;;
use think\Controller;
use think\Session;
/**
 * 公共部分
 */
class Common extends Controller
{
	
	function _initialize()
	{
		//判断用户是否登录
		if (Session('?userName')) {
			$userName = Session::get('userName');
			$limits = Session::get('limits');
			$this->assign("userName",$userName);
			$this->assign("limits",$limits);
		}else{
			$this->error('对不起,您还没有登录!请先登录再进行浏览','Login/login');
		}
	}
	//单个文件上传
	public function fileUploads()
	{
		// 获取表单上传文件 例如上传了001.jpg
		$images = array();
		$errors = array();
	    $files = request()->file();
	    dump($files);
	    exit;
	    foreach ($files as $key => $file) {
	    	$info = $file->rule('uniqid')->move('public/uploads/images/tem/');
	        if($info){
	            // 成功上传后 获取上传信息
	            // 输出 jpg
	            // return $info->getExtension();
	            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
	            // return 'uploads/images/'.$info->getSaveName();
	            // 输出 42a79759f284b767dfcb2a0197904287.jpg
	            $str = $info->getSaveName();
	            $path = 'public/uploads/images/tem/'.str_replace('\\',"/",$str);
	            array_push($images,$path);
	        }else{
	            // 上传失败获取错误信息
	            array_push($errors,$file->getError());
	        }
	    }
	    if(!$errors){
			$msg['code'] = 0;
			$msg['data'] = $images;
			return json($msg);
		}else{
			$msg['code'] = 1;
			$msg['data'] = $images;
			$msg['msg'] = "上传出错";
			return json($msg);
		}
	}

	//更换目录
	public function change($img,$name) 
	{	
		$path = str_replace('/tem',$name,$img);
		$arr = explode('/',$path);
		array_splice($arr,-1);
		$str  = implode('/',$arr);						//新的目录
		if(!is_dir($str)){
			mkdir($str);
		}
		if(file_exists($img)){
			rename($img,$path);
		}

	}

	//生成商品编码
	public function pro_no()
	{
		return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
	}

	//删除图片
	public function unlink($img){
		if(isset($img)){
			unlink($img);
		}
	}
}

?>