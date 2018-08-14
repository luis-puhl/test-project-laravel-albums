<?php

namespace App\Services;

use Validator as ValidatorFacade;
use Illuminate\Validation\ValidationException;

class BaseService
{
    public function validate(array $baseData, $validationRules = null, $validationMessages = null)
    {
        $validator = ValidatorFacade::make(
            $baseData,
            $validationRules ?? $this->validationRules,
            $validationMessages ?? $this->validationMessages
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

    public function create(array $baseData, $validationRules = null, $validationMessages = null)
    {
        $validData = $this->validate($baseData, $validationRules, $validationMessages);

        return ($this->model)::create($validData);
    }

    public function update(array $baseData, int $id, $validationRules = null, $validationMessages = null)
    {
        $validData = $this->validate($baseData, $validationRules, $validationMessages);

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
