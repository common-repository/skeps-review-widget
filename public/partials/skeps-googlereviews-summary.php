<?php

/**
 * Provide a view for the reviews bagdge
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.skeps.nl/wordpress
 * @since      1.0.0
 *
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/public/partials
 */
?>

<div id="sgr-badge-<?= $id ?>">

    In totaal <?= $sgr['total']; ?> reviews. Met een gemiddelde beoordeling van <?= $sgr['average']; ?>

    <svg class="icon">
                <use xlink:href="#stars-<?= $score_formatted ?>-star">
    </svg>

</div>
