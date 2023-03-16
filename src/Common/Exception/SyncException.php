<?php

namespace WonderGame\CenterUtility\Common\Exception;

use WonderGame\CenterUtility\Common\Http\Code;

/**
 * 同步失败异常
 * Class SyncException
 */
class SyncException extends \Exception
{
	public function __construct($message = "", $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, Code::ERROR_OTHER, $previous);
	}
}
