=== Sageus Theme ===

Contributors: Plutonius
Donate link: 
Tags: one-column, two-columns, three-columns, left-sidebar, custom-background, custom-colors, custom-header, custom-menu, editor-style, featured-images, flexible-header, full-width-template, post-formats, rtl-language-support, sticky-post, theme-options, threaded-comments, translation-ready, portfolio
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A trendy one-page parallax theme designed with book authors and film-makers in mind.

== Description ==

Sageus is a modern, minimal WordPress theme with parallax scrolling effects, perfect for showcasing your work through a portfolio or blog. The theme features:

* **Static Front Page**: Full-screen hero panel with site logo/title, menu, and page content
* **Content Panels**: Up to three additional panels built from static pages, each with optional one- or two-column content
* **Parallax Scrolling**: Hero, panel and footer images use fixed background attachment for stunning parallax effects
* **Blog Format**: Traditional blog layout with square panels, three across, displaying image, title, date, and author
* **Portfolio Template**: Showcase your work with hover-over project info, project type filters, and up to 120 projects
* **Responsive Design**: Fully responsive layout that looks great on all devices
* **Custom Menus**: Top navigation in a translucent block, plus a footer social links menu with auto-detected icons
* **Widgets**: Sidebar (hidden on static front page) and footer widget areas
* **Customizer Options**: Panel page selectors, per-panel column choice, header top text strings, and footer image

== Theme Specifications ==

* Front page column width: 1120px
* Content column width: 700px
* Sidebar width: 336px
* Full-width text on pages: 1520px
* Featured/Header image size: 2000x1200 pixels
* Site logo maximum height: 200px

== Installation ==

1. Upload the `sageus-theme-theme` folder to the `/wp-content/themes/` directory
2. Activate the theme through the 'Appearance > Themes' menu in WordPress
3. Set up your static front page in 'Settings > Reading' or use the default blog format

== Setting Up the Front Page ==

**For a Static Front Page:**

1. Go to **Settings > Reading**
2. Select "A static page" and choose your front page
3. Create pages for each panel you want to display
4. For each page, assign a featured image (recommended: 2000x1200 pixels)
5. Go to **Appearance > Customize > Theme Options > Front Page Panels**
6. Select pages for each panel and choose the column layout
7. Optional: Set a footer image in **Theme Options > Footer Image**

**For a Blog Front Page:**

1. Go to **Settings > Reading**
2. Select "Your latest posts" for the front page
3. The theme will automatically display posts in a square panel grid (three across)

== Header Top Text ==

Add two strings of text to the top of the theme next to the menu:

1. Go to **Appearance > Customize > Theme Options > Header Top Text**
2. Enter text for the left and/or right positions
3. HTML is allowed, so you can include links, icons, etc.

== Portfolio ==

Sageus includes a built-in portfolio system:

**Option 1: Use Portfolio Template on a Page**

1. Create a new page
2. Select the "Portfolio Template" from the Page Attributes meta box
3. Publish the page
4. Optional: Set this page as a panel on the front page

**Option 2: Use Portfolio Post Type**

1. Create portfolio items using the built-in "Portfolio" post type
2. Assign featured images and categorize by Portfolio Type
3. All portfolio items will be displayed at /portfolio/

**Option 3: Use Jetpack Portfolio Plugin**

If you have Jetpack installed and the Portfolio module activated, Sageus will automatically use Jetpack's portfolio system.

== Social Menu ==

Create a social links menu:

1. Go to **Appearance > Menus**
2. Create a new menu and assign it to the "Social Menu" location
3. Add links to your social media profiles
4. The theme will automatically detect and display the appropriate icon for each service

Supported services include: Bandcamp, CodePen, Digg, Dribbble, Dropbox, Email (mailto:), Facebook, Flickr, Foursquare, GitHub, Google+, Instagram, LinkedIn, Path, Pinterest, Pocket, Polldaddy, Reddit, RSS (/feed/), Skype, SoundCloud, Spotify, StumbleUpon, Tumblr, Twitch, Twitter, Vimeo, Vine, WordPress, YouTube

== Customizer Options ==

**Theme Options Panel:**

* **Header Top Text**: Add text to appear on either side of the header
* **Front Page Panels**: Select pages for up to three panels and choose column layouts
* **Footer Image**: Upload an image to display as a full-width footer on the front page
* **Custom Colors**: Change the primary, secondary, text, and link colors
* **Custom Fonts**: Change the heading and body fonts (Google Fonts)

== Frequently Asked Questions ==

**Q: How do I change the number of portfolio items displayed?**
A: By default, the portfolio template displays up to 120 items. When used as a front-page panel, it displays 6 items. You can modify this by editing the template files.

**Q: Can I use a different portfolio plugin?**
A: Yes! Sageus is compatible with Jetpack's Portfolio module. If you have another portfolio plugin, the theme will automatically detect and use it.

**Q: How do I make the header stick to the top when scrolling?**
A: The header becomes fixed when you scroll down the page. This is built into the theme's JavaScript.

**Q: Can I change the parallax effect speed?**
A: Yes, you can modify the parallax speed by editing the JavaScript in `/js/sageus-theme.js`. Look for the `translateY` values and adjust the multipliers.

**Q: How do I add custom CSS?**
A: Go to **Appearance > Customize > Additional CSS** and add your custom styles there.

== Changelog ==

= 1.0 = * Initial release

== License ==

Sageus Theme is licensed under the GNU General Public License v2 or later.

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
