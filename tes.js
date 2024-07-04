let kumpulanPage = 1;
let ceritakuPage = 1;

$(document).ready(function () {
    loadMore('kumpulan');
    loadMore('ceritaku');
});

function loadMore(category) {
    $.ajax({
        url: 'paging.php',
        method: 'POST',
        data: { category: category, page: (category === 'kumpulan' ? kumpulanPage : ceritakuPage) },
        success: function (data) {
            const containerId = (category === 'kumpulan' ? '#kumpulan-cerita' : '#ceritaku');
            $(containerId).append(data);
            (category === 'kumpulan' ? kumpulanPage++ : ceritakuPage++);
        }
    });
}
