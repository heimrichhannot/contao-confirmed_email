<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Forms
	'HeimrichHannot\ConfirmedEmail\FormConfirmedEmail' => 'system/modules/confirmed_email/forms/FormConfirmedEmail.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'form_confirmed_email' => 'system/modules/confirmed_email/templates',
));
