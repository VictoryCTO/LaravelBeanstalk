#!/bin/bash

/bin/echo "Running apt-get update"
/usr/bin/apt-get update --fix-missing

/bin/echo "Running apt-get upgrade"
DEBIAN_FRONTEND=noninteractive /usr/bin/apt-get -o Dpkg::Options::='--force-confdef' -o Dpkg::Options::='--force-confold' --allow-downgrades --allow-remove-essential --allow-change-held-packages -fuy upgrade


