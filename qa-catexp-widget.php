<?php

class qa_catexp_widget {

	var $urltoroot;

	function load_module($directory, $urltoroot)
	{
		$this->urltoroot = $urltoroot;
	}

	function allow_template($template)
	{
		if($template === 'questions'
		|| $template === 'unanswered'
		|| $template === 'activity'
		|| $template === 'unanswered'
		|| $template === 'hot'
		|| $template === 'qa'
			)
			return true;
		return false;
	}

	function allow_region($region)
	{
		return $region === 'main';

	}
	function gettopusers($catid)
	{
		$query = "select a.userid as userid,a.handle as handle,date_format(a.created, '%M %Y') as created, a.avatarblobid as avatarblobid, a.email as email, a.avatarwidth as width, a.avatarheight as height,a.flags as flags, b.points as points, b.netvotes as netvotes, b.aselects as aselects  from ^users a join ^catpoints b on a.userid=b.userid  and b.categoryid = # and b.points>0 order by b.points desc limit 10";
		$result = qa_db_query_sub($query, $catid);
		$users = qa_db_read_all_assoc($result);
		return $users;

	}

	function output_widget($region, $place, $themeobject, $template, $request, $qa_content)
	{
		if(qa_opt("qa_catexp_enable") )
		{
			if($template === 'qa')
			$categoryslugs = qa_request_parts( 0 );
			else
			$categoryslugs = qa_request_parts( 1 );
			$countslugs = count( $categoryslugs );
			if($countslugs < 1 || ($countslugs == 1 && $categoryslugs[0] ==''))
				return;
			$result = qa_db_query_sub("select categoryid, title from ^categories where tags like $",$categoryslugs[$countslugs-1]);
                	$cat = qa_db_read_one_assoc($result, true);
			if(!$cat) return;
				$topusers = $this->gettopusers($cat['categoryid']);

				$themeobject->output('
			 <div class="contain-wrapp gray-container padding-bot30">
                        <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                        <div class="section-heading">
                        <h3>'.qa_lang_html('catexp_lang/title').$cat['title'].' </h3>'.
                        '<i class="fa fa-user"></i>
                        </div>
                        </div>
                        </div>



			<div class="row catexperts">
                        <div class="col-md-12 owl-column-wrapp">
                        <div id="team" class="owl-carousel leftControls-right">');

			for($i = 0; $i < count($topusers); $i++){
				$themeobject->output('
					<div class="item">
					<div class="thumbnail team-wrapp">
					<div class="img-wrapper">
					<div class="img-caption capZoomIn">
					<div class="team-network">
					<p>'.qa_lang_html('catexp_lang/membersince').$topusers[$i]['created'].
					'<br>
                                '.qa_lang_html('catexp_lang/voteups').$topusers[$i]['netvotes']." ".qa_lang_html('catexp_lang/bestans').$topusers[$i]['aselects'].' </p>

					</div>
					</div>');
				$user = $topusers[$i];
				$themeobject->output(
					qa_get_user_avatar_html($user['flags'], $user['email'], $user['handle'], $user['avatarblobid'], 100,100, 100, true));
				$themeobject->output(
					'</div>
					<div class="caption">');
				$themeobject->output(
					qa_get_one_user_html($user['handle'], false).'
					<p class="uscore">'.$user['points'].' '.qa_lang_html('catexp_lang/points').'</p>
					</div>
					</div>
					</div>');
			}

				$themeobject->output(
'
				</div>
				</div>
				</div>
				</div>');




		}

	}
};


/*
   Omit PHP closing tag to help avoid accidental output
 */
