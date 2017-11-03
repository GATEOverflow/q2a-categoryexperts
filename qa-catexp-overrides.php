<?php


function qa_db_points_update_ifuser($userid, $columns)
{

	qa_db_points_update_ifuser_base($userid, $columns);
	if(qa_opt('qa_catexp_enable') == 1)
	{
		$calculations=qa_db_points_calculations();
		//$catfilter = "";
//		$catfilter = "  and (userid_src.categoryid = b.categoryid)";// or userid_src.categoryid  in  (
		$catfilter = "  and (userid_src.catidpath1 =b.categoryid or userid_src.catidpath2 = b.categoryid or userid_src.categoryid = b.categoryid)";// b.categoryid)";// or userid_src.categoryid  in  (
		$query1 = "insert into ^catpoints (categoryid, userid, points)  (select  b.categoryid,#, ".
			$calculations['aselecteds']['multiple']."*(select  ".$calculations['aselecteds']['formula'].$catfilter.")+".
			$calculations['avoteds']['multiple']."*(select  ".$calculations['avoteds']['formula'].$catfilter.") 
			as points from  ^categories b) on duplicate key update ^catpoints.points=points";
		$query2 = "insert into ^catpoints (categoryid, userid, netvotes)  (select  b.categoryid,$, ".
			"(select  ".$calculations['avoteds']['formula'].$catfilter.") as netvotes
			from  ^categories b) on duplicate key update ^catpoints.netvotes=netvotes";
		$query3 = "insert into ^catpoints (categoryid, userid, aselects)  (select  b.categoryid,$, ".
			"(select  ".$calculations['aselecteds']['formula'].$catfilter.") as aselects
			from  ^categories b) on duplicate key update ^catpoints.aselects=aselects";

		qa_db_query_raw(str_replace('~', "='".qa_db_escape_string($userid)."'", qa_db_apply_sub($query1, array($userid))));
	//	qa_db_query_raw(str_replace('~', "='".qa_db_escape_string($userid)."'", qa_db_apply_sub($query2, array($userid))));
	//	qa_db_query_raw(str_replace('~', "='".qa_db_escape_string($userid)."'", qa_db_apply_sub($query3, array($userid))));
	}
}


?>
