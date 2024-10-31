=== Please Link 2 Me ===
Contributors: geniosity
Donate link: http://www.amazon.com/gp/registry/wishlist/651WOOL713YK
Tags: links, post, posts,
Requires at least: 2.7
Tested up to: 2.9
Stable tag: 1.7

A plugin that adds a text box containing all the code necessary for visitors to easily create links back to your article from their website.

== Description ==

The "Please Link 2 Me" plugin adds a text box containing all the code necessary for visitors to easily create links back to your article from their website.

== Installation ==

1. Upload 'pleaselink2me.php' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the "Please Link 2 Me" plugin options page
4. Add the title to your "link 2 me" request. For example (without the quotes): "Please link to me:"
5. Add formatting tags for before and after the Title text. For example, to make the text bold, add <b> in the "Pre" box, and </b> in the "Post" box
6. Add the description to your "link 2 me" request. For example (without the quotes): "If you found this interesting, use the code in the box below to link to me from your website."
7. Add formatting tags for before and after the Description text. For example, to make the text bold, add <b> in the "Pre" box, and </b> in the "Post" box. Or leave them blank for no extra formatting.
8. Determine the size of your text box that contains the link.
9. Choose whether you want to make the text "read only" in the text box. This will prevent readers from editing the text before selecting it.
10. Choose whether you want the text to automatically be selected once the user/reader clicks in the text box.
11. Choose whether to automatically add the box to your blog post. Leaving this blank will mean you need to edit your template to add the code. (See the step below).
12. If you choose NOT to add the link box automatically to your blog post (in option 8), you will need to add the following to the appropriate location in your theme's template page (for a better example, see the plugin's admin page on your blog): **`<?php if(function_exists('pl2mAddLinkBox')) {pl2mAddLinkBox();} ?>`**

== Screenshots ==

1. The "Please Link 2 Me" plugin options page
2. What will be added to your blog's post.

== More Info ==

For more info on this plugin, you can go to the following pages:

* [Plugin Page](http://www.geniosity.co.za/tools/wordpress-hacks/please-link-2-me-wordpress-plugin/) - If you subscribe to the **comments feed**, you'll get update notifications as soon as I make them

== ChangeLog ==

= 1.7 =
* 2009/12/28
* Added an option to make the text area Read Only
* Added an option so the text is auto selected when a reader clicks in the box

= 1.6 =
* 2009/12/23
* Changed the Template Tag to be used. You must now use "pl2meTemplateTag()" instead of "pl2mAddLinkBox()"

= 1.5 =
* 2009/11/01
* Fixed changelog

= 1.4 =
* 2009/11/01
* Recoded to use new Options methods
* Changed look & feel of admin section
* Added option to modify size of TextArea (the box for link code)
* Changed main URLs for the plugin
* Added ability to add the box to a Page

= 1.3 =
* 2008/08/16
* Fixed issue with saving your options

= 1.2 =
* 2008/05/27
* Fixed issue with the Post Title not getting printed in the text box.

= 1.1 =
* 2008/05/26
* Improved Options Page and option to automatically add the text box under the post.

= 1.0 =
* Initial Release
