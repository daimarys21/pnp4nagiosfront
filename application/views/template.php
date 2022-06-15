<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <metacharset="UTF-8">
  <metahttp-equiv="X-UA-Compatible"content="IE=edge">
  <metaname="viewport"content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minimun-scale=1.0 ">



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="<?php echo $this->config->conf['refresh'] ?>" />
<title><?php if (isset($this->title)) echo html::specialchars($this->title) ?></title>
<?php echo html::stylesheet('media/css/common.css') ?>
<?php echo html::stylesheet('media/css/imgareaselect-default.css') ?>
<?php echo html::stylesheet('media/css/ui-'.$this->theme.'/jquery-ui.css') ?>
<?php echo html::link('media/images/favicon.ico','icon','image/ico') ?>
<?php echo html::script('media/js/jquery-min.js')?>
<?php echo html::script('media/js/jquery.imgareaselect.min.js')?>
<?php echo html::script('media/js/jquery-ui.min.js')?>
<?php echo html::script('media/js/jquery-ui-timepicker-addon.js')?>
<?php //echo html::script('media/js/jquery2.min.js')?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(window).load(
    function() {

    jQuery('div.graph').each(function(){
	var img_width = jQuery(this).next('img').width();
	var rrd_width = parseInt(jQuery(this).css('width'));
	var left = img_width - rrd_width - <?php echo $this->config->conf['right_zoom_offset'] ?>;
	jQuery(this).css('left', left);
	jQuery(this).css('cursor', 'e-resize');
	jQuery(this).attr('title', 'Click to zoom in');
    });

    jQuery('img.goto').css('visibility', 'visible');
    jQuery('div.graph').imgAreaSelect({ handles: false, autoHide: true,
        fadeSpeed: 500, onSelectEnd: redirect, minHeight: '<?php echo $this->config->conf['graph_height'] ?>' });

    function redirect(img, selection) {
    	if (!selection.width || !selection.height)
        	return;

	var graph_width = parseInt(jQuery(img).css('width'));
	var link   = jQuery(img).attr('id');
	var ostart = Math.abs(jQuery(img).attr('start'));
	var oend   = Math.abs(jQuery(img).attr('end'));
	var delta  = (oend - ostart);
	if( delta < 600 )
	    delta = 600;
	var sec_per_px = parseInt( delta / graph_width);
	var start = ostart + Math.ceil( selection.x1 * sec_per_px );  
	var end   = ostart + ( selection.x2 * sec_per_px );  
        window.location = link + '&start=' + start + '&end=' + end ; 

    }
	
	var sfilter = "<?php echo $this->session->get('sfilter') ?>";
	var spfilter = "<?php echo $this->session->get('spfilter') ?>";
	var pfilter = "<?php echo $this->session->get('pfilter') ?>";
	
	if(jQuery("#service-filter").length) {
		console.log("send keyup")
		jQuery("#service-filter").keyup()
	}
	if(jQuery("#special-filter").length) {
		jQuery("#special-filter").keyup()
	}
	if(jQuery("#page-filter").length) {
		jQuery("#page-filter").keyup()
	}
});
jQuery(document).ready(function(){
    var path = "<?php echo url::base(TRUE)."/"?>";
    jQuery("img").fadeIn(1500);
    jQuery("#basket_action_add a").live("click", function(){
        var item = (this.id)
        jQuery.ajax({
            type: "POST",
            url: path + "ajax/basket/add",
            data: { item: item },
            success: function(msg){
                jQuery("#basket_items").html(msg);
                window.location.reload() 
            }
        });
    });
    jQuery("#basket-clear").live("click", function(){
        jQuery.ajax({
            type: "POST",
            url: path + "ajax/basket/clear",
            success: function(msg){
                window.location.reload() 
            }
        });
    });
    jQuery("#basket-show").live("click", function(){
                window.location.href = path + 'page/basket' 
    });
    jQuery(".basket_action_remove a").live("click", function(){
        var item = (this.id)
        jQuery.ajax({
            type: "POST",
            url: path + "ajax/basket/remove/",
            data: { item: item },
            success: function(msg){
                jQuery("#basket_items").html(msg);
                window.location.reload() 
            }
        });
    });
    jQuery("#basket_items" ).sortable({
        update: function(event, ui) {
	    var items = jQuery(this).sortable('toArray').toString();
            jQuery.ajax({
                type: "POST",
                url: path + "ajax/basket/sort",
                data: { items: items },
                success: function(msg){
                    window.location.reload() 
                }
            });
        }
    });
    jQuery("#basket_items" ).disableSelection();
    jQuery("#remove_timerange_session").click(function(){
        jQuery.ajax({
            type: "GET",
            url: path + "ajax/remove/timerange",
            success: function(){
                location.reload();
            }
        });
    });

	jQuery("#service-filter").keyup(function () {
        var sfilter = jQuery("#service-filter").val();
		if(sfilter != "") {
			jQuery("#service-filter").css('background-color','#ff9999');
		}else{
			jQuery("#service-filter").css('background-color','white');
		}
		jQuery.ajax({
			type: "POST",
			url: path + "ajax/filter/set-sfilter",
			data: { sfilter: sfilter }
		});
        jQuery("#services span[id^='service']").each(function () {
            if (jQuery(this).attr('id').search(new RegExp("service-.*" + sfilter,"i")) == 0) {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            }
        });
    });

	jQuery("#special-filter").keyup(function () {
        var spfilter = jQuery("#special-filter").val();
		if(spfilter != "") {
			jQuery("#special-filter").css('background-color','#ff9999');
		}else{
			jQuery("#special-filter").css('background-color','white');
		}
		jQuery.ajax({
			type: "POST",
			url: path + "ajax/filter/set-spfilter",
			data: { spfilter: spfilter }
		});
        jQuery("#special-templates span[id^='special']").each(function () {
            if (jQuery(this).attr('id').search(new RegExp("special-.*" + spfilter,"i")) == 0) {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            };
        });
    });

	jQuery("#page-filter").keyup(function () {
        var pfilter = jQuery("#page-filter").val();
		if(pfilter != "") {
			jQuery("#page-filter").css('background-color','#ff9999');
		}else{
			jQuery("#page-filter").css('background-color','white');
		}
		jQuery.ajax({
			type: "POST",
			url: path + "ajax/filter/set-pfilter",
			data: { pfilter: pfilter }
		});
        jQuery("#pages span[id^='page']").each(function () {
            if (jQuery(this).attr('id').search(new RegExp("page-.*" + pfilter,"i")) == 0) {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            };
        });
    });
});


