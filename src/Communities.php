<?php
namespace KeriganSolutions\MLS;

use KeriganSolutions\CPT\CustomPostType;

class Communities
{
    /**
     * @return null
     */
    public function createPostType()
    {
        $communities = new CustomPostType(
            'Community',
            [
                'supports'           => ['title', 'editor', 'thumbnail', 'revisions'],
                'menu_icon'          => 'dashicons-location',
                'has_archive'        => true,
                'menu_position'      => null,
                'public'             => true,
                'publicly_queryable' => true,
                //'capability_type'    => array('community','communities'),
            ]
        );

        $communities->addMetaBox(
            'Community Info',
            [
                'Area Image'    => 'image',
                'Database Name' => 'text',
                'Latitude'      => 'text',
                'Longitude'     => 'text'
            ]
        );
    }

    /*
     * @return $communities
     */
    public function getCommunities()
    {
        $communitylist = get_posts([
            'posts_per_page' => -1,
            'offset'         => 0,
            'order'          => 'ASC',
            'orderby'        => 'menu_order',
            'post_type'      => 'community',
            'post_status'    => 'publish',
        ]);

        $communities = [];

        foreach ($communitylist as $community) {
            $communities[] = [
                'id'          => $community->ID,
                'title'       => $community->post_title,
                'name'        => get_post_meta($community->ID, 'community_info_database_name', true),
                'photo'       => get_post_meta($community->ID, 'community_info_area_image', true),
                'latitude'    => get_post_meta($community->ID, 'community_info_latitude', true),
                'longitude'   => get_post_meta($community->ID, 'community_info_longitude', true),
                'link'        => get_permalink($community->ID)
            ];
        }

        return $communities;
    }
}
