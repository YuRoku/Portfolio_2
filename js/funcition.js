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






    
});
