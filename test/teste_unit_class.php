<?php
include_once "C:\\Users\\srsha\\Documents\\teste_contato_seguro\\teste_backend\\source\\api_rest.php"; // coloque o diretorio completo :)
use PHPUnit\Framework\TestCase;

//para teste de url
function get_content($URL){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $URL);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

// Os teste irão necessitar do server ligado
class teste_unit_class extends TestCase
{

    private $url = "http://localhost:8000/"; // url local para teste é claro :)

    // Check incial se a instancia da classe realmente é igual
    public function test_instance_of_class()
    {
        $new_var = new API_REST();
        $this->assertInstanceOf(API_REST::class, $new_var);
    }

    // Pegando o primeiro GET do banco de dados
    public function test_get()
    {
        $org = file_get_contents('http://localhost:8000/');
        $previst = '[{"id":"1","0":"1","type":"duvida","1":"duvida","message":"Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.","2":"Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.","is_identified":"0","3":"0","whistleblower_name":null,"4":null,"whistleblower_birth":null,"5":null,"created_at":"2021-06-30 18:47:23","6":"2021-06-30 18:47:23","deleted":"1","7":"1"},{"id":"2","0":"2","type":"duvida","1":"duvida","message":"Donec ut mauris eget massa tempor convallis.","2":"Donec ut mauris eget massa tempor convallis.","is_identified":"1","3":"1","whistleblower_name":"Carly Insko","4":"Carly Insko","whistleblower_birth":"1988-03-19","5":"1988-03-19","created_at":"2020-12-19 09:55:55","6":"2020-12-19 09:55:55","deleted":"1","7":"1"},{"id":"3","0":"3","type":"sugestao","1":"sugestao","message":"In blandit ultrices enim.","2":"In blandit ultrices enim.","is_identified":"1","3":"1","whistleblower_name":"Parsifal Dorkens","4":"Parsifal Dorkens","whistleblower_birth":"1983-02-19","5":"1983-02-19","created_at":"2020-09-04 12:41:53","6":"2020-09-04 12:41:53","deleted":"0","7":"0"},{"id":"4","0":"4","type":"denuncia","1":"denuncia","message":"Donec semper sapien a libero.","2":"Donec semper sapien a libero.","is_identified":"0","3":"0","whistleblower_name":null,"4":null,"whistleblower_birth":null,"5":null,"created_at":"2020-12-05 21:59:01","6":"2020-12-05 21:59:01","deleted":"0","7":"0"},{"id":"5","0":"5","type":"denuncia","1":"denuncia","message":"Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio.","2":"Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio.","is_identified":"0","3":"0","whistleblower_name":null,"4":null,"whistleblower_birth":null,"5":null,"created_at":"2021-02-08 10:18:37","6":"2021-02-08 10:18:37","deleted":"0","7":"0"},{"id":"6","0":"6","type":"duvida","1":"duvida","message":"Phasellus sit amet erat.","2":"Phasellus sit amet erat.","is_identified":"0","3":"0","whistleblower_name":null,"4":null,"whistleblower_birth":null,"5":null,"created_at":"2020-08-31 20:53:33","6":"2020-08-31 20:53:33","deleted":"0","7":"0"},{"id":"7","0":"7","type":"denuncia","1":"denuncia","message":"Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.","2":"Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.","is_identified":"0","3":"0","whistleblower_name":null,"4":null,"whistleblower_birth":null,"5":null,"created_at":"2020-12-21 21:55:40","6":"2020-12-21 21:55:40","deleted":"1","7":"1"},{"id":"8","0":"8","type":"sugestao","1":"sugestao","message":"Nulla suscipit ligula in lacus. Curabitur at ipsum ac tellus semper interdum.","2":"Nulla suscipit ligula in lacus. Curabitur at ipsum ac tellus semper interdum.","is_identified":"1","3":"1","whistleblower_name":"Frances Petit","4":"Frances Petit","whistleblower_birth":"1997-06-12","5":"1997-06-12","created_at":"2021-05-12 14:25:24","6":"2021-05-12 14:25:24","deleted":"0","7":"0"},{"id":"9","0":"9","type":"denuncia","1":"denuncia","message":"Integer a nibh.","2":"Integer a nibh.","is_identified":"0","3":"0","whistleblower_name":null,"4":null,"whistleblower_birth":null,"5":null,"created_at":"2021-07-10 20:27:29","6":"2021-07-10 20:27:29","deleted":"0","7":"0"},{"id":"10","0":"10","type":"sugestao","1":"sugestao","message":"Suspendisse accumsan tortor quis turpis. Sed ante. Vivamus tortor.","2":"Suspendisse accumsan tortor quis turpis. Sed ante. Vivamus tortor.","is_identified":"1","3":"1","whistleblower_name":"Bar Rannigan","4":"Bar Rannigan","whistleblower_birth":"2001-12-30","5":"2001-12-30","created_at":"2020-10-03 17:13:22","6":"2020-10-03 17:13:22","deleted":"0","7":"0"}]';
        $this->assertEquals($previst, $org);
    }

