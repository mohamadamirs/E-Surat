{{-- File ini hanya berisi konten form untuk dimuat ke dalam modal --}}
<div class="card card-warning card-outline mb-0">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-edit mr-2"></i> Edit Data: {{ $user->name }}
        </h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="card-body">
            {{-- Input Nama --}}
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Input Email --}}
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Pilihan Role (Dropdown) --}}
            <div class="form-group">
                <label for="role">Peran (Role)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    </div>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror"
                        required>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                        </option>
                        <option value="kepala" {{ old('role', $user->role) == 'kepala' ? 'selected' : '' }}>kepala
                        </option>
                        <option value="sekretaris" {{ old('role', $user->role) == 'sekretaris' ? 'selected' : '' }}>
                            Sekretaris</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                    </div>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- INI KODE YANG BENAR --}}
            <div class="form-group">
                <label for="mobile_code">Nomer Hp</label>
                {{-- Input yang terlihat oleh pengguna. Perhatikan tidak ada atribut 'name'. --}}
                <input type="tel" id="mobile_code" class="form-control @error('nomer_hp') is-invalid @enderror"
                    value="{{ old('nomer_hp', $user->nomer_hp) }}" required>

                {{-- Input tersembunyi inilah yang akan dikirim ke Laravel --}}
                <input type="hidden" id="nomer_hp" name="nomer_hp">

                {{-- Tampilkan error di bawah input yang terlihat --}}
                @error('nomer_hp')
                    <div class="invalid-feedback d-block">{{-- d-block agar muncul --}}
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <hr>
            <p class="text-muted">Kosongkan bagian password jika tidak ingin mengubahnya.</p>

            {{-- Input Password (Opsional) --}}
            <div class="form-group">
                <label for="password">Password Baru</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        id="password" placeholder="Masukkan password baru">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Input Konfirmasi Password --}}
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                        placeholder="Ulangi password baru">
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
