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
 */
interface EnviMockEditor
{


    /**
     * +-- コンストラクタ
     *
     *
     * @access      public
     * @param       any $cla_name
     * @return      void
     * @deprecated EnviMock::mock('クラス名');を使用して下さい。
     * @see EnviMock::mock();
     */
    public function __construct($class_name);
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
     * @return      EnviTestMockEditorRunkit
     */
    public function shouldReceive($method_name);



    /**
     * +-- 定義済みの制限を再利用する
     *
     * 一度テストされた定義や、byDefault()された定義を再利用して、制限を加えます。
     *
     * @access      public
     * @param       string $method_name
     * @return      EnviTestMockEditorRunkit
     */
    public function recycle($method_name);



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
     * @return      EnviTestMockEditorRunkit
     */
    public function byDefault();



    /**
     * +-- このメソッドにのみ期待される引数のリストの制約を追加します。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * 指定のメソッドに渡される引数のリストを追加します。
     * 指定された引数以外が渡された場合は、例外、EnviMockExceptionがthrowされます。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function with();



    public function withNoArgs();

    public function withNoArgsByTimes($times);

    public function withAnyArgs();

    public function withAnyArgsByTimes($times);

    /**
     * +-- このメソッドにのみ期待される引数のリストの制約を追加します。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * 指定のメソッドに渡される引数のリストを追加します。
     * 指定された引数以外が渡された場合は、例外、EnviMockExceptionがthrowされます。
     *
     * @access      public
     * @param       integer $times 制限回数
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */

    public function withByTimes($times);



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
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function once();



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
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     * @see         EnviTestMockEditor::time()
     */
    public function twice();



    /**
     * +-- 呼び出し回数の上限と下限を定義します
     *
     * @access      public
     * @param       integer $min 制限回数下限
     * @param       integer $max 制限回数上限
     * @return      EnviTestMockEditorRunkit
     */
    public function between($min, $max);



    /**
     * +-- 最小実行回数を定義し、最大実行回数は削除します
     *
     * @access      public
     * @param       integer $n 制限回数下限
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function atLeast($n);



    /**
     * +-- 最大実行回数を定義し、最小実行回数は削除します
     *
     *
     *
     * @access      public
     * @param       integer $n 制限回数上限
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     * @see         EnviTestMockEditor::once()
     * @see         EnviTestMockEditor::twice()
     * @see         EnviTestMockEditor::time()
     */
    public function atMost($n);



    /**
     * +-- メソッドが呼び出されないことを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが呼び出されないことを定義します。
     * 制約から外れた場合は、例外、EnviMockExceptionがthrowされます。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function never();



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
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function times($n);



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
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function zeroOrMoreTimes();



    /**
     * +-- メソッド実行回数をリセットするかどうか
     *
     * Defaultでは、assert時にリセットされます。
     *
     * @access      public
     * @param       boolean $is_pool OPTIONAL:true
     * @return      EnviTestMockEditorRunkit
     */
    public function executionCountPooling($is_pool = true);



    /**
     * +-- Assert後も同じ制限を継続して利用するかどうかを指定する
     *
     * デフォルトでは、Assert後は制限が解除されます。
     *
     * @access      public
     * @param       boolean $val OPTIONAL:true
     * @return      void
     */
    public function autoRecycle($val = true);



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
    public function autoRestore($val = true);



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
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturn($res);



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
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturnNull();



    /**
     * +-- 指定した場所の引数をそのまま返すメソッドであると定義します
     *
     * @access      public
     * @param       integer $val 返す引数の場所 OPTIONAL:0
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturnAugment($val = 0);



    /**
     * +-- 引数をそのまま返すメソッドであると定義します
     *
     * @access      public
     * @param       integer $val 返す引数の場所 OPTIONAL:0
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturnAugmentAll();



    /**
     * +-- コールバックの結果を返すメソッドであると定義します
     *
     * @access      public
     * @param       callback $val
     * @return      EnviTestMockEditorRunkit
     */
    public function andReturnCallBack($val);



    /**
     * +-- 実行回数毎にバラバラの値を返すためのマップを登録します、マップに沿った値を返すメソッドであると定義します
     *
     * @access      public
     * @param       array $val
     * @return      EnviTestMockEditorRunkit
     */
    public function andReturnConsecutive(array $val);



    /**
     * +-- 引数によって返す値を変える為のマップを登録し、マップに沿った値を返すメソッドであると定義します
     *
     * @access      public
     * @param       array $map
     * @param       array $val
     * @return      EnviTestMockEditorRunkit
     */
    public function andReturnMap(array $map, array $val);



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
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andThrow($exception_class, $message = '');



    /**
     * +-- 処理を迂回せず実行するメソッドであると定義します。
     *
     * @access      public
     * @return      void
     */
    public function andNoBypass();

}
/* ----------------------------------------- */
