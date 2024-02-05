<div class="row">

    <div class="form-group col-md-4">
        <label for="name">Nome do recurso:</label>
        <input type="text" class="form-control" name="name" value="<?php echo old('name', $unit->name); ?>" id="name" aria-describedby="nameHelp" placeholder="Nome">
        <?php echo show_error_input('name'); ?>
    </div>


    <div class="form-group col-md-4">
        <label for="phone">Telefone:</label>
        <input type="tel" class="form-control phone_with_ddd" name="phone" value="<?php echo old('phone', $unit->phone); ?>" id="phone" aria-describedby="phoneHelp" placeholder="Informo a quantidade">
        <?php echo show_error_input('phone'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="coordinator">Usuário solicitante:</label>
        <input type="text" class="form-control" name="coordinator" value="<?php echo old('coordinator', $unit->coordinator); ?>" id="coordinator" aria-describedby="coordinatorHelp" placeholder="Usuário">
        <?php echo show_error_input('coordinator'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="start_time">Horário de Início:</label>
        <input type="time" class="form-control" name="start_time" value="<?php echo old('start_time', $unit->starttime); ?>" id="start_time" aria-describedby="start_timeHelp" placeholder="Início expediente">
        <?php echo show_error_input('start_time'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="end_time">Horário Fim:</label>
        <input type="time" class="form-control" name="end_time" value="<?php echo old('end_time', $unit->endtime); ?>" id="end_time" aria-describedby="end_timeHelp" placeholder="Final expediente">
        <?php echo show_error_input('end_time'); ?>
    </div>


    <div class="form-group col-md-4">
        <label for="servicetime">Tempo de cada Reunião:</label>

        <?php echo $timesInterval; ?>
        <?php echo show_error_input('servicetime'); ?>
    </div>


    <div class="form-group col-md-4">
        <label for="email">E-mail solicitante:</label>
        <input type="email" class="form-control" name="email" value="<?php echo old('email', $unit->email); ?>" id="email" aria-describedby="emailHelp" placeholder="E-mail">
        <?php echo show_error_input('email'); ?>
    </div>


    <div class="form-group col-md-4">
        <label for="address">Setor solicitante:</label>
        <input type="text" class="form-control" name="address" value="<?php echo old('address', $unit->address); ?>" id="address" aria-describedby="addressHelp" placeholder="Setor">
        <?php echo show_error_input('address'); ?>
    </div>

    <div class="form-group col-md-4">
        <label for="observation">Observação:</label>
        <input type="text" class="form-control" name="observation" value="<?php echo old('observation', $unit->observation); ?>" id="observation" aria-describedby="observationHelp" placeholder="Descreva informações adicionais">
        <?php echo show_error_input('observation'); ?>
    </div>


    <div class="col-md-12 mb-3 mt-4">

        <div class="custom-control custom-checkbox">
            <?php echo form_hidden('active', 0); ?>
            <input type="checkbox" name="active" value="1" <?php if ($unit->active) : ?> checked <?php endif; ?> class="custom-control-input" id="active">
            <label class="custom-control-label" for="active">Registro ativo</label>

        </div>

    </div>

</div>


<button type="submit" class="btn btn-primary mt-4">Salvar</button>

<a href="<?php echo route_to('units') ?>" class="btn btn-secondary mt-4">Voltar</a>