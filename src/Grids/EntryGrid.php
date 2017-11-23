<?php

namespace Partymeister\Competitions\Grids;

use Motor\Backend\Grid\Grid;

class EntryGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.entries.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.entries.destroy');
    }
}
