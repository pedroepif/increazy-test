# Projeto Desenvolvedor Backend - Increazy

O desafio proposto era criar uma API, utilizando Lumen ou Laravel, para realizar consulta de vários utilizando a [ViaCEP](https://viacep.com.br/) e fazer o retorno dos dados da maneira propostas.

- Rota ser criada: /search/local/{cep};
- Os CEPs devem ser enviados por ",", exemplo: /search/local/88220000,88210-000;

Exemplo de retorno proposto:

```bash
[
  {
    "cep": "17560246",
    "label": "Avenida Paulista, Vera Cruz",
    "logradouro": "Avenida Paulista",
    "complemento": "de 1600/1601 a 1698/1699",
    "bairro": "CECAP",
    "localidade": "Vera Cruz",
    "uf": "SP",
    "ibge": "3556602",
    "gia": "7134",
    "ddd": "14",
    "siafi": "7235"
  },
  {
    "cep": "01001000",
    "label": "Praça da Sé, São Paulo",
    "logradouro": "Praça da Sé",
    "complemento": "lado ímpar",
    "bairro": "Sé",
    "localidade": "São Paulo",
    "uf": "SP",
    "ibge": "3550308",
    "gia": "1004",
    "ddd": "11",
    "siafi": "7107"
  }
]
```

Para realização do projeto foi usado o Micro-serviço Lumen.

## Execução

Após clonar o repositório, é possui executar a aplicação via Docker ou localmente:

### Docker

Para rodar via Docker, é necessário ter o [Docker Dektop](https://www.docker.com/products/docker-desktop/) instalado. Após a instalação basta executar o comando:

```bash
docker compose up
```

### Local

Para rodar local, é necessário ter o PHP 8.3.9 devidamente instalado. Após a instalação, será necessário instalar as dependências através do comando:

```bash
composer install
```

Tendo as dependências devidamente instaladas, basta executar o comando abaixo para iniciar a aplicação:

```bash
php -S 0.0.0.0:8000 public/index.php
```

Agora a API já estará disponível através do endereço: http://localhost:8000/