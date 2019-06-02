@if (session("impersonator"))
    <form action="{{ route('impersonatees.destroy', auth()->user()->id) }}"
        method="POST"
        ref="impersonateeForm"
    >
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <h3
            @click="$refs.impersonateeForm.submit()"
            class="cursor-pointer flex items-center font-normal dim text-white mb-6 text-base no-underline"
        >
                <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="var(--sidebar-icon)" d="M17.56 17.66a8 8 0 0 1-11.32 0L1.3 12.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95zm-9.9-1.42a6 6 0 0 0 8.48 0L20.38 12l-4.24-4.24a6 6 0 0 0-8.48 0L3.4 12l4.25 4.24zM11.9 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
                <span class="sidebar-label">
                    Stop Impersonating
                </span>
            </a>
        </h3>
    </form>
@elseif (auth()->user()->hasRole("Admin") || auth()->user()->hasRole("SuperAdmin"))
    <router-link tag="h3" :to="{name: 'laravel-impersonator'}" class="cursor-pointer flex items-center font-normal dim text-white mb-6 text-base no-underline">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="var(--sidebar-icon)" d="M17.56 17.66a8 8 0 0 1-11.32 0L1.3 12.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95zm-9.9-1.42a6 6 0 0 0 8.48 0L20.38 12l-4.24-4.24a6 6 0 0 0-8.48 0L3.4 12l4.25 4.24zM11.9 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
        <span class="sidebar-label">
            Impersonate Users
        </span>
    </router-link>
@endif
