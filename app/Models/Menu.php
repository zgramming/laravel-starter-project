<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int $app_modul_id
 * @property int $app_menu_id_parent
 * @property string $code
 * @property string $name
 * @property string $url_controller
 * @property int $order
 * @property string|null $icon_name
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Menu newModelQuery()
 * @method static Builder|Menu newQuery()
 * @method static Builder|Menu query()
 * @method static Builder|Menu whereAppMenuIdParent($value)
 * @method static Builder|Menu whereAppModulId($value)
 * @method static Builder|Menu whereCode($value)
 * @method static Builder|Menu whereCreatedAt($value)
 * @method static Builder|Menu whereCreatedBy($value)
 * @method static Builder|Menu whereIconName($value)
 * @method static Builder|Menu whereId($value)
 * @method static Builder|Menu whereName($value)
 * @method static Builder|Menu whereOrder($value)
 * @method static Builder|Menu whereStatus($value)
 * @method static Builder|Menu whereUpdatedAt($value)
 * @method static Builder|Menu whereUpdatedBy($value)
 * @method static Builder|Menu whereUrlController($value)
 * @mixin Eloquent
 * @property string $route
 * @property-read Modul $modul
 * @method static Builder|Menu whereRoute($value)
 * @property-read Menu|null $menuParent
 */
class Menu extends Model
{
    use HasFactory;

    protected $table = Constant::TABLE_APP_MENU;

    protected $guarded = [];

    /**
     * @return HasOne
     */
    public function menuParent(): HasOne
    {
        return $this->hasOne(Menu::class,"id","app_menu_id_parent");
    }

    /**
     * @return BelongsTo
     */
    public function modul(): BelongsTo
    {
        /// Owner Key = Primary Key
        /// Foreign Key = FK
        /// Link ke [modul] menggunakan FK [menu.app_modul_id] dengan tujuan [modul.id]
        return $this->belongsTo(Modul::class,"app_modul_id","id");
    }
}
