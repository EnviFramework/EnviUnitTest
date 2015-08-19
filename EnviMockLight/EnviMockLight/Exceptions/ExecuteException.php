<?php
/**
 * モック実行時例外基底クラス
 *
 * モック実行時制限に引っかかった場合に、投げられる例外の基底クラス。
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

namespace EnviMockLight\Exceptions;

/**
 * モック実行時例外基底クラス
 *
 * モック実行時制限に引っかかった場合に、投げられる例外の基底クラス。
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
 * @codeCoverageIgnore
 */
class ExecuteException extends Exception
{
    public $limit_class_name;
    public $limit_method_name;
    public $execution_count;
    public function setLimitClass($setter)
    {
        $this->limit_class_name = $setter;
    }
    public function setLimitMethod($setter)
    {
        $this->limit_method_name = $setter;
    }
    public function setExecutionCount($setter)
    {
        $this->execution_count = $setter;
    }
}
/* ----------------------------------------- */
