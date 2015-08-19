<?php
namespace EnviMockLight\Builders;

class Builder
{
    public static $mock_class_list = array();

    /**
     * +-- クラスの動的作成
     *
     * @access      public
     * @param       string $parent_class_name
     * @param       string $auto_loading OPTIONAL:false
     * @return      string
     */
    public function classBuild($parent_class_name, $auto_loading = false)
    {
        if (isset(self::$mock_class_list[$parent_class_name])) {
            return self::$mock_class_list[$parent_class_name];
        }
        $build_class_name = $this->getBuildClassName($parent_class_name, $auto_loading);
        $context = $this->classContextBuild($build_class_name, $parent_class_name, $auto_loading);
        @eval($context);
        if (!class_exists($parent_class_name, false)) {
            class_alias($build_class_name, $parent_class_name, false);
            self::$mock_class_list[$parent_class_name] = $build_class_name;
        }

        return $build_class_name;
    }
    /* ----------------------------------------- */



    /**
     * +-- 動的生成するクラス名を取得する
     *
     * @access      public
     * @param       string $parent_class_name
     * @param       string $auto_loading OPTIONAL:false
     * @return      string
     */
    public function getBuildClassName($parent_class_name, $auto_loading = false)
    {
        $i = 0;
        $class_name = strtr($parent_class_name, "\\", '_');
        $build_class_name = '';


        $context = 'class ';
        while (strlen($build_class_name) === 0 || class_exists($build_class_name, false)) {
            $build_class_name = 'EnviMockLight_'.$i.'_'.$class_name;
            $i++;
        }
        return $build_class_name;
    }
    /* ----------------------------------------- */


    /**
     * +-- クラスコンテキストの作成
     *
     * @access      public
     * @param       string $build_class_name
     * @param       string $parent_class_name
     * @param       string $auto_loading OPTIONAL:false
     * @return      string
     */
    public function classContextBuild($build_class_name, $parent_class_name, $auto_loading = false)
    {
        // {@codeCoverageIgnoreStart}
        $context = "namespace {\n"
        // {@codeCoverageIgnoreEnd}
        ."    class ";
        $context .= $build_class_name;

        $methods = '';
        if (class_exists($parent_class_name, $auto_loading)) {
            $context .= ' extends '.$parent_class_name;
            $methods = $this->methodBuilder($parent_class_name);
        } else {
            $methods = $this->getCall($parent_class_name).$this->getCallStatic($parent_class_name);
        }
        // {@codeCoverageIgnoreStart}
        $context .= '{'."\n"

        // {@codeCoverageIgnoreEnd}
         .'    use \EnviMockLight\Builders\MockReceiver;
         public $class_name = "'.$parent_class_name.'";
             '.$methods.'
            }
        }';
        return $context;
    }
    /* ----------------------------------------- */

    /**
     * +-- クラス定義からクラスを作る
     *
     * @access      public
     * @param       string $parent_class_name
     * @return      string
     */
    public function methodBuilder($parent_class_name)
    {
        $ReflectionClass = new \ReflectionClass($parent_class_name);
        $methods = $ReflectionClass->getMethods();
        $content = '';
        $is_call        = false;
        $is__callStatic = false;
        foreach ($methods as $val) {
            // UnitTestのため分割して書く
            if ($val->isPrivate()) {
                continue;
            } elseif ($val->isFinal()) {
                continue;
            } elseif ($val->isStatic()) {
                continue;
            }

            $access = $val->isPublic() ? 'public' : 'protected';

            if ($val->name === '__call') {
                $is_call = true;
                $content .= $access.' function __call($name, array $arguments) {';

                // {@codeCoverageIgnoreStart}
                $content .= "\n      "
                .'$args = func_get_args();
                    if ($this->___EnviMockContainer()->isStab($name)) {
                        return $this->___EnviMockExecuter()->execute("'.$parent_class_name.'", $name, $arguments, $this);
                    }
                ';
                // {@codeCoverageIgnoreEnc}
            } elseif ($val->name === '__set') {
                $content .= $access.' function __set ($name , $value) {';
            } elseif ($val->name === '__get') {
                $content .= $access.' function __set ($name) {';
            } elseif ($val->name === '__isset') {
                $content .= $access.' function __isset($name) {';
            } elseif ($val->name === '__unset') {
                $content .= $access.' function __unset($name) {';
            } else {
                $content .= $access.' function '.$val->name.' () {';
            }
            // {@codeCoverageIgnoreStart}
            $content .= "\n      "
            // {@codeCoverageIgnoreEnc}
            .'if ($this->___EnviMockContainer()->isStab("'.$val->name.'")) {
                $results = $this->___EnviMockExecuter()->execute("'.$parent_class_name.'", "'.$val->name.'", func_get_args(), $this);
                if (!$this->___EnviMockContainer()->isNoBypass("'.$val->name.'")) {
                    return $results;
                }
            }
            return call_user_func_array(array("parent", "'.$val->name.'"), func_get_args());
            }
            ';

        }
        if (!$is_call) {
            $content .= $this->getCall($parent_class_name);
        }
        return $content;
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      private
     * @param       private $parent_class_name
     * @return      string
     */
    private function getCall($parent_class_name)
    {
        // {@codeCoverageIgnoreStart}
        return 'public function __call($name, array $arguments) {'."\n"
            .'// Common __call
            if ($this->___EnviMockContainer()->isStab($name)) {
                return $this->___EnviMockExecuter()->execute("'.$parent_class_name.'", $name, $arguments, $this);
            }
            throw new EnviMockLight\Exceptions\Exception("Undefined Method '.$parent_class_name.'::".$name, E_ERROR );
        }
        ';
        // {@codeCoverageIgnoreEnd}
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      private
     * @param       private $parent_class_name
     * @return      string
     */
    private function getCallStatic($parent_class_name)
    {
        // {@codeCoverageIgnoreStart}
        return 'public static function __callStatic($name, array $arguments) {'."\n"
            .'// Common __callStatic
            if (self::___EnviMockContainerStatic()->isStab($name)) {
                return self::___EnviMockExecuterStatic()->execute("'.$parent_class_name.'", $name, $arguments);
            }
            throw new \EnviMockLight\Exceptions\Exception("Undefined Method '.$parent_class_name.'::".$name, E_ERROR );
        }
        ';
        // {@codeCoverageIgnoreEnd}
    }
    /* ----------------------------------------- */
}
