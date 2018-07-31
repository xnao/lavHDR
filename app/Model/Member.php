<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Member extends Model
{
    //
    use Searchable;
    use SoftDeletes;
    protected $guarded=[];

    public function getGenderAttribute($gender){
        switch ($gender){
            case "1":
                $gender="男";
                break;
            case "0":
                $gender="女";
                break;
        }

        return $gender;
    }

    public function setGenderAttribute($value){
//dd($value);
        switch ($value){
            case "男":
                $this->attributes['gender']=1;
                break;
            case "女":
                $this->attributes['gender']=0;
                break;
            default:
                $g=9;
                break;

        }
        return $this->attributes['gender'];

    }

    public function setPasswordAttribute($value){
         $this->attributes['password'] = sha1($value);
    }
}
