<?php
class qa_html_theme_layer extends qa_html_theme_base {
	function body_suffix(){
		$version=1.12;
		qa_html_theme_base::body_suffix();
		$template = $this->template;
		if((qa_opt('qa_catexp_enable') == 1) && ($template === 'questions'
				|| $template === 'unanswered'
				|| $template === 'qa'
				|| $template === 'activity'
				|| $template === 'unanswered'
				|| $template === 'hot')
		  ){

			$this->output('
					<!-- owl carousel -->
					<script type="text/javascript" src="'.QA_HTML_THEME_LAYER_URLTOROOT.'js/owlcarousel/owl.carousel.min.js?v='.$version.'"></script>  
					<script type="text/javascript" src="'.QA_HTML_THEME_LAYER_URLTOROOT.'js/owlcarousel/setting.js?v='.$version.'"></script>
					<script type="text/javascript" src="'.QA_HTML_THEME_LAYER_URLTOROOT.'js/form/jcf.js?v='.$version.'"></script>
					<script type="text/javascript" src="'.QA_HTML_THEME_LAYER_URLTOROOT.'js/custom.js?v='.$version.'"></script>

					');
		}
	}

	function head_css(){
		$version=1.07;
		$template = $this->template;
		if((qa_opt('qa_catexp_enable')  == 1) &&  (($template === 'questions')
				|| ($template === 'unanswered')
				|| ($template === 'qa')
				|| ($template === 'activity')
				|| ($template === 'unanswered')
				|| ($template === 'hot'))
		  ){
			$this->output('
					<link href="'.QA_HTML_THEME_LAYER_URLTOROOT.'css/style.css?v='.$version.'" rel="stylesheet" type="text/css">
					<style type="text/css">
					.owl-theme .owl-controls .owl-page.active span,
					.owl-theme .owl-controls.clickable .owl-page:hover span,
					.owl-theme .owl-controls.clickable .owl-buttons div:hover,
					.img-caption{
					background-color: rgba(62, 64, 230, 0.9);
					}'.qa_opt('qa_catexp_css').'
					</style>
					');
		}
		qa_html_theme_base::head_css();
		
	}

}

