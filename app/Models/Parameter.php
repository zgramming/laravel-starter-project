<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
 */
class Parameter extends Model
{
    use HasFactory;

    protected $table = Constant::TABLE_PARAMETER;

    protected $guarded = [];

}
