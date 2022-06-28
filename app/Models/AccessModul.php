<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

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
 * @property-read Modul $modul
 * @property-read UserGroup $userGroup
 */

class AccessModul extends Model
{
    use HasFactory, LogsActivity;

    protected $table = Constant::TABLE_APP_ACCESS_MODUL;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    /**
     * @return BelongsTo
     */
    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class, 'app_modul_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function userGroup(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class, 'app_group_user_id', 'id');
    }
}
