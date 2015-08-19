<?php
/**
 * モック実行時、実効回数制限
 *
 * 実効回数制限例外(最大)に引っかかった場合に投げられる例外。
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
 * 実効回数制限例外(最大)に引っかかった場合に投げられる例外。
 *
 *
 * @category   自動テスト
 * @package    テストスタブ
 * @subpackage Mock
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @codeCoverageIgnore
 */
class MaxExecutionCountException extends ExecuteException
{
    public $times;

    public function setTimes($setter)
    {
        $this->times = $setter;
        $this->message = $this->limit_class_name.'::'.$this->limit_method_name.' max execution count : '.$this->execution_count.' on '.$setter;
    }
}
/* ----------------------------------------- */

