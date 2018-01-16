/*_______________________________FUNCTION AJAX_______________________________*/

ajaxGet = function(url, data, callback)
{
  var request2;
  var dataInfo = "";

  if (window.XMLHttpRequest)  // Mozilla, Safari, ...
     {request2 = new XMLHttpRequest();}
     else if (window.ActiveXObject)  // IE 6 e anteriores
     {request2 = new ActiveXObject("Microsoft.XMLHTTP");}
  
  //SE DATA ESTIVER VAZIA, PREPARA A VARIAVEL DE FORMA CORRETA
  if(Array.isArray(data) == true)
  {
    for (i = 0; i < data.length; i++) {dataInfo += "/" + data[i];}
  }else if (data == null)            
  {dataInfo = ""}
  else
  {dataInfo = "/"+data}
   
  //PREPARA A URL COM AS VARIAVEIS PARA ENVIO
  request2.open('GET', url+dataInfo, true);
  request2.onreadystatechange = function()
  {
    //SE NÃO TIVER PROBLEMAS NA REQUISIÇÃO, SEGUE ADIANTE
    if ( request2.readyState == 4 && request2.status == 200 ) 
    {
        var type = request2.getResponseHeader("Content-Type");
        //VERIFICA O FORMATO DA RESPOSTA, PREPARANDO ASSIM A VARIAVEL
        if (type.indexOf("xml") !== -1 && request2.responseXML)
          {callback(request2.responseXML);}
        else if (type === "application/json")
          {callback(JSON.parse(request2.responseText));}     
        else  
          {callback(request2.responseText);}
    }
 };
 request2.send(null);
}


ajaxPost = function(url, data, callback)
{
  var request2;
  if (window.XMLHttpRequest)  // Mozilla, Safari, ...
     {request2 = new XMLHttpRequest();}
     else if (window.ActiveXObject)  // IE 6 e anteriores
     {request2 = new ActiveXObject("Microsoft.XMLHTTP");}
  
  request2.open('POST', url, true);
  request2.onreadystatechange = function()
  {
    
    //SE NÃO TIVER PROBLEMAS NA REQUISIÇÃO, SEGUE ADIANTE
    if ( request2.readyState == 4 && request2.status == 200 ) 
    {
        var type = request2.getResponseHeader("Content-Type");

        //VERIFICA O FORMATO DA RESPOSTA, PREPARANDO ASSIM A VARIAVEL
        if (type.indexOf("xml") !== -1 && request2.responseXML)
          {valueResponse = request2.responseXML;}
        else if (type == "application/json")
          {valueResponse = JSON.parse(request2.responseText);}     
        else 
          {valueResponse = request2.responseText;}
                
        callback(valueResponse);        
    };
 }
 request2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
 request2.send("x="+data);
}
//Tratamento de string, retira as tags Ex="<ul>"
String.prototype.stripHTML = function() {return this.replace(/<.*?>/g, '');}

/* Máscaras ER */

inputMask = function(objeto, func)
{
    objeto = document.getElementById(objeto);
    
    objeto.addEventListener('keyup', function()
        {
            if(func == 'data')
            {
                setTimeout(function(){objeto.value = mdate(objeto.value);},1);
            }else if(func == 'cep')   
            {
                setTimeout(function(){objeto.value = mcep(objeto.value);},1);
            }else if(func == 'rg')
            {
                setTimeout(function(){objeto.value = mrg(objeto.value);},1);
            }else if(func == 'valor')
            {
                setTimeout(function(){objeto.value = mvalor(objeto.value);},1);
            }else if(func == 'numero')
            {
                setTimeout(function(){objeto.value = mnumber(objeto.value);},1);
            }else if(func == 'remove_acento')
            {
                setTimeout(function(){objeto.value = removerAcentos(objeto.value);},1);
            }
            
        });
    
    
    function mdate(v)
    {
        v=v.replace(/\D+/g,"");  //Remove tudo o que não é dígito
        v=v.replace(/(\d{2})(\d)/,"$1/$2"); //Coloca hífen entre o quarto e o quinto dígitos
        v=v.replace(/(\d{2})(\d)/,"$1/$2"); //Coloca hífen entre o quarto e o quinto dígitos
        v=v.replace(/(\d{2})(\d{2})$/,"$1$2");
        return v;
    }

    function mcep(v){
        v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
        v=v.replace(/^(\d{5})(\d)/,"$1-$2")         //Esse é tão fácil que não merece explicações
        return v
    }

    function mrg(v){
        v=v.replace(/\D/g,'');
        v=v.replace(/^(\d{2})(\d)/g,"$1.$2");
        v=v.replace(/(\d{3})(\d)/g,"$1.$2");
        v=v.replace(/(\d{3})(\d)/g,"$1-$2");
	    return v;
    }

    function mvalor(v){
        v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
        v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
        v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares
        v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos
        return v;
    }

    function mnumber(v){
        v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
        return v;
    }

    function removerAcentos( newStringComAcento ) {
        var string = newStringComAcento;
          var mapaAcentosHex 	= {
              a : /[\xE0-\xE6]/g,
              e : /[\xE8-\xEB]/g,
              i : /[\xEC-\xEF]/g,
              o : /[\xF2-\xF6]/g,
              u : /[\xF9-\xFC]/g,
              c : /\xE7/g,
              n : /\xF1/g
          };
      
          for ( var letra in mapaAcentosHex ) {
              var expressaoRegular = mapaAcentosHex[letra];
              string = string.replace( expressaoRegular, letra );
          }
      
          return string.toLowerCase();
      }

}


