<?php


class User
{
    use Db;

    const TABLE = 'users';
    const FIELDS = [
        'id',
        'name',
        'surname',
        'date_of_birth',
        'birth_city',
        'sex',
    ];

    private $data;


    public static function load($id)
    {
        $sql = 'SELECT * FROM `' . self::TABLE . '` WHERE id = ' . ':id';
        $executedData = (new User)->query($sql, ['id' => $id])[0];
        $userData = [];
        foreach (self::FIELDS as $key) {
            $userData[$key] = $executedData[$key];
        }
        return new User($userData);
    }

    public static function delete($id)
    {
        $sql = 'DELETE FROM `' . self::TABLE . '` WHERE id = ' . ':id';
        return (new User)->execute($sql, ['id' => $id]);
    }

    public static function getFormatSex(User $user)
    {
        return $user->sex ? 'муж' : 'жен';
    }

    public static function getAge(User $user)
    {
        $now = new DateTime();
        $date = DateTime::createFromFormat("Y-m-d", $user->date_of_birth);
        $interval = $now->diff($date);
        return $interval->y;
    }

    /**
     * Class constructor.
     *
     * @param array $data Array containing the necessary params.
     *    $anyKey => [
     *      'name'  => (string)
     *      'surname' => (string)
     *      'sex' => (bool)
     *      'date_of_birth'=> (Date)
     *      'birth_city => (string)
     *    ]
     * @param bool $save Save user in construct?
     * @throws Exception If Save is enabled
     */
    public function __construct($data = [], $save = false)
    {
//        try {
//            // parent::__construct();
//        } catch (Exception $e) {
//            echo $e->getMessage();
//            exit();
//        }
        $this->data = $data;
        if ($save)
            $this->save();
    }

    /**
     * @throws Exception
     */
    public function __set($name, $value)
    {
        if (!in_array($name, self::FIELDS)) {
            throw new Exception('Field not found');
        }
        $this->data[$name] = $value;
    }

    /**
     * @throws Exception
     */
    public function __get($name)
    {
        if (!in_array($name, self::FIELDS)) {
            throw new Exception('Field not found');
        }
        return $this->data[$name];
    }


    /**
     * @throws Exception
     */
    public function save()
    {
        $isUpdateAction = array_key_exists('id', $this->data);
        $sql = '';

        $dataToInsert = [];
        $updateFields = array_map(function($field){
            return '`'.$field.'`='.':'.$field;
        }, array_filter(self::FIELDS, function($field){
            return $field != 'id';
        }));

        foreach (self::FIELDS as $field) {
            if (!array_key_exists($field, $this->data) && $field != 'id') {
                throw new Exception('Some fields are not setted');
            }
            if ($field == 'id' && !$isUpdateAction) {
                continue;
            }
            $dataToInsert[':' . $field] = $this->data[$field];
        }

        if(!$isUpdateAction) {
            $sql = 'INSERT INTO `' . self::TABLE . '`(' . implode(',', array_filter(self::FIELDS, function($item) {return $item != 'id'; })) . ') VALUES (' . implode(',', array_keys($dataToInsert)) . ')';
        } else {
            $sql = 'UPDATE `' . self::TABLE . '` SET ' . implode(',', $updateFields) . ' WHERE `' . self::TABLE . '`.`id` = :id';
        }

        $res = $this->execute($sql, $dataToInsert);
        $this->id = $this->getLastId();

        return $res;

    }

    public function destroy()
    {
        if (array_key_exists('id', $this->data)) {
            return self::delete($this->id);
        }
        return false;
    }
}