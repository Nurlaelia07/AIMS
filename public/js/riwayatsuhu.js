$(document).ready(function() {
    function reloadRiwayatSuhu(filter) {
        $('#riwayat-container').load(riwayatUrl + ' #riwayat', { filter: filter }, function(response, status, xhr) {
            if (status == "error") {
                console.error(xhr.responseText);
            }
        });
    }

    $('#filter').on('change', function() {
        var selectedFilter = $(this).val();
        reloadRiwayatSuhu(selectedFilter);
    });

    setInterval(function() {
        var currentFilter = $('#filter').val();
        reloadRiwayatSuhu(currentFilter);
    }, 2000);
});
