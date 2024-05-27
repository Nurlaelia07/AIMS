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
                <a href="{{ url('riwayat-ppm') }}" class="nav-link">
                    <div class="card p-4" style="border-radius: 15px">
                        <img src="{{ asset('img/icon-riwayat.png') }}" style="width: 70px; height: 70px;" alt="">
                        <h5 class="mt-5">Riwayat</h5>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mt-4">
            <h4 class="mb-3">Parameter PPM Air</h4>
            <div class="col-md-5">
                <form action="" method="post">
                    @csrf
                    <input type="text" class="form-control bg-light" placeholder="Masukkan parameter batas maksimum ppm Air" name="max_ppm_air" id="max_ppm_air" style="border-radius: 15px">
                    <input type="text" class="form-control bg-light mt-3" placeholder="Masukkan parameter batas minimum ppm Air" name="min_ppm_air" id="min_ppm_air" style="border-radius: 15px">
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="card">
                                <h5 class="mt-3 ms-3">Parameter</h5>
                                <p id="parameter" class="ms-3"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button id="btn-perbarui" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card p-3">
                    <h5 class="text-center mb-3">PPM Terkini</h5>
                    <canvas id="barometer-ppm" style="width:80%;max-width:600px;display: block;margin: 0 auto;"></canvas>
                    <h3 id="ppm" class="text-center mb-3"></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3">
                    <h5 class="text-center mb-3">Data PPM 24 Jam</h5>
                    <canvas id="grafik-ppm" style="width:100%;max-width:600px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hasil Analisis PPM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <ul id="ppmMessage">
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
                <p class="text-center text-white mt-3">Anda berhasil memperbarui parameter PPM air!</p>
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
        $parameter = mysqli_query($conn, "SELECT min_ppm_air, max_ppm_air FROM parameter_ppm_air");
        $max = array();
        $min = array();
        while ($data_parameter = mysqli_fetch_array($parameter)) {
            $min[] = $data_parameter['min_ppm_air'];
            $max[] = $data_parameter['max_ppm_air'];
        }
    ?>
    var min = <?php echo json_encode($min); ?>[0];
    var max = <?php echo json_encode($max); ?>[0];
    var temperatureRange = min + '&nbsp; -&nbsp;' + max + '&nbsp;';

    parameterElement.innerHTML = temperatureRange;
