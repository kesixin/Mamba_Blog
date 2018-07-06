<?php

/**
 * BmobException 异常类
 * @author jeff
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobException extends Exception
{
	public function __construct($message="", $code = 0) {
		//codes are only set by a bmob.com error
		if($code != 0){
			$message = "bmob.cn error: ".$message;
		}
		
		parent::__construct($message, $code);
	}

	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

}