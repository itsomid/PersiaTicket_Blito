/*
 *
 *   INSPINIA - Responsive Admin Theme
 *   version 2.6
 *

 */
$(document).ready(function(){



    var selectedScene = 0 ;
    selectedScene = $('.salon option:selected').val() ;

    $('.disable-show-chair').addClass('show-chairs');
    $('.disable-show-chair').removeClass('disable-show-chair');
$('.alert_show').click(function () {
   alert('ثبت شد')
});


});

function con() {
    var r = confirm("تنظیمات صندلی‌های انتخاب شده در سالن قبلی حذف می‌گردند! ادامه می‌دهید؟");
    if (r == true) {
        $('.disable-show-chair').addClass('show-chairs');
        $('.disable-show-chair').removeClass('disable-show-chair');
        selectedScene = $('.salon option:selected').val();
        $('.array-seat').val("");
        $('.array-dis').val("")
        $('.price-row').html("");
    } else {
        $(".salon").val(selectedScene);
    }


}
$( "a.show-popup" ).on('click', function () {
    var showthis = $(this).attr('class').split(' ')[0];

    $('.'+showthis).show('');
});


$(function() {
    $('.close-ch-s').click(function(){
        $('.chair-div-fa').hide()
    });

    var dis_attribs = [];

    $('.disable-chair').click(function(){

alert('ثبت شد')

    $('.selected-view-of-chair').addClass('disable-view-chair');
    var disSelectItems = $('.selected-view-of-chair span.ui-selected');
        $(disSelectItems).addClass('disable-chair');
        $(disSelectItems).remove('have-price-seat');



            dis_attribs.push( $('.array-dis').text() );
            $('.selected-view-of-chair span.ui-selected').each(function () {

                $(this).find('i').text('disable');

                dis_attribs.push( $(this).attr("data") + ':' + 'disable');
            });

            var bef_val = $('.array-dis').text()  ;
            $('.array-dis').val(dis_attribs);
            var grid = $(".plan-grid option:selected").text();
            var divAdd = $(".final-grid-price") ;
/*
            $('<div class="price-row">\n' +
                '                <label>گرید</label>\n' +
                '                <label>' + grid + '</label>\n' +
                '                <label>تعداد صندلی</label>\n' +
                '                <label>' + chairSelectItems + '</label>\n' +
                '<label>قیمت صندلی</label>\n' +
                '<label>' + price + '</label>\n' +
                '<label>قیمت کل</label>\n' +
                '<label>' + price * chairSelectItems + '</label>\n' +

                '            <label><span class="fa fa-close icon deleat-price"></span></label></div>').appendTo(divAdd);
*/
        //$(".chair-div-fa").hide('slow');






    });


    function delCon() {


    }



    $( "body" ).delegate( "span.deleat-price", "click", function() {
        var txt;
        var r = confirm("مطعمن هستید ؟");
        if (r == true) {
            $(this).parents('div.price-row').remove();
        } else {

        }
       // $(this).parents('div.price-row').remove();
    });

    $('.metismenu li').click(function(){
        $('li').removeClass("active");
        $(this).addClass("active");

    });

    var tab_attribs = [];
$('.save-price').click(function(){
    tab_attribs = [] ;
   // $('.array-seat').val("");
    $('.tabAddHere').html('')
    var price = $('.grid-chair-price').val();
    var chairSelectItems = $('.selected-view-of-chair span.ui-selected').length;

    $('.view-chair').each(function () {
        var allForTab = $(this).find('span.ui-selectee').length ;
        var selForTab = $(this).find('span.have-price-seat').length ;
        var disForTab = $(this).find('span.disable-chair').length ;
        var baqiForTab = allForTab - (selForTab + disForTab) ;
        var nameForTab =  $(this).attr('class').split(' ')[0];
        var valForTab  = 0 ;
        $(this).find('span.have-price-seat').each(function () {
            var pThis = parseInt($(this).find('i').text()) ;
            valForTab = valForTab + pThis;
            });
        $('<tr><td>'+nameForTab+'</td><td> ' + allForTab + '</td><td>'+ selForTab +'</td><td>'+ disForTab +'</td><td>'+ baqiForTab +'</td><td>'+ valForTab +'</td></tr>').appendTo('.tabAddHere')
    });





    if(price == ""){
        alert('قیمت را وارد نمایید')
    }else{
       //  tab_attribs.push($('.array-seat').val());


        $('.selected-view-of-chair span.ui-selected').each(function () {
      //  $('.ui-selectable span.ui-selected').each(function () {
            $(this).removeClass('disable-chair');
            $(this).addClass('have-price-seat');
            $(this).find('i').text(price);
           // $(this).attr('id',price);


           // tab_attribs.push( $(this).attr("data") + ':' + price);
        });

        $('.have-price-seat').each(function () {
            //  $('.ui-selectable span.ui-selected').each(function () {

            tab_attribs.push( $(this).attr("data") + ':' +  $(this).find('i').text() );
        });
        console.log(tab_attribs);

        var bef_val = $('.array-seat').text()  ;
        $('.array-seat').val(tab_attribs);
        var grid = $(".plan-grid option:selected").text();
        var divAdd = $(".final-grid-price") ;

        // /$('<div class="price-row">\n' +
        //     '                <label>گرید</label>\n' +
        //     '                <label>' + grid + '</label>\n' +
        //     '                <label>تعداد صندلی</label>\n' +
        //     '                <label>' + chairSelectItems + '</label>\n' +
        //     '<label>قیمت صندلی</label>\n' +
        //     '<label>' + price + '</label>\n' +
        //     '<label>قیمت کل</label>\n' +
        //     '<label>' + price * chairSelectItems + '</label>\n' +
        //
        //     '            <label><span class="fa fa-close icon deleat-price"></span></label></div>').appendTo(divAdd);
        alert('ثبت شد')
    }
        //$(".chair-div-fa").hide('slow');
});

$(".deleat-price").click(function () {
   alert("asdad") ;
});




    var scntDiv = $('.sana-div-fa');
    var i = 3;
    var o = i + 10003;
    $('.add-sans').click(function() {i++;o++;


        $('<div class="row">\n' +
            '                            <label class="col-sm-1 control-label"> '+ (i-2) +'.</label>\n' +

            '                            <label class="col-sm-3 control-label">در تاریخ و ساعت</label>' +
            '                            <div class="col-md-6" style="margin-bottom: 20px;">  <input type="text" id="pcal'+ i +'" class="pdate form-control" name="showtime_date-'+ (i-2) +'"></div><br><br><br>' +
            '' +
            '                            <label class="col-sm-1 control-label">.</label>\n' +
            '                            <label class="col-sm-3 control-label">فروش از تاریخ و ساعت</label>' +
            '                              <div class="col-md-6"> <input type="text" id="pcal'+ o +'" class="pdate form-control" name="startshowtime_date-'+ (i-2) +'"><br>' +
            '' +

            '' +
            '                                </div>' +
            '                        <a href="#" class="fa fa-close icon deleat-link col-md-1 add-close "></a></div>').appendTo(scntDiv);


        $( '#pcal' + i + '' ).pDatepicker({
            format: 'YYYY/MM/DD HH:mm',
            timePicker: {
                enabled: true,
                meridiem: {
                    enabled: true
                }
            }
        });
        $( '#pcal' + o + '' ).pDatepicker({
            format: 'YYYY/MM/DD HH:mm',
            timePicker: {
                enabled: true,
                meridiem: {
                    enabled: true
                }
            }
        });
        $('#timepicker' + i + '').timepicki();
      
        //$('.hidd_fani').html('');
        return false;
    });

        $( "body" ).delegate( "a.deleat-link", "click", function() {
        if( i > 0 ) {$(this).parent().remove();
            i--;$('.hidd_fani').html('');  }  return false;
    });
});


