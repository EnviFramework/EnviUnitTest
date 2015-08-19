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
class EnviMockLightTest extends testCaseBase
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
     * +-- 空実行
     *
     * @access      public
     * @return      void
     */
    public function mock_assertionExecuteAfter_Test()
    {
        EnviMockLight::assertionExecuteAfter();
    }
    /* ----------------------------------------- */


    /**
     * +-- 空実行
     *
     * @access      public
     * @return      void
     */
    public function mock_free_Test()
    {
        EnviMockLight::free();
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover      EnviMockLight::mock
     */
    public function mock_WithoutNameSpace_Test()
    {
        // 存在しないクラスの作成
        $TestMockClass = EnviMockLight::mock('TestMockClass');
        $this->assertTrue(class_exists('TestMockClass', false));
        $TestMockClass2 = EnviMockLight::mock('TestMockClass');
        $this->assertEquals(get_class($TestMockClass), get_class($TestMockClass2));
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover      EnviMockLight::mock
     */
    public function mock_WithNameSpace_Test()
    {
        // 名前空間のあるクラスの作成
        $TestMockClass = EnviMockLight::mock('TestRoot\UsingTest\TestMockClass');
        $this->assertTrue(class_exists('TestRoot\UsingTest\TestMockClass', false));
        $TestClass = new TestRoot\UsingTest\TestClass;
        $TestMockClass = $TestClass->instanceCreate();

        $this->assertInstanceOf('TestRoot\UsingTest\TestMockClass', $TestMockClass);

        $TestMockClass->shouldReceive('time')->andReturn(2000);
        $this->assertEquals(2000, $TestMockClass->time());

        $TestMockClass->shouldReceive('undefinedMethod')->andReturn('asdfasdf');
        $this->assertEquals('asdfasdf', $TestMockClass->undefinedMethod());

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
