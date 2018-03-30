<?php

namespace Partymeister\Competitions\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;

class Vote extends Model
{

    use Searchable;
    use Filterable;

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'entry_id',
        'visitor_id',
        'vote_category_id',
        'special_vote',
        'comment',
        'points',
        'ip_address',
    ];

    public function vote_category()
	{
		return $this->belongsTo(VoteCategory::class);
	}
}
