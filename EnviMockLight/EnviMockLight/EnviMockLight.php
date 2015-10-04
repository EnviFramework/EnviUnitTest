<?php
/**
 * テストスタブ
 *
 * もとより、Enviが提供していたモックテスト機能である、**EnviMock**は___runkit___に依存していました。
 *
 *
 * **EnviMockLight** は ___runkit___を使用せずネイティブPHPの機能だけで、モックテストの機能を提供する目的で作成されました。
 *
 * **EnviMockLight** は **EnviMock**との互換性をできるかぎり保つように努力していますが、完全な互換でないことに注意してください。
 *
 *
 * EnviMockLight の `mock($class_name)` メソッドを使うと、指定したクラスのモッククラスを作成したり、特定のメソッドだけモックに置き換える、スタブが出来きるようになります。
 *
 * `EnviMock::getMock($class_name)`とは違い、すでにnewされたインスタンスを返すことに注意してください。
 *
 * `mock($className)`がコールされたときの状況に応じて、EnviMockLightは挙動を変えます。
 * 具体的には、
 *
 * $class_nameと言うクラスが存在する
 * : スタブ化されたオブジェクトを返す
 * : EnviMockとは違い、作られたインスタンスのみスタブ化されます
 *
 * $class_nameと言うクラスが存在しない
 * : 空の$class_nameを定義し、モッククラスとして動作させる
 * : 実際にモッククラスが作成されるため、new $class_nameしても、定義されたモッククラスが作成されます。
 *
 * と言った形です。
 *
 * 動作環境
 * -----------------------------------------------
 *
 * PHP 5.4以上の動作環境が必要です。
 *
 *
 * EnviMockとの違い
 * -----------------------------------------------
 *
 * EnviMockでクラスのスタブを行うと、それ以降の動作においてすべての該当クラスのメソッドがスタブ化されていました。
 * これは、クラスの中で更にインスタンスを作っているような場合に便利でしたが、テストの順番に細心の注意を払う必要がありました。
 *
 * また、テストをmultiモードで動かして、restorのコストを下げたり、テストの順番が関係有るのは、同一テストクラス内のみとするようなTipsが用いられていました。
 *
 * **EnviMockLight** では`EnviMockLight::mock()`で作られたインスタンスのみスタブ化されており、クラスの実体に手を加えることはありません。
 *
 *
 * EnviMockLightではなくEnviMockを使う理由
 * -----------------------------------------------
 *
 * EnviMockにできて、EnviMockLightにできないことがいくつかあります。
 *
 * - finalがついたメソッドのスタブ化
 * - アクセス権がprivateなメソッドのスタブ化
 * - staticメソッドのスタブ化
 * - EnviMockLight::mock()で作られるインスタンス以外のインスタンスの中身をスタブ化する
 *
 * これらを行う場合は、EnviMockを使用する必要があります
 *
 *
 *
 * モッククラス
 * -----------------------------------------------
 * デフォルトでは、すべてのメソッドが 単に NULL を返すだけのダミー実装になります。
 * たとえば andReturn($this->returnValue()) メソッドを使うと、 ダミー実装がコールされたときに値を返すよう設定することができます。
 *
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ {.alert .alert-info}
 * __※__ final, private および static メソッドのスタブやモックは作れないことに注意しましょう。
 * EnviMockLight のテストダブル機能ではこれらを無視し、元のメソッドの振る舞いをそのまま維持します。
 * これらをスタブ化したい場合は、EnviMockを使用してください。
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 *
 *
 * テストスタブ
 * -----------------------------------------------
 *
 * 実際のオブジェクトを置き換えて、 設定した何らかの値を (オプションで) 返すようなテストダブルのことを スタブ といいます。
 * スタブ を使うと、依存している実際のクラスを書き換え、依存先の入力を間接的に管理できます。
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
 * @subpackage_main
 */

use EnviMockLight\Builders\Builder;

