<?php namespace eBussola\Feedback\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\QueryBuilder;
use October\Rain\Database\Traits\Validation;

/**
 * Feedback Model
 */
class Feedback extends Model
{
    use Validation;

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
     * @var array The rules to be applied to the data.
     */
    public $rules = [
        'name' => '',
        'email' => 'email|required',
        'message' => 'required',
        'channel_id' => 'integer|required'
    ];


    /**
     * @var array The array of custom attribute names.
     */
    public $attributeNames = [
        'name' => 'ebussola.feedback::lang.feedback.name',
        'email' => 'ebussola.feedback::lang.feedback.email',
        'message' => 'ebussola.feedback::lang.feedback.message'
    ];

    /**
     * @var array The array of custom error messages.
     */
    public $customMessages = [
        'email' => 'ebussola.feedback::lang.component.onSend.error.email.email',
        'message' => 'ebussola.feedback::lang.component.onSend.error.message.required'
    ];


    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'channel' => '\eBussola\Feedback\Models\Channel'
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