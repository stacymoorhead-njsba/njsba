<?php

$context['cards'] = get_field('cards');

if (empty($context)) return;

Timber::render('cards.twig', $context);
