<?php

namespace App\Traits;

use App\Models\Modul;
use Illuminate\Database\Eloquent\Collection;

trait UserTrait
{
    /**
     * @param int|null $idUserGroup
     * @return Collection|bool|array
     */
    public function checkAccessModulAndMenu(?int $idUserGroup = null): Collection|null|array
    {
        if ($idUserGroup == null) return null;
        $modul = Modul::with(['menus', 'accessModul', 'accessMenu', 'accessMenu.menu'])
            ->whereRelation("accessModul", "app_group_user_id", "=", $idUserGroup)
            ->whereRelation("accessMenu", "app_group_user_id", "=", $idUserGroup)
            ->get();

        return $modul->isNotEmpty() ? $modul : null;
    }
}
