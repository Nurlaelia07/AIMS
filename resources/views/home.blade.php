@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <div class="card p-4" style="background: linear-gradient(98.59deg, #46B04B 36.51%, #B1B03E 105.37%); border-radius: 25px">
                    <p class="text-white mt-3 ml-3">5 April, 2024</p>
                    <h1 class="text-white ml-3 mt-3">Hello, Gilang</h1>
                    <p class="text-white ml-3">Welcome back to Aims</p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <h3 class="mb-3">Daily Report</h3>
            <div class="col-md-4 mb-3" >
                <div class="card p-4" style="border-radius: 20px">
                    <p>Temperature</p>
                    <h1 id="suhu" class="mt-3" style="color: #FFAA00"></h1>
                </div>
            </div>
            <div class="col-md-4 mb-3" >
                <div class="card p-4" style="border-radius: 20px">
                    <p>pH</p>
                    <h1 id="ph" class="mt-3" style="color: #FFAA00"></h1>
                </div>
            </div>
            <div class="col-md-4 mb-3" >
                <div class="card p-4" style="border-radius: 20px">
                    <p>PPM</p>
                    <h1 class="mt-3" style="color: #FFAA00">20</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function updateSuhuDisplay(suhu) {
        $('#suhu').text(suhu); 
    }


    function updatePHDisplay(ph) {
        $('#ph').text(ph); 
    }
    updateSuhuDisplay(<?php echo $suhu->suhu; ?>);
    updatePHDisplay(<?php echo $ph->ph_air; ?>);

    function fetchLatestSuhu() {
        $.ajax({
            url: '/', 
            method: 'GET',
            success: function(response) {
                const suhu = response.suhu; 
                updateSuhuDisplay(suhu); 
            },
            error: function(xhr, status, error) {
                console.error('Error fetching latest suhu:', error);
            }
        });
    }

 
    function fetchLatestPH() {
        $.ajax({
            url: '/', 
            method: 'GET',
            success: function(response) {
                const ph = response.ph;
                updatePHDisplay(ph);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching latest pH:', error); 
            }
        });
    }

    

    // setInterval(fetchLatestSuhu, 5000);
    // setInterval(fetchLatestPH, 5000);
</script>
@endsection
