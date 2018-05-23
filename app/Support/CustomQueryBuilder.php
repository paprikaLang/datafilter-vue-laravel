<?php
/**
 * Created by PhpStorm.
 * User: paprika
 * Date: 2018/5/24
 * Time: 上午1:28
 */

namespace App\Support;

class CustomQueryBuilder {
    public function apply($query,$data) {
        if (isset($data['f'])) {
            foreach ($data['f'] as $filter) {
                $filter['match'] = isset($data['filter_match']) ? $ $data['filter_match'] : 'and';
                $this->makeFilter($query,$filter);
            }
        }
        return $query;
    }
    public function makeFilter($query,$filter) {
        $this->{camel_case($filter['operator'])}($filter,$query);
    }
    public function equalTo($filter,$query) {
        return $query->where($filter['column'],'=',$filter['query_1'],$filter['match']);
    }
}