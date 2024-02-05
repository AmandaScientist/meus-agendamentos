<?php echo $this->extend('Back/Layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title ?? 'Home'; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('css'); ?>
<!-- Adicione estilos CSS específicos para esta página -->
<style>
    body {
        background-image: url('<?php echo base_url('back/img/calendar-8476416_1280.png'); ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: #fff;
        /* Cor do texto, ajuste conforme necessário para garantir legibilidade */
    }
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?? 'Home'; ?></h1>
</div>
<!-- /.container-fluid -->
<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
<!-- Adicione scripts JavaScript específicos para esta página se necessário -->
<?php echo $this->endSection(); ?>