/**
 * より簡易的なモックテストを提供します。
 *
 * EnviMockLightは、より簡易的にモックテストを提供します。
 *
 *
 * EnviMockLightは、それ自身でオブジェクトを生成しません。
 *
 * たとえば、下記のようなコードはエラーとなります。
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ {.php_code .code}
 * <?php
 * $mok = new EnviMockLight;
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 * EnviMockLight::mock('クラス名', array(コンストラクタに引き渡す引数), オートロードするかどうか(trueする：falseしない));
 *
 * による、インスタンスの生成や、EnviMockではEnviMockEditorが持っていたような、`restore()`や、`recycle()`などの機能を提供します。
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
     * モックメソッドや、モッククラスの実行トレースを取得します。
     *
     * 取得される値は、実行順となります。
     *
     * アサーション毎にリセットされますので、アサーションを行う前に取得してください。
     *
     * この機能は、主にメソッドやクラスの実行順序を監査するために使用されます。
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
     * モックメソッドや、モッククラスの実行トレースを削除します。
     *
     * @access      public
     * @static
     * @return      void
     * @doc_ignore
     */
    public static function resetMockTraceList()
    {
        self::_Load();
        EnviMockLight\Containers\Process::unsetTotalProcessAll();
    }
    /* ----------------------------------------- */

    /**
     * +-- プロセスのリストを削除する
     *
     * @access      public
     * @static
     * @return      void
     * @doc_ignore
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
     * @doc_ignore
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
     * @doc_ignore
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
     * EnviMockLight::mock()で作られたモックオブジェクトから、Containerオブジェクトを取得します。
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver EnviMockLight::mock()で作られたモックオブジェクト
     * @return      EnviMockLight\Containers\Container
     */
    public static function getMockContainer($MockReceiver)
    {
        self::_Load();
        return $MockReceiver->___EnviMockContainer();
    }
    /* ----------------------------------------- */

    /**
     * +-- オブジェクトからEnviMockEditorを取得する
     *
     * EnviMockLight::mock()で作られたモックオブジェクトから、EnviMockEditorオブジェクトを取得します。
     *
     * 現在のところ、EnviMockLight::getMockContainerの完全なエイリアスです。
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver EnviMockLight::mock()で作られたモックオブジェクト
     * @return      EnviMockLight\Containers\EnviMockEditor
     * @see         EnviMockLight::getMockContainer
     * @codeCoverageIgnore
     */
    public static function getMockEditor($MockReceiver)
    {
        return self::getMockContainer($MockReceiver);
    }
    /* ----------------------------------------- */



    /**
     * +-- オブジェクトから実行オブジェクトを取得する
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver EnviMockLight::mock()で作られたモックオブジェクト
     * @return      EnviMockLight\Executers\Executer
     * @doc_ignore
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
     * EnviMockLight::mock()で作られたモックオブジェクトを、スタブ化します。
     *
     * `EnviMockLight::getMockContainer($MockReceiver)->useStab($method_name);`と等価です。
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver EnviMockLight::mock()で作られたモックオブジェクト
     * @param       string $method_name useStabするメソッド
     * @return      EnviMockLight\Containers\EnviMockEditor
     * @see         EnviMockLight\Containers\EnviMockEditor::useStab
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
     * EnviMockLight::mock()で作られたモックオブジェクトの、$method_nameで指定されたメソッドのスタブや、制限をすべて解除します。
     *
     *
     * `EnviMockLight::getMockContainer($MockReceiver)->restore($method_name);`と等価です。
     *
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver EnviMockLight::mock()で作られたモックオブジェクト
     * @param       string $method_name restoreするメソッド
     * @return      EnviMockLight\Containers\EnviMockEditor
     * @see         EnviMockLight\Containers\EnviMockEditor::restore
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
     * EnviMockLight::mock()で作られたモックオブジェクトの、$method_nameで指定されたメソッドの制限を再利用します。
     *
     * 実行回数などは全てリセットされます。
     *
     * `EnviMockLight::getMockContainer($MockReceiver)->recycle($method_name);`と等価です。
     *
     * @access      public
     * @static
     * @param       EnviMockLight\Builders\MockReceiver $MockReceiver EnviMockLight::mock()で作られたモックオブジェクト
     * @param       string $method_name recycleするメソッド
     * @return      EnviMockLight\Containers\EnviMockEditor
     * @see         EnviMockLight\Containers\EnviMockEditor::recycle
     */
    public static function recycle($MockReceiver, $method_name)
    {
        self::_Load();
        return $MockReceiver->___EnviMockContainer()->recycle($method_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- すべて初期化する
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

/**
 * 汎用例外
 *
 * EnviMockLightの例外基底クラスおよび、汎用例外です
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
 * @codeCoverageIgnore
 */
class EnviMockLight_Exception extends \exception
{
}
