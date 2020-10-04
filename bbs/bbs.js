$(function() {

  // アコーディオン
  $('section h3').each(function(){
    $(this).click(function(){
      $(this).next('.accordion').slideToggle(500);
      $(this).toggleClass('open');
    });
  });

  // パスワード表示
  $('#passcheck').change(function(){
    if ( $(this).prop('checked') ) {
        $('#password').attr('type','text');
    } else {
        $('#password').attr('type','password');
    }
  });


  //最初は球技を表示しておく
  $("#category").val("1");
  categoryChange();
  
  //categoryを選択したら
  $("#category").change(categoryChange);

});

function categoryChange(){
  
  //categoryを取得
  var category = $("#category").val();
  
  //パラメータ
  var parameter = "category=" + category;
 
  //Ajax送信
  $.ajax({
    url:"bbs_category.php",
    data:parameter,
    dataType:"json",
    cache:false,
    success:successFunction,
  });
}

function successFunction(data){
  
  //#subcategoryの子要素を削除
  $("#subcategory").empty();
          
  //JSONを読み込む
  for(var i = 0; i < data.length; i++){
    
    //サブカテゴリを取得
    var subcate = data[i]["subcate"];
    
    //optionを作成、追加する
    var option = $("<option>");
    option.text(subcate);
    $("#subcategory").append(option);
  }
}
