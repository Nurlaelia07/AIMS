<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span id="badgeCounter" class="badge badge-danger badge-counter"></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header" style="background-color: #23AF4F; border: none">
                    Notifications
                </h6>
                <a id="suhuNotificationLink" class="dropdown-item d-flex align-items-center" href="#">
                </a>
                <a id="phNotificationLink" class="dropdown-item d-flex align-items-center" href="#">
                </a>
                <a id="ppmNotificationLink" class="dropdown-item d-flex align-items-center" href="#">
                </a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ session('username')}}</span>
                <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Function to add notification for all parameters
    function addNotification(suhu, minSuhu, maxSuhu, ph, minPh, maxPh, ppm, minPpm, maxPpm) {
        var suhuNotificationLink = document.getElementById('suhuNotificationLink');
        var phNotificationLink = document.getElementById('phNotificationLink');
        var ppmNotificationLink = document.getElementById('ppmNotificationLink');
        var notificationCount = 0;

        // Check suhu condition
        if (suhu > maxSuhu) {
            suhuNotificationLink.innerHTML = `
                <div class="notification-item">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div class="small text-gray-500">
                        Suhu: ${suhu}°C - Suhu di atas parameter. Segera tambahkan air dingin dan dinginkan instalasi
                    </div>
                </div>
            `;
            notificationCount++;
        } else if (suhu < minSuhu) {
            suhuNotificationLink.innerHTML = `
                <div class="notification-item">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div class="small text-gray-500">
                        Suhu: ${suhu}°C - Suhu di bawah parameter. Segera tambahkan air hangat dan hangatkan instalasi
                    </div>
                </div>
            `;
            notificationCount++;
        }

        // Check pH condition
        if (ph > maxPh) {
            phNotificationLink.innerHTML = `
                <div class="notification-item">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div class="small text-gray-500">
                        pH: ${ph} - pH di atas parameter. Segera Tambahkan Air
                    </div>
                </div>
            `;
            notificationCount++;
        } else if (ph < minPh) {
            phNotificationLink.innerHTML = `
                <div class="notification-item">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div class="small text-gray-500">
                        pH: ${ph} - pH di bawah parameter. Segera Tambahkan Cairan pH
                    </div>
                </div>
            `;
            notificationCount++;
        }

        // Check PPM condition
        if (ppm > maxPpm) {
            ppmNotificationLink.innerHTML = `
                <div class="notification-item">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div class="small text-gray-500">
                        PPM: ${ppm} - PPM di atas parameter. Segera lakukan penanganan
                    </div>
                </div>
            `;
            notificationCount++;
        } else if (ppm < minPpm) {
            ppmNotificationLink.innerHTML = `
                <div class="notification-item">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div class="small text-gray-500">
                        PPM: ${ppm} - PPM di bawah parameter. Segera lakukan penanganan
                    </div>
                </div>
            `;
            notificationCount++;
        }

        // Update counter
        updateCounter(notificationCount);
    }

    // Function to update counter
    function updateCounter(count) {
        var badgeCounter = document.getElementById('badgeCounter');
        if (count === 0) {
            badgeCounter.style.display = 'none';
        } else {
            badgeCounter.textContent = count;
            badgeCounter.style.display = 'block';
        }
    }

    // PHP Variables
    <?php
        $conn = mysqli_connect("127.0.0.1", "root", "", "aims");

        // Retrieve parameter data for suhu, pH, and PPM
        $suhu_parameter = mysqli_query($conn, "SELECT min_suhu, max_suhu FROM parameter_suhu");
        $ph_parameter = mysqli_query($conn, "SELECT min_ph_air, max_ph_air FROM parameter_ph_air");
        $ppm_parameter = mysqli_query($conn, "SELECT min_ppm_air, max_ppm_air FROM parameter_ppm_air");

        // Retrieve latest data for suhu, pH, and PPM
        $latest_suhu = mysqli_query($conn, "SELECT suhu FROM suhu ORDER BY id_suhu DESC LIMIT 1");
        $latest_ph = mysqli_query($conn, "SELECT ph_air FROM ph_air ORDER BY id_ph DESC LIMIT 1");
        $latest_ppm = mysqli_query($conn, "SELECT ppm_air FROM ppm_air ORDER BY id_ppm DESC LIMIT 1");
        $suhu_data = mysqli_fetch_assoc($suhu_parameter);
        $ph_data = mysqli_fetch_assoc($ph_parameter);
        $ppm_data = mysqli_fetch_assoc($ppm_parameter);
    
        // Fetch latest values
        $latest_suhu_value = mysqli_fetch_assoc($latest_suhu)['suhu'];
        $latest_ph_value = mysqli_fetch_assoc($latest_ph)['ph_air'];
        $latest_ppm_value = mysqli_fetch_assoc($latest_ppm)['ppm_air'];
    
        mysqli_close($conn);
    ?>
    var suhu = <?php echo isset($latest_suhu_value) ? $latest_suhu_value : '0'; ?>;
    var minSuhu = <?php echo isset($suhu_data['min_suhu']) ? $suhu_data['min_suhu'] : '0'; ?>;
    var maxSuhu = <?php echo isset($suhu_data['max_suhu']) ? $suhu_data['max_suhu'] : '0'; ?>;
    var ph = <?php echo isset($latest_ph_value) ? $latest_ph_value : '0'; ?>;
    var minPh = <?php echo isset($ph_data['min_ph_air']) ? $ph_data['min_ph_air'] : '0'; ?>;
    var maxPh = <?php echo isset($ph_data['max_ph_air']) ? $ph_data['max_ph_air'] : '0'; ?>;
    var ppm = <?php echo isset($latest_ppm_value) ? $latest_ppm_value : '0'; ?>;
    var minPpm = <?php echo isset($ppm_data['min_ppm_air']) ? $ppm_data['min_ppm_air'] : '0'; ?>;
    var maxPpm = <?php echo isset($ppm_data['max_ppm_air']) ? $ppm_data['max_ppm_air'] : '0'; ?>;

