<?php if( $this->isAuthorizedFor('host_search') ){ ?>
<!-- Search Box Start -->
<script type="text/javascript">
jQuery(function() {
    jQuery("#query").autocomplete({
        source: "<?php echo url::base('true')?>/index.php/ajax/search",
        select: function(event, ui) { window.location = "<?php echo url::base('true')?>" + "graph?host=" + ui.item.value  }
    });
});
</script>

<div class="ui-widget">
 <div class="p2 ui-widget-header ui-corner-top">
 <?php echo Kohana::lang('common.search-box-header') ?>
 </div>
 <div class="p4 ui-widget-content ui-corner-bottom logo_input">
   <input type="text" name="host" id="query" class="textbox" />
 </div>
</div>
<p>
    
 
<style type="text/css">

.logo_input{
  background-image: url(' <?php echo url::base();?>/media/images/zoom.png');
  background-repeat: no-repeat;
  background-position: 4px center;
  background-size: 20px;
  padding-left: 28px;
}

</style>
 
    
    
<!-- Search Box End -->
<?php } ?>
