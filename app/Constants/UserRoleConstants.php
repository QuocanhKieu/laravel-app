<?php

namespace App\Constants;

class UserRoleConstants
{
    const ROLES = [
        0 => [
            'name' => 'User',
            'routes' => [
                'user.dashboard',
                'user.profile',
                'user.orders',
                // Add other user routes here
            ],
        ],
        1 => [
            'name' => 'Administrator',
            'routes' => [
                'admin.dashboard',
                'admin.users.index',
                'admin.users.edit',
                'admin.settings',
                // Add other admin routes here
            ],
        ],
        2 => [
            'name' => 'Editor',
            'routes' => [
                'editor.dashboard',
                'editor.posts.index',
                'editor.posts.edit',
                // Add other editor routes here
            ],
        ],

    ];

    public static function getRoutesByRole($role)
    {
        return self::ROLES[$role]['routes'] ?? [];
    }
    public static function getRoleName($role)
    {
        return self::ROLES[$role]['name'] ?? 'Unknown';
    }
}
