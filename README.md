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

# Methods
### url
Sets the url to capture
```
$cutycapt->url('http://example.com');
```

### output
Sets the url to capture (This have to be the comlete path)
```
$cutycapt->output(__DIR__ . '/example.png');
```

### show
Output the image and stop execution
```
$cutycapt->show();
```
