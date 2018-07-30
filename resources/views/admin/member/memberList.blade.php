@extends('admin/common/basic')
@section('content')

    <meta name="csrf-token" content="{{csrf_token()}}">

    <body class="layui-anim layui-anim-up">
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so">
                <input class="layui-input" placeholder="开始日" name="start" id="start">
                <input class="layui-input" placeholder="截止日" name="end" id="end">
                <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <xblock>
            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
            <button class="layui-btn" onclick="x_admin_show('添加用户','{{url('admin/memberAdd')}}',600,500)"><i class="layui-icon"></i>添加</button>
            <span class="x-right" style="line-height:40px">共有数据：88 条</span>
        </xblock>
        <table class="layui-table">
            <thead>
            <tr>
                <th>
                    <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
                </th>
                <th>ID</th>
                <th>用户名</th>
                <th>性别</th>
                <th>手机</th>
                <th>邮箱</th>
                <th>地址</th>
                <th>邮编</th>
                <th>加入时间</th>
                <th>状态</th>
                <th>操作</th></tr>
            </thead>
            <tbody>
            @foreach($members as $member)
            <tr>
                <td>
                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$member->id}}'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td>{{$member->id}}</td>
                <td>{{$member->name}}</td>
                <td>{{$member->gender}}</td>
                <td>{{$member->mobile}}</td>
                <td>{{$member->email}}</td>
                <td>{{$member->address}}</td>
                <td>{{$member->post_code}}</td>
                <td>{{$member->created_at}}</td>
                <td class="td-status">
                    @if($member->status ==0)
                        <span class="layui-btn layui-btn-normal layui-btn-disabled">已停用</span>
                    @else
                        <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
                    @endif
                </td>
                <td class="td-manage">
                    <a onclick="member_stop(this,{{$member->id.','.$member->status}})" href="javascript:;"  title="启用">
                        <i class="layui-icon">&#xe601;</i>
                    </a>
                    <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/memberEdit?id=').$member->id}}',600,400)" href="javascript:;">
                        <i class="layui-icon">&#xe642;</i>
                    </a>
                    <a onclick="x_admin_show('修改密码','{{url('admin/memberCpwd?id=').$member->id}}',600,400)" title="修改密码" href="javascript:;">
                        <i class="layui-icon">&#xe631;</i>
                    </a>
                    <a title="删除" onclick="member_del(this,'{{$member->id}}')" href="javascript:;">
                        <i class="layui-icon">&#xe640;</i>
                    </a>
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>

        <div class="page">
           {{$members->links()}}
        </div>

    </div>
    <script>
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

        layui.use('laydate', function(){
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#start' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#end' //指定元素
            });
        });

        /*用户-停用*/
        function member_stop(obj,id,status){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // alert(status);
            if($(obj).attr('title')=='启用')
                var tag = '停用';
            else
                var tag = '启用';

            layer.confirm('确认要'+tag+'吗？',function(index){

                $.ajax({
                    url:"memberEdit",
                    type:"post",
                    dataType:"json",
                    data:{id:id,status:status},
                    success:function(data){

                        if(data.status){
                            if($(obj).attr('title')=='启用'){

                                //发异步把用户状态进行更改
                                $(obj).attr('title','停用')
                                $(obj).find('i').html('&#xe62f;');

                                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                                layer.msg('已停用!',{icon: 5,time:1000});

                            }else{
                                $(obj).attr('title','启用')
                                $(obj).find('i').html('&#xe601;');

                                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                                layer.msg('已启用!',{icon: 1,time:1000});
                            }
                        }
                    }
                });

            });
        }

        /*用户-删除*/
        function member_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    url:"memberDel",
                    type:"delete",
                    dataType:"json",
                    data:{id:id},
                    success:function(data){
                        //发异步删除数据
                        $(obj).parents("tr").remove();
                        layer.msg(data.message,{icon:1,time:1000});

                    }

                });

            });
        }



        function delAll (argument) {

            var data = tableCheck.getData();


            layer.confirm('确认要删除吗？'+data,function(index){
                $.ajax({
                    type:"DELETE",
                    url:"memberDel",
                    data:{id:data},
                    dataType:"json",
                    success:function(data){
                        layer.msg(data.message, {icon: 1});
                        $(".layui-form-checked").not('.header').parents('tr').remove();

                    }
                });
                //捉到所有被选中的，发异步进行删除
            });
        }
    </script>

    </body>

@stop
