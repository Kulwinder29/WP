<?php

// Wordpress Some Functions 

// Parameters
// Author Parameters
// Show posts associated with certain author.

// author (int) – use author id.
// author_name (string) – use ‘user_nicename‘ – NOT name.
// author__in (array) – use author id (available since version 3.7).
// author__not_in (array) – use author id (available since version 3.7).
// Show Posts for one Author

$query = new WP_Query(array('author' => 123));
$query = new WP_Query(array('author_name' => 'rami'));
$query = new WP_Query(array('author' => '2,6,17,38'));
$query = new WP_Query(array('author' => -12));
$query = new WP_Query(array('author__in' => array(2, 6)));
$query = new WP_Query(array('author__not_in' => array(2, 6)));

// Category Parameters
// Show posts associated with certain categories.

// cat (int) – use category id.
// category_name (string) – use category slug.
// category__and (array) – use category id.
// category__in (array) – use category id.
// category__not_in (array) – use category id.
// Display posts that have one category (and any children of that category), using category id:

$query = new WP_Query(array('cat' => 4));
$query = new WP_Query(array('category_name' => 'staff'));
$query = new WP_Query(array('category__in' => 4));
$query = new WP_Query(array('cat' => '2,6,17,38'));
$query = new WP_Query(array('category_name' => 'staff,news'));
$query = new WP_Query(array('category_name' => 'staff+news'));
$query = new WP_Query(array('cat' => '-12,-34,-56'));
$query = new WP_Query(array('category__and' => array(2, 6)));
$query = new WP_Query(array('category__in' => array(2, 6)));
$query = new WP_Query(array('category__not_in' => array(2, 6)));


// Tag Parameters
// Show posts associated with certain tags.

// tag (string) – use tag slug.
// tag_id (int) – use tag id.
// tag__and (array) – use tag ids.
// tag__in (array) – use tag ids.
// tag__not_in (array) – use tag ids.
// tag_slug__and (array) – use tag slugs.
// tag_slug__in (array) – use tag slugs.
// Display posts that have one tag, using tag slug:

$query = new WP_Query(array('tag' => 'cooking'));
$query = new WP_Query(array('tag_id' => 13));
$query = new WP_Query(array('tag' => 'bread,baking'));
$query = new WP_Query(array('tag' => 'bread+baking+recipe'));
$query = new WP_Query(array('tag__and' => array(37, 47)));
$query = new WP_Query(array('tag__in' => array(37, 47)));
$query = new WP_Query(array('tag__not_in' => array(37, 47)));


// Taxonomy Parameters
// Show posts associated with certain taxonomy.

// {tax} (string) – use taxonomy slug. (Deprecated since version 3.1 in favor of ‘tax_query‘).
// tax_query (array) – use taxonomy parameters (available since version 3.1).
// relation (string) – The logical relationship between each inner taxonomy array when there is more than one. Possible values are ‘AND’, ‘OR’. Do not use with a single inner taxonomy array.
// taxonomy (string) – Taxonomy.
// field (string) – Select taxonomy term by. Possible values are ‘term_id’, ‘name’, ‘slug’ or ‘term_taxonomy_id’. Default value is ‘term_id’.
// terms (int/string/array) – Taxonomy term(s).
// include_children (boolean) – Whether or not to include children for hierarchical taxonomies. Defaults to true.
// operator (string) – Operator to test. Possible values are ‘IN’, ‘NOT IN’, ‘AND’, ‘EXISTS’ and ‘NOT EXISTS’. Default value is ‘IN’.
// Important Note: tax_query takes an array of tax query arguments arrays (it takes an array of arrays).
// This construct allows you to query multiple taxonomies by using the relation parameter in the first (outer) array to describe the boolean relationship between the taxonomy arrays.

// Simple Taxonomy Query:

// Display posts tagged with bob, under people custom taxonomy:

$args = array(
    'post_type' => 'post',
    'tax_query' => array(
        array(
            'taxonomy' => 'people',
            'field' => 'slug',
            'terms' => 'bob',
        ),
    ),
);
$query = new WP_Query($args);

$args = array(
    'post_type' => 'post',
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'movie_genre',
            'field' => 'slug',
            'terms' => array('action', 'comedy'),
        ),
        array(
            'taxonomy' => 'actor',
            'field' => 'term_id',
            'terms' => array(103, 115, 206),
            'operator' => 'NOT IN',
        ),
    ),
);
$query = new WP_Query($args);

$args = array(
    'post_type' => 'post',
    'tax_query' => array(
        'relation' => 'OR',
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => array('quotes'),
        ),
        array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => array('post-format-quote'),
        ),
    ),
);
$query = new WP_Query($args);

$args = array(
    'post_type' => 'post',
    'tax_query' => array(
        'relation' => 'OR',
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => array('quotes'),
        ),
        array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => array('post-format-quote'),
            ),
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => array('wisdom'),
            ),
        ),
    ),
);
$query = new WP_Query($args);


// Search Parameters
// Show posts based on a keyword search.

// s (string) – Search keyword.
// Show Posts based on a keyword search

$query = new WP_Query(array('s' => 'keyword'));

