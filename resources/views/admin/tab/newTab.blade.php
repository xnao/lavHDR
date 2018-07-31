@extends('admin/common/basic')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}">

    <fieldset class="layui-elem-field">
        <legend>New Tab</legend>
        <div class="layui-field-box">
            <form class="layui-form layui-col-md12 x-so" action="" method="post">
                @csrf


                <div class="layui-col-md12 x-so">


                    <input type="text" id="newTab" name="tab[name]"
                           value="{{old('tab')['name']}}"
                           required="" lay-verify="required"
                           autocomplete="off" class="layui-input" placeholder="new tab name">



                    <button type="button" class="layui-btn" name="change" value="add" onclick="tabNew()">

                        <i class="layui-icon" />Add
                    </button>
                </div>
            </form>

        </div>
    </fieldset>

@stop