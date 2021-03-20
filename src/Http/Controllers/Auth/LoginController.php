<?php

namespace AporteWeb\Dashboard\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/adm/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = '/adm/home'; //config('adashboard.prefix', 'adm');
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated($request, $user)
    {
        /*if ($user->enabled_at == null) {
            $this->guard()->logout();
            $request->session()->invalidate();
            return back()->withErrors(['El usuario no ha sido activado']);
        }*/

        /*$car = json_decode(Cookie::get('MY-CAR'), true);
        if ($car) {
            if (count($car) > 0) {
                return redirect()->route('website.car');
            }
        }*/
        if ($request->ajax()) {
            return response()->json([
                'user' => [
                    'id'   => $user->id,
                    'uuid' => $user->uuid
                ],
                'status' => 'success'
                // 'target'  => route('client.home')
            ]);
        }
        // return redirect()->route('client.home');
    }
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('Dashboard::auth.login');
    }
    public function username()
    {
        return 'username';
    }
    public function logout(Request $request)
    {
        $this->performLogout($request);
        return $request->wantsJson()
            ? new Response('', 204)
            : redirect()->route('login');
    }
}
