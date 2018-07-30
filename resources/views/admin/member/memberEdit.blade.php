@extends('admin/common/basic')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}">
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            @if($detail)<input type="hidden" name="member[id]" id="id" value="{{$detail->id}}"/>@endif
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>用户名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="member[name]" required="" lay-verify="text"
                           autocomplete="off" class="layui-input" value ="{{$detail->name}}" placeholder="您的名字">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>邮箱
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="email" name="member[email]" required="" lay-verify="email"
                           autocomplete="off" class="layui-input" value="{{$detail->email}}" placeholder="您的名字">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>性别
                </label>
                <div class="layui-input-inline">
                    <select id="gender" name ="member['gender']">
                        @if(null !== $detail->gender)
                            <option value="{{$detail->gender}}" selected>{{$detail->gender}}</option>
                        @endif
                        <option value="男">男</option>
                        <option value="女">女</option>
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>手机
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="mobile" name="member[mobile]" required="" lay-verify="number"
                           autocomplete="off" class="layui-input" value="{{$detail->mobile}}" placeholder="手机号码">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>地址
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="address" name="member[address]" required="" lay-verify="text"
                           autocomplete="off" class="layui-input" value="{{$detail->address}}" placeholder="地址">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>邮编
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="post_code" name="member[post_code]" required="" lay-verify="text"
                           autocomplete="off" class="layui-input" value="{{$detail->post_code}}" placeholder="邮编">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>









            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  type="button" onclick="memberAdd()"   class="layui-btn" >
                    增加
                </button>
            </div>
        </form>
    </div>

@stop