<?php

namespace AporteWeb\Dashboard;



class Dashboard
{
    /**
     * Indicates if Dashboard routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

    /**
     * The roles that are available to assign to users.
     *
     * @var array
     */
    public static $roles = [];

    /**
     * The permissions that exist within the application.
     *
     * @var array
     */
    public static $permissions = [];

    /**
     * The default permissions that should be available to new entities.
     *
     * @var array
     */
    public static $defaultPermissions = [];

    /**
     * The user model that should be used by Dashboard.
     *
     * @var string
     */
    public static $userModel = 'App\\Models\\User';


    public static function ignoreRoutes()
    {
        static::$registersRoutes = false;

        return new static;
    }

}