#!/bin/bash
export HOME="/root"
export PATH="/sbin:/bin:/usr/sbin:/usr/bin:/opt/aws/bin"

/bin/echo ">>> Supervisor script started..."
# If supervisor is installed
/usr/bin/pip list 2> /dev/null | grep supervisor > /dev/null
if [ $? -eq 0 ]; then
    #Stop the queue worker
    /bin/echo ">>> Stopping worker"
    supervisorctl stop queue-worker
else
    # Supervisor not installed
    # Install supervisor
    /bin/echo ">>> Installing supervisor"
    /usr/bin/pip install supervisor --pre
    /bin/mkdir -p /etc/supervisor/conf.d

    /bin/cp .ebextensions/supervisord/installer/init.template /etc/init.d/supervisord
    /bin/chmod 755 /etc/init.d/supervisord
    /bin/cp .ebextensions/supervisord/installer/sysconfig.template /etc/sysconfig/supervisord
    /bin/mkdir -p /var/run/supervisord/
    /bin/chown webapp:webapp /var/run/supervisord/

    /bin/cp .ebextensions/supervisord/installer/config.template /etc/supervisord.conf
fi

#Stop supervisor
/bin/echo ">>> Stopping supervisor"
/sbin/service supervisord stop

#Deploy new config file
/bin/echo ">>> Setting config"
/bin/cp .ebextensions/supervisord/queue-worker.conf /etc/supervisor/conf.d/queue-worker.conf

#Start supervisor
/bin/echo ">>> Starting supervisor"
/sbin/service supervisord start
