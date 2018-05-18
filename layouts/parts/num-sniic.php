<?php if($this->isEditable() || $entity->num_sniic): ?>
    <?php $this->applyTemplateHook('num-sniic','before'); ?>
    <p class="num_sniic">
        <span class="label">Nº SNIIC:</span> 
        <span id="num-sniic"><?php echo $entity->num_sniic ? $entity->num_sniic : "Preencha os campos obrigatorios e clique em salvar para gerar"; ?></span>
    </p>
    <?php $this->applyTemplateHook('num-sniic','after'); ?>
<?php endif; ?>