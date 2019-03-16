<?php
namespace App\Handlers;

class ImageUploadHandler{
    //只允许以下后缀名的图片上传
    //使用protected 防止外部修改
    protected $allowed_ext=['jpg','png','gif','jpeg'];


    public function save($file,$folder,$file_prefix){
        //构建存储的文件夹规则,值如:uploads/images/avatars/201901/21
        //文件夹切割能让查找效率更高
        $folder_name="uploads/images/$folder/".date('Ym/d',time());

        //文件具体存储的物理路径,~pubLic_path()`获取的是`public`文件夹的物理路径
        //值如:/var/docker/wwwroot/blog/public/uoloads/images/avatar/201903/21/
        $upload_path=public_path().'/'.$folder_name;
        //获取文件的后缀名,因图片从剪切板黏贴的时候后缀名微空,所以确保后缀一直存在
        $extension=strtolower($file->getClientOriginalExtension())?:'png';
        //拼接文件名,加前缀是为了增加辨析度,前缀可以是相关数据模型的ID
        //值如:1_14923123_sqrq.png
        $filename=$file_prefix.'_'.time()."_".str_random(10).'.'.$extension;
        //如果上传的不是图片,将终止炒作
        if(!in_array($extension,$this->allowed_ext)){
            return false;
        }
        //将图片移动到我们的目标存储路径中
        $file->move($upload_path,$filename);
        return [
            'path'=>config('app.url')."/$folder_name/$filename"
        ];
    }
}