<?php
/**
 * This function maps integer value to room class name
 * @author Liu    Tuo
 * @param  int $value integer value representation of room class
 * @return string        a string which is the name of room class
 */
	public static function getRoomClassName($value)
	{
		switch ($value) {
			case 1:		
				return 'Standard';
				break;
			case 2:
				return 'Superior';
				break;
			case 3:
				return 'Deluxe';
				break;
			case 4:
				return 'Executive';
				break;
			case 5:
				return 'Presidential';
				break;
			default:
				return null;
				break;
		}
	}

/**
 * This function maps integer value to bed size name
 * @author Liu    Tuo
 * @param  int $value integer value representation of bed size
 * @return string        a string which represents the bed size
 */
	public static function getBedSizeName($value)
	{
		switch ($value) {
			case 1:
				return 'Single';
				break;
			case 2:
				return 'Double';
				break;
			case 3:
				return 'Queen';
				break;
			case 4:
				return 'Olympic Queen';
				break;
			case 5:
				return 'King';
				break;
			case 6:
				return 'California King';
				break;
			default:
				return null;
				break;
		}
	}