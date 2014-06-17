<?php
/**
 * モッククラスに対する操作を提供します。
 *
 * EnviTestMockEditorはモッククラスに対する操作を提供します。
 *
 * 内部では、runkitを使用しているため、必要に応じてエクステンションをインストールする必要性があります。
 *
 * EnviTestMockEditorはすべてメソッドチェーンで実行されます。
 *
 *
 * PHP versions 5
 *
 *
 * @category   自動テスト
 * @package    テストスタブ
 * @subpackage Mock
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 3.3.3.2
 */

/**
 * モッククラスに対する操作を提供します。
 *
 * EnviTestMockEditorはモッククラスに対する操作を提供します。
 *
 * 内部では、runkitを使用しているため、必要に応じてエクステンションをインストールする必要性があります。
 *
 * EnviTestMockEditorはすべてメソッドチェーンで実行されます。
 *
 *
 * @category   自動テスト
 * @package    テストスタブ
 * @subpackage Mock
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 3.3.3.2
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
     * +-- 継承されているかどうか
     *
     * @access      public
     * @return      boolean
     */
    public function isAdapt();



    /**
     * +-- クラス名を取得する
     *
     * @access      public
     * @return      string
     */
    public function getClassName();



    /**
     * +-- 定義されているメソッドの一覧を返します。
     *
     * モッククラスに定義されているメソッドの名前を配列として返します。
     * エラー時には NULL を返します。
     *
     * 宣言されているままのメソッド名 (大文字小文字を区別) を返すことに注意して下さい。
     *
     * @access      public
     * @return      array
     */
    public function getMethods();



    /**
     * +-- 継承を解除する
     *
     * 他のクラスを継承している場合継承関係を解消し、 親クラスから継承しているメソッドを取り除く
     * @access      public
     * @return      EnviTestMockEditorRunkit
     */
    public function emancipate();



    /**
     * +-- 指定したクラスを継承させる
     *
     * 継承されている場合、継承を解除し、指定したクラスを継承させる。
     *
     * @access      public
     * @param       string $class_name 継承させるクラス名
     * @return      EnviTestMockEditorRunkit
     * @since       3.3.3.5
     */
    public function adopt($class_name);



    /**
     * +-- メソッドを削除する
     *
     * クラスから、指定されたメソッドを削除します、
     *
     * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ {.alert .alert-warning}
     * __注意:__
     * 現在実行中(もしくはチェーンド)のメソッドを操作することはできません。
     * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
     *
     * @access      public
     * @param       string $method_name 削除するメソッド
     * @return      EnviTestMockEditorRunkit
     */
    public function removeMethod($method_name);



    /**
     * +-- スタブしたMethodを元に戻す
     *
     * 削除、および変更されたメソッドを元に戻す。
     *
     * @access      public
     * @param       string $method_name 戻すメソッド
     * @return      EnviTestMockEditorRunkit
     * @since       3.3.3.5
     */
    public function restoreMethod($method_name);



    /**
     * +-- デフォルトのメソッドを実行する
     *
     * @access      public
     * @param       string $method_name 実行するメソッド
     * @param       object|string $obj OPTIONAL:NULL
     * @param       array $arguments OPTIONAL:array() 引数
     * @return      mixed
     */
    public function executeDefaultMethod($method_name, $obj = NULL, array $arguments = array());



    /**
     * +-- スタブされたメソッドかどうか
     *
     * @access      public
     * @param       any $method_name
     * @return      boolean
     */
    public function isStab($method_name);



    /**
     * +-- 書き換えたクラス定義をすべて元に戻す
     *
     * モックエディタで変更した、クラス定義をすべて元に戻します。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     * @since       3.3.3.5
     */
    public function restoreAll();



    /**
     * +-- emancipateおよび、adoptした継承状態を元に戻す。
     *
     * モックエディタで変更した継承状態を元に戻します。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     * @since       3.3.3.5
     */
    public function restoreExtends();



    /**
     * +-- 空のメソッドを定義する
     *
     * 空のメソッドを定義します。
     * 既にメソッドが定義されている場合は、空のメソッドに置き換えます。
     *
     * @access      public
     * @param       string $method 定義したいメソッド名
     * @return      EnviTestMockEditorRunkit
     */
    public function blankMethod($method);



    /**
     * +-- 複数の空メソッドを定義する
     *
     * 複数の空メソッドを定義します。
     * 既にメソッドが定義されている場合は、空のメソッドに置き換えます。
     *
     * @access      public
     * @param       array $methods 定義するメソッド名の配列
     * @return      EnviTestMockEditorRunkit
     */
    public function blankMethodByArray(array $methods);



    /**
     * +-- 全ての定義済メソッドを空メソッドに置き換える
     *
     * 定義されているメソッドを空メソッドに置き換えます
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     */
    public function blankMethodAll();



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
