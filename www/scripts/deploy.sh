#!/bin/bash

echo -e "Content-type: text/html\n"

OUTPUT+=$(git fetch origin 2>&1)$'\n\n'
if [ $? -eq 0 ]; then
	OUTPUT+=$(git reset --hard origin/master 2>&1)$'\n\n'
fi

if [ $? -eq 0 ]; then
	OUTPUT+=$(cd ../.. && rm -rf ./temp/cache 2>&1)$'\n\n'
fi

echo "$OUTPUT" | mail "kscuk@fi.muni.cz" -s "[kscuk-web] Deploy status"
