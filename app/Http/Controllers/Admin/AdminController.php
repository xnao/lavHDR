<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * display admin info
     * @return string
     */
    public function info(){
        //get admin info by auth?
        if(Auth::guard('admin')->user()->level ==0){
            //this is superAdmin, list all the admins
            $admins = Admin::get();
        }else{
            //this is normal admin, list its own info
            $admins = Admin::where('id','=',
                Auth::guard('admin')->user()->id)->get();
        }

//        dd($admins);


        return view('admin/info/info',['admins'=>$admins]);

    }

    //change admin password
    public function changepwd(Request $request){
        if($request->ajax()){

            $admin = Admin::find($request->post('id'));
            $admin->password = bcrypt($request->post('newpwd'));
            if($admin->save()){
                $msg = ['status'=>'success','msg'=>'password has been changed'];
            }else{
                $msg = ['status'=>'failed','msg'=>'password change failed'];
            }
            return json_encode($msg);
        }
    }

    //delete admin
    public function adminDel(Request $request){
        if($request->ajax()){
            $result = Admin::destroy($request->post('id'));
            if($result){
                $msg = ['status'=>'success','msg'=>'admin '.$request->post('id').' has been deleted'];
            }else{
                $msg = ['status'=>'success','msg'=>'Error for admin (id: '.$request->post('id').')'];
            }
            return json_encode($msg);
        }
    }
}
