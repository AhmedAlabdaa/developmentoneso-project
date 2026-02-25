<?php

	if (!function_exists('truncateWords')) {
	    function truncateWords($string, $limit = 100) {
	        $words = explode(' ', $string);

	        if (count($words) > $limit) {
	            return implode(' ', array_slice($words, 0, $limit)) . '...';
	        }

	        return $string;
	    }
	}
