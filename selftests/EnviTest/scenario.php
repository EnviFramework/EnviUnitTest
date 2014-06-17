<?php
/**
 * テストのScenarioクラス
 *
 *
 * PHP versions 5
 *
 *
 *
 * @category   テスト
 * @package    テスト
 * @subpackage TestCode
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/c/man/v3/reference
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */

require_once dirname(__FILE__).'/testCaseBase.php';

$scenario_dir = dirname(__FILE__).DIRECTORY_SEPARATOR;
define('ENVI_TEST_YML', basename(dirname(__FILE__)).'.yml');
$file_list = array(
    '/EnviUnitTest.php',
    '/EnviUnitTest/EnviTestAssert.php',
    '/EnviUnitTest/EnviUnitTestBase.php',
    '/EnviUnitTest/EnviUnitTestExceptions.php',
    '/EnviMock.php',
    '/CodeParser/EnviCodeParser.php',
    '/CodeParser/CodeParser/EnviParserToken.php',
    '/CodeParser/CodeParser/EnviParserResult.php',
    '/EnviCodeCoverage.php',
    '/CodeCoverage/EnviCodeCoverageParser.php',
    '/CodeCoverage/EnviCodeCoverageDriver.php',
    '/CodeCoverage/EnviCodeCoverageFilter.php',
    '/EnviMock/EnviMockExceptions.php',
    '/EnviMock/EnviMockContainer.php',
    '/EnviMock/EnviMockEditor.php',
    '/EnviMock/EnviMockExecuter.php',
    '/EnviMock/EnviMockEditorRunkit.php',
    '/spyc/Spyc.php',
);
foreach ($file_list as $base_file_path) {
    $from_file_path = ENVI_TEST_BASE_DIR.$base_file_path;
    $to_file_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'copy'.DIRECTORY_SEPARATOR.$base_file_path;
    copy($from_file_path, $to_file_path);
    $file = file($to_file_path);
    $rep_file = array();
    $name_space = 'namespace envitest\unit;'."\n";
    $name_space .= 'use \exception;'."\n";
    $name_space .= 'use \ArrayAccess;'."\n";
    $name_space .= 'use \Countable;'."\n";
    $name_space .= 'use \SeekableIterator;'."\n";
    $name_space .= 'use \ReflectionClass;'."\n";

    foreach ($file as $line) {
        $rep_file[] = $line;
        if ($name_space) {
            $rep_file[] = $name_space;
            $name_space = '';
        }
    }
    file_put_contents($to_file_path, join('', $rep_file));
}

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'copy'.'/EnviUnitTest.php';

/**
 * テストのScenarioクラス
 *
 *
 *
 *
 * @category   テスト
 * @package    テスト
 * @subpackage TestCode
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/c/man/v3/reference
 * @since      File available since Release 1.0.0
 */
class Scenario extends EnviTestScenario
{
    public static $stack_data;

    /**
     * +-- データスタック用
     *
     * @access public
     * @static
     * @param  $k
     * @param  $v
     * @return void
     */
    public static function setAttribute($k, $v)
    {
        self::$stack_data[$k] = $v;
    }
    /* ----------------------------------------- */

    /**
     * +-- スタックしたデータを取得する用
     *
     * @access public
     * @static
     * @param  $k
     * @return void
     */
    public static function getAttribute($k)
    {
        return isset(self::$stack_data[$k]) ? self::$stack_data[$k] : NULL;
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行するテストの配列をYamlから返す
     *
     * @access public
     * @return array
     */
    public function execute()
    {
        if ($this->unit_test->hasOption('--auto')) {
            return parent::execute();
        }
        $arr = array();
        if (!$this->unit_test->hasOption('-s')) {
            foreach ($this->system_conf['scenario']['dirs'] as $dir_name) {
                $arr = $this->getTestByDir($dir_name, 1, $arr);
            }
        } else {
            foreach (explode(',', $this->unit_test->getOption('-s')) as $dir_name) {
                $arr = $this->getTestByDir($this->system_conf['scenario']['dirs'][$dir_name], 1, $arr);
            }
        }
        if ($this->unit_test->hasOption('-t')) {
            $sub_arr = array();
            foreach ($arr as $val) {
                foreach (explode(',', $this->unit_test->getOption('-t')) as $class_name) {
                    if ($val['class_name'] === $class_name) {
                        $sub_arr[] = $val;
                    }
                }
            }
            return $sub_arr;
        }
        return $arr;
    }
    /* ----------------------------------------- */

}
