<?php

namespace Partymeister\Competitions\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Motor\CMS\Models\PageVersionComponent;

class ComponentLiveVotings {

    protected $pageVersionComponent;
    protected $visitor;

    public function __construct(PageVersionComponent $pageVersionComponent)
    {
        $this->pageVersionComponent = $pageVersionComponent;
    }

    public function index(Request $request)
    {
        $this->visitor = Auth::guard('visitor')->user();
        if (is_null($this->visitor)) {
            return redirect(route('frontend.pages.index', ['slug' => 'start']));
        }

        return $this->render();
    }

    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), []);
    }

}
