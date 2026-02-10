#!/bin/sh

sudo podman compose run --rm certbot certonly --manual --preferred-challenges dns -d $1

