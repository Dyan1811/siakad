<nav class="navbar navbar-dark bg-success sticky-top shadow-sm">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-lg-none me-2" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">
                <i class="bi bi-mortarboard-fill me-1"></i>
                {{ config('app.name') }}
            </a>
        </div>

        <!-- Sisi Kanan Navbar: Tombol Tema & Dropdown Admin -->
        <div class="d-flex align-items-center">
            <!-- Tombol Ganti Tema (Terang / Gelap) -->
            <button id="btnThemeToggle" class="btn btn-outline-light me-2" type="button" title="Ganti Tema">
                <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
            </button>

            <!-- Dropdown Akun -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                    <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <span class="dropdown-item-text small">
                            {{ Auth::user()->email }}
                            <span class="badge text-bg-secondary ms-1">{{ Auth::user()->role }}</span>
                        </span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-1"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const themeToggleBtn = document.getElementById('btnThemeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const htmlElement = document.documentElement; // Elemen <html>

        // 1. Baca tema yang tersimpan di localStorage (bawaan: light)
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-bs-theme', savedTheme);

        // 2. Adjust ikon tombol berdasarkan tema saat halaman dibuka
        if (savedTheme === 'dark' && themeIcon) {
            themeIcon.className = 'bi bi-sun-fill';
        }

        // 3. Listener event saat tombol diklik
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function () {
                const currentTheme = htmlElement.getAttribute('data-bs-theme') || 'light';
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                // Mengubah atribut data-bs-theme pada elemen <html>
                htmlElement.setAttribute('data-bs-theme', newTheme);

                // Menyimpan pilihan ke localStorage agar tidak hilang saat pindah halaman
                localStorage.setItem('theme', newTheme);

                // Mengubah ikon tombol (Bintang/Bulan untuk Light, Matahari untuk Dark)
                if (themeIcon) {
                    themeIcon.className = newTheme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
                }
            });
        }
    });
</script>
@endpush