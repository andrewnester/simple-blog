<?php

namespace Nester;

/**
 * Class Model
 *
 * Basic model class.
 *
 * @package Nester
 */
abstract class Model
{
    /**
     * PDO object to access db.
     *
     * @var \PDO
     */
    private $db;

    /**
     * Model attributes
     *
     * @var array
     */
    private $attributes = [];

    /**
     * Model constructor.
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Table name Model represents.
     *
     * @return string
     */
    abstract public function tableName();

    /**
     * Insert new model in DB
     *
     * @return mixed
     */
    abstract public function insert();

    /**
     * Saves existing model in DB.
     *
     * @return mixed
     */
    abstract public function update();

    public function findAll()
    {
        $sql = 'SELECT * FROM ' . $this->tableName();
        $stmt = $this->db->query($sql);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->mapResults($result);

    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Sets named attribute for model.
     *
     * @param string $name
     * @param mixed $value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Returns all model attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Returns model attribute
     *
     * @param $name
     * @return mixed
     * @throws \RuntimeException
     */
    public function getAttribute($name)
    {
        if (!array_key_exists($name, $this->attributes)) {
            throw new \RuntimeException('There is no attribute ' . $name . ' in model ' . get_called_class());
        }

        return $this->attributes[$name];
    }

    /**
     * Map rows to real Model instances.
     *
     * @param array $result
     * @return Model[]
     */
    private function mapResults(array $result)
    {
        return array_map(function($row) {
            $model = new static($this->db);
            $model->setAttributes($row);
            return $model;
        }, $result);
    }

    /**
     * Returns DB instance.
     *
     * @return \PDO
     */
    protected function getDb()
    {
        return $this->db;
    }
}
