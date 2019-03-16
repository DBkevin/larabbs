<?php
namespace App\Handlers;
use Image;
class ImageUploadHandler{
    //只允许以下后缀名的图片上传
    //使用protected 防止外部修改
    protected $allowed_ext=['jpg','png','gif','jpeg'];

    /**
     * 图片保存类
     *
     * @param [type] $file
     * @param [string] $folder
     * @param [int] $file_prefix
     * @param [int] $max_width
     * @return void
     */
    public function save($file,$folder,$file_prefix,$max_width=false){
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

        //如果限制了图片宽度,就进行裁剪
        if($max_width && $extension !="gif"){
            //调用裁剪类
            $this->reduceSize($upload_path.'/'.$filename,$max_width);
        }
        return [
            'path'=>config('app.url')."/$folder_name/$filename"
        ];
    }
    /**
     * 图片大小调整
     *
     * @param [path_string] $file_path
     * @param [int] $max_width
     * @return void
     */
    public function reduceSize($file_path,$max_width){
        //先实例类,传参是磁盘物理路径
        $image=Image::make($file_path);
        //进行大小调整
        $image->resize($max_width,null,function($constraint){
            //设定宽度是$max_width,高度等比例缩放
            $constraint->aspectRatio();
            //防止图片裁剪后变大
            $constraint->upsize();
        });
        //对图片进行保存
        $image->save();
    }
}