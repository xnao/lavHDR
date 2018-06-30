@extends('admin/common/layout')

@section('title') {{--to show yield content--}}
    INDEX
@stop
@section('tabName')
    Desktop
@stop

@section('tabIcon')
    &#xe68e;
@stop

@section('content')

    <div class="x-body layui-anim layui-anim-up">
        <blockquote class="layui-elem-quote">欢迎管理员：{{'ID: ('.Auth::guard('admin')->user()->id.') '.Auth::guard('admin')->user()->username}}<br />
            <span class="x-red">test</span>！当前时间: {{date('Y-m-d H:i:s')}}</blockquote>
    </div>
@stop