// Check if the values are within the normal range and call addNotification function
if ((suhu < minSuhu || suhu > maxSuhu) || (ph < minPh || ph > maxPh) || (ppm < minPpm || ppm > maxPpm)) {
    addNotification(suhu, minSuhu, maxSuhu, ph, minPh, maxPh, ppm, minPpm, maxPpm);
} else {
    // If all values are within the normal range, no need to show any notification
    var noNotificationMessage = `
        <div class="notification-item">
            <div class="small text-gray-500">
                Tidak ada notifikasi
            </div>
        </div>
    `;
    suhuNotificationLink.innerHTML = noNotificationMessage;
    phNotificationLink.innerHTML = noNotificationMessage;
    ppmNotificationLink.innerHTML = noNotificationMessage;
    updateCounter(0);
}
</script>











<!-- JavaScript untuk mengambil data notifikasi dari server dan memperbarui tampilan -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // Fungsi untuk memperbarui jumlah notifikasi dan isi notifikasi
    function updateNotifications() {
        $.ajax({
            url: '/get-notifications', // Ganti dengan URL yang sesuai untuk mengambil data notifikasi dari server
            type: 'GET',
            success: function(data) {
                // Memperbarui jumlah notifikasi
                $('#badgeCounter').text(data.notifications.length);

                // Memperbarui isi notifikasi
                var notificationContent = '';
                data.notifications.forEach(function(notification) {
                    notificationContent += `
                        <a class="dropdown-item d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">${notification.date}</div>
                                <div>${notification.message}</div>
                            </div>
                        </a>
                    `;
                });
                $('#notificationContent').html(notificationContent);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Panggil fungsi updateNotifications setiap kali dropdown notifikasi diklik
    $('#alertsDropdown').on('click', function (e) {
        e.stopPropagation();
        updateNotifications();
    });

    // Memanggil fungsi updateNotifications saat halaman dimuat
    updateNotifications();
});
</script> -->
