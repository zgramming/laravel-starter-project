<?php

namespace App\Models;

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

    protected $table = 'master_category';

    protected $guarded = [];

    public function categoryParent(): HasOne
    {
        /// Foreign Key === Primary Key yang dituju
        /// Local Key === Foreign Key yang dituju
        return $this->hasOne(MasterCategory::class,'id','master_category_id');
    }

    public function masterData(): HasMany
    {
        return $this->hasMany(MasterData::class,'id','master_category_id');
    }
}
