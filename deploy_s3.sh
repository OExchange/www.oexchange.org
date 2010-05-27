#! /bin/bash

if [ $# -eq 0 ]   
then
	echo "FAIL"
  	echo "Usage: deploy_s3 <static assets version num>"
  	exit 1
fi

echo Syncing to /site/$1
s3sync --public-read --verbose --recursive --delete --cache-control='max-age=31536000' _staged/static/$1/ cache.oexchange.org:site/$1
