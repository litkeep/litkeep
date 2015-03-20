<?php
namespace Vendor;

class Helper
{
	/**
	 * Upraví formát data
	 * @param String[$value] Původní čas
	 * @param String[$format] Formát data
	 * @access public
	 * @return String Formátované datum
	 */
	public function date( $value, $format )
	{
		$value = date_create( $value );
		return date_format( $value, $format );
	}

	/**
	 * Ořízne text
	 * @param String[$text] Text, který má být oříznut
	 * @param Integer[$number] Na kolik znaků
	 * @access public
	 * @return String Oříznutý text
	 */
	public function truncate( $text, $number )
	{
		return substr( $text, 0, $number);
	}

	/**
	 * Aritmetický průměr
	 * @param Array[] Hodnoty
	 * @return Průměr
	 */
	public function arithmeticMean( $values )
	{
		if( count( $values ) == 0 ) {
			return 0;
		} else {
			$sum = 0;
			foreach( $values as $value ) {
				$sum += $value["value"];
			}

			return $sum / count( $values );
		}
	}

	/**
	 * Validuje řetězec
	 * @param String[$value] Kontrolovaný řetězec
	 * @param String[$type] Typ validace EMAIL/IP/INT/BOOLEAN
	 * @access public
	 * @return Boolean
	 */
	public function validate( $value, $type )
	{
		switch( $type ) {
			case("email"):
				return filter_var( $value, FILTER_VALIDATE_EMAIL );
			case("ip"):
				return filter_var( $value, FILTER_VALIDATE_IP );
			case("int"):
				return filter_var( $value, FILTER_VALIDATE_INT );
			case("bool"):
				return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
			default:
				return False;
		}
	}
}