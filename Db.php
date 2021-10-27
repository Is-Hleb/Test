<?php


class Db
{
    private $dbh;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $config = (include __DIR__ . '/config.php')['db'];
        $config['host'] .= ':' . $config['port'];
        try {
            $this->dbh = new \PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['user'], $config['password']);
        } catch (\PDOException $err) {
            throw new Exception('Не удалось подключиться');
        }
    }


    protected function execute($sql, $data = [])
    {
        $sth = $this->dbh->prepare($sql);
        return $sth->execute($data);
    }

    protected function getLastId()
    {
        return $this->dbh->lastInsertId();
    }

    /**
     * @throws Exception
     */
    protected function query($sql, $data)
    {
        $sth = $this->dbh->prepare($sql);
        $res = $sth->execute($data);
        if(!$res){
            throw new Exception('Запрос не может быть выполнен');
        }
        return $sth->fetchAll();
    }

}