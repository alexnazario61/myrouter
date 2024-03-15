<?php
namespace Cnab\Format;

class Picture
{
	// Regular expression for validating the format string
	const REGEX_VALID_FORMAT = '/(?P<tipo1>X|9)\((?P<tamanho1>[0-9]+)\)(?P<tipo2>(V9)?)\(?(?P<tamanho2>([0-9]+)?)\)?/';

	/**
	 * Validates if the given format string is valid
	 *
	 * @param string $format The format string to validate
	 * @return bool True if the format string is valid, false otherwise
	 */
	public static function validarFormato($format)
	{
		if(\preg_match(self::REGEX_VALID_FORMAT, $format))
			return true;
		else
		
