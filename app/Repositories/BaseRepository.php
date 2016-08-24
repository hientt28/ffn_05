<?php
/**
 * Base Repository
 */

namespace App\Repositories;

use Exception;
use DB;

abstract class BaseRepository implements BaseRepositoryInterface
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

    public function count()
    {
        return $this->loadWhere()->count();
    }

    public function all()
    {
        return $this->loadWhere()->orderBys()->all();
    }

    function loadWhere()
    {
        foreach ($this->where as $where)
        {
            $this->model->where($where);
        }
        foreach ($this->orWhere as $where)
        {
            $this->model->orWhere($where);
        }
        foreach ($this->inWhere as $where)
        {
            $this->model->inWhere($where);
        }

        return $this;
    }

    function orderBys()
    {
        foreach($this->orderBy as $orders)
        {
            $this->model->orderBy($orders['column'], $orders['direction']);
        }

        return $this;
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
        return $this->loadWhere()->orderBys()->paginate($limit);
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
        return $this->loadWhere()->orderBys()->lists($column, $key);
    }

    public function where($column, $value = null, $operator = null)
    {
        $this->where[] = compact('column', 'value', 'operator');

        return $this;
    }

    public function whereIn($column, $values)
    {
        $values = is_array($values) ? $values : array($values);
        $this->whereIn[] = compact('column', 'values');

        return $this;
    }

    public function orWhere($column, $operator = null, $value = null)
    {
        $this->orWhere[] = compact('column', 'value', 'operator');

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
