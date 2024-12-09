<?php

/**
 * Plugin Name: Verify Bluesky Domain
 * Description: Adds a route for /.well-known/atproto-did to return a user-defined DID string to enamble domain verification on Bluesky.
 * Version: 1.0
 * Author: Proverbial
 * Author URI: https://proverbial.online
 * License: GPL2
 * Text Domain: verify_bluesky_domain
 */

add_action('init', 'atproto_did_register_route');

function atproto_did_register_route()
{
    if (!function_exists('add_rewrite_rule')) {
        return;
    }

    add_rewrite_rule(
        '^\.well-known/atproto-did/?$',
        'index.php?atproto_did=1',
        'top'
    );
}

add_filter('query_vars', 'atproto_did_query_vars');
function atproto_did_query_vars($query_vars)
{
    $query_vars[] = 'atproto_did';  // Add a new query var for the custom route
    return $query_vars;
}

add_action('template_redirect', 'atproto_did_template_redirect');
function atproto_did_template_redirect()
{
    if (get_query_var('atproto_did')) {
        $user_did = get_option('atproto_user_did');

        header('Content-Type: text/plain');
        echo $user_did ? $user_did : 'DID not set.';
        exit();
    }
}

add_action('admin_menu', 'atproto_did_add_settings_page');
function atproto_did_add_settings_page()
{
    add_options_page(
        'ATProto DID Settings',
        'ATProto DID',
        'manage_options',
        'atproto-did',
        'atproto_did_settings_page',
    );
}

function atproto_did_settings_page()
{
?>
    <div class="wrap">
        <h1>ATProto DID Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('atproto_did_options_group');
            do_settings_sections('atproto-did');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="atproto_user_did">User DID</label></th>
                    <td>
                        <input type="text" id="atproto_user_did" name="atproto_user_did" value="<?php echo esc_attr(get_option('atproto_user_did')); ?>" class="regular-text" />
                        <p class="description">Enter the DID string that begins with "did:"</p>
                        <p class="description">Click here to find out your did <a href="https://ilo.so/bluesky-did/">https://ilo.so/bluesky-did/</a></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Register plugin settings
add_action('admin_init', 'atproto_did_register_settings');
function atproto_did_register_settings()
{
    register_setting('atproto_did_options_group', 'atproto_user_did');
}
