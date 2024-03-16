<?php 

/**
 * leaflet module
 * participants on a map
 *
 * Part of »Zugzwang Project«
 * https://www.zugzwang.org/modules/leaflet
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2016-2019, 2022, 2024 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


/**
 * output a map with participants of an event (people or groups)
 * grouped by place coordinates
 *
 * @param array $map settings for map
 *		array contact_fields
 *		array area_fields
 *		string area
 *		array static_fields (optional)
 * @param array $data
 * @return string
 */
function mf_leaflet_participants_map($map, $data) {
	if (!$data) return '';
	foreach ($data as $line) {
		$coord = $line['latitude'].'/'.$line['longitude'];
		if (!empty($map['contact_fields'])) {
			$contact = [];
			foreach ($map['contact_fields'] as $field) {
				if (empty($line[$field])) continue;
				$contact[] = $line[$field];
			}
			$line['contact'] = implode(' ', $contact);
		}
		if (!empty($map['area_fields'])) {
			$path_values = [];
			foreach ($map['area_fields'] as $field) {
				if (empty($line[$field])) {
					if (empty($map['static_fields'][$field])) continue;
					$line[$field] = $map['static_fields'][$field];
				}
				$path_values[] = $line[$field];
			}
			$line['link'] = wrap_path($map['area'], $path_values);
		}
		if (empty($map['coordinates'][$coord])) {
			$map['coordinates'][$coord]['latitude'] = $line['latitude'];
			$map['coordinates'][$coord]['longitude'] = $line['longitude'];
		}
		$map['coordinates'][$coord]['contacts'][] = [
			'contact' => $line['contact'],
			'link' => $line['link']
		];
	}
	$map['zoom'] = $map['zoom'] ?? wrap_setting('leaflet_participants_map_zoom');
	$map['center_lat'] = $map['center_lat'] ?? wrap_setting('leaflet_participants_map_center_lat');
	$map['center_lon'] = $map['center_lon'] ?? wrap_setting('leaflet_participants_map_center_lon');
	$map['coordinates'] = array_values($map['coordinates']);
	return wrap_template('leaflet-participants-map', $map);
}
