<?php
/**
 *
 *
 *
 * PHP versions 5
 *
 *
 *
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage %%subpackage_name%%
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    GIT: $Id$
 * @link       %%your_link%%
 * @see        http://www.enviphp.net/c/man/v3/core/unittest
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */


/**
 *
 *
 *
 *
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage %%subpackage_name%%
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    GIT: $Id$
 * @link       %%your_link%%
 * @see        http://www.enviphp.net/c/man/v3/core/unittest
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */
class MockReceiverTest extends testCaseBase
{

    /**
     * +-- 初期化
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
        $this->free();
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     */
    public function mockClass_Test()
    {
        // 存在しないクラスの作成
        $TestMockClass = EnviMockLight::mock('TestMockClass');
        $this->assertTrue(class_exists('TestMockClass', false));
        $e = NULL;
        try {
            $TestMockClass->test();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
        $TestMockClass->shouldReceive('test')->once()->andReturn(true);
        $this->assertTrue($TestMockClass->test());
        $e = NULL;
        try {
            $TestMockClass->test();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);

        $TestMockClass->shouldReceive('test2')->twice()->andReturnNull();
        $this->assertNull($TestMockClass->test2());
        $this->assertNull($TestMockClass->test2());
        $e = NULL;
        try {
            $TestMockClass->test2();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);


        // オブジェクト参照method
        $Container = EnviMockLight::getMockContainer($TestMockClass);
        $this->assertInstanceOf('EnviMockLight\Containers\Container', $Container);

        $Executer = EnviMockLight::getMockExecuter($TestMockClass);
        $this->assertInstanceOf('EnviMockLight\Executers\Executer', $Executer);

        EnviMockLight::assertionExecuteAfter();
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行回数制限とリサイクルのテスト
     *
     * @access      public
     * @return      void
     */
    public function classStab_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample', array(1, 2));
        $this->assertTrue(class_exists('TestRoot\Sample', false));
        $e = NULL;
        try {
            $TestMockClass->test();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);

        // 実行回数制限のテスト
        $TestMockClass->shouldReceive('returnAAA')->times(3)->andNoBypass();
        $this->assertEquals('AAA', $TestMockClass->returnAAA());
        $this->assertEquals('AAA', $TestMockClass->returnAAA());
        $this->assertEquals('AAA', $TestMockClass->returnAAA());
        $e = NULL;
        try {
            $TestMockClass->returnAAA();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);

        // リサイクルのテスト
        EnviMockLight::recycle($TestMockClass, 'returnAAA');
        $this->assertEquals('AAA', $TestMockClass->returnAAA());
        $this->assertEquals('AAA', $TestMockClass->returnAAA());
        $this->assertEquals('AAA', $TestMockClass->returnAAA());
        $e = NULL;
        try {
            $TestMockClass->returnAAA();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
        EnviMockLight::assertionExecuteAfter();
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();
    }
    /* ----------------------------------------- */




    /**
     * +-- 自動Recycleのテスト
     *
     * @access      public
     * @param       classStab2_Test
     * @return      void
     */
    public function autoRecycle_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample', array(1, 2));
        $TestMockClass->shouldReceive('doSomething3')->atLeast(1)->autoRecycle(true)->andReturn(true);
        $TestMockClass->doSomething3();

        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());

        // 一回目はエラーにならない
        EnviMockLight::assertionExecuteAfter();


        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());

        // 二回目はエラーになる
        $e = NULL;
        try {
            EnviMockLight::assertionExecuteAfter();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();
    }
    /* ----------------------------------------- */




    /**
     * +--
     *
     * @access      public
     * @param       classStab2_Test
     * @return      void
     */
    public function classStab2_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample', array(1, 2));

        // byDefaultのテスト
        $TestMockClass->shouldReceive('time')->byDefault()->with()->andReturnConsecutive([1000, 2000, 3000]);