    // Pegando o Get dessa vez com os parametros
    public function test_get_with_param()
    {
        $org = file_get_contents('http://localhost:8000/?type=duvida&deleted=0&order_by=DESC');
        $previst = '[{"id":"6","0":"6","type":"duvida","1":"duvida","message":"Phasellus sit amet erat.","2":"Phasellus sit amet erat.","is_identified":"0","3":"0","whistleblower_name":null,"4":null,"whistleblower_birth":null,"5":null,"created_at":"2020-08-31 20:53:33","6":"2020-08-31 20:53:33","deleted":"0","7":"0"}]';
        $this->assertEquals($previst, $org);
    }

    //Adicionado uma linha
    public function test_post()
    {
        $previst = 11; // Mude em caso de alteração no banco de dados
       
        $data = http_build_query(array(
            'type' => 'sugestao',
         'message' => 'Teste de ocorrencia POST'
        )); // O post basico, sem nome ou data de aniversário
    
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $data
            )
        );
        
        $context  = stream_context_create($opts);
        
        $result = file_get_contents($this->url, false, $context);

        $this->assertEquals($previst, $result);
    }

    //Atualizando por completo a linha
    public function test_put()
    {
        $previst = '"11"';
       
        $data = http_build_query(array(
            'type'  => 'sugestao',
         'message'  => 'Texto mudado via put',
            'user'  => 'Fulano',
            'birth' => '1988-03-19',
            'id'    =>  '11'
        ));
    
        $opts = array('http' =>
            array(
                'method'  => 'PUT',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $data
            )
        );
        
        $context  = stream_context_create($opts);
        
        $result = file_get_contents($this->url, false, $context);

        $this->assertEquals($previst, $result);
    }

    //Mudando o status da linha
    public function test_patch()
    {
        $previst = '"11"'; 
       
        $data = http_build_query(array(
            'id'    =>  '11'
        ));
    
        $opts = array('http' =>
            array(
                'method'  => 'PATCH',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $data
            )
        );
        
        $context  = stream_context_create($opts);
        
        $result = file_get_contents($this->url, false, $context);

        $this->assertEquals($previst, $result);
    }

    //Apagando a linha
    public function test_delete()
    {
        $previst = '"11"'; 
       
        $data = http_build_query(array(
            'id'    =>  '12'
        )); 
    
        $opts = array('http' =>
            array(
                'method'  => 'DELETE',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $data
            )
        );
        
        $context  = stream_context_create($opts);
        
        $result = file_get_contents($this->url, false, $context);

        $this->assertEquals($previst, $result);
    }

    //Test error
    public function test_get_error()
    {
        $org = get_content('http://localhost:8000/?type=duvida&id=11');
        $previst = '"Not found"';
        $this->assertEquals($previst, $org);
    }
    //Ao termina o banco de dados deve ter o mesmo dados podendo rodar o teste novamente
}

?>