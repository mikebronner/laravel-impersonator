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

        return view('genealabs-laravel-impersonator::impersonatees')->with([
            'users' => (new $this->userClass)->orderBy('name')->get(),
        ]);
    }

    public function update($impersonatee) : RedirectResponse
    {
        $this->authorize('impersonation', auth()->user());

        session(['impersonator' => auth()->user()]);
        auth()->login($impersonatee);

        return redirect('/');
    }

    public function destroy() : RedirectResponse
    {
        $this->authorize('impersonation', auth()->user());

        auth()->login(session('impersonator'));
        session(['impersonator' => null]);

        return redirect('/');
    }
}
