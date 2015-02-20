<?php
namespace MarkTopper\CutyCapy;

use MarkTopper\CutyCapt\Command\Generator as CommandGenerator;
class CutyCapt {
  
  protected $CommandGenerator;
  
  function __construct()
  {
    $this->CommandGenerator = new CommandGenerator;
  }
  
  protected function getter($key)
  {
    $this->CommandGenerator->getter($key);
    return $this;
  }
  
  protected function setter($key, $value)
  {
    $this->CommandGenerator->setter($key, $value);
    return $this;
  }
  
  public function url($value)
  {
    return $this->setter('url', $value);
  }
  
  public function output($value = null)
  {
    if ($this->value) $this->CommandGenerator->setOutput($value);
    $this->run();
  }
  
  public function show()
  {
    $this->output();
    return $this->CommandGenerator->getOutput();
  }
  
  public function __call($method, $parameters)
  {
    swtich(substr(snake_case($method), 0, 4))
    {
      case 'get_': return $this->getter(substr(snake_case($method), 4)); break;
      case 'set_': return $this->getter(substr(snake_case($method), 4), isset($parameters[0]) ? $parameters[0] : null); break;
    }
    
    throw new Exception('Method " . $method . " not found');
  }
  
}
