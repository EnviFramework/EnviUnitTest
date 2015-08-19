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
class Process
{

    protected $process_list = array();
    protected static $total_process_list = array();
    public static $self_list = array();

    public function __construct()
    {
        self::$self_list[] = $this;
    }

    /**
     * +-- processを記録する
     *
     * @access      public
     * @param       var_text $class_name
     * @param       var_text $method_name
     * @param       var_text $arguments
     * @return      void
     */
    public function setProcess($class_name, $method_name, $arguments)
    {
        $this->process_list[] = array('class_name' => $class_name, 'method_name' => $method_name, 'arguments' => $arguments);
        self::$total_process_list[] = array('class_name' => $class_name, 'method_name' => $method_name, 'arguments' => $arguments);
    }
    /* ----------------------------------------- */

    /**
     * +-- 記録された全てのプロセスを取得する
     *
     * @access      public
     * @return      array
     */
    public function getProcessAll()
    {
        return $this->process_list;
    }
    /* ----------------------------------------- */

    /**
     * +-- プロセスを全てクリアする
     *
     * @access      public
     * @return      void
     */
    public function unsetProcessAll()
    {
        $this->process_list = array();
    }
    /* ----------------------------------------- */




    /**
     * +-- 記録された全てのプロセスを取得する
     *
     * @access      public
     * @return      array
     */
    public static function getTotalProcessAll()
    {
        return self::$total_process_list;
    }
    /* ----------------------------------------- */

    /**
     * +-- プロセスを全てクリアする
     *
     * @access      public
     * @return      void
     */
    public static function unsetTotalProcessAll()
    {
        self::$total_process_list = array();
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @static
     * @return      void
     * @doc_ignore
     */
    public static function resetSelfList()
    {
        self::$self_list = array();
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @static
     * @return      void
     * @doc_ignore
     */
    public static function getSelfList()
    {
        return self::$self_list;
    }
    /* ----------------------------------------- */

}
