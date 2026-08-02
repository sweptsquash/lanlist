FROM ubuntu:24.04 AS caddy-builder

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

COPY --from=golang:latest /usr/local/go /usr/local/go

ENV PATH=/root/go/bin:/usr/local/go/bin:$PATH
ENV CGO_ENABLED=1

RUN apt-get update \
    && apt-get install -y \
        debian-keyring \
        debian-archive-keyring \
        curl \
        build-essential \
        ca-certificates \
        cmake \
        git \
        libargon2-dev \
        libbrotli-dev \
        pkg-config \
    && curl -1sLf 'https://dl.cloudsmith.io/public/caddy/xcaddy/gpg.key' | gpg --dearmor -o /usr/share/keyrings/caddy-xcaddy-archive-keyring.gpg \
    && curl -1sLf 'https://dl.cloudsmith.io/public/caddy/xcaddy/debian.deb.txt' | tee /etc/apt/sources.list.d/caddy-xcaddy.list \
    && apt-get update \
    && apt-get install -y \
        xcaddy \
    && rm -rf /var/lib/apt/lists/*

RUN xcaddy build --output /usr/bin/caddy --with github.com/dunglas/caddy-cbrotli

FROM ubuntu:24.04

LABEL maintainer="Stewart Marsh"

ARG WWWGROUP
ARG NODE_VERSION=24
ARG MYSQL_CLIENT="mysql-client"
ARG POSTGRES_VERSION=17
ARG PHP_VERSION=8.5

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC
ENV COMPOSER_CACHE_DIR=/composer/cache
ENV COMPOSER_HOME=/composer
ENV FRESHCLAM_UPDATE=2

ENV SUPERVISOR_PHP_USER="sail"

COPY --from=caddy-builder /usr/bin/caddy /usr/bin/caddy

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN echo "Acquire::http::Pipeline-Depth 0;" > /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::http::No-Cache true;" >> /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::BrokenProxy    true;" >> /etc/apt/apt.conf.d/99custom

ENV PATH=/root/go/bin:/usr/local/go/bin:$PATH

RUN apt-get update && apt-get upgrade -y \
    && mkdir -p /etc/apt/keyrings \
    && apt-get install -y \
        lsb-release \
        brotli \
        clamav \
        clamav-daemon \
        clamav-freshclam \
        libgd3 \
        gnupg \
        gosu \
        curl \
        ca-certificates \
        zip \
        unzip \
        git \
        supervisor \
        sqlite3 \
        libcap2-bin \
        libpng-dev \
        python3 \
        dnsutils \
        librsvg2-bin \
        fswatch \
        ffmpeg \
        nano \
        vim \
        ghostscript \
        libmagickwand-dev \
        libmagickcore-dev \
    && curl -sSLo /tmp/debsuryorg-archive-keyring.deb https://packages.sury.org/debsuryorg-archive-keyring.deb \
    && dpkg -i /tmp/debsuryorg-archive-keyring.deb \
    && sh -c 'echo "deb [signed-by=/usr/share/keyrings/debsuryorg-archive-keyring.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' \
    && apt-get update \
    && apt-get install -y  \
        php${PHP_VERSION}-cli \
        php${PHP_VERSION}-fpm \
        php${PHP_VERSION}-dev \
        php${PHP_VERSION}-pgsql \
        php${PHP_VERSION}-sqlite3 \
        php${PHP_VERSION}-gd \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-mongodb \
        php${PHP_VERSION}-imap \
        php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-zip \
        php${PHP_VERSION}-bcmath \
        php${PHP_VERSION}-soap \
        php${PHP_VERSION}-intl \
        php${PHP_VERSION}-readline \
        php${PHP_VERSION}-ldap \
        php${PHP_VERSION}-msgpack \
        php${PHP_VERSION}-igbinary \
        php${PHP_VERSION}-redis \
        php${PHP_VERSION}-mcrypt \
        php${PHP_VERSION}-swoole \
        php${PHP_VERSION}-memcached \
        php${PHP_VERSION}-pcov \
        php${PHP_VERSION}-imagick \
        php${PHP_VERSION}-xdebug \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && curl -sS https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor | tee /etc/apt/keyrings/pgdg.gpg >/dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/pgdg.gpg] http://apt.postgresql.org/pub/repos/apt noble-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
    && apt-get update \
    && apt-get install -y $MYSQL_CLIENT \
    && apt-get install -y postgresql-client-$POSTGRES_VERSION \
    && freshclam \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php${PHP_VERSION}

RUN userdel -r ubuntu
RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail
RUN git config --global --add safe.directory /var/www/html

RUN mkdir -p /tmp/phpstan/cache
RUN chmod -R 777 /tmp/phpstan

# PHP CLI configuration
COPY php.ini /etc/php/${PHP_VERSION}/cli/conf.d/99-sail.ini
COPY opcache.ini /etc/php/${PHP_VERSION}/cli/conf.d/99_opcache.ini
COPY xdebug.ini /etc/php/${PHP_VERSION}/cli/conf.d/99-xdebug.ini

# PHP FPM configuration
COPY fpm-pool.conf /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
COPY php.ini /etc/php/${PHP_VERSION}/fpm/conf.d/99-sail.ini
COPY opcache.ini /etc/php/${PHP_VERSION}/fpm/conf.d/99_opcache.ini
COPY xdebug.ini /etc/php/${PHP_VERSION}/fpm/conf.d/99-xdebug.ini

COPY clamd.conf /etc/clamav/clamd.conf
COPY Caddyfile /etc/caddy/Caddyfile
COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /usr/local/bin/start-container

RUN mkdir -p /var/www/.config /tmp/psysh /.local /.config /var/log/php ${COMPOSER_CACHE_DIR} ${XDG_CONFIG_HOME} ${XDG_DATA_HOME}
RUN chown -R sail:sail /var/www/.config /.local /run /.config /var/log ${COMPOSER_CACHE_DIR} ${XDG_CONFIG_HOME} ${XDG_DATA_HOME}
RUN chmod -R ugo+rw ${COMPOSER_CACHE_DIR} ${XDG_CONFIG_HOME} ${XDG_DATA_HOME}

# Create logs directory
RUN mkdir -p  /var/log/supervisor && \
    chmod -R 0777 /var/log/supervisor && \
    chown clamav:clamav /var/log/clamav && \
    chmod -R 0777 /var/log/clamav

#### ClamAV Start ####
# Create folders and set proper permissions
RUN mkdir /var/run/clamav && \
    chown clamav:clamav /var/run/clamav && \
    chmod 750 /var/run/clamav && \
    mkdir -p /var/lib/clamav/ && \
    chown -R clamav:clamav /var/lib/clamav/ && \
    touch /var/log/supervisor/clamav_init.log && \
    touch /var/log/supervisor/clamd.log && \
    touch /var/log/supervisor/freshclam.log

# Make clam and fresh to be run on forground so that supervisor take care of the rest
RUN sed -i 's/^Foreground false/Foreground true/g' /etc/clamav/freshclam.conf
##### ClamAV End ####

EXPOSE 80/tcp
EXPOSE 443/tcp
EXPOSE 443/udp
EXPOSE 2019/tcp

ENTRYPOINT ["start-container"]
