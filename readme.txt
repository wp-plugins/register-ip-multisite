=== Register IP ===
Contributors: johnnywhite2007, ipstenu
Tags: IP, log, register
Requires at least: 3.0
Tested up to: 3.0.1
Stable tag: 0.1

When a new user registers, their IP address is logged and shows in the users menu as well as in the user's profile.

== Description ==

Spam is one thing, but trolls and sock puppets are another.  Sometimes people just decide they're going to be jerks and create multiple accounts with which to harass your honest users.  This plugin helps you fight back by logging the IP address used at the time of creation.

When a user registers, their IP is logged in the wp_usermeta under the signup_ip key.  Log into your WP install as an Admin and you can look at their profile or the users table to see what it is. For security purposes their IP is not displayed to them when they see their profile.

== Installation ==

= Single Site =
1. Upload the `register-ip-ms` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= MultiSite = 
1. Upload the file `register-ip.php` to the `/wp-content/mu-plugins` directory

OR

1. Upload the `register-ip-ms` folder to the `/wp-content/plugins/` directory
2. Network Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Why does some users say "None Recorded"? =
This is because the user was registered before the plugin was installed and/or activated.

= Does this work on MultiSite? =
Yep! I'd stick it in the `mu-plugins` folder, personally, so it's active no matter where you try and view the users list, but you don't have to.

= Does this work with BuddyPress? =
It works with BuddyPress on Multisite, so I presume single-site as well. If not, let me know!

= This makes my screen too wide! =
Sorry about that, but that's what happens when you add in more columns.

= What's the difference between MultiSite and SingleSite installs? =
On multisite only the super admins who have access to Super Admin -> Users can see the IPs on the user list.

This is due to issues with how WordPress handles the filters and some lingering inconsistancy between MultiSite and regular WordPress. I had to duplicate code and put in an 'if MultiSite...' feature, which works, but if you're a regular Admin, you can ONLY see the user IP on the profile page.

Now, when they fix core, I expect this plugin to BREAK, but it'll be an easy enough fix, and then I'll be able to have it work for BOTH Users -> Users and Super Admin -> Users.

See http://core.trac.wordpress.org/ticket/14562 for tech details.

== Screenshots ==
1. Single Site (regular users menu)
2. Multisite (Super Admin -> Users menu)

== Changelog ==

= 0.1 =
* Initial fork
* Change to work in MultiSite AND Single Site
* BuddyPress Tested

== Upgrade Notice ==
N/A
