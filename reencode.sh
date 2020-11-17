#!/bin/sh

file=$1
vidnum=$((`ls video | sort -r | egrep "[0-9]" | head -c 1`+1))
threads=`cat /proc/cpuinfo | egrep "processor*" | sort -r | awk '{print $3}' | head -c 1`

ffmpeg -i $file -r 1 -t 1 video/previews/${vidnum}.png
ffmpeg -i $file -c:v vp8 -c:a libvorbis -q:v 22 -threads $threads video/${vidnum}.webm
ffmpeg -i $file -c:v libx264 -c:a libfaac -q:v 22 -threads $threads video/${vidnum}.mp4

rm -f $file
