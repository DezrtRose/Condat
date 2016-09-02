$(function(){
  $("#bars li .bar").each(function(key, bar){
    var applications = $(this).data('applications');
    if (applications>26){
    	applications=26;
    }
    var percentage=applications/26*100;


    $(this).animate({
      'height':percentage+'%'
    }, 1000);
  })
})
