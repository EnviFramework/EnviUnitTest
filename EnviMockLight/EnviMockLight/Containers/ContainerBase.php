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
class ContainerBase
{

    protected $Container;
    protected $Process;
    protected $Attributer;


    protected $method_name;

    /**
     * +-- 現在のmethod_nameを取得する
     *
     * @access      public
     * @return      string
     */
    public function getUsingMethodName()
    {
        return $this->method_name;
    }
    /* ----------------------------------------- */

    /**
     * +-- 現在のmethod_nameをセットする
     *
     * @access      public
     * @param       string $method_name
     * @return      void
     */
    public function setUsingMethodName($method_name)
    {
        $this->method_name = $method_name;
    }
    /* ----------------------------------------- */

    /**
     * +-- イニシャライザ
     *
     * @access      protected
     * @return      void
     * @doc_ignore
     */
    protected function initialize()
    {
        $this->Container     = new MainContainer($this);
        $this->Process       = new Process($this);
        $this->Attributer    = new Attributer($this);
    }
    /* ----------------------------------------- */

    public function setProcess($class_name, $method_name, $arguments)
    {
        return $this->Process->setProcess($class_name, $method_name, $arguments);
    }
    public function getProcessAll()
    {
        return $this->Process->getProcessAll();
    }
    public function unsetProcessAll()
    {
        return $this->Process->unsetProcessAll();
    }

    /**
     * +-- コンテナのリセット
     *
     * @access      public
     * @param       string $method_name OPTIONAL:null
     * @return      void
     * @doc_ignore
     */
    public function resetContainer($method_name = null)
    {
        return $this->Container->resetContainer($method_name);
    }
    /* ----------------------------------------- */


    /**
     * +-- コンテナのセット
     *
     * @access      public
     * @param       string $key
     * @param       string $value
     * @param       string $method_name OPTIONAL:null
     * @return      void
     * @doc_ignore
     */
    public function setContainer($key, $value, $method_name = null)
    {
        return $this->Container->setContainer($key, $value, $method_name);
    }
    /* ----------------------------------------- */


    /**
     * +-- コンテナのアンセット
     *
     * @access      public
     * @param       string $key
     * @param       string $value
     * @param       string $method_name OPTIONAL:null
     * @return      void
     * @doc_ignore
     */
    public function unsetContainer($key, $method_name = null)
    {
        return $this->Container->unsetContainer($key, $method_name);
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
    public function getContainer($key, $default_value = false, $method_name = null)
    {
        return $this->Container->getContainer($key, $default_value, $method_name);
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
        return $this->Attributer->setAttribute($key, $value, $method_name);
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
        return $this->Attributer->resetAttribute($method_name);
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
     */
    public function getAttribute($key, $default_value = false, $method_name = null)
    {
        return $this->Attributer->getAttribute($key, $default_value, $method_name);
    }
    /* ----------------------------------------- */
}