<?php if (!empty($zoom_header)) {
     echo $zoom_header;
} ?>
</script>
</head>
<body>

<!-- Preloader -->
<div class="preloader">
          <div id="preloader_1">
            <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
          </div>

        </div>
        <a class="preloader_text animated flash">Cargando...</a>

<!-- Contenido -->

<div id="contenido" style="display:none;">



<!-- Navbar-->
<div  style="position: absolute; top: -150px; left: 0px; width: 100%; z-index: 2;   animation-name: animated_nav; animation-duration: 1s; animation-timing-function: ease; animation-fill-mode: both;">
<section style="color: rgba(29, 29, 29, 0.5);">
            <nav class="circle">
              <ul>
                 <?php echo "<img id=\"logo2\" src=\"".url::base()."media/images/Logo_PDVSA.svg\" style=\"height: 40%; width: 50%; top: 5px; left: -15%; \">"; ?>
                
<?php $qsa  = pnp::addToUri(array('start' => $this->start,'end' => $this->end, 'view' => $this->view), False); ?>

		<?php echo "<li id=\"inicio\"><a title=\"Inicio\" href=\"".url::base(TRUE)."graph\">Inicio <img class=\"icon\" src=\"".url::base()."media/images/home.png\"></a></li>";?>
                <?php echo "<li id=\"colores\"><a title=\"Esquemas de Colores\" href=\"".url::base(TRUE)."color\">Esquema de Colores <img class=\"icon\" src=\"".url::base()."media/images/color.png\"></a></li>";?>
		<?php echo "<li id=\"calenadrio\"><a title=\"".Kohana::lang('common.title-calendar-link')."\" href=\"#\" id=\"button\">Establecer Fecha<img class=\"icon\" src=\"".url::base()."media/images/calendar.png\"></a></li>";?>
                <?php echo "<li id=\"estadisticas\"><a title=\"".Kohana::lang('common.title-statistics-link')."\" href=\"".url::base(TRUE)."graph?host=.pnp-internal&srv=runtime\">Estadisticas Internas <img class=\"icon\" src=\"".url::base()."media/images/stats.png\"></a></li>"; ?>
                <?php echo "<li id=\"documentacion\"><a title=\"".Kohana::lang('common.title-docs-link')."\" href=\"".url::base(TRUE)."docs\">Documentación <img class=\"icon\" src=\"".url::base()."media/images/docs.png\"></a></li>";?>
                <?php echo "<li id=\"de\"><a title=\"Documentacion (DE)\" href=\"/pnp4nagios/docs/view/de_DE/start\">Documentación (DE)<img class=\"icon\" src=\"".url::base()."media/images/de_DE.png\"></a></li>";?>
             	<?php echo "<li id=\"us\"><a title=\"Documentacion (US)\" href=\"/pnp4nagios/docs/view/en_US/start.html\">Documentación (US)<img class=\"icon\" src=\"".url::base()."media/images/en_US.png\"></a></li>";?>
		</ul>
            </nav>
