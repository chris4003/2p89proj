  jQuery(function(){

  /*-------------------------------MENU BAR ANIMATION------------------------------------*/
  function hideMenu(){
    var height = "-" + jQuery('#byslogin').outerHeight(true) + "px"

    jQuery('#byslogin').animate({top: height},500);
  }
  function showMenu(){
    jQuery('#byslogin').animate({top: 0},500);
  }

  var height = "-" + jQuery('#byslogin').outerHeight(true) + "px";
  jQuery('#byslogin').css('top', height);

  jQuery('#byslogin').mouseenter(function(){
    showMenu();
    jQuery(this).clearQueue();
    });
  jQuery('#byslogin').mouseleave(function(){
    hideMenu();
    jQuery(this).clearQueue();
  });
});