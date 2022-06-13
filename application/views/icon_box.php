<!-- Icon Box Start -->

<div class="wid_header" id="iconbox">
<div class="p2 wid_header ui-corner-top">
<?php echo Kohana::lang('common.icon-box-header') ?>
</div>
<div class="p4 ui-widget-content ui-corner-bottom" >
<?php
$qsa  = pnp::addToUri(array('start' => $this->start,'end' => $this->end, 'view' => $this->view), False);

if($this->config->conf['use_fpdf'] == 1 && ( $position == "graph" || $position == "special") ){
	echo "<a title=\"".Kohana::lang('common.title-pdf-link')."\" href=\"".url::base(TRUE)."pdf".$qsa."\"><img class=\"icon\" src=\"".url::base()."media/images/pdf.png\"></a>\n";
}
if($this->config->conf['use_fpdf'] == 1 && $position == "basket"){
	echo "<a title=\"".Kohana::lang('common.title-pdf-link')."\" href=\"".url::base(TRUE)."pdf/basket/".$qsa."\"><img class=\"icon\" src=\"".url::base()."media/images/pdf.png\"></a>\n";
}
if($this->config->conf['use_fpdf'] == 1 && $position == "page"){
	echo "<a title=\"".Kohana::lang('common.title-pdf-link')."\" href=\"".url::base(TRUE)."pdf/page/".$this->page.$qsa."\"><img class=\"icon\" src=\"".url::base()."media/images/pdf.png\"></a>\n";
}
if($this->config->conf['show_xml_icon'] == 1 && $position == "graph" && $xml_icon == TRUE){
	$qsa  = pnp::addToUri(array(), False);
	echo "<a title=\"".Kohana::lang('common.title-xml-link')."\" href=\"".url::base(TRUE)."xml".$qsa."\"><img class=\"icon\" src=\"".url::base()."media/images/xml.png\"></a>\n";
}
if($this->data->getFirstPage() && $this->isAuthorizedFor('pages') ){
	echo "<a title=\"".Kohana::lang('common.title-pages-link')."\" href=\"".url::base(TRUE)."page\"><img class=\"icon\" src=\"".url::base()."media/images/pages.png\"></a>\n";
}



if($this->data->getFirstSpecialTemplate() ){
	echo "<a title=\"".Kohana::lang('common.title-special-templates-link')."\" href=\"".url::base(TRUE)."special\"><img class=\"icon\" src=\"".url::base()."media/images/special.png\"></a>\n";
}

?>
</div>
</div><p>
<!-- Icon Box End -->


