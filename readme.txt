=== Magic robots.txt ===
Contributors: ABCdatos
Tags: robots,robots.txt,seo,google,bots
Requires at least: 4.2
Tested up to: 6.6
Stable tag: 1.0.7
Requires PHP: 5.4
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin automatically creates a robots.txt analyzing your site to improve your Google ranking and site performance.

== Description ==

In a nutshell: You don't want robots wasting your resources and slowing down your site if they don't give you some kind of direct or indirect benefit. An optimal configuration will maximize your SEO results and reduce your operating costs.

You'll need less than a minute to set your site characteristics and get a customized robots.txt configuration installed, matching your needs and easily updated without headaches. Let us to apply our experience in maintaining and optimizing sites. A clear knowledge of what we want to do and why, moved us to change the decission method from human created robots.txt to an automated system, things are simpler as they seems. Here comes to help this plugin, doing all the magic for you.

Some of your site specs will be automatically detected to reduce the manual config needs to the minimum. A few simple questions about your site will be enough to vast majority of sites.

== Update procedure ==

Any change required to the robots.txt is applied in real time when operating in virtual file mode. If you are working in real file mode, after updating the plugin version you should click the Save Changes button in the configuration screen to regenerate the robots.txt file.

== Installation ==

1. Upload files to the /wp-content/plugins/magic-robots-txt directory or install plugin directlly through the Plugins menu of your WordPress.
2. Activate the plugin through the Plugins menu of your WordPress.
3. Go to Magic robots.txt settings from the WordPress admin menu to configure the plugin.
4. Adjust settings to fit your site or maintain the selected defaults and press at Save changes.

== Frequently Asked Questions ==

= How can I verify the robots.txt content? =

Go to https://www.yoursite.com/robots.txt to see the current robots.txt. Remember your browser may cache it, operate as required to refresh.

= Can I modify the robots.txt content? =

Select the Use real file option and modify the created file outside the plugin generated block.

= There is a bunch of garbage in the robots.txt, can be cleaner? =

May be your WordPress is in debug mode, disable it to reduce the included comments.

= Can I obtain more information about the generated content in the robots.txt? =

Enable debug mode in your WordPress and read it again. If using real file mode, is required to save settings to regenerate the file.

= Does the plugin work in subdirectories? =

Yes. As virtual file is unavailable because need to be at domain root, the plugin will run in real file mode.

= Does the plugin work in multisite? =

No, it hasn't been planned.

= Is compatible with Yoast SEO robots.txt? =

In virtual file mode we process its data.

= Is compatible with Yoast SEO sitemaps? =

Yes, we detect and process them.

= Is compatible with All In One SEO plugin? =

We don't tried it, testing is needed.

= Is compatible with Windows servers? =

We don't tried it, the real robots.txt file mode may fail. If WordPress is installed on a subdirectory of the domain documents root, be sure it will fail on Windows right now. Contact support if you are interested and ready to make some testing.

= How to add a new robot? =

If the robot obeys robots.txt, contact support and give us this information:

*User-agent.
*Robot information page URL.
*Type: Search engine / link analyzer / advertising management / offline navigator or site downloader.

Robots outside these types are out of the scope of the plugin.

= Can I use the plugin to block attacks? =

This is not a security plugin, sorry, you should use a firewall or something like fail2ban.

== Screenshots ==

1. Settings view.
2. Sample of resulting robots.txt.
3. Sample of resulting robots.txt in debug mode.
4. Additional information in settings view while in debug mode.

== Changelog ==

= 1.0.7 - Aug 5, 2024 =
- Fixed bug when no initial configiration is done.

= 1.0.6 - Aug 1, 2024 =
- WordPress 6.6 basic compatibility checked.
- Fixed plugin menu icon issue.
- Implemented physical file loading when running preview at [https://playground.wordpress.net/](https://playground.wordpress.net/)

= 1.0.5 - March 30, 2024 =
- Changed the required capability to access the settings page.
- Improved settings update mechanism for conditional real robots.txt file generation.
- Minor code improvements.
- WordPress 6.5 basic compatibility checked.

= 1.0.4 - January 7, 2024 =
- Added Owler (Open Web Search) to search engines bot list.
- Added netEstate NE Crawler (Sengine) to search engines bot list.
- WordPress 6.4 basic compatibility checked.

= 1.0.3 - September 18, 2023 =
- WordPress 6.3 basic compatibility checked.
- Better load average availability testing.
- Changes in real robots.txt file management procedure.
- Improved source code styling and documentation.
- Added Amazonbot to abusive bots list.

= 1.0.2 - January 6, 2023 =
- Added "Google Listings & Ads" as not advertising indicator plugin.
- Added omgili and barkrowler to link analyzers bots list.
- Added MojeekBot, PetalBot, SeekportBot and Neevabot to search engines bot list.
- Added CriteoBot/0.1 and grapeshot to ad networks bot list.
- Added VelenPublicWebCrawler, AwarioBot, AwarioRssBot and AwarioSmartBot to abusive bot list.
- Untranslatable strings corrections.
- Corrected paths for allow and disallow in subdirectory installatons.

= 1.0.1 - November 20, 2022 =
- Syntax corrections.
- Untranslatable strings corrections.

= 1.0.0 . November 13, 2022 =
- First public version.

== Upgrade Notice ==

= 1.0.2 =
- Correction for subdirectory WordPress installation.
- More robots supported.

