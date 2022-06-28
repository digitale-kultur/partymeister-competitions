<?php

namespace Partymeister\Competitions\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Kra8\Snowflake\HasShortflakePrimary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Motor\Core\Filter\Filter;
use Motor\Core\Traits\Filterable;
use Motor\Core\Traits\Searchable;
use Partymeister\Core\Models\Visitor;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Partymeister\Competitions\Models\Entry
 *
 * @property int $id
 * @property int|null $competition_id
 * @property int|null $final_file_media_id
 * @property int|null $playable_file_id_1
 * @property int|null $playable_file_id_2
 * @property int|null $playable_file_id_3
 * @property int|null $playable_file_id_4
 * @property int|null $visitor_id
 * @property string $title
 * @property string $author
 * @property string $filesize
 * @property string $platform
 * @property int $sort_position
 * @property string $description
 * @property string $organizer_description
 * @property string $running_time
 * @property string $custom_option
 * @property string $ip_address
 * @property int $allow_release
 * @property int $is_remote
 * @property int $is_recorded
 * @property int $upload_enabled
 * @property int $is_prepared
 * @property int $status
 * @property string $author_name
 * @property string $author_email
 * @property string $author_phone
 * @property string $author_address
 * @property string $author_zip
 * @property string $author_city
 * @property string $author_country_iso_3166_1
 * @property string $composer_name
 * @property string $composer_email
 * @property string $composer_phone
 * @property string $composer_address
 * @property string $composer_zip
 * @property string $composer_city
 * @property string $composer_country_iso_3166_1
 * @property int $composer_not_member_of_copyright_collective
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $comments
 * @property-read Competition|null $competition
 * @property-read Media $final_file
 * @property-read mixed $download
 * @property-read mixed $last_file_upload
 * @property-read mixed $name
 * @property-read mixed $new_comments
 * @property-read mixed $ordered_files
 * @property-read mixed $special_votes
 * @property-read mixed $vote_comments
 * @property-read mixed $votes
 * @property-read \Illuminate\Database\Eloquent\Collection|Media[] $media
 * @property-read \Illuminate\Database\Eloquent\Collection|Option[] $options
 * @property-read Visitor|null $visitor
 *
 * @method static Builder|Entry filteredBy(Filter $filter, $column)
 * @method static Builder|Entry filteredByMultiple(Filter $filter)
 * @method static Builder|Entry newModelQuery()
 * @method static Builder|Entry newQuery()
 * @method static Builder|Entry query()
 * @method static Builder|Entry search($q, $full_text = false)
 * @method static Builder|Entry whereAllowRelease($value)
 * @method static Builder|Entry whereAuthor($value)
 * @method static Builder|Entry whereAuthorAddress($value)
 * @method static Builder|Entry whereAuthorCity($value)
 * @method static Builder|Entry whereAuthorCountryIso31661($value)
 * @method static Builder|Entry whereAuthorEmail($value)
 * @method static Builder|Entry whereAuthorName($value)
 * @method static Builder|Entry whereAuthorPhone($value)
 * @method static Builder|Entry whereAuthorZip($value)
 * @method static Builder|Entry whereCompetitionId($value)
 * @method static Builder|Entry whereComposerAddress($value)
 * @method static Builder|Entry whereComposerCity($value)
 * @method static Builder|Entry whereComposerCountryIso31661($value)
 * @method static Builder|Entry whereComposerEmail($value)
 * @method static Builder|Entry whereComposerName($value)
 * @method static Builder|Entry whereComposerNotMemberOfCopyrightCollective($value)
 * @method static Builder|Entry whereComposerPhone($value)
 * @method static Builder|Entry whereComposerZip($value)
 * @method static Builder|Entry whereCreatedAt($value)
 * @method static Builder|Entry whereCustomOption($value)
 * @method static Builder|Entry whereDescription($value)
 * @method static Builder|Entry whereFilesize($value)
 * @method static Builder|Entry whereFinalFileMediaId($value)
 * @method static Builder|Entry whereId($value)
 * @method static Builder|Entry whereIpAddress($value)
 * @method static Builder|Entry whereIsPrepared($value)
 * @method static Builder|Entry whereIsRecorded($value)
 * @method static Builder|Entry whereIsRemote($value)
 * @method static Builder|Entry whereOrganizerDescription($value)
 * @method static Builder|Entry wherePlatform($value)
 * @method static Builder|Entry whereRunningTime($value)
 * @method static Builder|Entry whereSortPosition($value)
 * @method static Builder|Entry whereStatus($value)
 * @method static Builder|Entry whereTitle($value)
 * @method static Builder|Entry whereUpdatedAt($value)
 * @method static Builder|Entry whereUploadEnabled($value)
 * @method static Builder|Entry whereVisitorId($value)
 * @mixin Eloquent
 */
