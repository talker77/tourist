$(function () {


  var swiper = new Swiper(".gray_icon_lists", {
    slidesPerView: "1.4",
    spaceBetween: 30,
    pagination: false,
    centeredSlides: true,
    initialSlide : 1,
    autoplay: {
      delay: 1800,
      disableOnInteraction: false,
    },

    breakpoints: {
      640: {
        slidesPerView: 2.4,
        spaceBetween: 20,
        centeredSlides: true,
      },
      768: {
        slidesPerView: 3.4,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1024: {
        slidesPerView: 5,
        spaceBetween: 30,
        centeredSlides: false,
      },
    },

  });


  var swiper = new Swiper(".attraction_carousel_centered", {
    slidesPerView: "1",
    spaceBetween: 30,
    pagination: false,
    centeredSlides: true,
    initialSlide : 1,
    
    autoplay:false,

    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    breakpoints: {
      320: {
        slidesPerView: 1.3,
        spaceBetween: 20,
        centeredSlides: true,
      },
      375: {
        slidesPerView: 1.3,
        spaceBetween: 20,
        centeredSlides: true,
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 20,
        centeredSlides: true,
      },
      768: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false,
      },
    },

  });

  var swiper = new Swiper(".prices_carousel", {
    slidesPerView: "1",
    spaceBetween: 30,
    pagination: false,
    centeredSlides: true,
    initialSlide : 4,

    autoplay:false,

    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    breakpoints: {
      320: {
        slidesPerView: 1.3,
        spaceBetween: 20,
        centeredSlides: true,
      },
      375: {
        slidesPerView: 1.3,
        spaceBetween: 20,
        centeredSlides: true,
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 20,
        centeredSlides: true,
      },
      768: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false,
      },
    },

  });

  var swiper = new Swiper(".museum_pass_slider", {
    slidesPerView: "1.2",
    spaceBetween: 30,
    pagination: false,
    loop: true,
    initialSlide : 1,


    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    breakpoints: {
      640: {
        slidesPerView: 1.2,
        spaceBetween: 20,
        centeredSlides: true,
      },
      768: {
        slidesPerView: 2.3,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
        centeredSlides: false,
      },
    },

  });  



  var swiper = new Swiper(".days_slider", {
    slidesPerView: "1",
    spaceBetween: 30,
    pagination: false,
    centeredSlides: true,
    initialSlide : 0,


    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },


  });


  



  var swiper = new Swiper(".testimonials_slider", {
    slidesPerView: "1",
    spaceBetween: 0,
    autoplay: {
      delay: 1800,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },

    breakpoints: {
      1280: {
        slidesPerView: 1,
        spaceBetween: 30,
        centeredSlides: false,
      },
    },

  });



  var swiper = new Swiper(".red_slider", {
    slidesPerView: "1",
    spaceBetween: 0,
    autoplay: {
      delay: 1800,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },

  });  




  var swiper = new Swiper(".video_testim_slider", {
    slidesPerView: "4",
    spaceBetween: 30,
    pagination: false,
    centeredSlides: true,
    initialSlide : 1,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    breakpoints: {
      300: {
        slidesPerView: 1.5,
        spaceBetween: 20,
        centeredSlides: true,
      },
      400: {
        slidesPerView: 1.5,
        spaceBetween: 20,
        centeredSlides: true,
      },
      640: {
        slidesPerView: 1.5,
        spaceBetween: 20,
        centeredSlides: true,
      },
      768: {
        slidesPerView: 1.5,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1280: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false,
      },
    },

  });



  var swiper = new Swiper(".video_ist_slider", {
    slidesPerView: "1.5",
    spaceBetween: 30,
    pagination: false,
    centeredSlides: true,
    initialSlide : 1,

    breakpoints: {
      640: {
        slidesPerView: 1,
        spaceBetween: 20,
        centeredSlides: true,
      },
      768: {
        slidesPerView: 1,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1200: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1300: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false,
      },
    },

  });



  var swiper = new Swiper(".partners_slider", {
    slidesPerView: "3",
    spaceBetween: 30,

    autoplay: {
      delay: 1800,
      disableOnInteraction: false,
    },
    breakpoints: {
      640: {
        slidesPerView: 3,
        spaceBetween: 30,
        centeredSlides: true,
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 30,
        centeredSlides: false,
      },
    },

  });



  var swiper = new Swiper(".notif_slider", {
    slidesPerView: "1",
    spaceBetween: 30,
    autoHeight: true,
    initialSlide : 1,
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },

  });



  var swiper = new Swiper(".numbers_slider", {
    slidesPerView: "4",
    spaceBetween: 12,
    autoplay: {
      delay: 1800,
      disableOnInteraction: false,
    },
    breakpoints: {
      640: {
        slidesPerView: 2,
        spaceBetween: 15,
        centeredSlides: true,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 15,
        centeredSlides: false,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1920: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false,
      },
    },

  });



  var swiper = new Swiper(".blog_posts_slider", {
    slidesPerView: "1",
    spaceBetween: 14,
    autoplay: {
      delay: 1800,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      640: {
        slidesPerView: 1,
        spaceBetween: 30,
        centeredSlides: true,
      },
      768: {
        slidesPerView: 1,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1024: {
        slidesPerView: 1,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1200: {
        slidesPerView: 3,
        spaceBetween: 30,
        centeredSlides: false,
      },
    },

  });







  $(".tabbar_container > div:nth-child(5)").on("click", function () {

    $(".mobile_menu_container").addClass("opened");
    $("html").addClass("menu_opened");

  });


  $(".close_mobile_menu").on("click", function () {

    $(".mobile_menu_container").removeClass("opened");
    $("html").removeClass("menu_opened");

  });




  // Accordion Action
  const accordionItem = document.querySelectorAll(".accordion-item");

  accordionItem.forEach((el) =>
    el.addEventListener("click", () => {
      if (el.classList.contains("active")) {
        el.classList.remove("active");
      } else {
        accordionItem.forEach((el2) => el2.classList.remove("active"));
        el.classList.add("active");
      }
    })
  );




  $(".lang_container > span").on("click", function () {

    $(".lang_container + .lang_list").toggleClass("opened");
    $(".lang_container").toggleClass("active");

  });







  var descMinHeight = 150;



  // When clicking more/less button
  $('.more-info').click(function () {

    var fullHeight = $('.desc').height();

    if ($(this).hasClass('expand')) {
      // contract
      $(this).parent().find(".desc-wrapper").animate({ 'height': descMinHeight }, 'fast');
      $(this).parent().find(".desc-wrapper").removeClass("active_more");
      $("html, body").animate({ scrollTop: 800 }, "slow");
    }
    else {
      // expand 
      $(this).parent().find(".desc-wrapper").css({ 'height': 'auto', 'max-height': 'none' }).animate({ 'height': 'auto' }, 'fast');
      $(this).parent().find(".desc-wrapper").addClass("active_more");
    }

    $(this).toggleClass('expand');
    return false;
  });







  $('.nested-accordion').find('.comment').slideUp();
  $('.comment .nested-accordion').find('h3').click(function () {
    //$(this).next('.comment').slideToggle(100);
    $(this).toggleClass('selected');
  });

  $('.nested-accordion').find('h3').click(function () {
    $(this).parent().find('.faqTitle').slideToggle(100);
    $(this).toggleClass('selected');
  });
  $('.nested-accordion .faqTitle').find('h3').click(function () {
    $(this).parent().find('.comment').slideToggle(100);
    $(this).toggleClass('selected');
  });
  $('.att_detail_accordion').find('h3').click(function () {
    $(this).toggleClass('selected');
  });





  var swiper = new Swiper(".blog_imgs_carousel", {
    slidesPerView: "1.3",
    spaceBetween: 20,
    pagination: false,
    centeredSlides: true,

    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    breakpoints: {
      640: {
        slidesPerView: 1.3,
        spaceBetween: 20,
        centeredSlides: true,
      },
      768: {
        slidesPerView: 3.3,
        spaceBetween: 30,
        centeredSlides: false,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false,
      },
    },

  });



  var swiper = new Swiper(".word-rotating", {
    direction: "vertical",
    autoplay: {
      delay: 1800,
      disableOnInteraction: false,
    },
  });


  $(".checkout_price_t_footer").on("click", function () {

    $(".detail_foot_box").toggle();
    $(this).toggleClass("active");

  });


  $(".att_detail_icons a.like").on("click", function (e) {

    e.preventDefault();

    $(this).toggleClass("active");

  });



  $(".att_detail_accordion").on("click", function () {

    $(".att_detail_accordion_container").find(".att_detail_accordion").removeClass("active");

    $(this).addClass("active");

  });


  $(".video-btn").YouTubePopUp({ autoplay: 1 });


  $(".att_detail_accordion").on("click", function () {

    if($(window).width() > 768) {
      $([document.documentElement, document.body]).animate({
        scrollTop: $(this).offset().top - 90
      }, 800);
    }else{
      $([document.documentElement, document.body]).animate({
        scrollTop: $(this).offset().top -90
      }, 800);
    }

  });


  $(".nested-accordion h3").on("click", function () {

    if($(window).width() > 768) {
      $([document.documentElement, document.body]).animate({
        scrollTop: $(this).offset().top - 90
      }, 800);
    }else{
      $([document.documentElement, document.body]).animate({
        scrollTop: $(this).offset().top - 90
      }, 800);
    }

  });




  $(".filter_cl_text").on("click", function () {

    $(this).parent(".t_filter").addClass("active");
    $("html").addClass("menu_opened");


  });


  $(".closeFilter").on("click", function () {

    $(this).parents(".t_filter").removeClass("active");
    $("html").removeClass("menu_opened");

  });






});




