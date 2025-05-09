<?php

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $_SERVER['HTTPS'] = 'on';
}

## UPO means: this is also a user preference option

$wgMetaNamespace = "Project";
$wgNamespaceAliases['Special'] = NS_SPECIAL;
$wgExtraNamespaces[NS_SPECIAL] = 'Special';
$wgArticlePath = "/w/$1";
$wgExternalLinkTarget = '_blank';
$wgScriptPath = "";
# The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;
# Time zone
$wgLocaltimezone = "UTC";
# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";
$wgDeleteRevisionsLimit = 5000;

#### Database settings
# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";
$wgDBtype = "mysql";
$wgDBserver = "database";

#### UI
$wgLogos = [
	#'1x' => "$wgResourceBasePath/repo/assets/logo.svg",
	'icon' => "$wgResourceBasePath/resources/assets/tmpl-img/logo.svg",
];

#### Upload and media
# Upload from URL
$wgAllowCopyUploads = true;
# Upload from ULR on special page
$wgCopyUploadsFromSpecialUpload = true;
# true disables all SVG conversion
$wgSVGNativeRendering = true;
## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";
# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = true;
$wgFileExtensions = [ 'png', 'gif', 'jpg', 'jpeg', 'svg', 'webp', 'avif', 'jxl', 'pdf', 'mp3', 'aac', 'm4a', 'opus'];
$wgUploadSizeWarning = 7340032;
$wgMaxUploadSize = 7340032;

##### Email
$wgEmailConfirmToEdit = true;
# Enable page Special:Emailuser
$wgEnableUserEmail = true;
# allow email notifications to a user when someone else edits the user's talk page
$wgEnotifUserTalk = true; # UPO
# allow email notification for watched pages
$wgEnotifWatchlist = true; # UPO

##### Cache
$wgUseCdn = true;
$wgResourceLoaderMaxage['unversioned'] = 3600; // Кэширование на 1 час
$wgUseGzip = true;
$wgEnableSidebarCache = true;
$wgRevisionCacheExpiry = 86400; // Кэширование ревизий на 24 часа
$wgMainCacheType = CACHE_MEMCACHED;
$wgMemCachedServers = ['memcached:11211'];
# Set this to false if MediaWiki is behind a CDN that re-orders query parameters on incoming requests
$wgCdnMatchParameterOrder = false;
$wgEnableSidebarCache = true;

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publicly accessible from the web.
#$wgCacheDirectory = "$IP/cache";

##### Security
$wgForceHTTPS = true;
$wgCaptchaTriggers['edit'] = true;
$wgCaptchaTriggers['create'] = true;
$wgCaptchaTriggers['sendemail'] = true;
$wgPasswordPolicy['policies']['default'] = [
    'MinimalPasswordLength' => 10,
    'MinimumPasswordLengthToLogin' => 10,
    'MaximalPasswordLength' => 1024,
    #'PasswordCannotMatchUsername' => ['value' => true],
    'PasswordCannotBeSubstringInUsername' => true,
    'PasswordNotInCommonList' => true,
];
#$wgPasswordPolicy['policies']['default']['PasswordCannotMatchUsername']['value'] = true;
$wgPasswordAttemptThrottle = [
	// Short term limit
	[ 'count' => 5, 'seconds' => 300 ],
	// Long term limit. We need to balance the risk
	// of somebody using this as a DoS attack to lock someone
	// out of their account, and someone doing a brute force attack.
	[ 'count' => 150, 'seconds' => 60 * 60 * 48 ],
];
$wgAccountCreationThrottle = [ [
	'count' => 20,
	'seconds' => 86400,
] ];

##### Language

switch ($_SERVER['HTTP_HOST']) {
  case 'ru.mediawiki.example.com':
    $wgLanguageCode = 'ru';
    $wgServer = "https://ru." . MAIN_DOMAIN;
    break;
  case 'es.mediawiki.example.com':
    $wgLanguageCode = 'es';
    $wgServer = "https://es." . MAIN_DOMAIN;
    break;
  default:
    # default interface language. Site language code, should be one of the list in ./includes/languages/data/Names.php
    $wgLanguageCode = 'en';
    $wgServer = "https://" . MAIN_DOMAIN;
  break;
}

######## Enabling

# Skins
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Vector' );
wfLoadSkin( 'MinervaNeue' );
wfLoadSkin( 'Timeless' );
wfLoadSkin( 'Citizen' );

# Standard extensions
wfLoadExtension( 'AbuseFilter' );
wfLoadExtension( 'CategoryTree' );
wfLoadExtension( 'Cite' );
wfLoadExtension( 'CiteThisPage' );
wfLoadExtension( 'CodeEditor' );
wfLoadExtensions([ 'ConfirmEdit', 'ConfirmEdit/Turnstile' ]);
wfLoadExtension( 'DiscussionTools' );
wfLoadExtension( 'Echo' );
wfLoadExtension( 'ImageMap' );
wfLoadExtension( 'InputBox' );
wfLoadExtension( 'Interwiki' );
wfLoadExtension( 'Linter' );
wfLoadExtension( 'LoginNotify' );
wfLoadExtension( 'MultimediaViewer' );
wfLoadExtension( 'Nuke' );
wfLoadExtension( 'OATHAuth' );
wfLoadExtension( 'PageImages' );
wfLoadExtension( 'PdfHandler' );
wfLoadExtension( 'ReplaceText' );
wfLoadExtension( 'SecureLinkFixer' );
wfLoadExtension( 'SpamBlacklist' );
wfLoadExtension( 'Scribunto' );
wfLoadExtension( 'TemplateData' );
wfLoadExtension( 'TitleBlacklist' );
wfLoadExtension( 'VisualEditor' );
wfLoadExtension( 'WikiEditor' );
wfLoadExtension( 'Poem' );
wfLoadExtension( 'SyntaxHighlight_GeSHi' );
wfLoadExtension( 'Math' );
wfLoadExtension( 'ParserFunctions' );
wfLoadExtension( 'Thanks' );

