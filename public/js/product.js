
//検索機能
jQuery.noConflict();
$(function() {
  $('.form-inline').on('submit', function(e) {

    e.preventDefault();
    let orderField = $('#order')
    let textField = $('.keyword');
    let selectField = $('.maker');
    let rowPriceField = $('.rowPrice');
    let highPriceField = $('.highPrice');
    let rowStockField = $('.rowStock');
    let highStockField = $('.highStock');


    let order = orderField.val();
    let keyword = textField.val();
    let maker = selectField.val();
    let rowPrice = rowPriceField.val();
    let highPrice = highPriceField.val();
    let rowStock = rowStockField.val();
    let highStock = highStockField.val();

    console.log('called');

    $.ajax({
      type: 'POST',
      url: 'product/search',
      data: {
        order: order,
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

      console.log('通信成功だよ〜ん');
    
      // Delete all the list rows
      document.querySelectorAll('#products-list > tr').forEach(row => {
        row.remove()
      });
      
      let url = $(location).attr('origin') + $(location).attr('pathname');
      console.log(url);

      
      if (data.length > 0) {
        data.forEach(product => {
          const newRow = `
            <tr>
              <td>${product.product_id}</td>
              <td>${product.company_name}</td>
              <td>${product.product_name}</td>
              <td>${product.price}</td>
              <td>${product.stock}</td>
              <td><img src="${ url }/storage/${product.image_path}" alt="${product.product_name}" width=100% /></td>
              <td><a href="${ url }/product/${product.product_id}" class="btn btn-primary">詳細表示</a></td>
              <td id="parents"><a href="#" data-product-id="${product.product_id}" class="product-delete-button btn btn-primary">削除</a></td>
            </tr>
          `;

          productsList.append(newRow);
        })
      }

    })
    .fail(function() {
      console.log('errorですよ');
    });
    //クラス付与の確認
    let check = $('a').hasClass('product-delete-button');
 
    console.log( check );
  });

});

//ソート機能
jQuery.noConflict();
$(function() {
  $('#order').on('change', function(e) {
    e.preventDefault();
    let textField = $('.keyword');
    let selectField = $('.maker');
    let rowPriceField = $('.rowPrice');
    let highPriceField = $('.highPrice');
    let rowStockField = $('.rowStock');
    let highStockField = $('.highStock');
    let orderField = $('#order')

    let keyword = textField.val();
    let maker = selectField.val();
    let rowPrice = rowPriceField.val();
    let highPrice = highPriceField.val();
    let rowStock = rowStockField.val();
    let highStock = highStockField.val();
    let order = orderField.val();

    console.log(highStock);
    console.log(order);
    console.log('called');

    $.ajax({
      type: 'POST',
      url: 'product/search',
      data: {
        order: order,
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

      console.log('通信成功だよ〜ん');
    
      // Delete all the list rows
      document.querySelectorAll('#products-list > tr').forEach(row => {
        row.remove()
      });
      
      let url = $(location).attr('origin') + $(location).attr('pathname');
      console.log(url);

      
      if (data.length > 0) {
        data.forEach(product => {
          const newRow = `
            <tr>
              <td>${product.product_id}</td>
              <td>${product.company_name}</td>
              <td>${product.product_name}</td>
              <td>${product.price}</td>
              <td>${product.stock}</td>
              <td><img src="${ url }/storage/${product.image_path}" alt="${product.product_name}" width=100% /></td>
              <td><a href="${ url }/product/${product.product_id}" class="btn btn-primary">詳細表示</a></td>
              <td id="parents"><a href="#" data-product-id="${product.product_id}" class="product-delete-button btn btn-primary">削除</a></td>
            </tr>
          `;

          productsList.append(newRow);
        })
      }

    })
    .fail(function() {
      console.log('errorですよ');
    });
    //クラス付与の確認
    let check = $('a').hasClass('product-delete-button');
 
    console.log( check );
  });
});

//削除機能呼び出し
jQuery.noConflict();
$(function() {
  $(document).on('click','.product-delete-button', function() {

    let clickEle = $(this);
    // 削除ボタンにユーザーIDをカスタムデータとして埋め込んでます。
    let productID = clickEle.attr('data-product-id');

    if(confirm('削除してよろしいでしょうか？')) {

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: 'product/delete',
        data: {'id': productID},
        datatype: "json"
      })
      .done(function() {
        console.log('通信成功!');

        clickEle.closest("tr").remove();
      })
  
      .fail(function() {
        console.log('エラー');
      });
  
    } else {
      (function(e) {
        e.preventDefault()
      });
    };
  });
});
