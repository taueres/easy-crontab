FROM debian
RUN apt-get update #force
RUN apt-get install -y apt-utils
RUN apt-get install -y php5
RUN apt-get install -y php5-xdebug
RUN apt-get install -y curl vim
RUN apt-get install -y cron
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer
