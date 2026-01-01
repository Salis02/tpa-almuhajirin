<ul class="space-y-2">
    {{-- Dashboard tetap single link --}}
    <x-sidebar-item 
        icon="home" 
        label="Dashboard" 
        route="dashboard" 
        :active="request()->routeIs('dashboard')" />

    {{-- Grup Master Data --}}
    <x-sidebar-group 
        icon="users" 
        label="Manajemen Pengguna" 
        :active="request()->routeIs(['santri.*', 'ustadz.*'])">
        
        <x-sidebar-item 
            icon="users" 
            label="Data Santri" 
            route="santri.index" 
            :active="request()->routeIs('santri.*')" />

        <x-sidebar-item 
            icon="users" 
            label="Data Ustadz" 
            route="ustadz.index" 
            :active="request()->routeIs('ustadz.*')" />
    </x-sidebar-group>

    {{-- Grup Akademik --}}
    <x-sidebar-group 
        icon="calendar" 
        label="Akademik" 
        :active="request()->routeIs(['schedule.*', 'absen.*', 'rapot.*'])">
        
        <x-sidebar-item 
            icon="calendar" 
            label="Penjadwalan" 
            route="schedule.index" 
            :active="request()->routeIs('schedule.*')" />

        <x-sidebar-item 
            icon="check-circle"
            label="Absensi Ustadzah"
            route="absen.index"
            :active="request()->routeIs('absen.*')" />
        
        <x-sidebar-item 
            icon="list"
            label="Raport Santri"
            route="rapot.index"
            :active="request()->routeIs('rapot.*')" />
    </x-sidebar-group>

    {{-- Grup Dokumen --}}
    <x-sidebar-group 
        icon="folder" 
        label="Arsip & Laporan" 
        :active="request()->routeIs(['report.*', 'document.*'])">
        
        <x-sidebar-item 
            icon="document" 
            label="Laporan Santri" 
            route="report.index" 
            :active="request()->routeIs('report.*')" />

        <x-sidebar-item 
            icon="folder" 
            label="Kelola Dokumen" 
            route="document.index" 
            :active="request()->routeIs('document.*')" />
    </x-sidebar-group>
</ul>