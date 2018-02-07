#!/bin/bash

VERSION=$1
IP=$2

/bin/echo "********************************"
/bin/echo " Running elasticsearch.sh "
/bin/echo " Elasticsearch Version: $VERSION"
/bin/echo " Elasticsearch IP: $IP"
/bin/echo "********************************"

# Get key for apt repository
/usr/bin/wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -

# Write the repository to apt sources list
/bin/echo "deb https://artifacts.elastic.co/packages/5.x/apt stable main" | sudo tee -a /etc/apt/sources.list.d/elastic-5.x.list

# Install Elasticsearch via apt repo
/usr/bin/apt-get -y install imagemagick
/usr/bin/apt-get update && /usr/bin/apt-get install elasticsearch=$VERSION

# Change IP address in elasticsearch.yml file to work with our dev vagrant env
NETWORK_HOST="network.host: $IP"
/bin/sed -i "s/^#network.host: 192.168.0.1$/$NETWORK_HOST/g" /etc/elasticsearch/elasticsearch.yml

/bin/systemctl daemon-reload
/bin/systemctl enable  elasticsearch.service 2>&1
/bin/systemctl restart elasticsearch.service

