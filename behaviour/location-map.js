/**
 * leaflet module
 * JavaScript for map with a single location
 *
 * Part of »Zugzwang Project«
 * https://www.zugzwang.org/modules/leaflet
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2026 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


%%% template leaflet-tiles-mapbox %%%

var map = L.map('map', { zoomControl: false, scrollWheelZoom: false }).addLayer(tiles);
new L.Control.Zoom({ position: 'topright' }).addTo(map);

L.marker(
	[%%% setting leaflet_location_map_center_lat %%%, %%% setting leaflet_location_map_center_lon %%%],
	{title: "%%% setting leaflet_location_map_title %%%"}
).addTo(map)
	.bindPopup('%%% setting leaflet_location_map_popup %%%');

map.setView([%%% setting leaflet_location_map_center_lat %%%, %%% setting leaflet_location_map_center_lon %%%], %%% setting leaflet_location_map_zoom %%%);
