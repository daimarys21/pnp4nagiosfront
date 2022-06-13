<!-- Icon Box 2 Start -->

<?php 
if($this->is_authorized === FALSE){
    print "<li><h2>Your are not authorized to view this site</h2></li>";
    return; 
}    
?>
    <ul>
<?php
    $qsa  = pnp::addToUri(array('start' => $this->start,'end' => $this->end, 'view' => $this->view), False);

    if($this->config->conf['use_fpdf'] == 1 && ( $position == "graph" || $position == "special") ){
	echo "<li title=\"".Kohana::lang('common.title-pdf-link')."\" href=\"".url::base(TRUE)."pdf".$qsa."\"><img class=\"icon\" src=\"".url::base()."media/images/pdf.png\"></li>\n";
    }
    if($this->config->conf['use_fpdf'] == 1 && $position == "basket"){
	echo "<li title=\"".Kohana::lang('common.title-pdf-link')."\" href=\"".url::base(TRUE)."pdf/basket/".$qsa."\"><img class=\"icon\" src=\"".url::base()."media/images/pdf.png\"></li>\n";
    }
    if($this->config->conf['use_fpdf'] == 1 && $position == "page"){
	echo "<li title=\"".Kohana::lang('common.title-pdf-link')."\" href=\"".url::base(TRUE)."pdf/page/".$this->page.$qsa."\"><img class=\"icon\" src=\"".url::base()."media/images/pdf.png\"></li>\n";
    }
    if($this->config->conf['show_xml_icon'] == 1 && $position == "graph" && $xml_icon == TRUE){
	$qsa  = pnp::addToUri(array(), False);
	echo "<li title=\"".Kohana::lang('common.title-xml-link')."\" href=\"".url::base(TRUE)."xml".$qsa."\"><img class=\"icon\" src=\"".url::base()."media/images/xml.png\"></li>\n";
    }
    if($this->data->getFirstPage() && $this->isAuthorizedFor('pages') ){
	echo "<li title=\"".Kohana::lang('common.title-pages-link')."\" href=\"".url::base(TRUE)."page\"><img class=\"icon\" src=\"".url::base()."media/images/pages.png\"></li>\n";
    }

    echo "<li title=\"".Kohana::lang('common.title-statistics-link')."\" href=\"".url::base(TRUE)."graph?host=.pnp-internal&srv=runtime\"><img class=\"icon\" src=\"".url::base()."media/images/stats.png\"></li>\n";

    if($this->data->getFirstSpecialTemplate() ){
	echo "<li title=\"".Kohana::lang('common.title-special-templates-link')."\" href=\"".url::base(TRUE)."special\"><img class=\"icon\" src=\"".url::base()."media/images/special.png\"></li>\n";
    }

    echo "<li title=\"".Kohana::lang('common.title-docs-link')."\" href=\"".url::base(TRUE)."docs\"><img class=\"icon\" src=\"".url::base()."media/images/docs.png\"></li>\n";
?>
    </ul>

<!-- Icon Box 2End -->


