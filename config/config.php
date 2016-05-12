<?php

/**
 * Backend form fields
 */
$GLOBALS['BE_FFL']['confirmed_email'] = 'TextField';

/**
 * Frontend form fields
 */
$GLOBALS['TL_FFL']['confirmed_email'] = 'HeimrichHannot\ConfirmedEmail\FormConfirmedEmail';

/**
 * EFG
 */
$GLOBALS['EFG']['storable_fields'][] = 'confirmed_email';