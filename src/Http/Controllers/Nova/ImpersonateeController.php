<?php namespace GeneaLabs\LaravelImpersonator\Http\Controllers\Nova;

use GeneaLabs\LaravelImpersonator\Impersonator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use GeneaLabs\LaravelImpersonator\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ImpersonateeController extends Controller
{
    private $userClass;

    public function __construct()
    {
        $this->userClass = config('genealabs-laravel-impersonator.user-model');
    }

    public function index() : Collection
    {
        // $this->authorize('impersonation', new Impersonator);

        return (new $this->userClass)->orderBy('name')
            ->get()
            ->filter(function ($user) {
                return $user->canBeImpersonated;
            });
    }

    public function update($impersonatee) : Response
    {
        // $this->authorize('impersonation', new Impersonator);
\Log::debug([auth()->user()]);
        $impersonator = auth()->user();
        $oldSession = session()->all();
        session()->flush();
        auth()->login($impersonatee);
        session([
            'impersonator' => $impersonator,
            'impersonator-session-data' => $oldSession,
        ]);

        return response(null, 204);
    }

    public function destroy() : Response
    {
        $impersonator = session('impersonator');
        $this->authorizeForUser($impersonator, 'impersonation', new Impersonator);
        $originalSession = session('impersonator-session-data');
        session()->flush();
        session($originalSession);
        auth()->login($impersonator);

        return redirect(config("nova.path"));
    }
}
