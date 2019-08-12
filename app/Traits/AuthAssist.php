<?php

namespace App\Traits;

use App\Depot;
use App\Drug;
use App\DrugLot;
use App\Pharmacist;
use App\Pharmacy;
use App\Rid;
use App\Role;
use App\Support\AuthCollection;
use App\User;
use App\Company;
use App\UserGroup;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Trait ListableAuth
 *
 * @package App\Support\Traits
 */
trait AuthAssist
{
    protected $user;

    protected function preGateCheck()
    {
        if ($this->user->is_developer) {
            return 2;
        }
        if ($this->user->status != 'Approved') {
            return -1;
        }
        if ($this->user->type->name == 'Early Access Care') {
            return 1;
        }
        return 0;
    }

    /**
     * List all rids the authorized user can view
     *
     * @return Collection rids viewable by the authorized user
     */
    protected function listRidAccess($user = null)
    {
        $this->user = $user ?? Auth::user();
        switch ($this->preGateCheck()) {
            case 1;
            case 2;
                return Rid::all();
            case -1:
                return null;
        }
        $rids = collect([]);
        if ($this->user->type->name == 'Physician')
            $rids = $rids->merge($this->user->rids);
        foreach ($this->user->groups() as $group)
            $rids = $rids->merge($group->rids);
        return $rids->unique('id');
    }

