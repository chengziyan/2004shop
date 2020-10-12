<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    //指定表名
    protected $table="user";
    //制定主键
    protected $primaryKey="id";
    //不自动添加时间
    public $timestamps=false;
    //黑名单
    protected $guarded=[];
}
