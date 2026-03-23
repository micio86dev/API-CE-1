<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role = $this->roles()->with('permissions')->first();

        $rolePermissions = $role
            ? $role->permissions->map(fn ($permission) => $permission->alias ?? $permission->name)
            : collect();

        $userPermissions = $this->getDirectPermissions()
            ->map(fn ($permission) => $permission->alias ?? $permission->name);

        $allPermissions = $rolePermissions
            ->merge($userPermissions)
            ->filter()
            ->unique()
            ->values();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role' => $role ? [
                'id' => $role->id,
                'name' => $role->name,
                'alias' => $role->alias,
            ] : null,
            'permissions' => $allPermissions,
        ];
    }
}
