<?php namespace GeneaLabs\LaravelImpersonator\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ImpersonateeController extends Controller
{
    private $userClass;

    public function __construct()
    {
        $this->userClass = config('genealabs-laravel-impersonator.user-model');
    }

    public function index() : View
    {
        $this->authorize('impersonation', auth()->user());
        $users = (new $this->userClass)->orderBy('name')
            ->get()
            ->filter(function ($user) {
                return $user->canBeImpersonated;
            });

        return view('genealabs-laravel-impersonator::impersonatees')->with([
            'users' => $users,
        ]);
    }

    public function update($impersonatee) : RedirectResponse
    {
        $this->authorize('impersonation', auth()->user());

        $oldSession = session()->all();
        session()->flush();

        auth()->login($impersonatee);
        session([
            'impersonator' => auth()->user(),
            'impersonator-session-data' => $oldSession,
        ]);

        return redirect('/');
    }

    public function destroy() : RedirectResponse
    {
        $this->authorize('impersonation', auth()->user());

        $impersonator = session('impersonator');
        $originalSession = session('impersonator-session-data');
        session()->flush();
        session($originalSession);
        auth()->login($impersonator);

        return redirect('/');
    }
}
