@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3">
                <a href="#" class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <div class="card p-4" style="border-radius: 15px">
                        <img src="{{ asset('img/icon-hasil-dan-analisis.png') }}" style="width: 70px; height: 70px;"
                            alt="">
                        <h5 class="mt-5">Hasil dan Analisis</h5>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-3">
                <a href="{{ url('riwayat-suhu') }}" class="nav-link">
                    <div class="card p-4" style="border-radius: 15px">
                        <img src="{{ asset('img/icon-riwayat.png') }}" style="width: 70px; height: 70px;" alt="">
                        <h5 class="mt-5">Riwayat</h5>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mt-4">
            <h4 class="mb-3">Parameter Suhu</h4>
            <div class="col-md-5">
                <form action="" method="post">
                @csrf
                    <input type="text" class="form-control bg-light" placeholder="Masukkan parameter atas" name="max_suhu" id="max_suhu" style="border-radius: 15px">
                    <input type="text" class="form-control bg-light mt-3" placeholder="Masukkan parameter bawah" name="min_suhu" id="min_suhu" style="border-radius: 15px">
                <div class="row mt-3">
                    <div class="col-md-8">
                        <div class="card">
                            <h5 class="mt-3 ms-3">Parameter</h5>
                            <p id="parameter" class="ms-3"></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button id="btn-perbarui" class="btn btn-success" data-toggle="modal"
                        data-target="#updateModal">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card p-3">
                    <h5 class="text-center mb-3">Suhu Terkini</h5>
                    <canvas id="barometer-suhu" style="width:80%;max-width:600px;display: block;margin: 0 auto;"></canvas>
                    <h3 id="suhu" class="text-center mb-3"></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3">
                    <h5 class="text-center mb-3">Data Suhu 24 Jam</h5>
                    <canvas id="grafik-suhu" style="width:100%;max-width:600px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px">
                <div class="modal-header">
                    <h5 class="modal-title p-2 id="exampleModalLabel">Hasil Analisis Suhu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <ul id="suhuMessage">
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
                <p class="text-center text-white mt-3">Anda berhasil memperbarui parameter suhu!</p>
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
            $parameter = mysqli_query($conn, "SELECT min_suhu, max_suhu FROM parameter_suhu");
            $max = array();
            $min = array();
            while ($data_parameter = mysqli_fetch_array($parameter)) {
                $min[] = $data_parameter['min_suhu'];
                $max[] = $data_parameter['max_suhu'];
            }
        ?>
        var minTemperature = <?php echo json_encode($min); ?>[0];
        var maxTemperature = <?php echo json_encode($max); ?>[0];
        var temperatureRange = minTemperature + '&nbsp;<sup>o</sup>C -&nbsp;' + maxTemperature + '&nbsp;<sup>o</sup>C';

        parameterElement.innerHTML = temperatureRange;
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var maxSuhuInput = document.getElementById('max_suhu');
    var minSuhuInput = document.getElementById('min_suhu');
    var perbaruiButton = document.getElementById('btn-perbarui');

    function checkInputs() {
        var maxSuhuValue = maxSuhuInput.value.trim();
        var minSuhuValue = minSuhuInput.value.trim();

        if (maxSuhuValue !== '' || minSuhuValue !== '') {
            perbaruiButton.disabled = false;
        } else {
            perbaruiButton.disabled = true;
        }
    }
    perbaruiButton.disabled = true;
 
    maxSuhuInput.addEventListener('input', checkInputs);
    minSuhuInput.addEventListener('input', checkInputs);



});
</script>




