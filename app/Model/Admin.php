<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    public function getLevelAttribute($value){


        switch ($value){
            case '0':
                $output = "super admin";
                break;
            case '1':
                $output = "admin";
            break;
            default:
                $output = "unknow";
            break;
        }

        return $output;


    }




}
