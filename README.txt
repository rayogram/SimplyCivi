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

1. Place the SimplyCivi folder in your themes directory.

2. Enable theme under Administer > Site building > Themes

3. Download and enable the civicrm_theme module at http://www.drupal.org/project/civicrm_theme

4. Configure http://yoursite/admin/settings/admin to use the SimplyCivi theme for "CiviCRM Admin Pages"

5. Add your CiviCRM Blocks in the SimplyCivi theme : http://yoursite/admin/build/block/list/SimplyCivi :
    
    There are regions setup for Recent Items, Quick Add and Create New Record.
    
    You can add "Full Text Search" to the Header, and it will configure itself


--- FEATURES --------------------------------------------------------

- normalizes Drupal's CSS to be consistent
- properly aggregates all SimplyCivi CSS files into a single file when this setting is enabled
- Adds custom icons for contact types
- Contact tabs are in a "sidebar" 
- Drupal and CiviCRM messages are aggregated and positioned at the top of the page, clearly visible and hideable
- CSS alterations to CiviCRM are broken out for easy adoption into your own theme
- single column design for best use of CiviCRM while maintaining easy access to existing sidebars for your actual site
- Getting close to full support of Drupal KIT theme specification http://drupal.org/project/kit

Drupal 6 version:
- Hover over blocks to reveal admin links to edit and configure the blocks as well as edit the menu blocks.
- Support for sub-themes.

