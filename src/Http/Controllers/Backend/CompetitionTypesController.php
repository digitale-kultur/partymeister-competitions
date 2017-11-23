<?php

namespace Partymeister\Competitions\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Competitions\Models\CompetitionType;
use Partymeister\Competitions\Http\Requests\Backend\CompetitionTypeRequest;
use Partymeister\Competitions\Services\CompetitionTypeService;
use Partymeister\Competitions\Grids\CompetitionTypeGrid;
use Partymeister\Competitions\Forms\Backend\CompetitionTypeForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class CompetitionTypesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new CompetitionTypeGrid(CompetitionType::class);

        $service = CompetitionTypeService::collection($grid);
        $grid->filter = $service->getFilter();
        $paginator    = $service->getPaginator();

        return view('partymeister-competitions::backend.competition_types.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(CompetitionTypeForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.competition_types.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('partymeister-competitions::backend.competition_types.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CompetitionTypeRequest $request)
    {
        $form = $this->form(CompetitionTypeForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        CompetitionTypeService::createWithForm($request, $form);

        flash()->success(trans('partymeister-competitions::backend/competition_types.created'));

        return redirect('backend/competition_types');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(CompetitionType $record)
    {
        $form = $this->form(CompetitionTypeForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.competition_types.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('partymeister-competitions::backend.competition_types.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CompetitionTypeRequest $request, CompetitionType $record)
    {
        $form = $this->form(CompetitionTypeForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        CompetitionTypeService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-competitions::backend/competition_types.updated'));

        return redirect('backend/competition_types');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompetitionType $record)
    {
        CompetitionTypeService::delete($record);

        flash()->success(trans('partymeister-competitions::backend/competition_types.deleted'));

        return redirect('backend/competition_types');
    }
}