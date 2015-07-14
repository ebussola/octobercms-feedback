<?php namespace eBussola\Feedback\Controllers;

use Backend\Classes\FormField;
use BackendMenu;
use Backend\Classes\Controller;
use eBussola\Feedback\Models\Feedback;

/**
 * feedbacks Back-end Controller
 */
class Feedbacks extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = [
        'list' => 'config_list.yaml',
        'archived' => 'config_list_archived.yaml'
    ];

    /**
     * @var array Permissions required to view this page.
     */
    protected $requiredPermissions = ['ebussola.feedback.manage'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('eBussola.Feedback', 'feedback', 'feedbacks');

        $this->pageTitle = $this->pageTitle ?: \Lang::get($this->getConfig('title', 'backend::lang.list.default_title'));
    }

    public function archived()
    {
        BackendMenu::setContext('eBussola.Feedback', 'feedback', 'archived');

        $this->bodyClass = 'slim-container';
        $this->makeLists();
    }

    public function onBulkArchive()
    {
        $feedbackIds = post('ids');

        Feedback::archive(Feedback::query()->whereIn('id', $feedbackIds));

        if (count($feedbackIds) > 1) {
            \Flash::success(\Lang::get('ebussola.feedback::lang.backend.feedback.archive.bulkSuccess'));
        } else {
            \Flash::success(\Lang::get('ebussola.feedback::lang.backend.feedback.archive.success'));
        }
        return $this->listRefresh();
    }

    public function onArchive($recordId)
    {
        Feedback::archive(Feedback::query()->where('id', '=', $recordId));

        \Flash::success(\Lang::get('ebussola.feedback::lang.backend.feedback.archive.success'));
        return $this->makeRedirect();
    }

    /**
     * Controller override: Extend the query used for populating the list
     * after the default query is processed.
     * @param \October\Rain\Database\Builder $query
     */
    public function listExtendQuery($query, $definition = null)
    {
        switch ($definition) {
            case 'archived' :
                $query->where('archived', '=', true);
                break;

            default :
                $query->where('archived', '=', false);
                break;
        }
    }

    /**
     * Replace a table column value (<td>...</td>)
     * @param  \Model $record The populated model used for the column
     * @param  string $columnName The column name to override
     * @param  string $definition List definition (optional)
     * @return string HTML view
     */
    public function listOverrideColumnValue($record, $columnName, $definition = null)
    {
        if ($columnName == 'message') {
            return \Str::limit($record->message, 140);
        }
    }

    /**
     * Called after the form fields are defined.
     * @param \Backend\Widgets\Form $host The hosting form widget
     * @return void
     */
    public function formExtendFields($host, $fields)
    {
        /** @var FormField $field */
        foreach ($host->getFields() as $field) {
            $field->disabled = true;
        }
    }

}