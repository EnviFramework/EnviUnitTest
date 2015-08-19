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
class BuilderTest extends testCaseBase
{
    public $Builder;


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
        EnviMockLight::_Load();
        $this->Builder = new EnviMockLight\Builders\Builder;
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover EnviMockLight\Builders\Builder::classBuild
     */
    public function classBuild_IsPartial_Test()
    {
        // グローバル名前空間
        $mock_class_name   = $this->Builder->getBuildClassName('Reflection');
        $mocked_class_name = $this->Builder->classBuild('Reflection');
        $this->assertEquals($mock_class_name, $mocked_class_name);

        return $mocked_class_name;
    }
    /* ----------------------------------------- */



    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover EnviMockLight\Builders\Builder::classBuild
     */
    public function classBuild_IsMock_Test()
    {
        $mock_class_name   = $this->Builder->getBuildClassName('SampleSample');
        $mocked_class_name = $this->Builder->classBuild('SampleSample');

        $this->assertEquals($mocked_class_name, $mock_class_name);

        //
        $mock_class_name = $this->Builder->getBuildClassName('TestRoot\Sample');
        $mocked_class_name = $this->Builder->classBuild('TestRoot\Sample');
        $mocked_class_name = $this->Builder->classBuild('TestRoot\Sample');
        $this->assertNotEquals($mock_class_name, $mocked_class_name);
        return $mocked_class_name;
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover EnviMockLight\Builders\Builder::getBuildClassName
     * @depends classBuild_IsPartial_Test
     */
    public function getBuildClassNameTest()
    {
        $res = $this->Builder->getBuildClassName('PDO');
        $this->assertEquals('EnviMockLight_0_PDO', $res);

        $res = $this->Builder->getBuildClassName('Reflection');
        $this->assertEquals('EnviMockLight_1_Reflection', $res);

        $res = $this->Builder->getBuildClassName('TestRoot\Sample');
        $this->assertEquals('EnviMockLight_2_TestRoot_Sample', $res);
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover EnviMockLight\Builders\Builder::classContextBuild
     * @cover EnviMockLight\Builders\Builder::methodBuilder
     * @cover EnviMockLight\Builders\Builder::getCall
     * @cover EnviMockLight\Builders\Builder::getCallStatic
     * @depends classBuild_IsPartial_Test
     */
    public function classContextBuild_MockClass_Test()
    {
        $build_class_name = $this->Builder->getBuildClassName('Foo\Bar');
        $class_context = $this->Builder->classContextBuild($build_class_name, 'Foo\Bar');


        $this->assertFalse(strpos($class_context, "extends Foo\Bar"));

        $this->assertTrue(strpos($class_context, 'public function __call($name, array $arguments) {') !== false);

        $this->assertTrue(strpos($class_context, "if (".'$'."this->___EnviMockContainer()->isStab(".'$'."name)) {") !== false);
        $this->assertTrue(strpos($class_context, 'return $this->___EnviMockExecuter()->execute("Foo\Bar", $name, $arguments, $this);') !== false);
        $this->assertFalse(strpos($class_context, 'return call_user_func_array(array("parent", "__callStatic"), func_get_args());'));

        $this->assertTrue(strpos($class_context, 'public static function __callStatic($name, array $arguments) {') !== false);

    }
    /* ----------------------------------------- */



    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover EnviMockLight\Builders\Builder::classContextBuild
     * @cover EnviMockLight\Builders\Builder::methodBuilder
     * @cover EnviMockLight\Builders\Builder::getCall
     * @cover EnviMockLight\Builders\Builder::getCallStatic
     * @depends classBuild_IsPartial_Test
     */
    public function classContextBuild_WithOutMagicMethod_Test()
    {

        $build_class_name = $this->Builder->getBuildClassName('TestRoot\Sample');
        $class_context = $this->Builder->classContextBuild($build_class_name, 'TestRoot\Sample');

        $this->assertTrue(strpos($class_context, "extends TestRoot\\Sample") !== false);

        $this->assertTrue(strpos($class_context, "public function __construct () {") !== false);
        $this->assertTrue(strpos($class_context, 'return call_user_func_array(array("parent", "__construct"), func_get_args());') !== false);


        $this->assertTrue(strpos($class_context, "public function doSomething () {") !== false);
        $this->assertTrue(strpos($class_context, 'return call_user_func_array(array("parent", "doSomething"), func_get_args());') !== false);

        $this->assertTrue(strpos($class_context, "public function doSomething2 () {") !== false);
        $this->assertTrue(strpos($class_context, 'return call_user_func_array(array("parent", "doSomething2"), func_get_args());') !== false);


        $this->assertTrue(strpos($class_context, "public function time () {") !== false);
        $this->assertTrue(strpos($class_context, 'return call_user_func_array(array("parent", "time"), func_get_args());') !== false);

        // マジックメソッドなしの場合
        $this->assertTrue(strpos($class_context, 'public function __call($name, array $arguments) {') !== false);

        $this->assertTrue(strpos($class_context, "if (".'$'."this->___EnviMockContainer()->isStab(".'$'."name)) {") !== false);
        $this->assertTrue(strpos($class_context, 'return $this->___EnviMockExecuter()->execute("TestRoot\Sample", $name, $arguments, $this);') !== false);
        $this->assertFalse(strpos($class_context, 'return call_user_func_array(array("parent", "__call"), func_get_args());'));

        $this->assertFalse(strpos($class_context, 'public static function __callStatic($name, array $arguments) {') !== false);
        $this->assertFalse(strpos($class_context, 'return call_user_func_array(array("parent", "__callStatic"), func_get_args());'));

    }
    /* ----------------------------------------- */





    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover EnviMockLight\Builders\Builder::classContextBuild
     * @cover EnviMockLight\Builders\Builder::methodBuilder
     * @cover EnviMockLight\Builders\Builder::getCall
     * @cover EnviMockLight\Builders\Builder::getCallStatic
     * @depends classBuild_IsPartial_Test
     */
    public function classContextBuild_WithMagicMethod_Test()
    {

        $build_class_name = $this->Builder->getBuildClassName('TestRoot\Sample2');
        $class_context = $this->Builder->classContextBuild($build_class_name, 'TestRoot\Sample2');

        $this->assertTrue(strpos($class_context, "extends TestRoot\\Sample2") !== false);

        $this->assertTrue(strpos($class_context, "public function __construct () {") !== false);
        $this->assertTrue(strpos($class_context, 'return call_user_func_array(array("parent", "__construct"), func_get_args());') !== false);


        $this->assertTrue(strpos($class_context, "public function doSomething () {") !== false);
        $this->assertTrue(strpos($class_context, 'return call_user_func_array(array("parent", "doSomething"), func_get_args());') !== false);

        $this->assertTrue(strpos($class_context, "public function doSomething2 () {") !== false);
        $this->assertTrue(strpos($class_context, 'return call_user_func_array(array("parent", "doSomething2"), func_get_args());') !== false);


        $this->assertTrue(strpos($class_context, "public function time () {") !== false);
        $this->assertTrue(strpos($class_context, 'return call_user_func_array(array("parent", "time"), func_get_args());') !== false);

        // マジックメソッドなしの場合
        $this->assertTrue(strpos($class_context, 'public function __call($name, array $arguments) {') !== false);

        $this->assertTrue(strpos($class_context, "if (".'$'."this->___EnviMockContainer()->isStab(".'$'."name)) {") !== false);
        $this->assertTrue(strpos($class_context, 'return $this->___EnviMockExecuter()->execute("TestRoot\Sample2", $name, $arguments, $this);') !== false);
        $this->assertTrue(strpos($class_context, 'return call_user_func_array(array("parent", "__call"), func_get_args());') !== false);

        $this->assertFalse(strpos($class_context, 'public static function __callStatic($name, array $arguments) {'));
        $this->assertFalse(strpos($class_context, 'return call_user_func_array(array("parent", "__callStatic"), func_get_args());'));

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
    /* ----------------------------------------- */

}
