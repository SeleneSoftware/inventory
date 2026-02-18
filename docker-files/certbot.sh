#!/bin/sh
CMD=docker
if command -v podman >/dev/null 2>&1
then
	CMD=podman
fi


sudo $CMD compose run --rm certbot certonly --manual --preferred-challenges dns -d $1

