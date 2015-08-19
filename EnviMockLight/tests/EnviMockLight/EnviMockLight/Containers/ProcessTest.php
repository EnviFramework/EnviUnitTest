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
class ProcessTest extends testCaseBase
{

    protected $Process;


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
        $this->Process = new \EnviMockLight\Containers\Process($Container);
    }
    /* ----------------------------------------- */



    /**
     * +-- データのセット
     *
     * @access      public
     * @return      void
     * @doc_ignore
     * @cover EnviMockLight\Containers\Process::__construct
     * @cover Attributer
     */
    public function construct_Test()
    {
        $Container = new \EnviMockLight\Containers\Container;
        $Container->setUsingMethodName('test_Method_Default');
        $Process = new \EnviMockLight\Containers\Process($Container);
        return $Process;
    }
    /* ----------------------------------------- */



    /**
     * +-- processを記録する
     *
     * @access      public
     * @return      void
     * @cover EnviMockLight\Containers\Process::setProcess
     * @cover EnviMockLight\Containers\Process::getProcessAll
     */
    public function setProcess_Test()
    {
        $this->Process->setProcess($class_name = __CLASS__, $method_name = __METHOD__, $arguments = array(1, 2, 3));
        $this->assertCount(1, $this->Process ->getProcessAll());
        $this->assertEquals(array(array('class_name' => $class_name, 'method_name' => $method_name, 'arguments' => $arguments)), $this->Process ->getProcessAll());
        $this->Process->setProcess($class_name2 = __CLASS__, $method_name2 = __METHOD__, $arguments2 = array(1, 2, 4));
        $this->assertCount(2, $this->Process ->getProcessAll());
        $this->assertEquals(array(array('class_name' => $class_name, 'method_name' => $method_name, 'arguments' => $arguments), array('class_name' => $class_name2, 'method_name' => $method_name2, 'arguments' => $arguments2)), $this->Process ->getProcessAll());
        return $this->Process;
    }
    /* ----------------------------------------- */


    /**
     * +-- プロセスを全てクリアする
     *
     * @access      public
     * @return      void
     * @cover EnviMockLight\Containers\Process::unsetProcessAll
     * @cover EnviMockLight\Containers\Process::getProcessAll
     * @depends setProcess_Test
     */
    public function unsetProcessAll_Test($Process)
    {
        $this->assertCount(2, $Process->getProcessAll());
        $Process ->unsetProcessAll();
        $this->assertCount(0, $Process->getProcessAll());
        $this->assertCount(0, $this->Process->getProcessAll());
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
