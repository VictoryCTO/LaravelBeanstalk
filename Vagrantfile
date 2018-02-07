# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'json'
require 'yaml'

VAGRANTFILE_API_VERSION ||= "2"

confDir = $confDir ||= File.expand_path("Homestead", File.dirname(__FILE__))
homesteadYamlPath = File.expand_path("Homestead/Homestead.yaml", File.dirname(__FILE__))
homesteadJsonPath = File.expand_path("Homestead.json", File.dirname(__FILE__))
afterScriptPath = "Homestead/after.sh"
require File.expand_path(confDir + '/scripts/homestead.rb')

Vagrant.require_version '>= 1.9.0'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  # Update and upgrade Ubuntu 16.04 apt packages
  apt_upgrade_script = "Homestead/provision/apt-get-upgrade.sh"
  if File.exist? apt_upgrade_script
    config.vm.provision :shell, path: apt_upgrade_script
  end

  # Install Official Java 8 from Oracle
  java_install_script = "Homestead/provision/java-8-oracle.sh"
  if File.exist? java_install_script
    config.vm.provision :shell, path: java_install_script
  end

  # Provision Homestead aliases
  aliases_path = "Homestead/aliases"
  if File.exist? aliases_path
    config.vm.provision :file, source: aliases_path, destination: "/tmp/bash_aliases"
    config.vm.provision :shell do |s|
      s.inline = "awk '{ sub(\"\r$\", \"\"); print }' /tmp/bash_aliases > /home/vagrant/.bash_aliases"
    end
  end

  # Homestead configuration
  if File.exist? homesteadYamlPath
    settings = YAML::load(File.read(homesteadYamlPath))
  elsif File.exist? homesteadJsonPath
    settings = JSON.parse(File.read(homesteadJsonPath))
  else
    abort "Homestead settings file not found in #{confDir}"
  end
  Homestead.configure(config, settings)

  if defined? VagrantPlugins::HostsUpdater
    config.hostsupdater.aliases = settings['sites'].map { |site| site['map'] }
  end

  # npm run is different for windows and linux
  if Vagrant::Util::Platform.windows? then
    config.vm.provision :shell, :inline => "npm install --no-bin-links --prefix=/home/vagrant/code"
  else
    config.vm.provision :shell, :inline => "npm install --prefix=/home/vagrant/code"
  end

  config.vm.provision :shell, :inline => "sysctl -w vm.max_map_count=262144", run: 'always'

  # Install elasticsearch
  elasticsearch_script = "Homestead/provision/elasticsearch.sh"
  if File.exist? elasticsearch_script
    config.vm.provision :shell, path: elasticsearch_script
  end

  # Homestead after.sh script
  if File.exist? afterScriptPath then
    config.vm.provision :shell, path: afterScriptPath, privileged: false
  end

  # Copy developers .gitconfig to vagrant home directory
  if File.exists? "~/.gitconfig"
    config.vm.provision :file, source: "~/.gitconfig", destination: ".gitconfig"
  end

end
