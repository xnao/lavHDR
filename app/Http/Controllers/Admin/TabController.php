<?php

namespace App\Http\Controllers\Admin;

use App\Model\Tab;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TabController extends Controller
{
    //
    public function tabList(Request $request){
        if($request->isMethod('get')){
            //list all the tabs
            $list = Tab::all();
            return view('admin/tab/tabList',['list'=>$list]);

        }elseif ($request->isMethod('post')){
            //add/update tabs
            if($request->ajax()){
            $update = Tab::where('id','=',$request->input('id'))
                ->update(['name'=>$request->input('tab')]);
            return $msg = ['status'=>'success','msg'=>'update successful'];



            }

        }elseif ($request->isMethod('delete')){
            //remove tabs
        }
    }

    public function tabEdit(Request $request){
        $details = Tab::find($request->input('id'));
//        var_dump($details);
        return view('admin/tab/tabEdit',['details'=>$details]);

    }

    public function tabAdd(Request $request){
        if($request->ajax()){
            $this->validate($request,
                [//rules
                    'tab.name'   =>  'required|between:3,9|unique:tabs,name',
                ],
                [//message
                    'required'  => ':attribute 必填',
                    'between'   => ':attribute 必须在:min与:max之间',

                ],
                [
                    'tab.name' => '新标签名称',

                ]);


            //if passed the validate, then will continue to execute the following code
            Tab::create($request->post('tab'));
            return $msg=['status'=>true,'message'=>'success'];

        }else{
            return view ('admin/tab/newTab');
        }
    }

    public function tabDel(Request $request){
        if($request->ajax()){
            $result = Tab::where('id','=',$request->post('id'))->delete();
            if($result){
                $msg =['status'=>1,'message'=>'has been deleted'];
            }else{
                $msg=['statsu'=>false,'message'=>'delete tab failed'];
            }
            return json_encode($msg);
        }

    }
}
