<?php

namespace Partymeister\Competitions\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Slides\Models\SlideTemplate;

class ComponentEntryDetails {

    protected $pageVersionComponent;
    protected $data = [];

    public function __construct(PageVersionComponent $pageVersionComponent)
    {
        $this->pageVersionComponent = $pageVersionComponent;
    }

    public function index(Request $request)
    {
        $visitor = Auth::guard('visitor')->user();

        if (is_null($visitor)) {
            return redirect()->back();
        }

        if (is_null($request->get('entry_id'))) {
            return redirect()->back();
        }

        $record = Entry::find($request->get('entry_id'));
        if (is_null($record)) {
            return redirect()->back();
        }

        if ($visitor->id != $record->visitor_id) {
            return redirect()->back();
        }

        $data = fractal($record,
            \Partymeister\Competitions\Transformers\EntryTransformer::class)->toArray();

        $entry = $data['data'];

        foreach (array_get($entry, 'options.data', []) as $i => $option) {
            $entry['option_'.($i+1)] = $option['name'];
        }

        $entry['competition_name'] = strtoupper($entry['competition_name']);
        if ($entry['filesize_bytes'] == 0) {
            $entry['filesize_human'] = ' ';
        }
        if ($entry['description'] == '') {
            $entry['description'] = ' ';
        }
        $entry['description'] = nl2br($entry['description']);
        $entry['sort_position_prefixed'] = rand(10, 99);
        $entry['previous_sort_position'] = ' ';
        $entry['previous_author'] = ' ';
        $entry['previous_title'] = ' ';

        $competitionTemplate = SlideTemplate::where('template_for', 'competition')->first();

        $this->data = [
            'entry' => $entry,
            'record' => $record,
            'competitionTemplate' => $competitionTemplate
        ];

        return $this->render();
    }

    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), $this->data);
    }

}