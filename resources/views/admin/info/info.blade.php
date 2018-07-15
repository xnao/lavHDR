@extends('admin/common/basic')


@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <fieldset class="layui-elem-field">
        <legend>管理员信息</legend>
        <div class="layui-field-box">
            <table class="layui-table">
                <tbody>

                @foreach($admins as $admin)
                    @if(is_array($admin))
                        @foreach($admin as $ad)
                            <tr>
                                <th>{{$ad->username}}</th>
                                <td>{{$ad->level}}</td>
                                <td>
                                    @if(Auth::guard('admin')->user()->id != $ad->id)
                                    <a title="删除" onclick="admin_del(this,'{{$admin->id}}')" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th>{{$admin->username}}</th>
                            <td>{{$admin->level}}</td>
                            <td>
                                @if(Auth::guard('admin')->user()->id != $admin->id)
                                <a title="删除" onclick="admin_del(this,'{{$admin->id}}','{{$admin->username}}')" href="javascript:;">
                                    <i class="layui-icon">&#xe640;</i>
                                </a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach

                </tbody>
            </table>
        </div>
    </fieldset>





    <fieldset class="layui-elem-field">
        <legend>修改密码</legend>
        <div class="layui-field-box">
            <form class="layui-form layui-col-md12 x-so">



                    <div class="layui-col-md12 x-so">


                        <input type="text" id="oldpassword" name="admin[oldpassword]"
                               value="{{old('admin')['password']}}"
                               required="" lay-verify="required"
                               autocomplete="off" class="layui-input" placeholder="old password">
                        {{$errors->first()}}
                        <input type="text" id="newpassword" name="admin[newpassword]"
                               value="{{old('admin')['password']}}"
                               required="" lay-verify="required"
                               autocomplete="off" class="layui-input" placeholder="new password">

                        <input type="text" id="passwordconfirm" name="admin[newpassword_confirmation]"
                               value="{{old('admin')['password']}}"
                               required="" lay-verify="required"
                               autocomplete="off" class="layui-input" placeholder="re-type password">

                        <button type="button" class="layui-btn" name="change" value="Change"
                                onclick="changePassword({{Auth::guard('admin')->user()->id}})">
                            <i class="layui-icon" />修改密码
                        </button>
                    </div>
            </form>

        </div>
    </fieldset>



@stop