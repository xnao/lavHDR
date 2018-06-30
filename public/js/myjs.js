
function changePassword(id){//change admin password
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var newpassword = $('#password').val();
    $.ajax({
        type: "POST",
        url: "/admin/changepwd",
        data: {id:id,newpwd:newpassword},
        dataType: "json",
        success: function(data){
            layer.msg(data.msg,{icon:1,time:1000});
        }
    });
}

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