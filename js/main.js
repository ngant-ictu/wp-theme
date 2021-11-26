(function($) {
	"use strict";
	
	$( '.autosearch-input' ).on( 'focus', function(){
		$( '.topsearch-entry' ).addClass( 'on' );
	}).on( 'focusout', function(){
		$('html').removeAttr('style');
		$( '.topsearch-entry' ).removeClass( 'on' );
	});

	/* 
	** Add Click On Ipad 
	*/
	$(window).resize(function(){
		var $width = $(this).width();
		if( $width < 1199 ){
			$( '.primary-menu .nav .dropdown-toggle'  ).each(function(){
				$(this).attr('data-toggle', 'dropdown');
			});
		}
	});
	
	/* Check variable if has swatches variation */
	if( $('body').hasClass( 'sw-wooswatches' ) ){
		$( '.sw-wooswatches .product-type-variable' ).each(function(){
			var h_swatches = $(this).find( '.sw-variation-wrapper' ).height() + 20;
			$(this).find( '.item-bottom' ).css( 'bottom', h_swatches );
		});
	}

	/*
	** Blog Masonry
	*/	
	$(window).load(function() {
		var $width = $(this).width();
		if( $width > 768 ){
			$('body').find('.blog-content-grid').isotope({ 
				layoutMode : 'masonry'
			});
			setTimeout(function(){
				$('.loader1').fadeToggle();

			}, 500);
		}
	});

	/*
	** Search on click
	*/	
	$('.top-search .icon-search').on('click', function(){
		$('.topsearch-entry').slideToggle("open");
	});

	$('.header-elementor3 .icon-sidebar').on('click', function(){
		$('.header-sibar').toggleClass('open');
		$('body').toggleClass('open');
	});

	$('.header-sibar .close-sidebar').on('click', function(){
		$('.header-sibar').removeClass('open');
		$('body').removeClass('open');
	});

	/*
	* tab
	*/
	
    $('#myTab li:first-child a').tab('show')

	/*
	** js mobile
	*/	
	$('.mobile-layout .back-history').on('click', function(){
		window.history.back();
	});
	
	/*add title to button*/
	$("a.compare").attr('title', custom_text.compare_text);
	$(".yith-wcwl-add-button a").attr('title', custom_text.wishlist_text);
	$("a.fancybox").attr('title', custom_text.quickview_text);
	$("a.add_to_cart_button").attr('title', custom_text.cart_text);
	
	$(document).click(function(event) {
    //if you click on anything except the modal itself or the "open modal" link, close the modal
        if (!$(event.target).closest(".box-bottom").length) {
            $("body").find(".box-bottom").removeClass("open");
        }
    });
    /** Button viewed **/
    $(document).ready(function() {

    	$('[data-toggle="tooltip"]').tooltip(); 

        function goToByScroll(id) {
            id = id.replace("link", "");
            $('html,body').animate({ scrollTop: $("#" + id).offset().top - 65 }, 'slow');
        }
        $(".more-quote > a").click(function(e) {
            e.preventDefault();
            goToByScroll($(this).attr("id"));
        });

         $(".more-quote2 a").click(function(e) {
            e.preventDefault();
            goToByScroll($(this).attr("id"));
        });


        var tabLinks = document.querySelectorAll(".tablinks");
        var tabContent = document.querySelectorAll(".tabcontent");
        tabLinks.forEach(function(el) {
            el.addEventListener("click", openTabs);
        });
        function openTabs(el) {
            var btnTarget = el.currentTarget;
            var id = btnTarget.dataset.id;

            tabContent.forEach(function(el) {
                el.classList.remove("active");
            });

            tabLinks.forEach(function(el) {
                el.classList.remove("active");
            });

            document.querySelector("#" + id).classList.add("active");

            btnTarget.classList.add("active");
        }

    });
    	
	/*
	** Product listing order hover
	*/
	$('ul.orderby.order-dropdown li ul').hide(); 
	$("ul.order-dropdown > li").each( function(){
		$(this).on('hover', function() {
			$('.products-wrapper').addClass('show-modal');
			$(this).find( '> ul' ).stop().fadeIn("fast");
		}, function() {
			$('.products-wrapper').removeClass('show-modal');
			$(this).find( '> ul' ).stop().fadeOut("fast");
		});
	});
	
	/*
	** Product listing select box
	*/
	$('.catalog-ordering .orderby .current-li a').html($('.catalog-ordering .orderby ul li.current a').html());
	$('.catalog-ordering .sort-count .current-li a').html($('.catalog-ordering .sort-count ul li.current a').html());
	
	$(".top-fill .button-filter").on('click', function(){
		$(".products-wrapper .above-product-widget").fadeToggle();
		$(".top-fill").toggleClass("closex");
	});
	
	/*
	** Quickview and single product slider
	*/
	$(document).ready(function(){
		/* 
		** Slider single product image
		*/
		$( '.product-images' ).each(function(){
			var $rtl 			= $('body').hasClass( 'rtl' );
			var $vertical		= $(this).data('vertical');
			var $img_slider 	= $(this).find('.product-responsive');
			var video_link 		= $(this).data('video');
			var $thumb_slider 	= $(this).find('.product-responsive-thumbnail' );
			var number_slider	= ( $vertical ) ? 5: 5;
			var number_mobile 	= ( $vertical ) ? 2: 4;
			
			$img_slider.slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				fade: true,
				arrows: false,
				rtl: $rtl,
				asNavFor: $thumb_slider,
				infinite: false
			});
			$thumb_slider.slick({
				slidesToShow: number_slider,
				slidesToScroll: 1,
				asNavFor: $img_slider,
				arrows: true,
				rtl: $rtl,
				infinite: false,
				vertical: $vertical,
				verticalSwiping: $vertical,
				focusOnSelect: true,
				responsive: [
				{
					breakpoint: 480,
					settings: {
						slidesToShow: number_mobile    
					}
				},
				{
					breakpoint: 360,
					settings: {
						slidesToShow: 2    
					}
				}
				]
			});
			var el = $(this);
			setTimeout(function(){
				el.removeClass("loading");
				var height = el.find('.product-responsive').outerHeight();
				var target = el.find( ' .item-video' );
				target.css({'height': height,'padding-top': (height - target.outerHeight())/2 });

				var thumb_height = el.find('.product-responsive-thumbnail' ).outerHeight();
				var thumb_target = el.find( '.item-video-thumb' );
				thumb_target.css({ height: thumb_height,'padding-top':( thumb_height - thumb_target.outerHeight() )/2 });
			}, 1000);
			if( video_link != '' ) {
				$img_slider.append( '<button data-type="popup" class="featured-video-button fa fa-play" data-video="'+ video_link +'"></button>' );
				if( $( 'body' ).hasClass( 'single-product-style1' ) || $( 'body' ).hasClass( 'single-product-style2' ) ){
					$( '.woocommerce-product-gallery__wrapper > .woocommerce-product-gallery__image:first' ).prepend( '<button data-type="popup" class="featured-video-button style1" data-video="'+ video_link +'"></button>' );
				}
			}
		});
	});

	/*
	** Hover on mobile and tablet
	*/
	var mobileHover = function () {
		$('*').on('touchstart', function () {
			$(this).trigger('hover');
		}).on('touchend', function () {
			$(this).trigger('hover');
		});
	};
	mobileHover();
	
	/*
	** Menu hidden
	*/
	$('.product-categories').each(function(){
		var number	 = $(this).data( 'number' ) - 1;
		var lesstext = $(this).data( 'lesstext' );
		var moretext = $(this).data( 'moretext' );
		if( number > 0 ) {
			$(this).find( 'li:gt('+ number +')' ).hide().end();		
			if( $(this).children('li').length > number ){ 
				$(this).append(
					$('<li><a>'+ moretext +'   +</a></li>')
					.addClass('showMore')
					.on('click',function(){
						if($(this).siblings(':hidden').length > 0){
							$(this).html( '<a>'+ lesstext +'   -</a>' ).siblings(':hidden').show(400);
						}else{
							$(this).html( '<a>'+ moretext +'   +</a>' ).show().siblings( ':gt('+ number +')' ).hide(400);
						}
					})
					);
			}
		}
	});

	/* 
	** Fix accordion heading state 
	*/
	$('.accordion-heading').each(function(){
		var $this = $(this), $body = $this.siblings('.accordion-body');
		if (!$body.hasClass('in')){
			$this.find('.accordion-toggle').addClass('collapsed');
		}
	});	

	
	/*
	** Cpanel
	*/
	$('#cpanel').collapse();

	$('#cpanel-reset').on('click', function(e) {

		if (document.cookie && document.cookie != '') {
			var split = document.cookie.split(';');
			for (var i = 0; i < split.length; i++) {
				var name_value = split[i].split("=");
				name_value[0] = name_value[0].replace(/^ /, '');

				if (name_value[0].indexOf(cpanel_name)===0) {
					$.cookie(name_value[0], 1, { path: '/', expires: -1 });
				}
			}
		}

		location.reload();
	});

	$('#cpanel-form').on('submit', function(e){
		var $this = $(this), data = $this.data(), values = $this.serializeArray();

		var checkbox = $this.find('input:checkbox');
		$.each(checkbox, function() {

			if( !$(this).is(':checked') ) {
				name = $(this).attr('name');
				name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');
				var date = new Date();
				date.setTime(date.getTime() + (30 * 1000));
				$.cookie( name , 0, { path: '/', expires: date });
			}

		})

		$.each(values, function(){
			var $nvp = this;
			var name = $nvp.name;
			var value = $nvp.value;

			if ( !(name.indexOf(cpanel_name + '[')===0) ) return ;

			name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');

			$.cookie( name , value, { path: '/', expires: 7 });

		});

		location.reload();

		return false;

	});

	$('a[href="#cpanel-form"]').on( 'click', function(e) {
		var parent = $('#cpanel-form'), right = parent.css('right'), width = parent.width();

		if ( parseFloat(right) < -10 ) {
			parent.animate({
				right: '0px',
			}, "slow");
		} else {
			parent.animate({
				right: '-' + width ,
			}, "slow");
		}

		if ( $(this).hasClass('active') ) {
			$(this).removeClass('active');
		} else $(this).addClass('active');

		e.preventDefault();
	});
	
	/*
	** Language
	*/
	var $current ='';
	$('#lang_sel ul > li > ul li a').on('click',function(){
	 $current = $(this).html();
	 $('#lang_sel ul > li > a.lang_sel_sel').html($current);
	 $a = $.cookie('lang_select_kontruk', $current, { expires: 1, path: '/'}); 
	});
	
	if( $.cookie('lang_select_kontruk') && $.cookie('lang_select_kontruk').length > 0 ) {
		$('#lang_sel ul > li > a.lang_sel_sel').html($.cookie('lang_select_kontruk'));
	}

	$('#lang_sel ul > li.icl-ar').on('click',function(){
		$('#lang_sel ul > li.icl-en').removeClass( 'active' );
		$(this).addClass( 'active' );
		$.cookie( 'kontruk_lang_en' , 1, { path: '/', expires: 1 });
	});
	
	$('#lang_sel ul > li.icl-en').on('click',function(){
		$('#lang_sel ul > li.icl-ar').removeClass( 'active' );
		$(this).addClass( 'active' );
		$.cookie( 'kontruk_lang_en' , 0, { path: '/', expires: -1 });
	});
	
	var Kontruk_Lang = $.cookie( 'kontruk_lang_en' );
	if( Kontruk_Lang == null ){
		$('#lang_sel ul > li.icl-en').addClass( 'active' );
		$('#lang_sel ul > li.icl-ar').removeClass( 'active' );
	}else{
		$('#lang_sel ul > li.icl-en').removeClass( 'active' );
		$('#lang_sel ul > li.icl-ar').addClass( 'active' );
	}
	
	/*
	** Clear header style 
	*/
	$( '.kontruk-logo' ).on('click', function(){
		$.cookie("kontruk_header_style", null, { path: '/' });
		$.cookie("kontruk_footer_style", null, { path: '/' });
	});
	
		
	/*
	** Back to top
	**/
	$("#kontruk-totop").hide();
	var wh = $(window).height();
	var whtml = $(document).height();
	$(window).scroll(function () {
		if ($(this).scrollTop() > whtml/10) {
			$('#kontruk-totop').fadeIn();
		} else {
			$('#kontruk-totop').fadeOut();
		}
	});
	
	$('#kontruk-totop').on('click',function() {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	/* end back to top */

	/*
	** Fix js 
	*/
	$('.wpb_map_wraper').on('click', function () {
		$('.wpb_map_wraper iframe').css("pointer-events", "auto");
	});

	$( ".wpb_map_wraper" ).on('mouseleave', function() {
	 	$('.wpb_map_wraper iframe').css("pointer-events", "none"); 
	});

	/*
	** Change Layout 
	*/
	$( window ).load(function() {	
		if( $( 'body' ).hasClass( 'tax-product_cat' ) || $( 'body' ).hasClass( 'post-type-archive-product' ) || $( 'body' ).hasClass( 'tax-dc_vendor_shop' ) ) {
			$('.grid-view').on('click',function(){
				$('.list-view').removeClass('active');
				$('.grid-view').addClass('active');
				jQuery("ul.products-loop").fadeOut(300, function() {
					$(this).removeClass("list").fadeIn(300).addClass( 'grid' );			
				});
			});
			
			$('.list-view').on('click',function(){
				$( '.grid-view' ).removeClass('active');
				$( '.list-view' ).addClass('active');
				$("ul.products-loop").fadeOut(300, function() {
					jQuery(this).addClass("list").fadeIn(300).removeClass( 'grid' );
				});
			});
			/* End Change Layout */
		} 
	});

	/*remove loading*/
	$(".responsive-slider").fadeIn(300, function() {
		var el = $(this);
		setTimeout(function(){
			el.removeClass("loading");
		}, 1000);
	});

	function sw_buynow_variation_product(){
		var element = $( '.single-product' );
		var target = $( '.single-product .variations_form' );
		var bt_addcart = target.find( '.single_add_to_cart_button' );
		var variation  = target.find( '.variation_id' ).val();
		var bt_buynow  = element.find( '.button-buynow' );
		var url = bt_buynow.data( 'url' );
		var qty = $('.single-product input.qty').val();
		if( typeof variation != 'undefined' ){
			if( variation == 0 ){
				bt_buynow.addClass( 'disabled' );
			}else{
				bt_buynow.removeClass( 'disabled' );
			}
			if( variation != '' ){
				bt_buynow.attr( 'href', url + '='+variation + '&quantity='+ qty );
			}else{
				bt_buynow.attr( 'href', url + '&quantity='+ qty );
			}
		}else{
			bt_buynow.attr( 'href', url + '&quantity='+ qty );
		}
	}
	$(window).on( 'change', function(){
		sw_buynow_variation_product();
	});
	$(document).ready(function(){
		sw_buynow_variation_product();
	});
	
}(jQuery));


