function multipleaction(u){
  var f = document.querySelector("form");
  var a = f.setAttribute("action", u);
  document.querySelector("form").submit();
  }

// -------------------
// スクロールバー調整用
// -------------------
$(window).on('load', function() {

  var td1_width = $('#schedule thead td:nth-child(1)').outerWidth();
  var td2_width = $('#schedule thead td:nth-child(2)').outerWidth();
  var td3_width = $('#schedule thead td:nth-child(3)').outerWidth();

  $('#schedule tbody td:nth-child(2), #schedule thead td:nth-child(2)').css('left',td1_width +'px');
  $('#schedule tbody td:nth-child(3), #schedule thead td:nth-child(3)').css('left',td1_width + td2_width + 'px');
  $('#schedule tbody td:nth-child(4), #schedule thead td:nth-child(4)').css('left',td1_width + td2_width + td3_width +'px');

});


// -------------------
// リサイズ対策
// -------------------
$(window).resize(function() {

  var re_td1_width = $('#schedule tbody td:nth-child(1)').outerWidth();
  var re_td2_width = $('#schedule tbody td:nth-child(2)').outerWidth();
  var re_td3_width = $('#schedule tbody td:nth-child(3)').outerWidth();

  $('#schedule tbody td:nth-child(2), #schedule thead td:nth-child(2)').css('left',re_td1_width +'px');
  $('#schedule tbody td:nth-child(3), #schedule thead td:nth-child(3)').css('left',re_td1_width + re_td2_width + 'px');
  $('#schedule tbody td:nth-child(4), #schedule thead td:nth-child(4)').css('left',re_td1_width + re_td2_width + re_td3_width +'px');

});


$(function() {

  // -----------------------
  // スケジュール追加
  // -----------------------
  $(document).on('click', '.table-calendar td span', function() {

    // 日付を取得
    var year = $(this).parent().attr('data-year');
    var month = $(this).parent().attr('data-month')-1;
    var date = $(this).parent().attr('data-date');
    var dayOfWeekStrJP = [ "日", "月", "火", "水", "木", "金", "土" ] ;

    // Dateで変換
    var selectedDate = new Date (year,month,date) ;
    var fainally = selectedDate.getMonth()+1 + '/' + selectedDate.getDate() + '(' + dayOfWeekStrJP[selectedDate.getDay()] + ')';

    if ($(this).parent().hasClass('selected') == false) {

      $(this).parent().addClass('selected');

      //テーブル見出し
      if ($('#index').hasClass('heading')  == false) {
        $('#time_place table').append('<tr id="index"class="heading"><th>日付</th><th>開始</th><th>終了</th><th>場所</th></tr>');
      } 

      // 日付を作る
      var tr = $('<tr>');
      $('#time_place table').append(tr);
      tr.append(`<td><input name="date[]" class="input_date" value="${fainally}"></td>`);

      //時間と場所を作る
      var start_time = 8;
      var end_time = 24;
      tr.append('<td><select name="time_select_start[]" class="time_select"></select></td>');
      tr.append('<td><select name="time_select_end[]" class="time_select"></select></td>');
      for (var i = start_time; i <= end_time; i++) {
        var minute = '00';
        $('.time_select').append(`<option>${i}:${minute}</option>`);
        minute = '30';
        $('.time_select').append(`<option>${i}:${minute}</option>`);
      }

      //場所を作る
      tr.append('<td><input type="text" name="place[]" required></td>');

    } else { //selectedクラスがなかったら

      $(this).parent().removeClass('selected');

      // 取り除く日付を検索
      $('.input_date').each(function(){
        var removeTxet = $(this).val();
        console.log(removeTxet);
        if ( removeTxet.indexOf(fainally) == 0) {
          $(this).parents('tr').remove();
        }        
        var test = removeTxet.indexOf(fainally);
        console.log(test);
      });

      //テーブル見出し
      if ($('#time_place td').length == 0) {
        $('#index').remove();
      } 
    }
  });
  
  // -----------------------
  // ラジオボタン消せるようにする
  // -----------------------

  //インプット要素を取得する
  var inputs = $('input');

  inputs.each(function() {

    //読み込み時に「:checked」の疑似クラスを持っているinputの値を取得する
    var checked = $(this).filter(':checked').val();

    //インプット要素がクリックされたら
    $(this).on('click', function(){
        
      //クリックされたinputとcheckedを比較
      if($(this).val() === checked) {
          //inputの「:checked」をfalse
          $(this).prop('checked', false);
          //checkedを初期化
          checked = '';
          
      } else {
          //inputの「:checked」をtrue
          $(this).prop('checked', true);
          //inputの値をcheckedに代入
          checked = $(this).val();
      }
      
    });
  });


  // -----------------------
  // コメント欄の「もっと見る」
  // -----------------------

  //「もっと見る」はコメント少なかったら表示しない
  var first_count = $('.article_top').length;

  if (first_count > 4) {
    $('article button').show();
  } else {
    $('article button').hide();
  }

  $('article button').on('click', function(){

    var count = $('.article_top').length;

    for (var i = count; i < count + 5; i++) { 

      $.ajax({
        url:"php/comment_get.php",
        data: "count="+i,
        dataType:"json",
        cache:false,
        success:successFunction,
        error: function(data) {
          console.log('error');
          console.log(data);
        }
      });

    }

  });

});

// -----------------------
// 「もっと見る」ajax成功時
// -----------------------
function successFunction(data){

  var id = data["id"];
  var date = data["date"];
  var name = data["name"];
  var category = data["category"];
  var message = data["message"];

  if (date != undefined) {

    var append_date = `<i class="fas fa-calendar-day fa-lg"></i><p>${date}</p>`;
    var append_name = `<i class="fas fa-user-edit fa-lg"></i><p>${name}</p>`;
    var append_category = `<i class="fas fa-futbol fa-lg"></i><p>${category}</p>`;
    var append_select = `<input type="checkbox" name="delete_comment_id[]" value="${id}" id="delete_comment_${id}">
    <label for ="delete_comment_${id}" class="delete_comment">選択`;
    var append_message = `<i class="fas fa-user-circle fa-3x"></i><p>${message}</p>`;
    var replace_message = append_message.replace(/\r\n/g, '<br>');
    
    $("article").append(`<div class="article_top">${append_date}${append_name}${append_category}${append_select}</div>`);
    $("article").append(`<div class="article_main">${replace_message}</div>`);

    $('article button').appendTo('article');

  } else if (date == undefined) {
    $('article button').hide();
  }
    
}
