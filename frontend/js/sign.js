/** Sign up Page JS
 * For new visitors
 */
// Inputs Security
var arabicInput = $('#arabicInput'),
    phoneInput  = $('#phoneInput'),
    groubInput  = $('#groubInput'),
    pass1       = $('#pass1'),
    pass2       = $('#pass2');
arabicInput.keyup(function(){
  if ( arabicInput.val().length > 40 || arabicInput.val().length < 10 ){
    $(this).css({'color':'red','border-color':'red'})
  } else {
    $(this).css({'color':'#22c722','border-color':'#22c722'})
  }
});
phoneInput.keyup(function(){
  if ( phoneInput.val().length > 11 || phoneInput.val().length < 11 ){
    $(this).css({'color':'red','border-color':'red'})
  } else {
    $(this).css({'color':'#22c722','border-color':'#22c722'})
  }
});
groubInput.keyup(function(){
  if ( groubInput.val().length > 20){
    $(this).css({'color':'red','border-color':'red'})
  } else {
    $(this).css({'color':'#22c722','border-color':'#22c722'})
  }
});
pass1.keyup(function(){
  if ( pass1.val().length > 50 || pass1.val().length < 5 ){
    $(this).css({'color':'red','border-color':'red'})
  } else {
    $(this).css({'color':'#22c722','border-color':'#22c722'})
  }
});
pass2.keyup(function(){
  if ( pass2.val() !== pass1.val() ){
    $(this).css({'color':'red','border-color':'red'})
  } else {
    $(this).css({'color':'#22c722','border-color':'#22c722'})
  }
});
// set footer for small screen or sign_in page
var screenHeight = $(window).outerHeight();
if ( screenHeight < 760 ){
  $('.sign-footer').css({'position':'relative','margin-top':'30px'});
}
$(window).resize(function(){
  var screenHeight = $(window).outerHeight();
  if ( screenHeight < 760 ){
    $('.sign-footer').css({'position':'relative','margin-top':'30px'});
  }
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
// set footer for large screen for sign_in page
if ( screenHeight > 760 ){
  $('.sign-footer').css({'position':'absolute','margin-top':'0'});
}
$(window).resize(function(){
  var screenHeight = $(window).outerHeight();
  if ( screenHeight > 760 ){
    $('.sign-footer').css({'position':'absolute','margin-top':'0'});
}
});