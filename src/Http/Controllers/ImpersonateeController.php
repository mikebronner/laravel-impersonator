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

        // Allow us to customise the middleware being used for each route.
        foreach (config('genealabs-laravel-impersonator.middleware', ['web', 'auth']) as $middleware => $config) {
            if (is_int($middleware)) {
                $middleware = $config;
            }

            $middleware = $this->middleware($middleware);

            if ($config['only'] ?? false) {
                $middleware->only($config['only']);
            }
            if ($config['except'] ?? false) {
                $middleware->except($config['except']);
            }
        }
    }

    public function index() : View
    {
        $this->authorize('impersonation', new Impersonator);

        $users = (new $this->userClass)->orderBy(config('genealabs-laravel-impersonator.orderby-column'))
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
