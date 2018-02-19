<div class="servico">
    <?php if($this->isEditable() || $entity->esfera): ?>
        <p class="esfera"><span class="label">Esfera: </span><span class="js-editable" data-edit="esfera" data-original-title="Esfera"><?php echo $entity->esfera; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->esfera_tipo): ?>
        <p class="esfera"><span class="label">Tipo de Esfera: </span><span class="js-editable" data-edit="esfera_tipo" data-original-title="Tipo de Esfera"><?php echo $entity->esfera_tipo; ?></span></p>
    <?php endif; ?>

    <?php if($this->isEditable() || $entity->certificado): ?>
        <p class="esfera"><span class="label">Títulos e Certificados: </span><span class="js-editable" data-edit="certificado" data-original-title="Títulos e Certificados"><?php echo $entity->certificado; ?></span></p>
    <?php endif; ?>
        
    <?php if($this->isEditable() || $entity->cnpj): ?>
        <p class="esfera"><span class="label">CNPJ: </span><span class="js-editable" data-edit="cnpj" data-original-title="CNPJ"><?php echo $entity->cnpj; ?></span></p>
    <?php endif; ?>
</div>