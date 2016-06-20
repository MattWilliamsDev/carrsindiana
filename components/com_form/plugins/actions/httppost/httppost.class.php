<?php
/**
 * @version $Id: httppost.class.php 184 2010-01-03 20:44:13Z  $
 * @package Blue Flame Forms (bfForms)
 * @copyright Copyright (C) 2003,2004,2005,2006,2007,2008,2009 Blue Flame IT Ltd. All rights reserved.
 * @license GNU General Public License 
 * @link http://www.blueflameit.ltd.uk
 * @author Phil Taylor / Blue Flame IT Ltd.
 * 
 * This file is part of the package bfForms.
 * 
 * bfForms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * bfForms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this package.  If not, see http://www.gnu.org/licenses/ 
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/* 
    -
    HTTPPost ver 1.0.0
    Author: Daniel Kushner
    Email: daniel@websapp.com
    Release: 2 Nov 2001
    Copyright 2001
    www.websapp.com/classes
    -
        -

    Wilfried Wolf (wilfried.wolf@sandstein.de) modified two things on 04/18/02:
    1. dataArray can be any Array now, eg.
     $dataArray = array(
                   'firstInput' => '1',
                   'secondInput' => 
                     array(
                      'field1' => 'a',
                      'field2' => 'b'
                     )
                    );

    2. the post() method will now return the responseBody of the request,
    i.e. no hexadecimal numbers will show up when you try to output the response.
    the headers of the response as well as the body can now be accessed by new methods
    getResponseHeaders() and getResponseBody().
    if the post() method does not return anything, the error can be accessed by
    the new method getResponseError



    -
    Added basic authentication method by elias@hostrix.com on 12/12/01, 04:54:01PM.
    new usage: HTTPPost($url, $dataArray, array('username', 'password'))
    -

    -
    Posts an array of data to a given URL using rfc2616 - Hypertext Transfer Protocol -- HTTP/1.1
    The data array should be in the form of comma-separated key => value pairs.
    Both the data and URL can be passed in the constructor or added by using
    the functions setDataArray() and setURL.
    -
*/
if (!class_exists('HTTPPost')){
class HTTPPost {
	
	var $url;
	var $uri;
	
	var $dataArray = array ();
	
	var $responseBody = '';
	var $responseHeaders = '';
	
	var $errors = '';
	
	function HTTPPost($url = '', $dataArray = '', $authInfo = false) {
		$this->setURL ( $url );
		$this->setDataArray ( $dataArray );
		$this->authInfo = $authInfo;
	}
	
	function setUrl($url) {
		if ($url != '') {
			$url = preg_replace ( "~^http://~", "", $url );
			$this->url = substr ( $url, 0, strpos ( $url, "/" ) );
			$this->uri = strstr ( $url, "/" );
			return true;
		} else {
			return false;
		}
	}
	
	function setDataArray($dataArray) {
		if (is_array ( $dataArray )) {
			$this->dataArray = $dataArray;
			return true;
		} else {
			return false;
		}
	}
	
	// can be called as: setAuthInfo(array('user', 'pass')) or setAuthInfo('user', 'pass')
	function setAuthInfo($user, $pass = false) {
		if (is_array ( $user ))
			$this->authInfo = $user;
		else
			$this->authInfo = array ($user, $pass );
	}
	
	function getResponseHeaders() {
		return $this->responseHeaders;
	}
	
	function getResponseBody() {
		return $this->responseBody;
	}
	
	function getErrors() {
		return $this->errors;
	}
	
	function prepareRequestBody(&$array, $index = '') {
		foreach ( $array as $key => $val ) {
			if (is_array ( $val )) {
				if ($index) {
					$body [] = $this->prepareRequestBody ( $val, $index . '[' . $key . ']' );
				} else {
					$body [] = $this->prepareRequestBody ( $val, $key );
				}
			} else {
				if ($index) {
					$body [] = $index . '[' . $key . ']=' . urlencode ( $val );
				} else {
					$body [] = $key . '=' . urlencode ( $val );
				}
			}
		}
		return implode ( '&', $body );
	}
	
	function post() {
		
		$this->responseHeaders = '';
		$this->responseBody = '';
		
		$requestBody = $this->prepareRequestBody ( $this->dataArray );
		
		if ($this->authInfo)
			$auth = base64_encode ( "{$this->authInfo[0]}:{$this->authInfo[1]}" );
		
		$contentLength = strlen ( $requestBody );
		
		$request = "POST $this->uri HTTP/1.1\r\n" . "Host: $this->url\r\n" . "User-Agent: HTTPPost\r\n" . "Content-Type: application/x-www-form-urlencoded\r\n" . ($this->authInfo ? "Authorization: Basic $auth\r\n" : '') . "Content-Length: $contentLength\r\n\r\n" . "$requestBody\r\n";
		
		$socket = fsockopen ( $this->url, 80, $errno, $errstr );
		if (! $socket) {
			$this->error ['errno'] = $errno;
			$this->error ['errstr'] = $errstr;
			return $this->getResponseBody ();
		}
		
		fputs ( $socket, $request );
		
		$isHeader = true;
		$blockSize = 0;
		
		while ( ! feof ( $socket ) ) {
			
			if ($isHeader) {
				$line = fgets ( $socket, 1024 );
				$this->responseHeaders .= $line;
				if ('' == trim ( $line )) {
					$isHeader = false;
				}
			} else {
				if (! $blockSize) {
					$line = fgets ( $socket, 1024 );
					if ($blockSizeHex = trim ( $line )) {
						$blockSize = hexdec ( $blockSizeHex );
					}
				} else {
					$this->responseBody .= fread ( $socket, $blockSize );
					$blockSize = 0;
				}
			}
		}
		fclose ( $socket );
		return $this->getResponseBody ();
	
	}
}
}