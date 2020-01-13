<?php
/*
 * 1. Какие типы паттернов проектирования существуют?

-Порождающие паттерны,
 предназначенные для создания новых объектов в системе.
Singleton, Simple Factory, Fabric Method

-Структурные паттерны,
https://tproger.ru/translations/design-patterns-simple-words-2/
решающие задачи компоновки системы на основе классов и объектов.
Adapter, Bridge

-Паттерны поведения,
https://tproger.ru/translations/design-patterns-simple-words-3/
предназначенные для распределения обязанностей между объектами в системе.
помогают ответить на вопрос «Как запустить поведение в программном компоненте?»
Chain of Responsibility,Command

* 2. Как можно улучшить Singleton при помощи trait-ов?

трейты можно использовать именно как copy-paste для использования Singleton.*/


namespace Traits;

trait SingletonTrait
{
    /**
     * @var array список объектов
     */
private static $instances = [];

/**
 * @return self
 */
public static function single()
{
    if (!isset(self::$instances[static::class])) {
        self::$instances[static::class] = new static;
    }

    return self::$instances[static::class];
}
}

namespace Classes;

use Traits\SingletonTrait;

class Test
{
    use SingletonTrait;

}

/*
* 3. Как реализуется паттерн Фабричный метод? В чем его отличие от паттерна Фабрика?
https://refactoring.guru/ru/design-patterns/factory-method

Менеджер предоставляет способ делегирования логики создания экземпляра дочерним классам.
Выгодное отличие от SimpleFactory в том, что вы можете вынести реализацию создания объектов в подклассы.
класс FactoryMethod зависит от абстракций, а не от конкретных классов.
<?php
/**
 * Фабрика
 */
interface Factory
{

    /**
     * Возвращает продукт
     *@return Product
     */
    public function getProduct();
}

/**
 * Продукт
 */
interface Product
{

    /**
     * Возвращает название продукта
     *
     * @return string
     */
    public function getName();
}

/**
 * Первая фабрика
 */
class FirstFactory implements Factory
{

    /**
     * Возвращает продукт
     *
     * @return Product
     */
    public function getProduct()
    {
        return new FirstProduct();
    }
}

/**
 * Вторая фабрика
 */
class SecondFactory implements Factory
{

    /**
     * Возвращает продукт
     *
     * @return Product
     */
    public function getProduct()
    {
        return new SecondProduct();
    }
}

/**
 * Первый продукт
 */
class FirstProduct implements Product
{

    /**
     * Возвращает название продукта
     *
     * @return string
     */
    public function getName()
    {
        return 'The first product';
    }
}

/**
 * Второй продукт
 */
class SecondProduct implements Product
{

    /**
     * Возвращает название продукта
     *
     * @return string
     */
    public function getName()
    {
        return 'Second product';
    }
}

/*
 * =====================================
 *        USING OF FACTORY METHOD
 * =====================================
 */

$factory = new FirstFactory();
$firstProduct = $factory->getProduct();
$factory = new SecondFactory();
$secondProduct = $factory->getProduct();

print_r($firstProduct->getName());
// The first product
print_r($secondProduct->getName());
// Second product

/*4. Объясните назначение и применение магических методов __get, __set, __isset, __unset, __call и __callStatic.
Когда, как и почему их стоит использовать (или нет)?

    Вся "магия" данных методов сводится к тому, что они могут перехватывать (отсюда их второе название - методы-перехватчики)
    сообщения, посланные неопределенным (по сути - несуществующим) методам и свойствам.
    Они делают API неясным, автоматическое завершение невозможным и, самое главное, они медленны.
    Вам нужно всего лишь использовать магию, если объект действительно "волшебный". Если у вас есть классический объект
    с фиксированными свойствами, то используйте сеттеры и геттеры, они отлично работают.

Если ваш объект имеет динамические свойства, например, он является частью уровня абстракции базы данных,
а его параметры заданы во время выполнения, тогда вам действительно нужны магические методы для удобства.

    *__get будет выполнен при чтении данных из недоступных (защищенных или приватных) или несуществующих свойств.
    * __set будет выполнен при записи данных в недоступные (защищенные или приватные) или несуществующие свойства.
    *__isset будет выполнен при использовании isset() или empty() на недоступных (защищенных или приватных)
      или несуществующих свойствах.
    *__unset() будет выполнен при вызове unset() на недоступном (защищенном или приватном) или несуществующем свойстве.
    *__call  запускается при вызове недоступных методов в контексте объект.
    * __callStatic  запускается при вызове недоступных методов в статическом контексте.


5. Опишите несколько структур данных из стандартной библиотеки PHP (SPL). Приведите примеры использования.

    -Двусвязный список (DLL)
динамическая структура данных состоящая из узлов которые содержат как данные так и ссылку на  предыдущий
 и следующем узел. Основа стека и очереди
    SPL stack абстрактный тип с элементами организованными по LIFO(last in first Out) такой тип хорошо подходит
для работы с древовидными структурами, в процессе которой нужно удобно хранить глубину погружения.
    SPL queue абстрактный тип с элементами организованными по FIFO(first in first Out) Пример использования:
последовательная обработка входящих сообщений, работа с командами, распределенными во времени

    -SPl Heap древовидная структура любой узел должен быть больше своих потомков или равен им. Применяется пользовательский
метод сравнения Пример использования: обработке неупорядоченного массива данных от веб-сервиса партнера

    -SplFixedArray массив с ограниченым кол-ом элементов,  хранит в непрерывном виде данные,
которые доступны только через их числовые индексы . Используеться для нумерованных списков и реализации сортировок.





6. Найдите все ошибки в коде:*/
interface MyInt {
    public function funcI();
    public function funcP();// все методы в Interface должны быть public
}
class A {
    protected $prop1; // $prop1, $prop2 обьевление переменной без $
    private $prop2;

    function funcA(){
       return $this->prop2; // поскольку переменная обьявлена неправильно выдаст ошибку
    }
}
class B extends A {
    function funcB(){
       return $this->prop1; // $prop1 не обьявлен внутри класса и не является константой или статической переменной в
                            // родительском классе интерпретатор выдаст фатальную оштбку поскольку свойство не определенно
    }
}
class C extends B implements MyInt { // если класс наследует интерфейс он должен содержать реализацию всехфункций.
                                     // В этом случае нужно реализовать funcI();
    function funcB(){
       return $this->prop1;
    }
    private function funcP(){
       return 123;
    }

    public function funcI()
    {
        // TODO: Implement funcI() method.
    }
}
$b = new B();
$b->funcA();
$c = new C();
$c->funcI();
