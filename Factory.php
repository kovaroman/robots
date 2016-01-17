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
	public function createUnionRobot() {
		
	}
}

// main options for robots, all robots extends this
abstract class RobotType {
	private $sTypeName;
	private $iWeight;
	private $iSpeed;
	private $iHeight;
	
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
	// here we can make some methods for setting parameters of each robot Type
}

// type MyHydra1 with parameters
class MyHydra1 extends RobotType {
	private $sTypeName = 'MyHydra1';
	private $iWeight = 22;
	private $iSpeed = 40;
	private $iHeight = 120;
}

// type MyHydra2 with parameters
class MyHydra2 extends RobotType {
	private $sTypeName = 'MyHydra2';
	private $iWeight = 35;
	private $iSpeed = 22;
	private $iHeight = 140;
}

$factory = new Factory();

$factory->addType(new MyHydra1());
$factory->addType(new MyHydra2());

var_dump($factory->createMyHydra1(5));
var_dump($factory->createMyHydra2(2));
?>