<script>
document.addEventListener('DOMContentLoaded', function() {
    var modalBody = document.getElementById('suhuMessage');
    <?php
    $conn = mysqli_connect("127.0.0.1", "root", "", "aims");
    $parameter = mysqli_query($conn, "SELECT min_suhu, max_suhu FROM parameter_suhu");
    $parameterData = mysqli_fetch_assoc($parameter); // Mengambil satu baris data

    // Periksa apakah data berhasil diambil
    if ($parameterData) {
        $min_suhu = $parameterData['min_suhu'];
        $max_suhu = $parameterData['max_suhu'];

        // Query data suhu
        $suhunotif = mysqli_query($conn, "SELECT waktu, suhu FROM suhu ORDER BY id_suhu ASC");
        $suhuData = mysqli_fetch_all($suhunotif, MYSQLI_ASSOC);

        // Inisialisasi pesan dan saran
        $pesan_max_suhu = '';
        $pesan_min_suhu = '';
        $saran_max_suhu = '';
        $saran_min_suhu = '';
        $hours_max_suhu = array();
        $hours_min_suhu = array();

        // Looping data suhu untuk analisis
        foreach ($suhuData as $data) {
            $hour = date('H', strtotime($data['waktu'])); // Ambil jam dari timestamp
            $suhu = $data['suhu'];

            // Analisis suhu
            if ($suhu > $max_suhu) {
                if (!isset($hours_max_suhu[$hour])) {
                    $hours_max_suhu[$hour] = 0;
                }
                $hours_max_suhu[$hour]++;
            } elseif ($suhu < $min_suhu) {
                if (!isset($hours_min_suhu[$hour])) {
                    $hours_min_suhu[$hour] = 0;
                }
                $hours_min_suhu[$hour]++;
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
        asort($hours_max_suhu);
        asort($hours_min_suhu);

        // Get the most frequent hours
        $most_frequent_max_suhu = array_keys($hours_max_suhu);
        $most_frequent_min_suhu = array_keys($hours_min_suhu);

        // Create intervals
        $interval_waktu_max_suhu = create_intervals($most_frequent_max_suhu);
        $interval_waktu_min_suhu = create_intervals($most_frequent_min_suhu);

        // Buat pesan berdasarkan interval waktu
        if (!empty($interval_waktu_max_suhu)) {
            $pesan_max_suhu = "Berdasarkan data pada jam " . implode(", ", $interval_waktu_max_suhu) . " suhu berada di atas ambang batas.";
            $saran_max_suhu = "Tambahkan air dingin pada jam " . implode(", ", $interval_waktu_max_suhu) . ".";
        } else {
            $pesan_max_suhu = "Tidak ada data suhu yang berada di atas ambang batas.";
            $saran_max_suhu = "Tidak ada saran tambahan untuk suhu di atas ambang batas.";
        }

        if (!empty($interval_waktu_min_suhu)) {
            $pesan_min_suhu = "Berdasarkan data pada jam " . implode(", ", $interval_waktu_min_suhu) . " suhu berada di bawah ambang batas.";
            $saran_min_suhu = "Tambahkan air hangat pada jam " . implode(", ", $interval_waktu_min_suhu) . ".";
        } else {
            $pesan_min_suhu = "Tidak ada data suhu yang berada di bawah ambang batas.";
            $saran_min_suhu = "Tidak ada saran tambahan untuk suhu di bawah ambang batas.";
        }
    }

    mysqli_close($conn);
    ?>

    var pesanMaxSuhuPHP = "<?php echo $pesan_max_suhu; ?>"; // Ambil pesan untuk suhu di atas ambang batas dari PHP
    var pesanMinSuhuPHP = "<?php echo $pesan_min_suhu; ?>"; // Ambil pesan untuk suhu di bawah ambang batas dari PHP
    var saranMaxSuhuPHP = "<?php echo $saran_max_suhu; ?>"; // Ambil saran untuk suhu di atas ambang batas dari PHP
    var saranMinSuhuPHP = "<?php echo $saran_min_suhu; ?>"; // Ambil saran untuk suhu di bawah ambang batas dari PHP

    // Menampilkan pesan dan saran
    modalBody.innerHTML += '<li>' + pesanMaxSuhuPHP + '</li>';
    modalBody.innerHTML += '<li>' + pesanMinSuhuPHP + '</li>';
    modalBody.innerHTML += '<h5 style="margin-top: 40px;">Saran</h5>';
    modalBody.innerHTML += '<li>' + saranMaxSuhuPHP + '</li>';
    modalBody.innerHTML += '<li>' + saranMinSuhuPHP + '</li>';
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

    var target = document.getElementById('barometer-suhu');
    var gauge = new Gauge(target).setOptions(opts);
    gauge.maxValue = 100;
    gauge.setMinValue(0);
    gauge.animationSpeed = 32;

    
    var suhu = <?php echo $latestSuhu->suhu; ?>;
    gauge.set(suhu);

    function updateGauge(suhu) {
        gauge.set(suhu); 
    }


    function fetchLatestSuhu() {
        $.ajax({
            url: '/suhu',
            method: 'GET',
            success: function(response) {
                var suhu = response.suhu; 
                updateGauge(suhu); 
            },
            error: function(xhr, status, error) {
                console.error('Error fetching latest suhu:', error);
            }
        });
    }

    // setInterval(fetchLatestSuhu, 5000);
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function updateSuhuDisplay(suhu) {
        $('#suhu').text(suhu + ' °C'); 
    }
    updateSuhuDisplay(<?php echo $latestSuhu->suhu; ?>);

    function fetchLatestSuhu() {
        $.ajax({
            url: '/suhu', 
            method: 'GET',
            success: function(response) {
                var suhu = response.suhu;
                updateSuhuDisplay(<?php echo $latestSuhu->suhu; ?>);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching latest suhu:', error);
            }
        });
    }

    setInterval(fetchLatestSuhu, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var ctx = document.getElementById('grafik-suhu').getContext('2d');
    var labels = [];
    var suhuData = [];

    <?php
        $conn = mysqli_connect("127.0.0.1", "root", "", "aims"); 
        $suhu = mysqli_query($conn, "SELECT waktu, suhu FROM suhu WHERE waktu >= NOW() - INTERVAL 1 DAY ORDER BY waktu ASC");
        while ($data_suhu = mysqli_fetch_array($suhu)) {
            echo "labels.push('".$data_suhu['waktu']."');";
            echo "suhuData.push(".$data_suhu['suhu'].");";
        }
    ?>

    var data = {
        labels: labels,
        datasets: [{
            label: 'Grafik Suhu 24 Jam',
            data: suhuData,
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
            url: 'getsuhu.php',
            method: 'GET',
            success: function(response) {
                var newLabels = [];
                var newSuhuData = [];

                response.forEach(function(item) {
                    newLabels.push(item.waktu);
                    newSuhuData.push(item.suhu);
                });

                myChart.data.labels = newLabels;
                myChart.data.datasets[0].data = newSuhuData;
                myChart.update();
            }
        });
    }

   
    setInterval(fetchData, 2000); 
</script>

    <!-- <script>
        const yValues = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];

        new Chart("grafikSuhu24jam", {
            type: "line",
            data: {
                labels: yValues,
                datasets: [{
                    data: [2000, 3000, 2000, 4000, 2000, 3000, 4000, 7000, 3000, 2500, 2800],
                    borderColor: "red",
                    backgroundColor: 'rgba(255, 0, 0, 0.1)',
                    fill: true,
                    borderWidth: 1
                }, {
                    data: [1000, 1700, 1500, 1400, 1600, 1800, 1600, 1300, 1800, 1700, 1400],
                    borderColor: "green",
                    backgroundColor: 'rgba(0, 255, 0, 0.1)',
                    fill: true,
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                }
            }
        });
    </script> -->
@endsection
