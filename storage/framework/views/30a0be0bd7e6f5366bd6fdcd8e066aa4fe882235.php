    
    <?php $__env->startSection('contenido'); ?>

    <?php if(Auth::check()): ?>
            <?php if(Auth::user()->id_rol == 1): ?>
            <template v-if="menu==0">
                <h1>Escritorio</h1>
            </template>
            
            <template v-if="menu==1">
                <facebook></facebook>
            </template>

            <template v-if="menu==2">
                <h1>Publicar</h1>
            </template>

            <template v-if="menu==3">
                <h1>Agregar Proyecto</h1>
            </template>

            <template v-if="menu==4">
                <h1>Pagina web</h1>
            </template>

            <template v-if="menu==5">
                <user></user>
            </template>

            <template v-if="menu==6">
                <rol></rol>
            </template>

            <template v-if="menu==7">
                <h1>Reporte Instagram</h1>
            </template>

            <template v-if="menu==8">
                <h1>Reporte Pagina web</h1>
            </template>

            <template v-if="menu==9">
                <h1>Ayuda</h1>
            </template>

            <template v-if="menu==10">
                <h1>Acerca de</h1>
            </template>
            <?php elseif(Auth::user()->id_rol == 2): ?>
            <template v-if="menu==0">
                <h1>Escritorio</h1>
            </template>
            
            <template v-if="menu==1">
                <h1>Vincular redes sociales</h1>
            </template>

            <template v-if="menu==2">
                <h1>Publicar</h1>
            </template>

            <template v-if="menu==3">
                <h1>Agregar Proyecto</h1>
            </template>

            <template v-if="menu==4">
                <h1>Pagina web</h1>
            </template>

            <template v-if="menu==7">
                <h1>Reporte Instagram</h1>
            </template>

            <template v-if="menu==8">
                <h1>Reporte Pagina web</h1>
            </template>

            <template v-if="menu==9">
                <h1>Ayuda</h1>
            </template>

            <template v-if="menu==10">
                <h1>Acerca de</h1>
            </template>
            <?php else: ?>

            <?php endif; ?>
    <?php endif; ?>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('principal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>