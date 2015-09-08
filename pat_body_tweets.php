<?php
/*
 * @name:    pat_body_tweets
 * @author:  © Patrick LEFEVRE, all rights reserved. <patrick[dot]lefevre[at]gmail[dot]com>
 * @link:    http://pat-body-tweets.cara-tm.com
 * @type:    Public
 * @prefs:   no
 * @order:   5
 * @version: 0.3.5
 * @license: GPLv2
*/

/**
 * This plugin tags registry
 *
 */
if (class_exists('Textpattern_Tag_Registry')) {
	Txp::get('Textpattern_Tag_Registry')
		->register('pat_body_tweets')
		->register('pat_body_tweets_live');
}


/**
 * Generate additional markup into text
 *
 * @param  array    Tag attributes
 * @return string   HTML tags with an individual link
 */
function pat_body_tweets($atts)
{

	global $thisarticle;

	extract(lAtts(array(
		'tag'		=> 'p',
		'full'		=> true,
		'sign'		=> '+',
		'tooltip'	=> NULL,
		'class'		=> 'notes-marker',
		'content'	=> 'body',
	), $atts));

	$tag = strtolower($tag);
	$words = '';

	if ( preg_match('/^p|li|h[1-6]{1}?$/', $tag) ) {

		$body_array = explode( "</$tag>", ($content ? $thisarticle[$content] : $thisarticle['body']) );

		for ($i=0; $i <= count($body_array)-2; ++$i) {

			$anchor = permlink(array()).'#t'.$thisarticle['thisid'].$i;

			if($full == true) {
				$text = trim( strip_tags($body_array[$i]) );
				$text = preg_replace('/\s+/', ' ', $text);
				$words = urlencode( substr( html_entity_decode($text, ENT_NOQUOTES, 'UTF-8'), 0, 114 ) ).'...';
			}

			$out .= str_replace( "<$tag>", '<'.$tag.' class="notes" id="t'.$thisarticle['thisid'].$i.'">', $body_array[$i] ).tag( href($sign, 'https://twitter.com/share?url='.urlencode($anchor).'&amp;text='.$words, ' target="_blank"'.($tooltip ? ' title="'.$tooltip.'"' : '')), 'span', ' class="'.$class.'"' )."</$tag>";

		}

		return $out;

	} else {

		return trigger_error(gTxt('invalid_attribute_value', array('{tag}' => 'tag')), E_USER_WARNING);

	}
}


/**
 * Generate additional HTML tags and script into public template
 *
 * @param  array    Tag attributes
 * @return string   HTML tags and custom script
 */
function pat_body_tweets_live($atts)
{

	global $thisarticle;

	extract(lAtts(array(
		'id' 		=> 'wrapper',
		'account' 	=> '',
		'label' 	=> 'Tweet it!',
		'popup' 	=> false,
		'info' 		=> false,
		'position' 	=> false,
		'tooltip' 	=> ' You can Tweet this text on mouse selection ',
		'top' 		=> '0',
		'right' 	=> '0',
		'bottom' 	=> '0',
		'color' 	=> '#00aced',
		'style' 	=> '',
	), $atts));

	if ( $account && ($thisarticle['excerpt'] || $thisarticle['body']) ) {

		return '<div id="share"><button><b>'.$label.'</b></button><span></span></div><script>var acc="'._pat_validate_account($account).'",getNode=document.getElementById("'.$id.'");function _isIn(e,t){while(e){if(e===t){return true;}e=e.parentNode;}return false;}function _save(e){if(window.getSelection){var t=window.getSelection();if(t.getRangeAt&&t.rangeCount){for(var n=0;n<t.rangeCount;++n){if(!_isIn(t.getRangeAt(n).commonAncestorContainer,e)){return null;}}return t.getRangeAt(0);}}else if(document.selection&&document.selection.createRange){return _isIn(document.selection.createRange(),e);}return null;}function _trunc(e,t,n){var el=n.toString().length;e=e.toString();e=e.replace(/\u00AD/g,"");for(var r=0;r<e.length;++r)e[r].href="";return e.length>=t?e.substr(0,t-el)+"...":e;}function _restore(e){if(e){if(window.getSelection){var t=window.getSelection();t.removeAllRanges();t.addRange(e).toString();}else if(document.selection&&e.select){e.select();}}}var _tweet=null,_btn=document.getElementById("share"),_share=_btn.children[0];document.onmouseup=function(e){_tweet=_save(getNode);setTimeout(function(){var t=_tweet.toString().length===0;_btn.style.top=(t?-9999:e.pageY+15)+"px";_btn.style.left=(t?-9999:e.pageX-30)+"px";},10);};_btn.onclick=function(e){if(!_tweet)return;var top=(screen.height/2)-170,left=(screen.width/2)-150,t=window.location.protocol+"//"+window.location.host+window.location.pathname;setTimeout(function(){_tweet=_trunc(_tweet,108,acc);_btn.style.top="-9999px";_btn.style.left="-9999px";window.open("https://twitter.com/intent/tweet?text=via @"+acc+" "+encodeURIComponent(_tweet)+" "+t,'.($popup ? '"shareWindow","width=300,height=340,top="+top+",left="+left+""' : '"_blank"').').focus();},10);_restore(_tweet);return false;};var _target=document.getElementById("'.$id.'");_target.style.position="relative";'.($info ? '_target.insertAdjacentHTML(\''.($position ? 'afterbegin' : 'beforeend').'\',\' <span id="tweety" title="'.addslashes($tooltip).'" style="position:absolute;'.($position ? 'top:'.$top : 'bottom:'.$bottom).';right:'.$right.';display:block;width:32px;height:32px;cursor:help;background:'.$color.' url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAYCAMAAADat72NAAAAhFBMVEUAAAD///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8g2+bRAAAAK3RSTlMABfuefDkC9vLkUCUKB+3ZzLKnjW1DFtS4rWFZPx8b3qSBcUgsEb66lzEve9FvTQAAAOpJREFUKM910eduwyAUhuGPZTveK15xnN117v/+WqhbQ0SeX0gvoCMdAAEcy6Xg0RAzIFs6IJmcfsvJqFU8VimCllqr7jmtQiqSFExQ2Gy5p3+RGCdkNRGVx7/HIW14zcAu5iQ7pvOVW1ngx0xG3tzuHVo7Q2OCVsW7eLMyNzVWFSefnc6ZoJC8Bp2DiV6Q0I7Fi/wJI4689cTwS5W+fA3WPMdnz9wJVgfvYNseP56StQUtk+FTjfawBElbOTcOcN1Lf03T9LGoszO09fOXrIeTHXORYMPmZme/bBSDgz2UHPuI530lVZc57RujiET2+03WRQAAAABJRU5ErkJggg==) center center no-repeat;'.$style.'"></span>\')' : '').'</script>';

	} elseif (false == $account) {

		return trigger_error(gTxt('invalid_attribute_value', array('{tag}' => 'account')), E_USER_WARNING);

	}

}


/**
 * Validate Twitter account
 *
 * @param  $entry  $att
 * @return string  string  User account without '@' sign
 */
function _pat_validate_account($entry)
{

	if ( preg_match("/\@[a-z0-9_]+/i", $entry) )
		$out = str_replace('@', '', $entry);
	else
		$out = $entry;

	return $out ? $out : trigger_error(gTxt('invalid_attribute_value', array('{account}' => 'Twitter account')), E_USER_WARNING);

}
