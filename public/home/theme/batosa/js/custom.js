$(document).ready(function(){
  if ($('.description-box').height() > 500) {
    $('.description-box').addClass('wbc-height');
  }

  $('.description-box .read-more').click(function(){
    $('.description-box').removeClass('wbc-height');
  });

	$('.banner-top-home .banners').owlCarousel2({
	  margin: 0,
	  items: 3,
	  nav: false,
	  navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  autoplay: 400,
	  autoWidth: false,
	  dots: true,
	  responsive: {
	    0:  { items: 2 } ,
	    480: { items:2 },
	    768: { items: 3 }
	  },
	});
	$('.product-item-content').matchHeight();
	$('.product-thumb .price').matchHeight();
  $('.product-thumb h4').matchHeight();
  $('.related-blogs-list .blog-item .caption').matchHeight();
  $('.related-blogs-list .blog-item .caption a').matchHeight();
	$('.related-blogs-list .blog-item .caption .description').matchHeight();
  
  if($('.category-info .description-box .desc-content > div').height()>150){
    $('.description-box .readmore').click(function(){
      $('.description-box').addClass('open');
    });
  }else{
    $('.category-info').addClass('remove-readmore');
  }
});
