<?php

namespace App\Repositories\Contracts;

interface TrackingRepository
{
    public function getToken();
    public function getDataTracking($token);
    public function getById($id);
    public function getAll();
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
