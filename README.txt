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
    
    You can add "Full Text Search" to the Header, and it will configure itself with a few bonuses.

--- FEATURES --------------------------------------------------------

- normalizes Drupal's CSS to be consistent
- properly aggregates all SimplyCivi CSS files into a single file when this setting is enabled
- Adds custom icons for contact types
- Contact tabs are in a "sidebar" 
- Drupal and CiviCRM messages are aggregated and positioned at the top of the page, clearly visible and hideable
- CSS alterations to CiviCRM are broken out for easy adaption into your own theme

Drupal 6 version:
- Hover over blocks to reveal admin links to edit and configure the blocks as well as edit the menu blocks.
- Support for sub-themes.

--- TIPS --------------------------------------------------------

- put your custom styles in css/style.css
- put any IE hacks into css/ie.css (conditionally loaded as needed)
- admin/build/themes/settings
  - enable site slogan (add one, good for SEO)
  - enable mission statement (used as META description for homepage in search engines)
  - enable user pictures
- Configure the comments for each node type 
  - admin/content/node-type/<typename> - Flat list - expanded, Date - oldest first, Display below post or comments.
  - You will need to do this for each content type that has comments enabled.
- (performance) remove line 76 in screen.css : .showgrid {background:url(src/grid.png);}  
  this saves an uncessary HTTP request on your server
- (performance) apply system.css.patch to remove uncessary HTTP requests to images that SimplyCivi overrides already



--- USING SimplyCivi --------------------------------------------------------

SimplyCivi aligns designs to a grid. If you add a class "showgrid" to any <div class="container showgrid"> it will
show you the grid it is working with, both in terms of columns and rows. You can read more by following the links
on the homepage: http://www.SimplyCivicss.org/

To get SimplyCivi to work with Drupal (because Drupal adds in paddings, borders, and more), we need to override
some values in Drupal and recalculate others so that it more closely follows the grid. Here are how such
calculations work:

# Default values
  - Browsers default font-size: 16px
  - Base font-size: 75% = 12px = 1em
  - Base line-height: 1.5em = 18px

# Calculating font size
  * font-size (em) to font-size (px):
    base * relative = result
    12px * 0.9em    = 10.8px

  * font-size (px) to font-size (em):
    font-size / base font-size = relative font-size
    15px      / 12px           = 1.25em

# Calculating line height
  * font-size (px) to line-height (em):
    base line-height / font-size = line-height
    18px             / 10px      = 1.8em

    * font-size (em) to line-height (em):
    base line-height / (base font-size * font-size) = line-height
    18px             / (12px           * 0.9em    ) = 1.667em

# Calculating pixel size
  1 / font-size = 1 pixel in ems
  1 / 12px      = 0.0834em

# Using horizontal borders
  The box model states that border width is added to the dimensions of the box. This means whenever a top or bottom border
  is used, we must account for the extra height by decreasing the padding.

  Example

  Here we need to adjust the padding-bottom value to account for the extra pixel added by the border-bottom:

    .class {
      border-bottom: 1px solid #ccc;
      padding-bottom: 1.5em;   /* WRONG!! */
    }

  The line height is 18px and putting a padding-bottom of 1.5em gives us a nice full line break below. But because we
  have a border too, we need to do slightly less than 1.5em (e.g., 18px - 1px):

    required pixels / base-font = em value
    17px            / 12px      = 1.4167em

    .class {
      border-bottom: 1px solid #ccc;
      padding-bottom: 1.4167em;   /* CORRECT :) */
    }


--- NOTE: -----------------------------------------------------------
SimplyCivi theme now includes two ways of adding a logo: via the $logo variable or via css. There is a setting in the theme settings to choose your method.

If you use the css method, here are some tips for adding it.

h1 a{
width: [width of logo];
height: [height of logo];
display:block;
text-indent: -99999em;
background: url(../images/logo.png) no-repeat left top;
}

What this ends up doing is removing the text title of the site, and replacing it with a background image of the logo that is still linked to the homepage of the site.

