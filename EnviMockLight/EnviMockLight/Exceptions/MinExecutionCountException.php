<?php
/**
 * モック実行時、実効回数制限
 *
 * 実効回数制限(最小)に引っかかった場合に投げられる例外。
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
 * モック実行時、実効回数制限
 *
 * 実効回数制限(最小)に引っかかった場合に投げられる例外。
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
class MinExecutionCountException extends MaxExecutionCountException
{
    public function setTimes($setter)
    {
        $this->times = $setter;
        $this->message = $this->limit_class_name.'::'.$this->limit_method_name.' min execution count : '.$this->execution_count.' on '.$setter;
    }
}
/* ----------------------------------------- */

