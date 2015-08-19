<?php
namespace EnviMockLight\Containers;

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
