<?php
// Interface
interface DisciplineStorage
{
  public function read($id);

  public function readAll();

  public function create(Discipline $discipline);

  public function delete($id);

  public function update($id, $obj);
}