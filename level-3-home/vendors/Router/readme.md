Данный Router класс предназначен для подключения классов и методов. и создания человеко читаемым URL.

## Конфигурация и запуск класса Router

- Класс Router принимает в себя супер глобальные перемменрые с названием контроллера и метода по умолчанию:

  `define( 'DEFAULT_CONTROLLER', 'Home'); // set default controller`<br/>
  `define( 'DEFAULT_ACTION', 'indexAction'); // set default action`

  - Для использования Router класса требуется его инициализация и запуск:

  `$router = new Router();>`<br/>
  `$router->run();`

- Модуль используется для подключения файлов и создания человеко читаемым URL. Класс подключает контроллеры и запускает методы. Пример: если используется ссылка 'www.domain.com/user/edit/301', где 'register' это котроллер. 
* /user/ это котроллер. Файл контроллера с названием "UserController". Название класса "UserController".
* /edit/ это метод класса "UserController. ФНазвание метода "editAction".
* /301/ это параметры которые можно передать в котроллер. Пример метода "editAction" принемаер в себя массив парамеров $queryParams:

  `public function editAction( array $queryParams = [] ) {`
    `$users = $this->pdo->getAll("users")->results();`
    `include ROOT . "app/views/index.view.php";`
  `}`

## Использование Router класса

### run() - Метод для подключения файлов и создания человеко читаемым URL.

- Метод не принимает никаких параметров.

- Пример использования:

  `$router->run();`