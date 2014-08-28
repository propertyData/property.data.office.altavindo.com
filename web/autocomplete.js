var placeSearch, autocomplete;
 /*    
        kita bikin inisialisasinya dulu, dengan mendeklarasikan service Google Maps Autocomplete
        lalu ketika form autocomplete di isi, maka service ini akan berjalan,
        setelah itu maka script ini akan memanggil fungsi isiAlamat()
    */
    function initialize() {
      autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('autocomplete')),
          { types: ['geocode'] });
 
      google.maps.event.addListener(autocomplete, 'place_changed', function() {
        isiAlamat();
      });
    }
	
	   /*    
        nah, fungsi ini untuk mengisi field-field pada form
        dengan output hasil dari autocomplete tadi.
    */
    function isiAlamat() {
      var place = autocomplete.getPlace();
      for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
      }
 
      for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
          var val = place.address_components[i][componentForm[addressType]];
          document.getElementById(addressType).value = val;
        }
      }
    }
	
	   /*    
        fungsi ini berguna untuk geolocate, dimana nama jalan yang akan tampil di autocomplete
        tidak akan jauh dengan lokasi tempat kita berada.
        Fungsi ini berguna karena tanpa fungsi ini, autocomplete akan menampilkan alamat yang kurang akurat
        atau bahkan ngaco.
    */
    function geolocate() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var geolocation = new google.maps.LatLng(
              position.coords.latitude, position.coords.longitude);
          autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
              geolocation));
        });
      }
    }