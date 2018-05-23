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
    public function notEqualTo($filter,$query) {
        return $query->where($filter['column'],'<>',$filter['query_1'],$filter['match']);
    }
    public function lessThan($filter,$query) {
        return $query->where($filter['column'],'<',$filter['query_1'],$filter['match']);
    }
    public function greaterThan($filter,$query) {
        return $query->where($filter['column'],'>',$filter['query_1'],$filter['match']);
    }
    public function between($filter,$query) {
        return $query->whereBetween($filter['column'],[
            $filter['query_1'],$filter['query_2']
        ],$filter['match']);
    }
    public function notBetween($filter,$query) {
        return $query->whereNotBetween($filter['column'],[
            $filter['query_1'],$filter['query_2']
        ],$filter['match']);
    }
    public function startsWith($filter,$query) {
        return $query->where($filter['column'],'like', $filter['query_1'].'%', $filter['match']);
    }
    public function endsWith($filter,$query) {
        return $query->where($filter['column'],'like', '%'.$filter['query_1'], $filter['match']);
    }
    public function contains($filter,$query) {
        return $query->where($filter['column'],'like','%'.$filter['query_1'].'%', $filter['match']);
    }
    public function inThePast($filter,$query) {
        $end = now()->endOfDay();
        $begin = now();
        switch ($filter['query_2']) {
            case 'hours':
                $begin->subHours($filter['query_1']);
                break;
            case 'days':
                $begin->subDays($filter['query_1'])->startOfDay();
                break;
            case 'months':
                $begin->subMonths($filter['query_1'])->startOfDay();
                break;
            case 'years':
                $begin->subYears($filter['query_1'])->startOfDay();
                break;
            default:
                $begin->subDays($filter['query_1'])->startOfDay();
        }
        return $query->whereBetween($filter['column'],[$begin,$end],$filter['match']);
    }

}