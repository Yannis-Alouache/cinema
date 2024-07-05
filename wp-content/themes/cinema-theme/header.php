<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <nav class="bg-gray-800">
  <div class="mx-auto container">
    <div class="relative flex h-16 items-center justify-between">
      <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
        <div class="flex flex-shrink-0 items-center">
            <a href="/cinema">
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=red&shade=500" alt="Your Company">
            </a>
        </div>
      </div>
    </div>
  </div>
</nav>
