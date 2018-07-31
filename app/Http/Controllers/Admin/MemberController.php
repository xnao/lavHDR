<?php

namespace App\Http\Controllers\Admin;

use App\Model\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;


class MemberController extends Controller
{
    //show member list
    public function memberList(){
//        Redis::set("name","ABC");
//echo Redis::get("name");

        //get member list form database
        $members = Member::paginate(2);
        return view('admin/member/memberList', ['members'=>$members]);
    }

    //show member add page
    public function memberAdd(Request $request){
        if($request->ajax()){

            //validate the input
            $this->validate($request,
                [

                ],
                [

                ],
                [


                ]);



            try{



//                $res = Member::updateOrCreate(['id'=>$request->post('id')],$request->post())
//                ->setGenderAttribute($request->post('gender'));
                $res = Member::updateOrCreate(['id'=>$request->post('id')],$request->post('data'))
                ->setGenderAttribute($request->post('gender'));
//                $res = new Member();
//                $res->name=$request->post('name');
//                $res->mobile=$request->post('mobile');
//                $res->address=$request->post('address');
//                $res->post_code=$request->post('post_code');
//                $res->email=$request->post('email');
//                $res->setGenderAttribute($request->post('gender'));
//                $res->save();

            }catch(\Exception $e){
                //generate log for records
                report($e);
                return $e;

                return "for unknow reason the insert failed";
            }
            return ['status'=>true,'msg'=>'成功'];

        }else{

            return view('admin/member/memberAdd');
        }
    }

    //edit member info

    /**
     * @param Request $request
     */
    public function memberEdit(Request $request){
        if($request->ajax()){
//          $this->validate($request,[],[][]);
            if($request->post('status')==0){
                $new_status=1;
            }elseif ($request->post('status')==1){
                $new_status=0;
            }
            try{
                $result = Member::find($request->post('id'))->update(['status'=>$new_status]);
//                $result = Member::find(9987)->update(['status'=>$new_status]);
            }catch (\Exception $e){
                $msg=['status'=>false];
            }
            $msg = ['status'=>true];
            return $msg;
        }

        if($request->isMethod('get')){
            if(Member::where('id',$request->get('id'))->doesntExist()){
                return "not found";
            }
            //get user info
            $detail = Member::find($request->get('id'));

            return view('admin/member/memberEdit', ['detail'=>$detail]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword(Request $request){
        if($request->ajax()){
           //update password

//            $res = Member::where('id','=',$request->post('id'))
//                ->update(['password'=>$request->post('new_pwd')]);

            Member::find($request->post('id'))
                ->update(['password'=>$request->post('new_pwd')]);





        }else{
            //get user info for ID
            $user = Member::find($request->get('id'));
            return view('admin/member/changepwd',['user'=>$user]);
        }
    }

    public function memberDel(Request $request){
        if($request->isMethod('delete')){
            if(Member::destroy($request->id)){
                $data['status'] =true;
                $data['message'] ="Delete Success";
            }else{
                $data['status']=false;
                $data['message']="Error, Unable to delete";
            }
            return $data;
        }


    }




}
