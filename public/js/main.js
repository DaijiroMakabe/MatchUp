$(function () {
  $('#active-btn'). on('click', function() {

      $('#active-btn').css('opacity', 0.5);
      // $('#inactive-btn').css('opacity', 100);
      // $('#btn').submit();
      // return true;
    });
  $('#inactive-btn'). on('click', function() {
      $('#inactive-btn').css('opacity', 0.5);
      $('#active-btn').css('opacity', 100);
    });
  // $('#app_btn'). on('click', function() {
  //     $('#app_btn').css('opacity', 0.5);
  //     $('#active-btn').css('opacity', 100);
  //   });
  // $('.switch, #del_btn'). on('click', function() {
  //     alert("aaaa");
  //   });
  // $('#del'). on('click', function() {
  //     alert("aaaa");
  //   });

  $('#add_friend_btn'). on('click', function() {
      $('a, #add_friend_btn').css('display', 'none');
    });
  // $('#add_friend_btn'). on('click', function() {
  //   $("#add_friend_btn").addClass("changed");
  //   });
  $('#delete'). on('click', function() {
    if(!confirm('本当に削除しますか？')){
      /* キャンセルの時の処理 */
      return false;
  }else{
      /*　OKの時の処理 */
      location.href = 'delete.php';
  }});
  $('#del_btn'). on('click', function() {
    if(!confirm('本当に削除しますか？')){
      /* キャンセルの時の処理 */
      return false;
  }else{
      /*　OKの時の処理 */
      $('#del_btn').submit();
  }});
});