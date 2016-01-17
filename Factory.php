<?php 
/*-------------------------------------------------------
*
*   Roman Kovalyshyn // robots Factory
*   Copyright © 2016
*
*---------------------------------------------------------
*/

// main factory
class Factory {
	private $aTypes = array();
	private $aRobots = array();
	
	public function addType($oType) {
		if (is_object($oType) && !isset($this->aTypes[$oType->getName()])){
			$this->aTypes[$oType->getName()] = $oType;
		}
		return;
	}
	// it will be better to use "create()" method with "TypeName" and "Count" parameters and don't duplicate code!
	public function createMyHydra1($iCount) {
		if (isset($this->aTypes['MyHydra1']) && is_numeric($iCount)) {
			$this->aRobots = array();
			for ($i=1; $i<=$iCount; $i++){
				$this->aRobots[] = clone $this->aTypes['MyHydra1'];
			}
			return $this->aRobots;
		}
		return false;
	}
	public function createMyHydra2($iCount) {
		if (isset($this->aTypes['MyHydra2']) && is_numeric($iCount)) {
			$this->aRobots = array();
			for ($i=1; $i<=$iCount; $i++){
				$this->aRobots[] = clone $this->aTypes['MyHydra2'];
			}
			return $this->aRobots;
		}
		return false;
	}
	public function createUnionRobot($iCount) {
		if (isset($this->aTypes['UnionRobot']) && is_numeric($iCount)) {
			$this->aRobots = array();
			for ($i=1; $i<=$iCount; $i++){
				$this->aRobots[] = clone $this->aTypes['UnionRobot'];
			}
			return $this->aRobots;
		}
		return false;
	}
}

// main options for robots, all robots extends this
abstract class RobotType {
	protected $sTypeName;
	protected $iWeight;
	protected $iSpeed;
	protected $iHeight;
	
	public function getName(){
		return $this->sTypeName;
	}
	public function getSpeed(){
		return $this->iSpeed;
	}
	public function getWeight(){
		return $this->iWeight;
	}
	public function getHeight(){
		return $this->iHeight;
	}
	// setting parameters of robot Type
	public function setName($value){
		$this->sTypeName = $value;
	}
	public function setSpeed($value){
		$this->iSpeed = $value;
	}
	public function setWeight($value){
		$this->iWeight = $value;
	}
	public function setHeight($value){
		$this->iHeight = $value;
	}
}

// type MyHydra1 with parameters
class MyHydra1 extends RobotType {
	protected $sTypeName = 'MyHydra1';
	protected $iWeight = 22;
	protected $iSpeed = 40;
	protected $iHeight = 120;
}

// type MyHydra2 with parameters
class MyHydra2 extends RobotType {
	protected $sTypeName = 'MyHydra2';
	protected $iWeight = 35;
	protected $iSpeed = 22;
	protected $iHeight = 140;
}

// type UnionRobot with parameters
class UnionRobot extends RobotType {
	protected $aRobots = array();
	protected $sTypeName = 'UnionRobot';
	protected $iWeight = 0;
	protected $iSpeed = 0;
	protected $iHeight = 0;

	public function addRobot($robot){
		if (is_object($robot)){
			$this->aRobots[] = $robot;
			$this->mergeRobots();
		} else if(is_array($robot)) {
			foreach ($robot as $oRobot) {
				$this->aRobots[] = $oRobot;
			}
			$this->mergeRobots();
		} else {
			return false;
		}
	}
	// here I have made every time merging of all added robots, it can be not as fast as method of merging new added robot to general parameters of previous merging, but here we can make some methods to change the way of robots merging and it will be easy to do with array of all robots
	protected function mergeRobots(){
		$this->iSpeed = 0;
		$this->iWeight = 0;
		$this->iHeight = 0;
		foreach ($this->aRobots as $oRobot) {
			if ($this->iSpeed === 0 || $oRobot->getSpeed() < $this->iSpeed){
				$this->iSpeed = $oRobot->getSpeed();
			}
			$this->iWeight = $this->iWeight + $oRobot->getWeight();
			$this->iHeight = $this->iHeight + $oRobot->getHeight();
		}
	}
}

$factory = new Factory();

$factory->addType(new MyHydra1());
$factory->addType(new MyHydra2());

var_dump($factory->createMyHydra1(5));
var_dump($factory->createMyHydra2(2));

$unionRobot = new UnionRobot();
$unionRobot->addRobot(new MyHydra1());
$unionRobot->addRobot($factory->createMyHydra2(2));

$factory->addType($unionRobot);
$aUnRobot = $factory->createUnionRobot(1);
$res = reset($aUnRobot);

echo $res->getSpeed().'<br>';
echo $res->getWeight().'<br>';
?>
