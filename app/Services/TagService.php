<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Facades\Validator;

class TagService
{

    /**
     * Create a new ag.
     *
     * @param  array  $data
     * @return boolean
     */
    public function createNewTag($data)
    {
        //check if value already exist in the data base
        $tagExist = $this->model()->where(["name" => $data["name"]])->exists();
        if (!$tagExist) {
            $createTag = $this->model()->create($data);
            if ($createTag) {
                return true;
            }
        }

        return false;
    }

    private function model()
    {
        return new Tag();
    }
}
