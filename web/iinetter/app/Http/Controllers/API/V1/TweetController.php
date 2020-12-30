<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\CreateTweetRequest;
use App\Models\Tweet;
use App\Repositories\TweetRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Gate;
use Response;

/**
 * Class TweetController
 * @package App\Http\Controllers\API\V1
 */

class TweetController extends AppBaseController
{
    /** @var  TweetRepository */
    private $tweetRepository;

    public function __construct(TweetRepository $tweetRepo)
    {
        $this->tweetRepository = $tweetRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/tweets",
     *      summary="Get a listing of the Tweets.",
     *      tags={"Tweet"},
     *      description="Get all Tweets",
     *      produces={"application/json"},
     *      security={{"apiToken":{}}},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Tweet")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $userId = auth('api')->id();

        $tweets = $this->tweetRepository->fetchAllByUserId($userId);

        return $this->sendResponse($tweets->toArray(), 'Tweets retrieved successfully');
    }

    /**
     * @param CreateTweetRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/tweets",
     *      summary="Store a newly created Tweet in storage",
     *      tags={"Tweet"},
     *      description="Store Tweet",
     *      produces={"application/json"},
     *      security={{"apiToken":{}}},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tweet that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tweet")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Tweet"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTweetRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth('api')->id();

        $tweet = $this->tweetRepository->create($input);

        return $this->sendResponse($tweet->toArray(), 'Tweet saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/tweets/{id}",
     *      summary="Remove the specified Tweet from storage",
     *      tags={"Tweet"},
     *      description="Delete Tweet",
     *      produces={"application/json"},
     *      security={{"apiToken":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tweet",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Tweet $tweet */
        $tweet = $this->tweetRepository->find($id);

        if (empty($tweet)) {
            return $this->sendError('Tweet not found');
        }

        Gate::authorize('delete', $tweet);

        $tweet->delete();

        return $this->sendSuccess('Tweet deleted successfully');
    }
}