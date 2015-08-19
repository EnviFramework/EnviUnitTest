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
namespace EnviMockLight\Containers;


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
class Container extends ContainerBase
    implements EnviMockEditor
{

    protected $stab_method_list;
    protected $by_default;

    protected $_this;

    public $class_name;

    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       var_text $MockReceiver
     * @return      void
     * @doc_ignore
     */
    public function __construct($MockReceiver = NULL)
    {
        $this->initialize();
        $this->_this = is_null($MockReceiver) ? $this : $MockReceiver;
        $this->class_name = is_null($MockReceiver) ? __CLASS__ : $MockReceiver->class_name;
    }
    /* ----------------------------------------- */

    /**
     * +-- 定義済みの制限を再利用する
     *
     * 一度テストされた定義や、byDefault()された定義を再利用して、制限を加えます。
     *
     * @access      public
     * @param       string $method_name
     * @return      \EnviMockLight\Containers\Container
     */
    public function recycle($method_name)
    {
        $this->free();
        if (!$this->getContainer('execution_count_pooling', false, $method_name)) {
            $this->resetAttribute($method_name);
        }
        $this->setUsingMethodName($method_name);
        $this->setContainer('is_should_receive', true);

        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 制限をテンプレートとして登録する
     *
     * 現在指定している制限や返り値を、デフォルトとして指定します。
     * デフォルト期待値はデフォルトではない制限や返り値が使われるまで、適用されます。
     * あとで定義されたデフォルト期待値は、先に宣言されたものを即座に置き換えます。
     *
     * initialize()や、データプロバイダーで制限だけ先に加えて、各テストで再利用する等という方法に利用できます。
     *
     * スタブ化前であれば、スタブする処理をスキップしますが、
     * スタブ化済のメソッドを、restore()することはしないので、定義順序に注意してください。
     *
     * @access      public
     * @return      \EnviMockLight\Containers\Container
     */
    public function byDefault()
    {
        $this->by_default = true;
        $this->setContainer('is_should_receive', false);
        $this->Container->byDefault();
        return $this;
    }
    /* ----------------------------------------- */



    /**
     * +-- 制約を追加するためのメソッドを定義します。
     *
     * メソッドに制約を追加できます。
     * 制約を追加したいメソッド名をshouldReceive()で指定し、メソッドチェーンで、制約を追加します。
     *
     * 追加した制約から外れた場合、該当のメソッドは、例外、EnviMockExceptionがthrowされます。
     *
     * 返り値を設定するまで、制約は追加されません。
     * 逆に、返り値を設定してしまうと、制約が追加され、メソッドは書き換えられてしまいます。
     *
     * {@example}
     *    $mock
     *    ->shouldReceive('check') // checkというメソッドが呼び出される
     *    ->with('foo') // 引数として'foo'を受け取る
     *    ->andReturn(true); // trueを返却する
     * {/@example}
     * @access      public
     * @param       string $method_name
     * @return      \EnviMockLight\Containers\Container
     */
    public function shouldReceive($method_name)
    {
        $this->free();
        $this->setUsingMethodName($method_name);

        if (!$this->getContainer('execution_count_pooling', false, $method_name)) {
            $this->resetAttribute($method_name);
        }
        $this->resetContainer($method_name);
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +-- このメソッドにのみ期待される引数のリストの制約を追加します。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * 指定のメソッドに渡される引数のリストを追加します。
     * 指定された引数以外が渡された場合は、例外、EnviMockExceptionがthrowされます。
     *
     * @access      public
     * @return      \EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function with()
    {
        $this->setContainer('with', func_get_args());
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @codeCoverageIgnore
     * @doc_ignore
     */
    public function withNoArgs()
    {
        $this->setContainer('with', array());
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @param       var_text $times
     * @return      void
     * @codeCoverageIgnore
     * @doc_ignore
     */
    public function withNoArgsByTimes($times)
    {
        $args = func_get_args();
        $times = array_shift($args);
        $res = $this->getContainer('with_by_times', array());
        $res[(integer)$times] = array();
        $this->setContainer('with_by_times', $res);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @codeCoverageIgnore
     * @doc_ignore
     */
    public function withAnyArgs()
    {
        $this->setContainer('with', false);
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @param       var_text $times
     * @return      void
     * @codeCoverageIgnore
     */
    public function withAnyArgsByTimes($times)
    {
        $args = func_get_args();
        $times = array_shift($args);
        $res = $this->getContainer('with_by_times', array());
        $res[(integer)$times] = false;
        $this->setContainer('with_by_times', $res);
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +-- このメソッドにのみ期待される引数のリストの制約を追加します。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * 指定のメソッドに渡される引数のリストを追加します。
     * 指定された引数以外が渡された場合は、例外、EnviMockExceptionがthrowされます。
     *
     * @access      public
     * @return      \EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function withByTimes($times)
    {
        $args = func_get_args();
        $times = array_shift($args);
        $res = $this->getContainer('with_by_times', array());
        $res[(integer)$times] = $args;
        $this->setContainer('with_by_times', $res);
        return $this;
    }
    /* ----------------------------------------- */



    /**
     * +-- このメソッドにのみ期待される引数のリストの制約を取り払います。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * 指定のメソッドに渡される引数のリストを追加します。
     * 指定された引数以外が渡された場合は、例外、EnviMockExceptionがthrowされます。
     *
     * @access      public
     * @return      \EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function withByTimesSkip($times)
    {
        $res = $this->getContainer('with_by_times', array());
        $res[(integer)$times] = false;
        $this->setContainer('with_by_times', $res);
        return $this;
    }
    /* ----------------------------------------- */




    /**
     * +-- メソッドが1回だけ呼び出されることを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが1回だけ呼び出されることを定義します
     * 制約から外れた場合は、例外、EnviMockExceptionがthrowされます。
     *
     * このメソッドはv3.3.6から、下限の制限がつきました。
     *
     * @access      public
     * @return      \EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function once()
    {
        $this->times(1);
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +-- メソッドが2回だけ呼び出されることを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが2回だけ呼び出されることを定義します。
     * 制約から外れた場合は、例外、EnviMockExceptionがthrowされます。
     *
     * このメソッドはv3.3.6から、下限の制限がつきました。
     *
     * @access      public
     * @return      \EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     * @see         EnviTestMockEditor::time()
     */
    public function twice()
    {
        $this->times(2);
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +-- 呼び出し回数の上限と下限を定義します
     *
     * @access      public
     * @param       any $min
     * @param       any $max
     * @return      EnviMockLight\Containers\Container
     */
    public function between($min, $max)
    {
        $this->setContainer('max_limit_times', (integer)$max);
        $this->setContainer('min_limit_times', (integer)$min);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 最小実行回数を定義し、最大実行回数は削除します
     *
     * @access      public
     * @param       any $n
     * @return      \EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function atLeast($n)
    {
        $this->unsetContainer('max_limit_times');
        $this->setContainer('min_limit_times', (integer)$n);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 最大実行回数を定義し、最小実行回数は削除します
     *
     *
     *
     * @access      public
     * @param       any $n
     * @return      EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     * @see         EnviTestMockEditor::once()
     * @see         EnviTestMockEditor::twice()
     * @see         EnviTestMockEditor::time()
     */
    public function atMost($n)
    {
        $this->setContainer('max_limit_times', (integer)$n);
        $this->unsetContainer('min_limit_times');
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- メソッドが呼び出されないことを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが呼び出されないことを定義します。
     * 制約から外れた場合は、例外、EnviMockExceptionがthrowされます。
     *
     * @access      public
     * @return      EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function never()
    {
        $this->times(-1);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- メソッドが$n回だけ呼び出されることを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが$n回だけ呼び出されることを定義します。
     * 制約から外れた場合は、例外、EnviMockExceptionがthrowされます。
     *
     * このメソッドはv3.3.6から、下限の制限がつきました。
     *
     * @access      public
     * @param       integer $n 制限回数
     * @return      EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function times($n)
    {
        $this->setContainer('max_limit_times', (integer)$n);
        $this->setContainer('min_limit_times', (integer)$n);
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +-- 期待メソッドが0回以上呼び出すことができることを宣言します。これは、すべてのメソッドのデフォルトです。
     *
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * 期待メソッドが0回以上呼び出すことができることを宣言します。
     * 設定変更しない限り、これは、すべてのメソッドのデフォルトです。
     *
     * @access      public
     * @return      EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function zeroOrMoreTimes()
    {
        $this->unsetContainer('max_limit_times');
        $this->unsetContainer('min_limit_times');
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- メソッド実行回数をリセットするかどうか
     *
     * Defaultでは、assert時にリセットされます。
     *
     * @access      public
     * @param       boolean $is_pool OPTIONAL:true
     * @return      EnviMockLight\Containers\Container
     */
    public function executionCountPooling($is_pool = true)
    {
        $this->setContainer('execution_count_pooling', $is_pool);
        return $this;
    }
    /* ----------------------------------------- */



    /**
     * +-- Assert後も同じ制限を継続して利用するかどうかを指定する
     *
     * デフォルトでは、Assert後は制限が解除されます。
     *
     * @access      public
     * @param       boolean $val OPTIONAL:true
     * @return      void
     */
    public function autoRecycle($val = true)
    {
        $this->setContainer('is_auto_recycle', $val);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 自動的にrestoreを行うかどうかを定義する
     *
     * 自動的にrestoreを行うかどうかを定義します。
     *
     * trueを指定すると、スタブされたメソッドについてはAssert後に自動的にrestoreを行います。
     *
     * デフォルトでは、Assert後もrestoreを行わず、andXXXで指定した処理を行います。
     *
     * @access      public
     * @param       boolean $val OPTIONAL:true
     * @return      void
     */
    public function autoRestore($val = true)
    {
        $this->setContainer('is_auto_restore', $val);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 戻り値を設定します。
     *
     * 戻り値を設定します。
     *
     * この後のモックメソッドの全ての呼び出しは、常にこの宣言に指定された値を返すことに注意してください。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出され、制限が確定されます。
     *
     *
     *
     * @access      public
     * @param       any $res
     * @return      EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturn($res)
    {
        $this->setContainer('return_values', $res);
        $this->mockCommit();
        return $this->_this;
    }
    /* ----------------------------------------- */

    /**
     * +-- NULLを返すメソッドであると定義します
     *
     * NULLを返すメソッドであると定義します
     *
     * この後のモックメソッドの全ての呼び出しは、常にこの宣言に指定されたNULLを返すことに注意してください。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出され、制限が確定されます。
     *
     * @access      public
     * @return      EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturnNull()
    {
        $this->setContainer('return_values', NULL);
        $this->mockCommit();
        return $this->_this;
    }
    /* ----------------------------------------- */


    /**
     * +-- 指定した場所の引数をそのまま返すメソッドであると定義します
     *
     * @access      public
     * @param       integer $val 返す引数の場所 OPTIONAL:0
     * @return      EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturnAugment($val = 0)
    {
        $this->setContainer('return_is_augment', true);
        $this->setContainer('return_values', $val);
        $this->mockCommit();
        return $this->_this;
    }
    /* ----------------------------------------- */


    /**
     * +-- 引数をそのまま返すメソッドであると定義します
     *
     * @access      public
     * @param       integer $val 返す引数の場所 OPTIONAL:0
     * @return      EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturnAugmentAll()
    {
        $this->setContainer('return_is_augment_all', true);
        $this->setContainer('return_values', true);
        $this->mockCommit();
        return $this->_this;
    }
    /* ----------------------------------------- */

    /**
     * +-- コールバックの結果を返すメソッドであると定義します
     *
     * @access      public
     * @param       callback $val
     * @return      EnviMockLight\Containers\Container
     */
    public function andReturnCallBack($val)
    {
        $this->setContainer('return_is_callback', true);
        $this->setContainer('return_values', $val);
        $this->mockCommit();
        return $this->_this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行回数毎にバラバラの値を返すためのマップを登録します、マップに沿った値を返すメソッドであると定義します
     *
     * @access      public
     * @param       array $val
     * @return      EnviMockLight\Containers\Container
     */
    public function andReturnConsecutive(array $val)
    {
        $this->setContainer('return_is_consecutive', true);
        $this->setContainer('return_values', $val);
        $this->mockCommit();
        return $this->_this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 引数によって返す値を変える為のマップを登録し、マップに沿った値を返すメソッドであると定義します
     *
     * @access      public
     * @param       array $map
     * @param       array $val
     * @return      EnviMockLight\Containers\Container
     */
    public function andReturnMap(array $map, array $val)
    {
        $this->setContainer('return_is_map', true);
        $return_values = array();
        foreach ($map as $arguments) {
            $return_value = each($val);
            $return_values[] = array('arguments' => $arguments, 'return_values' => $return_value ? $return_value[1] : NULL);
        }
        $this->setContainer('return_values', array_values($return_values));

        $this->mockCommit();
        return $this->_this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 呼び出された場合、このメソッドは、指定された例外オブジェクトをスローすることを宣言します。
     *
     * この後のモックメソッドの全ての呼び出し、常にこの宣言に例外を返すようになることに注意して下さい。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出され、制限が確定されます。
     *
     * @access      public
     * @param       string|exception $exception_class throwされるexceptionオブジェクトかexceptionクラス名
     * @param       any $message OPTIONAL:''
     * @return      EnviMockLight\Containers\Container
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andThrow($exception_class, $message = '')
    {
        $this->setContainer('return_is_throw', true);
        $this->setContainer('return_values', $exception_class);
        $this->mockCommit();
        return $this->_this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 処理を迂回せず実行するメソッドであると定義します。
     *
     * @access      public
     * @return      void
     */
    public function andNoBypass()
    {
        $this->setContainer('no_bypass', true);
        $this->mockCommit();
        return $this->_this;
    }
    /* ----------------------------------------- */

    /**
     * +-- スタブされているかどうか
     *
     * @access      public
     * @param       var_text $method_name
     * @return      boolean
     * @doc_ignore
     */
    public function isStab($method_name)
    {
        return isset($this->stab_method_list[$method_name]);
    }
    /* ----------------------------------------- */


    /**
     * +-- スタブする
     *
     * @access      public
     * @param       var_text $method_name
     * @return      void
     * @doc_ignore
     */
    public function useStab($method_name)
    {
        $this->shouldReceive($method_name);
        $this->mockCommit();
    }
    /* ----------------------------------------- */



    /**
     * +-- スタブやモックを解除する
     *
     * @access      public
     * @param       var_text $method_name
     * @return      void
     * @doc_ignore
     */
    public function restore($method_name)
    {
        if ($this->isStab($method_name)) {
            unset($this->stab_method_list[$method_name]);
            $this->resetContainer($method_name);
            $this->resetAttribute($method_name);
            \EnviMockLight\Executers\Executer::unsetSelfListByContainer($this);
        }
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @param       string $method_name
     * @return      boolean
     * @doc_ignore
     */
    public function isNoBypass($method_name)
    {
        $res = $this->getContainer('no_bypass', false, $method_name);
        return (bool)$res;
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      private
     * @return      \EnviMockLight\Containers\Container
     * @doc_ignore
     */
    private function mockCommit()
    {
        if ($this->by_default) {
            $this->Container->byDefault();
            return;
        }
        $this->setContainer('is_should_receive', true);
        $this->stab_method_list[$this->getUsingMethodName()] = $this->getUsingMethodName();
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      private
     * @return      \EnviMockLight\Containers\Container
     */
    private function free()
    {
        $this->setUsingMethodName('');
        $this->by_default = false;
        return $this;
    }
    /* ----------------------------------------- */


}
