=== Optimize Youtube Video ===
Contributors: jundellagbo
Tags: youtube, videos, speed, optimize
Donate link: https://www.paypal.me/jundellagbo
Requires at least: 5.1
Tested up to: 6.0
Requires PHP: 5.6
Stable tag: 1.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple plugin to optimize youtube videos and improve the site page speed score.

== Description ==

- Simple plugin to optimize youtube videos and improve the site page speed score.
- css and js are minimal and inlined for better performance.

= Shortcode =
advanced:
[opt-youtube-video id="dQw4w9WgXcQ" imgformat="jpg" width="480" height="360" title="Youtube title here" showtitle="1" lazyload="1" lazyattr="data-srcset" ytattrs="?autoplay=1&controls=0" ytthumbail="hqdefault" thumbnailclass="lazyload"]

or

simple:
[opt-youtube-video id="dQw4w9WgXcQ"]

youtube thumbnail lists: default, mqdefault, hqdefault, sddefault, maxresdefault

= Installation =
* Go to Plugins > Add New > Optimize Youtube Video
* Go to Settings > Optimize Youtube Video

= Maintainer =
* [Jundell Agbo](https://profiles.wordpress.org/jundellagbo/)

== Changelog ==

= 2.0.0
* simplify the plugin using shortcode

= 1.2.2
* fix nowebp typo
* set hqdefault for desktop
* set mqdefault for mobile

= 1.2.1
* fix vendor

= 1.2.0
* removing variable translations

= 1.1.0
* add option to enable lazyload for loggedin user, escape variables

= 1.0.0
* First major release