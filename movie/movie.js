$(function() {

  // -------------------------------
  // モーダル
  // -------------------------------

  $(".modal-open").click(function(){

    var image = $(this).attr('src');

    $("body").append('<div id="modal-bg"></div>');
    $("body").append(`<img id="modal-main" src="${image}" alt="">`);

    var imgWidth = $('#modal-main').width();
    var imgHeight = $('#modal-main').height();
    var windowWidth = $(window).width();
    
    
      if(imgWidth / imgHeight > 1){
         
        // 画僧の縦横比で条件分岐
        if (windowWidth > 650) {
          $('#modal-main').css('width','60%');
        } else {
         $('#modal-main').css('width','90%');
        }

      }else if (imgWidth / imgHeight <= 1){
        $('#modal-main').css('height','90%');
    }
    
    $("#modal-bg, #modal-main").fadeIn("slow");
    
    //画面のどこかをクリックしたらモーダルを閉じる
    $("#modal-bg").click(function(){
      $("#modal-main,#modal-bg").fadeOut("slow",function(){
        $('#modal-bg, #modal-main').remove() ;
      });  
    });
        
  });

  // -------------------------------
  //最終行の調整
  // -------------------------------
  for (var i = 0; i < 2; i++ ) {
    $('.container').append('<div class="empty"></div>')
  }

 // -------------------------------
  //スクロールアニメーション
  // -------------------------------

  // 最初は必ず表示
  $('#first .image').addClass('slideIn');
  $('#first .bg').addClass('slideDown');

  // 二つ並んでいた時
  var firstPos = $('#first').offset().top;
  var secondPos = $('#second').offset().top;

  if (firstPos == secondPos) {
    $('#second .image').addClass('slideIn');
    $('#second .bg').addClass('slideDown');
  }

  // ページ途中でロードされた場合
  var scroll = $(window).scrollTop();

  if (scroll > firstPos) {
    $('section').each(function(){

      var elemPos = $(this).offset().top;
      var windowHeight = $(window).height();
      
      if (scroll > elemPos - windowHeight + 300){
        $('.image', this).addClass('slideIn');
        $('.bg', this).addClass('slideDown');
      }
    });
  }

  // スクロールして実行
  $(window).scroll(function (){
    $('section').each(function(){

      var elemPos = $(this).offset().top;
      var scroll = $(window).scrollTop();
      var windowHeight = $(window).height();

      if (scroll > elemPos - windowHeight + 300){
        $('.image', this).addClass('slideIn');
        $('.bg', this).addClass('slideDown');
      }

    });
  });




});