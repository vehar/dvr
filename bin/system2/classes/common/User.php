<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 12.05.14
 * Time: 15:41
 */

namespace system2;

/**
 * Class User
 * @package system2
 */
class User implements IUser {
    protected $id;

    /**
     * @var array
     */
    protected $dvrs = array();

    /**
     * @param $id
     */
    function __construct($id)
    {
        $this->id = $id;
        $this->log(__FUNCTION__);

        $this->create();
    }

    /**
     * @return int
     */
    public function getID(){
        return $this->id;
    }

    final public function create()
    {
        $this->log(__FUNCTION__);

        //todo убрать массив, скомпановать
        $dvr = AbstractFactory::getInstance()->createDvr($this);
        $this->dvrs[$dvr->getID()] = $dvr;

        //$this->_create();
    }

    //abstract protected function _create();

    public function start()
    {
        $this->log(__FUNCTION__);
        foreach($this->dvrs as $dvr){
            /** @var $dvr IDVR */
            $dvr->start();
        }
    }

    public function stop()
    {
        $this->log(__FUNCTION__);
        foreach($this->dvrs as $dvr){
            /** @var $dvr IDVR */
            $dvr->stop();
        }
    }

    public function restart()
    {
        $this->log(__FUNCTION__);
        foreach($this->dvrs as $dvr){
            /** @var $dvr IDVR */
            $dvr->restart();
        }
    }

    public function update()
    {
        $this->log(__FUNCTION__);
        foreach($this->dvrs as $dvr){
            /** @var $dvr IDVR */
            $dvr->update();
        }
    }

    /**
     * @param $dvrID
     * @return DVR|null
     */
    public function getDVR($dvrID){
        if(isset($this->dvrs[$dvrID]))
            return $this->dvrs[$dvrID];
        else
            return null;
    }

    /**
     * @param $camID
     * @return null|Cam
     */
    public function getCam($camID){
        return $this->getDVR($this->getID())->getCam($camID);
    }

    /**
     * @return array
     */
    public function getDVRs(){
        return $this->dvrs;
    }

    /**
     * @param $message
     */
    final protected function log($message)
    {
        Log::getInstance($this->id)->put($message, $this);
    }


}
