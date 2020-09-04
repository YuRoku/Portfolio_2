$(function(){

  $(".modal-open").click(function(){

    var image = $(this).attr('id');

    $("body").append('<div id="modal-bg"></div>');
    $("body").append(`<img id="modal-main" src="${image}" alt="">`);

    var imgWidth = $('#modal-main').width();
    var imgHeight = $('#modal-main').height();

    console.log(imgWidth);
    console.log(imgHeight);
    
    if(imgWidth / imgHeight > 1){
      //横長画像の場合の処理（横幅÷縦幅が1以上になる場合）
      $('#modal-main').css('width','90%');
    }else if (imgWidth / imgHeight <= 1){
      //縦長画像の場合の処理
      $('#modal-main').css('height','100%');
    }

    $("#modal-bg, #modal-main").fadeIn("slow");
    
    //画面のどこかをクリックしたらモーダルを閉じる
    $("#modal-bg").click(function(){
      $("#modal-main,#modal-bg").fadeOut("slow",function(){
        $('#modal-bg, #modal-main').remove() ;
      });  
    });
        
  });

  //最終行の調整
  var length = $('.box').length;
  for (var i = 0; i < 6 - length; i++ ) {
    $('#container').append('<div class="empty"></div>')
  }

});

