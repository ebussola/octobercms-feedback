<?php namespace Ebussola\Feedback\Controllers;

use Backend\Classes\FormField;
use Backend\Widgets\Lists;
use BackendMenu;
use Backend\Classes\Controller;
use Ebussola\Feedback\Models\Feedback;

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

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Ebussola.Feedback', 'feedback', 'feedbacks');

        $this->pageTitle = $this->pageTitle ?: \Lang::get($this->getConfig('title', 'backend::lang.list.default_title'));
    }

    public function archived()
    {
        BackendMenu::setContext('Ebussola.Feedback', 'feedback', 'archived');

        $this->bodyClass = 'slim-container';
        $this->makeLists();
    }

    public function onBulkArchive()
    {
        $feedbackIds = post('ids');

        Feedback::archive(Feedback::query()->whereIn('id', $feedbackIds));

        \Flash::success(\Lang::get('ebussola.feedback::feedback.archive.success'));
        return $this->listRefresh();
    }

    public function onArchive($recordId)
    {
        Feedback::archive(Feedback::query()->where('id', '=', $recordId));

        \Flash::success(\Lang::get('ebussola.feedback::feedback.archive.success'));
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