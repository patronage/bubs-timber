// requires cookies lib and query string
// https://github.com/ScottHamper/Cookies
// https://github.com/sindresorhus/query-string
// bower install --save query-string cookies-js

Cookies.defaults = {
    path: '/',
    domain: location.hostname.split('.').slice(-2).join('.'),
    expires: 365 * 24 * 60 * 60
};

var analyticsSourcing = function() {
    var parsed = queryString.parse(location.search);
    var prefix = 'bubs_';
    var comboField = 'MarketSource'; // Sample for ngpvan
    // var $form = $('form');

    // Option to save source and subsource to a specific variable
    if ( parsed.source ) {
        Cookies.set('source', parsed.source);
    }
    if ( parsed.subsource ) {
        Cookies.set('subsource', parsed.subsource);
    }

    // Option to save each of the google utm variables
    if ( typeof parsed.utm_campaign !== 'undefined' ||
        typeof parsed.utm_source !== 'undefined' ||
        typeof parsed.utm_medium !== 'undefined' ||
        typeof parsed.utm_term !== 'undefined' ||
        typeof parsed.utm_content !== 'undefined' ) {

        var prefs = { domain: location.hostname };

        Cookies.set(prefix + 'campaign', parsed.utm_campaign)
            .set(prefix + 'source', parsed.utm_source)
            .set(prefix + 'medium', parsed.utm_medium)
            .set(prefix + 'term', parsed.utm_term)
            .set(prefix + 'content', parsed.utm_content);
    }

    // combine into a single comboSource if you have a single analytics field
    if ( Cookies.get(prefix + 'campaign') || Cookies.get(prefix + 'source') ||
        Cookies.get(prefix + 'medium') || Cookies.get(prefix + 'term') || Cookies.get(prefix + 'content') ) {

        var comboSource = '';
        comboSource += 'campaign__' + ( Cookies.get(prefix + 'campaign') || '' );
        comboSource += '|source__' + ( Cookies.get(prefix + 'source') || '' );
        comboSource += '|medium__' + ( Cookies.get(prefix + 'medium') || '' );
        comboSource += '|term__' + ( Cookies.get(prefix + 'term') || '' );
        comboSource += '|content__' + ( Cookies.get(prefix + 'content') || '' );
    }

    // attach these fields to form inputs (might need to customize)
    // if ( $form ) {
    //     $form.append('<input type="hidden" name="' + comboField + '" value="' + comboSource + '" />');
    // }
};
