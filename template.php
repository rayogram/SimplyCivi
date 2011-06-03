<?php
// $Id: template.php,v 1.15.2.1.2.20.2.1 2009/12/07 19:13:20 designerbrent Exp $

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('SimplyCivi_rebuild_registry')) {
  drupal_rebuild_theme_registry();
}
if (theme_get_setting('SimplyCivi_animated_submit')) {
  drupal_add_js(drupal_get_path('theme', 'SimplyCivi') .'/scripts/submit_animated.js');
}

if (theme_get_setting('SimplyCivi_import_htmlmailings')) {
  drupal_add_js(drupal_get_path('theme', 'SimplyCivi') .'/scripts/htmlmailings.js');
}

/**
 * Implements HOOK_theme().
 */
function SimplyCivi_theme(&$existing, $type, $theme, $path) {
  if (!db_is_active()) {
    return array();
  }
  include_once './' . drupal_get_path('theme', 'SimplyCivi') . '/template.theme-registry.inc';
  return _SimplyCivi_theme($existing, $type, $theme, $path);
}

/**
 * Intercept page template variables
 *
 * @param $vars
 *   A sequential array of variables passed to the theme function.
 */
function SimplyCivi_preprocess_page(&$vars) {
  global $user;
  $vars['path'] = base_path() . path_to_theme() .'/';
  $vars['path_parent'] = base_path() . drupal_get_path('theme', 'SimplyCivi') . '/';
  $vars['user'] = $user;

  // Prep the logo for being displayed
  $site_slogan = (!$vars['site_slogan']) ? '' : ' - '. $vars['site_slogan'];
  $logo_img ='';
  $title = $text = variable_get('site_name', '');
  if ($vars['logo']) {
    $logo_img = "<img src='". $vars['logo'] ."' alt='". $title ."' border='0' />";
    $text = ($vars['site_name']) ? $logo_img . $text : $logo_img;
  }
  $vars['logo_block'] = (!$vars['site_name'] && !$vars['logo']) ? '' : l($text, '', array('attributes' => array('title' => $title . $site_slogan), 'html' => !empty($logo_img)));

  //Play nicely with the page_title module if it is there.
  if (!module_exists('page_title')) {
    // Fixup the $head_title and $title vars to display better.
    $title = drupal_get_title();
    $headers = drupal_set_header();

    // if this is a 403 and they aren't logged in, tell them they need to log in
    if (strpos($headers, 'HTTP/1.1 403 Forbidden') && !$user->uid) {
      $title = t('Please login to continue');
    }
    $vars['title'] = $title;

    if (!drupal_is_front_page()) {
      $vars['head_title'] = $title .' | '. $vars['site_name'];
      if ($vars['site_slogan'] != '') {
        $vars['head_title'] .= ' &ndash; '. $vars['site_slogan'];
      }
    }
    $vars['head_title'] = strip_tags($vars['head_title']);
  }

  //Perform RTL - LTR swap and load RTL Styles.
  if ($vars['language']->dir == 'rtl') {
    // Remove SimplyCivi Grid and use RTL grid
    $css = $vars['css'];
    $css['screen,projection']['theme'][path_to_theme() .'/SimplyCivi/SimplyCivi/plugins/rtl/screen.css'] = TRUE;
    $vars['styles'] = drupal_get_css($css);
    
    //setup rtl css for IE
    $vars['styles_ie']['ie'] = '<link href="'. $path .'css/ie-rtl.css" rel="stylesheet"  type="text/css"  media="screen, projection" />';
    $vars['styles_ie']['ie6'] = '<link href="'. $path .'css/ie6-rtl.css" rel="stylesheet"  type="text/css"  media="screen, projection" />';
  }

  $vars['meta'] = '';
  // SEO optimization, add in the node's teaser, or if on the homepage, the mission statement
  // as a description of the page that appears in search engines
  if ($vars['is_front'] && $vars['mission'] != '') {
    $vars['meta'] .= '<meta name="description" content="'. SimplyCivi_trim_text($vars['mission']) .'" />'."\n";
  }
  elseif (isset($vars['node']->teaser) && $vars['node']->teaser != '') {
    $vars['meta'] .= '<meta name="description" content="'. SimplyCivi_trim_text($vars['node']->teaser) .'" />'."\n";
  }
  elseif (isset($vars['node']->body) && $vars['node']->body != '') {
    $vars['meta'] .= '<meta name="description" content="'. SimplyCivi_trim_text($vars['node']->body) .'" />'."\n";
  }
  // SEO optimization, if the node has tags, use these as keywords for the page
  if (isset($vars['node']->taxonomy)) {
    $keywords = array();
    foreach ($vars['node']->taxonomy as $term) {
      $keywords[] = $term->name;
    }
    $vars['meta'] .= '<meta name="keywords" content="'. implode(',', $keywords) .'" />'."\n";
  }

  // SEO optimization, avoid duplicate titles in search indexes for pager pages
  if (isset($_GET['page']) || isset($_GET['sort'])) {
    $vars['meta'] .= '<meta name="robots" content="noindex,follow" />'. "\n";
  }

  if (theme_get_setting('SimplyCivi_showgrid')) {
    $vars['body_classes'] .= ' showgrid ';
  }

  // Make sure framework styles are placed above all others.
  $vars['css_alt'] = SimplyCivi_css_reorder($vars['css']);
  $vars['styles'] = drupal_get_css($vars['css_alt']);

  /* I like to embed the Google search in various places, uncomment to make use of this
  // setup search for custom placement
  $search = module_invoke('google_cse', 'block', 'view', '0');
  $vars['search'] = $search['content'];
  */

  /* to remove specific CSS files from modules use this trick
  // Remove stylesheets
  $css = $vars['css'];
  unset($css['all']['module']['sites/all/modules/contrib/plus1/plus1.css']);
  $vars['styles'] = drupal_get_css($css);
  */

}

