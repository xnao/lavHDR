@extends('admin/common/basic')

@section('content')
    <meta name ="csrf-token" content="{{csrf_token()}}" />


    <form class="layui-form">
        <h4>用户：{{$user->name}}</h4>

        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>新密码：
            </label>

            <div class="layui-input-inline">
                <input type="text" id="new_pwd" name="new_pwd" required="" lay-verify="text"
                       autocomplete="off" class="layui-input" placeholder="新密码">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  type="button" onclick="changepwd({{$user->id}})"   class="layui-btn" >
                修改
            </button>
        </div>


    </form>

    <script>
        function changepwd(id){
            $.ajaxSetup({ headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});
            var new_pwd = $("#new_pwd").val();

            $.ajax({

                type:'post',
                url:'memberCpwd',
                data:{id:id,new_pwd:new_pwd},
                dataType:"json",
                success:function(data){
                    alert (data.msg);
                }



            });

        }

    </script>

@stop