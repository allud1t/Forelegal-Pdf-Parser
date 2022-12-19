## Projeto Forelegal para Extração de Nomes e CPFs de um arquivo .pdf

O projeto consiste em parsear e extrair os dados nome e cpf do documento .pdf fornecido no e-mail que propõe o desafio.

Para a resolução do projeto, a ideia era parsear o documento e transformá-lo em texto. Com o texto em mãos seria mais fácil extrair os dados através de uma regex (expressão regular)

Os primeiros pontos críticos eram:

- Escolher uma biblioteca que realizasse o parseamento do arquivo;
  
- Uma lib que tivesse uma implementação otimizada o suficiente para realizar o parseamento de um arquivo considerável em tamanho (~28 MB) e dados.
  

**Solução:** Smalot PDFParser https://github.com/smalot/pdfparser

Os primeiros testes com arquivos menores mostraram que a biblioteca realizava o parseamento e extraia o texto de forma muito satisfatória.

Com o texto do PDF em mãos, hora de extrair os nomes e CPFs da enorme lista de dados. O desafio era que os dados a serem extraídos existiam em várias linhas e por vezes uma parte dos dados ficava em outra página. Portanto, as regex:

```regex
"/Nome: (.*)/"
```

O símbolo "/" (barra) é o delimitador da expressão regular e tudo dentro delas faz parte da expressão.

"Nome:" é a regra de busca, isso porque todos os nomes tinham a sequência "Nome:" como seu início.

Optei pelo ponto "." para capturar todos os caracteres até uma quebra de linha, talvez o "\D" fosse uma opção melhor, mas caso houvesse um dígito errado no meio de um nome, essa regex pararia.
O "*" (asterisco) entende que pode ou não haver texto compatível, ou mais de uma ocorrência.

```regex
"/CPF: ([0-9.-]+)?/"
```

A "/" (barra) novamente delimita a expressão regular.

"CPF:" conforme o padrão do documento inicia a busca.

O grupo de seleção "([0-9.-]+)" indica que o número de 0 a 9, pontos e hífens devem ser capturados e o "+" indica que podem haver uma ou mais ocorrências desse grupo de seleção. **Isso permite selecionar CPFs com a formatação ou somente números.**

O "?" vai suprir casos em que o documento possa ter algum erro e o "CPF:" tenha algum caractere ou string vazia.

Feito isso com sucesso e os arrays com os resultados imprimindo os valores corretamente, **para adicionar certa complexidade e realmente verificar se os dados estavam precisamente extraídos, optei por relacionar os nomes com seus respectivos CPFs.**

Primeiro código escrevi em forma de script que imprimia o tamanho do array e deixei esse script incluído em diretório separado `cli-app` com o documento lá dentro para uso do script.

Após isso, para utilizar dos benefícios da programação orientada a objetos, tornei o código componentizado, reutilizável e com melhor leitura, utilizando um padrão mais básico, uma espécie de MVC. 
Aproveitando-se disso, criei uma tela HTML simples, seu respectivo CSS e a View que retornaria a resposta. Isso deixou a vizualização mais elegante e a sensação de interação do usuário.

Para isso eu precisava subir um servidor. Utilizei o servidor nativo do PHP. Contudo, um problema surgiu: **o arquivo era grande demais para que o upload fosse feito com sucesso**, logo algumas alterações foram necessária ou no php.ini, ou como um parâmetro ao subir o servidor `post_max_size=50M`, `upload_max_filesize=50M` e `max_execution_time=1200` isso vai me permitir utilizar arquivos maiores e exceder o tempo de execução antes de timeout.

---

Existem **3 maneiras** de rodar o código:

##### Docker

1. Utilizando o Docker, buildando a imagem e rodando o container
  
  ```docker
  docker build -t <nomedaimagem> .
  ```
  
  Após isso, é necessário rodar a imagem com o comando
  
  ```docker
  docker run -p 8000:8000 <nomedaimagem>
  ```
  
  No navegador abrar o endereço e a porta escolhidos no momento do docker run: ex: http://localhost:8000

Aqui é interessante comentar que ao rodar o servidor local o código pode alocar mais memória do que a configuração padrão do container Docker. **Portanto, houve a necessidade de alterar uma nova configuração que é o limite de memória para execução do PHP no container Docker** `docker-php-memlimit.ini`. **Nesta configuração optei por desabilitar esse limite de uso de memória.**
  
  ##### Servidor local
  

2. A próxima maneira expõe o frontend da aplicação, mas utilizando o servidor web nativo do PHP, portanto será necessário a instalação do PHP e Composer na máquina a ser utilizada. Na raiz do projeto o comando para iniciar o servidor interno e expor a porta 8000 é:
  
  ```php
  php -S localhost:8000 -d post_max_size=50M -d upload_max_filesize=50M -d max_execution_time=1200
  ```
  
  ##### Linha de comando
  
3. Outra maneira é através do Script php em linha de comando. Para iniciar deve ir ao path do script e rodar o comando:
  
  ```bash
  cd cli-app &&
  php ParserScriptTxt.php
  ```
  
  Esse script irá imprimir no terminal a quantidade de nomes e cpfs parseados e criará um arquivo de `output.txt` com os nomes e seus respectivos CPFs.