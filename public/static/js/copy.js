function copy (id, attr) {
  var target = null;

  if (attr) {
      target = document.createElement('div');
      target.id = 'tempTarget';
      target.style.opacity = '0';
      if (id) {
          var curNode = document.querySelector('#' + id);
          target.innerText = curNode[attr];
      } else {
          target.innerText = attr;
      }
      document.body.appendChild(target);
  } else {
      target = document.querySelector('#' + id);
  }

  try {
      var range = document.createRange();
      range.selectNode(target);
      window.getSelection().removeAllRanges();
      window.getSelection().addRange(range);
      document.execCommand('copy');
      window.getSelection().removeAllRanges();
      alert("复制成功");
  } catch (e) {
      console.log('复制失败');
  }

  if (attr) {
      // remove temp target
      target.parentElement.removeChild(target);
  }
}