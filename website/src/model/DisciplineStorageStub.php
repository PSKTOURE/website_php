<?php
class DiscplineStorageStub implements DisciplineStorage
{
  private $disciplines;

  public function __construct()
  {
    $f3 = new Discipline("Formula3", "open_wheel_single_seater", "Prema, ART, Carlin, Trident", 30, "Victor_Martins", "");
    $f2 = new Discipline("Formula2", "open_wheel_single_seater", "Prema, ART, Dams, MP_Motorsport", 45, "Piastri", "f3");
    $f1 = new Discipline("Formula1", "open_wheel_single_seater", "Mercedes, RedBull, Ferrari, Mcalaren", 90, "Verstappen", "f2, f3");
    $wec = new Discipline("World_Endurance_Championship", "endurance_racing", "Toyota, Peugeot, Porsche, Corvette", 360, "N°7", "");
    $moto2 = new Discipline("Moto2", "motor_bike_racing", "American_racing, RedBull_ktm", 40, "Remy Gardner", "");
    $motoGp = new Discipline("MotoGp", "motor_bike_racing", "Honda, Yamaha, Ducatti", 45, "Quartararo", "moto2");
    $this->disciplines = array("f1" => $f1, "f2" => $f2, "f3" => $f3, "wec" => $wec, "moto2" => $moto2, "motoGp" => $motoGp);
  }

  public function getDisciplines()
  {
    return $this->disciplines;
  }

  public function read($id)
  {
    if (!array_key_exists($id, $this->getDisciplines())) {
      return null;
    }
    return $this->getDisciplines()[$id];
  }

  public function readAll()
  {
    return $this->disciplines;
  }

  public function create(Discipline $discipline)
  {
  }

  public function delete($id)
  {
  }

  public function update($id, $obj)
  {
  }
}
