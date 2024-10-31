<?php
/*
Plugin Name: Please Link 2 Me
Plugin URI: http://www.geniosity.co.za/tools/wordpress-hacks/please-link-2-me-wordpress-plugin/
Description: This plugin adds a text box containing all the code necessary for visitors to easily create links back to your article from their website.
Author: James McMullan
Version: 1.7
Author URI: http://www.geniosity.co.za/
*/


if ( ! class_exists( 'PleaseLink2Me_Admin' ) ) {

    class PleaseLink2Me_Admin {
        function PleaseLink2Me_Admin() {
            add_filter('the_content', array(&$this,'pl2mContentFilter'));
            add_action('admin_init', array(&$this,'pleaselink2me_init'));
            add_action('admin_menu', array('PleaseLink2Me_Admin','add_config_page'));
        }
        function pleaselink2me_init() {
            register_setting( 'pleaselink2me_options', 'pleaselink2me', array('PleaseLink2Me_Admin','pleaselink2me_validate'));
        }

        function add_config_page() {
            add_options_page('Please Link 2 Me Configuration', 'Please Link 2 Me', 'manage_options', 'pl2me_options', array('PleaseLink2Me_Admin','config_page'));
        }

        function pleaselink2me_validate($input) {
            $nOfCols = $input['number-of-columns'];
            if (is_numeric($nOfCols)) {
                $nOfCols = absint($nOfCols);
                if ($nOfCols >= 1 && $nOfCols <= 100) {
                    $input['number-of-columns'] = $nOfCols;
                }else {
                    $input['number-of-columns'] = 50;
                }
            } else {
                $input['number-of-columns'] = 50;
            }
            $nOfRows = $input['number-of-rows'];
            if (is_numeric($nOfRows)) {
                if ($nOfRows >= 1 && $nOfRows <= 100) {
                    $input['number-of-rows'] = $nOfRows;
                } else {
                    $input['number-of-rows'] = 4;
                }
            } else {
                $input['number-of-rows'] = 4;
            }
            $input['description-pre-text'] = wp_filter_kses($input['description-pre-text']);
            $input['description-post-text'] = wp_filter_kses($input['description-post-text']);
            $input['description-text'] = wp_filter_kses($input['description-text']);
            $input['title-pre-text'] = wp_filter_kses($input['title-pre-text']);
            $input['title-post-text'] = wp_filter_kses($input['title-post-text']);
            $input['title-text'] = wp_filter_kses($input['title-text']);
            // $input['auto-show-below-page'] = $input['auto-show-below-page'];
            // $input['auto-show-below-post'] = $input['auto-show-below-post'];

            return $input;
        }

        function pl2mAddLinkBox($mustEcho = true) {
            $options = get_option('pleaselink2me');
            $theTitle = the_title('','',false);

            $theHTMLCode = '';
            $theHTMLCode .= '<div id="please_link_to_me">';
            if ($options['title-text'] != "") {
                $theHTMLCode .= '<div id="please_link_to_me_title">';
                if ($options['title-pre-text'] != "" && $options['title-post-text'] != "") {
                    $theHTMLCode .= stripslashes($options['title-pre-text']);
                }
                $theHTMLCode .= stripslashes($options['title-text']);
                if ($options['title-pre-text'] != "" && $options['title-post-text'] != "") {
                    $theHTMLCode .= stripslashes($options['title-post-text']);
                }
                $theHTMLCode .= '</div>';
            }
            if ($options['description-text'] != "") {
                $theHTMLCode .= '<div id="please_link_to_me_desc">';
                if ($options['description-pre-text'] != "" && $options['description-post-text'] != "") {
                    $theHTMLCode .= stripslashes($options['description-pre-text']);
                }
                $theHTMLCode .= stripslashes($options['description-text']);
                if ($options['description-pre-text'] != "" && $options['description-post-text'] != "") {
                    $theHTMLCode .= stripslashes($options['description-post-text']);
                }
                $theHTMLCode .= '</div>';
            }
            $theHTMLCode .= '<textarea ';
            if ($options['make-read-only'] != "" && $options['make-read-only'] == true) {
                $theHTMLCode .= 'readonly="readonly" ';
            }
            if ($options['make-select-all'] != "" && $options['make-select-all'] == true) {
                $theHTMLCode .= ' onclick="this.focus();this.select();" ';
            }
            $theHTMLCode .= ' rows="'. $options['number-of-rows'] .'" cols="'. $options['number-of-columns'] .'" id="please_link_to_area" name="please_link_to_me_area">&lt;a href=&quot;' . get_permalink() . '&quot; &gt;';
            $theHTMLCode .= $theTitle;
            $theHTMLCode .= '&lt;/a&gt;</textarea>';
            $theHTMLCode .= '</div>';
            if($mustEcho) {
                echo ($theHTMLCode);
            } else {
                return $theHTMLCode;
            }

        }

        function pl2mContentFilter($content = '') {
            $options = get_option('pleaselink2me');

            if ($options['auto-show-below-post'] == true && !is_feed() && is_single()) {
                return $content . $this->pl2mAddLinkBox(false);
            } else if ($options['auto-show-below-page'] == true && !is_feed() && is_page()) {
                    return $content . $this->pl2mAddLinkBox(false);
                } else {
                    return $content;
                }
        }
        function config_page() {
            ?>
<div class="wrap">
    <h2>Please Link 2 Me Configuration</h2>
    <div class="postbox" style="width:20%;float:right;padding:10px;">
        <h4 style="padding: 10px; background: #FFAFB2; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">* Plugin Appreciation</h4>
        If you like this plugin, consider signing up for one of the following services through these links:
        <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Spy on your Visitors</h4>
			If you sign up with <b><a href="http://pmetrics.performancing.com/480">Performancing Metrics</a></b>, you get the option to watch your visitors as they arrive and move around your site.
        <p>
            <b>BEWARE</b>: It's <i>EXTREMELY</i> addictive!
        </p>
        <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">AWESOME VPS hosting for WP</h4>
			I currently use <a href="http://manage.aff.biz/z/146/CD2453/&subid1=pl2me">VPS.net</a> for hosting quite a few WordPress websites (amongst others). I <i>fully</i> recommend it.
        <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Follow me on Twitter</h4>
			Here's my Twitter page: <a href="http://twitter.com/geniosity">@geniosity</a>

    </div>

    <div class="main-settings" style="display:table;width:70%;">
        <div class="postbox">
            <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Settings</h4>
            <form method="post" action="options.php">
                            <?php settings_fields('pleaselink2me_options'); ?>
                            <?php $options = get_option('pleaselink2me'); ?>
                <div class="submit" style="text-align: right; padding-right:5%;"><input type="submit" class="button-primary" name="submit" value="Update Settings" /></div>
                <table class="form-table">
                    <tr>
                        <th><label for="title-text">Title Text:</label></th>
                        <td><input size="60" id="title-text" name="pleaselink2me[title-text]" value="<?php echo stripslashes($options['title-text']) ?>" /> (example: Please link to me)</td>
                    </tr>
                    <tr>
                        <th><label for="title-pre-text">Markup before the Title:</label></th>
                        <td><input size="15" id="title-pre-text" name="pleaselink2me[title-pre-text]" value="<?php echo stripslashes($options['title-pre-text']) ?>" />(example: &lt;strong&gt;)</td>
                    </tr>
                    <tr>
                        <th><label for="title-post-text">Markup after the Title:</label></th>
                        <td><input size="15" id="title-post-text" name="pleaselink2me[title-post-text]" value="<?php echo stripslashes($options['title-post-text']) ?>" />(example: &lt;/strong&gt;)</td>
                    </tr>
                    <tr>
                        <th style="padding-top: 25px;"><label for="description-text">Description:</label></th>
                        <td>(explain why somebody should link to you)<br/>
                            <textarea cols="60" rows="9" name="pleaselink2me[description-text]" id="description-text"><?php echo stripslashes($options['description-text']) ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="description-pre-text">Markup before the Description:</label></th>
                        <td><input size="15" id="description-pre-text" name="pleaselink2me[description-pre-text]" value="<?php echo stripslashes($options['description-pre-text']) ?>" />(example: &lt;strong&gt;)</td>
                    </tr>
                    <tr>
                        <th><label for="description-post-text">Markup after the Description:</label></th>
                        <td><input size="15" id="description-post-text" name="pleaselink2me[description-post-text]" value="<?php echo stripslashes($options['description-post-text']) ?>" />(example: &lt;/strong&gt;)</td>
                    </tr>
                    <tr>
                        <th><label for="number-of-rows">Text Box number of rows:</label></th>
                        <td><input size="5" id="number-of-rows" name="pleaselink2me[number-of-rows]" value="<?php echo stripslashes($options['number-of-rows']) ?>" />The height (in rows) of the text box containing your link. (Default: 4)</td>
                    </tr>
                    <tr>
                        <th><label for="number-of-columns">Text Box number of columns:</label></th>
                        <td><input size="5" id="number-of-columns" name="pleaselink2me[number-of-columns]" value="<?php echo stripslashes($options['number-of-columns']) ?>" />The width (in columns) of the text box containing your link. (Default: 50)</td>
                    </tr>
                    <tr>
                        <th><label for="make-read-only">Make the text Read Only?:</label></th>
                        <td><input type="checkbox" id="make-read-only" name="pleaselink2me[make-read-only]" <?php if ( $options['make-read-only'] == true ) echo ' checked="checked" '; ?>/> (Selecting this will prevent people from editing the text in the box before selecting it)</td>
                    </tr>
                    <tr>
                        <th><label for="make-select-all">Make the text "Auto Selected"?:</label></th>
                        <td><input type="checkbox" id="make-select-all" name="pleaselink2me[make-select-all]" <?php if ( $options['make-select-all'] == true ) echo ' checked="checked" '; ?>/> (Enabling this will set it so the text is automatically selected as soon as the reader clicks in the box)</td>
                    </tr>
                    <tr>
                        <th><label for="auto-show-below-post">Show below the <b>post</b>?:</label></th>
                        <td><input type="checkbox" id="auto-show-below-post" name="pleaselink2me[auto-show-below-post]" <?php if ( $options['auto-show-below-post'] == true ) echo ' checked="checked" '; ?>/> (Selecting this will automatically place this below your post without you editing your theme)</td>
                    </tr>
                    <tr>
                        <th><label for="auto-show-below-page">Show below the <b>page</b>?:</label></th>
                        <td><input type="checkbox" id="auto-show-below-page" name="pleaselink2me[auto-show-below-page]" <?php if ( $options['auto-show-below-page'] == true ) echo ' checked="checked" '; ?>/> (Selecting this will automatically place this below your page without you editing your theme)</td>
                    </tr>
                </table>
                <div class="submit" style="text-align: right; padding-right:5%;"><input type="submit" class="button-primary" name="submit" value="Update Settings" /></div>
            </form>
        </div>
        <div class="postbox">
            <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Example</h4>
            <div style="padding: 10px;">
                <h5 style="font-size:1.3em;">Your Example Post Title</h5>
                <p>So this could be your example post. You'd write and write and write and write and tell people everything they wanted to hear.</p>
                <p>And then, at the bottom, you'd ask people to link to you.</p>
                <p>Depending on your settings above, and obviously the style and layout of your blog, it should look something like it does below.</p>
                <p>Of course, because this isn't REALLY a post on your blog, it can't put the link or title of any actual blog post, so I've taken the liberty of making it really easy for you to "please link 2 me" :-)</p>
                            <?php
                            $example_options = get_option('pleaselink2me');
                            if ($example_options == false || !array_key_exists('number-of-rows', $example_options)) {
                                $example_options['number-of-rows'] = 4;
                            }
                            if ($example_options == false || !array_key_exists('number-of-columns', $example_options)) {
                                $example_options['number-of-columns'] = 50;
                            }
                            echo('<div id="please_link_to_me">');
                            if ($example_options['title-text'] != "") {
                                echo('<div id="please_link_to_me_title">');
                                if ($example_options['title-pre-text'] != "" && $example_options['title-post-text'] != "") {
                                    echo stripslashes($example_options['title-pre-text']);
                                }
                                echo stripslashes($example_options['title-text']);
                                if ($example_options['title-pre-text'] != "" && $example_options['title-post-text'] != "") {
                                    echo stripslashes($example_options['title-post-text']);
                                }
                                echo('</div>');
                            }
                            if ($example_options['description-text'] != "") {
                                echo('<div id="please_link_to_me_desc">');
                                if ($example_options['description-pre-text'] != "" && $example_options['description-post-text'] != "") {
                                    echo stripslashes($example_options['description-pre-text']);
                                }
                                echo stripslashes($example_options['description-text']);
                                if ($example_options['description-pre-text'] != "" && $example_options['description-post-text'] != "") {
                                    echo stripslashes($example_options['description-post-text']);
                                }
                                echo('</div>');
                            }
                            echo('<textarea rows="'. $example_options['number-of-rows'] .'" cols="'. $example_options['number-of-columns'] .'" id="please_link_to_area" name="please_link_to_me_area">&lt;a href=&quot;http://www.geniosity.co.za&quot;&gt;Please link 2 me plugin by geniosity&lt;/a&gt;</textarea>');
                            echo('</div>');
                            ?>
            </div>
        </div>

        <div class="postbox">
            <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">About "Please Link 2 Me"</h4>
            <div class="postbox-content" style="padding: 10px;">
                <p>
					"Please Link 2 Me" is a plugin that allows you to add a text box containing the code necessary for people to copy, paste and thereby create a link back to your post.
					The text box will be placed on your "single posts" and pages. i.e.: Not on the home page, category pages or archive pages.
                </p>
                <p>
					This is useful for those people who have blogs that are frequented by readers who might not be technical enough to copy and paste a URL and create a link out of it.
                </p>
            </div>
            <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Usage</h4>
            <div class="postbox-content" style="padding: 10px;">
                <p>
					If you're reading this, then you probably have the plugin installed and activated on your blog.<br />
					Now it's just a case of placing the code somewhere in your theme so that the box containing the link code will be shown.<br />
                </p>
                <p>
					In the settings section at the top, you need to set up the following:<br />
					- <b>A Title</b>: This is where you can put a heading above the "link box". For example: "<b>Please link to me:</b>" Leave it blank for no heading.<br />
					- <b>A Description</b>: Just a little reason for about what the "link box" contains and why the reader should link to you. Leave it blank to skip the description.<br />
					- <b>Markup before/after</b>: Each of the above sections can be surrounded by html markup that will help you style the section to your liking. For example, giving the Title &lt;h3&gt; tags to make it a heading. If either the "before" box or the "after" box is empty, the markup will be skipped.<br />
                    - <b>Text Box number of rows</b>: Change the default number of rows for the text box (the height). Allows you to customise it a little to fit in with your theme.<br />
                    - <b>Text Box number of columns</b>: As above, but for the number of columns (width).<br />
                    - <b>Make the text Read Only?</b>: If this is selected, the user won't be able to edit the text in the text box before selecting it.<br />
                    - <b>Make the text "Auto Selected"?</b>: If this is selected, the text will be automatically selected as soon as a user clicks in the text box.<br />
					- <b>Show below Post?</b>: If you tick this box, then you won't need to edit your template file at all. The "Please Link 2 Me" box will be placed below your blog post automatically.<br />
					- <b>Show below Page?</b>: As above, but this will put the box on your site's Pages.<br />
                    - <b>Number of Columns/Rows?</b>: This will help you shrink/enlarge the actual text box to match your theme.<br />
                </p>
                <p>
                <h5>Styling options</h5>
                If you're familiar with CSS you can style the following Elements:<br />
                <ul style="margin:20px;list-style:square;">
                    <li><i>please_link_to_me_title</i></li>
                    <li><i>please_link_to_me_desc</i></li>
                    <li><i>please_link_to_area</i></li>
                </ul>
                </p>
                <p>
					If you don't select the "<b>Show below Post?</b>" option, you will need to edit your site's theme. Open up the template file where you'd like to place this code. The first thing you should look for is a file called "<b>single.php</b>", and if that doesn't exist, then open up "<b>index.php</b>".<br />
                </p>
                <p>
					You probably want to put this "link box" above the comment box, so you could probably just look for the "<b>&lt;?php comments_template(); ?&gt;</b>" line, or, if you can't find that, then you'd probably want to put the code above this line: "<b>&lt;?php endwhile; else: ?&gt;</b>"
                </p>
                <p>
					And here is the code that you will need to place in your template file:<br />
                    <b>&lt;?php if(function_exists('pl2meTemplateTag')) {pl2meTemplateTag();} ?&gt;</b>
                </p>
            </div>
            <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">More Info</h4>
            <div class="postbox-content" style="padding: 10px;">
                <p>
					You can get more info regarding this plugin from the following pages:
                <ul>
                    <li><b><a href="http://www.geniosity.co.za/tools/wordpress-hacks/please-link-2-me-wordpress-plugin/">Please Link 2 Me homepage</a></b> - If you subscribe to the comments feed you'll keep up with release announcements</li>
                    <li><b><a href="http://wordpress.org/extend/plugins/please-link-2-me/">Download the plugin</a></b></li>
                </ul>
                </p>
            </div>
        </div>
    </div>

</div>
        <?php
        }

    }
    $pl2me = new PleaseLink2Me_Admin();
    function pl2meTemplateTag() {
        global $pl2me;
        $pl2me->pl2mAddLinkBox();
    }
}

?>
