<?php

namespace App\Common\Lib;
use Illuminate\Support\Facades\Storage;

/**
 * base64jpeg格式图片
 * @class FileUpLoader
 * @author chengcheng
 */
class Base64Image
{
    public static function up($data)
    {
        $img = $data['img'];
        $checkString = substr($img, 0, 100);
        $filename = date('YmdHis') . '-' . uniqid() . '.' . "jpg";
        if(!empty($data['filename'])){
            $filename = $data['filename'];
        }
        $path='';
        //保存文件-存放
        if (preg_match('/^(data:image\/jpeg;base64,)/', $checkString, $result)) {
            //文件内容
            $fileInfo = base64_decode(str_replace($result[1], '', $img));

            //保存图片
            Storage::disk('uploads')->put($filename, $fileInfo);

            //文件路径
            $path = '/uploads/'.$filename;
        }
        return $path;

    }
}