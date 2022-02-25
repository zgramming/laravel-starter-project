<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Example
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $birth_date
 * @property float $current_money
 * @property string|null $profile_image
 * @property array|null $hobby
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Example newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Example newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Example query()
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereCurrentMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereHobby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Example whereUpdatedBy($value)
 * @mixin \Eloquent
 * @property-read \App\Models\ExampleChildFirst|null $exampleChildFirst
 */
class Example extends Model
{
    use HasFactory;

    /// Jika ingin custom nama table
    protected $table = 'example';

    /// Jika ingin custom primary key
//    protected $primaryKey ='id_example';

    /// Apakah ID increment/tidak
//public $incrementing = false;

    /// Jika tidak ingin menggunakan [created_at,updated_at], jadikan ini [false]
//public $timestamps = false;

    /// Format timestamp
//protected $dateFormat='U';

    /// Jika ingin custom nama [created_at, updated_at]
//const CREATED_AT = 'creation_date';
//const UPDATED_AT =  'last_update';

    /// Custom connection name
//protected $connection ='connection-name';

    /// Memberikan default value
//public $attributes = [
//    'delayed' =>false
//];

    /// Membuat kita bisa menggunakan MODELKAMU::create || MODELKAMMU::update
    protected $guarded = [];

    protected $casts = [
        'hobby'=>'array'
    ];


    /// Relationship

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function exampleChildFirst(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ExampleChildFirst::class);
    }
}
