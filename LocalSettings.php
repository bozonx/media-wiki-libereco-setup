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

#### Database settings
# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";
$wgDBtype = "mysql";
$wgDBserver = "database";
$wgDBuser = "mwuser";

#### UI
$wgLogos = [
	#'1x' => "$wgResourceBasePath/repo/assets/logo.svg",
	'icon' => "$wgResourceBasePath/repo/assets/logo.svg",
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

##### Email
# Enable page Special:Emailuser
$wgEnableUserEmail = true;
# allow email notifications to a user when someone else edits the user's talk page
$wgEnotifUserTalk = true; # UPO
# allow email notification for watched pages
$wgEnotifWatchlist = true; # UPO

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

######## Permissions

# stop anonymous users from editing any page
$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['*']['createpage'] = false;

$wgGroupPermissions['user']['upload_by_url'] = true;
$wgGroupPermissions['autoconfirmed']['upload_by_url'] = true;

######## Extensions permissions

$wgGroupPermissions['sysop']['interwiki'] = true;

