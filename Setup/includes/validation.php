<?php
class Validation extends Validation_Core
{
	function validate_system_path($value, $params = array())
	{
		if ( !is_file(rtrim($value, '/').'/Conf.d/dbconf.php') || !is_writable(rtrim($value, '/').'/Conf.d/dbconf.php') ) {
			$this->error = rtrim($value, '/').'/Conf.d/dbconf.php file does not exist or is not writeable.';
			return false;
		}
		return true;
	}
}