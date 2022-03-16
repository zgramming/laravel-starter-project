<?php

namespace App\Models;

use App\Constant\Constant;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
 */
class UserGroup extends Model
{
    use HasFactory;

    protected $table = Constant::TABLE_APP_GROUP_USER;

    protected $guarded = [];

}
