<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 09.04.14
 * Time: 14:58
 */

namespace system2;

/**
 * Class MotionVlc
 * vlc with motion
 * @package system
 */
class MotionVlc extends DVR {

    /**
     * @param User $user
     */
    function __construct(User $user)
    {
        parent::__construct($user);
    }

    /*public function timelaps(){
        Log::getInstance()->setUserID($this->getUid());
        Log::getInstance()->put(__FUNCTION__, __CLASS__);
        foreach($this->cams as $cam){
            /** var Cam $cam */
            /*Log::getInstance()->put("CID: ".$cam->getID(), __CLASS__);
            $camMotion = $cam->getCamMotion();
            if($camMotion != null ){
                Log::getInstance()->put("CID: ".$cam->getID()." do", __CLASS__);
                $path = $camMotion->getTargetDir();


                $list = "$path/list.txt";
                $filename = $cam->getID()."_".date("Y-m-d_H:i:s").".mp4";

                $createList = new \BashCommand("ls $path/snapshot*.jpg | sort > $list");
                $deleteList = new \BashCommand("rm $list");
                $createTimelaps = new \BashCommand("cat $list | xargs cat | ffmpeg -f image2pipe -r 3 -vcodec mjpeg -i - -vcodec libx264 $path/../$filename");
                $deleteImages = new \BashCommand("cat $list | xargs rm");

                $createList->exec();
                $createTimelaps->exec();

            }
        }
    }*/
} 