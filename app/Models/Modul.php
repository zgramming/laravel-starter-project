<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Modul
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $order
 * @property string $pattern
 * @property string|null $icon_name
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Modul newModelQuery()
 * @method static Builder|Modul newQuery()
 * @method static Builder|Modul query()
 * @method static Builder|Modul whereCode($value)
 * @method static Builder|Modul whereCreatedAt($value)
 * @method static Builder|Modul whereCreatedBy($value)
 * @method static Builder|Modul whereIconName($value)
 * @method static Builder|Modul whereId($value)
 * @method static Builder|Modul whereName($value)
 * @method static Builder|Modul whereOrder($value)
 * @method static Builder|Modul wherePattern($value)
 * @method static Builder|Modul whereStatus($value)
 * @method static Builder|Modul whereUpdatedAt($value)
 * @method static Builder|Modul whereUpdatedBy($value)
 * @mixin Eloquent
 * @property-read Collection|Menu[] $menus
 * @property-read int|null $menus_count
 * @property-read Collection|AccessMenu[] $accessMenu
 * @property-read int|null $access_menu_count
 * @property-read Collection|AccessModul[] $accessModul
 * @property-read int|null $access_modul_count
 */
class Modul extends Model
{
    use HasFactory;

    protected $table = Constant::TABLE_APP_MODUL;
    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function menus(): HasMany
    {
        /// Modul punya banyak menu, Link ke [Menu] dengan FK [menu.app_modul_id] menggunakan PK [modul.id]
        return $this->hasMany(Menu::class, "app_modul_id", "id");
    }

    /**
     * @return HasMany
     */
    public function accessModul(): HasMany
    {
        return $this->hasMany(AccessModul::class, 'app_modul_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function accessMenu(): HasMany
    {
        return $this->hasMany(AccessMenu::class, 'app_modul_id', 'id');
    }
}
