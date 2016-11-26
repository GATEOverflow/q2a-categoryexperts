<?php


function qa_db_points_update_ifuser($userid, $columns)
{

	qa_db_points_update_ifuser_base($userid, $columns);
		$calculations=qa_db_points_calculations();
	$catfilter = " group by userid_src.categoryid having userid_src.categoryid = b.categoryid";
	$catfilter = " and userid_src.categoryid = b.categoryid";
	//$options=qa_get_options(qa_db_points_option_names());
	$query = "replace into ^catpoints (categoryid, userid, points, netvotes, aselects)  select  b.categoryid,$, ".
$calculations['aselecteds']['multiple']."*(select  ".$calculations['aselecteds']['formula'].$catfilter.")+".
$calculations['avoteds']['multiple']."*(select  ".$calculations['avoteds']['formula'].$catfilter.")
as points,
(select  ".$calculations['avoteds']['formula'].$catfilter.") as netvotes,
(select  ".$calculations['aselecteds']['formula'].$catfilter.") as aselects
 from  qaee_categories b";

	qa_db_query_raw(str_replace('~', "='".qa_db_escape_string($userid)."'", qa_db_apply_sub($query, array($userid))));
								// build like this so that a #, $ or ^ character in the $userid (if external integration) isn't substituted

}

								
?>
