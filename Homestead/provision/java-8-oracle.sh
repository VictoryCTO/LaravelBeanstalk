#!/bin/bash

if [ ! -f /usr/lib/jvm/java-8-oracle/bin/java ]; then
  /bin/echo "Provisioning Oracle Java JVM"

  # Make install non-interactive
  /bin/echo "Accepting oracle java license"
  /bin/echo oracle-java8-installer shared/accepted-oracle-license-v1-1 select true | sudo /usr/bin/debconf-set-selections

  # Add apt repo for official Java JVM
  /bin/echo "Adding apt repo for oracle java"
  /bin/echo "deb http://ppa.launchpad.net/webupd8team/java/ubuntu xenial main" | /usr/bin/tee /etc/apt/sources.list.d/webupd8team-java-xenial.list
#  /bin/echo "deb-src http://ppa.launchpad.net/webupd8team/java/ubuntu xenial main" | /usr/bin/tee -a /etc/apt/sources.list.d/webupd8team-java.list

  # Pull key for apt-repo
  /usr/bin/apt-key adv --keyserver keyserver.ubuntu.com --recv-keys EEA14886

  # Install java 8 from repo
  /bin/echo "update packages from java source"
  /usr/bin/apt-get update
  /bin/echo "Installing Java 8 package - this could take a while depending on your connection"
  # Suppress the output of the following command so it doesn't spam the
  # vagrant up output
  /usr/bin/apt-get -y install oracle-java8-installer >/dev/null 2>&1
  /bin/echo "Java 8 package installed"

fi
