
![Logo](https://i.imgur.com/vOn1vNA.png)
# 😃 API REST com PHP  😄

## 😽REFERENCIA DE USO 🙀

#### PEGAR TODOS ELEMENTOS 

#### todos os elementos na url é usado de forma classica com (? e &) 

É importante dizer que estamos usando formulario para grande parte.

o header aparti de exemplo:

```header
Content-Type: application/x-www-form-urlencoded
```

```http
  GET vazio
```

#### Item por ID

```http
  GET ?id={$id}
```
Retorno serar um JSON.

você pode classificar por `order_by`, `limit` e `offset` alem dos `ID`, `type` ou e `message`

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string\numeric` | **Required**. É necessario o ID para o fetch |

#### Enviar um novo dado para a DB

O banco de dados pode ser bem modulado ao seu jeito, com tudo segue o exemplo padrão.

```http
POST array('type' => 'sugestao',
        'message' => 'Teste de ocorrencia POST')
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `type`      | `string` | **Required**. É necessario o type para o fetch |
| `message`      | `string` | **Required**. É necessario o message para o fetch |


o retorno em questão de processos de atualização e inserção o retorno é OK e o html retornar o ID da linha em questão.


```http
PUT   array('type'  => 'sugestao',
         'message'  => 'Texto mudado via put',
            'user'  => 'Fulano',
            'birth' => '1988-03-19',
            'id'    =>  '11')
```

# 😶‍🌫️ Esse projeto foi desenvolvido por meio de um teste.
desenvolvido por: SrShadowy.
![Logo](https://i.imgur.com/NUUNkon.png)