$(document).ready(function () {
  $('.count').prop('disabled', true);
  $('.plus').on('click', function () {
    counts = $(this).parent().find(".count");
    counts.val(parseInt(counts.val()) + 1);
  });
  $('.minus').on('click', function () {
    counts = $(this).parent().find(".count");
    counts.val(parseInt(counts.val()) - 1);
    if (counts.val() == 0) {
      counts.val(1);
    }
  });
});


$(window).scroll(function(){
  var sticky = $('.sticky'),
      scroll = $(window).scrollTop();

  if (scroll >= 200) sticky.addClass('fixed_nav');
  else sticky.removeClass('fixed_nav');
});



$(function(){
  var lastScrollTop = 0, delta = 30;
  $(window).scroll(function(){
     var nowScrollTop = $(this).scrollTop();

     
     if(nowScrollTop > 500){
      if(Math.abs(lastScrollTop - nowScrollTop) >= delta){
      if (nowScrollTop > lastScrollTop){
  $("body").addClass("scrollDown");
  $("body").removeClass("scrollUp");
      } else {
  $("body").removeClass("scrollDown");
  $("body").addClass("scrollUp");
      }
      lastScrollTop = nowScrollTop;
      }
    }


  });



  if($("#js-rotating").length){

    $("#js-rotating").Morphext({
      // The [in] animation type. Refer to Animate.css for a list of available animations.
      animation: "fadeInDown",
      // An array of phrases to rotate are created based on this separator. Change it if you wish to separate the phrases differently (e.g. So Simple | Very Doge | Much Wow | Such Cool).
      separator: ",",
      // The delay between the changing of each phrase in milliseconds.
      speed: 3000,
      complete: function () {
          $("#js-rotating span").addClass("ic_"+this.index);
      }
    });


    $("#js-rotating_ic").Morphext({
      // The [in] animation type. Refer to Animate.css for a list of available animations.
      animation: "fadeInDown",
      // An array of phrases to rotate are created based on this separator. Change it if you wish to separate the phrases differently (e.g. So Simple | Very Doge | Much Wow | Such Cool).
      separator: ",",
      // The delay between the changing of each phrase in milliseconds.
      speed: 3000,
      complete: function () {
          // Called after the entrance animation is executed.
      }
    });  

  }


  

  setTimeout(function(){
    $(".ms-slider-cont").addClass("show");
  }, 400);

});









