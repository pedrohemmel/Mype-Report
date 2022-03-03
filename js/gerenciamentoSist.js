//navegação
let displayBlockNav = document.querySelector('.displayBlockNav');
let navBase = document.querySelector('.navBase');
let linkAcessoRegistros = document.querySelectorAll('.linkAcessoRegistros');
let iconAbreFecha = document.querySelector('.iconAbreFecha');

//tabela gruposAcesso
$linkAdministrador = document.querySelector('#linkAdministrador');
$linkAdministradorSub = document.querySelector('#linkAdministradorSub');


navBase.style.width = '200px';

iconAbreFecha.style.backgroundColor = '#843aad';
iconAbreFecha.style.color = '#fff';  


function abreFechaNav() {
    
    if(displayBlockNav.style.display != 'none') {
        iconAbreFecha.style.transition = '0.5s';
        if(navBase.style.width == '200px') {
            for(let i = 0; i < 3; i++) {  
                linkAcessoRegistros[i].style.display = 'none';    
            }  
            navBase.style.width = '0';
            iconAbreFecha.style.backgroundColor = 'rgb(238, 238, 238)';
            iconAbreFecha.style.color = '#843aad';
        } else {
            for(let i = 0; i < 3; i++) {
                linkAcessoRegistros[i].style.display = 'block';
            }
            navBase.style.width = '200px';
            iconAbreFecha.style.backgroundColor = '#843aad';
            iconAbreFecha.style.color = '#fff';  
        } 
    }
    
}