//
//  $( function() {
//
//
//
//
//      $( "div,span" ).hover(function() {
//
//    var selectItems = $('.selected-view-of-chair span.ui-selected').length;
//    var allItems = $('.selected-view-of-chair span.item').length;
//           $(".chair-div-fa .chair-select span").text(selectItems);
//           $(".chair-div-fa .chair-all span").text(allItems);
//
// 	  //$(".chair-div-fa .chair-have span").text(allItems - selectItems);
//
//         //  if (selectItems == 0) {
//         //    $('.chair-prices-con').fadeOut('1');
//         //  }else{
//         //      $('.chair-prices-con').fadeIn('1');
//          // }
// });
//
//
//   } );
//
//





$( "body" ).delegate( ".show-chairs", "click", function() {
    $('.chair-div-fa').show();
});
$(document).ready(function () {

    //$('.show-chairs').on('click', function () {
   //     $('.chair-div-fa').show();
    //});
    $('.close-page').click(function(){
       $(this).parent().hide();

    });
    $('.close-popup').click(function(){
       $('div.user-create').hide('slow');
    });
    $(".show-cover").on('click', function () {
        $(".cover-popup").slideToggle();

    });


    // Add body-small class if window less than 768px
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }

    // MetsiMenu
    $('#side-menu').metisMenu();

    // Collapse ibox function
    $('.collapse-link').on('click', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.find('div.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('.close-link').on('click', function () {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Fullscreen ibox function
    $('.fullscreen-link').on('click', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        $('body').toggleClass('fullscreen-ibox-mode');
        button.toggleClass('fa-expand').toggleClass('fa-compress');
        ibox.toggleClass('fullscreen');
        setTimeout(function () {
            $(window).trigger('resize');
        }, 100);
    });

    // Close menu in canvas mode
    $('.close-canvas-menu').on('click', function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
    });

    // Run menu of canvas
    $('body.canvas-menu .sidebar-collapse').slimScroll({
        height: '100%',
        railOpacity: 0.9
    });

    // Open close right sidebar
    $('.right-sidebar-toggle').on('click', function () {
        $('#right-sidebar').toggleClass('sidebar-open');
    });

    // Initialize slimscroll for right sidebar
    $('.sidebar-container').slimScroll({
        height: '100%',
        railOpacity: 0.4,
        wheelStep: 10
    });

    // Open close small chat
    $('.open-small-chat').on('click', function () {
        $(this).children().toggleClass('fa-comments').toggleClass('fa-remove');
        $('.small-chat-box').toggleClass('active');
    });

    // Initialize slimscroll for small chat
    $('.small-chat-box .content').slimScroll({
        height: '234px',
        railOpacity: 0.4
    });

    // Small todo handler
    $('.check-link').on('click', function () {
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });


    // Minimalize menu
    $('.navbar-minimalize').on('click', function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();


    });


    // Tooltips demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });


    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarHeigh = $('nav.navbar-default').height();
        var wrapperHeigh = $('#page-wrapper').height();

        if (navbarHeigh > wrapperHeigh) {
            $('#page-wrapper').css("min-height", navbarHeigh + "px");
        }

        if (navbarHeigh < wrapperHeigh) {
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            if (navbarHeigh > wrapperHeigh) {
                $('#page-wrapper').css("min-height", navbarHeigh - 60 + "px");
            } else {
                $('#page-wrapper').css("min-height", $(window).height() - 60 + "px");
            }
        }

    }

    fix_height();

    // Fixed Sidebar
    $(window).bind("load", function () {
        if ($("body").hasClass('fixed-sidebar')) {
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }
    });

    // Move right sidebar top after scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() > 0 && !$('body').hasClass('fixed-nav')) {
            $('#right-sidebar').addClass('sidebar-top');
        } else {
            $('#right-sidebar').removeClass('sidebar-top');
        }
    });

    $(window).bind("load resize scroll", function () {
        if (!$("body").hasClass('body-small')) {
            fix_height();
        }
    });

    $("[data-toggle=popover]")
        .popover();

    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    })
});


