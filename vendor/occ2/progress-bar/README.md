# ProgressBar
Simple progress bar control for Nette Framework.

### Requirements:
PHP >=5.6
Nette >=2.4
Twitter Bootstrap >=3 (not for version 4)
nette.ajax.js

###Installation:
composer require occ2/progress-bar

- copy assets/autorefresh.ajax.js to your_www_js_dir/ext and link it in your page.
- don't forget to have Twitter bootstrap css and js files linked to your page

## Usage in presenter
```php
public function createComponentProgressBar(){
        $m=$this->model;
        $callback = function() use($m){
            return $m->getValue(); //change what you need .. must return integer !!
        };
        $config = [
            "title"=>"BAR TITLE", // bar title
            "minValue"=>0, // minimul value
            "maxValue"=>100,// maximum value
            "valuePrefix"=>"", // text before shown value
            "valueSuffix"=>"%", // text after shown value
            "showValue"=>true, // show value in progress bar?
            "strippedStyle"=>true, // use stripped style
            "animatedStyle"=>true, // use animated bar
            "colorStyle"=>"success" // color style (available info/warning/success/danger)
            "warningThreshold"=>null, // switch to warning style (if null nothing switched)
            "dangerThreshold"=>null // switch to danger style (if null nothing switched)
            ];
        $refreshTime = 3; // time to automatic AJAX refresh (set null if autorefresh disabled)
        return new \OCC2\ProgressBar\ProgressBar("cpuLoad", $callback, $config, $refreshTime);
}
```

###Usage in latte template
```latte
{control progressBar}
```

### Usage of autorefresh.ajax.sh
1. During $.nette.init() all elements with class .autorefresh is found and read url ant time
2. URL of autorefresh is in data-refresh-url attribute
3. Refresh time is in data-refresh-time attribute