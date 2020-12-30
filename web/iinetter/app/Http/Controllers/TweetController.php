<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTweetRequest;
use App\Http\Requests\UpdateTweetRequest;
use App\Repositories\TweetRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class TweetController extends AppBaseController
{
    /** @var  TweetRepository */
    private $tweetRepository;

    public function __construct(TweetRepository $tweetRepo)
    {
        $this->tweetRepository = $tweetRepo;
    }

    /**
     * Display a listing of the Tweet.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $tweets = $this->tweetRepository->all();

        return view('tweets.index')
            ->with('tweets', $tweets);
    }

    /**
     * Show the form for creating a new Tweet.
     *
     * @return Response
     */
    public function create()
    {
        return view('tweets.create');
    }

    /**
     * Store a newly created Tweet in storage.
     *
     * @param CreateTweetRequest $request
     *
     * @return Response
     */
    public function store(CreateTweetRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth('web')->id();

        $tweet = $this->tweetRepository->create($input);

        Flash::success('Tweet saved successfully.');

        return redirect(route('tweets.index'));
    }

    /**
     * Display the specified Tweet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tweet = $this->tweetRepository->find($id);

        if (empty($tweet)) {
            Flash::error('Tweet not found');

            return redirect(route('tweets.index'));
        }

        return view('tweets.show')->with('tweet', $tweet);
    }

    /**
     * Show the form for editing the specified Tweet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tweet = $this->tweetRepository->find($id);

        if (empty($tweet)) {
            Flash::error('Tweet not found');

            return redirect(route('tweets.index'));
        }

        return view('tweets.edit')->with('tweet', $tweet);
    }

    /**
     * Update the specified Tweet in storage.
     *
     * @param int $id
     * @param UpdateTweetRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTweetRequest $request)
    {
        $tweet = $this->tweetRepository->find($id);

        if (empty($tweet)) {
            Flash::error('Tweet not found');

            return redirect(route('tweets.index'));
        }

        $tweet = $this->tweetRepository->update($request->all(), $id);

        Flash::success('Tweet updated successfully.');

        return redirect(route('tweets.index'));
    }

    /**
     * Remove the specified Tweet from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tweet = $this->tweetRepository->find($id);

        if (empty($tweet)) {
            Flash::error('Tweet not found');

            return redirect(route('tweets.index'));
        }

        $this->tweetRepository->delete($id);

        Flash::success('Tweet deleted successfully.');

        return redirect(route('tweets.index'));
    }
}
