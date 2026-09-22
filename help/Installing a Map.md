<!--
# leaflet module
# installing a map on a page
#
# Part of »Zugzwang Project«
# https://www.zugzwang.org/modules/leaflet
#
# @author Gustaf Mossakowski <gustaf@koenige.org>
# @copyright Copyright © 2026 Gustaf Mossakowski
# @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
#
# Variables
# audience = programmer
-->

# Installing a Map

This module embeds interactive maps with [Leaflet](https://leafletjs.com/)
and Mapbox raster tiles. Often, the map sits in the page footer and shows one
marker for your address.

## Dependencies

Install both Git submodules:

* `_inc/modules/leaflet` — this module (templates, settings)
* `www/_behaviour/leaflet` — Leaflet CSS and JavaScript under
  `/_behaviour/leaflet/`

After cloning, run `git submodule update --init` in the project root (or
clone with `--recursive`).

Optional plugins (marker clustering, fullscreen) need extra libraries under
`www/_behaviour/` and the matching settings in `configuration/settings.cfg`
(`leaflet_markercluster`, `leaflet_fullscreen`).

## Mapbox settings

Create a Mapbox access token and a map style in [Mapbox Studio](https://studio.mapbox.com/).
Configure these settings (site or module configuration):

| Setting | Purpose |
|---------|---------|
| `mapbox_access_token` | Public token (`pk.…`) |
| `mapbox_user` | Mapbox account user name |
| `mapbox_style` | Style ID used in `styles/v1/{user}/{style}` |

The template `leaflet-tiles-mapbox` builds the tile layer from these values.

## Location map settings

The script `behaviour/location-map.js` (loaded as `%%% script leaflet/location-map.js %%%`)
initialises a single-marker map in the element `#map`. Configure the position and
labels in site configuration.

## Page template

Reference the module templates and the location map script from a page template
(for example the theme’s `page.template.txt`).

In the document `head`, after `%%% page head %%%`, load Leaflet CSS:

	%%% template leaflet-head %%%

Place a map container in the HTML where the map should appear. The location map
script expects the element id `map`:

	<div id="map"></div>

Before `</body>` or `</html>`, load Leaflet and the location map script:

	%%% template leaflet-js %%%
	%%% script leaflet/location-map.js %%%

The `script` line resolves to `/_behaviour/leaflet/location-map.js` (module
`behaviour/location-map.js`, processed as a zzbrick template).

Example (footer map on every page):

	<footer>
	…
	<div id="map"></div>
	</footer>
	</div>
	%%% template leaflet-js %%%
	%%% script leaflet/location-map.js %%%

For maps with custom behaviour (several markers, other controls), use your own
script under the theme or a separate module behaviour file instead of
`location-map.js`.

## CSS: height of `#map`

Leaflet measures the **map container element** (`#map`), not a wrapper around
it. The container needs an explicit height (or `height: 100%` with a parent
that has a defined height). Without that, the map area stays empty or only
shows a background colour on a parent box.

Example:

	footer #map {
		height: 700px;
		margin: 6.25rem auto 0;
	}

Adjust layout (width, grid placement, margins) to match your theme.

## Other map types

* **zzform table on a map** — template `leaflet-zzform-map` (GeoJSON layer,
  optional marker clustering). See `templates/leaflet-zzform-map.template.txt`.
* **Event participants** — template `leaflet-participants-map` and
  `mf_leaflet_participants_map()`; uses `#participants_map` as container id.

## Checklist

1. Submodules `leaflet` (module + behaviour) initialised
2. Mapbox settings configured
3. Location map latitude and longitude configured
4. `leaflet-head` in page `head`
5. `<div id="map"></div>` in the template
6. `leaflet-js` and `leaflet/location-map.js` before the end of the page
7. CSS gives `#map` a usable height

After changes to templates, settings, or JavaScript, reload the page; clear caches if
your setup uses cached HTML or behaviour files.
