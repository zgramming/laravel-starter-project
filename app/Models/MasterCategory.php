<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\MasterCategory
 *
 * @property int $id
 * @property int $master_category_id
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MasterCategory|null $categoryParent
 * @method static Builder|MasterCategory newModelQuery()
 * @method static Builder|MasterCategory newQuery()
 * @method static Builder|MasterCategory query()
 * @method static Builder|MasterCategory whereCode($value)
 * @method static Builder|MasterCategory whereCreatedAt($value)
 * @method static Builder|MasterCategory whereDescription($value)
 * @method static Builder|MasterCategory whereId($value)
 * @method static Builder|MasterCategory whereMasterCategoryId($value)
 * @method static Builder|MasterCategory whereName($value)
 * @method static Builder|MasterCategory whereStatus($value)
 * @method static Builder|MasterCategory whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|MasterData[] $masterData
 * @property-read int|null $master_data_count
 */
class MasterCategory extends Model
{
    use HasFactory;

    protected $table = Constant::TABLE_MST_CATEGORY;

    protected $guarded = [];

    public function categoryParent(): HasOne
    {
        /// SELECT t1.`name`, t2.`name` AS parent FROM `master_category` AS t1 JOIN `master_category` AS t2 ON (t1.`master_category_id` = t2.id)
        return $this->hasOne(MasterCategory::class,"id","master_category_id");
    }

    public function masterData(): HasMany
    {
        /// SELECT t2.* FROM master_category as t1 JOIN master_data as t2 ON (t1.id = t2.master_category_id)
        return $this->hasMany(MasterData::class,"master_category_id","id");
    }
}
