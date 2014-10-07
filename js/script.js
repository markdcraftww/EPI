$(function() {
	var owl = $('#homePageCarousel');
	owl.owlCarousel({
		navigation: true,
		slideSpeed: 2000,
		paginationSpeed: 400,
		singleItem: true,
		autoPlay: 5000,
		stopOnHover: true,
		transitionStyle: 'fade'
	});
	$('.device-header').slideUp('slow');
	$('.menuToggle').on('click','a',function(e){
		e.preventDefault();
		$('.device-header').slideDown('slow');
		$(this).addClass('activeOpen');
		$('.menuToggle').on('click', '.activeOpen', function(e){
			e.preventDefault;
			$('.device-header').slideUp('slow');
			$(this).removeClass('activeOpen')
		});
	});
	if(exists($.cookie('EPI_Cookie'))) {
		
	} else {
		$('#cookie').fadeIn('fast');
		$.cookie('EPI_Cookie', 'EPI', { 
			expires: 1000000, path: '/'
		});
	}
	$('#closeCookie').on('click', function(e){
		e.preventDefault();
		$('#cookie').fadeOut('fast');
	});
	$('.how-to-engage-menu-item .sub-menu li a').on('click', function(){
		$('.how-to-engage-menu-item .sub-menu li a').removeClass('activeMenu');
		$(this).addClass('activeMenu');
	});
	$('div.page').fullpage({
		verticalCentered: true,
		resize : true,
		scrollingSpeed: 700,
		easing: 'easeInQuart',
		navigation: false,
		slidesNavigation: true,
		slidesNavPosition: 'bottom',
		loopBottom: false,
		loopTop: false,
		loopHorizontal: false,
		autoScrolling: true,
		scrollOverflow: true,
		css3: true,
		paddingTop: '0',
		paddingBottom: '0',
		fixedElements: '#mainMenu, .device-header, .menuToggle, #copyright, #cookie',
		keyboardScrolling: true,
		touchSensitivity: 20,
		slideSelector: '.slide',
		sectionSelector: '.section',
		animateAnchor: true,
		onLeave: function(index, direction){
			$('.device-header').slideUp('slow');
		},
		afterLoad: function(anchorLink, index){},
		afterRender: function(){},
		afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex){},
		onSlideLeave: function(anchorLink, index, slideIndex, direction){}
	});
	var $container = $('#sortable');
	$container.imagesLoaded(function() {
		$container.isotope({
			itemSelector: '.col-1-3'
		});
	});

	$('#desktopfilters').on('click', 'button', function(e) {
		e.preventDefault();
		$('.filterer').removeClass('activeFilter');
		$(this).addClass('activeFilter');
		var filterValue = $(this).attr('data-filter');
		var filterDesc = $(this).attr('data-desc');
		$('#cat_desc').fadeOut(250, 'linear', function(){
			$('#cat_desc').html(filterDesc);
			$('#cat_desc').fadeIn(250, 'linear');
		});		
		$container.isotope({ filter: filterValue });
	});

	$('#mobilefilters').on('click', 'button', function(e) {
		e.preventDefault();
		$('.filterer').removeClass('activeFilter');
		$(this).addClass('activeFilter');
		var filterValue = $(this).attr('data-filter');
		var filterDesc = $(this).attr('data-desc');
		$('#cat_desc').fadeOut(250, 'linear', function(){
			$('#cat_desc').html(filterDesc);
			$('#cat_desc').fadeIn(250, 'linear');
		});
		$('.filterhide').hide('slow');
		$container.isotope({ filter: filterValue });
	});
	$('#mobilefilters').on('click', 'h4', function(e) {
		$('.filterhide').show('slow');
		$(this).addClass('open');
	});
	$('#mobilefilters').on('click', 'h4.open', function(e) {
		$('.filterhide').hide('slow');
		$(this).removeClass('open');
	});
});
var $allVideos = $("iframe[src*='youtube.com'], iframe[src*='vimeo.com']"),
$fluidEl = $('.padding');
$allVideos.each(function() {
    $(this).data('aspectRatio', this.height / this.width)
    .removeAttr('height')
    .removeAttr('width');
});

$(window).resize(function() {
	var newWidth = $fluidEl.width();
	$allVideos.each(function() {
		var $el = $(this);
		$el
		.width(newWidth)
		.height(newWidth * $el.data('aspectRatio'));
	});

}).resize();

$(document).keyup(function(e) {if(e.keyCode == 27) {$('.device-header').slideUp('slow');}});
function exists(data) {if(!data || data==null || data=='undefined' || typeof(data)=='undefined') return false;else return true;}