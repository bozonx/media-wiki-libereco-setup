if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); \
\$wgExtensionCredits['other'][] = [ \
    'path' => __FILE__, \
    'name' => 'ConvertToAVIF', \
    'author' => 'ChatGPT', \
    'url' => 'https://example.org/ConvertToAVIF', \
    'descriptionmsg' => 'converttoavif-desc', \
    'version' => '1.0.0', \
]; \
\$wgHooks['UploadComplete'][] = 'onUploadCompleteConvertToAVIF'; \
function onUploadCompleteConvertToAVIF( \$uploadBase ) { \
    \$file = \$uploadBase->getLocalFile(); \
    \$originalPath = \$file->getLocalRefPath(); \
    \$extension = strtolower( pathinfo( \$originalPath, PATHINFO_EXTENSION ) ); \
    if ( \$extension === 'avif' ) { \
        return true; \
    } \
    \$supported = [ 'jpg', 'jpeg', 'png', 'webp' ]; \
    if ( !in_array( \$extension, \$supported ) ) { \
        return true; \
    } \
    \$avifPath = preg_replace( '/\\.[^.]+$/', '.avif', \$originalPath ); \
    \$cmd = escapeshellcmd( \"convert \" . escapeshellarg( \$originalPath ) . \" \" . escapeshellarg( \$avifPath ) ); \
    exec( \$cmd, \$output, \$retval ); \
    if ( \$retval === 0 && file_exists( \$avifPath ) ) { \
        unlink( \$originalPath ); \
        rename( \$avifPath, \$originalPath ); \
        \$file->setProps( [ \
            'mime' => 'image/avif', \
            'media_type' => MEDIATYPE_BITMAP, \
        ] ); \
    } \
    return true; \
