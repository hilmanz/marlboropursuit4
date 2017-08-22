#!/bin/bash
CURL="/usr/bin/curl"
GAWK="/usr/bin/awk"
echo -n "Please pass the url you want to measure: "
read url
URL="$url"
result=`$CURL -o /dev/null -s -w %{time_connect}:%{time_starttransfer}:%{time_total} $URL`
echo " Time_Connect | Time_startTransfer | Time_total "
echo $result | $GAWK -F: '{ print $1" | "$2" | "$3}'

