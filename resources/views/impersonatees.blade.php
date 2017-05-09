@extends(config('genealabs-laravel-impersonator.layout'))

@section(config('genealabs-laravel-impersonator.content-section'))
    <div class="container">

        @if((auth()->user()->canImpersonate ?? false) && ! session('impersonator'))
            <div class="list-group">

                @foreach($users as $user)
                    @form(['route' => ['impersonatees.update', $user], 'method' => 'PUT', 'class' => 'list-group-item'])
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-lg fa-btn fa-user-secret"></i>
                        </button>
                        {{ $user->name }}
                    @endform
                @endforeach

            </div>
        @else
            <div class="alert alert-danger">
                <p>
                    <i class="fa fa-btn fa-warning"></i>
                    You are already impersonating someone. Please end this
                    impersonation session before trying to impersonate someone else.
                </p>
            </div>
        @endif

    </div>
@endsection
