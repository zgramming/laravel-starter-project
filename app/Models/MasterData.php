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
 * App\Models\MasterData
 *
 * @property int $id
 * @property int $master_category_id
 * @property string $master_category_code
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property string $status
 * @property int $order
 * @property string|null $parameter1_key
 * @property string|null $parameter2_key
 * @property string|null $parameter3_key
 * @property string|null $parameter4_key
 * @property string|null $parameter5_key
 * @property string|null $parameter1_value
 * @property string|null $parameter2_value
 * @property string|null $parameter3_value
 * @property string|null $parameter4_value
 * @property string|null $parameter5_value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|MasterData newModelQuery()
 * @method static Builder|MasterData newQuery()
 * @method static Builder|MasterData query()
 * @method static Builder|MasterData whereCode($value)
 * @method static Builder|MasterData whereCreatedAt($value)
 * @method static Builder|MasterData whereDescription($value)
 * @method static Builder|MasterData whereId($value)
 * @method static Builder|MasterData whereMasterCategoryCode($value)
 * @method static Builder|MasterData whereMasterCategoryId($value)
 * @method static Builder|MasterData whereName($value)
 * @method static Builder|MasterData whereOrder($value)
 * @method static Builder|MasterData whereParameter1Key($value)
 * @method static Builder|MasterData whereParameter1Value($value)
 * @method static Builder|MasterData whereParameter2Key($value)
 * @method static Builder|MasterData whereParameter2Value($value)
 * @method static Builder|MasterData whereParameter3Key($value)
 * @method static Builder|MasterData whereParameter3Value($value)
 * @method static Builder|MasterData whereParameter4Key($value)
 * @method static Builder|MasterData whereParameter4Value($value)
 * @method static Builder|MasterData whereParameter5Key($value)
 * @method static Builder|MasterData whereParameter5Value($value)
 * @method static Builder|MasterData whereStatus($value)
 * @method static Builder|MasterData whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read MasterCategory|null $masterCategory
 * @property int|null $created_by
 * @property int|null $updated_by
 * @method static Builder|MasterData whereCreatedBy($value)
 * @method static Builder|MasterData whereUpdatedBy($value)
 */
class MasterData extends Model
{
    use HasFactory, LogsActivity;

    protected $table = Constant::TABLE_MST_DATA;
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
    
    /**
     * @return BelongsTo
     */
    public function masterCategory(): BelongsTo
    {
        return $this->belongsTo(MasterCategory::class,'id','master_category_id');
    }
}
