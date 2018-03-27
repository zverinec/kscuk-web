#!/bin/bash

echo -e "Content-type: text/html\n"

OUTPUT+=$(git fetch origin 2>&1)$'\n\n'
if [ $? -eq 0 ]; then
	OUTPUT+=$(git reset --hard origin/kscuk-web-restyle 2>&1)$'\n\n'
fi

if [ $? -eq 0 ]; then
	OUTPUT+=$(cd .. && rm -rf ./temp/cache 2>&1)$'\n\n'
fi

echo "$OUTPUT" | mail "me@apophis.cz" "v.nem.co@mail.muni.cz" -s "[kscuk-web] Deploy status"