</script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var maxPpmInput = document.getElementById('max_ppm_air');
        var minPpmInput = document.getElementById('min_ppm_air');
        var perbaruiButton = document.getElementById('btn-perbarui');
    
        function checkInputs() {
            var maxPpmValue = maxPpmInput.value.trim();
            var minPpmValue = minPpmInput.value.trim();
        
            if (maxPpmValue !== '' || minPpmValue !== '') {
                perbaruiButton.disabled = false;
            } else {
                perbaruiButton.disabled = true;
            }
        }
        perbaruiButton.disabled = true;

        maxPpmInput.addEventListener('input', checkInputs);
        minPpmInput.addEventListener('input', checkInputs);
    });
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modalBody = document.getElementById('ppmMessage');
    <?php
    $conn = mysqli_connect("127.0.0.1", "root", "", "aims");
    $parameter = mysqli_query($conn, "SELECT min_ppm_air, max_ppm_air FROM parameter_ppm_air");
    $parameterData = mysqli_fetch_assoc($parameter); // Mengambil satu baris data

    // Periksa apakah data berhasil diambil
    if ($parameterData) {
        $min_ppm = $parameterData['min_ppm_air'];
        $max_ppm = $parameterData['max_ppm_air'];

        // Query data ppm
        $ppmnotif = mysqli_query($conn, "SELECT waktu, ppm_air FROM ppm_air ORDER BY id_ppm ASC");
        $ppmData = mysqli_fetch_all($ppmnotif, MYSQLI_ASSOC);

        // Inisialisasi pesan dan saran
        $pesan_max_ppm = '';
        $pesan_min_ppm = '';
        $saran_max_ppm = '';
        $saran_min_ppm = '';
        $hours_max_ppm = array();
        $hours_min_ppm = array();

        // Looping data ppm untuk analisis
        foreach ($ppmData as $data) {
            $hour = date('H', strtotime($data['waktu'])); // Ambil jam dari timestamp
            $ppm = $data['ppm_air'];

            // Analisis ppm
            if ($ppm > $max_ppm) {
                if (!isset($hours_max_ppm[$hour])) {
                    $hours_max_ppm[$hour] = 0;
                }
                $hours_max_ppm[$hour]++;
            } elseif ($ppm < $min_ppm) {
                if (!isset($hours_min_ppm[$hour])) {
                    $hours_min_ppm[$hour] = 0;
                }
                $hours_min_ppm[$hour]++;
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
        asort($hours_max_ppm);
        asort($hours_min_ppm);

        // Get the most frequent hours
        $most_frequent_max_ppm = array_keys($hours_max_ppm);
        $most_frequent_min_ppm = array_keys($hours_min_ppm);

        // Create intervals
        $interval_waktu_max_ppm = create_intervals($most_frequent_max_ppm);
        $interval_waktu_min_ppm = create_intervals($most_frequent_min_ppm);

        // Buat pesan berdasarkan interval waktu
        if (!empty($interval_waktu_max_ppm)) {
            $pesan_max_ppm = "Berdasarkan data pada jam " . implode(", ", $interval_waktu_max_ppm) . " PPM berada di atas ambang batas.";
            $saran_max_ppm = "Tambahkan air dengan PPM rendah pada jam " . implode(", ", $interval_waktu_max_ppm) . ".";
        } else {
            $pesan_max_ppm = "Tidak ada data PPM yang berada di atas ambang batas.";
            $saran_max_ppm = "Tidak ada saran tambahan untuk PPM di atas ambang batas.";
        }

        if (!empty($interval_waktu_min_ppm)) {
            $pesan_min_ppm = "Berdasarkan data pada jam " . implode(", ", $interval_waktu_min_ppm) . " PPM berada di bawah ambang batas.";
            $saran_min_ppm = "Tambahkan air dengan PPM tinggi pada jam " . implode(", ", $interval_waktu_min_ppm) . ".";
        } else {
            $pesan_min_ppm = "Tidak ada data PPM yang berada di bawah ambang batas.";
            $saran_min_ppm = "Tidak ada saran tambahan untuk PPM di bawah ambang batas.";
        }
    }

    mysqli_close($conn);
    ?>

    var pesanMaxPpmPHP = "<?php echo $pesan_max_ppm; ?>"; // Ambil pesan untuk PPM di atas ambang batas dari PHP
    var pesanMinPpmPHP = "<?php echo $pesan_min_ppm; ?>"; // Ambil pesan untuk PPM di bawah ambang batas dari PHP
    var saranMaxPpmPHP = "<?php echo $saran_max_ppm; ?>"; // Ambil saran untuk PPM di atas ambang batas dari PHP
    var saranMinPpmPHP = "<?php echo $saran_min_ppm; ?>"; // Ambil saran untuk PPM di bawah ambang batas dari PHP

    // Menampilkan pesan dan saran
    modalBody.innerHTML += '<li>' + pesanMaxPpmPHP + '</li>';
    modalBody.innerHTML += '<li>' + pesanMinPpmPHP + '</li>';
    modalBody.innerHTML += '<h5 style="margin-top: 40px;">Saran</h5>';
    modalBody.innerHTML += '<li>' + saranMaxPpmPHP + '</li>';
    modalBody.innerHTML += '<li>' + saranMinPpmPHP + '</li>';
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

    var target = document.getElementById('barometer-ppm');
    var gauge = new Gauge(target).setOptions(opts);
    
    // Initialize with default values
    gauge.maxValue = 100;
    gauge.setMinValue(0);
    gauge.animationSpeed = 32;

    function updateGauge(ppm, maxPpm, minPpm) {
        gauge.maxValue = maxPpm;
        gauge.setMinValue(minPpm);

        if (ppm > maxPpm) { // Jika ppm melebihi parameter, tetapkan nilai maksimum pointer ke nilai ppm
            gauge.maxValue = ppm;
        }

        gauge.set(ppm); 
    }

    function fetchLatestPpm() {
        fetch('/parameter-ppm')
            .then(response => response.json())
            .then(data => {
                const ppm = <?php echo $latestPpm->ppm_air; ?>; // Mengambil nilai ppm dari respons JSON ppm
                const maxPpm = data.max_ppm_air; // Mengambil nilai max ppm dari respons JSON parameter
                const minPpm = data.min_ppm_air; // Mengambil nilai min ppm dari respons JSON parameter
                updateGauge(ppm, maxPpm, minPpm); // Mengupdate gauge dengan nilai ppm, max ppm, dan min ppm
            })
            .catch(error => console.error('Error fetching latest ppm:', error));
    }

    // Panggil fetchLatestPpm() untuk menginisialisasi gauge saat halaman dimuat
    fetchLatestPpm();

    // Gunakan setInterval untuk memperbarui gauge secara berkala
    setInterval(fetchLatestPpm, 5000);
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function updatePpmDisplay(ppm) {
        $('#ppm').text(ppm); 
    }
    updatePpmDisplay(<?php echo $latestPpm->ppm_air; ?>);

    function fetchLatestPpm() {
        $.ajax({
            url: '/ppm', 
            method: 'GET',
            success: function(response) {
                const ppm = response.ppm;
                updatePpmDisplay(ppm);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching latest ppm:', error);
            }
        });
    }

    setInterval(fetchLatestPpm, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var ctx = document.getElementById('grafik-ppm').getContext('2d');
    var labels = [];
    var ppmData = [];

    <?php
        $conn = mysqli_connect("127.0.0.1", "root", "", "aims"); 
        $ppm = mysqli_query($conn, "SELECT waktu, ppm_air FROM ppm_air WHERE waktu >= NOW() - INTERVAL 1 DAY ORDER BY waktu ASC");
        while ($data_ppm = mysqli_fetch_array($ppm)) {
            echo "labels.push('".$data_ppm['waktu']."');";
            echo "ppmData.push(".$data_ppm['ppm_air'].");";
        }
    ?>

    var data = {
        labels: labels,
        datasets: [{
            label: 'Grafik PPM 24 Jam',
            data: ppmData,
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
            url: 'getppm.php',
            method: 'GET',
            success: function(response) {
                var newLabels = [];
                var newPpmData = [];

                response.forEach(function(item) {
                    newLabels.push(item.waktu);
                    newPpmData.push(item.ppm_air);
                });

                myChart.data.labels = newLabels;
                myChart.data.datasets[0].data = newPpmData;
                myChart.update();
            }
        });
    }

    setInterval(fetchData, 2000); 
</script>




@endsection