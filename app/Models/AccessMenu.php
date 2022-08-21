<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\AccessMenu
 *
 * @property int $id
 * @property int $app_group_user_id
 * @property int $app_modul_id
 * @property int $app_menu_id
 * @property mixed $allowed_access
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|AccessMenu newModelQuery()
 * @method static Builder|AccessMenu newQuery()
 * @method static Builder|AccessMenu query()
 * @method static Builder|AccessMenu whereAllowedAccess($value)
 * @method static Builder|AccessMenu whereAppGroupUserId($value)
 * @method static Builder|AccessMenu whereAppMenuId($value)
 * @method static Builder|AccessMenu whereAppModulId($value)
 * @method static Builder|AccessMenu whereCreatedAt($value)
 * @method static Builder|AccessMenu whereCreatedBy($value)
 * @method static Builder|AccessMenu whereId($value)
 * @method static Builder|AccessMenu whereUpdatedAt($value)
 * @method static Builder|AccessMenu whereUpdatedBy($value)
 * @mixin Eloquent
 * @property-read Menu $menu
 * @property-read Modul $modul
 * @property-read UserGroup $userGroup
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 */
class AccessMenu extends Model
{
    use HasFactory, LogsActivity;

    protected $table = Constant::TABLE_APP_ACCESS_MENU;

    protected $guarded = [];

    protected $keyType = 'string';

    protected $casts = [
        'allowed_access' => 'array',
    ];

    public $incrementing = false;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    public function userGroup(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class,'app_group_user_id','id');
    }

    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class,'app_modul_id','id');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class,'app_menu_id','id');
    }
}
