<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Parameter
 *
 * @method static Builder|Parameter newModelQuery()
 * @method static Builder|Parameter newQuery()
 * @method static Builder|Parameter query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $value
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Parameter whereCode($value)
 * @method static Builder|Parameter whereCreatedAt($value)
 * @method static Builder|Parameter whereId($value)
 * @method static Builder|Parameter whereName($value)
 * @method static Builder|Parameter whereStatus($value)
 * @method static Builder|Parameter whereUpdatedAt($value)
 * @method static Builder|Parameter whereValue($value)
 * @property int|null $created_by
 * @property int|null $updated_by
 * @method static Builder|Parameter whereCreatedBy($value)
 * @method static Builder|Parameter whereUpdatedBy($value)
 * @property-read Collection|Activity[] $activities
 * @property-read int|null $activities_count
 */
class Parameter extends Model
{
    use HasFactory, LogsActivity;

    protected $table = Constant::TABLE_PARAMETER;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
}
