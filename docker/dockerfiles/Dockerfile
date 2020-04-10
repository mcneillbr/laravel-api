FROM alpine:latest
LABEL Maintainer="Marcelo Nenzinho <mcneill.marcelo@outlook.com>" \
      Description="Lightweight container with Nginx 1.16 & PHP-FPM 7.3 based on Alpine Linux."

ENV HOME_PRJ html
ENV WWW_HOME /var/www

#https://hub.docker.com/r/trafex/alpine-nginx-php7/

RUN apk --update add bash wget

# create nginx user/group first, to be consistent throughout docker variants
RUN set -x \
    && addgroup -g 101 -S nginx \
    && adduser -S -D -H -u 101 -h /var/cache/nginx -s /sbin/nologin -G nginx -g nginx nginx 

RUN apk --no-cache add nginx supervisor curl


# trust this project public key to trust the packages.
ADD https://dl.bintray.com/php-alpine/key/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub

## you may join the multiple run lines here to make it a single layer

# make sure you can use HTTPS
RUN apk --update add ca-certificates icu-libs

# add the repository, make sure you replace the correct versions if you want.
RUN echo "https://dl.bintray.com/php-alpine/v3.9/php-7.3" >> /etc/apk/repositories

# install php and some extensions
RUN apk --no-cache --update add php7 \
                    php-common \
                    php-cli \
                    php7-fpm \
                    php-mysqlnd \
                    php7-json \
                    php7-openssl \
                    php7-curl \
                    php7-zlib \
                    php-zip \
                    php7-xml \
                    php7-phar \
                    php7-intl \
                    php7-dom \
                    php-xsl \
                    php7-xmlreader \
                    php7-ctype \
                    php7-session \
                    php7-mbstring \
                    php7-gd \
                    php-pcntl \
                    php-sqlite3 \
                    php-pdo \
                    php-pdo_mysql \
                    php-pdo_sqlite \
                    php-pdo_pgsql \
                    php-pear \
                    php-phar \
                    php-phpdbg \
                    php-iconv \
                    php-calendar \
                    php-bcmath \
                    php-mongodb \
                    php-redis \
                    php-xdebug \
                    php-tokenizer \
                    php-ctype
#
# Configure nginx
COPY ./config/nginx.conf /etc/nginx/nginx.conf
# Remove default server definition

RUN rm /etc/nginx/conf.d/default.conf
# Configure PHP-FPM

COPY ./config/fpm-pool.conf /etc/php7/php-fpm.d/www.conf

COPY ./config/php.ini /etc/php7/conf.d/custom.ini

# Configure supervisord
COPY ./config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup document root
RUN mkdir -p $WWW_HOME
RUN mkdir -p $WWW_HOME/$HOME_PRJ/bootstrap
RUN mkdir -p $WWW_HOME/$HOME_PRJ/storage
RUN mkdir -p $WWW_HOME/$HOME_PRJ/storage/tmp_files

# Make sure files/folders needed by the processes are accessable when they run under the nginx user
#
RUN mkdir -p /var/tmp/nginx
RUN mkdir -p /var/log/nginx
RUN mkdir -p /var/cache/nginx
#
RUN chown -R nginx.nginx /run && \
  chown -R nginx.nginx /var/lib/nginx && \
  chown -R nginx.nginx /var/tmp/nginx && \
  chown -R nginx.nginx /var/log/nginx && \
  chown -R nginx.nginx /var/cache/nginx && \
  chown -R nginx.nginx $WWW_HOME
#
RUN find $WWW_HOME -type f -exec chmod 640 {} \;
RUN find $WWW_HOME -type d -exec chmod 750 {} \;

RUN chmod 760 $WWW_HOME/$HOME_PRJ/bootstrap
RUN find $WWW_HOME/$HOME_PRJ/bootstrap -type f -exec chmod 640 {} \;
RUN find $WWW_HOME/$HOME_PRJ/bootstrap -type d -exec chmod 760 {} \;

RUN chmod 760 $WWW_HOME/$HOME_PRJ/storage
RUN find $WWW_HOME/$HOME_PRJ/storage -type f -exec chmod 640 {} \;
RUN find $WWW_HOME/$HOME_PRJ/storage -type d -exec chmod 760 {} \;
RUN find $WWW_HOME/$HOME_PRJ/storage/tmp_files -type d -exec chmod 760 {} \;


# Switch to use a non-root user from here on
#ARG UID=1000
#ENV USER="mnenzinho"
#RUN addgroup -g $UID -S $USER  && adduser -D -H -u $UID -s /sbin/nologin -G $USER -g $USER $USER 
#USER $USER
USER nginx

# Add application
WORKDIR $WWW_HOME

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
# HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping

