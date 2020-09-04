$(function(){

  $('.link').each(function(){
    $(this).click(function(){

      var page = $(this).data('page');
      var parameter = "page=" + page;
      
      $('article').fadeOut('slow', function(){
        
        $.ajax({
          url:page,
          data:parameter,
          dataType:"json",
          cache:false,
          success:successFunction,
        });
      
      });
      
      $('article').fadeIn('slow');
    
    });
  });

});

function successFunction(data){
          
  //JSONを読み込む
  var name = data["name"];
  var src = data["src"];
  var alt = data["alt"];
  var text = data["text"];
  
  //書き込む
  $('article h2').text(name);
  $('article img').attr('src', src);
  $('article img').attr('alt', alt);
  $('article p').text(text);

}

