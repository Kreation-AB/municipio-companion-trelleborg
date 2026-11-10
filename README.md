# Municipio Companion Trelleborg

A minimal utility plugin with small fixes and adjustments for the Municipio theme on trelleborgmuni.se.

## Structure

The main plugin file `municipio-companion-trelleborg.php` only loads the feature files:

```
municipio-companion-trelleborg.php   Plugin header, loads includes/
includes/style.php                   Municipio style adjustments
includes/multisite.php               Upgrade insecure requests
includes/projects.php                Project post type and taxonomies (Trelleborg Växer only)
assets/css/municipio-adjustments.css CSS overrides for Municipio
```

## Features

### Municipio style adjustments

Loads `assets/css/municipio-adjustments.css` on the frontend, after all other enqueued stylesheets (`wp_enqueue_scripts` with priority `PHP_INT_MAX`). Put CSS overrides for Municipio in this file.

The stylesheet handle is `municipio-adjustments`. The version is the file's modification time, so browsers fetch the new file after every change. Municipio's `CacheBust` helper is not used, because it only resolves files listed in the theme's build manifest.

Note: the WordPress Customizer's "Additional CSS" is printed later in `wp_head` and can still override these rules.

### Upgrade insecure requests

Prints `<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">` early in the `<head>`:

- Frontend: `wp_head`, priority 1.
- wp-admin: `admin_print_styles`, priority 0. `admin_head` is too late, since it runs after the admin stylesheets are printed and the meta tag only affects requests that come after it.

In the multisite setup, some asset URLs (for example fonts) are generated with `http://` while the site is served over `https://`. Browsers block these as mixed content. The meta tag makes the browser request them over HTTPS instead.

### Projects (Trelleborg Växer)

Registers the post type `project` with the hierarchical taxonomies `project_category` and `project_status`, ported from the old site's mu-plugin. See Architecture below.

## Architecture

### Project post type and taxonomies

- **What:** post type `project` and taxonomies `project_category` and `project_status`. All are public, and the post type is exposed in the REST API (`show_in_rest`), so the block editor can be used. Archive and permalinks: `/projects/`, `/project-categories/<term>/`, `/project-statuses/<term>/`. The `show_in_graphql`/`graphql_*` arguments are kept from the old code but have no effect, since WPGraphQL is not installed.
- **Where:** `includes/projects.php`, registered on `init`.
- **Why:** Trelleborg Växer's existing project content was migrated from the old site and needs these types to be registered.
- **Scope:** only registered when `get_current_blog_id()` equals `MUNICIPIO_COMPANION_TRELLEBORG_VAXER_BLOG_ID` (`4`). The blog ID must match Trelleborg Växer in every environment.
- **Setup:** activate this plugin on Trelleborg Växer, then save permalinks (Settings → Permalinks) on that site. Activating the plugin there also loads the other features above on that site.
- **Note:** admin labels are hardcoded in Swedish and are not translatable. Rewrite slugs are fixed strings.

## Installation

Activate the plugin on the site(s) where it is needed, or network-activate it.
