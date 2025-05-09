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
  # Clone freedom repo
  && git clone https://github.com/bozonx/media-wiki-libereco-setup.git /var/local/w/repo \
  && rm -Rf /var/local/w/repo/.git \
  && cp -R /var/local/w/repo/tmpl-img /var/www/html/resources/assets/ \
  && cp /var/local/w/repo/robots.txt /var/www/html/ \
  # PHP setup
  && echo "upload_max_filesize = 7M\npost_max_size = 7M" > /usr/local/etc/php/conf.d/custom-php.ini \
  # Composer
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
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/Translate extensions/Translate && rm -Rf extensions/Translate/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/UniversalLanguageSelector extensions/UniversalLanguageSelector && rm -Rf extensions/UniversalLanguageSelector/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/Babel extensions/Babel && rm -Rf extensions/Babel/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/cldr extensions/cldr && rm -Rf extensions/cldr/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/CleanChanges extensions/CleanChanges && rm -Rf extensions/CleanChanges/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/ContentTranslation extensions/ContentTranslation && rm -Rf extensions/ContentTranslation/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/YouTube extensions/YouTube && rm -Rf extensions/YouTube/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/ApprovedRevs.git extensions/ApprovedRevs && rm -Rf extensions/ApprovedRevs/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/AdminLinks extensions/AdminLinks && rm -Rf extensions/AdminLinks/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/EmailAuth extensions/EmailAuth && rm -Rf extensions/EmailAuth/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/Patroller extensions/Patroller && rm -Rf extensions/Patroller/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/StopForumSpam extensions/StopForumSpam && rm -Rf extensions/StopForumSpam/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/SmiteSpam extensions/SmiteSpam && rm -Rf extensions/SmiteSpam/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/UserMerge extensions/UserMerge && rm -Rf extensions/UserMerge/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/CheckUser extensions/CheckUser && rm -Rf extensions/CheckUser/.git \
  && git clone --depth=1 --branch REL1_43 https://gerrit.wikimedia.org/r/mediawiki/extensions/AntiSpoof extensions/AntiSpoof && rm -Rf extensions/AntiSpoof/.git \
  # Not standardized repos \
  && git clone --depth=1 https://gerrit.wikimedia.org/r/mediawiki/extensions/PageProperties extensions/PageProperties && rm -Rf extensions/PageProperties/.git \
  && git clone --depth=1 https://github.com/SkizNet/mediawiki-GTag extensions/GTag && rm -Rf extensions/GTag/.git \
  && git clone --depth=1 https://github.com/StarCitizenTools/mediawiki-skins-Citizen.git skins/Citizen && rm -Rf extensions/Citizen/.git \
  # Run composer update \
  && composer update --no-dev --optimize-autoloader
