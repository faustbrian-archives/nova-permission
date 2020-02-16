<?php

namespace KodeKeep\NovaPermission;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaPermissionTool extends Tool
{
    /** @var string */
    private $resourceRole = Resources\Role::class;

    /** @var string */
    private $resourcePermission = Resources\Permission::class;

    /**
     * Perform any tasks that need to happen when the tool is booted.
     */
    public function boot()
    {
        Nova::script('NovaPermission', __DIR__.'/../dist/js/tool.js');

        Nova::resources([$this->resourceRole, $this->resourcePermission]);
    }

    /**
     * Set the resource to use for the role model.
     *
     * @param string $value
     *
     * @return self
     */
    public function withRole(string $value): self
    {
        $this->resourceRole = $value;

        return $this;
    }

    /**
     * Set the resource to use for the permission model.
     *
     * @param string $value
     *
     * @return self
     */
    public function withPermission(string $value): self
    {
        $this->resourcePermission = $value;

        return $this;
    }

    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Permission';
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('nova-permission::navigation');
    }
}
