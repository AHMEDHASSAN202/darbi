<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Modules\CatalogModule\Enums\EntityType;
use Modules\CatalogModule\Repositories\EntityRepository;

trait EntityHelperService
{
    public function getShareLink($entityId, $entityType)
    {
        $entity = app(EntityRepository::class)->findWithBasicData($entityId);

        $name = $this->getEntityName($entity);

        return url('/share/' . $entityType . '/' . $entity->_id . '-' . slugify($name));
    }


    private function getEntityName($entity)
    {
        if ($entity->type == EntityType::YACHT) {
            return translateAttribute($entity->name);
        }
        return translateAttribute(optional($entity->model)->name) . ' ' . translateAttribute(optional($entity->brand)->name);
    }
}
