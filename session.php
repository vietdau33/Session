<?php 

class Session{

	protected $name;

	public function __construct($name, $flagNew = false){
		if(!isset($_SESSION)){
			session_start();
		}
		if($flagNew){
			unset($_SESSION[$name]);
		}
		if(!isset($_SESSION[$name])){
			$_SESSION[$name] = [];
		}
		$this->name = $name;
	}
	public function getName(){
		return $this->name;
	}
	public function hasSession($name){
		return !!$this->getSession($name);
	}
	public function get($name = null){
		if(is_null($name))
			return $_SESSION[$this->name];
		return $this->getSession($name);
	}
	public function set($name, $value){
		$this->setSection($_SESSION[$this->name], $name, $value);
	}
	public function setByArray(array $aryData = []){
	    if(empty($aryData)) return true;
	    foreach ($aryData as $name => $value){
	        $this->set($name, $value);
        }
	    return true;
    }
	public function unset($name){
		return $this->unsetSession($_SESSION[$this->name], $name);
	}
	public function die(){
		unset($_SESSION[$this->name]);
		return true;
	}
	private function unsetSession(&$valire, $name){
		$name = explode('.', $name);
		$n = $name[count($name) - 1];
		foreach ($name as $v) {
			if(!isset($valire[$v])){
				return true;
			}
			if($v == $n){
				unset($valire[$v]);
				return true;
			}
			array_splice($name, 0, 1);
			$this->unsetSession($valire[$v], $name);
			break;
		}
	}
	private function setSection(&$valire, $name, $value){
		$name = explode('.', $name);
		$n = $name[count($name) - 1];
		foreach ($name as $v) {
			if($v == $n){
				$valire[$v] = $value;
				return true;
			}
			array_splice($name, 0, 1);
			$this->setSection($valire[$v], $name, $value);
			break;
		}
	}
	private function getSession($name){
		$name = explode('.', $name);
		$valire = $_SESSION[$this->name];
		foreach ($name as $n) {
			if(!isset($valire[$n])){
				return false;
			}
			$valire = $valire[$n];
		}
		return $valire;
	}
	public function all(){
	    return $_SESSION[$this->name];
    }
}
