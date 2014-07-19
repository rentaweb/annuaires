jQuery(function() {

    

    jQuery(document).ready(function(){
        var geocoder = new window.google.maps.Geocoder();
        jQuery('#wpgmza_ugm_addmarker').click(function(){
            form = document.forms['wpgmaps_ugm'];
            var isChecked = jQuery('#wpgmza_ugm_spm:checked').val()?true:false;
            if (!isChecked) { alert(vgm_human_error_string); return; }

            jQuery('#wpgmza_ugm_addmarker').hide();
            jQuery('#wpgmza_ugm_addmarker_loading').show();
            var wpgm_address = '0';
            if (document.getElementsByName('wpgmza_ugm_add_address').length > 0) { wpgm_address = jQuery('#wpgmza_ugm_add_address').val(); }



            geocoder.geocode( { 'address': wpgm_address}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    wpgm_gps = String(results[0].geometry.location);
                    var latlng1 = wpgm_gps.replace('(','');
                    var latlng2 = latlng1.replace(')','');
                    var latlngStr = latlng2.split(',',2);
                    var wpgm_lat = parseFloat(latlngStr[0]);
                    var wpgm_lng = parseFloat(latlngStr[1]);

                    jQuery("#wpgmza_ugm_lat").val(wpgm_lat);
                    jQuery("#wpgmza_ugm_lng").val(wpgm_lng);
                    form.submit();
                    return true;

                } else {
                    alert('The address you used could not be geocoded. Please use another address: ' + status);
                            jQuery('#wpgmza_ugm_addmarker').show();
                            jQuery('#wpgmza_ugm_addmarker_loading').hide();
                            return false;
                            }
                    });
            });

    });
});
