<?php

use Alura\Cursos\Infra\EntityManagerCreator;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

// replace with path to your own project bootstrap file
require_once __DIR__ . '/../vendor/autoload.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = (new EntityManagerCreator())
                ->getEntityManager();

//$entityManager = GetEntityManager();

ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);