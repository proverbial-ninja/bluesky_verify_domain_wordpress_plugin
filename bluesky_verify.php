<?php

/*
 * Plugin Name: Verify Bluesky Domain
 * Plugin URI: https://github.com/proverbial-ninja/bluesky_verify_domain_wordpress_plugin
 * Description: Allows users to easily verify their domain for Bluesky by adding a custom  route "yourdomain.com/.well-known/atproto-did" that returns a user-defined DID (Decentralized Identifier) string.
 * Version: 1.0.0
 * Author:            Proverbial
 * Author URI:        https://proverbial.online/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: verify-bluesky-domain
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
        echo esc_html($user_did ? $user_did : 'DID not set.');
        exit();
    }
}

add_action('admin_menu', 'atproto_did_add_settings_page');
function atproto_did_add_settings_page()
{
    add_options_page(
        'Set Well-Known ATProto DID',
        'Verify Bluesky Domain',
        'manage_options',
        'atproto-did',
        'atproto_did_settings_page',
    );
}

function atproto_did_settings_page()
{
?>
    <div class="wrap">
        <h1>Set your Bluesky DID</h1>
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
                        <p class="description">Click here to find out your did <a target="_blank" href="https://ilo.so/bluesky-did/">https://ilo.so/bluesky-did/</a></p>
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
