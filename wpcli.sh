#!/bin/sh

docker run -it  --volumes-from wordpress-majin --network container:wordpress-majin wordpress:cli ${@:1}
