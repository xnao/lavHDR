<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class EntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth')//use middleware
            ->except(['loginForm','login']);
        //except loginForm and Login function don't use this method when construct the class

    }

    //show login form
    public function loginForm(){

        return view('admin/entry/login');
    }

    //processing login
    public function  login(Request $request){
        //if this is post request, then processing the login
        if($request->isMethod('post')){



            //use Controller's validator
            $this->validate($request,
                 [//make rules
                     'login.username'       =>  'required|between:3,10',
                     'login.password'       =>  'required',

                 ],
                 [//explain the ruls
                     'required'     =>  ':attribute 是必填字段',
                     'between'      =>  ':attribute 必须是在:min和:max之间'
                 ],
                 [//explain field name
                     'login.username'       => '用户名',
                     'login.password'       => '密码',

                 ]
             );


            //use Auth for login process return bool
            //set up guard, so the auth will look the defined part(admins) not the default part(users)
            /**
             * For use Auth, you need do the following, use admin as example
             * 1. go to config/auth.php
             * 2. register new guards admin,
             * 2.1 set how to store the result by session driver = session
             * 2.2 set new guards providers is admins
             * 3. register new guards providers to bind the table admins
             */


            $status = Auth::guard('admin')->attempt([ //try to get input
                //format as:
                //'tableField' => $request->input('formInputName'),
                'username' => $request->input('login.username'),
                'password' => $request->input('login.password'),
            ],
                $request->has('login.remember')//check if need to remember,return bool
            );

            if($status){

                //login success
                return redirect()->guest('admin/index');
            }else{
                return redirect('admin/login')->with('error','username / password error');
            }


//            var_dump($request->session()->all());



        }else{
            return view('admin/entry/login');
        }

    }

    //show admin home page, the admin must be logged in,
    //to verify this, use middleware to verify
    public function index(){
        //use middle to verify
        /**
         * how to create and use middleware
         * 1. use php artisan make:middleware to create middleware
         * 2. register the middleware into Kernel.php
         * 3. use: $this->middleware('admin.auth') to active the middleware
         */

//        $this->middleware('admin.auth');
        $this->middleware('admin.auth');
        //use Auth::guard('guardName')->user()->tableFieldName; to get info
        //also can be used in the blade
//        Auth::guard('admin')->user()->username;


        return view('admin/entry/index');
    }

    //admin logout function
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

}
