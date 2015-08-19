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

use EnviMockLight\Builders\Builder;

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
 */
class EnviMockLight
{

    private static $_is_auto_load = false;

    /**
     * +-- コンストラクタ
     *
     * static クラスなので、privateコンストラクタ
     *
     * @access      private
     * @return      void
     * @doc_ignore
     */
    private function __construct()
    {
    }
    /* ----------------------------------------- */

    /**
     * +-- モック化されたクラスオブジェクトの取得
     *
     * EnviMockLightによってモック化されたオブジェクトを返します。
     *
     * 定義済みのクラスを指定した場合は、スタブ可能なモックテストに、
     *
     * 未定義のクラスを指定した場合は、完全なモックを提供します。
     *
     * @access      public
     * @static
     * @param       string $class_name モックを作成するクラス名
     * @param       array $args コンストラクタに渡す引数
     * @param       boolean $auto_loading  モックを作るときにオートロードするか OPTIONAL:false
     * @param       boolean $is_cache  キャッシュするかどうか OPTIONAL:true
     * @return      EnviMockEditor モック操作オブジェクト
     */
    public static function mock($class_name, array $args = array(), $auto_loading = false)
    {
        self::_Load();

        $Builder = new Builder;
        $mocked_class_name = $Builder->classBuild($class_name,  $auto_loading);
        $reflection = new ReflectionClass($mocked_class_name);
        $instance = $reflection->newInstanceArgs($args);
        return $instance;
    }
    /* ----------------------------------------- */


    /**
     * +-- モックメソッドの実行トレースを取得する
     *
     * @access      public
     * @static
     * @return      array
     */
    public static function getMockTraceList()
    {
        self::_Load();
        return EnviMockLight\Containers\Process::getTotalProcessAll();
    }
    /* ----------------------------------------- */

    /**
     * +-- モックメソッドの実行トレースリストを削除する
     *
     * @access      public
     * @static
     * @return      void
     */
    public static function resetMockTraceList()
    {
        self::_Load();
        EnviMockLight\Containers\Process::unsetTotalProcessAll();
    }
    /* ----------------------------------------- */

    /**
     * +-- エグゼキューターのリストを削除する
     *
     * @access      public
     * @static
     * @return      void
     */
    public static function resetProcess()
    {
        self::_Load();
        EnviMockLight\Containers\Process::resetSelfList();
    }
    /* --

    /**
     * +-- エグゼキューターのリストを削除する
     *
     * @access      public
     * @static
     * @return      void
     */
    public static function resetExecuter()
    {
        self::_Load();
        EnviMockLight\Executers\Executer::resetSelfList();
    }
    /* ----------------------------------------- */



    /**
     * +-- Assertion毎に毎回実行される
     *
     * @access      public
     * @static
     * @param       boolean $is_reset_trace OPTIONAL:true
     * @return      void
     */
    public static function assertionExecuteAfter($is_reset_trace = true)
    {
        self::_Load();
        if ($is_reset_trace) {
            self::resetMockTraceList();
        }

        foreach (EnviMockLight\Executers\Executer::getSelfList() as $Executer) {
            $Executer->assertionExecuteAfter();
        }
        foreach (EnviMockLight\Containers\Process::getSelfList() as $Process) {
            $Process->unsetProcessAll();
        }
    }
    /* ----------------------------------------- */



    /**
     * +-- オブジェクトからコンテナを取得する
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver
     * @return      void
     */
    public static function getMockContainer($MockReceiver)
    {
        self::_Load();
        return $MockReceiver->___EnviMockContainer();
    }
    /* ----------------------------------------- */



    /**
     * +-- オブジェクトから実行オブジェクトを取得する
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver
     * @return      void
     */
    public static function getMockExecuter($MockReceiver)
    {
        self::_Load();
        return $MockReceiver->___EnviMockExecuter();
    }
    /* ----------------------------------------- */


    /**
     * +-- スタブ化する
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver
     * @param       string $method_name
     * @return      EnviMockLight\Containers\Container
     */
    public static function useStab($MockReceiver, $method_name)
    {
        self::_Load();
        return $MockReceiver->___EnviMockContainer()->useStab($method_name);
    }
    /* ----------------------------------------- */



    /**
     * +-- レストアする
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver
     * @param       string $method_name
     * @return      EnviMockLight\Containers\Container
     */
    public static function restore($MockReceiver, $method_name)
    {
        self::_Load();
        return $MockReceiver->___EnviMockContainer()->restore($method_name);
    }
    /* ----------------------------------------- */



    /**
     * +-- Recycleする
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver
     * @param       string $method_name
     * @return      EnviMockLight\Containers\Container
     */
    public static function recycle($MockReceiver, $method_name)
    {
        self::_Load();
        return $MockReceiver->___EnviMockContainer()->recycle($method_name);
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @static
     * @return      void
     */
    public static function free()
    {
        self::resetMockTraceList();
        self::assertionExecuteAfter();
        self::resetProcess();
        self::resetExecuter();
    }
    /* ----------------------------------------- */


    /**
     * +-- オートローディング
     *
     * @access      public
     * @static
     * @return      void
     * @doc_ignore
     * @codeCoverageIgnore
     */
    public static function _Load()
    {
        if (self::$_is_auto_load) {
            return;
        }

        spl_autoload_register(function($class_name) {
            $name_arr = explode("\\", $class_name);
            if (count($name_arr) >= 3 && $name_arr[0] === 'EnviMockLight') {
               $file_name =  dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.join(DIRECTORY_SEPARATOR, $name_arr).'.php';
               require $file_name;
            }
        });
        self::$_is_auto_load = true;
    }
    /* ----------------------------------------- */


}


