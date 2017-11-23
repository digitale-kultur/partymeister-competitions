<?php

namespace Partymeister\Competitions\Transformers;

use League\Fractal;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\OptionGroup;

class CompetitionTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['competition_type', 'vote_categories', 'option_groups'];

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = ['competition_type', 'vote_categories', 'option_groups'];


    /**
     * Transform record to array
     *
     * @param Competition $record
     *
     * @return array
     */
    public function transform(Competition $record)
    {
        return [
            'id'                        => (int) $record->id,
            'competition_type'          => $record->competition_type()->name,
            'name'                      => $record->name,
            'sort_position'             => (int) $record->sort_position,
            'prizegiving_sort_position' => (int) $record->prizegiving_sort_position,
            'has_prizegiving'           => (bool) $record->has_prizegiving,
            'upload_enabled'            => (bool) $record->upload_enabled,
            'voting_enabled'            => (bool) $record->voting_enabled,
        ];
    }

    /**
     * Include competition type
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeOptions(Competition $record)
    {
        return $this->item($record->competition_type(), new CompetitionTypeTransformer());
    }

    /**
     * Include vote categories
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeVoteCategories(Competition $record)
    {
        $collection = $record->vote_categories;
        if (!is_null($collection)) {
            return $this->collection($collection, new VoteCategoryTransformer());
        }
    }

    /**
     * Include option groups
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeOptionGroups(Competition $record)
    {
        $collection = $record->option_groups;
        if (!is_null($collection)) {
            return $this->collection($collection, new OptionGroupTransformer());
        }
    }

}
