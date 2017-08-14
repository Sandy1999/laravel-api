<?php

namespace App\Http\Controllers;
use App\Title;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Transformers\PostsTransformer;
use App\Policies\PostPolicy;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class PostsController extends Controller
{
    public function index()
    {
        $post = Post::paginate(3);
        $postCollection = $post->getCollection();
        
        // return response()->json($post);
        return fractal()
        ->collection($postCollection)->parseIncludes(['user'])->transformWith(new PostsTransformer)
        ->paginateWith(new IlluminatePaginatorAdapter($post))->toArray();
    }
    Public function show(Title $topic , Post $post)
    {
        // $haspost = Title::hasPosts($topic,$post);
        // if($haspost)
        // {
        //     dd($post);
        // }
        // else{
        //     return response(null,204);
        // }
        return fractal()
        ->item($post)->parseIncludes(['user'])->transformWith(new PostsTransformer)->toArray();
    }

    public function store(StorePostRequest $request, Title $topic)
    {
        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());
        // dd($post);
        $topic->posts()->save($post);

        return fractal()
        ->item($post)->parseIncludes(['user'])->transformWith(new PostsTransformer)->toArray(); 
    }

    public function update(UpdatePostRequest $request,Post $post)
    {
        $this->authorize('update',$post);

        $post->body = $request->get('body',$post->body);
        $post->save();

        return fractal()
        ->item($post)->parseIncludes(['user'])->transformWith(new PostsTransformer)->toArray();
    }

    public function destroy(Post $post)
    {
        $this->authorize('destroy',$post);

         $post->delete();

        return response(null,204);
    }
}
