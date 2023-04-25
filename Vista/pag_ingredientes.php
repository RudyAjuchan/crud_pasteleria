<?php
require 'encabezado.php';
?>
<div id="app">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Ingredientes</h3>
            <hr>
            <button type="button" class="btn btn-pas float-end" data-bs-toggle="modal" data-bs-target="#modalIngrediente" @click="aGuardar">
                <i class="fas fa-plus-circle"></i> Nuevo
            </button>
            <br>            
            <div class="table-responsive mt-3">
                <table class="table mt-4 table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th>Id ingrediente</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha Ingreso</th>
                            <th>Fecha vencimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>                    
                    <tbody>
                        <tr v-for="(ingrediente, i) in ingredientes" :key="ingrediente.id">                            
                            <td>{{ ingrediente.id_ingrediente }}</td>
                            <td>{{ ingrediente.nombre }}</td>
                            <td>{{ ingrediente.descripcion }}</td>
                            <td>{{ ingrediente.fecha_ingreso }}</td>
                            <td>{{ ingrediente.fecha_vencimiento }}</td>
                            <td>
                                <button type="button" style="border:none; background-color: transparent;font-size: 1.2rem" @click="actualizarIngrediente(ingrediente)">
                                    <i class="fa-solid fa-user-pen"></i>
                                </button>
                                <button type="button" style="border:none; background-color: transparent;font-size: 1.2rem" @click="borrarIngrediente(ingrediente.id_ingrediente)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>                
            </div>
        </div>
    </div>
</div>


<!-- Inicio del modal -->
<div class="modal fade" id="modalIngrediente" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Registro de ingredientes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form @submit.prevent="guardarIngrediente" class="needs-validation" id="formI" novalidate>
            <div class="modal-body">                
                    <div class="icono">
                        <label for="nombre">Nombre:</label>
                        <i class="fa-solid fa-file-signature"></i>
                        <input required type="text" v-model="nombre" class="form-control ps-5 mb-3" placeholder="Ingrese el nombre del ingrediente" >
                        <div class="invalid-feedback">
                            Por favor complete este campo
                        </div>                  
                    </div>
                    <div class="icono">
                        <label for="descripcion">Descripción:</label>
                        <i class="fa-solid fa-file-signature"></i>
                        <input required type="text" v-model="descripcion" class="form-control ps-5 mb-3" placeholder="Ingrese la descripción del ingrediente" >
                        <div class="invalid-feedback">
                            Por favor complete este campo
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="fIngreso">Fecha Ingreso:</label>                        
                            <input required type="date" v-model="fIngreso" class="form-control">
                            <div class="invalid-feedback">
                            Por favor complete este campo
                        </div>
                        </div>
                        <div class="col-md-6">
                            <label for="fVencimiento">Fecha Vencimiento:</label>                        
                            <input required type="date" v-model="fVencimiento" class="form-control">
                            <div class="invalid-feedback">
                            Por favor complete este campo
                        </div>
                        </div>
                    </div>                      
            </div>
            <div class="modal-footer">                
                <button class="btn btn-pas" v-if="!b_actualizar">Guardar</button>
                <button class="btn btn-pas" v-if="b_actualizar">Actualizar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>                     
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Final del modal -->
</div>
<?php
require 'pie.php';
?>
<script src="../assets/js/ingredientes.js"></script>