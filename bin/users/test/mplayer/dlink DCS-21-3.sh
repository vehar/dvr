#mplayer -noconsolecontrols http://localhost:9004 -sstep 10 -vo jpeg:outdir=/home/calc/vlc/tmp/test/dlink DCS-21-3 >> /dev/null 2>>/dev/null &
#fps не использовать, так как спустя 20 секунд он игнорируется!!!
mplayer -noconsolecontrols http://localhost:9004 -sstep 10 -vf scale=720:368 -vo jpeg:outdir=/home/calc/vlc/tmp/test/dlink DCS-21-3 >> /dev/null 2>>/dev/null &
