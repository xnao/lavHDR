<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


/**
 * Class adminPost
 * @package App\Http\Requests
 *
 *
 * MY NOTE:
 * for use this request section, replace the
 * function abc(Request $request){}
 * to
 * function abc(adminPost $request){}
 */
class adminPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return false;
        return Auth::guard('admin')->check();
    }


    //customized rules, rules name is check_password,
    public function addValidator(){
        Validator::extend('check_password',function ($attribute,$value,$parameters,$validator){
           return Hash::check($value,Auth::guard('admin')->user()->password);
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->addValidator();
        return [
            //use request to validate user's input
            //sometimes when the fileds shows on the page, then need to validate

            //use own customized rule:check_password
            'oldpwd' =>'sometimes|required|check_password',
            'newpwd' =>'sometimes|required|confirmed',
            'newpwd_confirmation'=>'sometimes|required',
        ];
    }

    public function messages()
    {
        return [
          'check_password'    => ':attribute is different with the system',
          'required'        => ':attribute is must fillin',
          'confirmed'       => ':attribute is not same as the new password',

        ];
    }

    public function attributes()
    {
        return [
            'oldpwd'    =>'旧密码',
            'newpwd'    =>'新密码'
        ];
    }
}
