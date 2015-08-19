<?php
/**
 * 引数制限例外
 *
 * モック実行時に、引数制限に引っかかった場合に投げられる例外。
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
 * 引数制限例外
 *
 * モック実行時に、引数制限に引っかかった場合に投げられる例外。
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
class ArgumentException extends ExecuteException
{
    public $argument;
    public function setArgument($setter)
    {
        $this->argument = $setter;
        $this->message = $this->limit_class_name.'::'.$this->limit_method_name.' augments error : '. json_encode($setter[0]) . ' : ' . json_encode($setter[1]);
    }
}
/* ----------------------------------------- */
