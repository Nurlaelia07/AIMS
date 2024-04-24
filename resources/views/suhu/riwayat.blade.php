@extends('layouts.app')
@section('title')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <a href="{{ url('suhu') }}" class="nav-link ml-3 mb-3"><i class="fas fa-chevron-left"></i></a>
            <div class="col-md-3">
            <form action="{{ route('suhu.riwayat') }}" method="GET">
                <select name="filter" id="filter" onchange="filterSuhu()" class="form-control">
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
                        <th>Suhu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatSuhu as $data)
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
                            <td>{{ $data->suhu }}</td>
                        </tr>
                    @endforeach
                </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if ($riwayatSuhu->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $riwayatSuhu->previousPageUrl() }}"
                                        tabindex="-1">Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @for ($i = max(1, $riwayatSuhu->currentPage() - 3); $i <= min($riwayatSuhu->lastPage(), $riwayatSuhu->currentPage() + 3); $i++)
                                @if (is_string($i))
                                    <li class="page-item disabled">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item {{ $riwayatSuhu->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $riwayatSuhu->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($riwayatSuhu->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $riwayatSuhu->nextPageUrl() }}">Next</a>
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
    function filterSuhu() {
        let filter = document.getElementById('filter').value;
        let url = '/riwayat-suhu';
        if (filter !== '') {
            url += '?filter=' + filter;
        }
        window.location.href = url;
    }
</script>
@endsection
