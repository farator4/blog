jQuery(function($){
    $('input[type=button]').addClass('btn');
    $('input[type=submit]').addClass('btn btn-primary');
    $('#nav-single a').addClass('btn btn-info');
    if($(window).width()>=800){
    $('.navbar .dropdown').hover(function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();

    }, function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();

    });
    $('.navbar .dropdown > a').click(function(){
        location.href = this.href;
    });} else {
        $('.dropdown').click(function(e){
            e.preventDefault();
            $(this).find('.dropdown-menu').first().stop(true, true).slideToggle();
        });
    }
    $('#search').popover({placement:'left',html:true});
    $('#search').click(function(){$(this).parent('li').toggleClass('open');});


});

