<?php
class qa_catexp_admin {

	function option_default($option) {

		switch($option) {
			case 'qa_catexp_enable': 
				return 1;
			case 'qa_catexp_css': 
				return '.catexperts{font-size:12px}';
			default:
				return null;				
		}

	}
	function init_queries($tableslc) {
		$queries = array();
		$tablename=qa_db_add_table_prefix('catpoints');
		if(qa_opt('qa_catexp_enable') && !in_array($tablename, $tableslc)) {
			$queries[] = "create table if not exists $tablename
				(
				 `categoryid` int(11) NOT NULL,
				 `userid` int(11) NOT NULL,
				 `points` int(11) DEFAULT 0,
				 `netvotes` int(11) DEFAULT '0',
				 `aselects` int(11) DEFAULT '0',
				 PRIMARY KEY (`categoryid`,`userid`)
				)";

			require_once QA_INCLUDE_DIR.'app/options.php';
			require_once QA_INCLUDE_DIR.'db/points.php';
			$catfilter = " and (userid_src.categoryid = b.categoryid or userid_src.categoryid  in  (
select categoryid from ^categories where parentid = b.categoryid) OR
userid_src.categoryid  in  ( 
select categoryid from ^categories where parentid in (select categoryid from ^categories where parentid = b.categoryid)))";

			$options=qa_get_options(qa_db_points_option_names());
			$aselectq = "(SELECT COUNT(*) AS aselecteds FROM ^posts AS userid_src JOIN ^posts AS questions ON questions.selchildid=userid_src.postid WHERE userid_src.userid=a.userid AND userid_src.type='A' AND NOT (questions.userid<=>userid_src.userid)".$catfilter .")";
			$aselecteds = $options['points_multiple']*$options['points_a_selected']
				."*".$aselectq;

			$usertable=qa_db_add_table_prefix('userpoints');
			$cattable=qa_db_add_table_prefix('categories');
			$avotedq="(SELECT COALESCE(SUM(".
				"LEAST(".((int)$options['points_per_a_voted_up'])."*upvotes,".((int)$options['points_a_voted_max_gain']).")".
				"-".
				"LEAST(".((int)$options['points_per_a_voted_down'])."*downvotes,".((int)$options['points_a_voted_max_loss']).")".
				"), 0) AS avoteds FROM ^posts AS userid_src WHERE LEFT(type, 1)='A' AND userid = a.userid".$catfilter.")";
			$avoteds = $options['points_multiple'] . "*".$avotedq;
			$queries[] = "insert into $tablename(categoryid, userid, points, netvotes, aselects) select b.categoryid, a.userid, ".$aselecteds." + ".$avoteds." as points,".$avotedq." as netvotes, ".$aselectq." as aselects  from $cattable b,  $usertable a group by b.categoryid, a.userid";
		}        
		return $queries;
	}



	function allow_template($template)
	{
		return ($template!='admin');
	}       

	function admin_form(&$qa_content)
	{                       

		// Process form input

		$ok = null;

		if (qa_clicked('qa_catexp_save')) {
			qa_opt('qa_catexp_enable',(bool)qa_post_text('qa_catexp_enable'));
			qa_opt('qa_catexp_css',(bool)qa_post_text('qa_catexp_css'));
			$ok = qa_lang('admin/options_saved');
		}
		if (qa_clicked('qa_catexp_recalc')) {
		

			$catfilter = " and (userid_src.categoryid = b.categoryid or userid_src.categoryid  in  (
select categoryid from ^categories where parentid = b.categoryid)
OR userid_src.categoryid  in  ( 
select categoryid from ^categories where parentid in (select categoryid from ^categories where parentid = b.categoryid)))";

                        $options=qa_get_options(qa_db_points_option_names());
                        $aselectq = "(SELECT COUNT(*) AS aselecteds FROM ^posts AS userid_src JOIN ^posts AS questions ON questions.selchildid=userid_src.postid WHERE userid_src.userid=a.userid AND userid_src.type='A' AND NOT (questions.userid<=>userid_src.userid)".$catfilter .")";
                        $aselecteds = $options['points_multiple']*$options['points_a_selected']
                                ."*".$aselectq;

                        $avotedq="(SELECT COALESCE(SUM(".
                                "LEAST(".((int)$options['points_per_a_voted_up'])."*upvotes,".((int)$options['points_a_voted_max_gain']).")".
                                "-".
                                "LEAST(".((int)$options['points_per_a_voted_down'])."*downvotes,".((int)$options['points_a_voted_max_loss']).")".
                                "), 0) AS avoteds FROM ^posts AS userid_src WHERE LEFT(type, 1)='A' AND userid = a.userid".$catfilter.")";
                        $avoteds = $options['points_multiple'] . "*".$avotedq;
                        $query = "replace into ^catpoints(categoryid, userid, points, netvotes, aselects) select b.categoryid, a.userid, ".$aselecteds." + ".$avoteds." as points,".$avotedq." as netvotes, ".$aselectq." as aselects  from ^categories b,  ^userpoints a group by b.categoryid, a.userid";
			$result = qa_db_query_sub($query);


	if($result)
				$ok = qa_lang('admin/options_saved');
		}

		// Create the form for display

		$fields = array();
		$fields[] = array(
				'label' => 'Enable Category Experts',
				'tags' => 'name="qa_catexp_enable"',
				'value' => qa_opt('qa_catexp_enable'),
				'type' => 'checkbox',
				);
		$fields[] = array(
				'label' => 'Category Experts CSS',
				'tags' => 'name="qa_catexp_css"',
				'value' => qa_opt('qa_catexp_css'),
				'type' => 'textarea',
				);

		return array(           
				'ok' => ($ok && !isset($error)) ? $ok : null,

				'fields' => $fields,

				'buttons' => array(
					array(
						'label' => qa_lang_html('main/save_button'),
						'tags' => 'NAME="qa_catexp_save"',
					     ),
					array(
						'label' => qa_lang_html('catexp_lang/recalculate_button'),
						'tags' => 'NAME="qa_catexp_recalc" title="'.qa_lang_html('catexp_lang/recalculate_button_pop').'"',
					     ),
					),
			    );
	}
}