</section>  
</div>



<style type="text/css">



/* TODO EL DOC*/


* {

margin: 0;
padding: 0;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;


}


/* NAVIGATION */
nav {
  height: 120px;
  background: #414956;
  padding: 0.5%;
  box-shadow: 0px 5px 0px #455261;
  opacity: 90%;
}


	
@keyframes animated_nav {
  0% {
    opacity: 0%;
  }
  25% {
    opacity: 25%;
  }

  50% {
    opacity: 50%;
  }

  75% {
    opacity: 75%;
  }

  100% {
    opacity: 100%;
    position: fixed;
    left: 0px;
    width: 100%;
    z-index: 2;
    top: 0px;
  }
}




nav ul {
  list-style: none;
  text-align: right;
}


#logo1 {
  float:left;
  margin-top: 10px;
  margin-left: -200px;
}

#logo2 {
  float:left;
  margin-top: 50px;
  margin-left: -10%;
}




nav ul li {
  display: inline-block;
  padding-bottom: 1%;
  margin-top: 20px;
  color: #ffffff;
}




nav ul li a {
  display: block;
  padding: 15px;
  text-decoration: none;
  color: #ffffff;
  font-weight: 800;
  text-transform: uppercase;
  margin: 0 10px;
}


nav ul li a,
nav ul li a:after,
nav ul li a:before {
  transition: all 0.5s;
}
nav ul li a:hover {
  color: #333333;
}


/* Circle */
nav.circle ul li a {
  position: relative;
  overflow: hidden;
  z-index: 1;
  color: #ffffff;
}

nav.circle ul li a:hover {
  color: #333333;
}

/* By Dominik Biedebach @domobch */
nav.circle ul li a:after {
  display: block;
  position: absolute;
  margin: 0;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  content: ".";
  color: transparent;
  width: 1px;
  height: 1px;
  border-radius: 50%;
  background: transparent;
}

nav.circle ul li a:hover:after {
  -webkit-animation: circle 1.5s ease-in forwards;
}

	
/* Keyframes */
@-webkit-keyframes fill {
  0% {
    width: 0%;
    height: 1px;
  }
  50% {
    width: 100%;
    height: 1px;
  }
  100% {
    width: 100%;
    height: 100%;
    background: #2ecc71;
  }
}

/* Keyframes */
@-webkit-keyframes circle {
  0% {
    width: 1px;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    margin: auto;
    height: 1px;
    z-index: -1;
    background: #c7ddff;
    border-radius: 100%;
  }
  100% {
    background: rgb(255, 255, 255);
    height: 5000%;
    width: 5000%;
    z-index: -1;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    border-radius: 0;
  }
}
	
	
	

	
/* PRELOADER */


@font-face {
  font-family: Raleway-Bold;
  src: url('/pnp4nagios/share/media/fonts/Raleway-Bold.ttf');
}

@font-face {
  font-family: Raleway-ExtraLight;
  src: url('/pnp4nagios/share/media/fonts/Raleway-ExtraLight.ttf');
}


@font-face {
  font-family: Raleway-Medium;
  src: url('/pnp4nagios/share/media/fonts/Raleway-Medium.ttf');
}

@font-face {
  font-family: Raleway-Regular;
  src: url('/pnp4nagios/share/media/fonts/Raleway-Regular.ttf');
}



