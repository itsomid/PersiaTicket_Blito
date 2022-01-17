$(document).ready(function() {





        $('.gallery').scrollAnimate({
                startScroll: 0,
                endScroll: 300,
                cssProperty: 'transform',
                before: 'scale(0)',
                after: 'scale(1)'
        });
        jQuery(".gallery").jqScrollAnim({
                rep: {
                        start: 0,
                        end: 300
                },
                animation: {
                        type: 'number',
                        property: 'opacity',
                        start: 0,
                    end: 1
                }
        });
    jQuery(".view").jqScrollAnim({
        rep: {
            start: 0,
            end: 600
        },
        animations: [{
            type: 'integer',
            property: 'top',
            end: 0,
            start: 250
        }]
    });

    jQuery(".all-seen img:nth-child(2)").jqScrollAnim({
        rep: {
            start: 0,
            end: 600
        },
        animations: [{
            type: 'integer',
            property: 'top',
            end: 50,
            start: 150
        }]
    });


    jQuery(".tickeet-code  img:nth-child(2)").jqScrollAnim({
        rep: {
            start: 0,
            end: 600
        },
        animations: [{
            type: 'integer',
            property: 'right',
            end: 0,
            start: -550
        }]
    });



    jQuery(".place  img:nth-child(2)").jqScrollAnim({
        rep: {
            start: 0,
            end: 600
        },
        animations: [{
            type: 'integer',
            property: 'top',
            end: 50,
            start: 350
        }]
    });




    jQuery(".apps img:nth-child(2)").jqScrollAnim({
        rep: {
            start: 0,
            end: 400
        },
        animations: [{
            type: 'integer',
            property: 'right',
            end: 30,
            start: -550
        }]
    });

    jQuery(".apps  img:nth-child(3)").jqScrollAnim({
        rep: {
            start: 0,
            end: 300
        },
        animations: [{
            type: 'integer',
            property: 'top',
            end: 110,
            start: 250
        }]
    });
});





/*

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].animation.left  = ""



  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }

  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";


}




var slideIndex = 0;
showSlidess();

function showSlidess() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    setTimeout(showSlidess, 80000); // Change image every 2 seconds
}
*/
