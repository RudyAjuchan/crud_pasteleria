const { createApp } = Vue

createApp({
    data() {
        return {
            pasteles: [],
            ingredientes: [],
            carrito: {},
            carrito2: {},
            carrito3: {},
            nombre: "",
            descripcion: "",
            preparado_por: "",
            fCreado: "",
            fVencimiento: "",
            b_actualizar: false,
            id_pastel: "",
        }
    },

    methods: {
        getPasteles(){
            axios({
                url: "http://localhost:8070/crud_pasteleria/PastelesController/listar",
                method: "get",
            }).then((res) =>{        
                this.pasteles = res.data;                
            }).catch((err) => {
                console.log(err);
            });            
            setTimeout(() => {
                table = $('#myTable').DataTable({
                    "language": {
                        "paginate": {
                            "previous": "Anterior",
                            "next":"Siguiente"
                        },
                        "lengthMenu": "Mostrar _MENU_ entradas",
                        "zeroRecords": "No hay ningun registro",
                        "info": "Mostrando _PAGE_ de _PAGES_",
                        "infoEmpty": "No hay ningun registro",
                        "search":"Buscar"
                    },                  
            });
            }, 100);
        },
        getIngredientes(){
            axios({
                url: "http://localhost:8070/crud_pasteleria/IngredientesController/listar",
                method: "get",
            }).then((res) =>{
                if(res.data!==null){
                    this.ingredientes = res.data;
                }else{
                    swal({
                        icon: "warning",
                        title: "Atención",
                        text: "¡No puede registrar pasteles aún, debe registrar ingredientes primero :) !",
                    }).then(function () {
                        window.location.href = "http://localhost:8070/crud_pasteleria/Page/inicio";
                    });
                }                
            }).catch((err) => {
                console.log(err);
            });
        },
        getIngredientesBuscar(){
            var formData = new FormData();
            formData.append("id_pastel", this.id_pastel);
            axios({
                url: "http://localhost:8070/crud_pasteleria/PastelesController/buscarIngredientes",
                method: "post",
                data: formData
            }).then((res) =>{
                //var datos = JSON.parse(res);        
                for(let i=0; i<=res.data.length-1; i++){
                    const ingrediente = {
                        title: res.data[i].nombre,      
                        id: res.data[i].id_ingrediente,
                        cantidad: 1,      
                        };
                        if (this.carrito.hasOwnProperty(ingrediente.id)) {
                        ingrediente.cantidad = this.carrito[ingrediente.id].cantidad + 1;
                        }
                        this.carrito[ingrediente.id] = { ...ingrediente }; 
                }              
            }).catch((err) => {
                console.log(err);
            });
        },
        aGuardar(){
            this.b_actualizar=false;

            this.nombre="";
            this.descripcion="";
            this.preparado_por="";
            this.fCreado="";
            this.fVencimiento="";
            this.id_ingrediente="",
            this.carrito= {},
            this.carrito2= {},
            this.carrito3= {}
        },
        guardarPastel(e){            
            var form = document.getElementById("formP");
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }else{                
                var formData= new FormData();
                formData.append("nombre", this.nombre);
                formData.append("descripcion", this.descripcion);
                formData.append("preparado_por", this.preparado_por);
                formData.append("fCreado", this.fCreado);
                formData.append("fVencimiento", this.fVencimiento);                
                formData.append("carrito", JSON.stringify(this.carrito));                

                if(!this.b_actualizar){
                    var datoscarrito=JSON.stringify(this.carrito);
                    console.log(datoscarrito);
                    if(datoscarrito !== "{}"){
                        axios({
                            url: "http://localhost:8070/crud_pasteleria/PastelesController/guardar",
                            method: "post",
                            data: formData
                        }).then((res) =>{                           
                            console.log(res);
                            swal({
                                icon: "success",
                                title: "Atención",
                                text: "¡Se ha registrado correctamente!",
                            }).then(function () {
                                window.location.href = "http://localhost:8070/crud_pasteleria/Page/pastel";
                            });
                        }).catch((err) => {
                            console.log(err);
                        })
                    }else{
                        swal({
                            icon: "warning",
                            title: "Atención",
                            text: "¡No se ha seleccionado ningún ingrediente!",
                        })
                    }                    
                }else{
                    formData.append("id_pastel", this.id_pastel);
                    formData.append("borrar", JSON.stringify(this.carrito2));
                    formData.append("agregar", JSON.stringify(this.carrito3));
                    axios({
                        url: "http://localhost:8070/crud_pasteleria/PastelesController/actualizar",
                        method: "post",
                        data: formData
                    }).then((res) =>{
                        console.log(res);
                        swal({
                            icon: "success",
                            title: "Atención",
                            text: "¡Se ha registrado correctamente!",
                        }).then(function () {
                            window.location.href = "http://localhost:8070/crud_pasteleria/Page/pastel";
                        });
                    }).catch((err) => {
                        console.log(err);
                    })
                }                                
            }
            form.classList.add('was-validated');
        },
        borrarPastel(id){
            swal({
                title: "¿Está seguro eliminar el dato",
                text: "Esta acción es irreversible",
                icon: "warning",
                buttons: {
                    confirm: { text: "Si deseo eliminarlo", className: "sweet-warning" },
                    cancel: "Cancelar",
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var formData = new FormData();
                    formData.append("id_pastel", id);
                    axios({
                        url: "http://localhost:8070/crud_pasteleria/PastelesController/eliminar",
                        method: "post",
                        data: formData
                    }).then((res) =>{                                                   
                        swal({
                            icon: "success",
                            title: "Atención",
                            text: "¡Se ha eliminado correctamente!",
                        }).then(function () {
                            window.location.href = "http://localhost:8070/crud_pasteleria/Page/pastel";
                        });
                    }).catch((err) => {
                        console.log(err);
                    })                       
                } else {
                    swal("No se eliminó el dato");
                }
            });
        },
        actualizarPastel(pastel){
            this.b_actualizar=true;

            this.nombre=pastel.nombre;
            this.descripcion=pastel.descripcion;
            this.preparado_por=pastel.preparado_por;
            this.fCreado=pastel.fecha_creacion;
            this.fVencimiento=pastel.fecha_vencimiento;
            this.id_pastel=pastel.id_pastel;
            this.carrito= {},
            this.carrito2= {},
            this.carrito3= {}
            this.getIngredientesBuscar();

            var myModalEl = document.querySelector('#modalPastel')
            var modal = bootstrap.Modal.getOrCreateInstance(myModalEl)
            modal.show();
        },
        cargarCarrito(id_ingrediente, nombre){
            $("#input-search").val("");
            $(".content-search").fadeOut();
            if(!this.b_actualizar){
                const ingrediente = {
                title: nombre,      
                id: id_ingrediente,
                cantidad: 1,      
                };
                if (this.carrito.hasOwnProperty(ingrediente.id)) {
                ingrediente.cantidad = this.carrito[ingrediente.id].cantidad + 1;
                }
                this.carrito[ingrediente.id] = { ...ingrediente };  
            }else{
                const ingrediente = {
                title: nombre,      
                id: id_ingrediente,
                cantidad: 1,      
                };
                if (this.carrito3.hasOwnProperty(ingrediente.id)) {
                ingrediente.cantidad = this.carrito3[ingrediente.id].cantidad + 1;
                }
                if (this.carrito.hasOwnProperty(ingrediente.id)) {
                    ingrediente.cantidad = this.carrito[ingrediente.id].cantidad + 1;
                    }
                this.carrito3[ingrediente.id] = { ...ingrediente };
                this.carrito[ingrediente.id] = { ...ingrediente };                
            }
        },
        /* aumentar(id){
            const producto = this.carrito[id]
            producto.cantidad++
            this.carrito[id] = { ...producto }
        }, */
        disminuir(id){
            const ingrediente = this.carrito[id]
            ingrediente.cantidad--
            if (ingrediente.cantidad === 0) {                
                if(this.b_actualizar){
                    const ingredienteaux = {
                        title: this.carrito[id].title,      
                        id: this.carrito[id].id,
                        cantidad: 1,      
                    };
                    if (this.carrito2.hasOwnProperty(ingredienteaux.id)) {
                        ingredienteaux.cantidad = this.carrito[ingredienteaux.id].cantidad + 1;
                    }
                    this.carrito2[ingredienteaux.id] = { ...ingredienteaux };
                }
                delete this.carrito[id];
            } else {
                this.carrito[id] = {...ingrediente}
            }
        },
        quitarBusqueda() {
            $(".content-search").fadeOut();
        }
    },

    mounted: function(){
        this.getPasteles();
        this.getIngredientes();
        /* para carrito */        
        /* Para buscador */
        setTimeout(() => {
            $(".content-search").fadeOut();
            var buscador = $("#table_search").DataTable();
            $("#input-search").keyup(function () {
            buscador.search($(this).val()).draw();
            if ($("#input-search").val() == "") {
                $(".content-search").fadeOut();
            } else {
                $(".content-search").fadeIn();
            }
            });
        }, 100);
        /* Para buscador */


        /* Para carrito */
    },
}).mount('#app')