=== BHM Random Quote ===
Contributors: bmarston
Donate link:
Tags: quote, custom post type, random, widget, plugin, sidebar, post format
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display a random quote from your collection in a sidebar using a widget

== Description ==

To add a quote, go to Quotes->Add New. Enter the citation (source or author) for the quote and the quote itself. You can use HTML in both the citation and the quote. For styling purposes, the post format defaults to "Quote."

To add the widget to a sidebar, go to Appearance->Widgets and drag the Quote widget to the sidebar. Set the "Title" to the text you want to be displayed above the random quote in the sidebar.

The HTML displayed by the widget looks like this:

	<div class="quote">
		&#8220;the_quote&#8221;
	</div>
	<div class="citation">
		&mdash;the_citation
	</div>
	<div class="all-quotes">
		[<a href="quote_archive_url">View All</a>]
	</div>

== Installation ==

1. Upload `bhm-quote.php` to your `wp-content/plugins/` directory.
1. Activate the Random Quote plugin through the 'Plugins' menu in WordPress.
1. Add your quotes using Quotes->Add New.
1. Go to Appearance->Widgets and drag the Quote widget to the sidebar.

== Frequently asked questions ==

= Can I use HTML in my quotes and citations? =

Yes.

= How can I style my quotes on single, index, archive, and search pages if I'm using the Twenty Twelve theme? =

Create a child theme with a `content-quote.php` template file.

= Where can I see an example of this plugin in action? =

[fatdays.com](http://fatdays.com/)

= What does "BHM" stand for? =

Brian Henry Marston (the plugin's author)

= How can I contact the plugin's author? =

webguy@fatdays.com


== Screenshots ==

1. Add New Quote
2. All Quotes
3. Appearance->Widgets

== Changelog ==

= 0.1 =
* Game on!

== Upgrade Notice ==
