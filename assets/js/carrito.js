


function cargarCarrito(id_ingrediente, nombre) {  
    $("#input-search").val("");
    $(".content-search").fadeOut();
    const ingrediente = {
      title: nombre,      
      id: id_ingrediente,
      cantidad: 1,      
    };
    if (carrito.hasOwnProperty(ingrediente.id)) {
      ingrediente.cantidad = carrito[ingrediente.id].cantidad + 1;
    }
    carrito[ingrediente.id] = { ...ingrediente };
    pintarCarrito();     
}



const pintarCarrito = () => {
    console.log(carrito);
    items.innerHTML = ''
    Object.values(carrito).forEach(ingrediente => {
        templateCarrito.querySelectorAll('td')[0].textContent = ingrediente.id
        templateCarrito.querySelectorAll('td')[1].textContent = ingrediente.title
        
        //botones
        templateCarrito.querySelector('.btn-delete').dataset.id = ingrediente.id
        templateCarrito.querySelector('.fa-trash').dataset.id = ingrediente.id        
    
        const clone = templateCarrito.cloneNode(true)
        fragment.appendChild(clone)
     })
    items.appendChild(fragment)
    console.log("pasa aquí");  
    pintarFooter();
    
  }
  
  const pintarFooter = () => {
    footer.innerHTML = ''
    
    if (Object.keys(carrito).length === 0) {
        footer.innerHTML = `
        <th scope="row" colspan="5">Lista vacía</th>
        `
        return
    }  
    const clone = templateFooter.cloneNode(true)
    fragment.appendChild(clone)
  
    footer.appendChild(fragment)
  
    const boton = document.querySelector('#vaciar-carrito')
    boton.addEventListener('click', () => {
        carrito = {}
        pintarCarrito()
    })
  
  }
