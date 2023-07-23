/**
 * Script custom for theme
 *
 * TABLE OF CONTENT
 *
 * Header: main menu
 * Header: main menu mobile
 * Sidebar: sticky sidebar
 * Feature: Preloading
 * Feature: Back to top
 */
(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_course_builder.ready();

		/* Search form menu right */
		$('.menu-right .button_search').on("click", function () {
			$('.menu-right .search-form').toggle(300);
			$('.menu-right input.search-field').focus();
		});

		/*
		 * Add icon toggle curriculum in lesson popup
		 * */
		window.toggle_curiculum_sidebar = function (e) {
			var icon_popup = $('.icon-toggle-curriculum');
			icon_popup.toggleClass('open');

			if (icon_popup.hasClass('open')) {
				$('#popup-sidebar').stop().animate({'margin-left': '0'});
				$('#popup-main').stop().animate({'left': '418px'});
			} else {
				$('#popup-sidebar').stop().animate({'margin-left': '-418px'});
				$('#popup-main').stop().animate({'left': '0'});
			}
		}
	});

	$(window).load(function () {
		thim_course_builder.load();
	});

	var thim_course_builder = window.thim_course_builder = {
		/**
		 * Call functions when document ready
		 */
		ready: function () {
			this.header_menu();
			this.back_to_top();
			this.feature_preloading();
			this.sticky_sidebar();
			this.contactform7();
			this.blog_auto_height();
			this.custom_select();
			this.header_search();
			this.off_canvas_menu();
			this.carousel();
			this.video_thumbnail();
			this.switch_layout();
			this.single_post_related();
			this.loadmore_profile();
			this.profile_update();
			this.profile_switch_tabs();
			this.profile_slide_certificates();
			this.coming_soon_hover_effect();
		},

		/**
		 * Call functions when window load.
		 */
		load: function () {
			this.header_menu_mobile();
			this.parallax();
			this.post_gallery();
			this.curriculum_single_course();
			this.quick_view();
			if ($("body.woocommerce").length) {
				this.product_slider();
			}
		},

		header_search: function () {
			$('#masthead .search-form').on({
				'mouseenter': function () {
					$(this).addClass('active');
					$(this).find('input.search-field').focus();
				},
				'mouseleave': function () {
					$(this).removeClass('active');
				}
			});

			$('#masthead .search-submit').on('click', function (e) {
				var $form = $(this).parents('form');
				var s = $form.find('.search-field').val();
				if ($form.hasClass('active') && s) {
					//nothing
				} else {
					e.preventDefault();
					$form.find('.search-field').focus();
				}
			});
		},

		// CUSTOM FUNCTION IN BELOW
		post_gallery: function () {
			$('.flexslider').flexslider({
				slideshow     : false,
				animation     : 'fade',
				pauseOnHover  : true,
				animationSpeed: 400,
				smoothHeight  : true,
				directionNav  : true,
				controlNav    : false,
				start         : function (slider) {
					slider.flexAnimate(1, true);
				},
			});

		},

		// CUSTOM SLIDER
		slider: function () {
			var rtl = false;
			if ($('body').hasClass('rtl')) {
				rtl = true;
			}

			$('.thim-slider .slides').owlCarousel({
				items: 1,
				nav  : true,
				dots : false,
				rtl  : rtl,
			});

			// scroll icon
			$('.thim-slider .scroll-icon').on('click', function () {
				var offset = $(this).offset().top;
				$('html,body').animate({scrollTop: offset + 80}, 800);
				return false;
			});

		},

		/**
		 * Mobile menu
		 */
		header_menu_mobile: function () {
			$(document).on('click', '.menu-mobile-effect', function (e) {
				e.stopPropagation();
				$('.responsive #wrapper-container').toggleClass('mobile-menu-open');
			});

			$(document).on('click', '.mobile-menu-open .overlay-close-menu', function () {
				$('.responsive #wrapper-container').removeClass('mobile-menu-open');
			});

			$('.main-menu li.menu-item-has-children > a,.main-menu li.menu-item-has-children > span').after('<span class="icon-toggle"><i class="fa fa-caret-down"></i></span>');
			$('.responsive .mobile-menu-container .navbar-nav > li.menu-item-has-children > a').after('<span class="icon-toggle"><i class="fa fa-caret-down"></i></span>');

			$('.responsive .mobile-menu-container .navbar-nav > li.menu-item-has-children .icon-toggle').on('click', function () {
				if ($(this).next('ul.sub-menu').is(':hidden')) {
					$(this).next('ul.sub-menu').slideDown(200, 'linear').parent().addClass('show-submenu');
					$(this).html('<i class="fa fa-caret-up"></i>');
				} else {
					$(this).next('ul.sub-menu').slideUp(200, 'linear').parent().removeClass('show-submenu');
					$(this).html('<i class="fa fa-caret-down"></i>');
				}
			});
		},

		/**
		 * Magic line before menu item
		 * Khoapq
		 */
		magic_line: function () {

			var $el, leftPos, newWidth,
				$mainNav = $(".main-menu");

			$mainNav.append("<span id='magic-line'></span>");
			var $magicLine = $("#magic-line");
			var $current = $('.current-menu-item'),
				$current_a = $current.find('> a');

			if ($current.length <= 0) {
				return;
			}

			$magicLine
				.width($current_a.width())
				.css("left", $current.position().left + parseInt($current_a.css('padding-left')))
				.data("origLeft", $current.position().left + parseInt($current_a.css('padding-left')))
				.data("origWidth", $current_a.width());

			$(".main-menu > .menu-item").hover(function () {
				$el = $(this);
				leftPos = $el.position().left + parseInt($el.find('> a').css('padding-left'));
				newWidth = $el.find('> a').width();
				$magicLine.stop().animate({
					left : leftPos,
					width: newWidth
				});
			}, function () {
				$magicLine.stop().animate({
					left : $magicLine.data("origLeft"),
					width: $magicLine.data("origWidth")
				});
			});
		},

		/**
		 * Header menu sticky, scroll, v.v.
		 */
		header_menu: function () {
			var $header = $('#masthead');

			if (!$header.length) {
				return;
			}

			var $header_wrapper = $('#masthead .header-wrapper'),
				off_Top = 0,
				menuH = $header_wrapper.outerHeight(),
				$topbar = $('#thim-header-topbar'),
				latestScroll = 0,
				startSticky = $header_wrapper.offset().top,
				main_Offset = 0;

			if ($('#wrapper-container').length) {
				// off_Top = $('#wrapper-container').offset().top;
				main_Offset = $('#wrapper-container').offset().top;
			}

			if ($topbar.length) {
				off_Top = $topbar.outerHeight();

			}

			//mobile
			if ($(window).width() <= 480) {
				off_Top = 0;
				main_Offset = 0;
			}

			if ($header.hasClass('header-overlay')) {
				// single course
				if ($(window).width() >= 768) {
					if ($('.header-course-bg').length) {
						$('.header-course-bg').css({
							'height': $('.header-course-bg').outerHeight() + menuH
						});
					}
				}
				$header.css({
					'top': off_Top,
				});
			}

			$header.css({
				'height': $header_wrapper.outerHeight()
			});

			if ($header.hasClass('sticky-header')) {
				$(window).scroll(function () {
					var current = $(this).scrollTop();

					if (current > latestScroll) {
						//scroll down

						if (current > startSticky + menuH) {
							$header.removeClass('affix-top').addClass('affix').removeClass('menu-show').addClass('menu-hidden');
							$header_wrapper.css({
								top: 0,
							});
						} else {
							$header.addClass('no-transition');
						}

					} else {
						// scroll up
						if (current <= startSticky) {
							$header.removeClass('affix').addClass('affix-top').addClass('no-transition');
							$header_wrapper.css({
								top: 0,
							});
						} else {
							$header.removeClass('no-transition');
							$header_wrapper.css({
								top: main_Offset,
							});
						}

						$header.removeClass('menu-hidden').addClass('menu-show');
					}

					latestScroll = current;
				});
			}


			$('#masthead.template-layout-2 .main-menu > .menu-item-has-children, .template-layout-2 .main-menu > li ul li').hover(
				function () {
					$(this).children('.sub-menu').stop(true, false).slideDown(250);
				},
				function () {
					$(this).children('.sub-menu').stop(true, false).slideUp(250);
				}
			);
		},


		off_canvas_menu: function () {
			var $off_canvas_menu = $('.mobile-menu-container'),
				$navbar = $off_canvas_menu.find('.navbar-nav');

			var menuH = 0;
			var toggleH = $off_canvas_menu.find('.navbar-toggle').outerHeight();
			var widgetH = $off_canvas_menu.find('.off-canvas-widgetarea').outerHeight();
			var innerH = $off_canvas_menu.innerHeight();

			menuH = innerH - toggleH - widgetH;

			$navbar.css({
				'height': menuH
			});
		},

		/**
		 * Back to top
		 */
		back_to_top: function () {
			var $element = $('#back-to-top');
			$(window).scroll(function () {
				if ($(this).scrollTop() > 100) {
					$element.addClass('scrolldown').removeClass('scrollup');
				} else {
					$element.addClass('scrollup').removeClass('scrolldown');
				}
			});

			$element.on('click', function () {
				$('html,body').animate({scrollTop: '0px'}, 800);
				return false;
			});
		},

		/**
		 * Sticky sidebar
		 */
		sticky_sidebar: function () {
			var offsetTop = 20;

			if ($("#wpadminbar").length) {
				offsetTop += $("#wpadminbar").outerHeight();
			}
			if ($("#masthead.sticky-header").length) {
				offsetTop += $("#masthead.sticky-header").outerHeight();
			}

			if ($('.sticky-sidebar').length > 0) {
				$(".sticky-sidebar").theiaStickySidebar({
					"containerSelector"     : "",
					"additionalMarginTop"   : offsetTop,
					"additionalMarginBottom": "0",
					"updateSidebarHeight"   : false,
					"minWidth"              : "768",
					"sidebarBehavior"       : "modern"
				});
			}
		},

		/**
		 * Parallax init
		 */
		parallax: function () {
			$(window).stellar({
				horizontalOffset: 0,
				verticalOffset  : 0
			});
		},

		/**
		 * feature: Preloading
		 */
		feature_preloading: function () {
			var $preload = $('#thim-preloading');
			var is_user = false;
			if ($('body').hasClass('logged-in')) {
				is_user = true;
			}

			if (is_user || (top === self)) {
				// if logined and not in a iframe.
				if ($preload.length > 0) {
					$preload.fadeOut(600, function () {
						$preload.remove();
					});
				}
			}

		},


		/**
		 * Custom select use
		 */
		custom_select: function () {
			$('select').select2({
				minimumResultsForSearch: Infinity
			});
		},


		/**
		 * Custom effect and UX for contact form.
		 */
		contactform7: function () {
			$(".wpcf7-submit").on('click', function () {
				$(this).css("opacity", 0.2);
				$(this).parents('.wpcf7-form').addClass('processing');
				$('input:not([type=submit]), textarea').attr('style', '');
			});

			$(document).on('spam.wpcf7', function () {
				$(".wpcf7-submit").css("opacity", 1);
				$('.wpcf7-form').removeClass('processing');
			});

			$(document).on('invalid.wpcf7', function () {
				$(".wpcf7-submit").css("opacity", 1);
				$('.wpcf7-form').removeClass('processing');
			});

			$(document).on('mailsent.wpcf7', function () {
				$(".wpcf7-submit").css("opacity", 1);
				$('.wpcf7-form').removeClass('processing');
			});

			$(document).on('mailfailed.wpcf7', function () {
				$(".wpcf7-submit").css("opacity", 1);
				$('.wpcf7-form').removeClass('processing');
			});

			$('body').on('click', 'input:not([type=submit]).wpcf7-not-valid, textarea.wpcf7-not-valid', function () {
				$(this).removeClass('wpcf7-not-valid');
			});
		},


		/**
		 * Blog auto height
		 */
		blog_auto_height: function () {
			var $blog = $('.archive .blog-content article'),
				maxHeight = 0,
				setH = true;

			// Get max height of all items.
			$blog.each(function () {
				setH = $(this).hasClass('column-1') ? false : true;
				if (maxHeight < $(this).find('.content-inner').height()) {
					maxHeight = $(this).find('.content-inner').height();
				}
			});

			// Set height for all items.
			if (maxHeight > 0 && setH) {
				$blog.each(function () {
					$(this).find('.content-inner').css('height', maxHeight);
				});
			}
		},

		/**
		 * Widget Masonry
		 */
		widget_masonry: function () {
			$('.masonry-items').imagesLoaded(function () {
				var $grid = $('.masonry-items').isotope({
					percentPosition: true,
					itemSelector   : 'article',
					masonry        : {
						columnWidth: 'article'
					}
				});

				$('.masonry-filter').on('click', 'a', function () {
					var filterValue = $(this).attr('data-filter');
					$grid.isotope({filter: filterValue});
				});
			});
		},

		widget_brands: function () {
			var rtl = false;
			if ($('body').hasClass('rtl')) {
				rtl = true;
			}

			$(".thim-brands").each(function () {
				var items = parseInt($(this).attr('data-items'));
				$(this).owlCarousel({
					nav       : false,
					dots      : false,
					rtl       : rtl,
					responsive: {
						0   : {
							items: 2,
						},
						480 : {
							items: 3,
						},
						768 : {
							items: 4,
						},
						1024: {
							items: items,
						}
					}
				});
			});
		},

		//single courses carousel

		carousel: function () {
			var rtlval = false;
			if ($('body').hasClass('rtl')) {
				var rtlval = true;
			}
			$(".courses-carousel").each(function (index, element) {
				$('.courses-carousel').owlCarousel({
					rtl            : rtlval,
					nav            : true,
					dots           : false,
					margin         : 30,
					navText        : ['<i class="ion-chevron-left" aria-hidden="true"></i>', '<i class="ion-chevron-right"></i>'],
					responsiveClass: true,
					responsive     : {
						0  : {
							items: 1
						},
						481: {
							items: 2
						},
						769: {
							items: 3
						}
					}
				});
			});
		},

		//single course video thumbnail
		video_thumbnail: function () {
			$(".video-thumbnail").magnificPopup({
				type: 'iframe',
			});
		},

		//Grid and List
		switch_layout: function () {
			var cookie_name = $('.grid-list-switch').data('cookie');
			var courses_layout = $('.grid-list-switch').data('layout');
			var $list_grid = $('.grid-list-switch');

			if (cookie_name == 'product-switch') {
				var gridClass = 'product-grid';
				var listClass = 'product-list';
			} else if (cookie_name == 'lpr_course-switch') {
				var gridClass = 'course-grid';
				var listClass = 'course-list';
			} else {
				var gridClass = 'blog-grid';
				var listClass = 'blog-list';
			}

			var check_view_mod = function () {
				var activeClass = 'switcher-active';
				if ($list_grid.hasClass('has-layout')) {
					if (courses_layout == 'grid') {
						$('.archive_switch').removeClass(listClass).addClass(gridClass);
						$('.switchToGrid').addClass(activeClass);
						$('.switchToList').removeClass(activeClass);
					} else {
						$('.archive_switch').removeClass(gridClass).addClass(listClass);
						$('.switchToList').addClass(activeClass);
						$('.switchToGrid').removeClass(activeClass);
					}
				} else {
					if ($.cookie(cookie_name) == 'grid') {
						$('.archive_switch').removeClass(listClass).addClass(gridClass);
						$('.switchToGrid').addClass(activeClass);
						$('.switchToList').removeClass(activeClass);
					} else if ($.cookie(cookie_name) == 'list') {
						$('.archive_switch').removeClass(gridClass).addClass(listClass);
						$('.switchToList').addClass(activeClass);
						$('.switchToGrid').removeClass(activeClass);
					}
					else {
						$('.switchToList').addClass(activeClass);
						$('.switchToGrid').removeClass(activeClass);
						$('.archive_switch').removeClass(gridClass).addClass(listClass);
					}
				}
			}
			check_view_mod();

			var listSwitcher = function () {
				var activeClass = 'switcher-active';
				if ($list_grid.hasClass('has-layout')) {
					$('.switchToList').click(function () {
						$('.switchToList').addClass(activeClass);
						$('.switchToGrid').removeClass(activeClass);
						$('.archive_switch').fadeOut(300, function () {
							$(this).removeClass(gridClass).addClass(listClass).fadeIn(300);
						});
					});
					$('.switchToGrid').click(function () {
						$('.switchToGrid').addClass(activeClass);
						$('.switchToList').removeClass(activeClass);
						$('.archive_switch').fadeOut(300, function () {
							$(this).removeClass(listClass).addClass(gridClass).fadeIn(300);
						});
					});
				} else {
					$('.switchToList').click(function () {
						if (!$.cookie(cookie_name) || $.cookie(cookie_name) == 'grid') {
							switchToList();
						}
					});
					$('.switchToGrid').click(function () {
						if (!$.cookie(cookie_name) || $.cookie(cookie_name) == 'list') {
							switchToGrid();
						}
					});
				}

				function switchToList() {
					$('.switchToList').addClass(activeClass);
					$('.switchToGrid').removeClass(activeClass);
					$('.archive_switch').fadeOut(300, function () {
						$(this).removeClass(gridClass).addClass(listClass).fadeIn(300);
						$.cookie(cookie_name, 'list', {expires: 3, path: '/'});
					});
				}

				function switchToGrid() {
					$('.switchToGrid').addClass(activeClass);
					$('.switchToList').removeClass(activeClass);
					$('.archive_switch').fadeOut(300, function () {
						$(this).removeClass(listClass).addClass(gridClass).fadeIn(300);
						$.cookie(cookie_name, 'grid', {expires: 3, path: '/'});
					});
				}
			}
			listSwitcher();
		},


		/**
		 * Related Post Carousel
		 * @author Khoapq
		 */
		single_post_related: function () {
			var rtlval = false;
			if ($('body').hasClass('rtl')) {
				var rtlval = true;
			}
			$('.related-carousel').owlCarousel({
				rtl            : rtlval,
				nav            : true,
				dots           : false,
				responsiveClass: true,
				margin         : 30,
				navText        : ['<i class="ion-chevron-left" aria-hidden="true"></i>', '<i class="ion-chevron-right"></i>'],
				responsive     : {
					0  : {
						items: 2,
					},
					569: {
						items: 3,
					}
				},
			});
		},

		// lp_single_course
		curriculum_single_course: function () {
			$(".curriculum-sections .section").each(function () {
				$(this).on("click", function () {
					$(this).toggleClass('active');
				});
			});
			$(".search").find("input[type=search]").each(function () {
				$(".search-field").attr("placeholder", "Search...");
			});
			$("#commentform").each(function () {
				$(".comment-form-comment #comment").on("click", function () {
					$(this).css("transition", ".5s");
					$(this).css("min-height", "200px");
					$("p.form-submit").css("display", "block");
				});
			});
			$(".comment-form-comment").find("textarea").each(function () {
				$(this).prop("placeholder", "Enter your comment");
			});


			//cookie
			var data_cookie = $(".learn-press-nav-tabs").data('cookie');
			var data_cookie2 = $(".learn-press-nav-tabs").data('cookie2');
			var data_tab = $('.learn-press-nav-tab.active a').data('key');
			var data_id = $(".learn-press-nav-tab.active a").data('id');

			$(".learn-press-nav-tab a").on('click', function () {
				var data_key = $(this).data('key');
				var data_id = $(this).data('id');
				$.cookie(data_cookie2, data_id, {expires: 3, path: '/'});
				$.cookie(data_cookie, data_key, {expires: 3, path: '/'});
			});
			if ($.cookie(data_cookie2) != data_id) {
				$.cookie(data_cookie, 'overview', {expires: 3, path: '/'});
			}

			if ($.cookie(data_cookie) == null) {
				$.cookie(data_cookie, 'overview', {expires: 3, path: '/'});
			}

			if ($.cookie(data_cookie) == data_tab) {
				var tab_class = $('.learn-press-nav-tab-' + $.cookie(data_cookie));
				var panel_class = $('.learn-press-tab-panel-' + $.cookie(data_cookie));
				$(".learn-press-nav-tab").removeClass("active");
				tab_class.addClass("active");
				$(".learn-press-tab-panel").removeClass("active");
				panel_class.addClass("active");
			}
		},

		/**
		 * Load more Profile
		 */
		loadmore_profile: function () {
			$('#load-more-button').on('click', '.loadmore', function (event) {
				event.preventDefault();

				var $sc = $('.profile-courses');

				var paged = parseInt($sc.attr('data-page')),
					limit = parseInt($sc.attr('data-limit')),
					count = parseInt($sc.attr('data-count')),
					userid = parseInt($sc.attr('data-user')),
					loading = false;

				if (!loading) {
					var $button = $(this);
					var rank = $sc.find('.course').length;
					loading = true;
					var current_page = paged + 1;

					var data = {
						action: 'thim_profile_loadmore',
						paged : current_page,
						limit : limit,
						rank  : rank,
						count : count,
						userid: userid,
					};

					console.log(data);

					$.ajax({
						type: "POST",
						url : ajaxurl,
						data: data,

						beforeSend: function () {
							$('#load-more-button').addClass('loading');

						},
						success   : function (res) {
							$sc.append(res);
							$('#load-more-button').removeClass('loading');
							$sc.attr('data-page', current_page);
							if ((rank + limit) >= count) {
								$('#load-more-button').remove();
							}
							$(window).lazyLoadXT();
						}
					});
				}
			});
		},

		/*
		 * Update user info in profile page
		 * */
		profile_update: function () {
			var $form = $('form[name="lp-edit-profile"]'),
				data = $form.serialize(),
				timer = null;
			$form.on('keyup change', 'input,textarea,select', function () {
				timer && clearTimeout(timer);
				timer = setTimeout(function () {
					$('#submit').attr('disabled', $form.serialize() === data);
				})
			});

			$form.on('submit', function () {
				var data = $form.serializeJSON(),
					completed = 0,
					$els = $('.lp-profile-section'),
					total = $els.length;

				$('#submit').css("color", "transparent")
				$form.find('#submit .sk-three-bounce').removeClass('hidden');

				$els.each(function () {
					data['lp-profile-section'] = $(this).find('input[name="lp-profile-section"]').val();
					if (data['lp-profile-section'] === 'avatar') {
						if ($(this).find('input[name="update-custom-avatar"]').last().val() !== 'yes') {
							completed++;
							return;
						}
					}
					$.post({
						url    : window.location.href,
						data   : data,
						success: function (res) {
							completed++;
							if (completed === total) {
								window.location.href = window.location.href;
							}
						}
					})
				});
				return false;
			});

			// Make update available immediately click on Remove button
			$('#tab-settings .clear-field').on('click', function () {
				$(this).siblings('input[type=text]').val('').trigger('change');
			});
		},

		/*
		 * Switch tab in profile page
		 * */
		get_tab_content: function (slug, current_tab) {
			$(".lp-profile .tabs-title .tab").removeClass("active");
			$(".lp-profile .tabs-title .tab[data-tab=" + current_tab + "]").addClass("active");

			$(".tabs-content .content").removeClass("active");
			$(slug).addClass("active");
		},

		profile_switch_tabs: function () {
			window.addEventListener('popstate', function (e) {
				var state = e.state;
				if (state == null) {
					thim_course_builder.get_tab_content('#tab-courses', 'courses_tab');
					return;
				}

				thim_course_builder.get_tab_content(state.slug, state.tab);
			});

			$(".tabs-title .tab > a").on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('href');
				var slug = $(this).attr('data-slug');
				var current_tab = $(this).parent().attr('data-tab');
				var tab_info = {slug: slug, tab: current_tab};

				thim_course_builder.get_tab_content(slug, current_tab);
				history.pushState(tab_info, null, url);
				if (current_tab == 'certificates_tab') {
					$(window).resize();
				}
			});
		},

		profile_slide_certificates: function () {
			var rtlval = false;
			if ($('body').hasClass('rtl')) {
				var rtlval = true;
			}
			$('#tab-settings .certificates-section .learn-press-user-profile-certs').owlCarousel({
				rtl       : rtlval,
				items     : 4,
				nav       : true,
				dots      : false,
				navText   : ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
				responsive: {
					0   : {
						items: 2,
					},
					481 : {
						items: 4,
					},
					1025: {
						items: 4,
					}
				}
			});

			$('#tab-settings .certificates-section .learn-press-user-profile-certs .more-info').on('click', function (e) {
				e.preventDefault();
				var url = $(this).parent().attr('href');
				history.pushState(null, null, url);
				thim_course_builder.get_tab_content('#tab-certificates', 'certificates_tab');
			});
		},

		/**
		 * Product single slider
		 */
		product_slider: function () {
			$('#carousel').flexslider({
				animation    : "slide",
				direction    : "vertical",
				controlNav   : false,
				animationLoop: false,
				slideshow    : false,
				itemWidth    : 101,
				itemMargin   : 5,
				maxItems     : 3,
				directionNav : false,
				asNavFor     : '#slider'
			});

			$('#slider').flexslider({
				animation    : "slide",
				controlNav   : false,
				animationLoop: false,
				directionNav : false,
				slideshow    : false,
				sync         : "#carousel"
			});
		},
		/**
		 * Quickview product
		 */
		quick_view    : function () {
			$('.quick-view').on('click', function (e) {
				/* add loader  */
				$('.quick-view span').css('display', 'none');
				$(this).append('<span class="loading dark"></span>');
				var product_id = $(this).attr('data-prod');
				var data = {action: 'jck_quickview', product: product_id};
				$.post(ajaxurl, data, function (response) {
					$.magnificPopup.open({
						mainClass: 'my-mfp-zoom-in',
						items    : {
							src : response,
							type: 'inline'
						}
					});
					$('.quick-view span').css('display', 'inline-block');
					$('.loading').remove();
					$('.product-card .wrapper').removeClass('animate');
					setTimeout(function () {
						$('.product-lightbox form').wc_variation_form();
					}, 600);

					$('#slider').flexslider({
						animation    : "slide",
						controlNav   : false,
						animationLoop: false,
						directionNav : true,
						slideshow    : false,
					});
				});
				e.preventDefault();
			});
		},
		
		coming_soon_hover_effect : function () {
			$(".thim-course-coming-soon .hover").mouseleave(
				function () {
					$(this).removeClass("hover");
				}
			)
		}
	};
})(jQuery);