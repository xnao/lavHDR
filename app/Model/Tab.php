<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    //允许批量添加的字段
    protected $fillable = ['name'];
    //不允许批量添加的字段
    protected $guarded=[];
}
