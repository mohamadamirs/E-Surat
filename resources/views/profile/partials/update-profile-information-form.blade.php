{{-- ====================================================================== --}}
{{--      PARTIAL UNTUK FORM EDIT INFORMASI PROFIL (UNTUK MODAL AJAX)      --}}
{{-- ====================================================================== --}}
<form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('patch')

    {{-- Header Modal --}}
    <div class="modal-header">
        <h5 class="modal-title">Edit Informasi Profil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>

    {{-- Body Modal (berisi semua input form) --}}
    <div class="modal-body">

        {{-- Foto Profil Saat Ini --}}
        <div class="form-group text-center mb-4">
            <label>Foto Profil Saat Ini</label><br>
            @if (Auth::user()->profile_photo_path)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto Profil"
                    class="rounded-circle img-fluid" style="width:120px; height:120px; object-fit:cover;">
            @else
                <img src="{{ asset('images/profile.svg') }}" alt="Default Foto Profil" class="rounded-circle img-fluid"
                    style="width: 150px !important; height: 150px !important; object-fit: cover !important; border-radius: 50% !important;">
            @endif
        </div>
        <hr>

        {{-- Input Foto Profil Baru --}}
        <div class="form-group">
            <label for="profile_photo">Ganti Foto Profil (Opsional)</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input @error('profile_photo') is-invalid @enderror"
                    id="profile_photo" name="profile_photo">
                <label class="custom-file-label" for="profile_photo">Pilih file gambar...</label>
            </div>
            @error('profile_photo')
                <span class="text-danger d-block mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Input Nama --}}
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Email --}}
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}"
                required autocomplete="email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Footer Modal (berisi tombol aksi) --}}
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
    </div>
</form>
