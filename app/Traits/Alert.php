<?php

namespace App\Traits;



trait Alert
{
    protected static function successAlert($title = null, $text = null)
    {

        $title = $title ?? 'عملیات موفق';
        $text = $text ?? 'درخواست شما با موفقیت انجام شد';
        return alert()->success($title, $text)->showConfirmButton('باشه', '#1cbb8c')->autoClose(2000);
    }

    protected function exception (\Throwable $e)
    {
        if ($e->getCode() == 1) {
            alert()->error('', $e->getMessage())->showConfirmButton('باشه', '#7367f0')->autoClose(3500);
        }else{
            dd(['title'=>'خطایی رخ داده.','message'=>$e->getMessage(),'code'=>$e->getCode(), 'file'=>$e->getFile(),'line'=>$e->getLine()]);
        }

    }

}
