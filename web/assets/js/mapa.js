///**
// * Created by btt_9 on 15/05/2017.
// */
//$(document).ready(function () {
//    function codeAddress() {
//        map = new google.maps.Map(document.getElementById('map'), {
//            zoom: zoom,
//            center: {lat: -34.397, lng: 150.644}
//        });
//        var address = document.getElementById('address').value + ", España";
//        geocoder.geocode({
//            'address': address
//
//        }, function (results, status) {
//            if (status == google.maps.GeocoderStatus.OK) {
//                var x = results[0].geometry.location.lat().toFixed(3);
//                var y = results[0].geometry.location.lng().toFixed(3);
//                map.setCenter(results[0].geometry.location);
//                var marker = new google.maps.Marker({
//                    map: map,
//                    position: results[0].geometry.location
//                });
//                for (var j = 0; j < results[0].address_components.length; j++) {
//                    for (var k = 0; k < results[0].address_components[j].types.length; k++) {
//                        if (results[0].address_components[j].types[k] == "postal_code") {
//                            zipcode = results[0].address_components[j].short_name;
//                        }
//                    }
//                }
//                address = results[0].formatted_address;
//                var zip_code = address.substr(0, 5);
//                var directionLong = address.substr(6);
//                var directionSplit = directionLong.split(", ");
//
//                // console.log(directionSplit);
//                infowindow = new google.maps.InfoWindow({
//                    content: address
//                });
//                infowindow.open(map, marker);
//
//            }
//            // errors
//            else {
//                alert('Geocode no tuvo éxito por la siguiente razón: ' + status)
//            }
//        })
//    }
//    google.maps.event.addDomListener(window, 'load', inicio);
//    $("#map").show();
//});