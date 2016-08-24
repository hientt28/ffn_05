<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function count();

    public function all();

    public function find($id);

    public function findBy($attribute, $value, $columns = ['*']);

    public function paginate($limit);

    public function create($inputs);

    public function update($inputs, $id);

    public function delete($ids);

    public function lists($column, $key = null);

    public function where($column, $value = null, $operator = null);

    public function whereIn($column, $values);

    public function orWhere($column, $operator = null, $value = null);

    public function orderBy($column, $direction = 'asc');

    public function save(array $data, $exist_field = 'id');
}
