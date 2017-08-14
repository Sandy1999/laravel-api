<?php 

namespace App\Transformers;

use App\Title;

class TitleTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['user','post'];

    public function transform(Title $title)
    {
        return [
            'id'=>$title->id,
            'title'=> $title->title,
            'created_at'=>$title->created_at->toDateTimeString(),
            'created_at_humans'=>$title->created_at->diffForHumans()
        ];
    }
    public function includeUser(Title $title)
    {
        return $this->item($title->user, new UserTransformer);
    }

    public function includePost(Title $title)
    {
        return $this->collection($title->posts, new PostsTransformer);
    }
}