FROM mediawiki:1.43.1

WORKDIR /var/www/html

# imagemagick libavif-tools libavif-dev

RUN apt-get update \
  && apt-get install -y --no-install-recommends libzip-dev libicu-dev libavif-dev imagemagick \
  && docker-php-ext-install zip intl \
  && curl -sS https://getcomposer.org/installer -o composer-setup.php \
  && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
  && rm composer-setup.php \
  && apt-get clean && rm -rf /var/lib/apt/lists/* \
  # Clone freedom repo \
  && git clone --depth=1 https://github.com/bozonx/media-wiki-libereco-setup.git /var/local/w/repo \
  && cp -R /var/local/w/repo/tmpl-img /var/www/html/resources/assets/ \
  && cp /var/local/w/repo/robots.txt /var/www/html/ \
  # PHP setup \
  && echo "[opcache]\n \
  opcache.enable=1\n \
  opcache.enable_cli=1\n \
  opcache.max_accelerated_files=10000\n \
  \n \
  [PHP]\n \
  memory_limit=256M\n \
  max_input_time=60\n \
  realpath_cache_ttl=7200\n \
  upload_max_filesize = 7M\n \
  post_max_size = 7M\n" > /usr/local/etc/php/conf.d/custom-php.ini \
  # Composer \
  && echo '{ \
  "require": {"wikimedia/equivset": "*"}, \
  "extra": { \
  "merge-plugin": { \
  "include": [ \
  "extensions/Translate/composer.json" \
  ], \
  "include": [ \
  "extensions/OpenIDConnect/composer.json" \
  ], \
  "include": [ \
  "extensions/OATHAuth/composer.json" \
  ] \
  } \
  } \
  }' > composer.local.json \
  # Image magic ?????? \
  && sed -i 's/<\/policy>.*<\/policymap>/\
  <policy domain="coder" rights="read|write" pattern="AVIF" \/>\n\
  <\/policymap>/' /etc/ImageMagick-6/policy.xml \
  # Standardized repos \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/Translate extensions/Translate \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/UniversalLanguageSelector extensions/UniversalLanguageSelector \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/Babel extensions/Babel \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/cldr extensions/cldr \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/CleanChanges extensions/CleanChanges \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/ContentTranslation extensions/ContentTranslation \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/YouTube extensions/YouTube \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/ApprovedRevs.git extensions/ApprovedRevs \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/AdminLinks extensions/AdminLinks \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/EmailAuth extensions/EmailAuth \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/Patroller extensions/Patroller \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/StopForumSpam extensions/StopForumSpam \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/SmiteSpam extensions/SmiteSpam \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/UserMerge extensions/UserMerge \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/CheckUser extensions/CheckUser \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/AntiSpoof extensions/AntiSpoof \
  # Not standardized repos \
  && git clone --depth=1 https://gerrit.wikimedia.org/r/mediawiki/extensions/PageProperties extensions/PageProperties \
  && git clone --depth=1 https://github.com/SkizNet/mediawiki-GTag extensions/GTag \
  && git clone --depth=1 https://gerrit.wikimedia.org/r/mediawiki/extensions/Memcached extensions/Memcached \
  && git clone --depth=1 https://github.com/StarCitizenTools/mediawiki-skins-Citizen.git skins/Citizen \
  # Run composer update \
  && composer update --no-dev --optimize-autoloader
