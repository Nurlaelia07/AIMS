@extends('layouts.app')
@section('title')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <a href="{{ url('ph') }}" class="nav-link ml-3 mb-3"><i class="fas fa-chevron-left"></i></a>
        <div class="col-md-3">
            <select name="filter" id="filter" onclick="filter()" class="form-control">
                <option value="" disabled selected>Select Filter</option>
                <option value="jam">Jam</option>
                <option value="hari">Hari</option>
                <option value="bulan">Bulan</option>
            </select>
        </div>
        <div class="col-md-12 mt-3">
            <div class="table-responsive" id="riwayat">
                <table class="table">
                    <thead style="background-color: gainsboro">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>pH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function filter(){
            let filter = document.getElementById('filter').value
            let riwayat = document.getElementById('riwayat')
            if (filter == 'jam'){
                filterByJam(riwayat)
            }else if(filter == 'hari'){
                filterByHari(riwayat)
            }else{
                filterByBulan(riwayat)
            }
        }

        function filterByJam(riwayat) {
            riwayat.innerHTML = `
                <table class="table">
                    <thead style="background-color: gainsboro">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>pH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>12-04-2024</td>
                            <td>12.20 WIB</td>
                            <td>30 C</td>
                        </tr>
                    </tbody>
                </table>
            `
        }

        function filterByHari(riwayat) {
            riwayat.innerHTML = `
                <table class="table">
                    <thead style="background-color: gainsboro">
                        <tr>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>pH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Senin</td>
                            <td>12-04-2024</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>Senin</td>
                            <td>12-04-2024</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>Senin</td>
                            <td>12-04-2024</td>
                            <td>30 C</td>
                        </tr>
                    </tbody>
                </table>
            `
        }

        function filterByBulan(riwayat) {
            riwayat.innerHTML = `
                <table class="table">
                    <thead style="background-color: gainsboro">
                        <tr>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>pH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2024</td>
                            <td>Januari</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>2024</td>
                            <td>Februari</td>
                            <td>30 C</td>
                        </tr>
                        <tr>
                            <td>2024</td>
                            <td>Maret</td>
                            <td>30 C</td>
                        </tr>
                    </tbody>
                </table>
            `
        }
</script>
@endsection