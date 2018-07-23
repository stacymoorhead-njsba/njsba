<?php

$context['corporate_partners_grid'] = get_field('corporate_partners_grid');

if (empty($context)) return;

Timber::render('corporate_partners_grid.twig', $context);
