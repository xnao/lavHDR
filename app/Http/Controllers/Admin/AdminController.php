<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\adminPost;
use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
//    public function changepwd(adminPost $request){
// using myOwn Request validator and so, for validator details check Request/adminPost


    public function changepwd(Request $request){
        //using Request validator and so
        $this->validate($request,
            [//rules
//                'id'                     => 'exists:admins,id',
                'oldpwd'                 => 'required',
                'newpwd'                 => 'required|confirmed|between:3,10',
                'newpwd_confirmation'    => 'required',

            ],
            [//explain the rules
                'required'      => ':attribute must filled in',
                'confirmed'     => ':attribute must as same as :attribute_confirmation',
                'between'       => ':attribute must between: :min and :max',

            ],
            [//define for translate variable to human readable
                'oldpwd'        => 'old / current password',
                'newpwd'        => 'new password',
                'newpwd_confirmation' => 'retype password',

            ]
        );








        if($request->ajax()){
            if(Hash::check($request->post('oldpwd'),Auth::guard('admin')->user()->password)){

                $admin = Admin::find($request->post('id'));
                $admin->password = bcrypt($request->post('newpwd'));
                if($admin->save()){
                    $msg = ['status'=>'success','msg'=>'password has been changed'];
                }else{
                    $msg = ['status'=>'failed','msg'=>'password change failed'];
                }
            }else{
                $msg = ['status'=>'failed','msg'=>'old password is wrong'];
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
