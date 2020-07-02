$(function() {

  /* ---------------------------------------------- /*
*   ローディング画面
/* ---------------------------------------------- */
  // var h = $(window).height();
  
  $('#wrap').css('display','none');
  // $('#loader-bg ,#loader').height(h).css('display','block');
  $('#loader-bg ,#loader').css('display','block');
  
  
$(window).load(function () { //全ての読み込みが完了したら実行
  $('#loader-bg').delay(2000).fadeOut(800);
  $('#loader').delay(1500).fadeOut(300);
  $('#wrap').css('display', 'block');
});
  
//10秒たったら強制的にロード画面を非表示
$(function(){
  setTimeout('stopload()',10000);
});
  
function stopload(){
  $('#wrap').css('display','block');
  $('#loader-bg').delay(900).fadeOut(800);
  $('#loader').delay(600).fadeOut(300);
}


  /* ---------------------------------------------- /*
*   タイピング風タイトル
/* ---------------------------------------------- */
  $(window).load(function () {

    $('.typ').children().andSelf().contents().each(function () {
      if (this.nodeType == 3) {
        $(this).replaceWith($(this).text().replace(/(\S)/g, '<span>$1</span>'));
      }
    });

    $('.typ').css({ 'opacity': 1 });
    for (var i = 0; i <= $('.typ').children().size(); i++) {
      $('.typ').children('span:eq(' + i + ')').delay(2500).delay(80 * i).animate({ 'opacity': 1 }, 0);
    };

  });

  /* ---------------------------------------------- /*
*   動画背景
/* ---------------------------------------------- */

  $('#youtube').YTPlayer();

  /* ---------------------------------------------- /*
*   スクロールフェード
/* ---------------------------------------------- */

    new WOW().init();

  /* ---------------------------------------------- /*
*   スムーススクロール
/* ---------------------------------------------- */

    $('.navbar-brand').click(function() {
      $('html, body').animate({scrollTop: 0}, 500);
      return false;
    });

    $('a[href^="#"]').click(function(){

      var speed = 500;
      var href= $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top;
      var windowWidth = $(window).width();
      var collapseHeight = $('.navbar-collapse').outerHeight();
      console.log(windowWidth);

      if ( windowWidth <= 992 ) {
        $("html, body").animate({scrollTop:position - collapseHeight }, speed, "swing");
        $('.navbar-collapse').collapse('hide');//クリックで閉じる
        return false;
      } else {
        $("html, body").animate({scrollTop:position}, speed, "swing");
        return false;
      }
    });


    
});
