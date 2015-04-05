<?php namespace Ebussola\Feedback\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Channel Model
 */
class Channel extends Model
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ebussola_feedback_channels';

    /**
     * @var array List of attribute names which are json encoded and decoded from the database.
     */
    protected $jsonable = [];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'code',
        'method',
        'email_destination',
        'firebase_path'
    ];

    public $rules = [
        'name' => 'required',
        'code' => 'required',
        'method' => 'required',
        'email_destination' => 'email',
        'firebase_path' => 'required_if:method,firebase'
    ];

    public $attributeNames = [
        'name' => 'ebussola.feedback::lang.channel.name',
        'code' => 'ebussola.feedback::lang.channel.code',
        'method' => 'ebussola.feedback::lang.channel.method',
        'email_destination' => 'ebussola.feedback::lang.channel.emailDestination',
        'firebase_path' => 'ebussola.feedback::lang.channel.firebasePath'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'feedbacks' => '\Ebussola\Feedback\Models\Feedback'
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    protected static function boot()
    {
        parent::boot();

        self::saving(function($channel) {
            if ($channel->code == null) {
                $channel->code = \Str::slug($channel->name);
            }
        });
    }

    /**
     * @param $code
     * @return Channel
     */
    public static function getByCode($code)
    {
        return self::query()->where('code', '=', $code)->first();
    }

}