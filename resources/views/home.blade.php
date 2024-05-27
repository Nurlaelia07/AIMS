@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <div class="card p-4" style="background: linear-gradient(98.59deg, #46B04B 36.51%, #B1B03E 105.37%); border-radius: 25px">
                    <p class="text-white mt-3 ml-3">{{ \Carbon\Carbon::now()->format('j F, Y') }}</p>
                    <h1 class="text-white ml-3 mt-3">Hello, {{ session('username')}}</h1>
                    <p class="text-white ml-3">Welcome back to Aims</p>
                </div>
            </div>
        </div>
        <div id="display-container">
            <div class="row mt-4">
                <h3 class="mb-3">Daily Report</h3>
                <div class="col-md-4 mb-3">
                    <div class="card p-4" style="border-radius: 20px">
                        <p>Temperature</p>
                        <h1 id="suhu" class="mt-3" style="color: #FFAA00">{{ $suhu ? $suhu->suhu : 'Data tidak tersedia' }}</h1>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card p-4" style="border-radius: 20px">
                        <p>pH</p>
                        <h1 id="ph" class="mt-3" style="color: #FFAA00">{{ $ph ? $ph->ph_air : 'Data tidak tersedia' }}</h1>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card p-4" style="border-radius: 20px">
                        <p>PPM</p>
                        <h1 id="ppm" class="mt-3" style="color: #FFAA00">{{ $ppm ? $ppm->ppm_air : 'Data tidak tersedia' }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchData() {
        $.ajax({
            url: '{{ route("home") }}',
            method: 'GET',
            success: function(response) {
                console.log('Response from server:', response);
                $('#display-container').html($(response).find('#display-container').html());
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    $(document).ready(function() {
        fetchData();
        setInterval(fetchData, 2000);
    });
</script>
@endsection
