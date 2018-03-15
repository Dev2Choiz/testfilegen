#!/bin/bash

docker/stopservices.sh
docker/rmcontainer.sh

#docker-compose build --no-cache
docker-compose build
docker-compose up -d

sleep 2 && sh ./initAppli.sh;
