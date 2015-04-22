<?php
namespace MarkTopper\CutyCapy;

use MarkTopper\CutyCapt\Command\Generator as CommandGenerator;

class CutyCapt {
  
  protected $CommandGenerator;
  protected static $debug_mode;
  
  function __construct()
  {
    $this->CommandGenerator = new CommandGenerator;
  }
  
  protected function camel_case($str)
  {
  	$str[0] = strtolower($str[0]);
  	$func = create_function('$c', 'return "_" . strtolower($c[1]);');
  	return preg_replace_callback('/([A-Z])/', $func, $str);	
  }
  
  protected function snake_case($str)
  {
  	$str[0] = strtolower($str[0]);
  	$func = create_function('$c', 'return "_" . strtolower($c[1]);');
  	return preg_replace_callback('/([A-Z])/', $func, $str);
  }
  
  protected function getter($key)
  {
  	$method = 'get' . ucfirst($this->camel_case($key));
    return $this->CommandGenerator->$method();
  }
  
  protected function setter($key, $value)
  {
  	$method = 'set' . ucfirst($this->camel_case($key));
    $this->CommandGenerator->$method($value);
    return $this;
  }
  
  public function url($value)
  {
    return $this->setter('url', $value);
  }
  
  public function output($value = null)
  {
    if ($value) $this->CommandGenerator->setOut($value);
    return $this->run();
  }
  
  public function show()
  {
    $this->output();
    
    $out = $this->getOut();
    $base = CommandGenerator::$base_output;
    
    $file = $base . $out;
    
    header("Content-type: image/png");
	readfile("$file");
	exit;
  }
  
  public function run()
  {
	  $command = $this->CommandGenerator->getCommand();
	  exec($command);
	  return $this;
  }
  
  public static function debug($mode = 0)
  {
	  self::$debug_mode = $mode;
	  CommandGenerator::debug($mode);
  }
  
  public function __call($method, $parameters)
  {
    switch(substr($this->snake_case($method), 0, 4))
    {
      case 'get_': return $this->getter(substr($this->snake_case($method), 4)); break;
      case 'set_': return $this->setter(substr($this->snake_case($method), 4), isset($parameters[0]) ? $parameters[0] : null); break;
      default: throw new \Exception('Method "' . $method . '" not found'); break;
    }
  }
  
  public static function __callStatic($method, $parameters)
  {
    switch($this->snake_case($method))
    {
      case 'set_base_output': CommandGenerator::$base_output = isset($parameters[0]) ? $parameters[0] : null; break;
      default: throw new \Exception('Method "' . $method . '" not found'); break;
    }
  }
  
}
