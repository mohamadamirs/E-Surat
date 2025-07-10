<form action="{{ route('sekretaris.surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Tambah Surat Masuk Baru</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nomor Surat</label>
            <input type="text" name="nomor_surat" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Diterima</label>
            <input type="date" name="tanggal_diterima" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Pengirim</label>
            <input type="text" name="pengirim" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Perihal</label>
            <textarea name="perihal" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label>File Dokumen (PDF, DOC, DOCX)</label>
            {{-- Bungkus input dan label di dalam div.custom-file --}}
            <div class="custom-file">
                {{-- Beri class 'custom-file-input' pada input --}}
                <input type="file" class="custom-file-input" id="file_dokumen_create" name="file_dokumen" required>
                {{-- Beri class 'custom-file-label' pada label dan sesuaikan atribut 'for' --}}
                <label class="custom-file-label" for="file_dokumen_create">Pilih file...</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
