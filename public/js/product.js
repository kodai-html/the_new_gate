function checkDelete() {
  if(window.confirm('削除してよろしいですか')) {
    return true;
  } else {
    return false;
  }
}

$(function() {
  function searchForm(data) {
    //以下は検索機能

  }
  // console.log('called')
  $('.form-inline').on('submit', function(e) {
    e.preventDefault();
    var textField = $('.keyword');
    var selectField = $('.maker');

    var keyword = textField.val();
    var maker = selectField.val();

    console.log('called');

    $.ajax({
      type: 'POST',
      // url: 'http://localhost:8888/public/product/search',
      // url: '../app/models/product.php',
      // url: "{{ route('search') }}",
      url: 'http://localhost:8888/public/resources/views/product/list.blade.php',
      data: {
        keyword: keyword,
        maker: maker
      },
      dataType: 'json' //データをjson形式で飛ばす
    })

    .done(function(data) {
      alert(data);
    })
    .fail(function() {
      alert('errorですよ！');
      
    });
  });
});