.preloader_text {
  color: rgb(78, 78, 78);
  position: absolute;
  margin:auto;
  margin-top: 8%;
  margin-left: 45%;
  font-family: Raleway-ExtraLight;
  font-size: 40px;
}

	
.preloader_text:hover {
  color: rgb(78, 78, 78);
}


.preloader {
display: flex;
justify-content: center;
margin-top: 15%;
margin-right: 10%;
opacity: 50%;
}

#preloader_1{
  position:relative;
}
#preloader_1 span{
  display:block;
  bottom:0px;
  width: 27px;
  height: 15px;
  background:#203064;
  position:absolute;
  animation: preloader_1 1.5s  infinite ease-in-out;
}

#preloader_1 span:nth-child(2){
left:33px;
animation-delay: .2s;

}
#preloader_1 span:nth-child(3){
left:66px;
animation-delay: .4s;
}
#preloader_1 span:nth-child(4){
left:99px;
animation-delay: .6s;
}
#preloader_1 span:nth-child(5){
left:132px;
animation-delay: .8s;
}
@keyframes preloader_1 {
  0% {height:15px;transform:translateY(0px);background:#3c63ac;}
  25% {height:120px;transform:translateY(60px);background:#3accc5;}
  50% {height:15px;transform:translateY(0px);background:#3c63ac;}
  100% {height:15px;transform:translateY(0px);background:#3c63ac;}
}




.animated {
  -webkit-animation-duration: 12s;
  animation-duration: 6s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: ease;
  animation-iteration-count: infinite;
 }
 @-webkit-keyframes flash {
  0%, 50%, 100% {
  opacity: 1;
  }
 25%, 75% {
  opacity: 0;
  }
 }
 @keyframes flash {
  0%, 50%, 100% {
  opacity: 1;
  }
 25%, 75% {
  opacity: 0;
  }
 }
 .flash {
  -webkit-animation-name: flash;
  animation-name: flash;
 }



/* FOOTER */

 .footer_logo {
   width: 90px;
   height: 30px;
 }

 .ait {
   position: absolute;
   right: 5%;
   bottom: 5px;
 }

 .gob {
   position: absolute;
   left: 5%;
   bottom: -20px;
   height: 90px;
   width: 130px;
 }

 .footer_text {
   font-family: Raleway-Regular;
   font-size: 14px;
   position: absolute;
   right: 40%;
   bottom: -10px;
 }

 .footer_1 {
   width: 100%;
   height: 40px;
   background-color: #d1d1d1;
   position: fixed;
   bottom: -50px;
   animation-name: animated_footer;
   animation-duration: 1s;
   animation-timing-function: ease-in;
   animation-fill-mode: both;
 }


@keyframes animated_footer {
  0% {
    opacity: 0%;
  }
  25% {
    opacity: 25%;
  }

  50% {
    opacity: 50%;
  }

  75% {
    opacity: 75%;
  }
	
 100% {
    opacity: 100%;
    position: fixed;
    bottom: 0px;
  }
}








</style>



<!-- Fin Navbar -->


<div id="centrame">
<?php if (!empty($graph)) {
     echo $graph;
} ?>
<?php if (!empty($debug)) {
     echo $debug;
} ?>
<?php if (!empty($color)) {
     echo $color;
} ?>
<?php if (!empty($zoom)) {
     echo $zoom;
} ?>
<?php if (!empty($page)) {
     echo $page;
} ?>
<?php if (!empty($docs)) {
     echo $docs;
} ?>
</div>

	
	<!-- FOOTER -->

<div class="footer_1">
    <img class="footer_logo gob" src=" <?php echo url::base();?>/media/images/PNP42.png">   
    <h4 class="footer_text">© 2022 - PDVSA AIT FALCÓN - Derechos Reservados </h4>
    <img class="footer_logo ait" src=" <?php echo url::base(); ?>/media/images/somosAIT.png">
</div>


	
	

</div>







<!-- Preloader JS -->
<script type="text/javascript">
    window.addEventListener('load', () => {

        document.getElementById('contenido').style.display = 'block';
        document.getElementById('preloader_1').style.display = 'none';
	document.getElementById('preloader_text').style.display = 'none';   

    })
</script>



</body>
</html>
