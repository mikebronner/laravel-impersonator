@if(session('impersonator'))
    <a href="{{ url('/logout') }}"
        onclick="event.preventDefault(); document.getElementById('end-personation-session-form').submit();"
    >
        End Impersonation Session
    </a>
@else
    <a href="{{ route('logout') }}"
        onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
        Logout
    </a>
@endif

@form([
    'route' => ['impersonatees.destroy', auth()->user()],
    'method' => 'DELETE',
    'style' => 'display: none;',
    'id' => 'end-personation-session-form'
])
@endform

@form([
    'route' => 'logout',
    'style' => 'display: none;',
    'id' => 'logout-form'
])
@endform
