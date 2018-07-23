<?php

$context = get_field('banner');
$context = $context[0];

if (empty($context)) return;

Timber::render('banner.twig', $context);
