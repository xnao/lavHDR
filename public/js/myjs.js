
//change admin password
function changePassword(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //capture use's input
    var newpassword = $('#newpassword').val();
    var passwordconfirm = $('#passwordconfirm').val();
    var oldpassword = $('#oldpassword').val();
    //check if the password is identical
    if(newpassword === passwordconfirm){
        $.ajax({
            type: "POST",
            url: "/admin/changepwd",
            data: {id: id, newpwd: newpassword, oldpwd: oldpassword, newpwd_confirmation: passwordconfirm},
            dataType: "json",

            success: function (data) {
                layer.msg(data.msg, {icon: 1, time: 1000});
            },

            //if the server response code is not 200, then triger this error function
            //to captu
            error: function (jqXHR, textStatus, errorThrown) {
                /*弹出jqXHR对象的信息*/
                alert(jqXHR.responseText);
                alert(jqXHR.status);
                alert(jqXHR.readyState);
                alert(jqXHR.statusText);
                /*弹出其他两个参数的信息*/
                alert(textStatus);
                alert(errorThrown);
            }
        });

    }else{
        layer.msg('密码不相同',{icon:1,time:1000});
    }


}

//remove admins
function admin_del(obj,id,adminName){
    layer.confirm('确认要删除 '+adminName +' ?',function(index){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:"post",
            url:"/admin/adminDel",
            data:{id:id},
            dataType:"json",
            success:function(data){
                if(data.status){
                    $(obj).parents("tr").remove();//remove the deleted record from page table not database table
                    layer.msg('已删除!',{icon:1,time:1000});//show to front user the record has been removed
                }else{
                    alert(data.msg);
                }
            }
        })

    });
}


//edit tab
function updateTab(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var newTab = $('#newTab').val();
    $.ajax({
       type:'post',
       url:'tab',
       data:{id:id,tab: newTab},
       dataType:"json",
       success:function(data){
           parent.layer.msg(data.msg, {icon: 1, time: 1000});

       },
       error:function(data){
           layer.msg(data.msg, {icon: 1, time: 1000});
       }
    });


}

function tabDel(id,tabName){
    layer.confirm('确认要删除 '+tabName +' ?',function(index) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'post',
            dataType:"json",
            url:'tabDel',
            data:{id:id},
            success:function(data){
                if(data.status){
                    layer.msg(data.message,{icon:1,time:1000});

                }else{
                    layer.msg(data.message,{icon:1,time:1000});
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                /*弹出jqXHR对象的信息*/
                alert(jqXHR.responseText);
                alert(jqXHR.status);
                alert(jqXHR.readyState);
                alert(jqXHR.statusText);
                /*弹出其他两个参数的信息*/
                alert(textStatus);
                alert(errorThrown);
            }
        });



    });


}


function tabNew(){
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

    data1={};
    data1['name']=$('#newTab').val();
    $.ajax({
        type:"post",
        data:{tab:data1},
        dataType:"json",
        url:"tabAdd",
        success:function(data){
            if(data.status){
                layer.msg(data.message,{icon:1,time:1000});

            }

        },
        error:function (jqXHR, textStatus, errorThrown) {
            /*弹出jqXHR对象的信息*/
            alert(jqXHR.responseText);
            alert(jqXHR.status);
            alert(jqXHR.readyState);
            alert(jqXHR.statusText);
            /*弹出其他两个参数的信息*/
            alert(textStatus);
            alert(errorThrown);
        },
    });

}

function memberAdd(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // get users input
    if (undefined != $("#id").val())
        var id          = $("#id").val();
    else
        var id = null;

    // var name        = $("#name").val();
    // var email       = $("#email").val();
    // var gender      = $("#gender").val();
    // var mobile      = $("#mobile").val();
    // var address     = $("#address").val();
    // var post_code   = $("#post_code").val();


    var data ={
        "name":$("#name").val(),
        "email":$("#email").val(),
        "gender":$("#gender").val(),
        "mobile":$("#mobile").val(),
        "address":$("#address").val(),
        "post_code":$("#post_code").val(),
    };


    $.ajax({
        url: "memberAdd",
        type:"post",
        dataType: "json",
        // data:{id:id,name:name,email:email,gender:gender,mobile:mobile,address:address,post_code:post_code},
        data:{data:data},
        success:function(data){
            parent.layer.msg(data.msg, {icon: 1, time: 1000});
        }




    });

}



