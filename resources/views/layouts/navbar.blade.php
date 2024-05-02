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
            <a  class="nav-link dropdown-toggle" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i  class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span id="badgeCounter" class="badge badge-danger badge-counter"></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header" style="background-color: #23AF4F; border: none">
                    Notifications
                </h6>
                <a id="notificationLink" class="dropdown-item d-flex align-items-center" href="#">
                </a>
        <a class="dropdown-item text-center small text-gray-500">Mark all as read</a>
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
                {{-- <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div> --}}
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
    
    function addNotification(date, suhu, minSuhu, maxSuhu) {
        var dropdownMenu = document.getElementById('alertsDropdown');
        var notificationLink = document.getElementById('notificationLink');

    
        var message = '';
        if (suhu > maxSuhu) {
            message = 'Suhu diatas parameter. Segera tambahkan air dingin dan dinginkan instalasi';
        } else if (suhu < minSuhu) {
            message = 'Suhu dibawah parameter. Segera tambahkan air hangat dan hangatkan instalasi';
        }
        
    
        if (message !== '') {
            var notificationContent = `
                <div class="mr-3">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500"></div>
                    Suhu: ${suhu}°C - ${message}
                </div>
            `;
            
        } else {
            
        }

       
        notificationLink.innerHTML = notificationContent;

        updateCounter();
    }

    function updateCounter() {
        var badgeCounter = document.getElementById('badgeCounter');
        var notificationCount = document.querySelectorAll('#notificationLink').length;

        // Periksa jumlah notifikasi
        if (notificationCount > 0) {
            badgeCounter.textContent = notificationCount;
            badgeCounter.style.display = 'block';
        } else {
            badgeCounter.style.display = 'none';
        }
    }

    
    <?php
            $conn = mysqli_connect("127.0.0.1", "root" , "", "aims");
            $parameter = mysqli_query($conn, "SELECT min_suhu, max_suhu FROM parameter_suhu");
            $parameterData = [];
            while ($data_parameter = mysqli_fetch_assoc($parameter)) {
                $parameterData[] = $data_parameter;
            }
            $suhunotif = mysqli_query($conn, "SELECT suhu FROM suhu ORDER BY id_suhu DESC LIMIT 1");
            $suhuData = mysqli_fetch_assoc($suhunotif);
            mysqli_close($conn);
        ?>
    var suhu = <?php echo $suhuData['suhu']; ?>;
    var minSuhu = <?php echo $parameterData[0]['min_suhu']; ?>;
    var maxSuhu = <?php echo $parameterData[0]['max_suhu']; ?>;
    addNotification(suhu, minSuhu, maxSuhu);
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
