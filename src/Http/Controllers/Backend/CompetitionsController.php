<?php

namespace Partymeister\Competitions\Http\Controllers\Backend;

use Illuminate\Http\Response;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Competitions\Forms\Backend\CompetitionForm;
use Partymeister\Competitions\Grids\CompetitionGrid;
use Partymeister\Competitions\Http\Requests\Backend\CompetitionRequest;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Services\CompetitionService;

/**
 * Class CompetitionsController
 */
class CompetitionsController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \ReflectionException
     */
    public function index()
    {
        $grid = new CompetitionGrid(Competition::class);

        $service = CompetitionService::collection($grid);
        $grid->setFilter($service->getFilter());
	$paginator = $service->getPaginator();

        return view('partymeister-competitions::backend.competitions.index', compact('paginator', 'grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $form = $this->form(CompetitionForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.competitions.store',
            'enctype' => 'multipart/form-data',
        ]);

        $motorShowRightSidebar = true;

        return view('partymeister-competitions::backend.competitions.create', compact('form', 'motorShowRightSidebar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompetitionRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CompetitionRequest $request)
    {
        $form = $this->form(CompetitionForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        CompetitionService::createWithForm($request, $form);

        flash()->success(trans('partymeister-competitions::backend/competitions.created'));

        return redirect('backend/competitions');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Competition  $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Competition $record)
    {
        $form = $this->form(CompetitionForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.competitions.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model'   => $record,
        ]);

        $motorShowRightSidebar = true;

        return view('partymeister-competitions::backend.competitions.edit', compact('form', 'motorShowRightSidebar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompetitionRequest  $request
     * @param  Competition  $record
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CompetitionRequest $request, Competition $record)
    {
        $form = $this->form(CompetitionForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        CompetitionService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-competitions::backend/competitions.updated'));

        return redirect('backend/competitions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Competition  $record
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Competition $record)
    {
        CompetitionService::delete($record);

        flash()->success(trans('partymeister-competitions::backend/competitions.deleted'));

        return redirect('backend/competitions');
    }
}
