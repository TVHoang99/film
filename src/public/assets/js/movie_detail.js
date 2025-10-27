$(document).ready(function() {
    // Smooth scrolling for nav links
    $('a.nav-link').on('click', function(e) {
        if (this.hash !== '') {
            e.preventDefault();
            const hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 70
            }, 800);
        }
    });

    // Form submission alert (for demo)
    $('#login-form, #register-form').on('submit', function(e) {
        e.preventDefault();
        alert('Form đã được gửi! (Chức năng này cần backend để xử lý.)');
    });

    // Search form submission alert (for demo)
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        const query = $(this).find('input[type="search"]').val();
        alert('Tìm kiếm: ' + query + ' (Chức năng này cần backend để xử lý.)');
    });

    // Khởi tạo Slick Slider cho danh sách phim
    $('.movie-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    // Rating form submission alert (for demo)
    $('#rating-form').on('submit', function(e) {
        e.preventDefault();
        const rating = $(this).find('#rating').val();
        alert('Đánh giá ' + rating + ' sao đã được gửi! (Chức năng này cần backend để xử lý.)');
    });

    // Comment form submission alert (for demo)
    $('#comment-form').on('submit', function(e) {
        e.preventDefault();
        const comment = $(this).find('#comment').val();
        alert('Bình luận: "' + comment + '" đã được gửi! (Chức năng này cần backend để xử lý.)');
    });
});
