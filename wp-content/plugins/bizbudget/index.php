<?php
/*
Plugin Name: Biz Bugget
Plugin URI: https://biz-solution.co.kh
Description: The perfect all-in-one responsive slider solution for WordPress.
Version: 1.0
Requires PHP: 7.0
Requires at least: 4.9
Author: Bunthean
Author URI: https://biz-solution.co.kh  
License: GPLv3 or later
License URI: https://biz-solution.co.kh
 */

include('register_post_type.php');
include('acf_fields.php');
// Our custom post type function
function income_post_type()
{

    register_post_type(
        'income',
        // CPT Options
        array(
            'labels' => array(
                'name' => ('income'),
                'singular_name' => ('income')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'income'),
            'show_in_rest' => true,
            'menu_icon'     => 'dashicons-plus',
            'supports'      => array('title', 'editor', 'author', 'thumbnail'),

        )
    );
}
// Hooking up our function to theme setup
add_action('init', 'income_post_type');

function expense_post_type()
{

    register_post_type(
        'expense',
        // CPT Options
        array(
            'labels' => array(
                'name' => ('expense'),
                'singular_name' => ('expense')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'expense'),
            'show_in_rest' => true,
            'menu_icon'     => 'dashicons-minus',
            'supports'      => array('title', 'editor', 'author', 'thumbnail')

        )
    );
}
// Hooking up our function to theme setup
add_action('init', 'expense_post_type');

register_activation_hook(__FILE__, 'child_plugin_activate');
function child_plugin_activate()
{

    if (!is_plugin_active('advanced-custom-fields-pro/acf.php') and current_user_can('activate_plugins'));
}

/**
 * Register a custom menu page.
 */
function wpdocs_register_my_custom_menu_page()
{
    add_menu_page(
        __('Income Report', 'textdomain'),
        'Income Report',
        'manage_options',
        'custompage',
        'my_custom_menu_page',
        'dashicons-chart-pie',
        '',
        6
    );
}
add_action('admin_menu', 'wpdocs_register_my_custom_menu_page');

function my_custom_menu_page()
{
    $total_income = '';
    $total_expense = '';
    $data = array('post_type' => 'income');
    $the_query = new WP_Query($data);

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $total_income = $total_income + (int) get_field('amount');
        }
    } else {
        $total_income = 0;
    }


    $data = array('post_type' => 'expense');
    $the_query = new WP_Query($data);

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $total_expense = $total_expense + (int) get_field('amount');
        }
    } else {
        $total_expense = 0;
    }
    $pl = $total_income - $total_expense;
    wp_reset_postdata();
?>
    <div style="margin:50px;height:100px; background: #ff9900; box-shadow: 10px 10px 5px 0 rgba(0.0.0.0.75)">
        <h1 style="color: #fff; padding:20px">Income: <?= $total_income; ?></h1>
    </div>
    <div style="margin:50px;height:100px; background: #990000; box-shadow: 10px 10px 5px 0 rgba(0.0.0.0.75)">
        <h1 style="color: #fff; padding:20px">Expense: <?= $total_expense; ?></h1>
    </div>
    <div style="margin:50px;height:100px; background: #cc0099; box-shadow: 10px 10px 5px 0 rgba(0.0.0.0.75)">
        <h1 style="color: #fff; padding:20px">P&I Report: <?= $pl; ?></h1>
    </div>
<?php
}
