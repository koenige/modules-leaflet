<!--
# leaflet module
# Karte auf einer Seite einbinden
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

# Karte einbinden

Das Modul bindet interaktive Karten mit [Leaflet](https://leafletjs.com/) und
Mapbox-Kacheln ein. Oft steht die Karte im Seitenfuß und zeigt einen Marker für
Ihren Standort.

## Abhängigkeiten

Beide Git-Submodule einrichten:

* `_inc/modules/leaflet` — dieses Modul (Vorlagen, Einstellungen)
* `www/_behaviour/leaflet` — Leaflet-CSS und -JavaScript unter
  `/_behaviour/leaflet/`

Nach dem Klonen im Projektroot `git submodule update --init` ausführen (oder
mit `--recursive` klonen).

Optionale Plugins (Marker-Cluster, Vollbild) benötigen weitere Bibliotheken
unter `www/_behaviour/` und die passenden Einstellungen in
`configuration/settings.cfg` (`leaflet_markercluster`, `leaflet_fullscreen`).

## Mapbox-Einstellungen

Legen Sie in [Mapbox Studio](https://studio.mapbox.com/) ein Zugriffstoken und
einen Kartenstil an. Diese Einstellungen konfigurieren (Website oder Modul):

| Einstellung | Bedeutung |
|-------------|-----------|
| `mapbox_access_token` | Öffentliches Token (`pk.…`) |
| `mapbox_user` | Mapbox-Benutzername |
| `mapbox_style` | Stil-ID für `styles/v1/{user}/{style}` |

Die Vorlage `leaflet-tiles-mapbox` erzeugt daraus die Kachelebene.

## Seitenvorlage

Modulvorlagen und Ihr Theme-Skript in einer Seitenvorlage einbinden (z. B.
`page.template.txt` des Themes).

Im Dokument-`head`, nach `%%% page head %%%`, Leaflet-CSS laden:

	%%% template leaflet-head %%%

An der gewünschten Stelle im HTML einen Karten-Container setzen. Die `id`
muss zum ersten Argument von `L.map()` im Skript passen (üblicherweise
`map`):

	<div id="map"></div>

Vor `</body>` bzw. `</html>` Leaflet und Ihre Karten-Initialisierung laden:

	%%% template leaflet-js %%%
	%%% script yourtheme/map.js %%%

Die Zeile `script` verweist auf `/_behaviour/yourtheme/map.js` (Theme-Datei
`behaviour/map.js`, als zzbrick-Vorlage verarbeitet).

Beispiel (Karte im Fuß auf jeder Seite):

	<footer>
	…
	<div id="map"></div>
	</footer>
	</div>
	%%% template leaflet-js %%%
	%%% script theme/map.js %%%

## Theme-JavaScript

Im Theme `behaviour/map.js` anlegen. Zuerst die Mapbox-Kacheln, dann Karte,
Marker und Ansicht:

	%%% template leaflet-tiles-mapbox %%%

	var map = L.map('map', { zoomControl: false, scrollWheelZoom: false }).addLayer(tiles);
	new L.Control.Zoom({ position: 'topright' }).addTo(map);

	L.marker([60.1736859, 24.9353442], {title: "%%% setting project %%%"}).addTo(map)
		.bindPopup('%%% setting project %%%');

	map.setView([60.1736859, 24.9353442], 17);

Breiten- und Längengrad sowie Zoom anpassen. Für Pop-up-Texte können Sie
`%%% setting project %%%` oder andere Einstellungen nutzen.

## CSS: Höhe von `#map`

Leaflet misst das **Karten-Element** (`#map`), nicht einen umschließenden
Container. Dem Element braucht eine feste Höhe (oder `height: 100 %` mit einem
Elternelement, das selbst eine Höhe hat). Sonst bleibt die Karte leer oder es
erscheint nur die Hintergrundfarbe eines umgebenden Blocks.

Beispiel:

	footer #map {
		height: 700px;
		margin: 6.25rem auto 0;
	}

Breite, Raster und Abstände an Ihr Theme anpassen.

## Weitere Kartentypen

* **zzform-Tabelle auf der Karte** — Vorlage `leaflet-zzform-map` (GeoJSON,
  optional Marker-Cluster). Siehe `templates/leaflet-zzform-map.template.txt`.
* **Veranstaltungsteilnehmer** — Vorlage `leaflet-participants-map` und
  `mf_leaflet_participants_map()`; Container-`id` ist `participants_map`.

## Checkliste

1. Submodule `leaflet` (Modul + Behaviour) initialisiert
2. Mapbox-Einstellungen gesetzt
3. `leaflet-head` im Seiten-`head`
4. `<div id="map"></div>` (oder passende `id`) in der Vorlage
5. `leaflet-js` und Theme-`map.js` am Seitenende
6. CSS vergibt `#map` eine sinnvolle Höhe
7. Koordinaten und Zoom in `behaviour/map.js`

Nach Änderungen an Vorlagen oder JavaScript Seite neu laden; bei gecachtem
HTML oder Behaviour ggf. Cache leeren.
