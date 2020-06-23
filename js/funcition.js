$(function() {

  /* ---------------------------------------------- /*
*   タイピング風タイトル
/* ---------------------------------------------- */
  $(window).on('load', function () {

    $('.typ').children().andSelf().contents().each(function () {
      if (this.nodeType == 3) {
        $(this).replaceWith($(this).text().replace(/(\S)/g, '<span>$1</span>'));
      }
    });

    $('.typ').css({ 'opacity': 1 });
    for (var i = 0; i <= $('.typ').children().size(); i++) {
      $('.typ').children('span:eq(' + i + ')').delay(80 * i).animate({ 'opacity': 1 }, 0);
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
