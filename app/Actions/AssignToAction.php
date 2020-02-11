<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class AssignToAction extends AbstractAction {
    public function getTitle() {
        return ' Assign To';
    }

    public function getIcon() {
        return 'voyager-pen';
    }

    public function getPolicy() {
        return 'read';
    }

    public function getAttributes() {
        return [
            'class' => 'btn btn-sm btn-primary pull-right',
        ];
    }

    public function getDefaultRoute() {
        return ('/admin/posts/'.$this->data->id.'/assign');
    }

    public function shouldActionDisplayOnDataType() {
        return $this->dataType->slug == 'posts';
    }

}