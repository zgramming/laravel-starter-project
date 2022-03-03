<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExampleChildFirst
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int $example_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExampleChildFirst newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExampleChildFirst newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExampleChildFirst query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExampleChildFirst whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExampleChildFirst whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExampleChildFirst whereExampleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExampleChildFirst whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExampleChildFirst whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExampleChildFirst whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Example $example
 */
class ExampleChildFirst extends Model
{
    use HasFactory;

    protected $table = 'example_child_first';

    protected $guarded = [];

    public function example(){
        return $this->belongsTo(Example::class);
    }
}
