# Verify Bluesky Domain Plugin

## Description

<img src="logo.jpg" alt="Bluesky Domain Plugin Logo" width="300" height="300">

The **Verify Bluesky Domain** plugin allows you to easily verify your domain for Bluesky by adding a custom route that returns a user-defined DID (Decentralized Identifier) string. This verification process is required to associate your domain with your Bluesky account.

Once installed and activated, the plugin creates a route at `/.well-known/atproto-did` which will return the DID string you specify in the plugin settings. This enables domain verification for Bluesky, allowing you to link your domain with your Bluesky profile.

## Features

- Adds a route to `/.well-known/atproto-did` to serve a custom DID string.
- Provides an easy way to verify your domain with Bluesky.
- Simple and lightweight, with minimal setup required.

## Installation

1. **Install the Plugin:**

   Clone or download this repository into the `wp-content/plugins/` directory of your WordPress installation.

2. **Activate the Plugin:**

   - After installation, go to the **Plugins** section of your WordPress admin panel and activate the **Verify Bluesky Domain** plugin.

3. **Configure the DID String:**

   - Once activated, go to **Settings > Verify Bluesky Domain** in the WordPress admin panel.
   - Enter your DID string in the provided field.
   - Save your settings.

4. **Domain Verification:**
   - Visit `https://yourdomain.com/.well-known/atproto-did` to verify the DID string is being correctly returned.
   - Follow the Bluesky domain verification instructions to complete the process.

## Usage

After the plugin is configured, Bluesky will be able to verify your domain by checking the DID string at the `/.well-known/atproto-did` URL. Once verified, your Bluesky account will be associated with your domain.

## License

This plugin is licensed under the GPLv2 license.

## Author

**Proverbial Ninja**  
[Website](https://proverbial.online)

## Changelog

### 1.0

- Initial release of the plugin.

---

For support or feature requests, please visit the plugin repository or contact the author via the provided website.
