$(document).ready(function() {
    // Initial load of stories
    loadMoreStories('kumpulan-cerita', 'left', 1, 4);
    loadMoreStories('ceritaku', 'right', 1, 2);

    // Load more button click events
    $('#load-more-left').on('click', function() {
        loadMoreStories('kumpulan-cerita', 'left');
    });

    $('#load-more-right').on('click', function() {
        loadMoreStories('ceritaku', 'right');
    });

    function loadMoreStories(containerId, section, page = 1, perPage = 4) {
        $.ajax({
            url: 'load_stories.php', // Gantilah dengan URL sesuai dengan skrip PHP Anda
            method: 'GET',
            data: { section: section, page: page, perPage: perPage },
            success: function(data) {
                $('#' + containerId).append(data);
            },
            error: function(error) {
                console.error(error);
            }
        });
    }
});

$(document).ready(function() {
    // Tampilkan cerita Ceritaku saat halaman dimuat
    loadStories('ceritaku', 1, 4);

    // Event ketika option di combobox diubah
    $('#category-dropdown').on('change', function() {
        var selectedCategory = $(this).val();
        if (selectedCategory === 'Ceritaku') {
            // Tampilkan cerita Ceritaku
            $('#kumpulan-cerita').hide();
            $('#ceritaku').show();
            loadStories('ceritaku', 1, 4);
        } else if (selectedCategory === 'Kumpulan Cerita') {
            // Tampilkan cerita Kumpulan Cerita
            $('#ceritaku').hide();
            $('#kumpulan-cerita').show();
            loadStories('kumpulan-cerita', 1, 4);
        }
    });

    // Event load more untuk Ceritaku
    $('#load-more-ceritaku').on('click', function() {
        loadStories('ceritaku');
    });

    // Event load more untuk Kumpulan Cerita
    $('#load-more-kumpulan-cerita').on('click', function() {
        loadStories('kumpulan-cerita');
    });

    function loadStories(category, page = 1, perPage = 4) {
        $.ajax({
            url: 'load_stories.php', // Gantilah dengan URL sesuai dengan skrip PHP Anda
            method: 'GET',
            data: { category: category, page: page, perPage: perPage },
            success: function(data) {
                $('#' + category).html(data);
            },
            error: function(error) {
                console.error(error);
            }
        });
    }
});

