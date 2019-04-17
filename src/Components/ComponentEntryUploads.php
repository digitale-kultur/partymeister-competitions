<?php

namespace Partymeister\Competitions\Components;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Competitions\Forms\Component\EntryUploadForm;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Services\EntryService;

class ComponentEntryUploads
{

    use FormBuilderTrait;

    protected $component;

    protected $pageVersionComponent;

    protected $entryUploadForm;

    protected $record;

    protected $request;


    public function __construct(PageVersionComponent $pageVersionComponent, \Partymeister\Competitions\Models\Component\ComponentEntryUpload $component)
    {
        $this->component            = $component;
        $this->pageVersionComponent = $pageVersionComponent;
    }


    public function index(Request $request)
    {
        $visitor = Auth::guard('visitor')->user();

        if (is_null($visitor)) {
            return redirect()->back();
        }

        $this->request = $request;

        $formOptions = [
            'name'    => 'entry-upload',
            'url'     => $this->request->url(),
            'method'  => 'POST',
            'enctype' => 'multipart/form-data',
        ];

        if ( ! is_null($request->get('entry_id'))) {
            $this->record = Entry::find($request->get('entry_id'));
            if (is_null($this->record) || $visitor->id != $this->record->visitor_id) {
                return redirect()->back();
            }
            $formOptions['url']    = $this->request->url() . '?entry_id=' . $this->record->id;
            $formOptions['model']  = $this->record;
            $formOptions['method'] = 'PATCH';
        }

        $this->entryUploadForm = $this->form(EntryUploadForm::class, $formOptions);

        switch ($request->method()) {
            case 'POST':
                $result = $this->post();
                if ($result instanceOf RedirectResponse) {
                    return $result;
                }
                break;
            case 'PATCH':
                $result = $this->patch();
                if ($result instanceOf RedirectResponse) {
                    return $result;
                }
                break;
        }

        return $this->render();
    }


    protected function post()
    {
        // It will automatically use current request, get the rules, and do the validation
        if ((int)$this->request->input($this->entryUploadForm->getName() . '.reload_on_change') == 1) {
            return redirect()->back()->withInput();
        }
        if ( ! $this->entryUploadForm->isValid()) {
            return redirect()->back()->withErrors($this->entryUploadForm->getErrors())->withInput();
        }

        EntryService::createWithForm($this->request, $this->entryUploadForm);

        return redirect(route('frontend.pages.index', ['slug' => $this->component->entries_page->full_slug]));
    }


    protected function patch()
    {
        if ( ! $this->record->competition->upload_enabled && ! $this->record->upload_enabled) {
            return redirect(route('frontend.pages.index', ['slug' => $this->component->entries_page->full_slug]));
        }

        $this->entryUploadForm->getField('file')->setOption('rules', '');
//        if ($record->competition->competition_type->number_of_work_stages > 0) {
//            for ($i = 1; $i <= $record->competition->competition_type->number_of_work_stages; $i++) {
////                $form->getField('work_stage_' . $i)->setOption('rules', '');
//            }
//        }

        // It will automatically use current request, get the rules, and do the validation
        if ((int)$this->request->input($this->entryUploadForm->getName() . '.reload_on_change') == 1) {
            return redirect()->back()->withInput();
        }

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $this->entryUploadForm->isValid()) {
            return redirect()->back()->withErrors($this->entryUploadForm->getErrors())->withInput();
        }

        EntryService::updateWithForm($this->record, $this->request, $this->entryUploadForm);

        return redirect(route('frontend.pages.index', ['slug' => $this->component->entries_page->full_slug]));
    }


    public function render()
    {
        return view(config('motor-cms-page-components.components.' . $this->pageVersionComponent->component_name . '.view'),
            ['entryUploadForm' => $this->entryUploadForm, 'record' => $this->record, 'component' => $this->component]);
    }

}