        // byDefaultからtime呼び出しテスト
        $TestMockClass2 = EnviMockLight::mock('\TestRoot\Sample', array(1, 2));
        EnviMockLight::useStab($TestMockClass2, 'time');
        $this->assertEquals(1000, $TestMockClass2->time());
        $this->assertEquals(2000, $TestMockClass2->time());
        $this->assertEquals(3000, $TestMockClass2->time());
        $this->assertEquals(1000, $TestMockClass2->time());
        $this->assertEquals(2000, $TestMockClass2->time());
        $this->assertEquals(3000, $TestMockClass2->time());

        // byDefaultから書き換えテスト
        $TestMockClass2->shouldReceive('time')->andReturnConsecutive([1000, 2000]);
        $this->assertEquals(1000, $TestMockClass2->time());
        $this->assertEquals(2000, $TestMockClass2->time());
        $this->assertEquals(1000, $TestMockClass2->time());
        $this->assertEquals(2000, $TestMockClass2->time());

        // 引数のチェックその1
        $e = NULL;
        try {
            $TestMockClass2->time(13254);
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);

        // 引数のチェックその2とandReturnAugmentAll,andReturnMapのテスト
        $TestMockClass2->shouldReceive('doSomething2')
            ->withByTimes(1, 1000, 2000)
            ->withByTimes(2, 2000, 2000)
            ->withByTimes(3, 3000, 2000)
            ->withByTimes(4, 4000, 2000)
            ->andReturnAugmentAll();
        $this->assertEquals([1000, 2000], $TestMockClass2->doSomething2(1000, 2000));
        $this->assertEquals([2000, 2000], $TestMockClass2->doSomething2(2000, 2000));
        $this->assertEquals([3000, 2000], $TestMockClass2->doSomething2(3000, 2000));
        $this->assertEquals([4000, 2000], $TestMockClass2->doSomething2(4000, 2000));
        $this->assertEquals([1000, 2000], $TestMockClass2->doSomething2(1000, 2000));
        $this->assertEquals([2000, 2000], $TestMockClass2->doSomething2(2000, 2000));
        $this->assertEquals([3000, 2000], $TestMockClass2->doSomething2(3000, 2000));
        $this->assertEquals([4000, 2000], $TestMockClass2->doSomething2(4000, 2000));

        $TestMockClass2->shouldReceive('doSomething2')
            ->withByTimes(1, 1000, 2000)
            ->withByTimes(2, 2000, 2000)
            ->withByTimes(3, 3000, 2000)
            ->withByTimes(4, 4000, 2000)
            ->andReturnMap(
                array(
                    [1000, 2000],
                    [2000, 2000],
                    [3000, 2000],
                    [4000, 2000],
                ),
                array(
                    1000,
                    2000,
                    3000,
                    4000,
                )
        );
        $this->assertEquals(1000, $TestMockClass2->doSomething2(1000, 2000));
        $this->assertEquals(2000, $TestMockClass2->doSomething2(2000, 2000));
        $this->assertEquals(3000, $TestMockClass2->doSomething2(3000, 2000));
        $this->assertEquals(4000, $TestMockClass2->doSomething2(4000, 2000));

        $TestMockClass2->shouldReceive('doSomething2')
            ->withByTimes(1, 1000, 2000)
            ->withByTimesSkip(2)
            ->withByTimes(3, 1000, 2000)
            ->andReturnMap(
                array(
                    [1000, 2000]
                ),
                array(
                )
        );
        $this->assertNull($TestMockClass2->doSomething2(1000, 2000));
        $this->assertNull($TestMockClass2->doSomething2(19000, 2000));

        $e = NULL;
        try {
        $this->assertNull($TestMockClass2->doSomething2(19000, 2000));
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);

        // 一回目実行
        EnviMockLight::assertionExecuteAfter();

        // 二回目の空実行
        EnviMockLight::assertionExecuteAfter();


        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @param       classStab2_Test
     * @return      void
     */
    public function classStab3_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample', array(1, 2));
        $TestMockClass->shouldReceive('doSomething3')->andThrow('\exception');

