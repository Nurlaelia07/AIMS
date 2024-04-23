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
        <h4 class="mb-3">Parameter PPM</h4>
        <div class="col-md-5">
            <form action="">
                <input type="number" class="form-control bg-light" placeholder="Masukkan parameter atas"
                    style="border-radius: 15px">
                <input type="number" class="form-control bg-light mt-3" placeholder="Masukkan parameter bawah"
                    style="border-radius: 15px">
            </form>
            <div class="row mt-3">
                <div class="col-md-8">
                    <div class="card">
                        <h5 class="mt-3 ms-3">Parameter</h5>
                        <p class="ms-3">30 C - 40 C</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success form-control" data-toggle="modal"
                        data-target="#updateModal">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5 class="text-center mb-3">Data PPM Terkini</h5>
                <canvas id="grafik-suhu-terkini" style="width:100%;max-width:600px"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h5 class="text-center mb-3">Data PPM 24 Jam</h5>
                <canvas id="grafikSuhu24jam" style="width:100%;max-width:600px"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px">
            <div class="modal-header">
                <h5 class="modal-title p-2 id=" exampleModalLabel">Hasil Analisis PPM</h5>
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
                <p class="text-center text-white mt-3">Anda berhasil memperbarui parameter PPM!</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const xValues = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];

        new Chart("grafik-suhu-terkini", {
            type: "line",
            data: {
                labels: xValues,
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
</script>
<script>
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
</script>
@endsection