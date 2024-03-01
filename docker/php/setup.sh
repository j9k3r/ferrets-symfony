#!/bin/bash

if ! [ -d /app/public/ ]; then
  echo "$SYMFONY_VERSION"
	mkdir  /app/docker/tmp;
	composer create-project symfony/skeleton:"$SYMFONY_VERSION" /app/docker/tmp/;
	echo '.idea' >> /app/docker/tmp/.gitignore;
	cp -r /app/docker/tmp/. /app/;
	rm -R /app/docker/tmp/;
fi