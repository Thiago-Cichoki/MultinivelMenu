Sistema de menu multinível 

Setup:
    - Instalar docker para o funcionamento do sistema. 
    
    - Docker para Linux (ubuntu)
    
        $ sudo apt-get update
        Install the latest version of Docker CE and containerd, or go to the next step to install a specific version:
    
        $ sudo apt-get install docker-ce docker-ce-cli containerd.io
        
        - Depois de instalar o docker, é necessário instalar o docker-compose
        https://docs.docker.com/compose/install/
       
    - Docker para Mac
    https://docs.docker.com/docker-for-mac/install/
    
    - Docker tool box para Windows
    https://docs.docker.com/toolbox/toolbox_install_windows/
    
     
     -Após instalar o docker: 
           - Linux:     
                - No diretório do projeto, execute o comando
                    $ docker-compose up -d
                    Esse comando irá executar a virtualização do sistema, bem como instalar seus dependências. 
                    Em sua primeira execução, o processo pode demorar um pouco. 
                    
                    Após ter a mensagem que os containers estão ativos, poderá acessar em http://127.0.0.1:8000, e o banco irá rodar na porta 33062, com usuário root e senha secret
           
           - Windows
                Execute o docker tool box, vá até o diretóri do projeto e execute o comando
                docker-compose up -d
                
                Em sua primeira execução, o processo pode demorar um pouco. 
                                    
                                    Após ter a mensagem que os containers estão ativos, poderá acessar em http://192.168.99.100:8000, e o banco irá rodar na porta 33062, com usuário root e senha secret
                                    
                              
     
     
     
