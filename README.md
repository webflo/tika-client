Apache Tika PHP Client
=====================

Usage:

    $path   = __DIR__ . '/../bin/tika-app-1.4.jar'; 
    $tika = new TikaClient($path);

    // Get text
    $text = $tika->getText('file.doc');

    // Get html text
    $html = $tika->getHtml('file.doc');

    // Get xhtml text
    $xhtml = $tika->getXhtml('file.doc');

    // Get language
    $lang = $tika->getLanguage('file.doc');

    // Get content type
    $type = $tika->getContentType('file.doc');

    // Extract all attachments on doc file
    $target = '/tmp/'; // target directory
    $tika->extract('file.doc', $target);


If you prefer, use the TikaWrapper to encapsulate all operations to same file. Eg:

    $wrapper = new TikaWrapper('file.doc', $client);

    // Get text
    $text = $wrapper->getText();

    // Get html text
    $html = $wrapper->getHtml();

    // Get xhtml text
    $xhtml = $wrapper->getXhtml();

    // Get language
    $lang = $wrapper->getLanguage();

    // Get content type
    $type = $wrapper->getContentType('file.doc');