
$('#btnsave').click(function () {
    var username = filterStr($('#username').val());
    if (!username.trim()){
        ShowDialog("昵称不能为空");
        return;
    }
    if (username.length > 12){
        ShowDialog("昵称不能太长");
        return;
    }
    $.ajax({
        method: 'post',
        url:'/userinfo',
        data:{username: username},
        success:function (res) {
            ShowDialog(res.msg);
            setTimeout(function () {
                // location.reload();
                window.location.href = '/ucenter'
            },1000);
        },
        error:function (data) {
            ShowDialog(data);
        }
    })
})

function filterStr(str)
{
    var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？%+_]");
    var specialStr = "";
    for(var i=0;i<str.length;i++)
    {
        specialStr += str.substr(i, 1).replace(pattern, '');
    }
    return specialStr;
}