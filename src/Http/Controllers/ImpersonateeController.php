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

    public function destroy() : RedirectResponse
    {
        /** This need to be comment **/
        //$this->authorize('impersonation', auth()->user());

        $impersonator = session('impersonator');
        if(!empty($impersonator)){
            $originalSession = session('impersonator-session-data');
            session()->flush();
            session($originalSession);
            auth()->login($impersonator);
            $msg = 'Impersonation Session end successfully.';
            // Message is optional and have to be implemented in layout first
            return back()->with('success',$msg); //using back instead of /
        }
        else{
            $msg =  'No impersonation session located.';
            return back()->with('error',$msg);  //using back instead of /
        }
    }
}
