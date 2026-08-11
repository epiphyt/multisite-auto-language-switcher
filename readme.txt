=== Multisite Auto Language Switcher ===
Contributors: epiphyt, kittmedia
Tags: multisite, switcher language, preferred, automatic
Requires at least: 6.1
Stable tag: 1.1.3
Tested up to: 7.1
Requires PHP: 7.4
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically switch to a user's preferred language if Multisite Language Switcher is enabled and active for the current page.

== Description ==

Multisite Auto Language Switcher is a handy extensions for [Multisite Language Switcher](https://wordpress.org/plugins/multisite-language-switcher/), which adds an automatic redirect to the preferred language of a user. To do so, it uses the preferred language the user has defined in its browser, which it automatically transmits on every request, to determine a matching language within your website. If a match could be found, it automatically redirects the user to this variant of the content.

**Note: This plugin requires the plugin [Multisite Language Switcher](https://wordpress.org/plugins/multisite-language-switcher/).**

= Contribution =

Feel free to contribute. The code is available at [GitHub](https://github.com/epiphyt/multisite-auto-language-switcher).

= Documentation =

You can find the documentation for Multisite Auto Language Switcher at [docs.epiph.yt](https://docs.epiph.yt/multisite-auto-language-switcher/).


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/multisite-auto-language-switcher` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.


== Frequently Asked Questions ==

= Does Multisite Auto Language Switcher use cookies? =

Multisite Auto Language Switcher uses a cookie to prevent redirect loops between languages. In GDPR terms, it’s a required cookie to provide the functionality of redirecting a user to its preferred language. It is only stored for the current session and doesn’t contain any private data.

= Where are the settings? =

Logged-in users can define in their profile whether they want to disable being auto-redirected between languages.

= Is Multisite Auto Language Switcher accessible? =

Yes. During development, I test each feature against the Web Content Accessibility Guidelines (WCAG). You can find the [Accessibility Conformance Report](https://docs.epiph.yt/multisite-auto-language-switcher/acr.html) in the documentation.

If you find an issue, please don't hesitate to contact me via the support forums or via my [contact page](https://epiph.yt/en/contact/).

= Who are you, folks? =

[Epiphyt](https://epiph.yt/en/) is your friendly neighborhood WordPress plugin shop from southern Germany.

= How can I report security bugs? =

You can report security bugs through the Patchstack Vulnerability Disclosure Program. The Patchstack team help validate, triage and handle any security vulnerabilities. [Report a security vulnerability.](https://patchstack.com/database/vdp/multisite-auto-language-switcher)


== Changelog ==

= 1.1.3 =
* Added: Note for screen readers that the documentation link opens in a new tab
* Fixed: Missing aria-current attribute for the current language in the language switcher
* Fixed: Language switcher links no longer contain a redundant title attribute
* Fixed: Escaping of the language switcher link output

= 1.1.2 =
* Added: Compatibility with WordPress 7.0

= 1.1.1 =
* Updated: Compatibility with the latest releases of Multisite Language Switcher

= 1.1.0 =
* Added: User option to disable redirect via profile settings
* Added: Redirect parameter is now being removed via JavaScript after redirecting

= 1.0.1 =
* Fixed: Unwanted redirects for certain pages
* Fixed: Redirecting again after explicitly clicking on a language in the language switcher

= 1.0.0 =
* Initial release
