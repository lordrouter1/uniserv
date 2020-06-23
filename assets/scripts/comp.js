function loadToast(status){
    if(status){
        $('#toast-success').fadeIn('slow').delay(1000).fadeOut('slow',function(){location.href='?'});
    }
    else{
        $('#toast-error').fadeIn('slow').delay(1000).fadeOut('slow',function(){location.href='?'});
    }
    return;
}