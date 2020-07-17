<?php

namespace D2;

use ReflectionMethod;
use ReflectionParameter;
use RuntimeException;

/**
 * Класс создания модели и ее гидрации данными
 * 
 * Данные должны иметь идентичное с моделью именование атрибутов!
 * То есть role, а не roleCode или role_code. Иначе их не получится 
 * сопоставить с моделью и выполнить гидрацию.
 * При начальном создании это переименование делает либо фабрика
 * При восстановлении данных базовый репозиторий 
 * 
 * Поддерживает загрузку через __construct или статический метод
 * Правила обработки входных данных:
 * 
 *      1.  Если аргумент метода, через который производится загрузка,
 *          скалярного типа, он попадает в метод в исходном виде
 * 
 *      2.  Если аргумент метода, через который производится загрузка,
 *          заявлен как объект (ValueObject), происходит создание этого 
 *          объекта $value = new ValueObject($value)
 *
 * В метод передаются только те параметры, который в нем заявлены. Лишние 
 * входные данные игнорируются.
 * 
 * class Account
 * {
 *      public function __construct(int $id, Status $status, string $name, ExternalEntity $externalEntity);
 *
 *      public static function create(int $id, string $name): self;
 * }
 * 
 * $externalEntity = Hydrator::buildConstructor(
 *      ExternalEntity::class, [
 *          'id' => 1
 *      ]
 * );
 * 
 * $account = Hydrator::buildConstructor(
 *      Account::class, [
 *          'id'             => 1,                                      // Это будет передано в таком виде
 *          'status'         => 1,                                      // Это будет преобразовано в new Status(1)
 *          'name'       => 'Имя',                                  // Это будет передано в таком виде
 *          'unused_attr'    => 'Лишний атрибут, полученный с данными', // Этого нет в конструкторе, будет пропущено
 *          'externalEntity' => $externalEntity                         // Объект, попадет в конструктор прямо так
 *      ]
 * );
 * 
 * $account = Hydrator::buildStaticMethod(
 *      Account::class, 'create',
 *      [
 *          'id'       => 1,  
 *          'name' => 'Имя'
 *      ]
 * );
 */

class Hydrator
{
    private $class;
    private $method = null;

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * Create instance by constructor
     * 
     * @param type $class
     * @param array $data
     * @return mixed
     */
    public function byConstructor(array $data = [])
    {
        $this->method = '__construct';

        $params = $this->params(
            (new ReflectionMethod($this->class, $this->method))->getParameters(), 
            $data
        );

        return new $this->class(...$params);
    }

   /**
    * Create instance by static constructor
    * 
    * @param type $class
    * @param type $method
    * @param array $data
    * @return mixed
    */
   public function byStaticConstructor(string $method, array $data = [])
   {
        $this->method = $method;

        $params = $this->params(
            (new ReflectionMethod($this->class, $this->method))->getParameters(), 
            $data
        );

       return $this->class::$method(...$params);
   }

    /**
     * Build params
     *
     * @param ReflectionParameter[] $reflectionParams
     * @param array $data
     * @return array
     */
    private function params(array $reflectionParams, array $data): array
    {
        $params = [];

        foreach ($reflectionParams as $param) {

            $name = $param->getName();

            if ($param->getClass()) {
                $value = $this->voParam($data, $param, $param->getClass()->name);
            }

            elseif (array_key_exists($name, $data)) {
                $value = $data[$name];
            }

            else {
                if ($param->isOptional()) {
                    $value = $param->getDefaultValue();
                } else {
                    $this->exception(
                        "Параметр \"{$name}\" не имеет значения по-умолчанию и отсутствует во входных данных"
                    );
                }
            }

            $params[] = $value;
        }

        return $params;
    }

    private function voParam(array $data, ReflectionParameter $reflection, string $voClass)
    {
        $param = $reflection->getName();

        if (isset($data[$param])) {

            $value = $data[$param];

            if (! is_object($value)) {
                return new $voClass($value);
            }

            $actualClass = get_class($value);

            if ($voClass === $actualClass) {
                return $value;
            }

            $this->exception(
                "Для объекта-значения {$voClass} {$param} передан некорректный объект {$actualClass}"
            );
        }

        if ($reflection->isOptional()) {
            return $reflection->getDefaultValue();
        }

        $this->exception(
            "Нет данных для создания объекта-значения {$voClass} {$param}"
        );
    }

    private function exception(string $message): void
    {
        $object = $this->method ? "{$this->class}::{$this->method}" : $this->class;

        throw new RuntimeException(
            "Ошибка гидрации {$object}. {$message}"
        );
    }

    // private function voParam(ReflectionParameter $param, array $data)
    // {
    //     $class = $param->getClass()->name;
    // }

    // /**
    //  * Создание параметров
    //  *
    //  * @param ReflectionParameter[] $reflectionParams
    //  * @param array $data
    //  * @return array
    //  */
    // private static function params(string $class, string $method, array $data): array
    // {
    //     $reflectionParams = (new ReflectionMethod($class, $method))->getParameters();

    //     $params = [];

    //     // Кэширование, пока выключено, профит по скорости был минимальный
    //     // Что с расходом cpu непонятно, нужно потестировать
    //     // $params = self::reflectMethodParams($class, $method);

    //     // @todo сообщение exception, объясняющее без trace в каком месте произошел вызов

    //     foreach ($reflectionParams as $param) {

    //         $name = $param->getName();

    //         // Exception, если для аргумента метода нет соответствия 
    //         // во входных данных и в конструкторе нет дефолтного значения

    //         if (! array_key_exists($name, $data)) {
    //             if ($param->isOptional()) {
    //                 $value = $param->getDefaultValue();
    //             } else {
    //                 throw new RuntimeException(
    //                     "Ошибка гидрации $class::$method. " .
    //                     "Аргумент метода $name не имеет значения по-умолчанию и отсутствует во входных данных"
    //                 );
    //             }
    //         } else {
    //             $value = $data[$name];
    //         }

    //         // Если значение не объект, не null и для его атрибута заявлен класс
    //         // это объект-значение и его нужно проинициализировать 
    //         // через конструктор с этим $value.
    //         // 
    //         // Необязательные объекты-значения конструктора
    //         // Для возможности написать так 
    //         // 
    //         //     __construct(?Datetime $sentAt = null)
    //         //
    //         // делаем проверку $value !== null
    //         // Без этой проверки будет выполнен с ошибкой new Datetime(null)
    //         // Принимаем за константу поведение, в котором объект-значение
    //         // не может быть проинициализирован с null.

    //         if (! is_object($value) && $value !== null && $param->getClass()) {
    //             $valueObject = $param->getClass()->name;
    //             $value = new $valueObject($value);
    //         }

    //         $params[] = $value;
    //     }

    //     return $params;
    // }
}
