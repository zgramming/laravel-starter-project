<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MasterCategory
 *
 * @property int $id
 * @property int $master_category_id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $status
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|MasterCategory newModelQuery()
 * @method static Builder|MasterCategory newQuery()
 * @method static Builder|MasterCategory query()
 * @method static Builder|MasterCategory whereCode($value)
 * @method static Builder|MasterCategory whereCreatedAt($value)
 * @method static Builder|MasterCategory whereDescription($value)
 * @method static Builder|MasterCategory whereId($value)
 * @method static Builder|MasterCategory whereMasterCategoryId($value)
 * @method static Builder|MasterCategory whereName($value)
 * @method static Builder|MasterCategory whereOrder($value)
 * @method static Builder|MasterCategory whereStatus($value)
 * @method static Builder|MasterCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */

class MasterCategory extends Model
{
    use HasFactory;

    // Jika ingin custom nama table
    protected $table = 'master_category';

    // Membuat kita bisa menggunakan MODELKAMU::create || MODELKAMMU::update
    protected $guarded = [];
}
