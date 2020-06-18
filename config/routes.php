<?php

return array(

	'api/users' => 'site/apiUsers',
	'api/comps' => 'site/apiComps',

	'api/auth' => 'site/apiAuth',

	'api/postproc' => 'site/apiPostProccess',

	'login' => 'site/login',
	'logout' => 'site/logout',

	'user/([0-9]+)' => 'site/user/$1',

	'^/*$' => 'site/index',


);
