<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 21.05.14
 * Time: 14:43
 */

namespace system2;
/*

http://www.newmediaist.com/n/compiling-nginx-source-centos

nginx.conf

rtmp {
    server {
        listen 1935;
        application myapp {
            live on;
        }
    }
}
*/


/**
 * rtmp stream to nginx or other
 * Class RtmpVlcReStream
 * @package system2
 */
class RtmpVlcReStream extends VlcReStream{

    /**
     * @param ICam $cam
     * @param LiveVlcStream $live
     * @param string $streamName
     */
    function __construct(ICam $cam, LiveVlcStream $live, $streamName = 'rtmp')
    {
        parent::__construct($cam, $live, $streamName);
    }

    /**
     * @param string $transcode
     * @return mixed
     */
    protected function getOutputVlm($transcode = 'transcode{acodec=mp4a,channels=2,samplerate=44100}:')
    {
        //transcode{vcodec=h264,vb=300,fps=25,scale=1,acodec=mp4a,ab=64,channels=2}:
        $path = $this->getPath();
        return "#{$transcode}std{access=rtmp,mux=ffmpeg{mux=flv},dst=rtmp://localhost:1935/$path}";
    }

    /**
     * @return string
     */
    protected function getPath(){
        return 'myapp/stream_'.$this->cam->getID();
    }
}
