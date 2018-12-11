<?php


function uri_localed($uri)
{

	preg_match_all("/{([a-zA-z]+)}/", $uri, $matches);

	if(sizeof($matches) == 2 && sizeof($matches[0]) > 0 && sizeof($matches[1]) > 0)
	{

		$replace = [];

		for($i=0; $i < sizeof($matches[0]); $i++)
		{
			$replace[$matches[0][$i]] = __("routes.".$matches[1][$i]);
		}

		$uri = strtr($uri, $replace);
	}

	$locale = app()->getLocale();

	return ($locale != "es" ? $locale."/" : "").$uri;
}