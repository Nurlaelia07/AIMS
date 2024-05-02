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
                    <canvas id="barometer-suhu" style="width:60%;max-width:600px;display: block;margin: 0 auto;"></canvas>
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
                    <li>Berdasarkan data pada pukul 07.00 hingga 17.00 suhu berada di bawah ambang batas.
                    </li>
                    <li>Berdasarkan data pada pukul 17.00 hingga 03.00 suhu berada di ambang normal.</li>
                </div>
                <div class="modal-footer" style="background-color: #23AF4F; text-align: center;">
                    <button type="button" style="align-items: center; text-align: center; align-content: center"
                        class="btn text-white" data-dismiss="modal">OK</button>
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
                updateSuhuDisplay(suhu);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching latest suhu:', error);
            }
        });
    }

    // setInterval(fetchLatestSuhu, 5000);
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('grafik-suhu');
    var labels = [];
    var suhuData = [];
    <?php
        $conn = mysqli_connect("127.0.0.1", "root" , "", "aims"); 
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
