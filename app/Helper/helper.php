<?php
if (!function_exists('hasAnyPermissionOnResource')) {
    /**
     * Check if the user has any of the basic permissions (view, create, edit, delete) on a resource.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user
     * @param string $resource
     * @return bool
     */
    function hasAnyPermissionOnResource(string $resource): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($actions as $action) {
            if ($user->can("{$resource}.{$action}")) {
                return true;
            }
        }

        return false;
    }
}
