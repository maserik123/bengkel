var map = new ol.Map({
    target: 'map',
    layers: [
      new ol.layer.Tile({
        source: new ol.source.OSM()
      }),
    ],
    view: new ol.View({
      center: ol.proj.fromLonLat([101.438309, 0.510440]),
      zoom:14
    })
  });


  var fill = new ol.style.Fill({
    color: 'rgba(210, 122, 167,0.2)'
  });

  var stroke = new ol.style.Stroke({
    color: '#B40404',
    width: 2
  });

  var pointStyles = new ol.style.Style({
      image: new ol.style.Circle({
        fill: fill,
        stroke: stroke,
        radius: 5
      }),
      fill: fill,
      stroke: stroke
    });

var vectorSource = new ol.source.Vector({
  format: new ol.format.GeoJSON(),
});

var vectorPoints = new ol.layer.Vector({
    source: vectorSource,
    style: pointStyles
  });


  // var marker = new ol.Feature({
//   geometry: new ol.geom.Point([vectorSource])
// })

map.addLayer(vectorPoints);

$.ajax({
  type:"GET",
  url:"Pengunjung/datageojson",
  dataType:"json",
  success:function(data){
    var geojsonformat = new ol.format.GeoJSON()

    var features = geojsonformat.readFeatures(data);
    vectorSource.addFeatures(features);
  }
});


/*function initMap(){
    var map = new google.maps.Map(document.getElementById('show_map'),{
        center  : {
            lat : 0.510440,
            lng : 101.438309
        },
        zoom : 4
    });
}*/