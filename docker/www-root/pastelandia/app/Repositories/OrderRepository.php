<?php
/**
* Class Base Repository
*
*
*/

namespace App\Repositories;


use App\Order as OrderModel;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

class OrdemRepository extends RepositoryBase {

    /**
     * RepositoryBase constructor.
     */
    protected function __construct()
    {

    }

    /**
     * Returns Instance class
     *
     * @return ClientRepository
     */
    public static function getInstance()
    {
        if (null === RepositoryBase::$instance) {
            RepositoryBase::$instance = new static();
        }
        return RepositoryBase::$instance;
    }

    /**
     * Execute the query and get the first result
     *
     * @param mixed $id
     * @return object|Arrayable|array|null
     */
    public function getById($id)
    {
        $model = OrderModel::findOrFail($id);
        return $this->modelToObject($model);
    }

    /**
     * @param \Closure|string|array $column
     * @return Arrayable|array|Collection
     */
    public function find($column)
    {
        $models = OrderModel::where($column);
        return $this->modelsToCollection($models);
    }

    /**
     * Execute the query and get the result
     *
     * @return Arrayable|array|Collection
     */
    public function all()
    {
        return $this->modelsToCollection(OrderModel::all());
    }

    /**
     * Create and return an un-saved model instance.
     *
     * @param array $fields
     * @return object|null
     */
    public function create(array $fields = [])
    {
        try {
            $this->lastError = null;
            $model = OrderModel::create($fields);
            return $this->modelToObject($model);
        } catch (Exception $e) {
            $this->lastError = $e;
        }
        return null;
    }

    /**
     * Update a record in the database.
     *
     * @param mixed $search
     * @param array $fields
     * @return int
     */
    public function update($search, array $fields = [])
    {
        if(count($fields) <= 0) {
            return 0;
        }
        try {
            $this->lastError = null;
            $result = OrderModel::where($search)->update($fields);
            return intval($result);

        } catch (Exception $e) {
            $this->lastError = $e;
        }

        return 0;
    }

    /**
     * Delete a record from the database.
     *
     * @param mixed $search
     * @param array $fields
     * @return int
     */
    public function delete($search, array $fields = [])
    {
        try {
            $this->lastError = null;
            $result = OrderModel::where($search)->delete();
            return intval($result);

        } catch (Exception $e) {
            $this->lastError = $e;
        }

        return 0;
    }
}
