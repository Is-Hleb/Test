<?php
// Date format Y-M-D
// Чтобы обновить данные используйте синтасис user->свойство
// Чтобы создать и сохранить в контроллер можно передать значение true для аргемента save

spl_autoload_register(function($class){
    try {
        include $class . '.php';
    } catch (Exception $exception) {
        echo "Такого класса не существует, либо же он не найдет";
    }
});

$user = new User([
    'name' => 'Name',
    'surname' => 'Surname',
    'date_of_birth' => date("Y-m-d"),
    'birth_city' => 'City',
    'sex' => true,
]);


try {
    var_export(UserCollection::where('id', '>', '13'));
    $user = new User([
        'name' => 'Name',
        'surname' => 'Surname',
        'date_of_birth' => date("Y-m-d"),
        'birth_city' => 'City',
        'sex' => true,
    ], true);

    $user->name = "Gleb";
    $user->surname = "Ischenko";

    $user->save();
//    $user = new User();
//    $user->name = "Some";
//    $user->destroy();
} catch (Exception $e) {
    echo $e->getMessage();
}