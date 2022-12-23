<?php
/*
zStudios Networks
Project SMFMOD0002
name: FontAweaZome BBC Code
author: Siplhes Swallengh
*/

if (!defined('SMF'))
	die('Hacking attempt...');

	function FontAweaZome_add_code(&$codes)
	{
		$codes[] = array(
                'tag' => 'fa',
                'type' => 'unparsed_content',
                'content' =>'<span class="fa $1"></span>',
			);

		$codes[] = array(
                'tag' => 'fa',
                'type' => 'unparsed_content',
                'parameters' =>array(
                    'op' => array('optional' => true, 'value' => '$1', 'match' => '([^<>]{1,192}?)'),
                ),
                'content' =>'<span class="fa $1 {op}"></span>',
		);

				$codes[] = array(
                'tag' => 'fasi',
                'type' => 'unparsed_content',
                'parameters' =>array(
                    'a' => array('optional' => true, 'value' => '$1', 'match' => '([^<>]{1,192}?)'),
					'b' => array('optional' => true, 'value' => '$1', 'match' => '([^<>]{1,192}?)'),
					'c' => array('optional' => true, 'value' => '$1', 'match' => '([^<>]{1,192}?)'),
                ),
                'content' =>'<span class="fa-stack fa-lg"><i style="color:{b};" class="fa {a} fa-stack-2x"></i><i style="color:{c};" class="fa $1 fa-stack-1x"></i></span>',
		);
	}

	 /* Here's we add the button in the text editor with his respective icon  */
	function FontAweaZome_add_button(&$buttons)
	{
		global $txt;

		$buttons[count($buttons) - 1][] = array(
			'image' => 'fa',
			'code' => 'Font Aweasome',
			'before' => '[fa]',
			'after' => '[/fa]',
			'description' => $txt['fa']
		);
				$buttons[count($buttons) - 1][] = array(
			'image' => 'fa',
			'code' => 'Font Aweasome - Stack Icons',
			'before' => '[fasi]',
			'after' => '[/fasi]',
			'description' => $txt['fasi']
		);
	}
