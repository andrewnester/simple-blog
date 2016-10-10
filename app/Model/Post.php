<?php

namespace App\Model;

use Nester\Model;

class Post extends Model
{
    public function tableName()
    {
        return 'posts';
    }

    public function insert()
    {
        $this->setAttribute('created', date('Y-m-d H:i:s'));
        $this->setAttribute('updated', date('Y-m-d H:i:s'));

        $sql = 'INSERT INTO ' . $this->tableName() . '(title, body, created, updated) VALUES (?, ?, ?, ?)';
        $stmt = $this->getDb()->prepare($sql);
        $stmt->bindValue(1, $this->getAttribute('title'));
        $stmt->bindValue(2, $this->getAttribute('body'));
        $stmt->bindValue(3, $this->getAttribute('created'));
        $stmt->bindValue(4, $this->getAttribute('updated'));
        $stmt->execute();
    }

    public function update()
    {
        $this->setAttribute('updated', date('Y-m-d H:i:s'));

        $sql = 'UPDATE ' . $this->tableName() . ' SET title=?, body=?, updated=? WHERE id = ?';
        $stmt = $this->getDb()->prepare($sql);
        $stmt->bindValue(1, $this->getAttribute('title'));
        $stmt->bindValue(2, $this->getAttribute('body'));
        $stmt->bindValue(3, $this->getAttribute('updated'));
        $stmt->bindValue(4, $this->getAttribute('id'));
        $stmt->execute();
    }

    /**
     * Finds model by ID.
     *
     * @param int $id
     * @return null|static
     */
    public function findById($id)
    {
        $sql = 'SELECT * FROM ' . $this->tableName() . ' WHERE id = ?';
        $stmt = $this->getDb()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $model = new static($this->getDb());
        $model->setAttributes($row);
        return $model;
    }

    /**
     * Deletes model by id.
     *
     * @param $id
     */
    public function deleteById($id)
    {
        $sql = 'DELETE FROM ' . $this->tableName() . ' WHERE id = ?';
        $stmt = $this->getDb()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}
