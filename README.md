# Multisite add-on for concrete5

This is an add-on for the concrete5 content management system. It is somewhat similar to the [Domain Mapper](http://www.concrete5.org/marketplace/addons/domain_mapper/) add-on, but takes domain mapping a few steps further for a true multi-site setup. 

Originally, I intended to sell this add-on through the concrete5 Marketplace for $75, but I soon discovered that the variances between server configurations made a lot of what this add-on does difficult to support globally (and difficult to get past concrete5's add-on approval), and ultimately I decided it would be better to offer for free (and open source!). I also needed to free up one of my 5 private repositories.

## Features

 - Map any parked domain name to any page in your concrete5 sitemap
 - Create unlimited websites in a single concrete5 installation
 - Automatically rewrite and mask URLs so the multi-site configuration is invisible to your site's users
 - Share users, groups, permissions, themes, and settings between multiple websites
 - Make concrete5 updates even simpler by updating only one instance of C5 for all of your websites

## System requirements

Ideally this should work on any typical LAMP stack with concrete5 (version 5.5+ recommended), but server configurations can vary widely - so your mileage may vary.

## Example Usage

Say you have a website with concrete5 installed. You are about to launch a new product and want to give the new product its own microsite. You decide that you love using concrete5, but don't see the need for an entire separate installation just for a handful of static pages. You decide that my Multisite add-on is right for you.

 1. Create the new homepage in your concrete5 sitemap. (You might want to set it so that the page is excluded from navigation, page lists, and sitemap.xml, depending on your needs)
 2. Create any sub-pages for the new site underneath the newly created homepage.
 3. Make sure that your new domain name's DNS records are pointing to the server with your concrete5 version installed.
 4. Go to the multisite area of the dashboard and add this newly created page to the Multisite records.
 5. That should be it! If your .htaccess file and pretty URLs are configured correctly, it should "just work."
 
### A note about AutoNav

concrete5's AutoNav block is incredibly useful, but it won't automatically work with this add-on. You will need to customize the AutoNav templates to point to the correct URLs in any sub-sites. This shouldn't be difficult, and if you're nice, I'll see about getting a code sample up here to help. 

## Donations

I don't expect any compensation for this add-on, but if it has been useful to you (and/or has saved you money from purchasing other multisite add-ons), feel free to [donate to me via PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VVQ7E57MWASDY). 

That's it! When it comes down to it, it's a very basic add-on to use, and tries to take care of most of the heavy lifting for you. Feel free to fork and submit pull requests if you come across any bugs or want to add any features.

## License

MIT License:

Copyright (c) 2012 David Strack

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
