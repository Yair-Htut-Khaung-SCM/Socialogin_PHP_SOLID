<?php
// Responsible for extracting the provider from the URL

// Get the current URL including query parameters
$currentUrl = $_SERVER['REQUEST_URI'];

// Parse the URL to extract its components
$urlParts = parse_url($currentUrl);

// Extract the path component
$path = $urlParts['path'];

// Split the path into segments
$pathSegments = explode('/', $path);

// Find the index of "oauth"
$oauthIndex = array_search('oauth', $pathSegments);

// Extract the relevant segment
$selectedProvider = $pathSegments[$oauthIndex + 1];
$selectedProvider = strtoupper($selectedProvider);

