# Municipio Companion Trelleborg

A minimal utility plugin with small fixes and adjustments for the Municipio theme on trelleborgmuni.se.

## Structure

The main plugin file `municipio-companion-trelleborg.php` only loads the feature files:

```
municipio-companion-trelleborg.php   Plugin header, loads includes/
includes/style.php                   Municipio style adjustments
includes/multisite.php               Upgrade insecure requests
includes/projects.php                Project post type and taxonomies (Trelleborg Växer only)
includes/query-performance.php       Remove duplicated meta query clauses in Posts module queries
includes/page-excerpt.php            Excerpt support for pages
assets/css/municipio-adjustments.css CSS overrides for Municipio
```

## Features

### Municipio style adjustments

Loads `assets/css/municipio-adjustments.css` on the frontend, after all other enqueued stylesheets (`wp_enqueue_scripts` with priority `PHP_INT_MAX`). Put CSS overrides for Municipio in this file.

The stylesheet handle is `municipio-adjustments`. The version is the file's modification time, so browsers fetch the new file after every change. Municipio's `CacheBust` helper is not used, because it only resolves files listed in the theme's build manifest.

Note: the WordPress Customizer's "Additional CSS" is printed later in `wp_head` and can still override these rules.

All rules are wrapped in `@layer theme` and use native CSS nesting, `:has()` and `color-mix()`.

Current adjustments:

- **Header:** fixed font size for the brand text in the flexible header.
- **Search page** (`.search-index-page`, Municipio's `SearchIndex` search page):
  - Removes the default background, shadow, margins and padding around the toolbar, filters and results.
  - Filters (facets) are shown as clickable chips in the primary color, with a secondary color for checked options, a hover state and a visible focus outline. The facet legend gets a trailing colon.
  - Pagination buttons are at least 44×44 px, and the current page is highlighted in the secondary color.
  - Result images are cropped from the top (`object-position: center top`).
  - From 896 px width, the filters are placed above the results instead of beside them, with the legend and chips on one row, and the pagination is centered.

The search page rules depend on Municipio's class names. If Municipio changes the search page markup, review them.

### Upgrade insecure requests

Prints `<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">` early in the `<head>`:

- Frontend: `wp_head`, priority 1.
- wp-admin: `admin_print_styles`, priority 0. `admin_head` is too late, since it runs after the admin stylesheets are printed and the meta tag only affects requests that come after it.

In the multisite setup, some asset URLs (for example fonts) are generated with `http://` while the site is served over `https://`. Browsers block these as mixed content. The meta tag makes the browser request them over HTTPS instead.

### Remove duplicated meta query clauses

Workaround for slow posts modules for logged-in users. Municipio's `RestrictPrivatePostToUserGroup` adds a `user-group-visibility` clause to `meta_query` on every `pre_get_posts` (priority 1), and Modularity's Posts module runs the same `WP_Query` twice. The second run gets the clause twice, which joins `wp_postmeta` four times and makes the query grow with the square of the meta rows per post (over 2 s per posts module in production).

Only Posts module queries are touched. The module's args filter `Modularity/Module/Posts/GetPosts/Args` adds the query var `municipio_companion_trelleborg_posts_module` to its query. A `pre_get_posts` callback at priority 2 then removes, for marked queries only, unnamed `meta_query` clauses that are exact duplicates of an earlier clause. The result is unchanged, since both "A AND A" and "A OR A" equal "A". Named clauses (used by `orderby`) are kept, and queries without duplicates are not touched. The module's sticky posts query does not pass the args filter and is not marked, but it only fetches a few posts by ID and stays cheap.

If Municipio renames or removes the `Modularity/Module/Posts/GetPosts/Args` filter, the workaround silently stops working and Posts modules become slow for logged-in users again.

Can be removed when Municipio no longer adds the clause twice.

### Excerpt on pages

Adds `excerpt` support to the `page` post type on `init`. WordPress core only enables excerpts for posts, and Municipio's "Post type functions" setting only applies to custom post types created through Municipio, not to the built-in pages.

In the classic editor the excerpt box may be hidden by default; enable it under Screen Options.

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