/*
** Check comment form
*/
function submitform(){
	if(document.commentform.comment.value=='' || document.commentform.author.value=='' || document.commentform.email.value==''){
		alert('Please fill the required field.');
		return false;
	} else return true;
}
(function($){		
	
	/*Verticle Menu*/
	if( !( $('#header').hasClass( 'header-style7' ) ) ) {
		$('.vertical-megamenu').each(function(){
			var number	 = $(this).parent().data( 'number' ) - 1;
			var lesstext = $(this).parent().data( 'lesstext' );
			var moretext = $(this).parent().data( 'moretext' );
			$(this).find(	' > li:gt('+ number +')' ).hide().end();		
			if($(this).children('li').length > number ){ 
				$(this).append(
					$('<li><a class="open-more-cat">'+ moretext +'</a></li>')
					.addClass('showMore')
					.on('click', function(){
						if($(this).siblings(':hidden').length > 0){
							$(this).html('<a class="close-more-cat">'+ lesstext +'</a>').siblings(':hidden').show(400);
						}else{
							$(this).html('<a class="open-more-cat">'+ moretext +'</a>').show().siblings( ':gt('+ number +')' ).hide(400);
						}
					})
				);
			}
		});
	}

	$(window).scroll(function() {   
		if( $( 'body' ).hasClass( 'mobile-layout' ) ) {
			var target = $( '.mobile-layout #header-page' );
			var sticky_nav_mobile_offset = $(".mobile-layout #header-page").offset();
			if( sticky_nav_mobile_offset != null ){
				var sticky_nav_mobile_offset_top = sticky_nav_mobile_offset.top;
				var scroll_top = $(window).scrollTop();
				if ( scroll_top > sticky_nav_mobile_offset_top ) {
					$(".mobile-layout #header-page").addClass('sticky-mobile');
				}else{
					$(".mobile-layout #header-page").removeClass('sticky-mobile');
				}
			}
		}
	});
		
	/*
	** Ajax login
	*/
	$('form#login_ajax').on('submit', function(e){
		var target = $(this);		
		var usename = target.find( '#username').val();
		var pass 	= target.find( '#password').val();
		if( usename.length == 0 || pass.length == 0 ){
			target.find( '#login_message' ).addClass( 'error' ).html( custom_text.message );
			return false;
		}
		target.addClass( 'loading' );
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: custom_text.ajax_url,
			headers: { 'api-key':target.find( '#woocommerce-login-nonce').val() },
			data: { 
				'action': 'kontruk_custom_login_user', //calls wp_ajax_nopriv_ajaxlogin
				'username': target.find( '#username').val(), 
				'password': target.find( '#password').val(), 
				'security': target.find( '#woocommerce-login-nonce').val() 
			},
			success: function(data){
				target.removeClass( 'loading' );
				target.find( '#login_message' ).html( data.message );
				if (data.loggedin == false){
					target.find( '#username').css( 'border-color', 'red' );
					target.find( '#password').css( 'border-color', 'red' );
					target.find( '#login_message' ).addClass( 'error' );
				}
				if (data.loggedin == true){
					target.find( '#username').removeAttr( 'style' );
					target.find( '#password').removeAttr( 'style' );
					document.location.href = data.redirect;
					target.find( '#login_message' ).removeClass( 'error' );
				}
			}
		});
		e.preventDefault();
	});

	
})(jQuery);


