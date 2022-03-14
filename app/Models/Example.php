<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/// Make sure you have install [https://github.com/barryvdh/laravel-ide-helper]
/// Because it's very usefull for IDE
/// The command you should be generate is :
/// 1. php artisan ide-helper:generate
/// 2. php artisan ide-helper:models
/// 3. php artisan ide-helper:meta
///
/// When you want create new feature, firstly :
/// 1. php artisan make:controller YOUR_CONTROLLER_NAME
/// 2. php artisan make:model YOUR_MODEL_NAME
/// 3. php artisan make:migration create_YOURMIGRATIONNAME_table
/// 4. php artisan make:seeder YOURMIGRATIONNAME

/**
 * App\Models\Example
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $job_desk
 * @property string $birth_date
 * @property float $current_money
 * @property string|null $profile_image
 * @property array|null $hobby
 * @property string|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ExampleChildFirst|null $exampleChildFirst
 * @method static Builder|Example newModelQuery()
 * @method static Builder|Example newQuery()
 * @method static Builder|Example query()
 * @method static Builder|Example whereBirthDate($value)
 * @method static Builder|Example whereCreatedAt($value)
 * @method static Builder|Example whereCreatedBy($value)
 * @method static Builder|Example whereCurrentMoney($value)
 * @method static Builder|Example whereDescription($value)
 * @method static Builder|Example whereHobby($value)
 * @method static Builder|Example whereId($value)
 * @method static Builder|Example whereJobDesk($value)
 * @method static Builder|Example whereName($value)
 * @method static Builder|Example whereProfileImage($value)
 * @method static Builder|Example whereStatus($value)
 * @method static Builder|Example whereUpdatedAt($value)
 * @method static Builder|Example whereUpdatedBy($value)
 * @mixin Eloquent
 */
class Example extends Model
{
    use HasFactory;

    // Jika ingin custom nama table
    protected $table = 'example';

    // Jika ingin custom primary key
    //  protected $primaryKey ='id_example';

    // Apakah ID increment/tidak
    // public $incrementing = false;

    // Jika tidak ingin menggunakan [created_at,updated_at], jadikan ini [false]
    //public $timestamps = false;

    // Format timestamp
    // protected $dateFormat='U';

    // Jika ingin custom nama [created_at, updated_at]
    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT =  'last_update';

    // Custom connection name
    // protected $connection ='connection-name';

    // Memberikan default value
    // public $attributes = [
    //    'delayed' =>false
    // ];

    // Membuat kita bisa menggunakan MODELKAMU::create || MODELKAMMU::update
    protected $guarded = [];

    protected $casts = [
        'hobby'=>'array'
    ];


    // Relationship

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function exampleChildFirst(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        /// Foreign Key === Primary Key yang dituju
        /// Local Key === Foreign Key yang dituju
        return $this->hasOne(ExampleChildFirst::class);
    }
}
