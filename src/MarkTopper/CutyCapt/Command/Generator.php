<?php
namespace MarkTopper\CutyCapt\Command;

use MarkTopper\Validator\Validator;

class Generator {
	
	protected $values = array(
		// The URL to capture (http:...|file:...|...)
		'url' => [
			'required' => true,
			'validate' => 'is_url'
		],
		// The target file (.png|pdf|ps|svg|jpeg|...)
		'out' => [
			'required' => true,
			'validate' => 'is_path'
		],
		// Like extension in --out, overrides heuristic
		'out-format' => [
			'validate' => 'is_valid_out_format'
		],
		// Minimal width for the image (default: 800)
		'min-width' => [
			'validate' => 'is_int'
		],
		// Minimal height for the image (default: 600)
		'min-height' => [
			'validate' => 'is_int'
		],
		// Don't wait more than (default: 90000, inf: 0)
		'max-wait' => [
			'validate' => 'is_int'
		],
		// After successful load, wait (default: 0)
		'delay' => [
			'validate' => 'is_int'
		],
		// Location of user style sheet file, if any
		'user-style-path' => [
			'validate' => 'is_stylesheet'
		],
		// User style rules specified as text
		'user-style-string' => [
			'validate' => 'is_css'
		],
		// User style rules specified as text
		'header' => [
			'validate' => 'is_header_string'
		],
		// Specifies the request method (default: get)
		'method' => [
			'validate' => 'is_http_method'
		],
		// Unencoded request body (default: none)
		'body-string' => [
			'validate' => 'is_http_body_request_string'
		],
		// Base64-encoded request body (default: none)
			'body-base64' => [
			'required' => false,
			'validate' => 'is_http_body_request_string',
			'encoded' => true,
			'encoding' => 'base64'
		],
		// appName used in User-Agent; default is none
		'app-name' => [],
		// appVers used in User-Agent; default is none
		'app-version' => [],
		// Override the User-Agent header Qt would set
		'user-agent' => [],
		// JavaScript execution (default: on)
		'javascript' => [
			'validate' => 'is_on_off'
		],
		// Java execution (default: unknown)
		'java' => [
			'validate' => 'is_on_off'
		],
		// Plugin execution (default: unknown)
		'plugins' => [
			'validate' => 'is_on_off'
		],
		// Private browsing (default: unknown)
		'private-browsing' => [
			'validate' => 'is_on_off'
		],
		// Automatic image loading (default: on)
		'auto-load-images' => [
			'validate' => 'is_on_off'
		],
		// Script can open windows? (default: unknown)
		'js-can-open-windows' => [
			'validate' => 'is_on_off'
		],
		// Script clipboard privs (default: unknown)
		'js-can-access-clipboard' => [
			'validate' => 'is_on_off'
		],
		// Backgrounds in PDF/PS output (default: off)
		'print-backgrounds' => [
			'validate' => 'is_on_off'
		],
		// Page zoom factor (default: no zooming)
		'zoom-factor' => [
			'validate' => 'is_float'
		],
		// Whether to zoom only the text (default: off)
		'zoom-text-only' => [
			'validate' => 'is_on_off'
		],
		// Address for HTTP proxy server (default: none)
		'http-proxy' => [
			'validate' => 'is_url'
		]
	);
  
	protected $valid_out_formats = array('svg', 'pdf', 'ps', 'png', 'jpeg', 'tiff', 'gif', 'bmp', 'ppm', 'xbm', 'xpm', 'jpg', 'itext', 'html', 'rtree', 'mng');
	
	public static $base_output;
	
	protected function is_valid_out_format($format)
	{
		return in_array($format, $this->valid_out_formats);
	}
	
	protected function validator($value, $rules)
	{
		$method = camel_case($rules['validate']);
		if (method_exists($this, $method)) return $this->$method($value, $rules);
		return Validator::single($value, $rules);
	}
	
	public function getCommand()
	{
		$command = xvfb_run_path() . " --server-args=\"-screen 0, 1280x1024x24\" " . cutycapt_path() . " ";
		//--url=http://www.google.com --out=google.png";
		
		//Validator::$error_mode = 'fail';
		
		foreach ($this->values AS $key => $value)
		{
			// Validator::single($value);
			if (isset($value['value']))
			$command .= " --" . $key . "=" . $value['value'];
		}
		
		return $command;
	}
	
	protected function setter($key, $value)
	{
		$key = str_replace('_', '-', $key);
		if (isset($this->values[$key])) $this->values[$key]['value'] = $value;
		return $this;
	}
	
	protected function getter($key)
	{
		$key = str_replace('_', '-', $key);
		return isset($this->values[$key]) && isset($this->values[$key]['value']) ? $this->values[$key]['value'] : null;
	}
	
	public function __call($method, $parameters)
	{
		switch (substr(snake_case($method), 0, 4))
		{
			case 'get_': return $this->getter(substr(snake_case($method), 4)); break;
			case 'set_': return $this->setter(substr(snake_case($method), 4), isset($parameters[0]) ? $parameters[0] : null); break;
		}
		
		die('method "' . $method . '" does not exists');
	}
	
}
