<?php

$context = get_field('hero');



$context = $context[0];

$context = flatten_array($context);

$context['announcement'] = get_field('announcement')[0];

if (empty($context)) return;

Timber::render('hero-bg.twig', $context);
