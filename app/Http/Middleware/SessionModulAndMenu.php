<?php

namespace App\Http\Middleware;

use App\Constant\Constant;
use App\Models\Menu;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SessionModulAndMenu
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /// Save Session Modul And Menu
        $currentSegments = $request->segments();
        list($firstSegment, $secondSegment) = $currentSegments;
        $menu = Menu::where("route", "like", "%" . sprintf("%s/%s", $firstSegment, $secondSegment))->get();

        /// If true, we assume this `menu` has parent
        /// Then we should get third segment to filter it
        if ($menu->count() > 1) {
            list($firstSegment, $secondSegment, $thirdSegment) = $currentSegments;
            $menu = $menu->filter(fn (Menu $value, $key) => $value->route === sprintf("%s/%s/%s", $firstSegment, $secondSegment, $thirdSegment))->first();
        } else {
            $menu = $menu->first();
        }

        $dataSession = ['menu_id' => $menu?->id, 'modul_id' => $menu?->app_modul_id];

        session([Constant::KEY_SESSION_MODUL_MENU => $dataSession]);

        return $next($request);
    }
}
