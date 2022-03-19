<?php

namespace App\Traits;

use App\Models\Modul;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait UserTrait
{
    /**
     * @param int|null $idUserGroup
     * @return Collection|bool|array
     */
    public function checkAccessModulAndMenu(?int $idUserGroup = null): Collection|null|array
    {
        if($idUserGroup == null) return null;
        $modul = Modul::with(['menus','accessModul','accessMenu'])
            ->whereRelation("accessModul","app_group_user_id","=",$idUserGroup)
            ->whereRelation("accessMenu","app_group_user_id","=",$idUserGroup)
        ->get();
        return !empty($modul) ? $modul : null;
    }
}
