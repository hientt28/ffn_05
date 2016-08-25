<?php
/**
 * Base Repository
 */

namespace App\Repositories;

use Exception;
use DB;

abstract class EloquentRepository implements RepositoryInterface
{
    protected $model;
    protected $where = [];
    protected $orWhere = [];
    protected $whereIn = [];
    protected $orderBy = [];

    /**
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    private function newQuery()
    {
        $this->model = $this->model->newQuery();

        return $this;
    }

    public function count()
    {
        $this->newQuery()->loadWhere();

        return $this->model->count();
    }

    public function all()
    {
        $this->newQuery()->loadWhere()->orderBys();

        return $this->model->get();
    }

    function loadWhere()
    {
        foreach ($this->where as $where) {
            $this->model->where($where[0], $where[1], $where[2]);
        }
        foreach ($this->orWhere as $where) {
            $this->model->orWhere($where[0], $where[1], $where[2]);
        }
        foreach ($this->whereIn as $where) {
            $this->model->whereIn($where);
        }

        return $this;
    }

    function orderBys()
    {
        foreach ($this->orderBy as $orders) {
            $this->model->orderBy($orders['column'], $orders['direction']);
        }

        return $this;
    }

    public function deleteAll()
    {
        $this->newQuery()->loadWhere();

        return $this->model->delete();
    }

    public function find($id)
    {
        $data = $this->model->find($id);
        if (!$data) {
            throw new Exception(trans('message.find_error'));
        }

        return $data;
    }

    public function findBy($attribute, $value, $columns = ['*'])
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function paginate($limit)
    {
        $this->newQuery()->loadWhere()->orderBys();

        return $this->model->paginate($limit);
    }

    public function create($inputs)
    {
        $data = $this->model->create($inputs);
        if (!$data) {
            throw new Exception(trans('message.create_error'));
        }

        return $data;
    }

    public function update($inputs, $id)
    {
        $data = $this->model->where('id', $id)->update($inputs);
        if (!$data) {
            throw new Exception(trans('message.update_error'));
        }

        return $data;
    }

    public function delete($ids)
    {
        DB::beginTransaction();
        try {
            $data = $this->model->destroy($ids);
            if (!$data) {
                throw new Exception(trans('message.delete_error'));
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $data;
    }

    public function lists($column, $key = null)
    {
        $this->newQuery()->loadWhere()->orderBys();

        return $this->model->lists($column, $key);
    }

    public function where($conditions, $operator = null, $value = null)
    {
        if (func_get_args() == 2) {
            list($value, $operator) = [$operator, '='];
        }

        $this->where[] = [$conditions, $operator, $value];

        return $this;
    }

    public function whereIn($column, $values)
    {
        $values = is_array($values) ? $values : array($values);
        $this->whereIn[] = compact('column', 'values');

        return $this;
    }

    public function orWhere($conditions, $operator = null, $value = null)
    {
        if (func_get_args() == 2) {
            list($value, $operator) = [$operator, '='];
        }

        $this->where[] = [$conditions, $operator, $value];

        return $this;
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->orderBy[] = compact('column', 'direction');

        return $this;
    }

    public function save(array $data, $exist_field = 'id')
    {
        $this->model->unguard();
        $model = $this->model->fill($data);
        $model->exists = $data[$exist_field];
        $this->model->reguard();

        return $model->save();
    }
}