/**
 * Intercept node template variables
 *
 * @param $vars
 *   A sequential array of variables passed to the theme function.
 */
function SimplyCivi_preprocess_node(&$vars) {
  $node = $vars['node']; // for easy reference
  // for easy variable adding for different node types
  switch ($node->type) {
    case 'page':
      break;
  }
}

/**
 * Intercept comment template variables
 *
 * @param $vars
 *   A sequential array of variables passed to the theme function.
 */
function SimplyCivi_preprocess_comment(&$vars) {
  static $comment_count = 1; // keep track the # of comments rendered
  // Calculate the comment number for each comment with accounting for pages.
  $page = 0;
  $comments_previous = 0;
  if (isset($_GET['page'])) {
    $page = $_GET['page'];    
    $comments_per_page = variable_get('comment_default_per_page_' . $vars['node']->type, 1);
    $comments_previous = $comments_per_page * $page;
  }
  $vars['comment_count'] =  $comments_previous + $comment_count;

  // if the author of the node comments as well, highlight that comment
  $node = node_load($vars['comment']->nid);
  if ($vars['comment']->uid == $node->uid) {
    $vars['author_comment'] = TRUE;
  }

  // If comment subjects are disabled, don't display them.
  if (variable_get('comment_subject_field_' . $vars['node']->type, 1) == 0) {
    $vars['title'] = '';
  }
  else {
    $vars['title'] = l($vars['comment']->subject, 'node/'. $vars['node']->nid, array('query' => $query, 'fragment' => $fragment));
  }

  // Add the pager variable to the title link if it needs it.
  $fragment = 'comment-' . $vars['comment']->cid;
  $query = '';
  if (!empty($page)) {
    $query = 'page='. $page;
  }

  $vars['comment_count_link'] = l('#'. $vars['comment_count'], 'node/'. $vars['node']->nid, array('query' => $query, 'fragment' => $fragment));

  $comment_count++;
}

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function SimplyCivi_preprocess_block(&$vars, $hook) {
  $block = $vars['block'];

  // Special classes for blocks.
  $classes = array('block');
  $classes[] = 'block-' . $block->module;
  $classes[] = 'region-' . $vars['block_zebra'];
  $classes[] = $vars['zebra'];
  $classes[] = 'region-count-' . $vars['block_id'];
  $classes[] = 'count-' . $vars['id'];

  $vars['edit_links_array'] = array();
  $vars['edit_links'] = '';

  if (theme_get_setting('SimplyCivi_block_edit_links') && user_access('administer blocks')) {
    include_once './' . drupal_get_path('theme', 'SimplyCivi') . '/template.block-editing.inc';
    SimplyCivi_preprocess_block_editing($vars, $hook);
    $classes[] = 'with-block-editing';
  }

  // Render block classes.
  $vars['classes'] = implode(' ', $classes);
}


