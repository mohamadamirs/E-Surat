<form action="{{ route('sekretaris.surat-masuk.update', $suratMasuk->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Edit Surat Masuk</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nomor Surat</label>
            <input type="text" name="nomor_surat" class="form-control" value="{{ $suratMasuk->nomor_surat }}"
                required>
        </div>
        <div class="form-group">
            <label>Tanggal Diterima</label>
            <input type="date" name="tanggal_diterima" class="form-control"
                value="{{ $suratMasuk->tanggal_diterima }}" required>
        </div>
        <div class="form-group">
            <label>Pengirim</label>
            <input type="text" name="pengirim" class="form-control" value="{{ $suratMasuk->pengirim }}" required>
        </div>
        <div class="form-group">
            <label>Perihal</label>
            <textarea name="perihal" class="form-control" rows="3" required>{{ $suratMasuk->perihal }}</textarea>
        </div>
        {{-- VERSI BARU --}}
        <div class="form-group">
            <label>File Dokumen (PDF, DOC, DOCX)</label>

            {{-- 1. Tambahkan teks petunjuk untuk pengguna --}}
            <p class="text-muted small">Kosongkan jika tidak ingin mengubah file dokumen.</p>

            <div class="custom-file">
                {{-- 2. Hapus atribut 'required' dari input file --}}
                <input type="file" class="custom-file-input" id="file_dokumen_edit" name="file_dokumen">
                <label class="custom-file-label" for="file_dokumen_edit">Pilih file baru...</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>
