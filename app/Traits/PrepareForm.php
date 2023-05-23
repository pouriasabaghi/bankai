<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait PrepareForm
{
    protected function attributes(?Model $model = null): array
    {
        if ($model) {
            $action = route($this->actionRoute($model), $model->id);
            $method = 'PUT';
            $form = 'update';
            $isUpdate = true;
        } else {
            $action = route($this->actionRoute());
            $method = 'POST';
            $form = 'store';
            $isUpdate = false;
        }

        return compact('action', 'method', 'form', 'isUpdate');
    }

    abstract protected function actionRoute(?Model $model = null);
}
