<header class="admin-topbar" x-data="notifications()">
    <button class="btn btn-sm btn-link d-lg-none" @click="$dispatch('toggle-sidebar')" aria-label="Menu">☰</button>

    <form class="topbar-search" role="search" action="{{ route('admin.bookings.index') }}">
        <input type="search" name="keyword" class="form-control form-control-sm"
               placeholder="Search bookings by number, name or email" value="{{ request('keyword') }}">
    </form>

    <div class="topbar-actions">
        <a class="btn btn-sm btn-primary" href="{{ route('admin.bookings.create') }}">New booking</a>

        <div class="dropdown">
            <button class="btn btn-sm btn-light position-relative" data-bs-toggle="dropdown" @click="load()">
                Notifications
                <span class="badge rounded-pill text-bg-danger" x-show="unread" x-text="unread"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end notification-menu">
                <template x-for="item in items" :key="item.id">
                    <a class="dropdown-item" :href="item.data.url" @click="markRead(item.id)">
                        <strong x-text="item.data.title"></strong>
                        <span class="d-block small text-muted" x-text="item.data.message"></span>
                    </a>
                </template>
                <p class="dropdown-item-text small text-muted" x-show="!items.length">Nothing new.</p>
            </div>
        </div>
    </div>
</header>
