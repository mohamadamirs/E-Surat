{{-- <form action="{{ route('admin.disposisi.store', $suratMasuk->id) }}" method="POST"> --}}
    {{-- @csrf --}}
    {{-- <div class="modal-header">
        <h5 class="modal-title">Buat Disposisi</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
    </div> --}}
    {{-- <div class="modal-body"> --}}
        {{-- Menampilkan info surat yang akan didisposisi --}}
        {{-- <div class="alert alert-light">
            <strong>Surat Dari:</strong> {{ $suratMasuk->pengirim }}<br>
            <strong>Perihal:</strong> {{ $suratMasuk->perihal }}
        </div>
         --}}
        {{-- <div class="form-group">
            <label for="catatan">Catatan / Instruksi Disposisi</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="5" placeholder="Tuliskan catatan atau instruksi untuk Pimpinan di sini..." required></textarea>
        </div>
        
        <div class="form-group">
            <label for="id_kepala">Teruskan Kepada (Kepala)</label>
            <select name="id_kepala" id="id_kepala" class="form-control" required>
                <option value="">-- Pilih Pimpinan --</option>
                @php
                    $kepalas = \App\Models\User::where('role', 'kepala')->get();
                @endphp
                @foreach ($kepalas as $kepala)
                    <option value="{{ $kepala->id }}">{{ $kepala->name }}</option>
                @endforeach
            </select>
        </div> 
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan dan Teruskan Disposisi</button>
    </div>
</form> --}}