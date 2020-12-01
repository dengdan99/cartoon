/*
    大体思路：
    1.对于所有的img标签，把真实的地址放入自定义属性data-img
    2.当滚动页面时，检查页面所有的img标签，看看这个标签是否出现到我们的视野，当出现在我们的视野时
    再去判断它是否已经加载过，如果没有加载，加载它
    */

    
    // 用户第一次打开页面，还未滚动窗口的时候需要执行一次 lazyRender
    $(document).ready(function(){
      lazyRender();
      var clock;
      $(window).on('scroll',function(){
           //用户鼠标滚轮滚动一次，有多次事件响应。下面的 setTimeout 主要是为性能考虑，只在最后一次事件响应的时候执行 lazyRender，若在300毫秒内再次滚动则清除原来的定时器
          if(clock){
              clearTimeout(clock);
          }
          clock = setTimeout(function(){
              lazyRender();
          }, 300)
          
      })
  
  
      function lazyRender() {
          $('img.lazyImg').each(function(){
              //判断图片是否出现在可视窗口和图片是否已经加载
              if( checkShow($(this)) && !isLoaded($(this)) ){
                  //若图片出现在可是区域且没有加载，加载图片
                  loadImg($(this));
              }
          })
      }
  
      //判断图片出没出现在可视窗口
      function checkShow($img) {
        //获取浏览器窗口高度
        var windowHeight = $(window).height(),
        //获取窗口滚动的高度
            windowScrolltop = $(window).scrollTop(),
        //获取图片到页面顶部的高度
            imgOffsettop = $img.offset().top,
        //获取图片元素自己的高度,包括内外边距
            imgHeight = $img.outerHeight(true);
        if(windowHeight + windowScrolltop >= imgOffsettop && imgOffsettop + imgHeight >= windowScrolltop){
          return true;
        }
        return false;
      }
  
      //判断图片加没加载过
      function isLoaded($img) {
        return $img.attr('data-original') == $img.attr('src');
      }
              
      //加载图片
      function loadImg($img) {
          var _self = this;
          var text = $img.attr("data-original");
          var str = text.substring(text.length-4);
          if(str == '.txt' || text.indexOf('.html' > 10)) {
              $.ajax({
                  url: text,
                  dataType: 'text',
                  success: function(data, status) {
                  $img.attr("src", data);
                  $img.attr("data-original", data);
                      // obj.src = data
                  }
              })
          } else {
              $img.attr("src", text);
          }
          // $img.attr('src',$img.attr('data-original'))
      }
  })