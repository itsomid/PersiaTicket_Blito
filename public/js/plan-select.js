function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
function readFile() {

    if (this.files && this.files[0]) {

        var FR= new FileReader();

        FR.addEventListener("load", function(e) {
            document.getElementById("b64").innerHTML = e.target.result;
        });
        FR.readAsDataURL( this.files[0] );
    }
}

document.getElementById("imgInp").addEventListener("change", readFile);
$("#imgInp").change(function() {
    readURL(this);
});
var itemNum = 0 ;

function drg() {
    $(".place-here").draggable(
        {
            containment: "parent",
            drag: function(){
                var offset = $('.img-w').offset() ;
                var thisOffset = $(this).offset() ;
                var it = parseInt($(this).find('i').text())
                var xPos = Number(((thisOffset.left - offset.left) / $('#blah').width()).toFixed(2));
                var yPos = Number(((thisOffset.top - offset.top) / $('#blah').height()).toFixed(2));
                $('#pos-x-' + it).text(xPos);
                $('#pos-y-' + it).text(yPos);
            }
        });
}

function getRndInteger(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}





/*

    var strsT     = ''
    var jsonArray = [] ;

        for (var z = 1 ; z <= placeHere; z++) {
            var xNeed = $('#pos-x-' + z).text();
            var yNeed = $('#pos-y-' + z).text();
            var zone = { 'x' : xNeed, 'y' : yNeed };

            //rows
            var rows = []


            zone['rows'] = rows;

        }

        var finalStr = '{"palce" : ' + strsT + '}' ;
        jsonArray.push(finalStr) ;


        alert(jsonArray)
*/






$(document).ready(function () {


    drg();


        $('.add-place').click(function () {
            itemNum++
            var color_cat = 'rgba(' + getRndInteger(0, 255) + ',' + getRndInteger(0, 255) + ',' + getRndInteger(0, 255) + ',' + 0.41 + ')';

            $('<div id="pos-x-' + itemNum + '"></div><div id="pos-y-' + itemNum + '"></div>').appendTo('.x-y');


            $('<div class="place-here sel-' + itemNum + '"><i style="background: ' + color_cat + '">' + itemNum + '</i><i></i></div>').appendTo('.img-w');
            $('\n' +
                '<div class="one-place-color-item  sel-' + itemNum + '" style="background: ' + color_cat + '">' +
                '<div class="deleat-pfa btn btn-danger  sel-' + itemNum + ' ">حذف جایگاه</div>\n' +
                '<div class="plan-row"><strong class="palce-title-st">نام جایگاه</strong></div>\n' +
                '    <div class="plan-row "><input type="text" value="" name="" class="small-in-put input-style-cus place-title"> </div>\n' +
                '<div class="radif-fa plan-row">\n' +
                '    <div class="plan-row ">\n' +
                '<div class="tit-test">ردیف</div>' +
                '    <div class="chair-int-cont-fa ">\n' +
                '        <div class="but-a space-create-a"></div>\n' +
                '        <div class="but-a chair-create-a">صندلی</div>\n' +


                '            <input type="text" value="" name="" class="small-in-put end-in input-style-cus mar-top">\n' +
                '            <div class="words-mar">تا</div>\n' +
                '            <input type="text" value="" name="" class="small-in-put start-than input-style-cus mar-top">\n' +
                '            <div class="words-mar">از</div>\n' +


                '\n' +
                '    </div>\n' +
                '    </div>\n' +
                '\n' +
                '    <input type="text" value="1" name="" class="small-in-put input-style-cus row-tit">\n' +
                '   <div class="del-chair-created-in-row fa fa-close icon"></div> <div class="big-in-div input-style-cus">\n' +
                '\n' +
                '\n' +
                '\n' +
                '    </div>\n' +
                '\n' +
                '</div>\n' +
                '<div class="add-new-radif  btn btn-primary fa fa-plus icon"></div><div class="remove-new-radif  btn btn-danger fa fa-minus icon"></div></div>').appendTo('.place-chiar-int-div')
            drg();

        });

        $("body").delegate(".chair-create-a", "click", function () {

            var than = parseInt($(this).parents('div.radif-fa').find('.start-than').val());
            var to = parseInt($(this).parents('div.radif-fa').find('.end-in').val());

            if (than < to) {


                for (var n = than; n <= to; n++) {
                    $('<div class="c-chair-int">' + n + '</div>').appendTo($(this).parents('div.radif-fa').find('.big-in-div'));
                }

            } else if (than > to) {
                for (var n = than; n >= to; n--) {
                    $('<div class="c-chair-int">' + n + '</div>').appendTo($(this).parents('div.radif-fa').find('.big-in-div'));
                }
            }

            $(this).parents('div.radif-fa').find('.start-than').val(n);
            $(this).parents('div.radif-fa').find('.end-in').val('');

        });


        $("body").delegate(".space-create-a", "click", function () {


            $('<div class="c-space-int">  </div>').appendTo($(this).parents('div.radif-fa').find('.big-in-div'));


        });
        $("body").delegate(".add-new-radif", "click", function () {

            var intOpHave = $(this).parent('div.one-place-color-item').find(".radif-fa").length;
            intOpHave++


            $('<div class="radif-fa plan-row">\n' +
                '    <div class="plan-row ">\n' +
                '    <div class="chair-int-cont-fa ">\n' +
                '        <div class="but-a space-create-a"></div>\n' +
                '        <div class="but-a chair-create-a">صندلی</div>\n' +
                '\n' +
                '            <input type="text" value="" name="" class="small-in-put end-in input-style-cus mar-top">\n' +
                '            <div class="words-mar">تا</div>\n' +
                '            <input type="text" value="" name="" class="small-in-put start-than input-style-cus mar-top">\n' +
                '            <div class="words-mar">از</div>\n' +
                '\n' +
                '    </div>\n' +
                '    </div>\n' +
                '\n' +
                '    <input type="text" value="' + intOpHave + ' " name="" class="small-in-put input-style-cus row-tit" >\n' +
                '    <div class="del-chair-created-in-row fa fa-close icon"></div><div class="big-in-div input-style-cus">\n' +
                '\n' +
                '\n' +
                '\n' +
                '    </div>\n' +
                '\n' +
                '</div>').appendTo($(this).parent('div.one-place-color-item'));
        });

        $("body").delegate(".remove-new-radif", "click", function () {

            $(this).parents('.one-place-color-item').find('.radif-fa:last-child').remove()


        });

        $("body").delegate(".deleat-pfa", "click", function () {
            var showthis_sel = $(this).attr('class').split(' ')[4];

            $('.' + showthis_sel).remove();
        });


        $("body").delegate(".del-chair-created-in-row", "click", function () {
            $(this).parent('.radif-fa').find('div.big-in-div').text('');
        });

        $("body").delegate(".c-space-int", "click", function () {
            $(this).remove();
        });

});