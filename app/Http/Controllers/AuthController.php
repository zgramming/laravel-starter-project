<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UserTrait;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Session;
use Throwable;

class AuthController extends Controller
{
	use UserTrait;

	public function index(): Factory|View|Application
	{
		$keys = [];
		return view("modules.login", $keys);
	}

	/**
	 * @return Redirector|RedirectResponse|Application
	 */
	public function login(): Redirector|RedirectResponse|Application
	{
		/// If you want change authentication method using username instead of email, you can follow link in below.
		/// Don't forget to change input type from email to username in login.blade.php >.<
		/// Reference [https://stackoverflow.com/a/31852437/7360353]
		try {
			$post = request()->all();

			$rules = [
				'username' => ['required'],
				'password' => ['required'],
			];

			$validator = Validator::make($post, $rules);
			if ($validator->fails()) return back()->withErrors($validator->messages())->withInput();

			$data = [
				'username' => $post['username'],
				'password' => $post['password'],
			];

			if (!Auth::attempt($data)) throw new Exception("Username atau Password yang dimasukkan tidak valid", 404);

			$user = User::with(['userGroup'])->where("username", "=", $post['username'])->first();
			$access = $this->checkAccessModulAndMenu($user?->userGroup?->id);
			if (empty($access)) {
                throw new Exception("Account dengan username $user->username belum mempunyai access, silahkan hubungi admin", 404);
            }

			/// Get first menu in modul setting [MANAGEMENT USER] & Extract the route
			$accessMenu = collect($access->first()->accessMenu->sortBy("app_menu_id",SORT_ASC));
			$initialRoute = $accessMenu->first()->menu->route;

			request()->session()->regenerate();
			return redirect($initialRoute);
		} catch (QueryException $e) {
			$message = $e->getMessage();
			$code = $e->getCode() ?: 500;

			return back()->withErrors($message)->withInput();
		} catch (Throwable $e) {
			$message = $e->getMessage();
			$code = $e->getCode() ?: 500;

			return back()->withErrors($message)->withInput();
		}
	}

	/**
	 * @return RedirectResponse
	 */
	public function logout(): RedirectResponse
	{
		Session::flush();
		Auth::logout();
		return to_route("login");
	}
}
