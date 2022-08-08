<?php

namespace Modules\CatalogModule\Observers;

use App\Proxy\Proxy;
use Modules\CatalogModule\Entities\Branch;
use Modules\CatalogModule\Proxy\CatalogProxy;

class BranchObserver
{
    /**
     * Handle the Branch "created" event.
     *
     * @param  \Modules\CatalogModule\Entities\Branch  $branch
     * @return void
     */
    public function creating(Branch $branch)
    {

    }

    /**
     * Handle the Branch "created" event.
     *
     * @param  \Modules\CatalogModule\Entities\Branch  $branch
     * @return void
     */
    public function created(Branch $branch)
    {
        $this->addBranch($branch);
    }

    /**
     * Handle the Branch "updated" event.
     *
     * @param  \Modules\CatalogModule\Entities\Branch  $branch
     * @return void
     */
    public function updated(Branch $branch)
    {
        if ($branch->wasChanged('regions_ids')) {
            $this->removeBranch($branch);
            $this->addBranch($branch);
        }
    }

    /**
     * Handle the Branch "deleted" event.
     *
     * @param  \Modules\CatalogModule\Entities\Branch  $branch
     * @return void
     */
    public function deleted(Branch $branch)
    {
        $this->removeBranch($branch);
    }

    /**
     * Handle the Branch "restored" event.
     *
     * @param  \Modules\CatalogModule\Entities\Branch  $branch
     * @return void
     */
    public function restored(Branch $branch)
    {

    }

    /**
     * Handle the Branch "force deleted" event.
     *
     * @param  \Modules\CatalogModule\Entities\Branch  $branch
     * @return void
     */
    public function forceDeleted(Branch $branch)
    {

    }


    private function addBranch($branch)
    {
        $catalogProxy = new CatalogProxy('ADD_BRANCH_TO_REGIONS', ['branch_id' => $branch->id, 'regions_ids' => generateStringIdOfArrayValues($branch->regions_ids)]);
        $result = (new Proxy($catalogProxy))->result();

        if (!$result) {
            helperLog(__CLASS__, __FUNCTION__, "Can't add branch to regions");
        }
    }


    private function removeBranch($branch)
    {
        $catalogProxy = new CatalogProxy('REMOVE_BRANCH_FROM_REGIONS', ['branch_id' => $branch->id]);
        $result = (new Proxy($catalogProxy))->result();

        if (!$result) {
            helperLog(__CLASS__, __FUNCTION__, "Can't remove branch to regions");
        }
    }
}
