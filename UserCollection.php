<?php

class UserCollection extends Db
{
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
        $db = new Db();
        $sql = 'SELECT * FROM `' . self::TABLE . '` WHERE `' . self::TABLE . '`.`id` IN (' . implode(',', $ids) . ')';
        $data = $db->query($sql, []);
        return self::setCollection($data);
    }

    /**
     * @throws Exception
     */
    public static function loadAll()
    {
        $db = new Db();
        $data = $db->query('SELECT * FROM `' . self::TABLE . '`', []);
        return self::setCollection($data);
    }

    /**
     * @throws Exception
     */
    public static function where($name, $action, $value)
    {
        $db = new Db();
        $sql = 'SELECT * FROM `' . self::TABLE . '` WHERE ' . $name . $action .':'.$name;
        $data = $db->query($sql, [':'.$name => $value]);
        return self::setCollection($data);
    }
}