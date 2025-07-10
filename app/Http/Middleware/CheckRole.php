<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class CheckRole
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @param  string  ...$roles   <-- Parameter untuk menampung semua role yang diizinkan
         * @return mixed
         */
        public function handle(Request $request, Closure $next, ...$roles)
        {
            // 1. Periksa apakah user sudah login
            if (!Auth::check()) {
                // Jika belum, arahkan ke halaman login
                return redirect('login');
            }

            // 2. Dapatkan data user yang sedang login
            $user = Auth::user();

            // 3. Periksa apakah peran user ada di dalam daftar $roles yang diizinkan
            foreach ($roles as $role) {
                if ($user->role == $role) {
                    // Jika peran cocok, lanjutkan permintaan ke controller
                    return $next($request);
                }
            }

            // 4. Jika setelah dicek tidak ada peran yang cocok, tolak akses.
            // abort(403) akan menampilkan halaman error "403 Forbidden"
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }
