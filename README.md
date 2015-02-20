# cutycapt-php
A easy to use PHP library for running CutyCapt

# Install
run `composer require marktopper/cutycapt-php 1.*`

# Usage
```
// creating the instance
$cutycapt = new MarkTopper\CutyCapt\CutyCapt;

// set url to capture
$cutycapt->url('http://google.com');

// save output to location (this have to be the complete path, unless you set base_output)
$cutycapt->output(__DIR__ . '/google.png');

// show the generated image
$cutycapt->show();
```

# Options
### Note
All options are set using `$cutycapt->setOption('value')` where in `setOption` the `Option` is the name of the setting trying to set.   
Like if you want to set the url, then it would be `$cutycapt->setUrl('http://www.example.com')`.   
Same goes with getting options, like getting the url `$cutycapt->getUrl()` returns `http://www.example.com` if that was the url set.

### Option list
coming soon
