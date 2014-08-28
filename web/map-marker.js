var markers = [];
    var info = [];
	
function ambilpeta(){
    url = "json.php";
    $.ajax({
        url: url,
        dataType: 'json',
        cache: false,
        success: function(msg) {
	    var markers = [];
            for(i=0;i<msg.warteg.cabang.length;i++){
				x[i] = msg.warteg.cabang[i].x;
				y[i] = msg.warteg.cabang[i].y;
                var point = new google.maps.LatLng(parseFloat(msg.warteg.cabang[i].x),parseFloat(msg.warteg.cabang[i].y));
                  tanda = new google.maps.Marker({
							position: point,
							map: peta,
							icon: gambar_tanda,
							clickable: true
				});
				markers.push(tanda);
			}
			var markerCluster = new MarkerClusterer(peta, markers);
        }
    });
}

// ketika button caripeta ditekan, maka script ini akan berjalan
$(document).ready(function() {
    $("#caripeta").click(function(){
        var kab 	= $("#kab").val();
	$.ajax({
        url: "json.php",
        data: "kab="+kab,
        dataType: 'json',
        cache: false,
        success: function(msg){
			var awal2 = new google.maps.LatLng(-7.090911,107.668887);
			var petaoption2 = {
				zoom: 8,
				center: awal2,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var peta2 = new google.maps.Map(document.getElementById("petaku"),petaoption2);
			google.maps.event.addListener(peta2,'click',function(event){
				kasihtanda(event.latLng);
			});
			
             var markers = [];
            for(i=0;i<msg.warteg.cabang.length;i++){
				x[i] = msg.warteg.cabang[i].x;
				y[i] = msg.warteg.cabang[i].y;
                var point2 = new google.maps.LatLng(parseFloat(msg.warteg.cabang[i].x),parseFloat(msg.warteg.cabang[i].y));
                  tanda = new google.maps.Marker({
							position: point2,
							map: peta2,
							icon: gambar_tanda,
							clickable: true
				});
				markers.push(tanda);
			}
			var markerCluster = new MarkerClusterer(peta2, markers);
        }
    });
    });
});