=== Plugin Name ===
Contributors: richardashby
Donate link: http://www.movember.com/
Tags: eu cookie law, cookie law, eu privacy directive, privacy directive, cookies, privacy, compliance
Requires at least: 3.3.1
Tested up to: 3.3.2
Stable tag: 1.0.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*UPDATED* A simple way to show how your website complies with the EU Cookie Law, which came into force on 26 May 2012.

== Description ==

This plugin adds a subtle banner to your website, either in the header or footer, to highlight your compliance status regarding the new EU Cookie Law.


It also has a Cookie Audit module so you can easily show what cookies your site uses and display them neatly in a table on your Privacy & Cookies Policy page.


Inline with official ICO guidelines and current industry best practice, this plugin uses 'implied consent' to aid you in showing your compliance status. This is a deliberate design choice that does not proactively block cookies: it doesn't make your visitors take action before they can use your website, and will not interfere with blog comments and [Google] Analytics. This approach is aimed at reducing website visitor dropout and maintaining your vital analytics data.


Note: the EU Cookie Law is officially called the 'EU ePrivacy Directive'.


For a demo, [check out the EU Cookie Law website](http://www.cookielawinfo.com/ "Demo the EU Cookie Law plugin"), including the table of cookies on the Privacy Policy page.


Features:

* Fully customisable dropdown header: position, colours, styles, fonts, use HTML and shortcodes
* Website visitors can dismiss the message, so that will not be shown again (uses a cookie)
* Optional "show again" tab - fully customisable including position shown on page
* NEW: "Cookie Audit" shortcode to construct a nicely-styled 'Privacy & Cookie Policy'
* NEW: shortcodes for fancy button styles
* Shortcode to allow visitor to delete cookie used to control header
* Able to switch header on/off without losing settings or having to disable plugin
* NEW: improved user interface
* NEW: improved help section

Coming soon:

* Language translations
* Cookie Law Info Plus - even more customisation and cookie control features

[Read more about the EU Cookie Law](http://www.cookielawinfo.com/ "More information about the EU Cookie Law")


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the `cookie-law-info` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to "Cookie Law Info / Cookie Law Settings" to configure the banner with your own text, colours and styles

To set up your Privacy & Cookie Policy Page:

1. Add descriptions of the cookies your site uses. Go to "Cookie Law Info / Add New".
2. Add a new page called e.g. Privacy and Cookie Policy
3. Add the [cookie_audit] shortcode to your Privacy & Cookie Policy Page

Cookie table shortcode usage:

	[cookie_audit]
	[cookie_audit style="winter"]
	[cookie_audit not_shown_message="No records found"]
	[cookie_audit style="winter" not_shown_message="Not found"]
	
	Parameters:
	
	style (optional) - choose one of several table styles included with the plugin. Styles included: simple, classic, modern, rounded, elegant, winter (styles are cAsE sensitive). Default style applied: classic.
	not_shown_message (optional) - if no cookie records are found, display this text. Default is blank (i.e. no message shown).
	

Delete header cookie usage:

	[delete_cookies]
	[delete_cookies linktext="delete cookies"]
	
	Parameters:
	
	linktext (optional) - the text shown in the link. Default is "Delete Cookies".


== Frequently Asked Questions ==

= What is the EU Cookie Law? =
More correctly, this is called the 'EU e-Privacy Directive'. Popular media refers to it as the 'EU Cookie Law'.
Under new EU privacy regulations, websites must make it clear to visitors what information about them is being stored. This specifically includes cookies. Even if cookies do not store information identifying an individual, you must still provide your visitor with information on what is being stored, by whom, what for, and so on.

Certain cookies are exempt from this- those deemed to be "strictly necessary" (e.g. WordPress stores session cookies for authentication, without these it wouldn't work) however cookies stored by analytics software like Google Analytics do not fall into this category.
See www.cookielawinfo.com for more information.

= What does this plugin do? =
This plugin will:

1. Add a banner to the top of all pages on your website, notifying the visitor that you have a clearly defined privacy and cookie policy.
2. Allow you to record which cookies your site uses, and:
3. Neatly display a list of these cookies (via a shortcode). You can put this list on your Privacy & Cookie Policy page, for example.

= Does this plugin block all cookies? =
No, and neither does any other WordPress plugin - be aware that despite what you may believe, it is not currently technically possible to completely block all cookies on your WordPress website without first updating all plugins that use cookies in some way. That is beyond the scope of any single plugin.
A more realistic approach for WordPress website owners is to use what is called "implied consent". This should not be a message buried on your website rather something more prominent that is clear to your visitors. This plugin can be used to highlight your compliance status and use of cookies in this way.


= I'm not a UK/EU citizen, how can this law apply to me? =
If you have a significant proportion of visitors from the EU then this law also applies to you.
See www.cookielawinfo.com for more information.

= My website is not hosted in the UK/EU, am I exempt? =
No. The law is about protecting the privacy of EU citizens, so if your website has a significant proportion of visitors from the EU then this law also applies to you.
See www.cookielawinfo.com for more information.

= Do visitors now have to accept/refuse cookies in order to use websites? =
In short, no, although there is a great deal of ambiguity and misinformation around this law. What the law really gets at is privacy, not just cookies. The UK government, for example, plan on using a version of what is called "implied consent" on their own websites, which is a technique similar to what this plugin does.

Online Marketing experts Econsultancy provide their perspective on this interpretation. This plugin follows the same approach.

Further reading:

1. [UK Cabinet Office approach](http://digital.cabinetoffice.gov.uk/2012/03/19/its-not-about-cookies-its-about-privacy/ "UK Government approach to the EU Cookie Law")
2. [Econsultancy's solution](http://econsultancy.com/us/blog/9453-econsultancy-s-solution-to-eu-e-privacy-directive-compliance/ "Econsultancy's solution")

= Does this plugin stop cookies from being stored? =
No. Quite intentionally, this plugin will not do that. We have no way of knowing what plugins you use or how they work, so blocking/deleting cookies on a WordPress website/blog would possibly/probably break your site. Larger websites with huge budgets may well invest in such technology, but this plugin aims to help you provide a certain level of compliance without taking drastic action. If you do want blocking/deleting cookie functionality then (for now *) this is not the right plugin for you.

(*) Depending upon demand, this feature might be included in a future release.

= Does this plugin guarantee that I comply with this law? =
No.
As a generic plugin there's no way we can know anything about your specific circumstances. It can be used as part of an overall plan of action to comply, but just installing it and doing nothing more does nothing to help you. In all cases, you need to assess your own website's use of cookies and decide an appropriate course of action. If you are looking for specialist legal advice relating to your website you should always consult a lawyer.
See www.cookielawinfo.com for more information on what is required.

= The cookie law doesn't make much sense. How can we stop it? =
Many people agree with you. However it is here, it is law, and according to the Information Commissioner's Office (AKA 'the ICO') it will be enforced. We think it's best to take action to comply as well as petition. However there's no point just ignoring it, it is already here.

= How do I comply with the EU e-Privacy Directive (AKA 'the EU Cookie Law')? =
There are various interpretations of the law within the industry, and as such there is no simple answer. But the main way to ensure you are not penalised is to make some attempt at complying- reviewing your cookie use then using a plugin like this one is a good first step.
See www.cookielawinfo.com for more information.

= The cookie header isn't displaying =
First check you have installed the plugin and have activated it in the plugins panel.
To check if it is switched on or not, go to 'Settings / Cookie Law Info' and then enable the header by setting 'Display cookie bar?' to 'yes'.

= It would be great if your plugin also did XYZ =
Please email me and I'll consider adding that feature. It would be great to hear suggestions on how to improve it.

= The header doesn't work on my browser =
Please report a bug on the support forum. Be sure to include the following information:

* WordPress version e.g. 3.3.2 (found in bottom right hand corner of dashboard)
* Browser name and version e.g. FireFox 4.1
* Describe the problem

The more information you give, the quicker I can respond.

== Screenshots ==

1. Cookie bar in footer (with default styles)
2. Cookie bar "show again tab" (optional- can be switched off or position can be changed)
3. Admin panel
4. Cookie Audit - list your cookies
5. Cookie table displayed on your Privacy Policy page

== Changelog ==

= 0.8.3 =
* First public release.

= 0.9 =
* Improved design & appearance
* Cookie Law Info bar can be shown in header or footer
* Customise fonts
* New animations on page load / close header
* Option to switch off "show again tab" - or position it anywhere horizontally in the header or footer. Additionally the styling has been improved and you are now able to customise the message.
* New button styles: better styling and effects, greater control
* Customise your message using HTML and 5 shortcodes with quick-start default options
* "Cookie Audit" module - document the cookies your site uses then display them in your privacy policy via a shortcode
* Enhanced dashboard
* Enhanced help section
* Refactored codebase, improved jQuery performance
* Bugs fixed: no more slashes in Message Box

== Upgrade Notice ==

= 0.9 =
Major upgrade with several new features including show in footer, custom fonts and a new shortcode for Privacy & Cookie policy page.