$(document).ready(function(){
    
  $(window).scroll(function(){
      if ($(this).scrollTop() > 100) {
          $('.scrollToTop').fadeIn();
      } else {
          $('.scrollToTop').fadeOut();
      }
  });
  
  $('.scrollToTop').click(function(){
      $('html, body').animate({scrollTop : 0},800);
      return false;
  });




  if($("a[data-lightbox]").length){

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })

  }
  
});

$('.rating3').barrating({
  theme: 'fontawesome-stars-o',
  initialRating: '3',
  readonly: true
});
$('.rating3_5').barrating({
  theme: 'fontawesome-stars-o',
  initialRating: '3.5',
  readonly: true
});
$('.rating4').barrating({
  theme: 'fontawesome-stars-o',
  initialRating: '4',
  readonly: true
});
$('.rating4_5').barrating({
  theme: 'fontawesome-stars-o',
  initialRating: '4.5',
  readonly: true
});
$('.rating4_8').barrating({
  theme: 'fontawesome-stars-o',
  initialRating: '4.8',
  readonly: true
});
$('.rating5').barrating({
  theme: 'fontawesome-stars-o',
  initialRating: '5',
  readonly: true
});
$('.rating_active_2').barrating({
  theme: 'fontawesome-stars-o',
  initialRating: '4.5',
  readonly: true
});

