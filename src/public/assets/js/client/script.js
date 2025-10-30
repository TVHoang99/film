// Kiểm tra JQuery
if (typeof jQuery === 'undefined') {
    console.error('JQuery không được tải. Vui lòng kiểm tra script trong header.');
} else {
    $(document).ready(function () {
        // Kiểm tra phần tử DOM
        const searchInput = $('#search-input');
        const searchForm = $('#search-form');
        const searchDropdown = $('#search-dropdown');
        const searchResults = $('#search-results');

        if (!searchInput.length || !searchForm.length || !searchDropdown.length || !searchResults.length) {
            console.error('Không tìm thấy phần tử DOM: #search-input, #search-form, #search-dropdown, hoặc #search-results');
            return;
        }

        // Debounce để hạn chế gửi AJAX liên tục
        let debounceTimeout;
        function debounce(func, wait) {
            return function () {
                const context = this; // Lưu ngữ cảnh của this
                const args = arguments;
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(() => {
                    // console.log('Debounce executed, context:', context); // Debug ngữ cảnh
                    func.apply(context, args);
                }, wait);
            };
        }

        // Xử lý keyup cho Smart Hint
        searchInput.on('keyup', debounce(function (event) {
            const input = $(this); // Lưu $(this) để đảm bảo ngữ cảnh
            const query = (input.val() || '').trim(); // Giá trị mặc định là chuỗi rỗng
            console.log('Search query:', query, 'Input value:', input.val());
            if (query.length < 2) {
                console.log(11111111);
                searchDropdown.hide();
                return;
            }

            // Hiển thị spinner loading
            searchResults.html('<div class="dropdown-item p-2 text-muted"><i class="fas fa-spinner fa-spin me-2"></i> Đang tìm kiếm...</div>');
            searchDropdown.show();
            console.log(22222222222);

            $.ajax({
                url: '/ajax-search',
                type: 'GET',
                data: { q: query },
                dataType: 'json',
                success: function (data) {
                    console.log('AJAX response:', data);
                    if (Array.isArray(data) && data.length > 0) {
                        let html = '';
                        data.forEach(function (movie) {
                            const title = movie.title || 'Không có tiêu đề';
                            const url = movie.url || '#';
                            const poster = movie.poster || 'https://placehold.co/40x60?text=No+Image';
                            const rating = movie.rating || 'N/A';
                            const views = movie.views || '0';

                            html += `
                                <a href="${url}" class="dropdown-item d-flex align-items-center p-2 border-bottom text-decoration-none">
                                    <img src="${poster}" class="rounded me-2" style="width: 40px; height: 60px; object-fit: cover;" alt="${title}">
                                    <div class="flex-fill">
                                        <div class="fw-bold text-truncate" style="max-width: 250px;">${title}</div>
                                        <small class="text-muted">
                                            <i class="fas fa-star text-warning me-1"></i> ${rating} | 
                                            <i class="far fa-eye me-1"></i> ${views}
                                        </small>
                                    </div>
                                </a>
                            `;
                        });
                        searchResults.html(html);
                        searchDropdown.show();
                    } else {
                        searchResults.html('<div class="dropdown-item p-2 text-muted">Không tìm thấy phim</div>');
                        searchDropdown.show();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Search AJAX error:', status, error);
                    searchResults.html('<div class="dropdown-item p-2 text-muted">Lỗi khi tìm kiếm</div>');
                    searchDropdown.show();
                }
            });
        }, 300));

        // Ẩn dropdown khi click ra ngoài
        $(document).on('click', function (e) {
            if (!searchForm.has(e.target).length) {
                searchDropdown.hide();
            }
        });

        // Ẩn dropdown khi ô tìm kiếm mất focus
        searchInput.on('blur', function () {
            setTimeout(function () {
                searchDropdown.hide();
            }, 200); // Delay để cho phép click vào dropdown
        });

        // Submit form
        searchForm.on('submit', function (e) {
            const query = searchInput.val().trim();
            if (query.length < 2) {
                e.preventDefault();
                alert('Vui lòng nhập ít nhất 2 ký tự để tìm kiếm.');
                return false;
            }
            searchDropdown.hide();
        });
    });
}
