<?php namespace Ebussola\Feedback\Models;

use Model;

/**
 * Feedback Model
 */
class Feedback extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ebussola_feedback_feedbacks';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'email',
        'message',
        'channel_id'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'channel' => '\Ebussola\Feedback\Models\Channel'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public static function archive($query)
    {
        $query->update(['archived' => true]);
    }

}