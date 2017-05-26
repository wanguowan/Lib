<?php
/**
 * Created by PhpStorm.
 * User: wan
 * Date: 5/26/17
 * Time: 2:30 PM
 */
namespace Wan\Lib;

Class CBasicLib
{
	public static function isValidString( $sStr, $bTrim = false )
	{
		$bRtn = false;

		if ( is_string( $sStr ) || is_numeric( $sStr ) )
		{
			$sStr = strval( $sStr );
			$bRtn = strlen( $bTrim ? trim( $sStr ) : $sStr )  > 0;
		}

		return $bRtn;
	}

	public static function isValidArray( $arr )
	{
		return is_array( $arr ) && count( $arr ) > 0;
	}

	public static function isValidInt( $nInt )
	{
		return ( is_numeric( $nInt ) && intval( $nInt ) == $nInt );
	}

	public static function isValidDateTime( $sDateTime, $sFormat = 'Y-m-d H:i:s' )
	{
		$bRtn = false;

		if( self::isValidString( $sFormat ) )
		{
			if( self::isValidString( $sDateTime ) )
			{
				$bRtn = $sDateTime == date( $sFormat, strtotime( $sDateTime ) );
			}
		}

		return $bRtn;
	}

	public static function isSameString( $sStr1, $sStr2 )
	{
		return is_string( $sStr1 ) && is_string( $sStr2 ) && 0 === strcmp( $sStr1, $sStr2 );
	}

	public static function isCaseSameString( $sStr1, $sStr2 )
	{
		return is_string( $sStr1 ) && is_string( $sStr2 ) && 0 === strcasecmp( $sStr1, $sStr2 );
	}

	public static function isValidInnerIP( $sStr )
	{
		$bRtn = false;

		if ( self::isValidString( $sStr ) )
		{
			if ( self::isValidIP( $sStr, false ) )
			{
				$bResult = filter_var(
					$sStr,
					FILTER_VALIDATE_IP,
					FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE
				);

				if ( false === $bResult )
				{
					$bRtn = true;
				}
			}
		}

		return $bRtn;
	}

	public static function isValidIP( $sStr, $bMustBePublic = true, $bTrim = false )
	{
		//
		//	sStr		- the ip address / the variable being evaluated
		//	bMustBePublic	- true 	/ the ip address must be a valid public address
		//			  false	/ return true if an address is valid in its format.
		//				  return true for all type of internal addresses, e.g.: 127.0.0.1, 192.168.0.1
		//	RETURN		- ip address or empty if occurred errors
		//
		//
		//	<Documentation>
		//		https://en.wikipedia.org/wiki/X-Forwarded-For
		//		https://en.wikipedia.org/wiki/IPv6
		//		http://php.net/manual/en/function.filter-var.php
		//
		if ( ! self::isValidString( $sStr ) )
		{
			return false;
		}
		if ( ! is_bool( $bMustBePublic ) )
		{
			return false;
		}
		if ( false == $bMustBePublic && self::IsSameString( '127.0.0.1', $sStr ) )
		{
			return true;
		}
		if ( ! is_bool( $bTrim ) )
		{
			return false;
		}

		//	...
		$sStr	= ( $bTrim ? trim( $sStr ) : $sStr );

		//
		//	Documentation
		//	http://php.net/manual/en/filter.filters.flags.php
		//
		//	FILTER_FLAG_NO_PRIV_RANGE
		//		Fails validation for the following private IPv4 ranges: 10.0.0.0/8, 172.16.0.0/12 and 192.168.0.0/16.
		//		Fails validation for the IPv6 addresses starting with FD or FC.
		//
		//	FILTER_FLAG_NO_RES_RANGE
		//		Fails validation for the following reserved IPv4 ranges:
		//		0.0.0.0/8, 169.254.0.0/16, 192.0.2.0/24 and 224.0.0.0/4.
		//		This flag does not apply to IPv6 addresses.
		//
		return ( false !== filter_var
			(
				$sStr,
				FILTER_VALIDATE_IP,
				$bMustBePublic ? ( FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) : FILTER_DEFAULT
			) );
	}
}