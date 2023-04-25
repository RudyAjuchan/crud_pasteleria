const { createApp } = Vue

createApp({
    data() {
        return {
            ingredientes: [],
            nombre: "",
            descripcion: "",
            fIngreso: "",
            fVencimiento: "",
            b_actualizar: false,
            id_ingrediente: "",
        }
    },

    methods: {
        getIngredientes(){
            axios({
                url: "http://localhost:8070/crud_pasteleria/IngredientesController/listar",
                method: "get",
            }).then((res) =>{        
                this.ingredientes = res.data;                
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
        aGuardar(){
            this.b_actualizar=false;

            this.nombre="";
            this.descripcion="";
            this.fIngreso="";
            this.fVencimiento="";
            this.id_ingrediente="";
        },
        guardarIngrediente(e){            
            var form = document.getElementById("formI");
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }else{                
                var formData= new FormData();
                formData.append("nombre", this.nombre);
                formData.append("descripcion", this.descripcion);
                formData.append("fIngreso", this.fIngreso);
                formData.append("fVencimiento", this.fVencimiento);                

                if(!this.b_actualizar){
                    axios({
                        url: "http://localhost:8070/crud_pasteleria/IngredientesController/guardar",
                        method: "post",
                        data: formData
                    }).then((res) =>{                           
                        swal({
                            icon: "success",
                            title: "Atención",
                            text: "¡Se ha registrado correctamente!",
                        }).then(function () {
                            window.location.href = "http://localhost:8070/crud_pasteleria/Page/ingrediente";
                        });
                    }).catch((err) => {
                        console.log(err);
                    })
                }else{
                    formData.append("id_ingrediente", this.id_ingrediente);
                    axios({
                        url: "http://localhost:8070/crud_pasteleria/IngredientesController/actualizar",
                        method: "post",
                        data: formData
                    }).then((res) =>{                        
                        swal({
                            icon: "success",
                            title: "Atención",
                            text: "¡Se ha registrado correctamente!",
                        }).then(function () {
                            window.location.href = "http://localhost:8070/crud_pasteleria/Page/ingrediente";
                        });
                    }).catch((err) => {
                        console.log(err);
                    })
                }                                
            }
            form.classList.add('was-validated');
        },
        borrarIngrediente(id){
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
                    formData.append("id_ingrediente", id);
                    axios({
                        url: "http://localhost:8070/crud_pasteleria/IngredientesController/eliminar",
                        method: "post",
                        data: formData
                    }).then((res) =>{                                                   
                        swal({
                            icon: "success",
                            title: "Atención",
                            text: "¡Se ha eliminado correctamente!",
                        }).then(function () {
                            window.location.href = "http://localhost:8070/crud_pasteleria/Page/ingrediente";
                        });
                    }).catch((err) => {
                        console.log(err);
                    })                       
                } else {
                    swal("No se eliminó el dato");
                }
            });
        },
        actualizarIngrediente(ingrediente){
            this.b_actualizar=true;

            this.nombre=ingrediente.nombre;
            this.descripcion=ingrediente.descripcion;
            this.fIngreso=ingrediente.fecha_ingreso;
            this.fVencimiento=ingrediente.fecha_vencimiento;
            this.id_ingrediente=ingrediente.id_ingrediente;
            var myModalEl = document.querySelector('#modalIngrediente')
            var modal = bootstrap.Modal.getOrCreateInstance(myModalEl)
            modal.show();
        },
    },

    mounted: function(){
        this.getIngredientes();                
    },
}).mount('#app')