    /**
     * List all open gates the current user has to a RID
     *
     * @param Rid $rid Which rid to get retrieve the gates from
     *
     * @return AuthCollection all open gates
     */
    protected function ridAuth(Rid $rid)
    {
        $this->user = Auth::user();
        $access = new AuthCollection();
        switch ($this->preGateCheck()) {
            case 2:
                $access->setAuthAll();
                return $access;
            case 1;
                foreach ($this->user->groups() as $group)
                    $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));
                return $access;
            case -1:
                $access->setAuthNone();
                return $access;
        }
        if ($this->user->id == $rid->physician->id)
            $access->pushAccess(json_decode(Role::where('name', 'Physician Admin')->first()->base_level));
        foreach ($rid->user_groups as $group)
            if ($member = $group->members->where('id', $this->user->id)->first())
                $access->pushAccess(json_decode($member->role->base_level));
        return $access;
    }

    protected function ridInitiate()
    {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2;
                return true;
            case -1:
                return $this->abortNow();
        }
        $access = new AuthCollection();
        foreach ($this->user->groups() as $group)
            $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));

        if ($access->gate('rid.index.create'))
            return true;
        else
            return $this->abortNow();
    }

    /**
     * List all drugs the authorized user can view
     *
     * @return Collection drugs viewable by the authorized user
     */
    protected function listDrugAccess($user = null)
    {
        $this->user = $user ?? Auth::user();
        switch ($this->preGateCheck()) {
            case 1;
            case 2;
                return Drug::all();
            case -1:
                return null;
        }
        $drugs = collect([]);
        foreach ($this->user->groups() as $group)
            $drugs = $drugs->merge($group->drugs);
        return $drugs->unique('id');
    }

    /**
     * List all open gates the current user has to a drug
     *
     * @param Drug $drug Which drug to get retrieve the gates from
     *
     * @return AuthCollection all open gates
     */
    protected function drugAuth(Drug $drug)
    {
        $access = new AuthCollection();
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2:
                $access->setAuthAll();
                return $access;
            case 1;
                foreach ($this->user->groups() as $group)
                    $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));
                return $access;
            case -1:
                $access->setAuthNone();
                return $access;
        }
        foreach ($drug->user_groups as $group)
            if ($member = $group->members->where('id', $this->user->id)->first())
                $access->pushAccess(json_decode($member->role->base_level));
        return $access;
    }

    protected function drugInitiate()
    {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2;
                return true;
            case -1:
                return $this->abortNow();
        }
        $access = new AuthCollection();
        foreach ($this->user->groups() as $group)
            $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));

        if ($access->gate('drug.index.create'))
            return true;
        else
            return $this->abortNow();
    }

    /**
     * List all users the authorized user can view
     *
     * @return Collection users viewable by the authorized user
     */
    protected function listUserAccess()
    {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 1;
            case 2;
                return User::all();
            case -1:
                return null;
        }
        $users = collect([]);
        foreach ($this->user->groups() as $group)
            $users = $users->merge($group->users());
        return $users->unique('id');
    }

    /**
     * List all open gates the current user has to a user
     *
     * @param User $targetUser Which target user to get retrieve the gates from
     *
     * @return AuthCollection all open gates
     */
    protected function userAuth(User $targetUser)
    {
        $access = new AuthCollection();
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2:
                $access->setAuthAll();
                return $access;
            case 1;
                foreach ($this->user->groups() as $group)
                    $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));
                return $access;
            case -1:
                $access->setAuthNone();
                return $access;
        }
        if ($this->user->id === $targetUser->id) {
            $access->setAuthAll();
            return $access;
        }
        foreach ($targetUser->groups() as $group)
            if ($member = $group->members->where('id', $this->user->id)->first())
                $access->pushAccess(json_decode($member->role->base_level));
        return $access;
    }

    protected function userInitiate()
    {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2;
                return true;
            case -1:
                return $this->abortNow();
        }
        $access = new AuthCollection();
        foreach ($this->user->groups() as $group)
            $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));

        if ($access->gate('user.index.create'))
            return true;
        else
            return $this->abortNow();
    }

    /**
     * List all groups the authorized user can view
     *
     * @return Collection groups viewable by the authorized user
     */
    protected function listGroupAccess()
    {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 1;
            case 2;
                return UserGroup::all();
            case -1:
                return null;
        }
        return $this->user->groups();
    }

    protected function groupAuth(UserGroup $group)
    {
        $access = new AuthCollection();
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2:
                $access->setAuthAll();
                return $access;
            case 1;
                foreach ($this->user->groups() as $group)
                    $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));
                return $access;
            case -1:
                $access->setAuthNone();
                return $access;
        }
        if ($member = $group->members->where('id', $this->user->id)->first())
            $access->pushAccess(json_decode($member->role->base_level));
        return $access;
    }

    protected function groupInitiate()
    {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2;
                return true;
            case -1:
                return $this->abortNow();
        }
        $access = new AuthCollection();
        foreach ($this->user->groups() as $group)
            $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));

        if ($access->gate('group.index.create'))
            return true;
        else
            return $this->abortNow();
    }

    /**
     * List all companies the authorized user can view
     *
     * @return Collection companies viewable by the authorized user
     */
    protected function listCompanyAccess()
    {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 1;
            case 2;
                return Company::all();
            case -1:
                return null;
        }
        return $this->user->company;
    }

    protected function companyAuth(Company $company)
    {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2;
                return true;
            case -1:
                return $this->abortNow();
        }
        $access = new AuthCollection();
        foreach ($this->user->groups() as $group)
            $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));

        if ($access->gate('company.index.view'))
            return true;
        else
            return $this->abortNow();
    }

    protected function pharmacyAuth(Pharmacy $pharmacy) {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2;
                return true;
            case -1:
                return $this->abortNow();
        }
        $access = new AuthCollection();
        foreach ($this->user->groups() as $group)
            $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));

        if ($access->gate('pharmacy.index.view'))
            return true;
        else
            return $this->abortNow();
    }

    protected function pharmacistAuth(Pharmacist $pharmacist) {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2;
                return true;
            case -1:
                return $this->abortNow();
        }
        $access = new AuthCollection();
        foreach ($this->user->groups() as $group)
            $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));

        if ($access->gate('pharmacist.index.edit'))
            return true;
        else
            return $this->abortNow();
    }

    protected function depotAuth(Depot $depot) {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2;
                return true;
            case -1:
                return $this->abortNow();
        }
        $access = new AuthCollection();
        foreach ($this->user->groups() as $group)
            $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));

        if ($access->gate('depot.index.edit'))
            return true;
        else
            return $this->abortNow();
    }

    protected function lotAuth(DrugLot $lot) {
        $this->user = Auth::user();
        switch ($this->preGateCheck()) {
            case 2;
                return true;
            case -1:
                return $this->abortNow();
        }
        $access = new AuthCollection();
        foreach ($this->user->groups() as $group)
            $access->pushAccess(json_decode($group->members->where('id', $this->user->id)->first()->role->base_level));

        if ($access->gate('lot.index.edit'))
            return true;
        else
            return $this->abortNow();
    }

    protected function abortNow()
    {
        return abort(403, 'Unauthorized action.');
    }
}
