$(document).ready(function() {
    // Fungsi untuk memuat ulang riwayat suhu menggunakan Ajax
    function reloadRiwayatPh() {
        $.ajax({
            url: riwayatUrl, 
            type: 'GET',
            success: function(response) {
                // Memperbarui konten riwayat suhu
                $('#riwayat').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Memuat ulang riwayat suhu setiap 2 detik
    setInterval(function() {
        reloadRiwayatPh();
    }, 2000); // Interval waktu dalam milidetik
});