        $e = NULL;
        try {
            $TestMockClass->doSomething3();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('exception', $e);

        $TestMockClass->shouldReceive('doSomething3')->andThrow(new \exception('star'));

        $e = NULL;
        try {
            $TestMockClass->doSomething3();

        } catch (Exception $e) {
        }
        $this->assertInstanceOf('exception', $e);

        $TestMockClass->shouldReceive('doSomething3')
            ->withByTimes(1, 1000, 2000)
            ->withByTimes(2)
            ->withByTimes(3, 3000, 2000)
            ->withByTimes(4)
            ->andReturnMap(
                array(
                    [1000, 2000],
                    [2000, 2000],
                    [3000, 2000],
                    [4000, 2000],
                ),
                array(
                    3000,
                )
        );
        $this->assertEquals(3000, $TestMockClass->doSomething3(1000, 2000));
        $this->assertNull($TestMockClass->doSomething3());


        $TestMockClass->shouldReceive('mock')
            ->withByTimes(1, 1000, 2000)
            ->andReturnAugment(0);
        $this->assertEquals(1000, $TestMockClass->mock(1000, 2000));

        $TestMockClass->shouldReceive('mock2')
            ->andReturnAugment(3);
        $this->assertNull($TestMockClass->mock2(1000, 2000));

        $TestMockClass->shouldReceive('mock3')
            ->andReturnCallBack(function(){return 2000;});
        $this->assertEquals(2000, $TestMockClass->mock3(1000, 2000));
        EnviMockLight::assertionExecuteAfter();
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();

    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @param       classStab2_Test
     * @return      void
     */
    public function classStab4_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass->shouldReceive('doSomething3')->byDefault()->andReturn(true);
        $TestMockClass->doSomething3();
        $this->assertCount(0, EnviMockLight\Executers\Executer::getSelfList());
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();
    }


