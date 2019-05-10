<?php 
namespace app\admin\Common;
use think\File;
/**
 * 文件上传
 */
class Common 
{
	//单个文件上传
	public function fileUploads($img,$name)
	{
		// 获取表单上传文件 例如上传了001.jpg
	    $file = request()->file($img);
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    if($file){
	        $info = $file->rule('uniqid')->move(ROOT_PATH.'public/uploads/images/'.$name.'/');
	        if($info){
	            // 成功上传后 获取上传信息
	            // 输出 jpg
	            // return $info->getExtension();
	            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
	            // return 'uploads/images/'.$info->getSaveName();
	            // 输出 42a79759f284b767dfcb2a0197904287.jpg
	            $str = $info->getSaveName();
	            return 'public/uploads/images/'.$name.'/'.str_replace('\\',"/",$str); 
	        }else{
	            // 上传失败获取错误信息
	            return $file->getError();
	        }
	    }
	}

	//生成商品编码
	public function pro_no()
	{
		return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
	}
}
?>
