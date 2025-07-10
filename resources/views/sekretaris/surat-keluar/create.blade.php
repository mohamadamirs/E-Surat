<form action="{{ route('sekretaris.surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Tambah Surat Keluar Baru</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nomor Surat Keluar</label>
            <input type="text" name="nomor_surat_keluar" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Surat</label>
            <input type="date" name="tanggal_surat" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tujuan</label>
            <input type="text" name="tujuan" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Perihal</label>
            <textarea name="perihal" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label>File Dokumen (PDF, DOC, DOCX)</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="file_dokumen" name="file_dokumen" required>
                <label class="custom-file-label" for="file_dokumen">Pilih file...</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>