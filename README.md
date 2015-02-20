# cutycapt-php
A easy to use PHP library for running CutyCapt

# Install
run `composer require marktopper/cutycapt-php 1.*`

# Usage
```
// creating the instance
$cutycapt = new MarkTopper\CutyCapt\CutyCapt;

// set url to capture
$cutycapt->setUrl('http://google.com');

// set output (this have to be the complete path)
$cutycapt->setUrl(__DIR__ . '/google.png');

// get generated command
$cutycapt->setCommand();

// run the command
$cutycapt->run();
```

# Options
### Note
All options are set using `$cutycapt->setOption('value')` where in `setOption` the `Option` is the name of the setting trying to set.   
Like if you want to set the url, then it would be `$cutycapt->setUrl('http://www.example.com')`.   
Same goes with getting options, like getting the url `$cutycapt->getUrl()` returns `http://www.example.com` if that was the url set.

### Option list
coming soon
