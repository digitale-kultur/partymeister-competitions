<?php

namespace Partymeister\Competitions\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Partymeister\Competitions\Http\Requests\Backend\EntryRequest;
use Partymeister\Competitions\Http\Resources\EntryCollection;
use Partymeister\Competitions\Http\Resources\EntryResource;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Models\LiveVote;
use Partymeister\Competitions\Services\EntryService;

/**
 * Class EntriesController
 *
 * @package Partymeister\Competitions\Http\Controllers\Api
 */
class EntriesController extends ApiController
{
    protected string $model = 'Partymeister\Competitions\Models\Entry';

    protected string $modelResource = 'entry';

    /**
     * @OA\Get (
     *   tags={"EntriesController"},
     *   path="/api/entries",
     *   summary="Get entry collection",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/EntryResource")
     *       ),
     *       @OA\Property(
     *         property="meta",
     *         ref="#/components/schemas/PaginationMeta"
     *       ),
     *       @OA\Property(
     *         property="links",
     *         ref="#/components/schemas/PaginationLinks"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Collection read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   )
     * )
     *
     * Display a listing of the resource.
     *
     * @return EntryCollection
     */
    public function index()
    {
        $paginator = EntryService::collection()
                                 ->getPaginator();

        return (new EntryCollection($paginator))->additional(['message' => 'Entry collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"EntriesController"},
     *   path="/api/entries",
     *   summary="Create new entry",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/EntryRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EntryResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Entry created"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param EntryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EntryRequest $request)
    {
        $result = EntryService::create($request)
                              ->getResult();

        return (new EntryResource($result))->additional(['message' => 'Entry created'])
                                           ->response()
                                           ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"EntriesController"},
     *   path="/api/entries/{entry}",
     *   summary="Get single entry",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="entry",
     *     parameter="entry",
     *     description="Entry id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EntryResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Entry read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Display the specified resource.
     *
     * @param Entry $record
     * @return EntryResource
     */
    public function show(Entry $record)
    {
        $result = EntryService::show($record)
                              ->getResult();

        return (new EntryResource($result->load('competition')))->additional(['message' => 'Entry read']);
    }

    /**
     * @OA\Put (
     *   tags={"EntriesController"},
     *   path="/api/entries/{entry}",
     *   summary="Update an existing entry",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/EntryRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="entry",
     *     parameter="entry",
     *     description="Entry id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/EntryResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Entry updated"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Update the specified resource in storage.
     *
     * @param EntryRequest $request
     * @param Entry $record
     * @return EntryResource
     */
    public function update(EntryRequest $request, Entry $record)
    {
        $result = EntryService::update($record, $request)->getResult();

	    foreach (LiveVote::all() as $liveVote) {
		    $liveVote->delete();
	    }

	    if(strpos($request->getContent(), 'enable_livevoting=true') !== false) {
		    if($record) {
			    $liveVote = new LiveVote();
			    $liveVote->competition_id = $record->competition_id;
			    $liveVote->entry_id       = $record->id;
			    $liveVote->sort_position  = $record->sort_position;
			    $liveVote->save();
			    $result->enable_livevoting = true;
		    }
	    }

        return (new EntryResource($result))->additional(['message' => 'Entry updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"EntriesController"},
     *   path="/api/entries/{entry}",
     *   summary="Delete a entry",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="entry",
     *     parameter="entry",
     *     description="Entry id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Entry deleted"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   ),
     *   @OA\Response(
     *     response="400",
     *     description="Bad request",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Problem deleting entry"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param Entry $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Entry $record)
    {
        $result = EntryService::delete($record)
                              ->getResult();

        if ($result) {
            return response()->json(['message' => 'Entry deleted']);
        }

        return response()->json(['message' => 'Problem deleting Entry'], 404);
    }
}
