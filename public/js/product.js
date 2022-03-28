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

    // $.ajaxSetup({
    //   headers: {
    //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //   },
    // });

    e.preventDefault();
    var textField = $('.keyword');
    var selectField = $('.maker');
    var rowPriceField = $('.rowPrice');
    var highPriceField = $('.highPrice');
    var rowStockField = $('.rowStock');
    var highStockField = $('.highStock');

    var keyword = textField.val();
    var maker = selectField.val();
    var rowPrice = rowPriceField.val();
    var highPrice = highPriceField.val();
    var rowStock = rowStockField.val();
    var highStock = highStockField.val();

    console.log('called');

    $.ajax({
      type: 'POST',
      url: 'product/search',
      data: {
        keyword: keyword,
        maker: maker,
        rowPrice: rowPrice,
        highPrice: highPrice,
        rowStock: rowStock,
        highStock: highStock
      },
      dataType: 'json', //データをjson形式で飛ばす
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
    .done(function(data) {
      const productsList = $('#products-list');
    
      // Delete all the list rows
      //ジェークエリーに書き直す
      document.querySelectorAll('#products-list > tr').forEach(row => {
        row.remove()
      });
      
      if (data.length > 0) {
        data.forEach(product => {
          const newRow = `
            <tr>
              <td>${product.product_id}</td>
              <td>${product.company_name}</td>
              <td>${product.product_name}</td>
              <td>${product.price}</td>
              <td>${product.stock}</td>
              <td><img src="${ window.location.href }/storage/${product.image_path}" alt="${product.product_name}" width=100% /></td>
              <td><a href="${ window.location.href }/product/${product.product_id}" class="btn btn-primary">詳細表示</a></td>
              <td><a href="#" class="product-delete-button btn btn-primary">削除</a></td>
            </tr>
          `;
  
          productsList.append(newRow);
        })
      }
    })
    .fail(function() {
      console.log('errorですよ！');
    });
  });

  // $('.product-delete-button').forEach(button => button.on('click', (e) => {
  //   console.log('clicked')
  //   const targetProductId = e.target.getAttribute('data-product-id');
  //   console.log(e.target);
  //   // Ajax call to delete product of the id.

  // }));

  // $(function() {
  //   $('.product-delete-button').on('click', function() {
  //     var deleteConfirm = confirm('削除してよろしいでしょうか？');

  //     console.log('called');
  
  //     if(deleteConfirm == true) {
  //       var clickEle = $(this)
  //       // 削除ボタンにユーザーIDをカスタムデータとして埋め込んでます。
  //       var productID = clickEle.attr('data-product-id');

  //       console.log(productID);

  //       $.ajax({
  //         headers: {
  //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //         },
  //         type: 'POST',
  //         url: 'product/delete/' + productID,
  //         data: {'id': productID,
  //         '_method': 'DELETE'},
  //         datatype: "json"
  //       })
  
  //      .done(function() {
  //         // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
  //         clickEle.parents('tr').remove();
  //         console.log('通信成功');
  //       })
  
  //      .fail(function() {
  //         alert('エラー');
  //       });
  
  //     } else {
  //       (function(e) {
  //         e.preventDefault()
  //       });
  //     };
  //   });
  // });

});
$(function() {
  $(".product-delete-button").on('click', function(){
    $(function(){
      $('a').on('click',function(event){
        event.preventDefault();
      });
    });
    var deleteConfirm = confirm('削除してよろしいでしょうか？');
  
    console.log('called');
  
    if(deleteConfirm == true) {
      var btnid = $(this).data("id");
      deleteData(btnid);
    }
  });
  
  function deleteData(btnid) {
    $.ajax({
      type: 'POST',
      dataType:'json',
      //データを投げる先のphpを指定。
      url:'product/delete/' + btnid,
      data:{
          btnid:btnid,
      }
    }
  )};
});

$(function() {
  $("#sortTable").tablesorter(); 
  console.log('calleddd');
}); 

// $(function(){
//   $('#sortTable').tablesorter({
//     headers: {
//       0: { sorter: "digit"}, /// => テキストとしてソート
//       1: { sorter: "text"}, /// => テキストとしてソート
//       2: { sorter: "text"}, /// => 数値としてソート
//       3: { sorter: "digit"},
//       4: { sorter: "digit"},
//       5: { sorter: false }
//     },
//     sortList: [[0,1],[2,0]],  
//   });
// });