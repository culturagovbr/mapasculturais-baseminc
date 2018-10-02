<?php
namespace MapasCulturais;

$app = App::i();
$em = $app->em;
$conn = $em->getConnection();

return [

    'FIX entities without create history entries' => function() {
        $app = \MapasCulturais\App::i();
        foreach (['Agent', 'Space', 'Event'] as $class){
            
            $entity_class = strpos($class, 'MapasCulturais\Entities\\') === 0 ? $class : 'MapasCulturais\Entities\\' . $class;
            $query = $app->em->createQuery("SELECT e FROM $entity_class e WHERE e.id NOT IN (SELECT r.objectId FROM MapasCulturais\Entities\EntityRevision r WHERE r.action = 'created' AND r.objectType = '$entity_class')");

            $entities = $query->getResult();
            
            foreach ($entities as $entity) {
            
                $user = $entity->owner->user;
                $app->user = $user;
                $app->auth->authenticatedUser = $user;
                $entity->controller->action = \MapasCulturais\Entities\EntityRevision::ACTION_CREATED;

                /*
                 * Versão de Criação
                 */
                $entity->_newCreatedRevision();
            
            }

        }
        
        $app->auth->logout();
        
    },
    'Atualiza tipologias de agente coletivo' => function() use ($conn) {
        echo "\nAtualizando tipologias de agentes coletivos ... \n";
        $conn->executeQuery("UPDATE agent_meta set value='Demais Agentes' where key='tipologia_nivel1' and value='Demais Agentes Culturais'");
        $conn->executeQuery("UPDATE agent_meta set value='Demais Agentes Culturais' where key='tipologia_nivel2' and value='Mestres de Cultura'");
    }
         
];

