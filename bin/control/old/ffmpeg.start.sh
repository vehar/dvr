#!/bin/bash
#daemon -d
DIR=/home/calc/vlc
#BIN=ffmpeg
CMD=$1
USER=$2
CAM=$3
if [ ! $USER ]; then
    echo "Не указана организация";
    exit 1;
fi
if [ ! $CAM ]; then
    echo "Не указана камера, обрабатываем все";
    #exit 1;
    ALL=1
fi

DATE=`date +%F_%T`
CONF=$DIR/etc/$USER/ffmpeg.conf
PROC=$DIR/proc/$USER

case "$1" in
  start)
    if [ ! -f $CONF ]; then
      echo $CONF" не существует"
      exit 1;
    fi
    if [ ! $ALL ]; then
      CAMS=$CAM;
    else
      CAMS=`cat $CONF`;
    fi
    for CAM in $CAMS
    do
      #проверить pid файл
      #запустить скрипт
      PIDF=$PROC/ffmpeg_$CAM.pid
      if [ -f $PIDF ]; then
        echo "ffmpeg для камеры $CAM уже запущен или мертв";
      else
        echo "запускаем ffmpeg для $CAM";
        $DIR/bin/$USER/ffmpeg/$CAM.sh
        PS=`ps -aef | grep ffmpeg | grep $CAM | grep -v bash | grep -v ffmpeg.start | grep -v grep`
        PID=`echo $PS | awk '{print $2}'`
        echo $PID > $PIDF
      fi
    done
  ;;
  stop)
    if [ ! -f $CONF ]; then
      echo $CONF" не существует, придется чистить в ручную... :("
      exit 1;
    fi
    if [ ! $ALL ]; then
      CAMS=$CAM;
    else
      CAMS=`cat $CONF`;
    fi
    for CAM in $CAMS
    do
      #проверить pid файл
      #убить скрипт скрипт
      PIDF=$PROC/ffmpeg_$CAM.pid
      if [ ! -f $PIDF ]; then
        echo "ffmpeg для камеры $CAM не запущен, судя по отсутствию pid файла";
      else
        echo "убиваем ffmpeg для камеры $CAM";
        kill `cat $PIDF`
        rm $PIDF
      fi
    done
  ;;
  restart)
    $0 stop  $USER
    $0 start $USER
  ;;
  *)
  echo "Usage: $0 {start} org_name port daemon"
  exit 1
esac

exit 0
