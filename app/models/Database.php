<?php


namespace App\models;


use Aura\SqlQuery\QueryFactory;
use PDO;

class Database
{
    /**
     * @var QueryFactory
     */
    private $queryFactory;
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(QueryFactory $queryFactory, PDO $pdo)
    {

        $this->queryFactory = $queryFactory;
        $this->pdo = $pdo;
    }

    public function all($table, $limit = null)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
                ->from($table)
                ->limit($limit);

        // prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());

        // bind the values and execute
        $sth->execute($select->getBindValues());

        // get the results back as an associative array
        return  $sth->fetchAll(PDO::FETCH_ASSOC);
    }


    public function find($table, $id)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
                ->from($table)
                ->where('id = :id')
                ->bindValue('id', $id);

        // prepare the statment
        $sth = $this->pdo->prepare($select->getStatement());

        // bind the values and execute
        $sth->execute($select->getBindValues());

        // get the results back as an associative array
        return $result = $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $id)
    {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)                  // update this table
            ->cols($data)
            ->where('id = :id')           // AND WHERE these conditions
            ->bindValue('id', $id);   // bind one value to a placeholder;
        // prepare the statement
        $sth = $this->pdo->prepare($update->getStatement());

        // execute with bound values
        $sth->execute($update->getBindValues());
    }

    public function create($data)
    {
        $insert = $this->queryFactory->newInsert();

        $insert
            ->into('photos')                   // INTO this table
            ->cols($data);

        // prepare the statement
        $sth = $this->pdo->prepare($insert->getStatement());

        // execute with bound values
        $result = $sth->execute($insert->getBindValues());

        // get the last insert ID
        $name = $insert->getLastInsertIdName('id');
        $id = $this->pdo->lastInsertId($name);
        return $result;
    }

    public function whereAll($table, $row, $id, $limit = 4)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->limit($limit)
            ->where("$row = :row")
            ->bindValue(":row", $id);
        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaginateFrom($table, $row, $id, $page, $rows)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
                ->from($table)
                ->where("$row = :row")
                ->bindValue(":row", $id)
                ->page($page)
                ->setPaging($rows);
        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getCount($table, $row, $id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])
            ->from($table)
            ->where("$row = :row")
            ->bindValue(":row", $id);
        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return count($sth->fetchAll(PDO::FETCH_ASSOC));
    }
}