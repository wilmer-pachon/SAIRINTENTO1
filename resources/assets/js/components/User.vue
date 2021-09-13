<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Usuarios
                        <button type="button" @click="abrirModal('user','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="usuario">Nombre de usuario</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarUsuario(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarUsuario(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre De Usuario</th>
                                    <th>Clave</th>
                                    <th>Rol</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in arrayUsuario" :key="user.id">
                                    <td>
                                        <button type="button" @click="abrirModal('user','actualizar',user)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>&nbsp;
                                        <template v-if="user.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="eliminarUsuario(user.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <!-- <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarUsuario(usuario.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template> -->
                                    </td>
                                    <td v-text="user.usuario"></td>
                                    <td v-text="user.password"></td>
                                    <td v-text="user.rol"></td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
                 <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre Usuario (*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Nombre de usuario">  
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Clave (*)</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Clave de acceso">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Rol (*)</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="id_rol">
                                            <option valor = "0" >Seleccione un rol</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.rol"></option>
                                        </select>
                                    </div>
                                </div>

                                <div v-show="errorUsuario" class="form-group-row div-error">
                                     <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjUsuario" :key="error" v-text="error">

                                        </div>
                                     </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUsuario()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarUsuario()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            </div>
        </main>
</template>

<script>
    export default {
        data () { 
            return {
                usuario_id: 0,
                usuario : '',
                password : '',
                id_rol: 0,
                arrayUsuario : [],
                arrayRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorUsuario : 0,
                errorMostrarMsjUsuario : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'usuario',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return  pagesArray;
            }
        },
        methods : {
            listarUsuario (page,buscar,criterio){
                let me=this;
                var url='/user?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUsuario = respuesta.users.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectRol(){
                let me=this;
                var url='/rol/selectRol';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
               let me = this;
               //Actualizar la pagina actual
               me.pagination.current_page = page;
               //Envia la peticion para visualizar la data de esa pagina
               me.listarUsuario(page,buscar,criterio);
            },
            registrarUsuario(){
                if(this.validarUsuario()){
                    return;
                }

                let me = this;

                axios.post('/user/registrar',{
                    'usuario': this.usuario,
                    'password': this.password,
                    'id_rol' : this.id_rol

                }).then(function (response) {
                    me.cerrarModal();
                    me.listarUsuario(1,'','usuario');
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarUsuario(){
               if(this.validarUsuario()){
                    return;
                }

                let me = this;

                axios.put('/user/actualizar',{
                    'usuario': this.usuario,
                    'password': this.password,
                    'id_rol': this.id_rol,
                    'id' : this.usuario_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarUsuario(1,'','usuario');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            eliminarUsuario(id){
                const swalWithBootstrapButtons = swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
 
                swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de eliminar este usuario?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
 
                        axios.post('/user/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarUsuario(1,'','nombre');
                        }).catch(function (error) {
                            console.log(error);
                        });
                        swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'El registro a sido eliminado con éxito.',
                            'success'
                        )
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        
                    }
                })
            },
            validarUsuario (){
                this.errorUsuarip=0;
                this.errorMostrarMsjUsuario =[];

                if(!this.usuario) this.errorMostrarMsjUsuario.push("El nombre de usuario no puede estar vacio.");
                if(!this.password) this.errorMostrarMsjUsuario.push("la clave no puede estar vacia.");
                if(this.id_rol==0) this.errorMostrarMsjUsuario.push("Debes seleccionar un rol para el usuario.");

                if(this.errorMostrarMsjUsuario.length) this.errorUsuario = 1;

                return this.errorUsuario;
            },
             cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.usuario='';
                this.password='';
                this.id_rol=0;
                this.errorUsuario=0;
            },
            abrirModal(modelo, accion, data = []){
                this.selectRol();
                switch(modelo){
                    case "user":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal  = 'Registrar Usuario';
                                this.usuario='';
                                this.password='';
                                this.id_rol=0;
                                this.tipoAccion = 1;
                                break;

                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Usuario';
                                this.tipoAccion=2;
                                this.usuario_id=data['id'];
                                this.usuario = data['usuario'];
                                this.password =  data['password'];
                                this.id_rol =  data['id_rol'];
                                break;
                            }    
                        }
                    }
                }
            },
            // desactivarUsuario(id){
            //     const swalWithBootstrapButtons = swal.mixin({
            //       customClass: {
            //         confirmButton: 'btn btn-success',
            //         cancelButton: 'btn btn-danger'
            //       },
            //       buttonsStyling: false
            //     })

            //     swalWithBootstrapButtons.fire({
            //       title: 'Esta seguro de desactivar este usuario?',
            //       icon: 'warning',
            //       showCancelButton: true,
            //       confirmButtonText: 'Aceptar',
            //       cancelButtonText: 'Cancelar',
            //       reverseButtons: true
            //     }).then((result) => { 
            //       if (result.isConfirmed) {
            //         let me = this;

            //         axios.put('/usuario/desactivar',{
            //             'id': id
            //         }).then(function (response) {
            //             me.listarUsuario(1,'','nombre');
            //             swalWithBootstrapButtons.fire(
            //               'Desactivado!',
            //               'El registro a sido desactivado con exito.',
            //               'success'
            //             )
            //         }).catch(function (error){
            //             console.log(error);
            //         });
                    
            //       } else if (
            //         /* Read more about handling dismissals below */
            //         result.dismiss === swal.DismissReason.cancel
            //       ) {

            //      }
            //      })
            // },
            // activarUsuario(id){
            //     const swalWithBootstrapButtons = swal.mixin({
            //       customClass: {
            //         confirmButton: 'btn btn-success',
            //         cancelButton: 'btn btn-danger'
            //       },
            //       buttonsStyling: false
            //     })

            //     swalWithBootstrapButtons.fire({
            //       title: 'Esta seguro de activar este usuario?',
            //       icon: 'warning',
            //       showCancelButton: true,
            //       confirmButtonText: 'Aceptar',
            //       cancelButtonText: 'Cancelar',
            //       reverseButtons: true
            //     }).then((result) => { 
            //       if (result.isConfirmed) {
            //         let me = this;

            //         axios.put('/usuario/activar',{
            //             'id': id
            //         }).then(function (response) {
            //             me.listarUsuario(1,'','nombre_usuario');
            //             swalWithBootstrapButtons.fire(
            //               'Activado!',
            //               'El registro a sido activado con exito.',
            //               'success'
            //             )
            //         }).catch(function (error){
            //             console.log(error);
            //         });
                    
            //       } else if (
            //         /* Read more about handling dismissals below */
            //         result.dismiss === swal.DismissReason.cancel
            //       ) {

            //      }
            //      })
            // },
        },
        mounted() {
            this.listarUsuario(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
