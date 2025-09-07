<ul class="space-y-2">
    <x-sidebar-item 
        icon="home" 
        label="Dashboard" 
        route="dashboard" 
        :active="request()->routeIs('dashboard')" />

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

    <x-sidebar-item 
        icon="calendar" 
        label="Penjadwalan" 
        route="schedule.index" 
        :active="request()->routeIs('schedule.*')" />

    <x-sidebar-item 
        icon="document" 
        label="Laporan Santri" 
        route="report.index" 
        :active="request()->routeIs('report.*')" />
</ul>
