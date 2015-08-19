<?php
namespace EnviMockLight\Builders;

trait MockReceiver
{
    protected $___envi_mock_container;
    protected $___envi_mock_executer;
    protected static $___envi_mock_container_static;
    protected static $___envi_mock_executer_static;

    /**
     * +-- モックの変更を開始する
     *
     * @access      public
     * @param       string $method_name
     * @return      EnviMockLight\Containers\Container
     */
    public function shouldReceive($method_name)
    {
        $this->___EnviMockContainer()->shouldReceive($method_name);
        return $this->___EnviMockContainer();
    }
    /* ----------------------------------------- */


    /**
     * +-- コンテナオブジェクトを取得する
     *
     * @access      public
     * @return      \EnviMockLight\Containers\Container
     */
    public function ___EnviMockContainer()
    {
        if ($this->___envi_mock_container) {
            return $this->___envi_mock_container;
        }

        return $this->___envi_mock_container = new \EnviMockLight\Containers\Container($this);
    }
    /* ----------------------------------------- */


    /**
     * +-- 実行を取得する
     *
     * @access      public
     * @return      \EnviMockLight\Executers\Executer
     */
    public function ___EnviMockExecuter()
    {
        if ($this->___envi_mock_executer) {
            return $this->___envi_mock_executer;
        }

        return $this->___envi_mock_executer = new \EnviMockLight\Executers\Executer($this->___EnviMockContainer($this));
    }
    /* ----------------------------------------- */


    /**
     * +-- コンテナオブジェクトを取得する
     *
     * @access      public
     * @static
     * @return      EnviMockLight\Containers\Container
     */
    public static function ___EnviMockContainerStatic()
    {
        if (self::$___envi_mock_container_static) {
            return self::$___envi_mock_container_static;
        }

        return self::$___envi_mock_container_static = new \EnviMockLight\Containers\Container();
    }
    /* ----------------------------------------- */


    /**
     * +-- 実行を取得する
     *
     * @access      public
     * @static
     * @return      \EnviMockLight\Executers\Executer
     */
    public static function ___EnviMockExecuterStatic()
    {
        if (self::$___envi_mock_executer_static) {
            return self::$___envi_mock_executer_static;
        }

        return self::$___envi_mock_executer_static = new \EnviMockLight\Executers\Executer(self::___EnviMockContainerStatic());
    }
    /* ----------------------------------------- */

}
