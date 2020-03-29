#!/bin/bash
SAVEIFS=$IFS
IFS=$(echo -en "\n\b")
# set me
FILES=$1/*
for f in $FILES
do
  /usr/bin/ffmpeg -y -i "$f" "${f%.*}.mp4"
done
# restore $IFS
IFS=$SAVEIFS