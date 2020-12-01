

function subcomment() {
    var uid = $('#session_uid').val();
    var comment = $('#content').val().trim();
    var book_id = $('#book_id').val();
    // if (uid == '-1') {
    //     ShowDialog('请先登录');
    // } else 
    if (comment.length <= 0) {
        ShowDialog('请勿提交空评论');
    } else {
        $.ajax({
            method: 'post',
            url: '/commentadd',
            data: {comment: comment, book_id: book_id},
            success: function(res) {
                $('#content').val('');
                if (res.err == 1) {
                    ShowDialog(res.msg);
                } else {
                    ShowDialog(res.msg);
                    setTimeout(function () {
                        location.reload();
                    },1000)
                }
            },
            error: function(res) {
                ShowDialog('表单提交出错');
                return false;
            }
        })
    }
}