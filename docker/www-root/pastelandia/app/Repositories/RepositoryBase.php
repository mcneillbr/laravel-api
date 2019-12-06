<?php
/**
* Abstract Class Base Repository
*
*
*/

namespace App\Repositories;


use \Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model as EloquentModel;


abstract class RepositoryBase {


    /**
     * @var Exception|object|null
     */
    protected $lastError = null;

    /**
     * @var RepositoryBase
     */
    protected static $instance = null;

    /**
     * RepositoryBase constructor.
     */
    abstract protected function __construct();

    /**
     * Returns Instance class
     *
     * @return RepositoryBase
     */
    abstract public static function getInstance();

    /**
     * Execute the query and get the first result
     *
     * @param  mixed  $id
     * @return object|Arrayable|array
     */
    abstract public function getById($id);


    /**
     * @param \Closure|string|array  $column
     * @return Arrayable|array|Collection
     */
    abstract public function find($column);

    /**
     * Execute the query and get the result
     *
     * @return Arrayable|array|Collection
     */
    abstract public function all();

    /**
     * Create and return an un-saved model instance.
     *
     * @param array $fields
     * @return Arrayable|array|Collection
     */
    abstract public function create(array $fields = []);


    /**
     * Update a record in the database.
     *
     * @param mixed $search
     * @param array $fields
     * @return int
     */
    abstract public function update($search, array $fields = []);

    /**
     * Delete a record from the database.
     *
     * @param mixed $search
     * @param array $fields
     * @return int
     */
    abstract public function delete($search, array $fields = []);

    /**
     * Returns Query Builder form model class
     *
     * @param string|object $model
     * @return Illuminate\Database\Eloquent\Builder
     * @throws Exception
     */
    protected function getQueryBuilder($model) {
        $isParentModelClass = is_subclass_of($model, EloquentModel::class);
        if($isParentModelClass && is_object($model)) {
            return $model->forNestedWhere();
        } else if( $isParentModelClass ) {
           return call_user_func($model . '::forNestedWhere');
       }
       throw new Exception("the class $model is not as one of its parents or implements it", 4214);

    }

    /**
     * Returns last error exception
     *
     * @return Exception|object|null
     */
    public function getLastError() {
        return $this->lastError;
    }

    /**
     * Convert model to object
     *
     * @param EloquentModel $model
     * @return object|null
     */
    protected function modelToObject(EloquentModel $model) {
        if(!$model) {
            return null;
        }
        return (object) $model->toArray();
    }

    /**
     * Convert model collection for object collection
     *
     * @param iterable $models
     * @return \Illuminate\Support\Collection
     */
    protected function modelsToCollection(iterable $models) {
        $m = [];
        foreach ($models as $model) {
            array_push($m, $this->modelToObject($model));
        }
        return collect($m);
    }



}
