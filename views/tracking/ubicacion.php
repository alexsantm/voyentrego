<?php
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    
    
    
echo '<h3>Map with a Marker</h3>';

//    foreach($mensajeros as $d){   
//        $user_id=$d['user_id'];
//        $destino_longitud =$d['longitud'];
//        $destino_latitud=$d['latitud'];
//        $userLocationsdestinos[]=array('location'=>array('lat' => $destino_latitud, 'long' => $destino_longitud), 'htmlContent' => $user_id);
//   
//
////$coord = new LatLng(['lat' => 39.720089311812094, 'lng' => 2.91165944519042]);
// $coord = new LatLng(['lat' => $destino_latitud, 'lng' => $destino_longitud]);
//$map[] = new Map([
//    'center' => $coord,
//    'zoom' => 14,
//]);
// 
//// Lets add a marker now
//$marker = new Marker([
//    'position' => $coord,
//    'title' => 'My Home Town',
//]);
// 
//// Provide a shared InfoWindow to the marker
//$marker->attachInfoWindow(
//    new InfoWindow([
//        'content' => '<p>This is my home town</p>'
//    ])
//);
//$map->addOverlay($marker);
//
// }
// // Display the map -finally :)
//echo $map->display();
 
 




//$coord = new LatLng(['lat' => $latitud_origen, 'lng' => $longitud_origen]);
$coord = new LatLng(['lat' => -1.831239, 'lng' => -78.18340599999999]);
$map = new Map([
    'center' => $coord,
    'zoom' => 10,
    'width' => '100%'
]);

foreach ($mensajeros as $f) {
    $coord = new LatLng(['lat' => $f['latitud'], 'lng' => $f['longitud']]);
    $marker = new Marker([
                'position' => $coord,
                'title' => $f['user_id'],
                'animation' => 'google.maps.Animation.DROP',
                'visible'=>'true'
            ]);
     $marker->attachInfoWindow(new InfoWindow(['content' => $f['user_id']]));
     $map->addOverlay($marker);
}    

echo $map->display();
 
 



