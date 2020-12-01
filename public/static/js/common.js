// 批量转换图片
$(document).ready(function(){
  setTimeout(function(){
      $(".selectImg").each(function(){
          var _this = this;
          var text = $(this).attr("data-original");
          var str = text.substr(text.length-4);
          if(str == '.txt' || text.indexOf('.html' > 10)) {
            sendAjax(text, function(base64Src) {
              $(_this).attr("src", base64Src);
            })
          } else {
            $(_this).attr("src", text);
          }
      });
  }, 200)

  function sendAjax(url, callback) {
    $.ajax({
      url: url,
      dataType: 'text',
      success: function(base64Src) {
        callback(base64Src)
        // $(_this).attr("src", data);
      }
    })
  }
})