/**
 * Intercept box template variables
 *
 * @param $vars
 *   A sequential array of variables passed to the theme function.
 */
function SimplyCivi_preprocess_box(&$vars) {
  // rename to more common text
  if (strpos($vars['title'], 'Post new comment') === 0) {
    $vars['title'] = 'Add your comment';
  }
}

/**
 * Override, remove "not verified", confusing
 *
 * Format a username.
 *
 * @param $object
 *   The user object to format, usually returned from user_load().
 * @return
 *   A string containing an HTML link to the user's page if the passed object
 *   suggests that this is a site user. Otherwise, only the username is returned.
 */
function SimplyCivi_username($object) {
  if ($object->uid && $object->name) {
    // Shorten the name when it is too long or it will break many tables.
    if (drupal_strlen($object->name) > 20) {
      $name = drupal_substr($object->name, 0, 15) .'...';
    }
    else {
      $name = $object->name;
    }

    if (user_access('access user profiles')) {
      $output = l($name, 'user/'. $object->uid, array('attributes' => array('title' => t('View user profile.'))));
    }
    else {
      $output = check_plain($name);
    }
  }
  elseif ($object->name) {
    // Sometimes modules display content composed by people who are
    // not registered members of the site (e.g. mailing list or news
    // aggregator modules). This clause enables modules to display
    // the true author of the content.
    if (!empty($object->homepage)) {
      $output = l($object->name, $object->homepage, array('attributes' => array('rel' => 'nofollow')));
    }
    else {
      $output = check_plain($object->name);
    }
  }
  else {
    $output = variable_get('anonymous', t('Anonymous'));
  }

  return $output;
}

/**
 * Override, make sure Drupal doesn't return empty <P>
 *
 * Return a themed help message.
 *
 * @return a string containing the helptext for the current page.
 */
function SimplyCivi_help() {
  $help = menu_get_active_help();
  // Drupal sometimes returns empty <p></p> so strip tags to check if empty
  if (strlen(strip_tags($help)) > 1) {
    return '<div class="help">'. $help .'</div>';
  }
}

/**
 * Override, use a better default breadcrumb separator.
 *
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function SimplyCivi_breadcrumb($breadcrumb) {
  // Don't add the title if menu_breadcrumb exists. TODO: Add a settings 
  // checkbox to optionally control the display.
  if (!module_exists(menu_breadcrumb) && count($breadcrumb) > 0) {
      $breadcrumb[] = drupal_get_title();
  }
  return '<div class="breadcrumb">'. implode(' &rsaquo; ', $breadcrumb) .'</div>';
}

/**
 * Rewrite of theme_form_element() to suppress ":" if the title ends with a punctuation mark.
 */
function SimplyCivi_form_element($element, $value) {
  $args = func_get_args();
  return preg_replace('@([.!?]):\s*(</label>)@i', '$1$2', call_user_func_array('theme_form_element', $args));
}

/**
 * Set status messages to use SimplyCivi CSS classes.
 */
function SimplyCivi_status_messages($display = NULL) {
  $output = '';
  foreach (drupal_get_messages($display) as $type => $messages) {
    // SimplyCivi can either call this success or notice
    if ($type == 'status') {
      $type = 'success';
    }
    $output .= "<div class=\"messages $type\">\n";
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>'. $message ."</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div>\n";
  }
  return $output;
}

/**
 * Override comment wrapper to show you must login to comment.
 */
function SimplyCivi_comment_wrapper($content, $node) {
  global $user;
  $output = '';

  if ($node = menu_get_object()) {
    if ($node->type != 'forum') {
      $count = ($node->comment_count > 0) ? format_plural($node->comment_count, '1 comment', '@count comments') : t('No comments available.');
      $output .= '<h3 id="comment-number">'. $count .'</h3>';
    }
  }

  $output .= '<div id="comments">';
  $msg = '';
  if (!user_access('post comments')) {
    $dest = 'destination='. $_GET['q'] .'#comment-form';
    $msg = '<div id="messages"><div class="error-wrapper"><div class="messages error">'. t('Please <a href="!register">register</a> or <a href="!login">login</a> to post a comment.', array('!register' => url("user/register", array('query' => $dest)), '!login' => url('user', array('query' => $dest)))) .'</div></div></div>';
  }
  $output .= $content;
  $output .= $msg;

  return $output .'</div>';
}