jQuery(document).ready(function($) {
	var $content  = $('.box-masonry .gallery-project'),
	$sidebar   = $('.box-masonry .entry-top');
	var $width = $(this).width();

	if ($sidebar.length > 0 && $content.length > 0 && $width > 768) {
		var $window    = $(window),
			offset     = $sidebar.offset(),
			timer;

		$window.scroll(function() {
			clearTimeout(timer);
			timer = setTimeout(function() {
				if ($content.height() > $sidebar.height()) {
					var new_margin = $window.scrollTop() - offset.top;
					if ($window.scrollTop() > offset.top && ($sidebar.height()+new_margin) <= $content.height()) {
						// Following the scroll...
						$sidebar.stop().animate({ marginTop: new_margin }, 300);
						$sidebar.addClass('fixed');
					} else if (($sidebar.height()+new_margin) > $content.height()) {
						// Reached the bottom...
						$sidebar.stop().animate({ marginTop: $content.height()-$sidebar.height() }, 300);
					} else if ($window.scrollTop() <= offset.top) {
						// Initial position...
						$sidebar.stop().animate({ marginTop: 0 }, 300);
						$sidebar.removeClass('fixed');
					}
				}else{
					var new_margin = $window.scrollTop() - offset.top;
					if ($window.scrollTop() > offset.top && ($content.height()+new_margin) <= $sidebar.height()) {
						// Following the scroll...
						$content.stop().animate({ marginTop: new_margin }, 300);
						$content.addClass('fixed');
					} else if (($content.height()+new_margin) > $sidebar.height()) {
						// Reached the bottom...
						$content.stop().animate({ marginTop: $sidebar.height()-$content.height() }, 300);
					} else if ($window.scrollTop() <= offset.top) {
						// Initial position...
						$content.stop().animate({ marginTop: 0 }, 300);
						$content.removeClass('fixed');
					}
				}
			}, 100);
		});
	}
});