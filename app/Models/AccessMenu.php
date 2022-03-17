<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
 */
class AccessMenu extends Model
{
    use HasFactory;

    protected $table = Constant::TABLE_APP_ACCESS_MENU;

    protected $guarded = [];

    protected $keyType = 'string';

    public $incrementing = false;
}
