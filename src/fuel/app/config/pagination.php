<?php
return array(
    'bootstrap3' => array(
        'wrapper'               => '<div class="pagination">{pagination}</div>',
        'pagination'            => '<ul>{first}{previous}{links}{next}{last}</ul>',
        'first'                 => '<li>{link}</li>',
        'first-inactive'        => '',
        'first-link'            => '<a href="{uri}">First</a>',
        'previous'              => '<li class="prev">{link}</li>',
        'previous-inactive'     => '<li class="prev disabled"><span>Previous</span></li>',
        'previous-link'         => '<a href="{uri}" rel="prev">Previous</a>',
        'regular'               => '<li>{link}</li>',
        'active'                => '<li class="active"><span>{page}</span></li>',
        'regular-link'          => '<a href="{uri}">{page}</a>',
        'next'                  => '<li class="next">{link}</li>',
        'next-inactive'         => '<li class="next disabled"><span>Next</span></li>',
        'next-link'             => '<a href="{uri}" rel="next">Next</a>',
        'last'                  => '<li>{link}</li>',
        'last-inactive'         => '',
        'last-link'             => '<a href="{uri}">Last</a>',
    ),
);
