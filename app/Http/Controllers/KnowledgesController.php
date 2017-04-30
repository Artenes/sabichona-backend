<?php

namespace Sabichona\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sabichona\Http\Requests\StoreKnowledgeRequest;
use Sabichona\Http\Responses\KnowledgeSearchResponse;
use Sabichona\Models\Knowledge;

/**
 * Controller that manages knowledges.
 * @package Sabichona\Http\Controllers
 */
class KnowledgesController extends Controller
{

    /**
     * Shows the content of a knowledge.
     *
     * @param Knowledge $knowledge
     * @return array
     */
    public function show(Knowledge $knowledge)
    {

        return [

            'status' => true,
            'message' => 'Here, have a knowledge.',
            'data' => [
                'url' => $knowledge->url(),
                'content' => $knowledge->content,
            ],

        ];

    }

    /**
     * Store a knowledge.
     *
     * @param StoreKnowledgeRequest $request
     * @return array
     */
    public function store(StoreKnowledgeRequest $request)
    {

        $knowledge = Knowledge::create(['content' => $request->get('content')]);

        return [

            'status' => true,
            'message' => 'You have shown me your knowledge',
            'data' => [
                'id' => $knowledge->id,
                'url' => $knowledge->url(),
            ],

        ];

    }

    /**
     * Search for knowledges.
     *
     * @param Request $request
     * @param KnowledgeSearchResponse $response
     * @return JsonResponse
     */
    public function search(Request $request, KnowledgeSearchResponse $response)
    {

        $location = $request->route('location');
        $search = $request->get('search');

        if (!Knowledge::isThereSomethingAt($location))
            return $response->thereIsNothingInThisLocation();

        if (empty($search))
            return $response->randomKnowledge(Knowledge::random($location));

        $results = Knowledge::search($location, $search);

        if ($results->count() === 0)
            return $response->foundNothing();

        return $response->foundSomething($results, $search);

    }

}