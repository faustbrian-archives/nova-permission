<?php

namespace KodeKeep\NovaPermission\Fields;

use KodeKeep\NovaPermission\Drivers\Eloquent;
use KodeKeep\NovaPermission\Drivers\Name;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Permissions extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'FieldPermissions';

    /**
     * Create a new field.
     *
     * @param string      $name
     * @param string|null $attribute
     * @param mixed|null  $resolveCallback
     */
    public function __construct($name, $attribute = 'permissions', $resolveCallback = null)
    {
        parent::__construct($name, $attribute ?? 'permissions', $resolveCallback);

        $this->fromNameWithGroups();
    }

    /**
     * Display permissions in groups.
     *
     * @return self
     */
    public function fromSourceWithGroups(array $options): self
    {
        return $this->withMeta(['withGroups' => true] + compact('options'));
    }

    /**
     * Display permissions by their name.
     *
     * @return self
     */
    public function fromSourceWithoutGroups(array $options): self
    {
        return $this->withMeta(['withGroups' => false] + compact('options'));
    }

    /**
     * Display permissions in groups. Groups are based on their names.
     *
     * @return self
     */
    public function fromNameWithGroups(): self
    {
        return $this->fromSourceWithGroups(Name::group());
    }

    /**
     * Display permissions by their name.
     *
     * @return self
     */
    public function fromNameWithoutGroups(): self
    {
        return $this->fromSourceWithoutGroups(Name::get());
    }

    /**
     * Display permissions in groups. Groups are based on their "group" attribute.
     *
     * @return self
     */
    public function fromEloquentWithGroups(): self
    {
        return $this->fromSourceWithGroups(Eloquent::group());
    }

    /**
     * Display permissions by their name.
     *
     * @return self
     */
    public function fromEloquentWithoutGroups(): self
    {
        return $this->fromSourceWithoutGroups(Eloquent::get());
    }

    /**
     * Resolve the field's value.
     *
     * @param mixed       $resource
     * @param string|null $attribute
     */
    public function resolve($resource, $attribute = null)
    {
        $this->value = $resource->permissions->pluck('name')->toArray();
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param string                                  $requestAttribute
     * @param object                                  $model
     * @param string                                  $attribute
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            if (! \is_array($choices = $request[$requestAttribute])) {
                $permissions = collect(explode(',', $choices))->reject(function ($name) {
                    return empty($name);
                })->all();
            }

            $model->syncPermissions($permissions);
        }
    }
}
