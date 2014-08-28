<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Google Maps KML</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<style>
  body {
	padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
  }
  #petaku img {
  	max-width: none;
	}

   #petaku label {
    width: auto; display:inline;
</style>
    <meta name="description" content="gabungan tutorial gmap api">
    <meta name="author" content="HK">
	
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<script type="text/javascript" src="assets/js/markerclusterer_packed.js"></script>
	<style type="text/css">
		body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
	</style>	
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	
	<!-- memanggil library geoxml3 untuk parsing data kml ke peta -->
	<script type="text/javascript" src="http://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js"></script>
	<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
	
<script type="text/javascript" src="web/autocomplete.js"></script>
<script type="text/javascript" src="web/map-marker.js"></script>
<script type="text/javascript" src="web/kml-map.js"></script>
	<script type="text/javascript">
	var peta;
var peta2;
var nama     = new Array();
var kategori = new Array();
var alamat   = new Array();
var x        = new Array();
var y        = new Array();
var i;
var url;
var gambar_tanda;
gambar_tanda = 'assets/img/marker.png';

	function peta_awal() {
    var purwakarta = new google.maps.LatLng(-6.538174427323609,107.44945527392576);

	  // ini buat ngilangin icon place bawaan google maps
    var myStyles =[
    {
        featureType: "poi",
        elementType: "labels",
        stylers: [
              { visibility: "off" }
        ]
    }
    ];

    var petaoption = {
        zoom: 10,
        center: purwakarta,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: myStyles 
        };

    peta = new google.maps.Map(document.getElementById("petaku"),petaoption);

		/** disini kita panggil function dari geoXML3 untuk memparsing file kml */
		var geoXml = new geoXML3.parser({map: peta});
		/** letak file kml */
		geoXml.parse('web/jawa_barat.kml');

		//event on click		
		google.maps.event.addListener(peta,'click',function(event){
			//kasihtanda(event.latLng);
			infowindow.setContent('<div><strong>' + place.name + '</strong><br>'+place.geometry.location.lat() + ',' + place.geometry.location.lng());
		});
		
    // panggil pungsi ini buat nampilin markernya di peta
    ambildatabase();
	//ambilpeta();
}
	function zoomPeta() {
			/** disini kita panggil function dari geoXML3 untuk memparsing file kml */
		var geoXml = new geoXML3.parser({map: peta});
		/** letak file kml */
		geoXml.parse('web/jawa_barat.kml');
    var purwakarta = new google.maps.LatLng(-6.538174427323609,107.44945527392576);

	  // ini buat ngilangin icon place bawaan google maps
    var myStyles =[
    {
        featureType: "poi",
        elementType: "labels",
        stylers: [
              { visibility: "off" }
        ]
    }
    ];

    var petaoption = {
        zoom: 10,
        center: purwakarta,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: myStyles 
        };

    peta = new google.maps.Map(document.getElementById("petaku"),petaoption);


		//event on click		
		google.maps.event.addListener(peta,'click',function(event){
			//kasihtanda(event.latLng);
			infowindow.setContent('<div><strong>' + place.name + '</strong><br>'+place.geometry.location.lat() + ',' + place.geometry.location.lng());
		});
		
    // panggil pungsi ini buat nampilin markernya di peta
    ambildatabase();
	//ambilpeta();
}

function ambildatabase(){
    // kita bikin dulu array marker dan content info
    //var markers = [];
   // var info = [];
    
    <?php
    // koneksi database
       $link   = mysql_connect('localhost','root','');
    mysql_select_db('googlemaps_multiicon', $link);

   $query = mysql_query("SELECT `a`.*,`b`.* FROM `lokasi` AS `a` LEFT JOIN `kategori` AS `b` ON `a`.`kategori` = `b`.`id`");
    $i = 0;
    $js = "";
	
       // kita lakuin looping datanya disini
    while ($value = mysql_fetch_assoc($query)) {

    $js .= 'nama['.$i.'] = "'.$value['nama'].'";
            kategori['.$i.']  = "'.$value['nama_kategori'].'";
            alamat['.$i.'] = "'.$value['alamat'].'";
            x['.$i.'] = "'.$value['latittude'].'";
            y['.$i.'] = "'.$value['longitude'].'";
            set_icon("'.$value['ikon'].'");
            
            // kita set dulu koordinat markernya
            var point = new google.maps.LatLng(parseFloat(x['.$i.']),parseFloat(y['.$i.']));

            // disini kita masukin konten yang akan ditampilkan di InfoWindow
            var contentString = "<table>"+
                                        "<tr>"+
                                            "<td><b>" + nama['.$i.'] + "</b></td>"+
                                        "</tr>"+
                                        "<tr>"+
                                            "<td>" + alamat['.$i.'] + "</td>"+
                                        "</tr>"+
                                    "</table>";

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            
            tanda = new google.maps.Marker({
                    position: point,
                    map: peta,
                    icon: gambar_tanda,
                    clickable: true
                });
                       
            // nah, disini kita buat marker dan infowindow-nya kedalam array
            markers.push(tanda);
            info.push(infowindow);

            // ini fungsi untuk menampilkan konten infowindow kalo markernya diklik
            google.maps.event.addListener(markers['.$i.'], "click", function() { info['.$i.'].open(peta,markers['.$i.']); 
			 isiAlamat();
			});
            ';    
        $i++;  
    }

    // kita tampilin deh output jsnya :D
    echo $js;
    ?>
    
    // nah untuk yang satu ini...kita push semua markernya kedalam array untuk dikelompokan
    var markerCluster = new MarkerClusterer(peta, markers);
    
}

// fungsi inilah yang akan menampilkan gambar ikon sesuai dengan kategori markernya sendiri
function set_icon(ikon){
    if (ikon == "") {
    } else {
        gambar_tanda = "assets/icon/"+ikon;
    }
}
	google.maps.event.addListener(peta,'click',function(event){
			//kasihtanda(event.latLng);
			 isiAlamat();
			infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + place.geometry.location.lat() + ',' + place.geometry.location.lng());
		});
		
</script>


	</head>
	
	<body onload="peta_awal()">
		<h2>Google Maps KML</h2>
		<div class="container">
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				</a>
			<a class="brand" href="#">Property Search</a>
			<div class="btn-group pull-right"></div>
			</div>
		</div>
	</div>
<form id="formpeta" class="form-inline">
<select name="kabkota" id="kab">
<option value="">- Pilih Kabupaten -</option>
<?php
require ('config.php');
$sql = mysql_query("SELECT * FROM `kabkota`");
while ($kab = mysql_fetch_array($sql)) {
	echo '<option value="'.$kab['idkabkota'].'">'.$kab['nama_kabkota'].'</option>';
}
?>
</select>
<input type="button" id="caripeta" class="btn" value="tampilkan" onclick="zoomPeta();">
</form>
<input type="text" id="autocomplete" style="width:500px">
    <br>
    <form>
    <table id="alamat">
        <tr>
            <td>Alamat :</td><td><input type="text" id="route" class="form"></td>
       
            <td>|| Kota :</td><td><input type="text" id="locality" class="form"></td>
       
            <td>|| Kode Pos :</td><td><input type="text" id="postal_code"></td>
        </tr>
        <tr>
            <td>Provinsi :</td><td><input type="text" id="administrative_area_level_1" class="form"></td>
       
            <td>|| Negara :</td><td><input type="text" id="country" class="form"></td>
        </tr>
    </table>
    </form>
<div id="petaku" style="height:500px"></div>
	
<hr>
	  <footer>
        <p>&copy; Trial Map 2014</p>
      </footer>
</div>
	</body>
</html>
