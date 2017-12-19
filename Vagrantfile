Vagrant.configure("2") do |config|
  config.vm.box = "bento/ubuntu-16.04"

  config.vm.box_check_update = false

  config.vm.synced_folder ".", "/home/vagrant/memc-client", :mount_options => ['dmode=755', 'fmode=775']

  # config.vm.provision "shell", inline: <<-SHELL
  #   apt install python-software-properties
  #   add-apt-repository ppa:ondrej/php
  #   apt-get update
  #   apt-get install -y php7.1 memcached
  # SHELL
end
