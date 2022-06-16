
    if ($(window).width() < 600) {
        $('.pricing-mobil-slider').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 3000,
            pauseOnHover: true,
            centerMode: true,
            pauseOnDotsHover: true,
            initialSlide: 1
        });

    }else {

        $('.pricing-mobil-slider').slick({
            autoplay: false,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
        });

    }

    $(window).on("resize", function(){
        console.log('resized');

        $('.pricing-mobil-slider').slick('unslick');

        if ($(window).width() < 600) {
            $('.pricing-mobil-slider').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 3000,
                pauseOnHover: true,
                centerMode: true,
                pauseOnDotsHover: true,
                initialSlide: 1
            });

        } else {
            $('.pricing-mobil-slider').slick({
                autoplay: false,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3,
            });

        }
    });



