<?php
/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   自動テスト
 * @package    テストスタブ
 * @subpackage EnviMockLight
 * @author     Suzunone <suzunne.eleven@gmail.com>
 * @copyright  2011-2015 Artisan Project
 * @license    https://github.com/EnviMVC/EnviMockLight/blob/master/LICENSE
 * @version    GIT: $Id$
 * @link       http://www.enviphp.net/
 * @see        http://www.enviphp.net/
 * @since      Class available since Release v1.0.0
 */

namespace EnviMockLight\Executers;


/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * @category   自動テスト
 * @package    テストスタブ
 * @subpackage EnviMockLight
 * @author     Suzunone <suzunne.eleven@gmail.com>
 * @copyright  2011-2015 Artisan Project
 * @license    https://github.com/EnviMVC/EnviMockLight/blob/master/LICENSE
 * @version    Release: @package_version@
 * @link       http://www.enviphp.net/
 * @author     Suzunone <suzunne.eleven@gmail.com>
 * @since      Class available since Release v1.0.0
 * @doc_ignore
 */
class Executer
{
    private $class_name;
    private $method_name;
    private $arguments;
    private $container;

    public static $self_list = array();

    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       \EnviMockLight\Containers\ContainerBase $container
     * @return      void
     * @doc_ignore
     */
    public function __construct(\EnviMockLight\Containers\ContainerBase $container)
    {
        $this->container = $container;
        self::$self_list[] = $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 同じContainerかどうか調べる
     *
     * @access      public
     * @param       \EnviMockLight\Containers\ContainerBase  $container
     * @return      boolean
     * @doc_ignore
     */
    public function ckContainer(\EnviMockLight\Containers\ContainerBase $container)
    {
        return $container === $this->container;
    }
    /* ----------------------------------------- */

    /**
     * +-- モックメソッドの実行本体
     *
     * @access      public
     * @param       string $method_name
     * @param       array $arguments
     * @return      mixed
     * @doc_ignore
     */
    public function execute($class_name, $method_name, $arguments, $_this = NULL)
    {
        $this->class_name  = $class_name;
        $this->method_name = $method_name;
        $this->arguments   = $arguments;
        if ($this->getContainer('is_should_receive')) {
            $this->setProcess();
            $execute_count = $this->incrementExecuteCount();
            $this->maxExecutionLimitedCheck($execute_count);
            $this->argumentsCheck($execute_count);
        }
        if ($this->getContainer('no_bypass', false)) {
            // no bypass
            return;
        } elseif ($this->getContainer('return_is_throw', false)) {
            // exception
            if (is_string($this->getContainer('return_values', 'Exception'))) {
                $exception_name = $this->getContainer('return_values', 'Exception');
                throw new $exception_name('return_is_throw');
                // @codeCoverageIgnoreStart
            } else {
                // @codeCoverageIgnoreEnd
                throw $this->getContainer('return_values');
            }
        } elseif ($this->getContainer('return_is_augment', false)) {
            // 引数
            return isset($arguments[$this->getContainer('return_values')]) ? $arguments[$this->getContainer('return_values')] : NULL;
        } elseif ($this->getContainer('return_is_augment_all', false)) {
            // 引数
            return $arguments;
        } elseif ($this->getContainer('return_is_callback', false)) {
            // 関数の実行
            return call_user_func_array($this->getContainer('return_values'), $arguments);
        } elseif ($this->getContainer('return_is_consecutive', false)) {
            // consecutive
            if (!isset($execute_count)) {
                $execute_count = $this->incrementExecuteCount();
            }

            $map = $this->getContainer('return_values');
            $maxkey = count($map) - 1;
            $key = $execute_count - 1;
            while (!isset($map[$key])) {
                $key -= count($map);
            }
            return $map[$key];
        } elseif ($this->getContainer('return_is_map', false)) {
            // map
            $map = $this->getContainer('return_values');
            foreach ($map as $val) {
                if ($arguments === $val['arguments']) {
                    return $val['return_values'];
                }
            }
            return NULL;
        }
        return $this->getContainer('return_values', NULL);
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @static
     * @return      void
     * @doc_ignore
     */
    public static function resetSelfList()
    {
        self::$self_list = array();
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @static
     * @return      void
     * @doc_ignore
     */
    public static function getSelfList()
    {
        return self::$self_list;
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @static
     * @param       \EnviMockLight\Containers\ContainerBase $container
     * @return      void
     * @doc_ignore
     */
    public static function unsetSelfListByContainer(\EnviMockLight\Containers\ContainerBase $container)
    {
        foreach (self::$self_list as $k => $executer) {
            if (!$executer->ckContainer($container)) {
                continue;
            }
            unset(self::$self_list[$k]);
        }
    }
    /* ----------------------------------------- */



    /**
     * +-- Assertion毎に毎回実行される
     *
     * @access      public
     * @return      void
     * @doc_ignore
     */
    public function assertionExecuteAfter()
    {
        if (!$this->getContainer('is_should_receive', false)) {
            return;
        }

        // エラー処理
        $e = null;
        try{
            $this->minExecutionLimitedCheck($this->getExecuteCount());
        } catch (\EnviMockLight\Exceptions\Exception $e) {

        }

        // 初期化処理
        if (!$this->getContainer('execution_count_pooling', false)) {
            $this->setExecuteCount(0);
        }

        // 自動Recycle
        if ($this->getContainer('is_auto_recycle', false)) {
            $this->container->recycle($this->method_name);
        } else {
            $this->setContainer('is_should_receive', false);
        }

        // 自動レストア
        if ($this->getContainer('is_auto_restore', false)) {
            $this->container->restore($this->method_name);
        }

        // エラーの場合通知する
        if (!is_null($e)) {
            throw $e;
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- 最大実行回数制限の確認
     *
     * @access      private
     * @param       integer $execute_count 今の実行回数
     * @return      boolean
     * @doc_ignore
     */
    private function maxExecutionLimitedCheck($execute_count)
    {
        $times_check = $this->getContainer('max_limit_times', false, $this->method_name);
        if ($times_check === false) {
            return true;
        } elseif ($times_check >= $execute_count) {
            return true;
        }
        $e = new \EnviMockLight\Exceptions\MaxExecutionCountException;
        $e->setLimitClass($this->class_name);
        $e->setLimitMethod($this->method_name);
        $e->setExecutionCount($execute_count);
        $e->setTimes($times_check);
        throw $e;
    }
    /* ----------------------------------------- */


    /**
     * +-- 最小実行回数制限の確認
     *
     * @access      private
     * @param       integer $execute_count 今の実行回数
     * @return      boolean
     * @doc_ignore
     */
    private function minExecutionLimitedCheck($execute_count)
    {
        $times_check = $this->getContainer('min_limit_times', false);
        if ($times_check === false) {
            return true;
        } elseif ($times_check <= $execute_count) {
            return true;
        }
        $e = new \EnviMockLight\Exceptions\MinExecutionCountException;
        $e->setLimitClass($this->class_name);
        $e->setLimitMethod($this->method_name);
        $e->setExecutionCount($execute_count);
        $e->setTimes($times_check);
        throw $e;
    }
    /* ----------------------------------------- */

    private function argumentsCheck($execute_count)
    {
        $with_by_times = $this->getContainer('with_by_times', array());
        $error = array();
        if (isset($with_by_times[$execute_count])) {
            if ($with_by_times[$execute_count] === false) {
                return true;
            }
            if ($with_by_times[$execute_count] === $this->arguments) {
                return true;
            }
            $error = $with_by_times[$execute_count];
        } else {
            $with = $this->getContainer('with', false);
            if ($with === false) {
                return true;
            }elseif ($with === $this->arguments) {
                return true;
            }
            $error = $with;
        }

        $e = new \EnviMockLight\Exceptions\ArgumentException;
        $e->setLimitClass($this->class_name);
        $e->setLimitMethod($this->method_name);
        $e->setExecutionCount($execute_count);
        $e->setArgument(array($this->arguments, $error));
        throw $e;
    }

    private function incrementExecuteCount()
    {
        $res = $this->getExecuteCount() + 1;
        $this->setExecuteCount($res);
        return $res;
    }


    private function getExecuteCount()
    {
        return $this->getAttribute('execute_count', 0);
    }


    private function setExecuteCount($n)
    {
        return $this->setAttribute('execute_count', $n);
    }

    private function setContainer($setter_key, $setter_value)
    {
        $this->container->setContainer($setter_key, $setter_value, $this->method_name);
    }

    private function getContainer($setter_key, $default_value = false)
    {
        return $this->container->getContainer($setter_key, $default_value, $this->method_name);
    }


    private function setAttribute($setter_key, $setter_value)
    {
        $this->container->setAttribute($setter_key, $setter_value, $this->method_name);
    }

    private function getAttribute($setter_key, $default_value = false)
    {
        return $this->container->getAttribute($setter_key, $default_value, $this->method_name);
    }

    private function setProcess()
    {
        $this->container->setProcess(
            $this->class_name,
            $this->method_name,
            $this->arguments
        );
    }
}

