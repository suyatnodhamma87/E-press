      <!-- Sidebar -->
      <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark">
            <a href=".">
              <img src="{{ asset('tabler/static/nalanda.png') }}" width="220" height="50" alt="Tabler" class="">
            </a>
          </h1>
          <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="#" class="dropdown-item">Status</a>
                <a href="./profile.html" class="dropdown-item">Profile</a>
                <a href="#" class="dropdown-item">Feedback</a>
                <div class="dropdown-divider"></div>
                <a href="./settings.html" class="dropdown-item">Settings</a>
                <a href="./sign-in.html" class="dropdown-item">Logout</a>
              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
              <li class="nav-item">
                <a class="nav-link" href="/panel/homeadmin" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                  </span>
                  <span class="nav-link-title">
                    Home
                  </span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is(['karyawan', 'divisi', 'anakperusahaan', 'cuti']) ? 'show' : '' }}"
                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button"
                    aria-expanded="{{ request()->is(['karyawan', 'divisi', 'anakperusahaan', 'cuti']) ? 'true' : '' }}">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /><path d="M16 5.25l-8 4.5" /></svg>
                  </span>
                  <span class="nav-link-title">
                    Data Master
                  </span>
                </a>
                <div class="dropdown-menu {{ request()->is(['karyawan', 'divisi', 'anakperusahaan', 'cuti']) ? 'show' : '' }}">
                  <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                      @role('administrator|admin divisi', 'user')
                      <a class="dropdown-item {{ request()->is(['karyawan']) ? 'active' : '' }}" href="/karyawan">
                        Karyawan
                      </a>
                      @endrole
                      @role('administrator', 'user')
                      <a class="dropdown-item {{ request()->is(['divisi']) ? 'active' : '' }}" href="/divisi">
                        Divisi
                      </a>
                      <a class="dropdown-item {{ request()->is(['anakperusahaan']) ? 'active' : '' }}" href="/anakperusahaan">
                        Mode Lokasi Kerja
                      </a>
                      <a class="dropdown-item {{ request()->is(['cuti']) ? 'active' : '' }}" href="/cuti">
                        Cuti
                      </a>
                      @endrole
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/presensi/livereport" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" /><path d="M18 14v4h4" />
                        <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" />
                        <path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M8 11h4" />
                        <path d="M8 15h3" /></svg>
                  </span>
                  <span class="nav-link-title">
                    Live Report
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->is(['presensi/perijinankaryawan']) ? 'show' : '' }}" href="/presensi/perijinankaryawan" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-chart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                        <path d="M12 10v4h4" />
                        <path d="M12 14m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    </svg>
                  </span>
                  <span class="nav-link-title">
                    Data Ijin / Sakit
                  </span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is(['presensi/laporanpresensi','presensi/laporanpresensiall']) ? 'show' : '' }}" href="#navbar-base"
                    data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ request()->is(['presensi/laporanpresensi','presensi/laporanpresensiall']) ? 'true' : '' }}">
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    </svg>
                  </span>
                  <span class="nav-link-title">
                    Laporan Presensi
                  </span>
                </a>
                <div class="dropdown-menu {{ request()->is(['presensi/laporanpresensi','presensi/laporanpresensiall']) ? 'show' : '' }}">
                  <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                      <a class="dropdown-item {{ request()->is(['presensi/laporanpresensi']) ? 'active' : '' }}" href="/presensi/laporanpresensi">
                        Individu
                      </a>
                      <a class="dropdown-item {{ request()->is(['presensi/laporanpresensiall']) ? 'active' : '' }}" href="/presensi/laporanpresensiall">
                        Semua Karyawan
                      </a>
                    </div>
                  </div>
                </div>
              </li>
              @role('administrator', 'user')
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is(['setting/lokasikantor']) ? 'show' : '' }}" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    </svg>
                  </span>
                  <span class="nav-link-title">
                    Setting
                  </span>
                </a>
                <div class="dropdown-menu  {{ request()->is(['setting', 'setting/*']) ? 'show' : '' }}">
                  <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                      {{-- <a class="dropdown-item {{ request()->is(['setting/lokasikantor']) ? 'active' : '' }}" href="/setting/lokasikantor">
                        Lokasi kantor
                      </a> --}}
                      <a class="dropdown-item {{ request()->is(['setting/jamkerja']) ? 'active' : '' }}" href="/setting/jamkerja">
                        Jam Kerja
                      </a>
                      <a class="dropdown-item {{ request()->is(['setting/jamkerja_divisi']) ? 'active' : '' }}" href="/setting/jamkerjadiv">
                        Jam Kerja Divisi
                      </a>
                      <a class="dropdown-item {{ request()->is(['setting/users']) ? 'active' : '' }}" href="/setting/users">
                        Users
                      </a>
                    </div>
                  </div>
                </div>
              </li>
              @endrole
            </ul>
          </div>
        </div>
      </aside>
