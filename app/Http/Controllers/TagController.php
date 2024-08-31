<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use App\Http\Resources\TagResource;



class TagController extends Controller
{

    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @OA\Post(
     *     path="api/tag",
     *     summary="get all tags",
     *     description="this endpoint return a json of all tags.",
     *     tags={"tag"},
     *    
     *     
     *     @OA\Response(
     *         response=200,
     *         description="Data has been saved and dispatched to the proper channel.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/TagResource")
     *         )
     *     ),
     *     
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */

    public function index()
    {
        // get all tags
        $tags = $this->tagService->getAllTags();
        return TagResource::collection($tags)->additional([
            'status' => 'success', // or any other status you want to append
        ]);
    }
}