# Extra extensions


######## Extensions and skins settings

$wgCitizenEnableDrawerSiteStats = false;
$wgCitizenEnableManifest = false;
$wgThanksLogging = false;

######## Permissions

# stop anonymous users from editing any page
$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['*']['createpage'] = false;
$wgGroupPermissions['*']['createtalk'] = false;

# Allow to users with confirmed email
$wgGroupPermissions['autoconfirmed']['sendemail'] = true;
$wgGroupPermissions['autoconfirmed']['spamblacklistlog'] = true;
$wgGroupPermissions['autoconfirmed']['createtalk'] = true;

# Remove some right of user
$wgGroupPermissions['user']['sendemail'] = false;
$wgGroupPermissions['user']['spamblacklistlog'] = false;
$wgGroupPermissions['user']['upload'] = false;
$wgGroupPermissions['user']['upload_by_url'] = false;
$wgGroupPermissions['user']['reupload-shared'] = false;
$wgGroupPermissions['user']['reupload'] = false;
$wgGroupPermissions['user']['move-rootuserpages'] = false;
$wgGroupPermissions['user']['move'] = false;
$wgGroupPermissions['user']['move-categorypages'] = false;
$wgGroupPermissions['user']['move-subpages'] = false;
$wgGroupPermissions['user']['movefile'] = false;
$wgGroupPermissions['user']['editcontentmodel'] = false;
$wgGroupPermissions['user']['changetags'] = false;

# Group autopatrolled for trusted editors
$wgGroupPermissions['autopatrolled']['autopatrol'] = true;
$wgGroupPermissions['autopatrolled']['edit'] = true;
$wgGroupPermissions['autopatrolled']['skip-move-moderation'] = true;
$wgGroupPermissions['autopatrolled']['skip-moderation'] = true;
$wgGroupPermissions['autopatrolled']['pageproperties-caneditpageproperties'] = true;
$wgGroupPermissions['autopatrolled']['upload'] = true;
$wgGroupPermissions['autopatrolled']['upload_by_url'] = true;
$wgGroupPermissions['autopatrolled']['reupload-shared'] = true;
$wgGroupPermissions['autopatrolled']['reupload'] = true;
$wgGroupPermissions['autopatrolled']['move-rootuserpages'] = true;
$wgGroupPermissions['autopatrolled']['move'] = true;
$wgGroupPermissions['autopatrolled']['move-categorypages'] = true;
$wgGroupPermissions['autopatrolled']['move-subpages'] = true;
$wgGroupPermissions['autopatrolled']['movefile'] = true;
$wgGroupPermissions['autopatrolled']['editcontentmodel'] = true;
$wgGroupPermissions['autopatrolled']['changetags'] = true;
$wgGroupPermissions['autopatrolled']['noratelimit'] = true;

# Trusted admins
$wgGroupPermissions['trusted']['blockemail'] = true;
$wgGroupPermissions['trusted']['block'] = true;
$wgGroupPermissions['trusted']['rollback'] = true;
$wgGroupPermissions['trusted']['undelete'] = true;
$wgGroupPermissions['trusted']['protect'] = true;
$wgGroupPermissions['trusted']['pagelang'] = true;
$wgGroupPermissions['trusted']['mergehistory'] = true;
$wgGroupPermissions['trusted']['patrol'] = true;
$wgGroupPermissions['trusted']['browsearchive'] = true;
$wgGroupPermissions['trusted']['deletedhistory'] = true;
$wgGroupPermissions['trusted']['unwatchedpages'] = true;
$wgGroupPermissions['trusted']['deletedtext'] = true;
$wgGroupPermissions['trusted']['deletechangetags'] = true;
$wgGroupPermissions['trusted']['delete'] = true;
$wgGroupPermissions['trusted']['managechangetags'] = true;

######## Extensions permissions

$wgGroupPermissions['trusted']['pageproperties-caneditpageproperties'] = true;
$wgGroupPermissions['trusted']['adminlinks'] = true;
$wgGroupPermissions['trusted']['titleblacklistlog'] = true;
$wgGroupPermissions['trusted']['abusefilter-protected-vars-log'] = true;
$wgGroupPermissions['trusted']['abusefilter-modify-restricted'] = true;
$wgGroupPermissions['trusted']['abusefilter-log-private'] = true;
$wgGroupPermissions['trusted']['abusefilter-access-protected-vars'] = true;
$wgGroupPermissions['trusted']['abusefilter-log-detail'] = true;
$wgGroupPermissions['trusted']['abusefilter-view-private'] = true;
$wgGroupPermissions['trusted']['abusefilter-modify-blocked-external-domains'] = true;
$wgGroupPermissions['trusted']['abusefilter-modify'] = true;
$wgGroupPermissions['trusted']['translate-manage'] = true;
$wgGroupPermissions['trusted']['pagetranslation'] = true;
$wgGroupPermissions['trusted']['approverevisions'] = true;
$wgGroupPermissions['trusted']['viewapprover'] = true;
$wgGroupPermissions['trusted']['smitespam'] = true;
$wgGroupPermissions['trusted']['interwiki'] = true;

$wgGroupPermissions['sysop']['interwiki'] = true;

