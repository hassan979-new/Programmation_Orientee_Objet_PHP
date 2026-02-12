<?php
declare(strict_types=1);

spl_autoload_register(function (string $class):void {
    $prefix = "App\\";
    $baseDir = __DIR__ . "/../src/";
    if (strncmp($prefix,$class,strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace("\\","/",$relativeClass) . ".php";

    if (file_exists($file)) {
        require $file;
    }
});

use App\Entity\Filiere;
use App\Entity\Etudiant;
use App\Repository\FakeEtudiantRepository;

// // $f = new Filiere(null, "Informatique");
// // echo $f->getLibelle();

// $f = new Filiere(1, "Mathématiques");
// $e = new Etudiant(null, "Ali", "ali@test.com", $f);

// // echo $e->getNom() . " - " . $e->getFiliere()->getLibelle();

// try {
//     $bad = new Etudiant(null, "", "gghhlol", $f);
// } catch (\InvalidArgumentException $e) {
//     echo "Erreur detectee : " . $e->getMessage();
// }

$repo = new FakeEtudiantRepository();
$f1 = new Filiere(1, "Informatique");

$e1 = new Etudiant(null, "Sara", "sara@test.com", $f1);
$e2 = new Etudiant(null, "Youssef", "youssef@test.com", $f1);

$repo->save($e1);
$repo->save($e2);

echo "Insertion:\n";
foreach ($repo->findAll() as $e){
    echo $e->getId() . " - " . $e->getNom() . " (" . $e->getFiliere()->getLibelle() . ")\n";
}

$e1->setNom("Sara Benali");
$repo->save($e1);

echo "Modification:\n";
echo $repo->findById($e1->getId())->getNom() . "\n";

$repo->delete($e2->getId());

echo "Suppression:\n";
foreach ($repo->findAll() as $e) {
    echo $e->getNom() . "\n";
}
?>