    /**
     * +--
     *
     * @access      public
     * @param       classStab2_Test
     * @return      void
     */
    public function classStab5_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass->shouldReceive('doSomething3')->atLeast(2)->andReturn(true);
        $TestMockClass->doSomething3();
        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());
        $e = NULL;
        try {
            EnviMockLight::assertionExecuteAfter();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();
    }




    /**
     * +-- レストア後の制限正常系
     *
     * @access      public
     * @param       classStab2_Test
     * @return      void
     */
    public function restore_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass->shouldReceive('doSomething3')->atLeast(2)->andReturn(true);
        $TestMockClass->doSomething3();

        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());

        $TestMockClass2 = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass2->shouldReceive('doSomething3')->atLeast(1)->andReturn(true);
        $TestMockClass2->doSomething3();

        $this->assertCount(2, EnviMockLight\Executers\Executer::getSelfList());


        EnviMockLight::restore($TestMockClass, 'doSomething3');
        $TestMockClass->doSomething3();
        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());
        EnviMockLight::assertionExecuteAfter();
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();

    }
    /* ----------------------------------------- */



    /**
     * +-- レストア後の制限エラー
     *
     * @access      public
     * @param       classStab2_Test
     * @return      void
     */
    public function restore2_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass->shouldReceive('doSomething3')->atLeast(2)->andReturn(true);
        $TestMockClass->doSomething3();

        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());

        $TestMockClass2 = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass2->shouldReceive('doSomething3')->atLeast(2)->andReturn(true);
        $TestMockClass2->doSomething3();

        $this->assertCount(2, EnviMockLight\Executers\Executer::getSelfList());

        EnviMockLight::restore($TestMockClass, 'doSomething3');
        $TestMockClass->doSomething3();
        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());
        $e = NULL;
        try {
            EnviMockLight::assertionExecuteAfter();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();
    }
    /* ----------------------------------------- */


    /**
     * +-- スタブ化していないもののレストア
     *
     * @access      public
     * @param       classStab2_Test
     * @return      void
     */
    public function restore3_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass->shouldReceive('doSomething3')->atLeast(2)->andReturn(true);
        $TestMockClass->doSomething3();

        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());

        EnviMockLight::restore($TestMockClass, 'doSomething');

        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());

        $e = NULL;
        try {
            EnviMockLight::assertionExecuteAfter();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();
    }
    /* ----------------------------------------- */


    /**
     * +-- 自動レストアのテスト
     *
     * @access      public
     * @param       classStab2_Test
     * @return      void
     */
    public function autoRestore_Test()
    {
        // まずは通常系
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass->shouldReceive('doSomething3')->between(3, 5)->andReturn(true);

        // 一回目は制限型のチェックが走る
        $this->assertTrue($TestMockClass->doSomething3());
        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());
        $e = NULL;
        try {
            EnviMockLight::assertionExecuteAfter();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);

        // 二回目は返り値のみが変更された状態で制限系のチェックは走らない
        $this->assertTrue($TestMockClass->doSomething3());

        // リセットするか、レストアするまではエグゼキューターはプールされ続ける
        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());

        EnviMockLight::assertionExecuteAfter();
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();

        // 自動レストアの場合
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass->shouldReceive('doSomething3')->atLeast(2)->autoRestore(true)->andReturn(true);

        // 一回目は制限型のチェックが走る
        $this->assertTrue($TestMockClass->doSomething3());
        $this->assertCount(1, EnviMockLight\Executers\Executer::getSelfList());
        $e = NULL;
        try {
            EnviMockLight::assertionExecuteAfter();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);

        // 二回目はスタブが無効になる
        $this->assertFalse($TestMockClass->doSomething3());
        $this->assertCount(0, EnviMockLight\Executers\Executer::getSelfList());

        EnviMockLight::assertionExecuteAfter();
        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行回数の継続取得テスト
     *
     * @access      public
     * @return      void
     */
    public function executionCountPooling_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));

        $TestMockClass
        ->shouldReceive('doSomething3')
        ->between(3, 5)
        ->executionCountPooling(true)
        ->autoRecycle(true)
        ->andReturn(true);

        $this->assertTrue($TestMockClass->doSomething3());

        $this->assertCount(1, EnviMockLight::getMockTraceList());
        $this->assertArrayHasValue(array (
            'class_name' => '\\TestRoot\\Sample3',
            'method_name' => 'doSomething3',
            'arguments' => array ()), EnviMockLight::getMockTraceList());

        $e = NULL;
        try {
            EnviMockLight::assertionExecuteAfter();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
        $this->assertCount(0, EnviMockLight::getMockTraceList());

        $this->assertTrue($TestMockClass->doSomething3());
        $this->assertCount(1, EnviMockLight::getMockTraceList());

        $e = NULL;
        try {
            EnviMockLight::assertionExecuteAfter();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
        $this->assertCount(0, EnviMockLight::getMockTraceList());

        $this->assertTrue($TestMockClass->doSomething3());
        $this->assertTrue($TestMockClass->doSomething3());
        $this->assertTrue($TestMockClass->doSomething3());

        $e = NULL;
        try {
            $TestMockClass->doSomething3();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
        $this->assertCount(4, EnviMockLight::getMockTraceList());

        EnviMockLight::assertionExecuteAfter();
        $this->assertCount(0, EnviMockLight::getMockTraceList());


        EnviMockLight::resetProcess();
        EnviMockLight::resetExecuter();

    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     */
    public function never_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass
        ->shouldReceive('doSomething3')
        ->never()
        ->andReturn(true);
        $e = NULL;
        try {
            $TestMockClass->doSomething3();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     */
    public function atMost_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass
        ->shouldReceive('doSomething3')
        ->atMost(2)
        ->andReturn(true);
        $TestMockClass->doSomething3();
        $TestMockClass->doSomething3();
        $e = NULL;
        try {
            $TestMockClass->doSomething3();
        } catch (Exception $e) {
        }
        $this->assertInstanceOf('EnviMockLight_Exception', $e);
    }
    /* ----------------------------------------- */




    /**
     * +--
     *
     * @access      public
     * @return      void
     */
    public function zeroOrMoreTimes_Test()
    {
        // スタブ
        $TestMockClass = EnviMockLight::mock('\TestRoot\Sample3', array(1, 2));
        $TestMockClass
        ->shouldReceive('doSomething3')
        ->never()
        ->zeroOrMoreTimes()
        ->andReturn(true);
        $TestMockClass->doSomething3();
        $TestMockClass->doSomething3();
        $TestMockClass->doSomething3();
        $TestMockClass->doSomething3();
    }
    /* ----------------------------------------- */


    /**
     * +-- 終了処理
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
    }

}
