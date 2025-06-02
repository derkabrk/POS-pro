window.addEventListener("scroll", function () {
    var header = document.querySelector(".header-section.home-header");
    var scrollPosition = window.scrollY;

    if (scrollPosition > 5) {
        header.classList.add("bg-0d0d16");
    } else {
        header.classList.remove("bg-0d0d16");
    }
});

/* ----------------------------------------------- */
/* Slick Slider */
/* ----------------------------------------------- */

$(document).ready(function () {
    $(".slick-slider-section .app-slide").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        rtl: false,
        autoplay: true,
        autoplaySpeed: 1500,
        infinite: true,
        pauseOnFocus: false,
        responsive: [{
                breakpoint: 1400,
                settings: {
                    slidesToShow: 3,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                },
            },
        ],
    });
});

$(document).ready(function () {
    $(".customer-slider-section .row").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: false,
        rtl: false,
        autoplay: true,
        autoplaySpeed: 1500,
        infinite: true,
        pauseOnFocus: false,
        responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                },
            },
        ],
    });
});

/* ----------------------------------------------- */
/* Top Scroll */
/* ----------------------------------------------- */
$(document).ready(function () {
    $("#scrollToTopButton").on("click", function () {
        $("html, body").animate({
                scrollTop: 0,
            },
            "slow"
        );
    });
});
/* ----------------------------------------------- */
/* product-details Slide Image */
/* ----------------------------------------------- */
$(document).ready(function () {
    $(".product-details-small-image").on("click", function () {
        var newImageSrc = $(this).data("image-src");
        $("#product-details-big-image").attr("src", newImageSrc);
        $(".product-details-small-image")
            .parent()
            .removeClass("product-details-custom-b");
        $(this).parent().addClass("product-details-custom-b");
    });
});

/* ----------------------------------------------- */
/* About Page Read More Button */
/* ----------------------------------------------- */
$(document).ready(function () {
    $("#readMoreButton").on("click", function () {
        if ($("#moreText").css("display") === "none") {
            $("#moreText").css("display", "block");
            $("#readMoreButton").hide();
        } else {
            $("#moreText").css("display", "none");
        }
    });
});
/* ----------------------------------------------- */
/* Blogs page tags active button */
/* ----------------------------------------------- */
$(document).ready(function () {
    $(".tags-btn").on("click", function () {
        $(".tags-btn")
            .removeClass("blogs-tag-btn-selected")
            .addClass("blogs-tag-btn-unselected");
        $(this)
            .removeClass("blogs-tag-btn-unselected")
            .addClass("blogs-tag-btn-selected");
    });
});

