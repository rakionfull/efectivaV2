var BASE_URL = document.getElementById("base_url").value;

window.addEventListener("hashchange", () => {

    let opcion = window.location.hash;

    switch(opcion)
    {
        case "#/Empresa":
            
           
            for(let i=0; i<document.getElementsByClassName("opcion").length; i++)
            {
                document.getElementsByClassName("opcion")[i].style.display = "none";

                // $(".menu li").removeClass("activado");
            }
           
            document.querySelectorAll(".menu li").forEach(element => {
                element.classList.remove("activado");
            });
            document.getElementById("apartEmpresa").style.display = "block";
            document.getElementById("empresa").className = "activado";
            LoadTableEmpresa();
            
        window.location.hash = '#';   
        break;
        case "#/Area":
            
       
        for(let i=0; i<document.getElementsByClassName("opcion").length; i++)
        {
            document.getElementsByClassName("opcion")[i].style.display = "none";
        }
        document.querySelectorAll(".menu li").forEach(element => {
            element.classList.remove("activado");
        });
        document.getElementById("apartArea").style.display = "block";
        document.getElementById("area").className = "activado";
        LoadTableArea();
        window.location.hash = '#';   
        break;
       }    

});