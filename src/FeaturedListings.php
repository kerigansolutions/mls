<?php

namespace KeriganSolutions\MLS;

use KeriganSolutions\CPT\CustomPostType;

class FeaturedListings
{
    public function createPostType()
    {
        $listing = new CustomPostType(
            'Featured Listing',
            [
                'supports'           => ['title'],
                'menu_icon'          => 'dashicons-welcome-add-page',
                'has_archive'        => false,
                'menu_position'      => null,
                'public'             => false,
                'publicly_queryable' => false,
                'hierarchical'       => false,
                'show_ui'            => true,
                'show_in_nav_menus'  => true,
                '_builtin'           => false,
            ]
        );
    }

    public function createAdminColumns()
    {
        add_filter('manage_featured_listing_posts_columns', function () {
            $defaults = [
                'title' => 'MLS Number',
                'date'  => 'Date Posted'
            ];
            return $defaults;
        }, 0);

        add_filter('enter_title_here', function ($title) {
            $screen = get_current_screen();

            if ('featured_listing' == $screen->post_type) {
                $title = 'MLS Number';
            }

            return $title;
        });
    }

    public function getFeaturedListings($args = [])
    {
        $request = [
            'post_type'      => 'featured_listing',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'offset'         => 0,
            'post_status'    => 'publish',
        ];

        $request = get_posts(array_merge($request, $args));

        $featuredArray = [];
        foreach ($request as $item) {
            $mlsNumber = (isset($item->post_title) ? $item->post_title : null);
            array_push($featuredArray, $mlsNumber);
        }

        return $featuredArray;
    }
}