// Minimalize menu when screen is less than 768px
$(window).bind("resize", function () {
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

// Local Storage functions
// Set proper body class and plugins based on user configuration
$(document).ready(function () {
    if (localStorageSupport()) {

        var collapse = localStorage.getItem("collapse_menu");
        var fixedsidebar = localStorage.getItem("fixedsidebar");
        var fixednavbar = localStorage.getItem("fixednavbar");
        var boxedlayout = localStorage.getItem("boxedlayout");
        var fixedfooter = localStorage.getItem("fixedfooter");

        var body = $('body');

        if (fixedsidebar == 'on') {
            body.addClass('fixed-sidebar');
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }

        if (collapse == 'on') {
            if (body.hasClass('fixed-sidebar')) {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            } else {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }

            }
        }

        if (fixednavbar == 'on') {
            $(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
            body.addClass('fixed-nav');
        }

        if (boxedlayout == 'on') {
            body.addClass('boxed-layout');
        }

        if (fixedfooter == 'on') {
            $(".footer").addClass('fixed');
        }
    }
});

// check if browser support HTML5 local storage
function localStorageSupport() {
    return (('localStorage' in window) && window['localStorage'] !== null)
}

// For demo purpose - animation css script
function animationHover(element, animation) {
    element = $(element);
    element.hover(
        function () {
            element.addClass('animated ' + animation);
        },
        function () {
            //wait for animation to finish before removing classes
            window.setTimeout(function () {
                element.removeClass('animated ' + animation);
            }, 2000);
        });
}

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 200);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(400);
            }, 100);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

// Dragable panels
function WinMove() {
    var element = "[class*=col]";
    var handle = ".ibox-title";
    var connect = "[class*=col]";
    $(element).sortable(
        {
            handle: handle,
            connectWith: connect,
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8
        })
        .disableSelection();
}