/**
 * Override, use better icons, source: http://drupal.org/node/102743#comment-664157
 *
 * Format the icon for each individual topic.
 *
 * @ingroup themeable
 */
function SimplyCivi_forum_icon($new_posts, $num_posts = 0, $comment_mode = 0, $sticky = 0) {
  // because we are using a theme() instead of copying the forum-icon.tpl.php into the theme
  // we need to add in the logic that is in preprocess_forum_icon() since this isn't available
  if ($num_posts > variable_get('forum_hot_topic', 15)) {
    $icon = $new_posts ? 'hot-new' : 'hot';
  }
  else {
    $icon = $new_posts ? 'new' : 'default';
  }

  if ($comment_mode == COMMENT_NODE_READ_ONLY || $comment_mode == COMMENT_NODE_DISABLED) {
    $icon = 'closed';
  }

  if ($sticky == 1) {
    $icon = 'sticky';
  }

  $output = theme('image', path_to_theme() . "/images/icons/forum-$icon.png");

  if ($new_posts) {
    $output = "<a name=\"new\">$output</a>";
  }

  return $output;
}

/**
 * Override, remove previous/next links for forum topics
 *
 * Makes forums look better and is great for performance
 * More: http://www.sysarchitects.com/node/70
 */
function SimplyCivi_forum_topic_navigation($node) {
  return '';
}

/**
 * Trim a post to a certain number of characters, removing all HTML.
 */
function SimplyCivi_trim_text($text, $length = 150) {
  // remove any HTML or line breaks so these don't appear in the text
  $text = trim(str_replace(array("\n", "\r", "\r\n"), ' ', strip_tags(html_entity_decode($text, ENT_QUOTES, 'UTF-8'))));
  $text = trim(substr($text, 0, $length));
  $lastchar = substr($text, -1, 1);
  // check to see if the last character in the title is a non-alphanumeric character, except for ? or !
  // if it is strip it off so you don't get strange looking titles
  if (preg_match('/[^0-9A-Za-z\!\?]/', $lastchar)) {
    $text = substr($text, 0, -1);
  }
  // ? and ! are ok to end a title with since they make sense
  if ($lastchar != '!' && $lastchar != '?') {
    $text .= '...';
  }
  return $text;
}

/**
 * This rearranges how the style sheets are included so the framework styles
 * are included first.
 *
 * Sub-themes can override the framework styles when it contains css files with
 * the same name as a framework style. This can be removed once Drupal supports
 * weighted styles.
 */
function SimplyCivi_css_reorder($css) {
  global $theme_info, $base_theme_info;

  // Dig into the framework .info data.
  $framework = !empty($base_theme_info) ? $base_theme_info[0]->info : $theme_info->info;

  // Pull framework styles from the themes .info file and place them above all stylesheets.
  if (isset($framework['stylesheets'])) {
    foreach ($framework['stylesheets'] as $media => $styles_from_bp) {
      // Setup framework group.
      if (isset($css[$media])) {
        $css[$media] = array_merge(array('framework' => array()), $css[$media]);
      }
      else {
        $css[$media]['framework'] = array();
      }
      foreach ($styles_from_bp as $style_from_bp) {
        // Force framework styles to come first.
        if (strpos($style_from_bp, 'framework') !== FALSE) {
          $framework_shift = $style_from_bp;
          $remove_styles = array($style_from_bp);
          // Handle styles that may be overridden from sub-themes.
          foreach ($css[$media]['theme'] as $style_from_var => $preprocess) {
            if ($style_from_bp != $style_from_var && basename($style_from_bp) == basename($style_from_var)) {
              $framework_shift = $style_from_var;
              $remove_styles[] = $style_from_var;
              break;
            }
          }
          $css[$media]['framework'][$framework_shift] = TRUE;
          foreach ($remove_styles as $remove_style) {
            unset($css[$media]['theme'][$remove_style]);
          }
        }
      }
    }
  }

  return $css;
}

