<?php

namespace App\Transformers;

use App\Post;

class PostsTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['user'];
    public function transform(Post $post)
    {
        return [
            'id'=>$post->id,
            'body'=>$post->id,
            'created_at'=>$post->created_at->toDateTimeString(),
            'created_at_human'=>$post->created_at->diffForHumans(),
            'title'=>$post->title->title
        ];
    }

    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer);
    }
}