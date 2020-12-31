<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="UserProfile",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="screen_name",
 *          description="screen_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="location",
 *          description="location",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="url",
 *          description="url",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="icon",
 *          description="icon",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="header_image",
 *          description="header_image",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class UserProfile extends Model
{
    use HasFactory;

    public $table = 'user_profiles';
    


    public $fillable = [
        'user_id',
        'screen_name',
        'description',
        'location',
        'url',
        'icon',
        'header_image'
    ];

    protected $appends = [
        'icon_url',
        'header_image_url',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'screen_name' => 'string',
        'description' => 'string',
        'location' => 'string',
        'url' => 'string',
        'icon' => 'string',
        'header_image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'screen_name' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
        'url' => 'nullable|string|url',
        'icon' => 'nullable|file|image',
        'header_image' => 'nullable|file|image'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    #
    # Accessors
    #

    public function getIconUrlAttribute()
    {
        return isset($this->icon) ? asset('storage/'.$this->icon) : config('app.url') . '/images/user_icon_default.png';
    }

    public function getHeaderImageUrlAttribute()
    {
        return isset($this->header_image) ? asset('storage/'.$this->header_image) : config('app.url') . '/images/user_header_image_default.png';
    }
}
