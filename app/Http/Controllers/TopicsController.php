<?php

namespace App\Http\Controllers;

use App\Title;
use App\Post;
use App\Http\Requests\StoreTopicRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateTopicRequest;
use App\Transformers\TitleTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Policies\TopicPolicy;
class TopicsController extends Controller
{
    public function index()
    {
        $topic = Title::paginate(3);
        $topicCollection  = $topic->getCollection();

        return fractal()
        ->collection($topicCollection)->parseIncludes(['user'])->transformWith(new TitleTransformer)
        ->paginateWith(new IlluminatePaginatorAdapter($topic))->toArray();
    }

    public function show(Title $topic)
    {
        return fractal()
        ->item($topic)->parseIncludes(['user','posts','post.user'])->transformWith(new TitleTransformer)->toArray();
    }

    public function store(StoreTopicRequest $request)
    {
        $topic  = new Title;
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        $topic->posts()->save($post);

        return fractal()
            ->item($topic)->parseIncludes(['user','post'])->transformWith(new TitleTransformer)->toArray();
    }

    public function update(UpdateTopicRequest $request , Title $topic)
    {
        $this->authorize('update',$topic);

        $topic->title = $request->get('title',$topic->title);

        $topic->save();

        return fractal()
        ->item($topic)->parseIncludes(['user'])->transformWith(new TitleTransformer)->toArray();
    }
    public function destroy(Title $topic)
    {
        $this->authorize('destroy',$topic);

        $topic->delete();

        return response(null,204);
    }
}
