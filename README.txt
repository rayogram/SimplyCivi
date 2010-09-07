# $Id: README.txt,v 1 2010/09/07 16:00:00 kylejaster Exp $


--- README  -------------------------------------------------------------

SimplyCivi, Version 1.x

Design and Development by Kyle Jaster for rayogram
kyle@rayogram.com
http://rayogram.com

Requirements: Drupal 6.x
Recommended: CiviCRM 3.2.x, civicrm_theme module

Much borrowed from the Blueprint theme (except, not blueprint.css!) hard work by:

Brent Hardinge, aka, designerbrent
 designerbrent@gmail.com
 http://brenthardinge.net/
 
Contributors:

Originally by Ted Serbinski, aka, m3avrck
  hello@tedserbinski.com
  http://tedserbinski.com

Richard Burford, aka, psynaptic
 rich@freestylesystems.co.uk
 http://www.freestylesystems.co.uk

--- INSTALLATION --------------------------------------------------------

1. have a working version of CiviCRM installed on your Drupal site

2. Download the latest version of the SimplyCivi theme:

	http://github.com/kylejaster/SimplyCivi/zipball/master

	Place it in you sites/all/themes directory (you may wish to rename the 
    directory to "SimplyCivi" - github adds a silly name) and enable it at 
    admin/build/themes
    
    ALTERNATE OPTION: clone the SimplyCivi project into your 
    sites/all/themes directory with this command:
    git clone git@github.com:kylejaster/SimplyCivi.git

3. Download, install and enable the civicrm_theme module:

	http://drupal.org/project/civicrm_theme

4. Visit the Admin Theme configuration page at: admin/settings/admin
	
	Configure the "CiviCRM Administration Theme" to use "SimplyCivi"

5. Configure your CiviCRM blocks for the SimplyCivi theme at: 
	
	admin/build/block/list/SimplyCivi

	There are regions for many of the blocks CiviCRM provides, simply match 
	the blocks to the regions (place "CiviCRM full text search" into the 
	"Header" region)

	Additional blocks may be put into the Left and Right sidebars - these 
	are hidden by default, but show tabs on the left and right sides of 
	the screen when enabled.

    Once you have configured your blocks, you are done! 
    
    Visit yoursite.org/civicrm/dashboard?reset=1 and 
    enjoy your clean new CiviCRM admin theme. 



--- FEATURES --------------------------------------------------------

- normalizes Drupal's CSS to be consistent

- properly aggregates all SimplyCivi CSS files into a single file 
  when this setting is enabled

- Adds custom icons for contact types

- Contact tabs are in a "sidebar" 

- Drupal and CiviCRM messages are aggregated and positioned at the top 
  of the page, clearly visible and hideable

- CSS alterations to CiviCRM are broken out for easy adoption into your 
  own theme

- single column design for best use of CiviCRM while maintaining easy 
  access to existing sidebars for your actual site

- Getting close to full support of Drupal KIT theme specification 
  http://drupal.org/project/kit
