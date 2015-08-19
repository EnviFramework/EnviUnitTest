<?php

namespace TestRoot
{
    /**
     * @category   %%project_category%%
     * @package    %%project_name%%
     * @subpackage %%subpackage_name%%
     * @author     Suzunone <suzunne.eleven@gmail.com>
     * @since      Class available since Release 1.0.0
     * @doc_ignore
     */
    class Sample
    {

        public function __construct($arg1, $arg2)
        {
            $this->arg1 = $arg1;
            $this->arg2 = $arg2;
        }

        public function doSomething()
        {
            return $this->time();
        }

        public function doSomething2($arg1, $arg2)
        {
            return $arg1 + $arg2;
        }


        public function doSomething3()
        {
            return false;
        }

        public function time()
        {
            return time();
        }


        public function returnAAA()
        {
            return 'AAA';
        }


        final public function doFinalAnything()
        {

        }
        public static function doStaticAnything()
        {

        }


        private function doPrivateAnything()
        {

        }

        private static function doPrivateStaticAnything()
        {

        }

        protected function doProtectedSomething()
        {

        }


        protected static function doProtectedStaticSomething()
        {

        }
    }


    /**
     * @category   %%project_category%%
     * @package    %%project_name%%
     * @subpackage %%subpackage_name%%
     * @author     Suzunone <suzunne.eleven@gmail.com>
     * @since      Class available since Release 1.0.0
     * @doc_ignore
     */
    class Sample2 extends Sample
    {

        private $data = array();

        public $declared = 1;

        private $hidden = 2;

        public function __call($method_name, $args)
        {
            return $args;
        }
        public static function __callStatic($method_name, $args)
        {
            return $args;
        }
        public function __sleep()
        {
            return array('dsn', 'username', 'password');
        }

        public function __wakeup()
        {
            $this->connect();
        }

        public function __toString()
        {
            return $this->foo;
        }
        public function __invoke($x)
        {
            var_dump($x);
        }

        public function __debugInfo() {
            return [
                'propSquared' => $this->prop * 2,
            ];
        }




        public function __set($name, $value)
        {
            echo "Setting '$name' to '$value'\n";
            $this->data[$name] = $value;
        }

        public function __get($name)
        {
            echo "Getting '$name'\n";
            if (array_key_exists($name, $this->data)) {
                return $this->data[$name];
            }

            $trace = debug_backtrace();
            trigger_error(
                'Undefined property via __get(): ' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
                E_USER_NOTICE);
            return null;
        }

        public function __isset($name)
        {
            echo "Is '$name' set?\n";
            return isset($this->data[$name]);
        }

        public function __unset($name)
        {
            echo "Unsetting '$name'\n";
            unset($this->data[$name]);
        }
    }


    /**
     * @category   %%project_category%%
     * @package    %%project_name%%
     * @subpackage %%subpackage_name%%
     * @author     Suzunone <suzunne.eleven@gmail.com>
     * @since      Class available since Release 1.0.0
     * @doc_ignore
     */
    class Sample3 extends Sample
    {

    }
}
namespace TestRoot\UsingTest
{
    /**
     * @category   %%project_category%%
     * @package    %%project_name%%
     * @subpackage %%subpackage_name%%
     * @author     Suzunone <suzunne.eleven@gmail.com>
     * @since      Class available since Release 1.0.0
     * @doc_ignore
     */
    class TestClass
    {

        public function __construct()
        {
        }

        public function instanceCreate()
        {
            return new TestMockClass;
        }


    }
}
