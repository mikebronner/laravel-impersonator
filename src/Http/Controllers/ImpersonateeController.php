<?php namespace GeneaLabs\LaravelImpersonator\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use GeneaLabs\LaravelImpersonator\Impersonator;

class ImpersonateeController extends Controller
{
    private $userClass;

    public function __construct()
    {
        $this->userClass = config('genealabs-laravel-impersonator.user-model');
    }

    public function index() : View
    {
        $this->authorize('impersonation', new Impersonator);

        $users = (new $this->userClass)->orderBy(config('genealabs-laravel-impersonator.orderby-field-name'))
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
        $this->authorize('impersonation', new Impersonator);

        $impersonator = auth()->user();
        $oldSession = session()->all();
        session()->flush();
        auth()->login($impersonatee);
        session([
            'impersonator' => $impersonator,
            'impersonator-session-data' => $oldSession,
        ]);

        return redirect('/');
    }

    public function destroy() : Response
    {
        $impersonator = session('impersonator');
        $this->authorizeForUser($impersonator, 'impersonation', new Impersonator);
        $originalSession = session('impersonator-session-data');
        session()->flush();
        session($originalSession);
        auth()->login($impersonator);

        if (request()->ajax()) {
            return response(null, 204);
        }

        return redirect('/');
    }
}
