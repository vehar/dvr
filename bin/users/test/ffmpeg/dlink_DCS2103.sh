#ffmpeg -i http://10.112.30.100:9003/ -r 2 -s 1280x720 -b 4000k /home/calc/vlc/tmp/test/mtn_ubnt_zerkalo_%06d.jpg >/dev/null 2>/dev/null &
ffmpeg -i http://localhost:9004/ -r 2 -s 640x352 -b 4000k /home/calc/vlc/tmp/test/dlink_DCS2103_%06d.jpg >/dev/null 2>/dev/null &