class Entry extends Model implements HasMedia
{
    use InteractsWithMedia;
    use Searchable;
    use Filterable;
    use HasShortflakePrimary;

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'id',
        'title',
        'author',
        'platform',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'visitor_id',
        'ip_address',
        'sort_position',
        'title',
        'author',
        'filesize',
        'platform',
        'description',
        'organizer_description',
        'running_time',
        'custom_option',
        'allow_release',
        'is_remote',
        'is_recorded',
        'is_prepared',
        'upload_enabled',
        'composer_not_member_of_copyright_collective',
        'author_name',
        'author_email',
        'author_phone',
        'author_address',
        'author_zip',
        'author_city',
        'author_country_iso_3166_1',
        'composer_name',
        'composer_email',
        'composer_phone',
        'composer_address',
        'composer_zip',
        'composer_city',
        'composer_country_iso_3166_1',
        'final_file_media_id',
	    'playable_file_id_1',
	    'playable_file_id_2',
	    'playable_file_id_3',
	    'playable_file_id_4',
        'status',
        'discord_name',
        'has_explicit_content',
        'needs_content_check',
        'notify_about_status',
        'identifier',
        'representative'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        /*
         * Add incremeting identifier to the entry to recreate the incrementing id functionality
         */
        static::creating(function (Entry $entry) {
            $e = Entry::orderBy('identifier', 'DESC')->first();
            $nextIdentifier = !is_null($e) ? $e->identifier+1 : 1;
            $entry->identifier = $nextIdentifier;
        });
    }


    /**
     * @param  Media|null  $media
     *
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->width(320)
             ->height(240)
             ->nonQueued();

        $this->addMediaConversion('preview')
             ->width(1280)
             ->height(1024)
             ->nonQueued();
    }

    /**
     * @return string
     */
    public function getLastFileUploadAttribute()
    {
        $media = $this->getMedia('file')
                      ->reverse()
                      ->first();
        if (! is_null($media)) {
            return $media->created_at;
        }

        return '';
    }

    /**
     * @return BelongsTo
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->title.' by '.$this->author;
    }

    /**
     * @return BelongsToMany
     */
    public function options()
    {
        return $this->belongsToMany(Option::class);
    }

    public function getRemoteTypeAttribute() {
        if ($this->visitor) {
            if ($this->visitor->is_satellite) {
                return 'Satellite';
            } else if ($this->visitor->is_remote) {
                return 'Remote';
            }
        }
        if ($this->is_remote) {
            return 'Remote';
        }
        return '';
    }

    /**
     * @return int|mixed
     */
    public function getSpecialVotesAttribute()
    {
        // Get visitor votes
        $query = DB::table('votes')
                   ->select(DB::raw('SUM(special_vote) as special_votes'))
                   ->where('entry_id', '=', $this->id)
                   ->first();

        if (is_null($query)) {
            return 0;
        }

        return $query->special_votes;
    }

    /**
     * @return array
     */
    public function getVoteCommentsAttribute()
    {
        return DB::table('votes')
                 ->select('comment')
                 ->where('entry_id', $this->id)
                 ->where('comment', '!=', '')
                 ->get()
                 ->pluck('comment')
                 ->toArray();
    }

    /**
     * @return int|mixed
     */
    public function getVotesAttribute()
    {
        // Get visitor votes
        $sub = DB::table('votes')
                 ->select(DB::raw('SUM(points)/count(id) as points_per_visitor'))
                 ->where('entry_id', '=', $this->id)
                 ->groupBy('visitor_id');

        $points = DB::table(DB::raw("({$sub->toSql()}) as sub"))
                    ->mergeBindings($sub)// you need to get underlying Query Builder
                    ->select(DB::raw('SUM(points_per_visitor) as points'))
                    ->pluck('points')
                    ->first();

        // Get manual votes
        $manualPoints = DB::table('manual_votes')
                          ->select(DB::raw('SUM(points) as points'))
                          ->where('entry_id', $this->id)
                          ->pluck('points')
                          ->first();

        return (is_null($points) ? 0 : $points) + (is_null($manualPoints) ? 0 : $manualPoints);
    }

    /**
     * @return int
     */
    public function getNewCommentsAttribute()
    {
        return $this->comments()
                    ->where('read_by_visitor', false)
                    ->count();
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany('Partymeister\Competitions\Models\Comment', 'model');
    }

    /**
     * @return Collection
     */
    public function getOrderedFilesAttribute()
    {
        $media = $this->getMedia('file');

        $mediaArray = [];
        foreach ($media as $m) {
            $mediaArray[] = $m;
        }

        usort($mediaArray, function ($item1, $item2) {
            return strtotime($item2['created_at']) <=> strtotime($item1['created_at']);
        });

        return collect($mediaArray);
    }

    /**
     * @return |null
     */
    public function getDownloadAttribute()
    {
        $media = null;
        if ($this->final_file_media_id > 0) {
            $media = Media::find($this->final_file_media_id);
        }

        return $media;
    }

    /**
     * @return HasOne
     */
    public function final_file()
    {
        return $this->hasOne(Media::class, 'model_id');
    }

    /**
     * @return BelongsTo
     */
    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
