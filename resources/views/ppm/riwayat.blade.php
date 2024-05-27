@extends('layouts.app')
@section('title')
@endsection
@section('content')
<div class="container">
    <div class="row">
    <a href="{{ url('ppm') }}" class="nav-link ml-3 mb-3"><i class="fas fa-chevron-left"></i></a>
            <div class="col-md-3">
            <form action="{{ route('ppm.riwayat') }}" method="GET">
                <select name="filter" id="filter" onchange="filterPpm()" class="form-control">
                    <option value="" disabled selected>Pilih Filter</option>
                    <option value="no">No Filter</option>
                    <option value="jam">Jam</option>
                    <option value="hari">Hari</option>
                    <option value="bulan">Bulan</option>
                </select>
            </form>
            </div>
            <div class="col-md-12 mt-3">
                <div class="table-responsive" id="riwayat">
                    <table class="table">
                        <thead style="background-color: gainsboro">
                        <tr>
                        @if($filter === 'jam')
                            <th>Tanggal</th>
                            <th>Jam</th>
                        @elseif($filter === 'hari')
                            <th>Hari</th>
                            <th>Tanggal</th>
                        @elseif($filter === 'bulan')
                            <th>Bulan</th>
                            <th>Tahun</th>
                        @else
                            <th>Tanggal</th>
                            <th>Waktu</th>
                        @endif
                        <th>Ppm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatPpm as $data)
                        <tr>
                            @if($filter === 'jam')
                                <td>{{ $data->tanggal }}</td>
                                <td>{{ $data->jam }}</td>
                            @elseif($filter === 'hari')
                                <td>{{ __('day.' . strtolower($data->hari)) }}</td>
                                <td>{{ $data->tanggal }}</td>
                            @elseif($filter === 'bulan')
                                <td>{{ $data->bulan }}</td>
                                <td>{{ $data->tahun }}</td>
                            @else
                                <td>{{ $data->tanggal }}</td>
                                <td>{{ $data->waktu }}</td>
                            @endif
                            <td>{{ $data->ppm_air }}</td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if ($riwayatPpm->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $riwayatPpm->previousPageUrl() }}"
                                        tabindex="-1">Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @for ($i = max(1, $riwayatPpm->currentPage() - 3); $i <= min($riwayatPpm->lastPage(), $riwayatPpm->currentPage() + 3); $i++)
                                @if (is_string($i))
                                    <li class="page-item disabled">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item {{ $riwayatPpm->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $riwayatPpm->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($riwayatPpm->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $riwayatPpm->nextPageUrl() }}">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function filterPpm() {
        let filter = document.getElementById('filter').value;
        let url = '/riwayat-ppm';
        if (filter !== '') {
            url += '?filter=' + filter;
        }
        window.location.href = url;
    }
</script>
@endsection
