@extends('admin/common/basic')
@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}"/>

    <button class="layui-btn" onclick="x_admin_show('New Tabs','{{url('admin/tabAdd')}}',600,400)"><i class="layui-icon"></i>Add New Tab</button>

    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>


    <table class="layui-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created</th>
            <th>Updated</th>
            <th colspan="2">Manage</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $records)
        <tr>
            <td>{{$records->id}}</td>
            <td>{{$records->name}}</td>
            <td>{{$records->created_at}}</td>
            <td>{{$records->updated_at}}</td>
            <td><a href="javascript:;" onclick="x_admin_show('Edit Tab','{{url('admin/tabEdit?id=').$records->id}}',600,400)">Modify</a></td>

            <td><a title="删除" onclick="tabDel('{{$records->id}}','{{$records->name}}')" href="javascript:;">
                    <i class="layui-icon"></i>
                </a></td>
        </tr>
        @endforeach
        </tbody>
    </table>









@stop
