@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mb-3">
            <a href="#" class="nav-link" data-toggle="modal" data-target="#exampleModal">
                <div class="card p-4" style="border-radius: 15px">
                    <img src="{{ asset('img/icon-hasil-dan-analisis.png') }}" style="width: 70px; height: 70px;" alt="">
                    <h5 class="mt-5">Hasil dan Analisis</h5>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ url('riwayat-ph') }}" class="nav-link">
                <div class="card p-4" style="border-radius: 15px">
                    <img src="{{ asset('img/icon-riwayat.png') }}" style="width: 70px; height: 70px;" alt="">
                    <h5 class="mt-5">Riwayat</h5>
                </div>
            </a>
        </div>
    </div>

    <div class="row mt-4">
        <h4 class="mb-3">Parameter pH</h4>
        <div class="col-md-5">
         <form action="" method="post">
                @csrf
                    <input type="text" class="form-control bg-light" placeholder="Masukkan parameter batas maksimum pH Air" name="max_ph_air" id="max_ph_air" style="border-radius: 15px">
                    <input type="text" class="form-control bg-light mt-3" placeholder="Masukkan parameter batas minimum pH Air" name="min_ph_air" id="min_ph_air" style="border-radius: 15px">
                <div class="row mt-3">
                    <div class="col-md-8">
                        <div class="card">
                            <h5 class="mt-3 ms-3">Interval Parameter</h5>
                            <p id="parameter" class="ms-3"></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button id="btn-perbarui" class="btn btn-success" data-toggle="modal"
                        data-target="#updateModal">Perbarui</button>
                    </div>
                </div>
                </form>   
        </div>
    </div>
    <div class="row mt-4">
            <div class="col-md-6">
                <div class="card p-3">
                    <h5 class="text-center mb-3">Ph Terkini</h5>
                    <canvas id="barometer-ph" style="width:80%;max-width:600px;display: block;margin: 0 auto;"></canvas>
                    <h3 id="ph" class="text-center mb-3"></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3">
                    <h5 class="text-center mb-3">Data Ph 24 Jam</h5>
                    <canvas id="grafik-ph" style="width:100%;max-width:600px"></canvas>
                </div>
            </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px">
            <div class="modal-header">
                <h5 class="modal-title p-2" id="exampleModalLabel">Hasil Analisis pH</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <ul id="phMessage">
                    </ul>
            </div>
            <div class="modal-footer" style="background-color: #23AF4F; text-align: center; display: flex; justify-content: center;">
                    <button type="button" class="btn text-white" data-dismiss="modal">OK</button>
                </div>

        </div>
    </div>
