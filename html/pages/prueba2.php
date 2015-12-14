<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Slider to change fusiontable maps layers</title>
  <link
 href="https://code.google.com/apis/maps/documentation/javascript/examples/default.css"
 rel="stylesheet" type="text/css" />
  <script type="text/javascript"
 src="https://maps.google.com/maps/api/js?sensor=false"></script>
  <script
 src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="http://piotrkrosniak.github.io/simple-slider.js"></script>
  <link href="http://piotrkrosniak.github.io/simple-slider.css" rel="stylesheet"
 type="text/css" />
  <link href="http://piotrkrosniak.github.io/simple-slider-volume.css" rel="stylesheet"
 type="text/css" />

  <script type="text/javascript">
function initialize() {
	var myLatLng = new google.maps.LatLng(19.4460481, -99.1196811);
	map = new google.maps.Map(document.getElementById('map_canvas'), {
    center: myLatLng,
    zoom: 14,
	panControl: false,
  	zoomControl: true,
	zoomControlOptions: {
    position: google.maps.ControlPosition.LEFT_CENTER
    },
  	mapTypeControl: false,
      mapTypeId: 'roadmap'
    });
  ////// mi ubicacion

       var markeri=new google.maps.Marker({
         position:myLatLng,
         });
      
       markeri.setMap(map);
       var infowindoi = new google.maps.InfoWindow({
         content:"<span>hola</span>"
         });
       
        infowindoi.open(map,markeri);

       google.maps.event.addListener(markeri, 'click', function() {
         infowindoi.open(map,markeri);
       });

      /// map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
}
	// Replace the xxx with your Fusion Tables IDs. 
	//You can use FT Wizard http://fusion-tables-api-samples.googlecode.com/svn/trunk/FusionTablesLayerWizard/src/index.html
/*layer1 = new google.maps.FusionTablesLayer({
      query: {
        select: 'geometry',
        from: '1sARycbyEEl8obP2dq7o0ZLbCVqI7Ez-N4cjISCA5'   //1950
      },
        styleId: 2,
        templateId: 2,
      map: map, 
    });
	
layer2 = new google.maps.FusionTablesLayer({
      query: {
        select: 'geometry',
        from: '1Cfy8KVorYYcz6QOqIGAg_X4BpsQ7u5UK1ZVbdyo3'   //1960
       },
        styleId: 2,
        templateId: 2,
      map: map, 
    });

layer3 = new google.maps.FusionTablesLayer({
      query: {
        select: 'Geometry',
        from: '10_g5zMJY8aEzE5eNUe00RUPleaGijqrhcx651lQV'    //1970
       },
        styleId: 2,
        templateId: 2,
      map: map, 
    });

layer4 = new google.maps.FusionTablesLayer({
      query: {
        select: 'Geometry',
        from: '1lQSIMpLdl0HI2hq_vhPz0FTdbzoXEn3Yx9gqgWqY'     //1980
       },
        styleId: 2,
        templateId: 2,
      map: map, 
    });

layer5 = new google.maps.FusionTablesLayer({
      query: {
        select: 'Geometry',
        from: '11enrFB5xvIp_vPn-ZBBt3XFkPCqKiLsQv_IWD7y4'       //1990
       },
        styleId: 2,
        templateId: 2,
      map: map, 
    });
    
layer6 = new google.maps.FusionTablesLayer({
      query: {
        select: 'Geometry',
        from: '1yD-zUilJqgCMertIYiU6y3l-waiSrIouwl7A-mUK'       //2000
       },
        styleId: 2,
        templateId: 2,
      map: map, 
    });
    
layer7 = new google.maps.FusionTablesLayer({
      query: {
        select: 'Geometry',
        from: '1f2K7FpLQKdi52_j_VHWmMlDhOpSQh5ppejGhVil3'       //2010
       },
        styleId: 2,
        templateId: 2,
      map: map, 
    });
    
layer8 = new google.maps.FusionTablesLayer({
      query: {
        select: 'Geometry',
        from: '1VZ6A75d3w-gMhkVAvqvAle2xBGgQuGbk9ndy_XQa'       //2013
       },
        styleId: 2,
        templateId: 2,
      map: map, 
    });

layer9.setMap(map);
}
*/
	tableidselections = 0;
	/*
function changeLayer(tableidselections) {

	if (tableidselections == 1950){
		clearmap();
		layer1.setMap(map); }

	if (tableidselections == 1960){
		clearmap();
		layer2.setMap(map); }
		
	if (tableidselections == 1970){
		clearmap();
		layer3.setMap(map); }
		
	if (tableidselections == 1980){
		clearmap();
		layer4.setMap(map); }
		
	if (tableidselections == 1990){
		clearmap();
		layer5.setMap(map); }
	
  if (tableidselections == 2000){
		clearmap();
		layer6.setMap(map); }
		
  if (tableidselections == 2010){
		clearmap();
		layer7.setMap(map); }
		
  if (tableidselections == 2013){
		clearmap();
		layer8.setMap(map); }
		}

function clearmap() {
	layer1.setMap(null);
	layer2.setMap(null);
	layer3.setMap(null);
	layer4.setMap(null);
	layer5.setMap(null);
  layer6.setMap(null);
	layer7.setMap(null);
	layer8.setMap(null);


}
*/
</script>
  <link
 href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900%7CQuicksand:400,700%7CQuestrial"
 rel="stylesheet" />
  <link href="http://piotrkrosniak.github.io/default.css" rel="stylesheet"
 type="text/css" media="all" />
  <link href="http://piotrkrosniak.github.io/fonts.css" rel="stylesheet"
 type="text/css" media="all" />
<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
</head>
<body onload="initialize()">
<a href="https://github.com/piotrkrosniak"><img
 title="Fork me on GitHub"
 style="border: 0px solid ; position: absolute; top: 0pt; right: 0pt; width: 149px; height: 149px;"
 src="https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png"
 alt="Fork me on GitHub" /></a>
<div id="header-wrapper">
<div id="header" class="container">
<div id="logo">
<h1><a target="_blank"
 href="https://github.com/PiotrKrosniak/FusionTablesSlider">Under-five mortality rate 1950-2013</a></h1>
<hr style="border-top: 1px dotted;" /></div>
<div id="menu">
</div>
</div>
<div id="map_canvas" class="container"
 style="width: 1200px; height: 400px;"></div>
<div id="slider" class="container">
<h3>Drag the slider to change Year</h3>
<input data-slider="true" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14"
 data-slider-highlight="true" data-slider-snap="true" type="text" /></div>
<script>
$("[data-slider]")
.each(function () {
var input = $(this);
$("<span>")
.addClass("output")
.insertAfter($(this));
})
.bind("slider:ready slider:changed", function (event, data) {
$(this)
.nextAll(".output:first")
.html(data.value.toFixed(0));
tableidselections = data.value.toFixed(0);
//changeLayer(tableidselections);
});
</script>
</div>
</body>
</html>
