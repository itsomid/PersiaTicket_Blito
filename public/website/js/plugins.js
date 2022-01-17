


/* $("body").delegate(".ticket-yours", "click", function () {

    $(this).removeClass('ticket-yours');

});
*/
$(document).ready(function () {


    $('.pro_link').click(function () {
        $(this).find('div.m_op').fadeToggle();
    });



    $("body").delegate(".tags span", "click", function () {
    var tagClass = $(this).attr('class').split(' ')[0] ;
    if ($(this).hasClass( "active-tag" )){
        $('.tags span').removeClass('active-tag');
        $('.h-show').fadeIn();
        $(this).removeClass('active-tag');
        $('ul.pagination').fadeIn(0);
    }else {
        $('.tags span').removeClass('active-tag');
        $('.h-show').fadeOut(0);
        $('.' + tagClass).fadeIn();
        $(this).addClass('active-tag');

        if ($('a.' + tagClass).length == 0){
            $('ul.pagination').fadeOut(0);
            $('.shows_empty').fadeIn(0)

        }else if ($('a.' + tagClass).length > 20 ){
            $('ul.pagination').fadeIn(0);
            $('.shows_empty').fadeOut(0);
        }else if($('a.' + tagClass).length < 20 ) {
            $('ul.pagination').fadeOut(0);
            $('.shows_empty').fadeOut(0);
        }
    }
});

$("body").delegate(".price-cat strong", "click", function () {

        var pi = $(this).attr('class') ;
        $('span.p-pin').fadeOut(0);
        $('span.'+ pi).fadeIn();
        $('.active-pin').removeClass('active-pin');
        $('.'+ pi).addClass('active-pin');

    var s_active = $('.active-pin').attr('class').split(' ');
    localStorage.setItem('pin',s_active[0]);
    });

    $("body").delegate(".p-pin-all", "click", function () {
        var pi = $(this).attr('class') ;

        $('span.p-pin').fadeIn();
        $('.active-pin').removeClass('active-pin');
        $('.'+ pi).addClass('active-pin');
    });

    $('.show_wl_tags ').click(function () {
       $('.tags').slideToggle()
    });

    $("body").delegate(".tabs_tiwall span", "click", function () {
        var id_show_tiwall = $(this).attr('class').split(' ')[0]  ;
        $('.section-container').fadeOut(0);
        $('.tabs_tiwall span').removeClass('active_tiwall');
        $(this).addClass('active_tiwall');
        $('#' + id_show_tiwall).fadeIn();
    });







































    $('.p-pin').click(function () {

        $('.act-st').next('.step').addClass('act-st');
    });


    var firstTime = 0 ;

    $('.ticket-date').click(function () {
        $('.sans-hide span.ticket-sans').fadeOut(0);
        if (firstTime == 0) {
            $('.ticket-date').removeClass('ticket-date-checked');
            $(this).addClass('ticket-date-checked');
            var s_active = $(this).attr('class').split(' ')[0];
            $('.'+ s_active).fadeIn(0);
            localStorage.setItem('date',s_active[0]);
            $('.sans-hide').fadeIn('');
            firstTime = 1;
        }else {
            if ($(this).hasClass('ticket-date-checked')){}else{
                $('.buyPlace').fadeOut(0);
                $('.buyChair').fadeOut(0);
                $('.buyFinal').fadeOut(0);
                $('.ticket-review').fadeOut(0);

                var s_active = $(this).attr('class').split(' ')[0];
                $('.'+ s_active).fadeIn(0);

                $('.ticket-date').removeClass('ticket-date-checked');
                $(this).addClass('ticket-date-checked');
                $('.sans-hide').fadeIn('');
            }
        }

        var s_active = $(this).attr('class').split(' ')[0];
        $('.'+ s_active).fadeIn(0);

    });
    $('.ticket-sans').click(function () {
        $('.ticket-sans').removeClass('ticket-sans-checked');
        $(this).addClass('ticket-sans-checked');
        var s_active = $(this).attr('class').split(' ');
        localStorage.setItem('sans',s_active[0]);

        //$('.loading-fa').fadeIn();


    });






    // $('.1').addClass('active');
    // $('.h-show').fadeOut(0);
    // $('.1').fadeIn();

    $('.shows-tab span').click(function(){
        $('.tags span').removeClass('active-tag');
        $('.h-show').fadeIn(0);
        var tabActiv = $(this).attr('class').split(' ')[0] ;
        $('.shows-tab span').removeClass('active');
        $(this).addClass('active');
        $('.h-show').fadeOut(0);
        $('.tags span').fadeOut(0);
        if(tabActiv == "all"){
            $('.shows_empty').fadeOut(0);
            $('.h-show').fadeIn(0);
            $('.tags span').fadeIn(0);
        }else {
            $('.shows_empty').fadeOut(0);
            $('.' + tabActiv).fadeIn(200);
        }
    });

    $('.user-menu a').click(function(){
        var vi = $(this).attr('class').split(' ')[0] ;
        $('.user-menu a').removeClass('active-m');
        $('.user-menu a span').attr('class', '');
        $(this).addClass('active-m');
        $(this).find('span').addClass(vi);
        $('.user-view').fadeOut(0);


        $('.' + vi).fadeIn(200);

    });




});