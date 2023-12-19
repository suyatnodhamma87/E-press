<!-- App Bottom Menu -->
<div class="appBottomMenu">
        <a href="/home" class="item {{ request()-> is('home') ? 'active' : ''}}">
            <div class="col">
                <ion-icon name="home-outline" class="text-light"></ion-icon>
                <strong class="text-light">Home</strong>
            </div>
        </a>
        <a href="/presensi/history" class="item {{ request()-> is('presensi/history') ? 'active' : ''}}">
            <div class="col">
                <ion-icon class="text-light" name="timer-outline"></ion-icon>
                <strong class="text-light">History</strong>
            </div>
        </a>
        <a href="/presensi/create" class="item">
            <div class="col">
                <div class="action-button large">
                    {{-- <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon> --}}
                    <ion-icon  name="finger-print-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                </div>
            </div>
        </a>
        <a href="/presensi/ijin" class="item {{ request()-> is('presensi/ijin') ? 'active' : ''}}">
            <div class="col">
                <ion-icon name="mail-unread-outline" class="text-light"></ion-icon>
                <strong class="text-light">Ijin</strong>
            </div>
        </a>
        <a href="/editprofile" class="item {{ request()-> is('presensi/editprofile') ? 'active' : ''}}">
            <div class="col">
                <ion-icon class="text-light" name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                <strong class="text-light">Profile</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->
