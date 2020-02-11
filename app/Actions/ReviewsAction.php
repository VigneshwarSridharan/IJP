<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;
use App\Review;

class ReviewsAction extends AbstractAction {

    public function getTitle() {
        $reviews = Review::where('post_id','=',$this->data->id)->get();
        return ' Reviews '.count($reviews->toArray());
    }

    public function getIcon() {
        return 'voyager-bubble';
    }

    public function getPolicy() {
        return 'read';
    }

    public function getAttributes() {
        $reviews = Review::where('post_id','=',$this->data->id)->get()->toArray();
        return [
            'class' => 'btn btn-sm btn-primary pull-right',
            'style' => count($reviews) != 0 ? '' : 'display: none'
        ];
    }

    public function getDefaultRoute() {
        return ('/admin/posts/'.$this->data->id.'/reviews');
    }

    public function shouldActionDisplayOnDataType() {
       
        return $this->dataType->slug == 'posts';
    }

}