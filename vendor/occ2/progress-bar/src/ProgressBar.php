<?php

namespace OCC2\ProgressBar;

/**
 * Progress bar control for Nette framework
 * @author Milan Onderka
 * @version 1.0.0
 */
class ProgressBar extends \Nette\Application\UI\Control{
    /**
     * @var string
     */
    public $name=null;
    
    /**
     * @var integer
     */
    public $refreshTime=null;
    
    /**
     * @var callable
     */
    public $updater;
    
    /**
     * @var mixed
     */
    private $currentValue=null;
    
    /**
     * @var array
     */
    public $config = [
        "title"=>null, // bar title
        "minValue"=>0, // minimul value
        "maxValue"=>100,// maximum value
        "valuePrefix"=>"", //text before shown value
        "valueSuffix"=>"", // text after shown value
        "showValue"=>true, // show value in progress bar?
        "strippedStyle"=>true, // use stripped style
        "animatedStyle"=>false, // use animated bar
        "colorStyle"=>"info",    // color style / if not set threshold
        "warningThreshold"=>null, // switch to warning style (if not set nothing switched)
        "dangerThreshold"=>null // switch to danger style (if not set nothing switched)
    ];
    
    /**
     * constructor
     * @param string $name name of progress bar
     * @param callable $updater callback that update bar value
     * @param array $config configuration
     * @param integer $refreshTime automatic refresh time in seconds
     * @return void
     */
    public function __construct($name,callable $updater,$config=null,$refreshTime=null){
        $this->updater = $updater;
        $this->refreshTime = $refreshTime;
        $this->name = $name;
        $config!=null ? $this->config = $config : null;
        return;
    }
    
    /**
     * render control
     * @return void
     */
    public function render(){
        if($this->currentValue==null){
            $this->currentValue = call_user_func($this->updater);
        }
        if(isset($this->config["warningThreshold"]) && $this->config["warningThreshold"]!=null){
            $this->config["colorStyle"] = $this->currentValue >= $this->config["warningThreshold"] ? "warning" : $this->config["colorStyle"];
        }
        
        if(isset($this->config["dangerThreshold"]) && $this->config["dangerThreshold"]!=null){
            $this->config["colorStyle"] = $this->currentValue >= $this->config["dangerThreshold"] ? "danger" : $this->config["colorStyle"];
        }
        
        $this->template->name = $this->name;
        $this->template->refreshTime = $this->refreshTime;
        $this->template->currentValue = $this->currentValue;
        $this->template->config = $this->config;
        $this->template->width = ($this->config["maxValue"]-$this->config["minValue"]) * ($this->currentValue/100);
        $this->template->render(__DIR__ . "/progressBar.latte");
        return;
    }
    
    /**
     * reload signal receiver
     * @return void
     */
    public function handleReload(){
        try {
            $this->currentValue = call_user_func($this->updater);
            $this->redrawControl("progressBar");
        } catch (\Exception $ex) {
            dump($ex);
        }
        return;
    }
}
