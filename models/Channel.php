<?php namespace eBussola\Feedback\Models;

use eBussola\Feedback\Classes\Method;
use October\Rain\Database\Traits\Validation;

/**
 * Channel Model
 */
class Channel extends \October\Rain\Database\Model
{
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'ebussola_feedback_channels';

    /**
     * @var array List of attribute names which are json encoded and decoded from the database.
     */
    protected $jsonable = ['method_data'];

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
        'method_data',
        'prevent_save_database'
    ];

    public $rules = [
        'name' => 'required',
        'code' => 'required',
        'method' => 'required'
    ];

    public $attributeNames = [
        'name' => 'ebussola.feedback::lang.channel.name',
        'code' => 'ebussola.feedback::lang.channel.code',
        'method' => 'ebussola.feedback::lang.channel.method'
    ];

    public static $methods = [
        'none' => ['\eBussola\Feedback\Classes\NoneMethod', '-- None --'],
        'email' => ['\eBussola\Feedback\Classes\EmailMethod', 'Email'],
        'group' => ['\eBussola\Feedback\Classes\GroupMethod', 'Group']
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'feedbacks' => '\eBussola\Feedback\Models\Feedback'
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

        if (strstr(\Url::current(), trim(\Backend::baseUrl(), '/'))) {
            self::backendBoot();
        }
    }

    public static function backendBoot()
    {
        foreach (self::$methods as $method) {
            $namespace = $method[0];

            $method = new $namespace();
            $method->boot();
        }
    }

    public function getMethodOptions()
    {
        $options = [];
        foreach (self::$methods as $key => $method) {
            $options[$key] = isset($method[1]) ? $method[1] : $key;
        }

        return $options;
    }

    /**
     * @param string $key
     * @param string $fqn
     * @param null|string $alias
     */
    public static function registerMethod($key, $fqn, $alias=null)
    {
        $config = [$fqn];
        if ($alias !== null) {
            $config[] = $alias;
        }

        self::$methods[$key] = $config;
    }

    /**
     * @return Method
     */
    public function getMethodObj()
    {
        $methodClass = self::$methods[$this->method][0];
        return new $methodClass();
    }

    /**
     * @param $code
     * @return Channel
     */
    public static function getByCode($code)
    {
        return self::query()->where('code', '=', $code)->first();
    }

    /**
     * @param $data
     * @throws \October\Rain\Database\ModelException
     */
    public function send($data)
    {
        $feedback = new \eBussola\Feedback\Models\Feedback($data);
        $feedback->channel_id = $this->id;

        if (!$this->prevent_save_database) {
            $feedback->validate();
            $feedback->save();
        }

        $this->getMethodObj()->send($this->method_data, $data);
    }

}