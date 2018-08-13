<?php

namespace App\Services;

use Validator as ValidatorFacade;
use Illuminate\Validation\ValidationException;

class BaseService
{
    public function validate(array $baseData)
    {
        $validator = ValidatorFacade::make(
            $baseData,
            $this->validationRules,
            $this->validationMessages
        );
        return $validator->validate();
    }

    public function find($id)
    {
        return ($this->model)::findOrFail($id);
    }

    public function index()
    {
        return ($this->model)::all();
    }

    public function show($id)
    {
        return $this->find($id);
    }

    public function create(array $baseData)
    {
        $validData = $this->validate($baseData);

        return ($this->model)::create($validData);
    }

    public function update(array $baseData, int $id)
    {
        $validData = $this->validate($baseData);

        $entity = $this->find($id);

        $entity->fill($validData);
        $entity->saveOrFail();

        return $entity;
    }

    public function destroy($id)
    {
        $entity = $this->find($id);

        return $entity->delete();
    }
}