$('.rating_active').barrating({
  theme: 'fontawesome-stars-o',
  initialRating: '0',
  readonly: false
});


$( ".daybtn" ).click(function() {
  $('.pricepop').show();
  $('#children').val(0);
  $('#adults').val(1);
  $('.bg_white').css({"border": "none"});
  $(this).closest('.bg_white').css({"border-color": "#F0034E","border-width":"1px","border-style":"solid"});
  $('#child_price').html('€0');
  var val = $(this).data("value");
  var id = $(this).data("id");
  var sale1 = $('#day'+id+'_sale1').html();
  var price1 = $('#day'+id+'_price1').html()
  let adultSale = sale1.replace('€','');
  let adultPrice = price1.replace('€','');
  let defaultDiscount = adultSale-adultPrice;
  $('.popdays').html(id);
  $('#product').val(val);
  $('#adultsale').val($('#day'+id+'_sale1').html().replace('€',''));
  $('#adultprice').val($('#day'+id+'_price1').html().replace('€',''));
  $('#childsale').val($('#day'+id+'_sale2').html().replace('€',''));
  $('#childprice').val($('#day'+id+'_price2').html().replace('€',''));

  $('#adult_price').html($('#day'+id+'_sale1').html());
  $('#order_total').html($('#day'+id+'_price1').html());
  $('#sale_discount').html('-€'+defaultDiscount);
  $('#saving').val(defaultDiscount);
});
$('#adults, #children').on('change', function (e) {
  var ad = $('#adults').val();
  var ch = $('#children').val();
  var saleAdultChange = $('#adultsale').val();
  var priceAdultChange = $('#adultprice').val();
  var saleChildChange = $('#childsale').val();
  var priceChildChange = $('#childprice').val();

  var totalAdultSale = (ad*saleAdultChange)-(ad*priceAdultChange);
  var totalChildSale = (ch*saleChildChange)-(ch*priceChildChange);
  var totalAdultPrice = (ad*priceAdultChange);
  var totalChildPrice = (ch*priceChildChange);

  if(!totalAdultSale)  totalAdultSale = 0;
  if(!totalChildSale) totalChildSale = 0;
  if(!totalAdultPrice) totalAdultPrice = 0;
  if(!totalChildPrice) totalChildPrice = 0;

  $('#adult_price').html('€'+(ad*saleAdultChange));
  $('#child_price').html('€'+(ch*saleChildChange));

  $('#sale_discount').html('-€'+(totalAdultSale+totalChildSale));
  $('#saving').val(totalAdultSale+totalChildSale);
  $('#order_total').html('€'+(totalAdultPrice+totalChildPrice));

});

/* <![CDATA[ */
    function doGTranslate(lang_pair) {
        if(lang_pair.value)
            lang_pair=lang_pair.value;
        if(lang_pair=='')
            return;
        var lang=lang_pair.split('|')[1];
        var plang=location.pathname.split('/')[1];
        if(plang.length !=2 && plang.toLowerCase() != 'zh-cn' && plang.toLowerCase() != 'zh-tw')
            plang='en';
        if(lang == 'en')
            location.href=location.protocol+'//'+location.host+location.pathname.replace('/'+plang+'/', '/')+location.search;
        else location.href=location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang+'/', '/')+location.search;
      }
/* ]]> */











