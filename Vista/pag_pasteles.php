<?php
require 'encabezado.php';
?>
<div id="app">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Pasteles</h3>
            <hr>
            <button type="button" class="btn btn-pas float-end" data-bs-toggle="modal" data-bs-target="#modalPastel" @click="aGuardar">
                <i class="fas fa-plus-circle"></i> Nuevo
            </button>
            <br>            
            <div class="table-responsive mt-3">
                <table class="table mt-4 table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th>Id pastel</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Preparado por</th>
                            <th>Fecha Creación</th>
                            <th>Fecha vencimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>                    
                    <tbody>
                        <tr v-for="(pastel, i) in pasteles" :key="pastel.id_pastel">                            
                            <td>{{ pastel.id_pastel }}</td>
                            <td>{{ pastel.nombre }}</td>
                            <td>{{ pastel.descripcion }}</td>
                            <td>{{ pastel.preparado_por }}</td>
                            <td>{{ pastel.fecha_creacion }}</td>
                            <td>{{ pastel.fecha_vencimiento }}</td>
                            <td>
                                <button type="button" style="border:none; background-color: transparent;font-size: 1.2rem" @click="actualizarPastel(pastel)">
                                    <i class="fa-solid fa-user-pen"></i>
                                </button>
                                <button type="button" style="border:none; background-color: transparent;font-size: 1.2rem" @click="borrarPastel(pastel.id_pastel)">
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
<div class="modal fade" id="modalPastel" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Registro de Pasteles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form @submit.prevent="guardarPastel" class="needs-validation" id="formP" novalidate>
            <div class="modal-body">                
                    <div class="icono">
                        <label for="nombre">Nombre:</label>
                        <i class="fa-solid fa-file-signature"></i>
                        <input required type="text" v-model="nombre" class="form-control ps-5 mb-3" placeholder="Ingrese el nombre el pastel" >
                        <div class="invalid-feedback">
                            Por favor complete este campo
                        </div>                  
                    </div>
                    <div class="icono">
                        <label for="descripcion">Descripción:</label>
                        <i class="fa-solid fa-file-signature"></i>
                        <input required type="text" v-model="descripcion" class="form-control ps-5 mb-3" placeholder="Ingrese la descripción el pastel" >
                        <div class="invalid-feedback">
                            Por favor complete este campo
                        </div>
                    </div>

                    <div class="icono">
                        <label for="preparado_por">Preparado por:</label>
                        <i class="fa-solid fa-file-signature"></i>
                        <input required type="text" v-model="preparado_por" class="form-control ps-5 mb-3" placeholder="Ingrese quién prepara el pastel" >
                        <div class="invalid-feedback">
                            Por favor complete este campo
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="fCreado">Fecha Creación:</label>                        
                            <input required type="date" v-model="fCreado" class="form-control">
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
                    
                    <!-- Para la búsqueda -->
                    <Label class="float-start mt-4">Buscar Ingrediente:</Label>
                    <input type="search" id="input-search" @blur="quitarBusqueda()" placeholder="Buscar aqui" class="form-control">
                    <div class="content-search">
                        <div class="content-table">
                            <table id="table_search" class="table">
                                <thead>
                                    <tr>
                                        <th>Cod</th>
                                        <th>Ingrediente</th>                              
                                        <th>Descripción</th>
                                        <th>Acción</th>                              
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <tr v-for="(ingrediente, i) in ingredientes" :key="ingrediente.id_ingrediente">
                                        <td>{{ ingrediente.id_ingrediente }}</td>
                                        <td>{{ ingrediente.nombre }}</td>
                                        <td>{{ ingrediente.descripcion }}</td>
                                        <td><button type="button" class="btn btn-success btn-sm" @click="cargarCarrito(ingrediente.id_ingrediente, ingrediente.nombre)">Agregar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Para la búsqueda -->
                    
                    <!-- Para el resumen de ingredientes -->
                    <center>
                        <h3 class="mt-5" id="abajo">Listado de ingredientes</h3>
                    </center>
                    <div class="table-responsive" id="div_carrito">
                        <table class="table mt-4 table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Ingrediente</th>
                                    <!-- <th>Cantidad</th> -->
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="items">
                                <tr v-for="(ingr, i) in carrito" :key="ingr.id">
                                    <td>{{ ingr.id }}</td>
                                    <td>{{ ingr.title }}</td>
                                    <!-- <td v-if="ingr.cantidad>0">ingr.cantidad</td>
                                    <td v-else>1</td>   -->                                  
                                    <td>
<!--                                     <button type="button" class="btn btn-info btn-sm" @click="aumentar(ingr.id)">
                                        +
                                    </button> -->
                                    <button type="button" class="btn btn-danger btn-sm ms-2" @click="disminuir(ingr.id)">
                                        -
                                    </button>
                                    </td>
                                </tr>
                            </tbody>                                                        
                        </table>
                    </div>
                    <!-- Fin resumen ingredientes -->
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
<script src="../assets/js/pasteles.js"></script>