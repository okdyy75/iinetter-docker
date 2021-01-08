<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Tweet",
 *      required={"ref_tweet_id", "tweet_type", "tweet_text"},
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
 *          property="ref_tweet_id",
 *          description="ref_tweet_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="tweet_type",
 *          description="tweet_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="tweet_text",
 *          description="tweet_text",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="reply_count",
 *          description="reply_count",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="retweet_count",
 *          description="retweet_count",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="favorite_count",
 *          description="favorite_count",
 *          type="integer",
 *          format="int32"
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
class Tweet extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'tweets';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'ref_tweet_id',
        'tweet_type',
        'tweet_text',
        'reply_count',
        'retweet_count',
        'favorite_count'
    ];

    protected $appends = [
        'screen_favorite_count',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'ref_tweet_id' => 'integer',
        'tweet_type' => 'string',
        'tweet_text' => 'string',
        'reply_count' => 'integer',
        'retweet_count' => 'integer',
        'favorite_count' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'ref_tweet_id' => 'nullable|required_if:tweet_type,retweet,reply|integer|exists:tweets,id',
        'tweet_type' => 'required|string|in:tweet,retweet,reply',
        'tweet_text' => 'nullable|required_if:tweet_type,tweet,reply|string|max:255',
        'reply_count' => 'nullable|integer|min:0',
        'retweet_count' => 'nullable|integer|min:0',
        'favorite_count' => 'nullable|integer|min:0'
    ];

    #
    # Accessors
    #

    public function getScreenFavoriteCountAttribute()
    {
        return $this->getKanjiNum((string) $this->favorite_count);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function refTweet()
    {
        return $this->belongsTo(\App\Models\Tweet::class, 'ref_tweet_id', 'id');
    }

    /**
     * 数字を漢字表記で取得する
     * example)
     *  Before:40003000200010000
     *  After: 4京3兆2億1万
     *
     * @param string $num
     * @return string
     */
    private function getKanjiNum(string $num): string
    {
        $length = strlen($num);
        $digits = ['', '万', '億', '兆', '京', '垓'];
        $kanjiNums = [];
        $kanjiNum = '';

        for ($i = 0; $i < ceil($length / 4); $i++) {
            $kanjiNums[$i] = substr($num, -4, 4);
            $num = substr($num, 0, -4);
            if ($kanjiNums[$i] != '0000') $kanjiNum = (int) $kanjiNums[$i] . $digits[$i] . $kanjiNum;
        }
        return $kanjiNum ?: '0';
    }
}
