<form action="{{ route('sekretaris.surat-keluar.update', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title">Edit Surat Keluar</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nomor Surat Keluar</label>
            <input type="text" name="nomor_surat_keluar" class="form-control" value="{{ $suratKeluar->nomor_surat_keluar }}" required>
        </div>
        <div class="form-group">
            <label>Tanggal Surat</label>
            <input type="date" name="tanggal_surat" class="form-control" value="{{ $suratKeluar->tanggal_surat }}" required>
        </div>
        <div class="form-group">
            <label>Tujuan</label>
            <input type="text" name="tujuan" class="form-control" value="{{ $suratKeluar->tujuan }}" required>
        </div>
        <div class="form-group">
            <label>Perihal</label>
            <textarea name="perihal" class="form-control" rows="3" required>{{ $suratKeluar->perihal }}</textarea>
        </div>
        <div class="form-group">
            <label>File Dokumen (PDF, DOC, DOCX)</label>
            <p class="text-muted">Kosongkan jika tidak ingin mengubah file.</p>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="file_dokumen" name="file_dokumen">
                <label class="custom-file-label" for="file_dokumen">Pilih file baru...</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>