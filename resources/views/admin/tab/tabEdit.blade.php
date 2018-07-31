@extends('admin/common/basic')


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

<fieldset class="layui-elem-field">
    <legend>Edit Tab</legend>
    <div class="layui-field-box">
        <form class="layui-form layui-col-md12 x-so">



            <div class="layui-col-md12 x-so">
                <h1>{{$details->name}}</h1>



                <input type="text" id="newTab" name="tab[newName]"
                       value="@if(null==old('tab')['newName']){{$details->name}}@else{{old('tab')['newName']}}@endif"

                       required="" lay-verify="required"
                       autocomplete="off" class="layui-input" placeholder="new tab name">



                <button type="button" class="layui-btn" name="change" value="Change"
                        onclick="updateTab('{{$details->id}}')">
                    <i class="layui-icon" />update
                </button>
            </div>
        </form>

    </div>
</fieldset>
@stop