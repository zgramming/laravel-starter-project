<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UserTrait;
use Auth;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    use UserTrait;

    public function index(): Factory|View|Application
    {
        $keys = [];
        return view("modules.login",$keys);
    }

    /**
     * @return Redirector|RedirectResponse|Application
     */
    public function login(): Redirector|RedirectResponse|Application
    {

        try {
            $post = request()->all();

            $rules = [
                'email'=> ['required','email'],
                'password'=> ['required'],
            ];

            $validator = Validator::make($post, $rules);
            if ($validator->fails()) return back()->withErrors($validator->messages())->withInput();

            $data = [
                'email'=> $post['email'],
                'password'=> $post['password'],
            ];

            if(!Auth::attempt($data)) throw new Exception("Email atau Password yang dimasukkan tidak valid",404);

            $user = User::with(['userGroup'])->where("email","=",$post['email'])->first();
            $access = $this->checkAccessModulAndMenu($user?->userGroup?->id);
            if(empty($access)) throw new Exception("Account dengan email $user->email belum mempunyai access, silahkan hubungi admin",404);

            $initialRoute = $access->first()->menus->first()->route;

            request()->session()->regenerate();
            return redirect($initialRoute);
        }catch (QueryException $e) {
            $message = $e->getMessage();
            $code = $e->getCode() ?: 500;

            return back()->withErrors($message)->withInput();
        }  catch (Throwable $e){
            $message = $e->getMessage();
            $code = $e->getCode() ?: 500;

            return back()->withErrors($message)->withInput();
        }
    }

    public function logout(){

    }
}
