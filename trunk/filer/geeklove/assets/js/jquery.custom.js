jQuery(document).ready(function($){
    /*------------------------------------------------------------------------------*/
    /* Set cookie for retina displays; refresh if not set
    /*------------------------------------------------------------------------------*/

    (function(){
        "use strict";
        if( document.cookie.indexOf('retina') === -1 && 'devicePixelRatio' in window && window.devicePixelRatio === 2 ){
            document.cookie = 'retina=' + window.devicePixelRatio + ';';
            window.location.reload();
        }
    })();

    /*------------------------------------------------------------------------------*/
    /* Mobile Navigation Setup
    /*------------------------------------------------------------------------------*/
    var mobileNav = $('#primary-menu').clone().attr('id', 'mobile-primary-nav');

    $('#primary-menu').supersubs({
        minWidth: 12,
        maxWidth: 27,
        extraWidth: 1
    }).superfish({
        delay: 100,
        animation: {opacity:'show', height:'show'},
        speed: 'fast',
        autoArrows: false,
        dropShadows: false
    });

    function stag_mobilemenu(){
        "use strict";
        var windowWidth = $(window).width();
        if( windowWidth <= 992 ) {
            if( !$('#mobile-nav').length ) {
                $('<a id="mobile-nav" href="#mobile-primary-nav"><i class="icon icon-navicon"></i></a>').prependTo('#navigation');
                mobileNav.insertAfter('#mobile-nav').wrap('<div id="mobile-primary-nav-wrap" />');
                mobile_responder();
            }
        }else{
            mobileNav.css('display', 'none');
        }
    }
    stag_mobilemenu();

    function mobile_responder(){
        $('#mobile-nav').click(function(e) {
            if( $('body').hasClass('ie8') ) {
                var mobileMenu = $('#mobile-primary-nav');
                if( mobileMenu.css('display') === 'block' ) {
                    mobileMenu.css({
                        'display' : 'none'
                    });
                } else {
                    mobileMenu.css({
                        'display' : 'block',
                        'height' : 'auto',
                        'z-index' : 999,
                        'position' : 'absolute'
                    });
                }
            } else {
                $('#mobile-primary-nav').stop().slideToggle(500);
            }
            e.preventDefault();
        });
    }

    $(window).resize(function() {
        stag_mobilemenu();
    });

    /* Custom Dropdown for <select> */
    if(jQuery().dropdown){
        $( 'select' ).each(function(){
            $(this).dropdown({
                stack : false
            });
        });
    }

    /*------------------------------------------------------------------------------*/
    /* Photo Gallery - Isotope
    /*------------------------------------------------------------------------------*/
    var container = $('#photo-list');

    container.isotope({
      itemSelector : '.photo',
      layoutMode: 'fitRows',
    });

    // A small hack to make Isotope work on responsive stuff
    $(window).scroll(function(){
        container.resize();
    });
    container.resize();
    $(window).resize();

    $('#filters a').click(function(){
      var selector = $(this).attr('data-filter');
      container.isotope({ filter: selector });

      $('#filters a').removeClass('active');
      $(this).addClass('active');

      return false;
    });


    /*------------------------------------------------------------------------------*/
    /* Keyboard Navigation
    /*------------------------------------------------------------------------------*/
    $("body").keydown(function(e){
      if(e.keyCode === 39){
        if($('a[rel=next]').attr('href') !== undefined){
            document.location.href = $('a[rel=next]').attr('href');
        }
      }else if(e.keyCode === 37){
        if($('a[rel=prev]').attr('href') !== undefined){
            document.location.href = $('a[rel=prev]').attr('href');
        }
      }
    });

    /*------------------------------------------------------------------------------*/
    /* FitVids
    /*------------------------------------------------------------------------------*/
    $(".container").fitVids();

});