<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    //
    public function index(){
        return view('admin/member/upload');
    }

    public function upload(Request $request){
        if($request->isMethod('post')){
            if($request->file('pics')){

                $files = $request->file('pics');
                foreach ($files as  $file) {

                    if($file ->isValid()){
                        $originalName = $file->getClientOriginalName(); // 文件原名
                        $ext = $files->getClientOriginalExtension();     // 扩展名
                        $realPath = $file->getRealPath();   //临时文件的绝对路径
                        $type = $file->getClientMimeType();     // image/jpeg

                        // 上传文件
                        $filename = $originalName;//date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                        // 使用我们新建的uploads本地存储空间（目录）
                        //这里的uploads是配置文件的名称
                        $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                        var_dump($bool);

                    }

                }

            }
        }
    }

}
