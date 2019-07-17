  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <script>
   // $( window ).on("load", function() {
   //  // executes when complete page is fully loaded, including all frames, objects and images
   //  $("body").removeClass("preload");
   // });
   (function ($) {
    $('.carousel').carousel({
     interval: 40000
    });
    // Scroll to top button and fixed navigation triggers
    $(document).on('scroll', function () {
     var scrollDistance = $(this).scrollTop();
     if(scrollDistance > 50) {
      $("#header").addClass("alternate");
     }
     else {
      $("#header").removeClass("alternate");
     }
     if(scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
     }
     else {
      $('.scroll-to-top').fadeOut();
     }
    });
    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function (event) {
     var $anchor = $(this);
     $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
     }, 1000, 'easeInOutExpo');
     event.preventDefault();
    });
   })(jQuery); // End of use strict*/
  </script>