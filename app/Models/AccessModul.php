<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\AccessModul
 *
 * @property int $id
 * @property int $app_group_user_id
 * @property int $app_modul_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|AccessModul newModelQuery()
 * @method static Builder|AccessModul newQuery()
 * @method static Builder|AccessModul query()
 * @method static Builder|AccessModul whereAppGroupUserId($value)
 * @method static Builder|AccessModul whereAppModulId($value)
 * @method static Builder|AccessModul whereCreatedAt($value)
 * @method static Builder|AccessModul whereCreatedBy($value)
 * @method static Builder|AccessModul whereId($value)
 * @method static Builder|AccessModul whereUpdatedAt($value)
 * @method static Builder|AccessModul whereUpdatedBy($value)
 * @mixin Eloquent
 */

class AccessModul extends Model
{
    use HasFactory;

    protected $table = Constant::TABLE_APP_ACCESS_MODUL;

    protected $guarded = [];

    protected $keyType = 'string';

    public $incrementing = false;

}
