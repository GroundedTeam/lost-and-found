$(function() {
    var map = L.map('map');

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    map.locate({ setView : true, maxZoom : 12 });

    var drawnItems = new L.FeatureGroup();
    map.addControl(drawnItems);

    var latitude = $('#latitude').data('latitude');
    var longitude = $('#longitude').data('longitude');
    var area = $('#area').data('area');
    var areaType = $('#areaType').data('areaType');

    var options = {color: "#000000", weight: 2};

    var layer = null;
    var center = null;

    switch (areaType) {
        case 'polygon':
            area = JSON.parse(JSON.parse(area));

            var polygon = [];
            var summLat = 0, summLng = 0;

            for (var i = 0; i < area.length; i++) {
                polygon.push([area[i].latitude, area[i].longitude]);
                summLat += parseInt(area[i].latitude);
                summLng += parseInt(area[i].longitude);
            }

            layer = L.polygon(polygon, options)
            center = [summLat / area.length, summLng / area.length];
            map.setView(center, 6);
            break;
        case 'rectangle':
            area = JSON.parse(JSON.parse(area));
            console.log(area[0]);

            var bounds = [[area[0].latitude, area[0].longitude], [area[2].latitude, area[2].longitude]];

            layer = L.rectangle(bounds, options);
            center = [area[0].latitude, area[0].longitude];
            map.setView([area[0].latitude, area[0].longitude], 6);
            break;
        case 'circle':
            area = JSON.parse(JSON.parse(area));

            layer = L.circle([area[0].latlng.lat, area[0].latlng.lng], area[0].radius, options);
            center = [area[0].latlng.lat, area[0].latlng.lng];
            map.setView([area[0].latlng.lat, area[0].latlng.lng], 6);
            break;
        case 'marker':
            layer = L.marker([latitude, longitude]);
            center = [latitude, longitude];
            map.setView([latitude, longitude], 6);
            break;
    }

    var figureLayer = L.layerGroup().addLayer(layer).addTo(map);

    $("a.photo_group")
        .attr('rel', 'gallery')
        .fancybox({
            padding : 0,
            helpers : {
                overlay : {
                    css : {
                        'background' : 'rgba(58, 42, 45, 0.95)'
                    }
                }
            }
        });
});

$.ajaxSetup({
    statusCode: {
        400: function(data) {
            alert('Bad request!');
        }
    }
});

$('#item_details_save').on('click', function(e) {
    e.preventDefault();

    var $form = $('form[name=item_details]');
    var values = $form.serialize();
    $.post(
        // Url
        Routing.generate('item_user_get_facebook', {
            id : $('#itemId').data('item-id')
        }),

        // Data
        values,

        // Callback
        function(data) {
            $("#message").toggle();
            $('#item_details_save').hide();

            document.getElementById('facebook-profile').href = 'https://www.facebook.com/' + data;

            $("#facebook-profile").toggle();
        },

        // Data-type
        "json"
    );


});
