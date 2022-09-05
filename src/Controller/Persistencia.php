<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;

class Persistencia implements InterfaceControladorRequisicao
{
    use FlashMessageTrait;
    
    private $entityManager;
    
    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
    }
    
    public function processaRequisicao(): void
    {
        // Pegar dados do formulário
        $descricao = filter_input(
            INPUT_POST,
            'descricao',
            FILTER_SANITIZE_STRING
        );

        // Montar modelo Curso
        $curso = new Curso();
        $curso->setDescricao($descricao);

        $id = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if (!is_null($id) && $id !== false) {
            // atualizar
            //$curso->setId($id);
            $curso = $this->entityManager->find(Curso::class, $id);
            $curso->setDescricao($descricao);
            $this->defineMensagem('success', 'Curso atualizado com sucesso!');

        } else {
            // Inserir no banco
            $this->entityManager->persist($curso);
            $this->defineMensagem('success', 'Curso inserido com sucesso!');
        }

        $this->entityManager->flush();

        header('Location:/listar-cursos', true, 302);

    }
}