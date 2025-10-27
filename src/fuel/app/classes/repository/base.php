<?php

abstract class Repository_Base
{
    protected $model;

    /**
     * Contructor
     */
    public function __construct()
    {
        $this->setModel();
    }

    abstract function get_model();

    public function setModel()
    {
        $model = $this->get_model();
        if (!class_exists($model)) {
            throw new \Exception("Model class {$model} does not existed.");
        }
        $this->model = $model;
    }

    /**
     * Find a record by the options
     * @param  array  $options Options (e.g., related, where)
     * @return Model|null
     */
    public function find_by_options(array $options)
    {
        $query = $this->query();

        if (!empty($options['where'])) {
            foreach ($options['where'] as $condition) {
                $query->where($condition);
            }
        }

        if (!empty($options['related'])) {
            $query->related($options['related']);
        }

        return $query->get_one();
    }

    /**
     * Retrieve all records
     * @param  array  $options Options (e.g., where, order_by)
     * @return Model[]
     */
    public function find_all(array $options = [])
    {
        $query = $this->query();

        if (!empty($options['where'])) {
            foreach ($options['where'] as $condition) {
                $query->where($condition);
            }
        }

        if (!empty($options['order_by'])) {
            $query->order_by($options['order_by']);
        }

        if (!empty($options['related'])) {
            $query->related($options['related']);
        }

        return $query->get();
    }

    /**
     * Create a new record
     * @param  array  $data Data to create the record
     * @return Model
     * @throws \Exception
     */
    public function create(array $data)
    {
        $instance = $this->model::forge()->set($data);
        $model = $instance->save();
        if ($model) {
            return $instance;
        }
        throw new \Exception('Unable to create record.');
    }

    /**
     * Update a record
     * @param  mixed  $id The ID of the record
     * @param  array  $data Data to update
     * @return Model
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        $instance = $this->find_by_options([
            'where' => [
                ['id', '=', $id]
            ]
        ]);

        if (!$instance) {
            throw new \Exception('Record not found.');
        }

        foreach ($data as $key => $value) {
            $instance->{$key} = $value;
        }

        if ($instance->save()) {
            return $instance;
        }
        throw new \Exception('Unable to update record.');
    }

    /**
     * Delete a record
     * @param  mixed  $id The ID of the record
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        $instance = $this->find($id);
        if (!$instance) {
            throw new \Exception('Record not found.');
        }

        return $instance->delete();
    }

    /**
     * Get query builder for custom queries
     * @return \Orm\Query
     */
    public function query()
    {
        return $this->model::query();
    }
}
