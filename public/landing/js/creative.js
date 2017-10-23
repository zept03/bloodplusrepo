(function($) {
    "use strict"; // Start of use strict

    // Smooth scrolling using jQuery easing
    // $('a[href*="#"]:not([href="#"])').click(function() {
    //     if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
    //         var target = $(this.hash);
    //         target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    //         if (target.length) {
    //             $('html, body').animate({
    //                 scrollTop: (target.offset().top - 48)
    //             }, 1000, "easeInOutExpo");
    //             return false;
    //         }
    //     }
    // });

    // Activate scrollspy to add active class to navbar items on scroll
    $('body').scrollspy({
        target: '#mainNav',
        offset: 48
    });

    // Closes responsive menu when a link is clicked
    $('.navbar-collapse>ul>li>a').click(function() {
        $('.navbar-collapse').collapse('hide');
    });

    // Collapse the navbar when page is scrolled
    $(window).scroll(function() {
        if ($("#mainNav").offset().top > 500) {
            $("#mainNav").addClass("navbar-shrink");
        } else {
            $("#mainNav").removeClass("navbar-shrink");
        }
    });

    // Scroll reveal calls
    window.sr = ScrollReveal();
    sr.reveal('.sr-headings',{
        duration: 600,
        delay: 200,
        scale: 1.3
    });
     sr.reveal('.sr-pics', {
        duration: 1000,
        delay: 200,
        scale: 0.9,
        distance: '50px'
    }, 200);
    sr.reveal('.sr-headings2',{
        duration: 600,
        delay: 400
    });
    sr.reveal('.sr-headings3',{
        duration: 600,
        delay: 800
    });
    sr.reveal('.sr-icons', {
        duration: 800,
        scale: 0.3,
        distance: '50px'
    }, 200);
    sr.reveal('.sr-button', {
        duration: 1000,
        delay: 200
    });
    sr.reveal('.sr-contact', {
        duration: 600,
        scale: 0.3,
        distance: '0px'
    }, 300);

    // Magnific popup calls
    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1]
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        }
    });


    // SAMPLE


})(jQuery); // End of use strict


