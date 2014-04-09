Weather_Bootstrapped v1
=======================

Weather Bootstrapped

Joomla 2 & 3 module for display of Yahoo weather forcast rss feed

1. requires jquery
2. Caches the feed rss to avoid excessive requests
3. uses the default weather pics or you can supply your own
4. doesn't need the bootstrap framework - the module can load the parts it needs
5. carousel display or single weather with optional 5 day forecast
6. weather.css file to enable fine tuning of display or override bootstrap defaults

Notes:

2. cache time configurable, does not need Joomla cache to be enabled

3. gets main weather pictures from http://l.yimg.com/a/i/us/nws/weather/gr/ and
    small weather pictures from http://l.yimg.com/a/i/us/we/52/
    these can be changed on module administration screen so you can use your own or another source

4. 3 templates depending on your version of bootstrap, can be chosen from the administrator page.
    If you choose non-bootstrap template then it loads bootstrap.min.js, carousel.css and conflict.js
    conflict.js disables the mootools-more slideFX because it conflicts with the bootstrap carousel.

