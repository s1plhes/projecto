<?php

	if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
		require_once(dirname(__FILE__) . '/SSI.php');
	elseif (!defined('SMF'))
		exit('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php.');

	$hooks = array(
		'integrate_bbc_codes' => 'FontAweaZome_add_code',
		'integrate_bbc_buttons' => 'FontAweaZome_add_button',
		'integrate_pre_include' => '$sourcedir/FontAweaZome.php'
	);

	foreach ($hooks as $hook => $function)
		remove_integration_function($hook, $function);

