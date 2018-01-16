# estrutura-mvc-php

Modelo de estrutura MVC pronta para uso, criada para organizar diferentes ambientes no mesmo sistema (site, área adminsitrativa, área do cliente, etc...).

Os arquivos são chamados na seguinte ordem:
1 - public/index.php #carrega o arquivo /application/init.php e inicia App
2 - init.php #carrega /lib/Constante.php e /lib/AutoLoad.php
3 - App.php #responsável por gerenciar todas as requisições via URL e direcionar para o local correto.
4 - Constante.php #Cria as constantes do sistema e verifica o ínicio da URL para redirecionar ao site ou outras divisões.
5 - AutoLoad.php #Inclui o diretório raiz e inícia a classe spl_autoload_register.


![alt text](https://raw.githubusercontent.com/nct-juan/estrutura-mvc-php/master/doc/estrutura.png)
