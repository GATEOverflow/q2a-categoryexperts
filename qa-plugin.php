<?php
        
                        
    if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
                    header('Location: ../../');
                    exit;   
    }               

    qa_register_plugin_module('module', 'qa-catexp-admin.php', 'qa_catexp_admin', 'Category Experts');
    qa_register_plugin_module('widget', 'qa-catexp-widget.php', 'qa_catexp_widget', 'Category Experts Widget');
    qa_register_plugin_layer('qa-catexp-layer.php', 'Category Experts Layer');
    qa_register_plugin_overrides('qa-catexp-overrides.php', 'Category Experts Override');
	qa_register_plugin_phrases('qa-catexp-lang-*.php', 'catexp_lang');    
/*                              
    Omit PHP closing tag to help avoid accidental output
*/                              
                          

