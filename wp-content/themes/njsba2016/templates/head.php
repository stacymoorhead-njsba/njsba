<?php


ob_start();
wp_head();
$context['wphead'] = ob_get_contents();
ob_end_clean();

if (empty($context)) return;
Timber::render('head.twig', $context);
