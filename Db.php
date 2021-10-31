<?php


trait Db
{
    private $dbh;

    /**
     * @throws Exception
     */
    private function dbConstruct()
    {
        $config = (include __DIR__ . '/config.php')['db'];
        $config['host'] .= ':' . $config['port'];
        try {
            $this->dbh = new \PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['user'], $config['password']);
        } catch (\PDOException $err) {
            throw new Exception('Не удалось подключиться');
        }
    }


    /**
     * @throws Exception
     */
    protected function execute($sql, $data = [])
    {
        $this->dbConstruct();
        $sth = $this->dbh->prepare($sql);
        return $sth->execute($data);
    }

    /**
     * @throws Exception
     */
    protected function getLastId()
    {
        $this->dbConstruct();
        return $this->dbh->lastInsertId();
    }

    /**
     * @throws Exception
     */
    protected function query($sql, $data)
    {
        $this->dbConstruct();
        $sth = $this->dbh->prepare($sql);
        $res = $sth->execute($data);
        if(!$res){
            throw new Exception('Запрос не может быть выполнен');
        }
        return $sth->fetchAll();
    }

}