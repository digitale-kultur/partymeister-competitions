<?php

namespace Partymeister\Competitions\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Partymeister\Competitions\Http\Requests\Backend\CompetitionRequest;
use Partymeister\Competitions\Http\Resources\CompetitionCollection;
use Partymeister\Competitions\Http\Resources\CompetitionResource;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Services\CompetitionService;
use Illuminate\Support\Arr;
use Motor\Backend\Models\Permission;
use Partymeister\Competitions\Models\LiveVote;

/**
 * Class CompetitionsController
 *
 * @package Partymeister\Competitions\Http\Controllers\Api
 */
class CompetitionsController extends ApiController
{
    protected string $model = 'Partymeister\Competitions\Models\Competition';

    protected string $modelResource = 'competition';

    /**
     * @OA\Get (
     *   tags={"CompetitionsController"},
     *   path="/api/competitions",
     *   summary="Get competition collection",
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
     *         @OA\Items(ref="#/components/schemas/CompetitionResource")
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
     * @return CompetitionCollection
     */
    public function index()
    {
        $paginator = CompetitionService::collection()
                                       ->getPaginator();

        return (new CompetitionCollection($paginator))->additional(['message' => 'Competition collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"CompetitionsController"},
     *   path="/api/competitions",
     *   summary="Create new competition",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/CompetitionRequest")
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
     *         ref="#/components/schemas/CompetitionResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Competition created"
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
     * @param CompetitionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CompetitionRequest $request)
    {
        $result = CompetitionService::create($request)
                                    ->getResult();

        return (new CompetitionResource($result))->additional(['message' => 'Competition created'])
                                                 ->response()
                                                 ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"CompetitionsController"},
     *   path="/api/competitions/{competition}",
     *   summary="Get single competition",
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
     *     name="competition",
     *     parameter="competition",
     *     description="Competition id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/CompetitionResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Competition read"
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
     * @param Competition $record
     * @return CompetitionResource
     */
    public function show(Competition $record)
    {
        $result = CompetitionService::show($record)
                                    ->getResult();

        return (new CompetitionResource($result))->additional(['message' => 'Competition read']);
    }

    /**
     * @OA\Put (
     *   tags={"CompetitionsController"},
     *   path="/api/competitions/{competition}",
     *   summary="Update an existing competition",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/CompetitionRequest")
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
     *     name="competition",
     *     parameter="competition",
     *     description="Competition id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/CompetitionResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Competition updated"
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
     * @param CompetitionRequest $request
     * @param Competition $record
     * @return CompetitionResource
     */
    public function update(CompetitionRequest $request, Competition $record)
    {
        $result = CompetitionService::update($record, $request)
                                    ->getResult();

	    foreach (LiveVote::all() as $liveVote) {
		    $liveVote->delete();
	    }
        return (new CompetitionResource($result))->additional(['message' => 'Competition updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"CompetitionsController"},
     *   path="/api/competitions/{competition}",
     *   summary="Delete a competition",
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
     *     name="competition",
     *     parameter="competition",
     *     description="Competition id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Competition deleted"
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
     *         example="Problem deleting competition"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param Competition $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Competition $record)
    {
        $result = CompetitionService::delete($record)
                                    ->getResult();

        if ($result) {
            return response()->json(['message' => 'Competition deleted']);
        }

        return response()->json(['message' => 'Problem deleting Competition'], 404);
    }
}
