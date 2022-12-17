<script src="libs/jquery/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="libs/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="libs/leaflet/1.9.3/leaflet.js"></script>
<script src="js/landing.js"></script>
<script src="libs/aos/js/aos.js"></script>
<script>
  AOS.init({
    disable: 'mobile',
    duration: 600,
    once: true
  });
</script>
<script type="text/javascript">
    //Leaflet map with Kenya Geo Coordinates
    const map = L.map("distribution_map").setView([-1.286389, 36.817223], 10);

    //Add tile layer
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {maxZoom: 19}).addTo(map);

    //Get markers and add them to map
    const markers = JSON.parse(document.querySelector("#partner_geo_coordinates").getAttribute("data-coordinates"));
    for(const marker of markers){
        L.marker(marker).addTo(map);
    }
</script>
<!--
<script src="js/sb-customizer.js"></script>
<sb-customizer project="sb-ui-kit-pro"></sb-customizer>
-->
