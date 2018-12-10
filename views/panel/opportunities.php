<?php
use \MapasCulturais\i;
$this->layout = 'panel';
$opportunitiesToEvaluate = $user->opportunitiesCanBeEvaluated;
?>
<div class="panel-list panel-main-content">
    <header class="panel-header clearfix">
        <h2><?php $this->dict('entities: My opportunities');?></h2>
    </header>
    <ul class="abas clearfix clear">
        <li class="active"><a href="#ativos"><?php i::_e("Ativos");?> (<?php echo count($user->enabledOpportunities); ?>)</a></li>
        <li><a href="#permitido"><?php i::_e("Concedidos");?> (<?php echo count($user->hasControlOpportunities); ?>)</a></li>
        <li><a href="#rascunhos"><?php i::_e("Rascunhos");?> (<?php echo count($user->draftOpportunities); ?>)</a></li>
        <li><a href="#lixeira"><?php i::_e("Lixeira");?> (<?php echo count($user->trashedOpportunities); ?>)</a></li>
        <li><a href="#arquivo"><?php i::_e("Arquivo");?> (<?php echo count($user->archivedOpportunities); ?>)</a></li>
        <li><a href="#avaliacoes"><?php i::_e("Avaliações");?> (<?php echo count($opportunitiesToEvaluate); ?>)</a></li>
    </ul>
    <div id="ativos">
        <?php foreach($user->enabledOpportunities as $entity): ?>
            <?php $this->part('panel-opportunity', array('entity' => $entity)); ?>
        <?php endforeach; ?>
        <?php if(!$user->enabledOpportunities): ?>
            <div class="alert info"><?php i::_e("Você não possui nenhuma ");?><?php $this->dict('entities: opportunity')?>.</div>
        <?php endif; ?>
    </div>
    <!-- #ativos-->
    <div id="rascunhos">
        <?php foreach($user->draftOpportunities as $entity): ?>
            <?php $this->part('panel-opportunity', array('entity' => $entity)); ?>
        <?php endforeach; ?>
        <?php if(!$user->draftOpportunities): ?>
            <div class="alert info">Você não possui nenhum rascunho de <?php $this->dict('entities: opportunity');?>.</div>
        <?php endif; ?>
    </div>
    <!-- #lixeira-->
    <div id="lixeira">
        <?php foreach($user->trashedOpportunities as $entity): ?>
            <?php $this->part('panel-opportunity', array('entity' => $entity)); ?>
        <?php endforeach; ?>
        <?php if(!$app->user->trashedOpportunities): ?>
            <div class="alert info">Você não possui nenhum <?php $this->dict('entities: opportunity')?> na lixeira.</div>
        <?php endif; ?>
    </div>
    <!-- #lixeira-->
    <!-- #arquivo-->
    <div id="arquivo">
        <?php foreach($user->archivedOpportunities as $entity): ?>
            <?php $this->part('panel-opportunity', array('entity' => $entity)); ?>
        <?php endforeach; ?>
        <?php if(!$user->archivedOpportunities): ?>
            <div class="alert info">Você não possui nenhum <?php $this->dict('entities: opportunity')?> arquivada.</div>
        <?php endif; ?>
    </div>
    <!-- #arquivo-->
    <!-- #permitido-->
    <div id="permitido">
        <?php foreach($app->user->hasControlOpportunities as $entity): ?>
            <?php $this->part('panel-opportunity', array('entity' => $entity)); ?>
        <?php endforeach; ?>
        <?php if(!$user->hasControlOpportunities): ?>
            <div class="alert info">Você não possui nenhum <?php $this->dict('entities: opportunity')?> liberado.</div>
        <?php endif; ?>
    </div>
    <!-- #permitido-->
    <!-- #avaliar-->
    <div id="avaliar">
        <?php foreach($opportunitiesToEvaluate as $entity): ?>
            <?php $this->part('panel-evaluation', array('entity' => $entity)); ?>
        <?php endforeach; ?>
        <?php if(!$opportunitiesToEvaluate): ?>
            <div class="alert info">Você não possui nenhum <?php $this->dict('entities: opportunity')?> liberado para avaliação.</div>
        <?php endif; ?>
    </div>
    <!-- #avaliar-->
</div>
