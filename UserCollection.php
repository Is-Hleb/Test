<?php

class UserCollection
{
    use Db;
    const TABLE = 'users';

    /**
     * @throws Exception
     */
    private static function setCollection($data)
    {
        $export = [];
        foreach ($data as $userData) {
            $export[$userData['id']] = new User($userData);
        }
        return $export;
    }


    /**
     * @throws Exception
     */
    public static function loadByIds($ids)
    {
        $sql = 'SELECT * FROM `' . self::TABLE . '` WHERE `' . self::TABLE . '`.`id` IN (' . implode(',', $ids) . ')';
        $data = (new UserCollection)->query($sql, []);
        return self::setCollection($data);
    }

    /**
     * @throws Exception
     */
    public static function loadAll()
    {
        $data = (new UserCollection)->query('SELECT * FROM `' . self::TABLE . '`', []);
        return self::setCollection($data);
    }

    /**
     * @throws Exception
     */
    public static function where($name, $action, $value)
    {
        $sql = 'SELECT * FROM `' . self::TABLE . '` WHERE ' . $name . $action .':'.$name;
        $data = (new UserCollection)->query($sql, [':'.$name => $value]);
        return self::setCollection($data);
    }
}