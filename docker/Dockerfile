FROM php:7.4-alpine

RUN set -eux ; \
  apk add --no-cache --virtual .composer-rundeps \
    bash \
    coreutils \
    git \
    make \
    openssh-client \
    patch \
    subversion \
    tini \
    unzip \
    zip \
    $([ "$(apk --print-arch)" != "x86" ] && echo mercurial) \
    $([ "$(apk --print-arch)" != "armhf" ] && echo p7zip)

RUN printf "# composer php cli ini settings\n\
date.timezone=UTC\n\
memory_limit=-1\n\
" > $PHP_INI_DIR/php-cli.ini

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp

RUN set -eux ; \
  # install https://github.com/mlocati/docker-php-extension-installer
  curl \
    --silent \
    --fail \
    --location \
    --retry 3 \
    --output /usr/local/bin/install-php-extensions \
    --url https://github.com/mlocati/docker-php-extension-installer/releases/download/1.2.58/install-php-extensions \
  ; \
  echo 182011b3dca5544a70fdeb587af44ed1760aa9a2ed37d787d0f280a99f92b008e638c37762360cd85583830a097665547849cb2293c4a0ee32c2a36ef7a349e2 /usr/local/bin/install-php-extensions | sha512sum --strict --check ; \
  chmod +x /usr/local/bin/install-php-extensions ; \
  # install necessary/useful extensions not included in base image
  install-php-extensions \
    bz2 \
    zip \
    pdo \
    pdo_mysql \
  ; \