</div>
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; background-color: #29CC39">
            <div class="modal-body p-4">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h1 class="text-center mt-5">
                    <i class="fas fa-check text-white text-center" style="font-size: 50px;"></i>
                </h1>
                <h3 class="text-white text-center mt-4">Success</h3>
                <p class="text-center text-white mt-3">Anda berhasil memperbarui parameter pH!</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var parameterElement = document.getElementById('parameter');
    <?php
        $conn = mysqli_connect("127.0.0.1", "root" , "", "aims"); 
        $parameter = mysqli_query($conn, "SELECT min_ph_air, max_ph_air FROM parameter_ph_air");
        $max = array();
        $min = array();
        while ($data_parameter = mysqli_fetch_array($parameter)) {
            $min[] = $data_parameter['min_ph_air'];
            $max[] = $data_parameter['max_ph_air'];
        }
    ?>
    var min = <?php echo json_encode($min); ?>[0];
    var max = <?php echo json_encode($max); ?>[0];
    var temperatureRange = min + '&nbsp; -&nbsp;' + max + '&nbsp;';

    parameterElement.innerHTML = temperatureRange;
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var maxPhInput = document.getElementById('max_ph_air');
        var minPhInput = document.getElementById('min_ph_air');
        var perbaruiButton = document.getElementById('btn-perbarui');
    
        function checkInputs() {
            var maxPhValue = maxPhInput.value.trim();
            var minPhValue = minPhInput.value.trim();
        
            if (maxPhValue !== '' || minPhValue !== '') {
                perbaruiButton.disabled = false;
            } else {
                perbaruiButton.disabled = true;
            }
        }
        perbaruiButton.disabled = true;

        maxPhInput.addEventListener('input', checkInputs);
        minPhInput.addEventListener('input', checkInputs);
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modalBody = document.getElementById('phMessage');
    <?php
    $conn = mysqli_connect("127.0.0.1", "root", "", "aims");
    $parameter = mysqli_query($conn, "SELECT min_ph_air, max_ph_air FROM parameter_ph_air");
    $parameterData = mysqli_fetch_assoc($parameter); // Mengambil satu baris data

    // Periksa apakah data berhasil diambil
    if ($parameterData) {
        $min_ph = $parameterData['min_ph_air'];
        $max_ph = $parameterData['max_ph_air'];

        // Query data ph
        $phnotif = mysqli_query($conn, "SELECT waktu, ph_air FROM ph_air ORDER BY id_ph ASC");
        $phData = mysqli_fetch_all($phnotif, MYSQLI_ASSOC);

        // Inisialisasi pesan dan saran
        $pesan_max_ph = '';
        $pesan_min_ph = '';
        $saran_max_ph = '';
        $saran_min_ph = '';
        $hours_max_ph = array();
        $hours_min_ph = array();

        // Looping data ph untuk analisis
        foreach ($phData as $data) {
            $hour = date('H', strtotime($data['waktu'])); // Ambil jam dari timestamp
            $ph = $data['ph_air'];

            // Analisis ph
            if ($ph > $max_ph) {
                if (!isset($hours_max_ph[$hour])) {
                    $hours_max_ph[$hour] = 0;
                }
                $hours_max_ph[$hour]++;
            } elseif ($ph < $min_ph) {
                if (!isset($hours_min_ph[$hour])) {
                    $hours_min_ph[$hour] = 0;
                }
                $hours_min_ph[$hour]++;
            }
        }

        // Fungsi untuk membuat interval waktu dari array
        function create_intervals($hours) {
            sort($hours); // Pastikan array jam diurutkan
            $intervals = [];
            $current_interval = [];

            foreach ($hours as $index => $hour) {
                if (empty($current_interval)) {
                    $current_interval[] = $hour;
                } elseif ($hour - end($current_interval) === 1) {
                    // Jika jam saat ini berurutan dengan jam terakhir di interval, tambahkan ke interval
                    $current_interval[] = $hour;
                } else {
                    // Periksa apakah panjang interval saat ini antara 2 dan 4
                    $interval_length = count($current_interval);
                    if ($interval_length >= 2 && $interval_length <= 4) {
                        $intervals[] = $current_interval[0] . ".00-" . end($current_interval) . ".00";
                    } else {
                        // Jika panjang interval tidak dalam rentang, tambahkan jam individu
                        foreach ($current_interval as $ci) {
                            $intervals[] = $ci . ".00";
                        }
                    }
                    $current_interval = [$hour];
                }
            }

            // Tambahkan interval terakhir atau jam individu
            $interval_length = count($current_interval);
            if ($interval_length >= 2 && $interval_length <= 4) {
                $intervals[] = $current_interval[0] . ".00-" . end($current_interval) . ".00";
            } else {
                foreach ($current_interval as $ci) {
                    $intervals[] = $ci . ".00";
                }
            }

            return $intervals;
        }

        // Sort the hours by frequency and then by the hour
        asort($hours_max_ph);
        asort($hours_min_ph);

        // Get the most frequent hours
        $most_frequent_max_ph = array_keys($hours_max_ph);
        $most_frequent_min_ph = array_keys($hours_min_ph);

        // Create intervals
        $interval_waktu_max_ph = create_intervals($most_frequent_max_ph);
        $interval_waktu_min_ph = create_intervals($most_frequent_min_ph);

        // Buat pesan berdasarkan interval waktu
        if (!empty($interval_waktu_max_ph)) {
            $pesan_max_ph = "Berdasarkan data pada jam " . implode(", ", $interval_waktu_max_ph) . " pH berada di atas ambang batas.";
            $saran_max_ph = "Tambahkan air pada jam " . implode(", ", $interval_waktu_max_ph) . ".";
        } else {
            $pesan_max_ph = "Tidak ada data pH yang berada di atas ambang batas.";
            $saran_max_ph = "Tidak ada saran tambahan untuk pH di atas ambang batas.";
        }

        if (!empty($interval_waktu_min_ph)) {
            $pesan_min_ph = "Berdasarkan data pada jam " . implode(", ", $interval_waktu_min_ph) . " pH berada di bawah ambang batas.";
            $saran_min_ph = "Tambahkan Cairan pH pada jam " . implode(", ", $interval_waktu_min_ph) . ".";
        } else {
            $pesan_min_ph = "Tidak ada data pH yang berada di bawah ambang batas.";
            $saran_min_ph = "Tidak ada saran tambahan untuk pH di bawah ambang batas.";
        }
    }

    mysqli_close($conn);
    ?>

    var pesanMaxPhPHP = "<?php echo $pesan_max_ph; ?>"; // Ambil pesan untuk pH di atas ambang batas dari PHP
    var pesanMinPhPHP = "<?php echo $pesan_min_ph; ?>"; // Ambil pesan untuk pH di bawah ambang batas dari PHP
    var saranMaxPhPHP = "<?php echo $saran_max_ph; ?>"; // Ambil saran untuk pH di atas ambang batas dari PHP
    var saranMinPhPHP = "<?php echo $saran_min_ph; ?>"; // Ambil saran untuk pH di bawah ambang batas dari PHP

    // Menampilkan pesan dan saran
    modalBody.innerHTML += '<li>' + pesanMaxPhPHP + '</li>';
    modalBody.innerHTML += '<li>' + pesanMinPhPHP + '</li>';
    modalBody.innerHTML += '<h5 style="margin-top: 40px;">Saran</h5>';
    modalBody.innerHTML += '<li>' + saranMaxPhPHP + '</li>';
    modalBody.innerHTML += '<li>' + saranMinPhPHP + '</li>';
});
</script>




