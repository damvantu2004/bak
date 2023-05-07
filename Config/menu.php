<?php
return $menus = [
    [
        'label' => 'Dashboard',
        'route' => './?module=admin&controller=dashboard',
        'icon' => 'fa-columns'
    ],
    [
        'label' => 'Category Manager',
        'route' => './?module=admin&controller=category',
        'icon' => 'fa-list',
        'items' => [
            [
                'label' => 'All category',
                'route' => './?module=admin&controller=category',
            ],
            [
                'label' => 'Add category',
                'route' => './?module=admin&controller=category&action=create',
            ]
        ]
    ],
    [
        'label' => 'Product Manager',
        'route' => './?module=admin&controller=product',
        'icon' => 'fa-bread-slice',
        'items' => [
            [
                'label' => 'All Product',
                'route' => './?module=admin&controller=product',
            ],
            [
                'label' => 'Add Product',
                'route' => './?module=admin&controller=product&action=create',
            ]
        ]
    ],
    [
        'label' => 'Coupon Manager',
        'route' => './?module=admin&controller=coupon',
        'icon' => 'fa-gift',
        'items' => [
            [
                'label' => 'All Coupon',
                'route' => './?module=admin&controller=coupon',
            ],
            [
                'label' => 'Add Coupon',
                'route' => './?module=admin&controller=coupon&action=create',
            ]
        ]
    ],
    [
        'label' => 'Review Manager',
        'route' => './?module=admin&controller=review',
        'icon' => 'fa-comment-alt',
        'items' => [
            [
                'label' => 'All review',
                'route' => './?module=admin&controller=review',
            ],
        ]
    ],
    [
        'label' => 'Contact Manager',
        'route' => './?module=admin&controller=contact',
        'icon' => 'fa-envelope-open-text',
        'items' => [
            [
                'label' => 'All contact',
                'route' => './?module=admin&controller=contact',
            ],
        ]
    ],
    [
        'label' => 'Banner Manager',
        'route' => './?module=admin&controller=banner',
        'icon' => 'fa-image',
        'items' => [
            [
                'label' => 'All banner',
                'route' => './?module=admin&controller=banner',
            ],
            [
                'label' => 'Add banner',
                'route' => './?module=admin&controller=banner&action=create',
            ]
        ]
    ],
    [
        'label' => 'Order Manager',
        'route' => './?module=admin&controller=order',
        'icon' => 'fa-receipt',
        'items' => [
            [
                'label' => 'All order',
                'route' => './?module=admin&controller=order',
            ],
            // [
            //     'label' => 'Statistic',
            //     'route' => './?module=admin&controller=category',
            // ]
        ]
    ],
    [
        'label' => 'Account Manager',
        'route' => './?module=admin&controller=account',
        'icon' => 'fa-user',
        'items' => [
            [
                'label' => 'All account',
                'route' => './?module=admin&controller=account',
            ],
            [
                'label' => 'Add account',
                'route' => './?module=admin&controller=account&action=create',
            ]
        ]
    ]
];
