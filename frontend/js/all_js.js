
$(document).ready(function () {

  /** start for log page || sign_in page */

  // set height for welc-div
  var screenHeight = $(window).outerHeight();
  $('.welc-div').css({'height':screenHeight});
  $(window).resize(function(){
      var screenHeight = $(window).outerHeight();
      $('.welc-div').css({'height':screenHeight});
  });
  // start on foucus input
  $('input[placeholder]').focus(function(){
    $(this).attr( 'store',$(this).attr('placeholder') );
    $(this).removeAttr('placeholder');
  });

  $('input[placeholder]').blur(function(){
    $(this).attr( 'placeholder',$(this).attr('store') );
    $(this).removeAttr('store');
  });
  // start show passwoed eye
  $('.show-pass').click(function(){
    $('.input-pass').attr('type','text');
    $(this).hide(1);
    $('.hide-pass').show(1);
  });

  $('.hide-pass').click(function(){
    $('.input-pass').attr('type','password');
    $(this).hide(1);
    $('.show-pass').show(1);
  });
  // set footer for small screen
  var screenHeight = $(window).outerHeight();
  if ( screenHeight < 545 ){
      $('.footer').css({'position':'relative','margin-top':'30px'});
  }
  $(window).resize(function(){
      var screenHeight = $(window).outerHeight();
      if ( screenHeight < 545 ){
          $('.footer').css({'position':'relative','margin-top':'30px'});
      }
  });
  // set footer for large screen
  if ( screenHeight > 545 ){
      $('.footer').css({'position':'absolute','margin-top':'0'});
  }
  $(window).resize(function(){
      var screenHeight = $(window).outerHeight();
      if ( screenHeight > 545 ){
          $('.footer').css({'position':'absolute','margin-top':'0'});
      }
  });
  // chek txt
  function isPhone() {
    var txt = $(this).val();
    if ( txt.length > 11 || txt.length < 11 ) {
      $(this).css({'color':'red'});
      //$('#log').attr('disabled','disabled');
    } else if ( txt.length == 11 ) {
      $(this).css({'color':'#22c722'});
    }
  }
  $('#input1').change(function(){
    isPhone();
  });

  /** end for log page */

  /** start for manage page */
  // clicked btn student information fields
  $('.se-btn').click(function(){
    //ckice action
    $(this).addClass('se-btn-active').siblings().removeClass('se-btn-active');
    
    //result in tables
    if ( $('.se-btn-1').is('.se-btn-active') ){
      $('.se-1-div').addClass('active-table').siblings().removeClass('active-table');
    }
    if ( $('.se-btn-2').is('.se-btn-active') ){
      $('.se-2-div').addClass('active-table').siblings().removeClass('active-table');
    }
    if ( $('.se-btn-3').is('.se-btn-active') ){
      $('.se-3-div').addClass('active-table').siblings().removeClass('active-table');
    }
  });
  // search btn click
  $('.search-btn-1').click(function(){
    $('.search-1').slideToggle();
  });
  $('.search-btn-2').click(function(){
    $('.search-2').slideToggle();
  });
  $('.search-btn-3').click(function(){
    $('.search-3').slideToggle();
  });
  // search progress for students informations
  $('#search-1').on('keyup', function () {
    var value = $(this).val().toLowerCase();
  
    // Filter only the first td in each row
    $('#table-1 tr').each(function () {
      var firstTd = $(this).find('td:first-child');
      var rowText = firstTd.text().toLowerCase();
      firstTd.closest('tr').toggle(rowText.indexOf(value) > -1);
    });
  
    // Show the first two rows
    $('#table-1 tr:first, #table-1 tr:nth-child(2)').show();
  });
  $('#search-2').on('keyup', function () {
    var value = $(this).val().toLowerCase();
  
    // Filter only the first td in each row
    $('#table-2 tr').each(function () {
      var firstTd = $(this).find('td:first-child');
      var rowText = firstTd.text().toLowerCase();
      firstTd.closest('tr').toggle(rowText.indexOf(value) > -1);
    });
  
    // Show the first two rows
    $('#table-1 tr:first, #table-1 tr:nth-child(2)').show();
  });
  $('#search-3').on('keyup', function () {
    var value = $(this).val().toLowerCase();
  
    // Filter only the first td in each row
    $('#table-3 tr').each(function () {
      var firstTd = $(this).find('td:first-child');
      var rowText = firstTd.text().toLowerCase();
      firstTd.closest('tr').toggle(rowText.indexOf(value) > -1);
    });
  
    // Show the first two rows
    $('#table-1 tr:first, #table-1 tr:nth-child(2)').show();
  });
  // IN HASH NOW BECOUSE WE DELETED THE OLD DESIGN
  // search progress for deg page
  $('#search-deg-1').on('keyup',function(){
    var value = $(this).val().toLowerCase();
    $('.table-deg-1 tr').filter(function(){
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    $('.table-deg-1 tr:first,.table-deg-1 tr:nth-child(2)').show();
  });
  $('#search-deg-2').on('keyup',function(){
    var value = $(this).val().toLowerCase();
    $('.table-deg-2 tr').filter(function(){
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    $('.table-deg-2 tr:first,.table-deg-2 tr:nth-child(2)').show();
  });
  $('.search-deg-3').on('keyup',function(){
    var value = $(this).val().toLowerCase();
    $('.table-deg-3 tr').filter(function(){
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    $('.table-deg-3 tr:first,.table-deg-3 tr:nth-child(2)').show();
  });

  // print btn
  $('#print1,#print2,#print3,#printFirstSeStudent,#printSecoundSeStudent,#printThirdSeStudent').click(function () {
    window.print();
  });
  /** end for manage page */

  /** start for exams page */
  $('.answer').click(function(){
    $(this).css('background','rgb(224 224 224)');
    $(this).siblings().css('background','transparent');
    $('.qustion').css('background','rgb(127 231 255 / 54%)');
    
    var radioVal  = $(this).children().attr('id'),
        qusionNum = radioVal.slice(0,2);
    localStorage.setItem(qusionNum,radioVal);
  });
  var storage = localStorage;
  for ( var x = 0 ; x < storage.length ; x++ ) {
    $('#'+storage['q'+x]).attr('checked','checked');
    $('#'+storage['q'+x]).parent().css('background','rgb(224, 224, 224)');
  }
  /** end for exams page */

});// ready function


