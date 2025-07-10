{{-- FORM UNTUK UPDATE PASSWORD --}}
<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    {{-- Header Modal --}}
    <div class="modal-header">
        <h5 class="modal-title">Ubah Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>

    {{-- Body Modal (berisi semua input form) --}}
    <div class="modal-body">
        
        {{-- Password Saat Ini --}}
        <div class="form-group">
            <label for="update_password_current_password">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password" required>
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password Baru --}}
        <div class="form-group">
            <label for="update_password_password">Password Baru</label>
            <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password" required>
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        {{-- Konfirmasi Password Baru --}}
        <div class="form-group">
            <label for="update_password_password_confirmation">Konfirmasi Password Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" required>
        </div>
    </div>

    {{-- Footer Modal (berisi tombol aksi) --}}
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Password</button>
    </div>
</form>