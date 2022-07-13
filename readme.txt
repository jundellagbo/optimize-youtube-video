=== Optimize Youtube Video ===
Contributors: jundellagbo
Tags: youtube, videos, webp, thumbnails, speed, optimize
Donate link: https://www.paypal.me/jundellagbo
Requires at least: 5.1
Tested up to: 6.0
Requires PHP: 5.6
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Optimize youtube videos considering webp thumbnails and adapting to any lazyloading plugin.

== Description ==

Optimize youtube videos considering webp thumbnails and adapting to any lazyloading plugin.
Flexible to any lazyload plugin, you can follow their markup and have a full control for the thumbnails.

= Improving your page speed score =
* Lazy load third-party resources with facades
* Next-gen format for thumbnails | webp format
* Responsive Thumbnails with srcset snippet or alternate mobile thumbnail

= Features =
* Automatically convert your iFrame with youtube source link to thumbnails
* Adapting to any lazyload Plugins, No lazyload js included to reduce http request and to avoid duplicate lazyload library
* Can access youtube thumbnail as variable | available to all thumbnail resolutions
* Full control output for youtube videos and their thumbnails
* Auto-resize thumbnail in mobile from iframe attribute or global settings
* Using inline and minimal css and javascript
* Minified outputs

= Installation =
* Go to Plugins > Add New > Optimize Youtube Video
* Go to Settings > Optimize Youtube Video
 
= Tips =
* Do not lazyload above the fold thumbnails
* For WP Rocket or LazyLoad plugin - disable "Replace Youtube videos by thumbnail" in Lazyload Tab
* Disable lazyload thumbnails in above-the-fold content to improve LCP

= Maintainer =
* [Jundell Agbo](https://profiles.wordpress.org/jundellagbo/)

== Changelog ==

= 1.2.1
* fix vendor

= 1.2.0
* removing variable translations

= 1.1.0
* add option to enable lazyload for loggedin user, escape variables

= 1.0.0
* First major release