<?php

return array(

	'api/comps' => 'site/apiComps',

	'ajax/comps' => 'site/ajaxComps',

	'api/postproc' => 'site/apiPostProccess',

	'login' => 'site/login',
	'logout' => 'site/logout',

	'user/([0-9]+)' => 'site/user/$1',

	'^/*$' => 'site/index',


);
