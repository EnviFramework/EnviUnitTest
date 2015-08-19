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
class Attributer
{
    protected $attribute;
    protected $Container;

    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       Container $Container
     * @return      void
     */
    public function __construct(Container $Container)
    {
        $this->Container = $Container;
    }
    /* ----------------------------------------- */

    /**
     * +-- データのセット
     *
     * @access      public
     * @param       string $key
     * @param       string $value
     * @param       string $method_name OPTIONAL:null
     * @return      void
     * @doc_ignore
     */
    public function setAttribute($key, $value, $method_name = null)
    {
        $method_name = is_null($method_name) ? $this->Container->getUsingMethodName() : $method_name;
        $this->attribute[$method_name][$key] = $value;
    }
    /* ----------------------------------------- */



    /**
     * +-- データのリセット
     *
     * @access      public
     * @param       string $method_name OPTIONAL:null
     * @return      void
     * @doc_ignore
     */
    public function resetAttribute($method_name = null)
    {
        $method_name = is_null($method_name) ? $this->Container->getUsingMethodName() : $method_name;

        if (isset($this->attribute[$method_name])) {
            unset($this->attribute[$method_name]);
        }
    }
    /* ----------------------------------------- */


    /**
     * +-- データの取得
     *
     * @access      public
     * @param       string $key
     * @param       mexed $default_value OPTIONAL:false
     * @param       string $method_name OPTIONAL:null
     * @return      mexed
     * @doc_ignore
     */
    public function getAttribute($key, $default_value = false, $method_name = null)
    {
        $method_name = is_null($method_name) ? $this->Container->getUsingMethodName() : $method_name;
        return isset($this->attribute[$method_name][$key]) ? $this->attribute[$method_name][$key] : $default_value;
    }
    /* ----------------------------------------- */

    /**
     * +-- 全てを出力
     *
     * @access      public
     * @return      array
     */
    public function getAll()
    {
        return $this->attribute;
    }
    /* ----------------------------------------- */
}
