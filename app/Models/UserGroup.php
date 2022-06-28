<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\UserGroup
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UserGroup newModelQuery()
 * @method static Builder|UserGroup newQuery()
 * @method static Builder|UserGroup query()
 * @method static Builder|UserGroup whereCode($value)
 * @method static Builder|UserGroup whereCreatedAt($value)
 * @method static Builder|UserGroup whereCreatedBy($value)
 * @method static Builder|UserGroup whereId($value)
 * @method static Builder|UserGroup whereName($value)
 * @method static Builder|UserGroup whereStatus($value)
 * @method static Builder|UserGroup whereUpdatedAt($value)
 * @method static Builder|UserGroup whereUpdatedBy($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AccessMenu[] $accessMenu
 * @property-read int|null $access_menu_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AccessModul[] $accessModul
 * @property-read int|null $access_modul_count
 */
class UserGroup extends Model
{
    use HasFactory, LogsActivity;

    protected $table = Constant::TABLE_APP_GROUP_USER;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    /**
     * @return HasMany
     */
    public function accessModul(): HasMany
    {
        return $this->hasMany(AccessModul::class,'app_group_user_id','id');
    }

    /**
     * @return HasMany
     */
    public function accessMenu(): HasMany
    {
        return $this->hasMany(AccessMenu::class,'app_group_user_id','id');
    }

}