<script src="https://bernii.github.io/gauge.js/dist/gauge.min.js"></script>
<script>
    var opts = {
        angle: -0.2,
        lineWidth: 0.2,
        radiusScale: 1,
        pointer: {
            length: 0.6,
            strokeWidth: 0.024,
            color: '#000000'
        },
        limitMax: false,
        limitMin: false,
        colorStart: '#F7C35F',
        colorStop: '#F7C35F',
        strokeColor: '#EEEEEE',
        generateGradient: true,
        highDpiSupport: true,
    };

    var target = document.getElementById('barometer-ph');
    var gauge = new Gauge(target).setOptions(opts);
    
    // Initialize with default values
    gauge.maxValue = 14; // pH scale max value
    gauge.setMinValue(0); // pH scale min value
    gauge.animationSpeed = 32;

    function updateGauge(ph, maxPh, minPh) {
        gauge.maxValue = maxPh;
        gauge.setMinValue(minPh);

        if (ph > maxPh) { // If pH exceeds the parameter, set the max pointer value to pH
            gauge.maxValue = ph;
        }

        gauge.set(ph); 
    }

    function fetchLatestPh() {
        fetch('/parameter-ph')
            .then(response => response.json())
            .then(data => {
                const ph = <?php echo $latestPh->ph_air; ?>; // Get the pH value from the JSON response
                const maxPh = data.max_ph_air; // Get the max pH value from the JSON response
                const minPh = data.min_ph_air; // Get the min pH value from the JSON response
                updateGauge(ph, maxPh, minPh); // Update the gauge with pH, max pH, and min pH values
            })
            .catch(error => console.error('Error fetching latest pH:', error));
    }

    // Call fetchLatestPh() to initialize the gauge when the page loads
    fetchLatestPh();

    // Use setInterval to update the gauge periodically
    setInterval(fetchLatestPh, 10000);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function updatePhDisplay(ph) {
        $('#ph').text(ph); 
    }
    updatePhDisplay(<?php echo $latestPh->ph_air; ?>);

    function fetchLatestPh() {
        $.ajax({
            url: '/ph', 
            method: 'GET',
            success: function(response) {
                const ph = response.ph;
                updatePhDisplay(ph);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching latest pH:', error);
            }
        });
    }

    setInterval(fetchLatestPh, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
        var ctx = document.getElementById('grafik-ph').getContext('2d');
        var labels = [];
        var phData = [];

        <?php
        $conn = mysqli_connect("127.0.0.1", "root", "", "aims"); 
        $ph = mysqli_query($conn, "SELECT waktu, ph_air FROM ph_air WHERE waktu >= NOW() - INTERVAL 1 DAY ORDER BY waktu ASC");
        while ($data_ph = mysqli_fetch_array($ph)) {
            echo "labels.push('".$data_ph['waktu']."');";
            echo "phData.push(".$data_ph['ph_air'].");";
        }
           
        ?>

        var data = {
            labels: labels,
            datasets: [{
                label: 'Grafik ph 24 Jam',
                data: phData,
                fill: false,
                borderColor: '#F7C35F',
                tension: 0.1
            }]
        };

        var config = {
            type: 'line',
            data: data,
        };

        var myChart = new Chart(ctx, config);

        function fetchData() {
            $.ajax({
                url: 'getph.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var newLabels = [];
                    var newPhData = [];

                    response.forEach(function(item) {
                        newLabels.push(item.waktu);
                        newPhData.push(item.ph);
                    });

                    myChart.data.labels = newLabels;
                    myChart.data.datasets[0].data = newPhData;
                    myChart.update();
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        setInterval(fetchData, 10000); 
    </script>


@endsection