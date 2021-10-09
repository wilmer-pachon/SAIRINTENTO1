<?php $__env->startSection('login'); ?>
<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4"> 
          <form class="form-horizontal was-validated" method="POST" action="<?php echo e(route('login')); ?>">
           <?php echo e(csrf_field()); ?>

            <div class="card-body">
              <h1>Acceder</h1>
              <p class="text-muted">Control de acceso al Software</p>
              <div class="form-group mb-3<?php echo e($errors->has('usuario' ? 'is-invalid' : '')); ?>">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="<?php echo e(old('usuario')); ?>" name="usuario" id="usuario" class="form-control" placeholder="Nombre de Usuario">
                <?php echo $errors->first('usuario','<span class="invalid-feedback">:message</span>'); ?>

              </div>
              <div class="form-group mb-4<?php echo e($errors->has('password' ? 'is-invalid' : '')); ?>">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="password">
                <?php echo $errors->first('password','<span class="invalid-feedback">:message</span>'); ?>

              </div>
              <div class="row">
                <div class="col-6">
                  <button type="submit" class="btn btn-primary px-4">Acceder</button>
                </div>
              </div>
            </div>
          </form>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2>SAIR </h2>
                <p>Software de Analisis Interactivo de Redes sociales en la compañia MOVIP SAS.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.contenido', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>