(function ($) {
    "use strict";

    var $swiperSelector = $(".creative-interface-slider");
    $swiperSelector.each(function (index) {
        var $this = $(this);
        $this.addClass("swiper-sliderone-" + index);

        var dragSize = $this.data("drag-size") ? $this.data("drag-size") : 50;
        var freeMode = $this.data("free-mode") ? $this.data("free-mode") : false;
        var loop = $this.data("loop") ? $this.data("loop") : true;
        var slidesDesktop = $this.data("slides-desktop") ?
            $this.data("slides-desktop") :
            4;
        var slideslaptop = $this.data("slides-laptop") ?
            $this.data("slides-laptop") :
            4;
        var slidesTablet = $this.data("slides-tablet") ?
            $this.data("slides-tablet") :
            4;
        var slidesMobile = $this.data("slides-mobile") ?
            $this.data("slides-mobile") :
            2.2;
        var spaceBetween = $this.data("space-between") ?
            $this.data("space-between") :
            20;

        var swiper7 = new Swiper(".swiper-sliderone-" + index, {
            direction: "horizontal",
            loop: loop,
            freeMode: freeMode,
            spaceBetween: spaceBetween,
            breakpoints: {
                1920: {
                    slidesPerView: slidesDesktop,
                },
                1024: {
                    slidesPerView: slideslaptop,
                },
                767: {
                    slidesPerView: slidesTablet,
                },
                320: {
                    slidesPerView: slidesMobile,
                },
            },
            navigation: {
                nextEl: ".next",
                prevEl: ".prev",
            },
            scrollbar: {
                el: ".swiper-scrollbar",
                draggable: true,
                dragSize: dragSize,
            },
        });
    });

    var $swiperSelectorOne = $(".premium-product-slide");
    $swiperSelectorOne.each(function (index) {
        var $this = $(this);
        $this.addClass("swiper-slidertwo-" + index);

        var dragSize = $this.data("drag-size") ? $this.data("drag-size") : 50;
        var freeMode = $this.data("free-mode") ? $this.data("free-mode") : false;
        var loop = $this.data("loop") ? $this.data("loop") : true;
        var slidesDesktop = $this.data("slides-desktop") ?
            $this.data("slides-desktop") :
            3;
        var slideslaptop = $this.data("slides-laptop") ?
            $this.data("slides-laptop") :
            3;
        var slidesTablet = $this.data("slides-tablet") ?
            $this.data("slides-tablet") :
            2.5;
        var slidesMobile = $this.data("slides-mobile") ?
            $this.data("slides-mobile") :
            1.2;
        var spaceBetween = $this.data("space-between") ?
            $this.data("space-between") :
            20;

        var swiper5 = new Swiper(".swiper-slidertwo-" + index, {
            direction: "horizontal",
            loop: loop,
            freeMode: freeMode,
            spaceBetween: spaceBetween,
            breakpoints: {
                1920: {
                    slidesPerView: slidesDesktop,
                },
                1024: {
                    slidesPerView: slideslaptop,
                },
                767: {
                    slidesPerView: slidesTablet,
                },
                320: {
                    slidesPerView: slidesMobile,
                },
            },
            navigation: {
                nextEl: ".next1",
                prevEl: ".prev1",
            },
            scrollbar: {
                el: ".swiper-scrollbar",
                draggable: true,
                dragSize: dragSize,
            },
        });
    });

    var $swiperSelectorTwo = $(".testimonial-slider");
    $swiperSelectorTwo.each(function (index) {
        var $this = $(this);
        $this.addClass("swiper-sliderthree-" + index);

        var dragSize = $this.data("drag-size") ? $this.data("drag-size") : 50;
        var freeMode = $this.data("free-mode") ? $this.data("free-mode") : false;
        var loop = $this.data("loop") ? $this.data("loop") : true;
        var slidesDesktop = $this.data("slides-desktop") ?
            $this.data("slides-desktop") :
            3;
        var slideslaptop = $this.data("slides-laptop") ?
            $this.data("slides-laptop") :
            3;
        var slidesTablet = $this.data("slides-tablet") ?
            $this.data("slides-tablet") :
            1.5;
        var slidesMobile = $this.data("slides-mobile") ?
            $this.data("slides-mobile") :
            1;
        var spaceBetween = $this.data("space-between") ?
            $this.data("space-between") :
            20;

        var swiper2 = new Swiper(".swiper-sliderthree-" + index, {
            direction: "horizontal",
            loop: loop,
            freeMode: freeMode,
            spaceBetween: spaceBetween,
            breakpoints: {
                1920: {
                    slidesPerView: slidesDesktop,
                },
                1024: {
                    slidesPerView: slideslaptop,
                },
                767: {
                    slidesPerView: slidesTablet,
                },
                320: {
                    slidesPerView: slidesMobile,
                },
            },
            navigation: {
                nextEl: ".next2",
                prevEl: ".prev2",
            },
            scrollbar: {
                el: ".swiper-scrollbar",
                draggable: true,
                dragSize: dragSize,
            },
        });
    });

    var swiper = new Swiper(".admin-panel-slider", {
        slidesPerView: 1,
        spaceBetween: 30,
        autoplay: false,
        loop: true,
        speed: 1400,
        autoplay: {
            delay: 6000,
        },
        navigation: {
            nextEl: ".next5",
            prevEl: ".prev5",
        },
    });
})(jQuery);

// show signup
$('.choose-plan-btn').on('click', function () {

    $('#signup-modal').modal('show');

    var route = $('#get-business-categories').val();
    var plan_id = $(this).data('plan_id');
    var plan_name = $(this).data('plan_name');

    $('#subscription_name').text(plan_name)
    $('#plan_id').val(plan_id)

    $.ajax({
        url: route,
        method: 'GET',
        success: function (data) {
            var category_select = $('#business_category');
            category_select.empty();

            category_select.append(`<option value="">Select Business Category</option>`);
            $.each(data, function (index, category) {
                category_select.append(`<option value="${category.id}">${category.name}</option>`);
            });
        },
    });

});
