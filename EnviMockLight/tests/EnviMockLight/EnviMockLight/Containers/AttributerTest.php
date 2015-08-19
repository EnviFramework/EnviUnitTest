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
class AttributerTest extends testCaseBase
{

    protected $Attributer;

    /**
     * +--
     *
     * @access      public
     * @static
     * @return      void
     * @beforeClass
     */
    public static function Load()
    {
        EnviMockLight::_Load();
    }
    /* ----------------------------------------- */

    /**
     * +-- 初期化
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
        $this->free();
        $Container = new \EnviMockLight\Containers\Container;
        $Container->setUsingMethodName('test_Method_Default');
        $this->Attributer = new \EnviMockLight\Containers\Attributer($Container);
    }
    /* ----------------------------------------- */


    /**
     * +-- データのセット
     *
     * @access      public
     * @return      void
     * @doc_ignore
     * @cover EnviMockLight\Containers\Attributer::__construct
     * @cover Attributer
     */
    public function construct_Test()
    {
        $Container = new \EnviMockLight\Containers\Container;
        $Container->setUsingMethodName('test_Method_Default');
        $Attributer = new \EnviMockLight\Containers\Attributer($Container);
        return $Attributer;
    }
    /* ----------------------------------------- */


    /**
     * +-- データのセット
     *
     * @access      public
     * @return      void
     * @doc_ignore
     * @cover EnviMockLight\Containers\Attributer::setAttribute
     * @cover EnviMockLight\Containers\Attributer::getAll
     * @cover Attributer
     */
    public function setAttribute_DefinedMethodName_Test()
    {
        $this->Attributer->setAttribute('test', 'value', 'test_Method');
        $this->assertArrayHasKey('test_Method', $this->Attributer->getAll());
        $this->assertCount(1, $this->Attributer->getAll());
        return $this->Attributer;
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @param       string $key
     * @param       mexed $default_value OPTIONAL:false
     * @param       string $method_name OPTIONAL:null
     * @return      mexed
     * @doc_ignore
     * @depends setAttribute_DefinedMethodName_Test
     * @cover EnviMockLight\Containers\Attributer::getAttribute
     * @cover Attributer::getAttribute
     */
    public function getAttribute_DefinedMethodName_Test(\EnviMockLight\Containers\Attributer $Attributer)
    {
        $this->assertEquals($Attributer->getAttribute('test', false, 'test_Method'), 'value');
        $this->assertEquals($Attributer->getAttribute('test2', 'あいうえお', 'test_Method'), 'あいうえお');
        $this->assertFalse($Attributer->getAttribute('test', false));
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @param       string $key
     * @param       mexed $default_value OPTIONAL:false
     * @param       string $method_name OPTIONAL:null
     * @return      mexed
     * @doc_ignore
     * @depends setAttribute_DefinedMethodName_Test
     * @cover EnviMockLight\Containers\Attributer::resetAttribute
     * @cover Attributer::getAttribute
     */
    public function resetAttribute_DefinedMethodName_Test(\EnviMockLight\Containers\Attributer $Attributer)
    {
        $Attributer->resetAttribute('test_Method_aaaa');
        $Attributer->resetAttribute();
        $Attributer->resetAttribute('test_Method');
        $this->assertCount(0, $Attributer->getAll());
    }
    /* ----------------------------------------- */




    /**
     * +-- データのセット
     *
     * @access      public
     * @return      void
     * @doc_ignore
     * @cover EnviMockLight\Containers\Attributer::setAttribute
     * @cover EnviMockLight\Containers\Attributer::getAll
     * @cover Attributer
     */
    public function setAttribute_UndefinedMethodName_Test()
    {
        $this->Attributer->setAttribute('test', 'value');
        $this->assertArrayHasKey('test_Method_Default', $this->Attributer->getAll());
        $this->assertCount(1, $this->Attributer->getAll());
        return $this->Attributer;
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @param       string $key
     * @param       mexed $default_value OPTIONAL:false
     * @param       string $method_name OPTIONAL:null
     * @return      mexed
     * @doc_ignore
     * @depends setAttribute_UndefinedMethodName_Test
     * @cover EnviMockLight\Containers\Attributer::getAttribute
     * @cover Attributer::getAttribute
     */
    public function getAttribute_UndefinedMethodName_Test(\EnviMockLight\Containers\Attributer $Attributer)
    {
        $this->assertEquals($Attributer->getAttribute('test', false), 'value');
        $this->assertEquals($Attributer->getAttribute('test', false, 'test_Method_Default'), 'value');
        $this->assertEquals($Attributer->getAttribute('test2', 'あいうえお'), 'あいうえお');
        $this->assertEquals($Attributer->getAttribute('test2', 'あいうえお', 'test_Method_Default'), 'あいうえお');
        $this->assertFalse($Attributer->getAttribute('test', false, 'test_Method123'));
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @param       string $key
     * @param       mexed $default_value OPTIONAL:false
     * @param       string $method_name OPTIONAL:null
     * @return      mexed
     * @doc_ignore
     * @depends setAttribute_UndefinedMethodName_Test
     * @cover EnviMockLight\Containers\Attributer::resetAttribute
     * @cover Attributer::getAttribute
     */
    public function resetAttribute_UndefinedMethodName_Test(\EnviMockLight\Containers\Attributer $Attributer)
    {
        $Attributer->resetAttribute();
        $this->assertCount(0, $Attributer->getAll());
    }
    /* ----------------------------------------- */




    /**
     * +-- データのリセット
     *
     * @access      public
     * @param       string $method_name OPTIONAL:null
     * @return      void
     * @doc_ignore
     * @cover EnviMockLight\Containers\Attributer::resetAttribute
     * @cover Attributer
     */
    public function resetAttributeTest()
    {
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

