<?php

namespace HeimrichHannot\ConfirmedEmail;

class FormConfirmedEmail extends \Widget
{
	protected $blnSubmitInput = true;
	protected $blnForAttribute = true;
	protected $strTemplate = 'form_confirmed_email';
	protected $strPrefix = 'widget widget-text widget-confirmed-email';

	public function __construct($arrAttributes=false)
	{
		parent::__construct($arrAttributes);
		$this->decodeEntities = true;
		$this->rgxp = $this->rgxp ?: 'email';
	}

	public function __set($strKey, $varValue)
	{
		switch ($strKey)
		{
			case 'maxlength':
				$this->arrAttributes[$strKey] = ($varValue > 0) ? $varValue : '';
				break;

			case 'mandatory':
				if (VERSION == 2.9 || VERSION == 2.10) {
					$this->arrConfiguration['mandatory'] = $varValue ? true : false;
				} else {
					if ($varValue)
					{
						$this->arrAttributes['required'] = 'required';
					}
					else
					{
						unset($this->arrAttributes['required']);
					}
					parent::__set($strKey, $varValue);
				}
				break;
			
			case 'placeholder':
				$this->arrAttributes['placeholder'] = $varValue;
				break;
				
			default:
				parent::__set($strKey, $varValue);
				break;
		}
	}

	/**
	 * Validate input and set value
	 * @param mixed
	 * @return string
	 */
	protected function validator($varInput)
	{
		$this->blnSubmitInput = false;
		
		if (!strlen($varInput) && (strlen($this->varValue) || !$this->mandatory))
		{
			return '';
		}
		
		if ($varInput != $this->getPost($this->strName . '_confirm'))
		{
			$this->addError($GLOBALS['TL_LANG']['ERR']['confirmedEmailMismatch']);
		}

		$varInput = $this->idnaEncodeEmail($varInput);
		$varInput = parent::validator($varInput);

		if (!$this->hasErrors())
		{
			$this->blnSubmitInput = true;
			return $varInput;
		}

		return '';
	}

	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		// Hide the Punycode format (see #2750)
		$this->varValue = $this->idnaDecode($this->varValue);
		
		return sprintf('<input type="email" name="%s" id="ctrl_%s" class="text%s" value="%s"%s />',
						$this->strName,
						$this->strId,
						(strlen($this->strClass) ? ' ' . $this->strClass : ''),
						specialchars($this->varValue),
						$this->getAttributes()) . $this->addSubmit();
	}

	/**
	 * Generate the label of the confirmation field and return it as string
	 * @param array
	 * @return string
	 */
	public function generateConfirmationLabel()
	{
		return sprintf('<label for="ctrl_%s_confirm" class="confirm%s">%s%s%s</label>',
						$this->strId,
						(strlen($this->strClass) ? ' ' . $this->strClass : ''),
						($this->required ? '<span class="invisible">'.$GLOBALS['TL_LANG']['MSC']['mandatory'].'</span> ' : ''),
						sprintf($GLOBALS['TL_LANG']['MSC']['confirmedEmailConfirmation'], $this->strLabel),
						($this->required ? '<span class="mandatory">*</span>' : ''));
	}

	/**
	 * Generate the widget and return it as string
	 * @param array
	 * @return string
	 */
	public function generateConfirmation()
	{
		// Hide the Punycode format (see #2750)
		$this->varValue = $this->idnaDecode($this->varValue);
		
		return sprintf('<input type="email" name="%s_confirm" id="ctrl_%s_confirm" class="text confirm%s" value="%s"%s />',
						$this->strName,
						$this->strId,
						(strlen($this->strClass) ? ' ' . $this->strClass : ''),
						specialchars($this->varValue),
						$this->getAttributes());
	}
}