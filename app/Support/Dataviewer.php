<?php
/**
 * Created by PhpStorm.
 * User: paprika
 * Date: 2018/5/23
 * Time: 下午11:51
 */

namespace App\Support;

trait Dataviewer {
    public function scopeAdvancedFilter($query) {
        return $this->process($query,request()->all())
                    ->orderBy(
                        request('order_column','created_at'),
                        request('order_direction','desc')
                    )
                    ->paginate(request('limit',10));
    }
    public function process($query,$data) {
        return $query;
    }
}