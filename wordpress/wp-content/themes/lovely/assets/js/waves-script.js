/* Resize */
jQuery(window).resize(function () {
    "use strict";
    /* Scroll Thumb resize */
//    jQuery(".bottom-area .instagram-pics li").each(function () {
//        var $curr = jQuery(this);
//        var $currH = 200;
//        var $currW = 317;
//        var $currD = $currW / $currH;
//        var $currNW = $curr.width();
//        var $currNH = $currNW / $currD;
//        $curr.height($currNH);
//        var $currImg = $curr.find('img');
//        var $currImgH = $currImg.height();
//        var $currImgMT = ($currNH - $currImgH) / 2;
//        $currImg.css('margin-top', $currImgMT + 'px');
//    });
});
jQuery(document).ready(function ($) {
    "use strict";
    
    /* Search Form Animation */
    jQuery('.searchform.on-menu i').each(function () {
        var $currSearchIcon = jQuery(this);
        var $currInput = $currSearchIcon.siblings('input');
        $currSearchIcon.click(function () {
            var $currInput = jQuery(this).siblings('input');
            if (jQuery('body').hasClass('search-opened')) {
                $currInput.focusout();
            } else {
                $currInput.focus().select();
            }
        });
        $currInput.focus(function () {
            jQuery('body').addClass('search-opened');
        });
        $currInput.focusout(function () {
            jQuery('body').removeClass('search-opened');
        });
    });
    // Waves Social Tabs Widget
    $('.lovely-social-tabs').each(function (i) {
        var $cSocTabs = $(this);
        var $tabs = $cSocTabs.find('.nav-tabs>li>a');
        var $contents = $cSocTabs.find('.tab-content>.tab-pane');
        $tabs.eq(0).parent().addClass('active');
        $contents.eq(0).addClass('active');
        $tabs.each(function (j) {
            var $cTab = $(this);
            var $cName = 'lovely-social-tab-' + i + '-' + j;
            $cTab.attr('href', '#' + $cName).attr('aria-controls', $cName);
            $contents.eq(j).attr('id', $cName);
        });
    });
    // OwlCarousel
    if ($().owlCarousel !== undefined && $().owlCarousel !== 'undefined') {
        $('.feature-area .owl-carousel').owlCarousel({
            singleItem: true,
            navigationText: ["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"],
            navigation: true,
            items: 1
        });
        $('.entry-media .owl-carousel').owlCarousel({
            singleItem: true,
            navigationText: ["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"],
            navigation: true,
            items: 1
        });
        $('.null-instagram-feed>.owl-carousel').each(function () {
            var $cOwl = $(this);
            var $singleItem = $cOwl.closest('.bottom-area').hasClass('bottom-area') ? false : true;
            var $items = $cOwl.closest('.bottom-area').hasClass('bottom-area') ? 8 : 1;
            var $pagination = $cOwl.closest('.sidebar-area').hasClass('sidebar-area') ? true : false;
            var $navigation = $cOwl.closest('.sidebar-area').hasClass('sidebar-area') ? false : true;
            var $autoPlay = $cOwl.data('auto-play');
            if ($autoPlay === '') {
                $autoPlay = false;
            }
            $cOwl.owlCarousel({
                autoPlay: $autoPlay,
                itemsDesktop:[1199,7],
                itemsDesktopSmall:[979,6],
                itemsTablet: [768,4],
                itemsTabletSmall: [599,2],
                itemsMobile: [479,1],
                navigationText: ["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"],
                navigation: $navigation,
                pagination: $pagination,
                stopOnHover: true,
                items: $items,
                singleItem: $singleItem
            });
        });        
    }
    $('.feature-posts').each(function(){
        var $cFeatPost=$(this);
        var $cFeatPostItems=$cFeatPost.children('.post-item');
        var $auto=true;
        var $time=0;
        var $timeInt=1000;
        var $timeMax=3000;
        $cFeatPostItems.each(function(){
            var $cFeatPostItem=$(this);
            $cFeatPostItem.hover(function(){
                $cFeatPostItem.addClass('active').siblings('.post-item').removeClass('active');
                $auto=false;
            },function(){
                $time=0;
                $auto=true;
            });
        });
        if($cFeatPostItems.length>1){
            setInterval(function(){
               if($auto&&$time>$timeMax){
                   $time=0;
                   var $activeItem=$cFeatPost.children('.post-item.active');
                   var $nextItem=$activeItem.next('.post-item').hasClass('post-item')?$activeItem.next('.post-item'):$cFeatPostItems.eq(0);
                   $nextItem.addClass('active');
                   $activeItem.removeClass('active');
               }else{
                   $time+=$timeInt;
               }
            },$timeInt);
        }
    });

    /* Video Responsive */
    jQuery('.content-area iframe').each(function () {
        if (!jQuery(this).hasClass('fluidvids-elem')) {
            jQuery(this).addClass('makeFluid');
        }
    });
    Fluidvids.init({
        selector: '.content-area iframe.makeFluid',
        players: ['www.youtube.com', 'player.vimeo.com']
    });
    jQuery('.content-area iframe').removeClass('makeFluid');

    /* navigation */
    $('.tw-menu ul.sf-menu').superfish({
        delay: 10,
        animation: {
            opacity: 'show',
            height: 'show'
        },
        speed: 'fast',
        autoArrows: false,
        dropShadows: false
    });

    /* Mobile Menu Action */
    jQuery('.mobile-menu-icon').click(function () {
        if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active');
            jQuery('body').removeClass('show-mobile-menu');
        } else {
            jQuery(this).addClass('active');
            jQuery('body').addClass('show-mobile-menu');
        }
        return false;
    });
    jQuery('.tw-mobile-menu>i').click(function () {
        jQuery('.mobile-menu-icon.active').click();
    });
    /* Mobile Menu - Sub Menu Action */
    jQuery('.tw-mobile-menu>nav ul.sub-menu').each(function () {
        var $subMenu = jQuery(this);
        var $parMenuLink = $subMenu.siblings('a');
        $parMenuLink.click(function (e) {
            e.preventDefault();
            var $parMenu = jQuery(this).closest('li');
            $parMenu.siblings('li.menu-open').removeClass('menu-open').children('.sub-menu').slideUp('fast');
            $parMenu.toggleClass('menu-open');
            if ($parMenu.hasClass('menu-open')) {
                $parMenu.children('.sub-menu').slideDown('fast');
            } else {
                $parMenu.children('.sub-menu').slideUp('fast');
            }
            return false;
        });
    });

    /* facebook */
    $('a.facebook-share').click(function (e) {
        e.preventDefault();
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + jQuery(this).attr('href'), "facebookWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });

    /* twitter */
    $('a.twitter-share').click(function (e) {
        e.preventDefault();
        var $text = $(this).data('title');
        $text += ' ' + $(this).attr('href');
        window.open('http://twitter.com/intent/tweet?text=' + $text.replace(/&/gi, ''), "twitterWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        jQuery.post($(this).data('ajaxurl'), {tweet_pid: $(this).data('id')});
        return false;
    });

    /* pinterest */
    $('a.pinterest-share').click(function (e) {
        e.preventDefault();
        window.open('http://pinterest.com/pin/create/button/?url=' + jQuery(this).attr('href') + '&media=' + $(this).closest('article').find('img').first().attr('src') + '&description=' + $('.section-title h1').text(), "pinterestWindow", "height=640,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });

    /* Scroll Up Menu */
    var $scrollTopOld = jQuery(window).scrollTop();
    var $scrollUpMax = 100;
    var $scrollUp = 0;
    var $scrollDownMax = 50;
    var $scrollDown = 0;
    jQuery(window).scroll(function (e) {
        var $header = jQuery('header>.tw-menu-container');
        var $headerClone = $header.siblings('.header-clone');
        var $headerCloneOT = $headerClone.offset().top;
        var $scrollTop = jQuery(window).scrollTop();
        /* START - Header resize */
        /* Important - Is HeaderScrollUp Check First */
        if(jQuery('#wpadminbar').attr('id')==='wpadminbar'){$headerCloneOT-=jQuery('#wpadminbar').height();}
        var $diff = $scrollTopOld - $scrollTop;
        if ($diff > 0) {/* Scroll Up */
            $scrollUp += $diff;
            $scrollDown = 0;
        } else {/* Scroll Down */
            $scrollUp = 0;
            $scrollDown -= $diff;
        }
        $scrollTopOld = $scrollTop;
        if ($scrollUpMax <= $scrollUp && $scrollTop > 0 && $headerCloneOT < $scrollTop && !jQuery('body').hasClass('header-small') && !jQuery('body').hasClass('menu-locked')) {
            jQuery('body').addClass('header-small');
            $header.css('margin-top', ('-' + $header.height() + 'px'));
            $header.stop().animate({marginTop: 0}, 200, 'linear', function () {
                $header.css({'margin-top': ''});
            });
        } else if (($scrollDownMax <= $scrollDown || $scrollTop === 0 || $headerCloneOT>$scrollTop) && jQuery('body').hasClass('header-small') && !$header.hasClass('hidding')) {
            if ($scrollTop === 0 || $headerCloneOT>$scrollTop) {
                jQuery('body').removeClass('header-small').removeClass('hidding');
            } else {
                $header.stop().addClass('hidding').animate({marginTop: ('-' + $header.height() + 'px')}, 200, 'linear', function () {
                    jQuery('body').removeClass('header-small');
                    $header.css({'margin-top': ''}).removeClass('hidding');
                });
            }
        }
        /* END   - Header resize */
    });
    jQuery(window).scroll();
    /* --------------- */
});
jQuery(window).load(function () {
    
    
    /* PrettyPhoto */
    jQuery("a[rel^='prettyPhoto']").prettyPhoto({
        animation_speed:'normal',
        theme:'pp_default',
        deeplinking: true
    });
    /* --------------- */
    jQuery(window).resize();
});