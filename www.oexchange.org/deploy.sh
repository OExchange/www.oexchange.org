#! /bin/bash
TEST=0
OEROOT=oexchange.org

if [ $# -eq 0 ]   
then
	echo "FAIL"
  	echo "Usage: deploy <username>"
  	exit 1
fi
MOREARGS=""
if [ "$TEST" -eq "1" ]
then
	MOREARGS=--dry-run
fi		

echo "Deploying as $1..."
rsync -avrz $MOREARGS --chmod=g+w --delete webroot/ $1@pacer.dreamhost.com:$OEROOT/
