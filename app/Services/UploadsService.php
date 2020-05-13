<?php


namespace App\Services;


use App\Exceptions\FailException;

class UploadsService extends Service
{
   public function upload($file,$path='uploads/wechat',$rule=['jpg', 'png', 'gif','mp4','wmv','avi','aac','amr','ape','wav','m4r','mmf','wma','mp3','ogg','ogv']){
       $url_path =$path.'/'.date('Ymd');
       $rule = $rule;
       if ($file->isValid()) {
           $clientName = $file->getClientOriginalName();
           $tmpName = $file->getFileName();
           $realPath = $file->getRealPath();
           $entension = $file->getClientOriginalExtension();
           if (!in_array($entension, $rule)) {
               throw new FailException(['message'=>'格式不正确']);
           }
           $newName = md5(date("Y-m-d H:i:s") . $clientName) . "." . $entension;
           $file->move($url_path, $newName);
           $namePath = $url_path . '/' . $newName;
           return $namePath;
       }

   }
}