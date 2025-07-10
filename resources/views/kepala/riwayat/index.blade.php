@extends('layouts.app')
@section('title', 'Riwayat Validasi')
@section('page-title', 'Riwayat Validasi Disposisi')

{{-- Menambahkan Stylesheet untuk DataTables --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Disposisi yang Telah Anda Proses</h3>
        {{-- [PERUBAHAN] Menambahkan tombol Aksi Massal --}}
        <div class="card-tools">
            <button type="button" class="btn btn-danger btn-sm" id="btn-delete-selected" disabled>
                <i class="fas fa-trash-alt"></i> Hapus Terpilih
            </button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        {{-- [PERUBAHAN] Bungkus tabel dengan form untuk aksi massal --}}
        <form id="bulk-delete-form" action="{{ route('kepala.riwayat.bulkDelete') }}" method="POST">
            @csrf
            @method('DELETE')
            
            <table id="main-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10px;">
                            {{-- Checkbox untuk "Pilih Semua" --}}
                            <input type="checkbox" id="select-all-checkbox">
                        </th>
                        <th>No. Surat Masuk</th>
                        <th>Perihal Surat</th>
                        <th class="text-center">Status Keputusan</th>
                        <th>Tanggal Keputusan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($historyList as $item)
                    <tr>
                        <td class="text-center">
                            {{-- Checkbox untuk setiap baris --}}
                            <input type="checkbox" class="row-checkbox" name="ids[]" value="{{ $item->id }}">
                        </td>
                        <td>{{ $item->suratMasuk->nomor_surat }}</td>
                        <td>{{ $item->suratMasuk->perihal }}</td>
                        <td class="text-center">
                            @if($item->status_validasi == 'Disetujui') <span class="badge badge-success">Disetujui</span>
                            @elseif($item->status_validasi == 'Ditolak') <span class="badge badge-danger">Ditolak</span>
                            @elseif($item->status_validasi == 'Revisi') <span class="badge badge-info">Revisi</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_validasi)->format('d M Y H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ route('kepala.validasi.show', $item->id_surat_masuk) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Anda belum memiliki riwayat validasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
    </div>
</div>
@endsection

{{-- Menambahkan Scripts --}}
@push('scripts')
    {{-- Semua library yang dibutuhkan --}}
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            var table = $('#main-table').DataTable({
                "responsive": true, "lengthChange": true, "autoWidth": false,
                "order": [[ 4, "desc" ]],
                // [PERUBAHAN] Matikan pengurutan untuk kolom checkbox
                "columnDefs": [ { "orderable": false, "targets": 0 } ]
            });

            // Logika untuk checkbox "Pilih Semua"
            $('#select-all-checkbox').on('click', function(){
                var rows = table.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
                toggleDeleteButton();
            });

            // Logika saat checkbox per baris diubah
            $('#main-table tbody').on('change', 'input[type="checkbox"]', function(){
                if(!this.checked){
                    var el = $('#select-all-checkbox').get(0);
                    if(el && el.checked && ('indeterminate' in el)){
                        el.indeterminate = true;
                    }
                }
                toggleDeleteButton();
            });

            // Fungsi untuk mengaktifkan/menonaktifkan tombol hapus
            function toggleDeleteButton() {
                var checkedCount = $('.row-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#btn-delete-selected').prop('disabled', false);
                } else {
                    $('#btn-delete-selected').prop('disabled', true);
                }
            }

            // Aksi saat tombol "Hapus Terpilih" diklik
            $('#btn-delete-selected').on('click', function() {
                var form = $('#bulk-delete-form');
                var checkedCount = $('.row-checkbox:checked').length;
                
                // Tampilkan konfirmasi SweetAlert
                Swal.fire({
                    title: `Yakin ingin menghapus ${checkedCount} data?`,
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, submit form
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush